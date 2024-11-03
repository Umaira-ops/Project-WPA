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

// Fetch the doctor's details
$doctor_stmt = $conn->prepare("SELECT * FROM doctors WHERE DoctorID = ?");
$doctor_stmt->bind_param("i", $doctorID);
$doctor_stmt->execute();
$doctor_result = $doctor_stmt->get_result();
$doctor = $doctor_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Handle profile updates
    $name = $_POST['name'];
    $email = $_POST['email'];

    $update_stmt = $conn->prepare("UPDATE doctors SET Name = ?, Email = ? WHERE DoctorID = ?");
    $update_stmt->bind_param("ssi", $name, $email, $doctorID);
    $update_stmt->execute();
    $update_stmt->close();

    // Refresh the doctor's details
    $doctor_stmt->execute();
    $doctor_result = $doctor_stmt->get_result();
    $doctor = $doctor_result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="doc.css">
    <title>Doctor Profile</title>
</head>
<body>
    <h1>Doctor Profile</h1>
    <ul>
        <li><a href="doctor.php">Home</a></li>
        <li><a href="docpatient.php">Patients Record</a></li>
        <li><a href="docappoint.php">Manage Appointments</a></li>
        <li><a href="docprofile.php">Profile</a></li>
        <li class="split"><a href="login.php">Logout</a></li>
    </ul>
    <br><br>
    <h2>Profile Information</h2>
    <form method="POST"><br>
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($doctor['Name']); ?>" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($doctor['Email']); ?>" required>
        <br><br>
        <input type="submit" value="Update Profile">
    </form>
    <form>
    <h3><b>YOUR CURRENT DETAILS</b></h3>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($doctor['Name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor['Email']); ?></p>
    </form>
</body>
</html>

<?php
// Close connections
$doctor_stmt->close();
$conn->close();
?>
