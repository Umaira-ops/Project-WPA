<?php
include('dbLogin.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['AdminID']) && !isset($_SESSION['DoctorID'])) {
    header('Location: login.php');
    exit();
}

// Fetch the appointment ID from the URL
$appointmentId = isset($_GET['AppointmentID']) ? $_GET['AppointmentID'] : null;

if ($appointmentId) {
    // Fetch the appointment details
    $query = "SELECT * FROM appointments WHERE AppointmentID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointmentId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if appointment exists
    if ($result->num_rows === 0) {
        echo "No appointment found.";
        exit();
    }

    $appointment = $result->fetch_assoc();
} else {
    echo "Invalid Appointment ID.";
    exit();
}

// Handle form submission for updating appointment
// Handle form submission for updating appointment
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated details from the form
    $updatedDate = $_POST['appointment_date'];
    $updatedStatus = $_POST['status'];

    // Update appointment in the database
    $updateQuery = "UPDATE appointments SET appointment_date = ?, status = ? WHERE AppointmentID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ssi", $updatedDate, $updatedStatus, $appointmentId);

    if ($updateStmt->execute()) {
        // Redirect back to docappoint.php after successful update
        header('Location: docappoint.php?success=1');
        exit();
    } else {
        echo "Error updating appointment: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit.css">
    <title>Edit Appointment</title>
</head>
<body>
    <h1>Edit Appointment</h1>
    <form method="POST" action="">
        <label>Appointment Date:</label>
        <input type="datetime-local" id="appointment_date" name="appointment_date" value="<?php echo htmlspecialchars($appointment['appointment_date']); ?>" required>
        
        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="booked" <?php echo $appointment['status'] == 'booked' ? 'selected' : ''; ?>>Booked</option>
            <option value="canceled" <?php echo $appointment['status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
            <option value="completed" <?php echo $appointment['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
        </select>
        <div class="button-container">
    <input type="button" value="Cancel" onclick="window.location.href='docappoint.php';"> <!-- Adjust href as needed -->
    <input type="submit" value="Update">
</div>

    </form>
    <br>
    
</body>
</html>
