<?php
include('dbLogin.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['AdminID']) && !isset($_SESSION['DoctorID'])) {
    header('Location: login.php');
    exit();
}

// Determine if user is Admin or Doctor
$isAdmin = isset($_SESSION['AdminID']);
$doctorID = isset($_SESSION['DoctorID']) ? $_SESSION['DoctorID'] : null;

// Fetch appointments
if ($isAdmin) {
    $query = "SELECT a.*, r.FName AS UserFName, r.LName AS UserLName 
              FROM appointments a
              JOIN register r ON a.UserID = r.UserID";
} else {
    // For doctor-specific appointments
    $query = "SELECT a.*, r.FName AS UserFName, r.LName AS UserLName 
              FROM appointments a
              JOIN register r ON a.UserID = r.UserID
              WHERE a.DoctorName = (SELECT Name FROM doctors WHERE DoctorID = $doctorID)";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="home.css">
    <title>Manage Appointments</title>
</head>
<body>
    <h1>Manage Appointments</h1>
    <ul>
        <li><a href="Admin.php">Home</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_doctors.php">Manage Doctors</a></li>
        <li><a href="manage_appointments.php">Manage Appointments</a></li>
        <li class="split"><a href="login.php">Logout</a></li>
    </ul>
    <br><br>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">Appointment updated successfully!</p>
    <?php endif; ?>

    <table>
        <tr>
            <th>Appointment ID</th>
            <th>User Name</th>
            <th>Doctor Name</th>
            <th>Appointment Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['AppointmentID']); ?></td>
                <td><?php echo htmlspecialchars($row['UserFName']); ?></td>
                <td><?php echo htmlspecialchars($row['DoctorName']); ?></td>
                <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                <a href="adminedit.php?AppointmentID=<?php echo $row['AppointmentID']; ?>">Edit</a>
                <a href="delete_appointment.php?AppointmentID=<?php echo $row['AppointmentID']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
