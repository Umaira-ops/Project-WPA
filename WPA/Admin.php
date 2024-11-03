<?php
include('dbLogin.php');
session_start();
if (!isset($_SESSION['AdminID'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Fetch total users and doctors count
$userCountQuery = "SELECT COUNT(*) as total_users FROM register";
$doctorCountQuery = "SELECT COUNT(*) as total_doctors FROM doctors";
$totalUsers = $conn->query($userCountQuery)->fetch_assoc()['total_users'];
$totalDoctors = $conn->query($doctorCountQuery)->fetch_assoc()['total_doctors'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="home.css">
    <title>Admin</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <ul>
        <li><a href="Admin.php">Home</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_doctors.php">Manage Doctors</a></li>
        <li><a href="manage_appointments.php">Manage Appointments</a></li>
        <li class="split"><a href="login.php">Logout</a></li>
    </ul>
    <br><br>
    <table><tr>
    <th><h2>Total Patients: </h2></th>
    <th><h2>Total Doctors: </th>
</tr><tr>
    <td><?php echo $totalUsers; ?></td>
    <td><?php echo $totalDoctors; ?></td></tr>
</body>
</html>
