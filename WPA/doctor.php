<?php
session_start();
include('dbLogin.php');

// Check if the doctor is logged in
if (!isset($_SESSION['DoctorID'])) {
    header("Location: login.php");
    exit();
}

// Get the doctor's ID from the session
$doctorID = $_SESSION['DoctorID'];

// Fetch the doctor's name from the doctors table
$doctorName_stmt = $conn->prepare("SELECT Name FROM doctors WHERE DoctorID = ?");
$doctorName_stmt->bind_param("i", $doctorID);
$doctorName_stmt->execute();
$doctorName_result = $doctorName_stmt->get_result();

// Check if the doctor exists and fetch the name
if ($doctorName_result->num_rows > 0) {
    $doctorName_row = $doctorName_result->fetch_assoc();
    $doctorName = $doctorName_row['Name']; // Get the doctor's name
} else {
    $doctorName = "Doctor"; // Default name in case of error
}

// Fetch upcoming appointments
$appointments_stmt = $conn->prepare("SELECT * FROM appointments WHERE DoctorName = ? AND appointment_date >= NOW() ORDER BY appointment_date ASC");
$appointments_stmt->bind_param("s", $doctorName);
$appointments_stmt->execute();
$appointments_result = $appointments_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="home.css">
    <title>Doctor Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($doctorName); ?>!</h1>

    <ul>
        <li><a href="doctor.php">Home</a></li>
        <li><a href="docpatient.php">Patients Record</a></li>
        <li><a href="docappoint.php">Manage Appointments</a></li>
        <li><a href="docprofile.php">Profile</a></li>
        <li class="split"><a href="login.php">Logout</a></li>
    </ul>
    <br><br>
    <h2>Your Upcoming Appointments</h2>
    <table border='1'>
        <tr>
            <th>Appointment ID</th>
            <th>User ID</th>
            <th>Appointment Date</th>
            <th>Status</th>
    
        </tr>
        <?php while ($appointment = $appointments_result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $appointment['AppointmentID']; ?></td>
            <td><?php echo $appointment['UserID']; ?></td>
            <td><?php echo $appointment['appointment_date']; ?></td>
            <td><?php echo $appointment['status']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>

<?php
// Close connections
$doctorName_stmt->close();
$appointments_stmt->close();
$conn->close();
?>
