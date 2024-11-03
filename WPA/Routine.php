<?php
include('dbLogin.php');
session_start(); // Start the session to access session variables

// Make sure UserID is available
if (!isset($_SESSION['UserID'])) {
    // Redirect to login page if UserID is not set
    header('Location: login.php');
    exit();
}

$UserID = $_SESSION['UserID']; // Get the UserID from the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feelings Reflection Game</title>
    <link rel="stylesheet" href="routine.css">
</head>
<body>

<h1>Feelings Reflectio</h1>
<ul>
  <li><a class="active" href="Homepage.php">Home</a></li>
  <li><a href="Records.php?UserID=<?php echo htmlspecialchars($UserID); ?>">Health Records</a></li>
  <li><a href="Appointments.php">Appointments</a></li>  
  <li><a href="Routine.php">Therapy</a></li>
  <li><a href="about.php">About</a></li>
  <li><a href="profile.php">Profile</a></li>
  <li class="split"><a href="login.php">Logout</a></li>
</ul>
<br><br>
 <div class="container">
        
        <p>Select an emotion to explore:</p>
        <div class="button-container">
            <button class="emotion-btn" id="happyBtn">Happy</button>
            <button class="emotion-btn" id="sadBtn">Sad</button>
            <button class="emotion-btn" id="angryBtn">Angry</button>
            <button class="emotion-btn" id="excitedBtn">Excited</button>
            <button class="emotion-btn" id="nervousBtn">Nervous</button>
        </div>
        <div id="prompt"></div>
        <textarea id="response" placeholder="Write your thoughts here..." rows="4"></textarea>
        <button id="submitResponse">Submit Response</button>
        <div id="feedback"></div>
        <button id="resetBtn">Reset</button>
    </div>
    <script src="routine.js"></script>
</body>
</html>