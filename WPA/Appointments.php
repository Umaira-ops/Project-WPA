<?php
include('dbLogin.php');

// Set the timezone to Malaysia
date_default_timezone_set('Asia/Kuala_Lumpur');

// Start the session
session_start();
if (!isset($_SESSION['UserID'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$UserID = $_SESSION['UserID']; // Get UserID from session

// Check if appointment data is passed in the URL
if (isset($_GET['status']) && isset($_GET['doctor_name'])) {
    // Sanitize and validate input
    $appointmentStatus = $_GET['status'];
    $doctorName = $_GET['doctor_name']; // Get the doctor name from the URL

    // Generate a random appointment time for tomorrow
    $appointmentDate = date('Y-m-d H:i:s', strtotime('+1 day ' . mt_rand(0, 17) . ':' . mt_rand(0, 59) . ':00')); // Random time until 6 PM tomorrow

    // Insert the appointment into the database
    $insertAppointmentQuery = "INSERT INTO appointments (UserID, appointment_date, status, DoctorName) VALUES (?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertAppointmentQuery);
    if ($insertStmt) {
        $insertStmt->bind_param("isss", $UserID, $appointmentDate, $appointmentStatus, $doctorName);
        if (!$insertStmt->execute()) {
            $_SESSION['error'] = "Error creating appointment: " . $insertStmt->error;
        }
        $insertStmt->close();
    } else {
        echo "Error preparing the insert statement: " . $conn->error;
    }

    // Redirect to the Appointments page to show updated appointment list
    header('Location: Appointments.php');
    exit();
}

// Fetch and display appointments for the user
$query = "SELECT appointment_date, status, DoctorName FROM appointments WHERE UserID = ?";
$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param("i", $UserID);
    $stmt->execute();
    $fetchResult = $stmt->get_result(); // Get the result set
}

// Display error messages only
if (isset($_SESSION['error'])) {
    echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="appoint.css">
    <title>Your Appointments</title>
</head>
<body>
<h1>YOUR APPOINTMENTS</h1>
<ul>
  <li><a class="active" href="Homepage.php">Home</a></li>
  <li><a href="Records.php?UserID=<?php echo htmlspecialchars($UserID); ?>">Health Records</a></li>
  <li><a href="Appointments.php">Appointments</a></li>
  <li><a href="Routine.php">Therapy</a></li>
  <li><a href="about.php">About</a></li>
  <li><a href="profile.php">Profile</a></li>
  <li class="split"><a href="login.php">Logout</a></li>
</ul>

<br><br>
<table>
    <tr>
        <th>Appointment Date</th>
        <th>Status</th>
        <th>Doctor Name</th>
    </tr>
    <?php
    if ($fetchResult->num_rows > 0) {
        while ($row = $fetchResult->fetch_assoc()) {
            // Convert appointment_date to a formatted date with AM/PM
            $formattedDate = date("d-m-Y h:i A", strtotime($row["appointment_date"])); // Adjusted line
            echo "<tr>
                    <td>" . htmlspecialchars($formattedDate) . "</td>
                    <td>" . htmlspecialchars($row["status"]) . "</td>
                    <td>" . htmlspecialchars($row["DoctorName"]) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No appointments found</td></tr>";
    }
    // Close the statement and connection if they were successfully initialized
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
    ?>
</table>

</body>
</html>
