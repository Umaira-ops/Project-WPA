<?php
include('dbLogin.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['AdminID'])) {
    header('Location: login.php');
    exit();
}

// Check if DoctorID is provided
if (!isset($_GET['DoctorID'])) {
    header('Location: manage_doctors.php'); // Redirect if no DoctorID is specified
    exit();
}

$doctorID = $_GET['DoctorID'];

// Fetch the doctor data
$query = "SELECT * FROM doctors WHERE DoctorID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $doctorID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Doctor not found.";
    exit();
}

$doctorData = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new doctor data from the form
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $password = $_POST['Password']; // New password

    // If password is provided, hash it before updating
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        // Update with password
        $updateQuery = "UPDATE doctors SET Name = ?, Email = ?, Password = ? WHERE DoctorID = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ssii", $name, $email, $hashedPassword, $doctorID);
    } else {
        // If no new password, just update name and email
        $updateQuery = "UPDATE doctors SET Name = ?, Email = ? WHERE DoctorID = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ssi", $name, $email, $doctorID);
    }

    if ($updateStmt->execute()) {
        header('Location: manage_doctors.php'); // Redirect back to manage doctors
        exit();
    } else {
        echo "Error updating doctor: " . $updateStmt->error;
    }
    $updateStmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="edit.css">
    <title>Edit Doctor</title>
</head>
<body>
    <h1>Edit Doctor</h1>
    <form method="POST">
        <label for="Name">Name:</label>
        <input type="text" name="Name" value="<?php echo htmlspecialchars($doctorData['Name']); ?>" required><br>

        <label for="Email">Email:</label>
        <input type="email" name="Email" value="<?php echo htmlspecialchars($doctorData['Email']); ?>" required><br>
        <label for="Password">Password:</label>
        <input type="password" name="Password" placeholder="Leave blank to keep current password"><br>

        <div class="button-container">
            <input type="button" value="Cancel" onclick="window.location.href='manage_doctors.php';">
            <input type="submit" value="Update">
        </div>
    </form>
</body>
</html>
