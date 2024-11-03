<?php
include('dbLogin.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['AdminID'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Check if UserID is provided
if (!isset($_GET['UserID'])) {
    header('Location: manage_users.php'); // Redirect if no UserID is specified
    exit();
}

$userID = $_GET['UserID'];

// Fetch the user data
$query = "SELECT * FROM register WHERE UserID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "User not found.";
    exit();
}

$userData = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new user data from the form
    $firstName = $_POST['FName'];
    $lastName = $_POST['LName'];
    $email = $_POST['Email'];
    $password = $_POST['Password']; // Ensure to hash passwords in a real application

    // Update the user data
    $updateQuery = "UPDATE register SET FName = ?, LName = ?, Email = ?, Password = ? WHERE UserID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ssssi", $firstName, $lastName,  $email, $password, $userID);

    if ($updateStmt->execute()) {
        header('Location: manage_users.php'); // Redirect back to manage users
        exit();
    } else {
        echo "Error updating user: " . $updateStmt->error;
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
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="POST">
        <label>First Name:</label>
        <input type="text" name="FName" value="<?php echo htmlspecialchars($userData['FName']); ?>" required><br>

        <label>Last Name:</label>
        <input type="text" name="LName" value="<?php echo htmlspecialchars($userData['LName']); ?>" required><br>

        <label>Email:</label>
        <input type="email" name="Email" value="<?php echo htmlspecialchars($userData['Email']); ?>" required><br>

        <label for="Password">Password:</label>
        <input type="password" name="Password" placeholder="Leave blank to keep current password"><br>

        <div class="button-container">
    <input type="button" value="Cancel" onclick="window.location.href='manage_users.php';"> <!-- Adjust href as needed -->
    <input type="submit" value="Update">
</div>
</body>
</html>
