<?php
  include('dbLogin.php');
  
  // Start session to access UserID
  session_start();
  
  // Check if the user is logged in
  if (!isset($_SESSION['UserID'])) {
      header("Location: login.php"); // Redirect to login if not logged in
      exit();
  }
  
  $UserID = $_SESSION['UserID']; // Get the UserID from the session
  
  // Fetch user data
  $query = "SELECT FName, Email, Gender FROM register WHERE UserID = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $UserID);
  $stmt->execute();
  $result = $stmt->get_result();
  
  // Check if data exists
  if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
  } else {
      echo "No user found.";
  }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="profile.css">
<title> Profile </title>
</head>
<body>

<h1> PROFILE </h1>

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
<div class="profile-container">
    <h2>User Profile</h2>
    
    <?php if (isset($user)): ?>
    <table>
        <tr>
            <th>User ID:</th>
            <td><?php echo htmlspecialchars($UserID); ?></td> 
        </tr>
        <tr>
            <th>Name:</th>
            <td><?php echo htmlspecialchars($user['FName']); ?></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><?php echo htmlspecialchars($user['Email']); ?></td>
        </tr>
        <tr>
            <th>Gender:</th>
            <td><?php echo htmlspecialchars($user['Gender']); ?></td>
        </tr>
    </table>
    <?php else: ?>
    <p>No user information found.</p>
    <?php endif; ?>
</div>

</body>
</html>
