<?php
include('dbLogin.php');
session_start();
if (!isset($_SESSION['AdminID'])) {
    header('Location: login.php');
    exit();
}

// Fetch doctors
$doctorQuery = "SELECT * FROM doctors";
$result = $conn->query($doctorQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="home.css">
    <title>Manage Doctors</title>
</head>
<body>
    <h1>Manage Doctors</h1>
    <ul>
        <li><a href="Admin.php">Home</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_doctors.php">Manage Doctors</a></li>
        <li><a href="manage_appointments.php">Manage Appointments</a></li>
        <li class="split"><a href="login.php">Logout</a></li>
    </ul>
    <br><br>
    <table>
        <tr>
            <th>Doctor ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['DoctorID']); ?></td>
                <td><?php echo htmlspecialchars($row['Name']); ?></td>
                <td><?php echo htmlspecialchars($row['Email']); ?></td>
                <td>
                    <a href="edit_doctor.php?DoctorID=<?php echo $row['DoctorID']; ?>">Edit</a>
                    <a href="delete_doctor.php?DoctorID=<?php echo $row['DoctorID']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
