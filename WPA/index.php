<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="signup.css">
<title> Signup </title>
</head>

<body>

<img src="img1.png" alt="Project" class="center-image">

<h1> Lil'S Sunshine </h1>

<p> Hi, Welcome to <b>Child Health Care</b>! <br><br>
    We hope this website can make it easier for you to track your child health data.<br><br>
    Sign up now!
</p>
<div class="login-container">
    <h2>SIGN UP</h2>
    <form method="POST">
        <label> First Name </label>
        <input type="text" name="FName" required>
        <br>
        <label> Last Name </label>
        <input type="text" name="LName" required>
        <br>
        <label> Gender </label>
        <select name="Gender" class="select-box" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <br>
        <label>Email</label>
        <input type="email" name="Email" required>
        <br>
        <label>Password</label>
        <input type="password" name="Password" required>
        <br>
        <label>Birth Date</label> <!-- New Birth Date field -->
        <input type="date" name="BirthDate" required>
        <br>
        <label>Register Date</label>
        <input type="date" id="registerDate" name="registerDate" required>
        <br>
        <br>
        <input type="submit" value="SIGN UP">
    </form>
    <br>
    <br>
    <p>Already have an account? Login here<br><br><a href="Login.php">Login</a></p>
</div>

<script>
    // JavaScript to set the current date
    document.addEventListener('DOMContentLoaded', (event) => 
    {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('registerDate').value = today;
    });
</script>

</body>
</html>
<?php
include ('dbLogin.php'); 
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $Firstname = $_POST['FName'];
    $Lastname = $_POST['LName'];
    $Gender = $_POST['Gender'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $RegisterDate = $_POST['registerDate'];
    $BirthDate = $_POST['BirthDate']; // Capture Birth Date

    if (!empty($Email) && !empty($Password) && !is_numeric($Email)) 
    {
        $query = "INSERT INTO `register` (`FName`, `LName`, `Gender`, `Email`, `Password`, `registerDate`, `BirthDate`) VALUES ('$Firstname', '$Lastname', '$Gender', '$Email', '$Password', '$RegisterDate', '$BirthDate')";
        if (mysqli_query($conn, $query)) {
            echo "<script type='text/javascript'> alert('Signup is Successful')</script>";
            header("Location: Login.php");
            exit();
        } 
        else 
        {
            echo "<script type='text/javascript'> alert('Error: " . mysqli_error($conn) . "')</script>";
        }
    } 
    else 
    {
        echo "<script type='text/javascript'> alert('Signup is Unsuccessful. Please Enter Valid Information!')</script>";
    }
}
?>
