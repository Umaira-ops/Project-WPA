<?php
include('dbLogin.php');
session_start();
if (!isset($_SESSION['AdminID'])) {
    header('Location: login.php');
    exit();
}

// Fetch users
$userQuery = "SELECT * FROM register";
$result = $conn->query($userQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="home.css">
    <title>Manage Users</title>
</head>
<body>
    <h1>Manage Users</h1>
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
            <th>User ID</th>
            <th>Register Date</th> <!-- Changed column header -->
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['UserID']); ?></td>
                <td><?php echo htmlspecialchars($row['registerDate']); ?></td> <!-- Changed to registerDate -->
                <td><?php echo htmlspecialchars($row['Email']); ?></td>
                <td>
    <a href="Edit_user.php?UserID=<?php echo $row['UserID']; ?>">Edit</a>
    <a href="Delete.php?UserID=<?php echo $row['UserID']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
</td>

            </tr>
        <?php } ?>
    </table>
</body>
</html>
