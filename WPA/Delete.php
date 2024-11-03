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

// Delete the user from the database
$deleteQuery = "DELETE FROM register WHERE UserID = ?";
$stmt = $conn->prepare($deleteQuery);
$stmt->bind_param("i", $userID);

if ($stmt->execute()) {
    // User deleted successfully
    header('Location: manage_users.php'); // Redirect back to manage users
    exit();
} else {
    echo "Error deleting user: " . $stmt->error;
}

$stmt->close();
?>
