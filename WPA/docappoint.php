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
    $result = $conn->query($query);
} else {
    // For doctor-specific appointments using prepared statements
    $query = "SELECT a.*, r.FName AS UserFName, r.LName AS UserLName 
              FROM appointments a
              JOIN register r ON a.UserID = r.UserID
              WHERE a.DoctorName = (SELECT Name FROM doctors WHERE DoctorID = ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $doctorID);
    $stmt->execute();
    $result = $stmt->get_result();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="home.css">
    <title>Manage Appointments</title>
</head>
<body>
    <h1>Manage Appointments</h1>
    <ul>
        <li><a href="doctor.php">Home</a></li>
        <li><a href="docpatient.php">Patients Record</a></li>
        <li><a href="docappoint.php">Manage Appointments</a></li>
        <li><a href="docprofile.php">Profile</a></li>
        <li class="split"><a href="login.php">Logout</a></li>
    </ul>
    <br><br>
    
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">Appointment updated successfully!</p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>User ID</th>
                <th>User Name</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['AppointmentID']); ?></td>
                    <td><?php echo htmlspecialchars($row['UserID']); ?></td>
                    <td><?php echo htmlspecialchars($row['UserFName']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <a href="docedit.php?AppointmentID=<?php echo $row['AppointmentID']; ?>">Edit</a>
                        <a href="delete_appointment.php?AppointmentID=<?php echo $row['AppointmentID']; ?>" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php 
    // Close the statement if it's set
    if (isset($stmt)) {
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
