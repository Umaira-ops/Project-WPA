<?php
session_start();
include('dbLogin.php');

// Check if the doctor is logged in
if (!isset($_SESSION['DoctorID'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $userId = $_POST['userId'];
    // Fetch health records by user ID
    $health_records_stmt = $conn->prepare("SELECT * FROM health_records WHERE UserID = ?");
    $health_records_stmt->bind_param("i", $userId);
    $health_records_stmt->execute();
    $health_records_result = $health_records_stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="doc.css">
    <title>Patient Health Records</title>
</head>
<body>
    <h1>Patient Health Records</h1>
    
    <ul>
        <li><a href="doctor.php">Home</a></li>
        <li><a href="docpatient.php">Patients Record</a></li>
        <li><a href="docappoint.php">Manage Appointments</a></li>
        <li><a href="docprofile.php">Profile</a></li>
        <li class="split"><a href="login.php">Logout</a></li>
    </ul>
    <br><br>
    <form method="POST">
        <label for="userId">User ID:</label>
        <input type="number" name="userId" required>
        <input type="submit" value="Records">
    </form>

    <?php if (isset($health_records_result)): ?>
        <br>
        <h2>Health Records</h2>
        <?php if ($health_records_result->num_rows > 0): ?>
            <table border='1'>
                <tr>
                    <th>Record ID</th>
                    <th>User ID</th>
                    <th>Score</th>
                    <th>Created At</th>
                </tr>
                <?php while ($record = $health_records_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($record['RecordID']); ?></td>
                    <td><?php echo htmlspecialchars($record['UserID']); ?></td>
                    <td><?php echo htmlspecialchars($record['Score']); ?></td>
                    <td><?php echo date("d F Y", strtotime($record['created_at'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No records found for this User ID.</p>
        <?php endif; ?>
    <?php endif; ?>

</body>
</html>

<?php
// Close connections
$conn->close();
?>
