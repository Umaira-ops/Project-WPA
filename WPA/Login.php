<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="log.css">
    <title>Login</title>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const showPasswordCheckbox = document.getElementById("show-password");

            // Toggle the input type
            if (showPasswordCheckbox.checked) {
                passwordInput.type = "text"; // Show password
            } else {
                passwordInput.type = "password"; // Hide password
            }
        }
    </script>
</head>

<body>

<img src="img1.png" alt="Project" class="center-image">

<h1> Lil'S Sunshine </h1>

<p> Hi peeps! Welcome to <b>Child Health Care</b>! <br><br>
    Great to see you here! Hope your days become better and don't give up yet.
</p>

<div class="login-container">
    <h2>LOGIN</h2>
    <form method="POST">
        <label>Email</label>
        <input type="email" name="Email" required>
        <br>
        <label>Password</label>
        <input type="password" name="Password" id="password" required>
        <br>
        <input type="checkbox" id="show-password" onclick="togglePassword()">
        <label for="show-password">Show Password</label>
        <br><br>
        <input type="submit" value="LOGIN">
    </form>
    <br>
    <p>New User? Sign Up here<br><br><a href="index.php">Sign Up</a></p>
</div>
</body>
</html>

<?php
// Start the session
session_start();

// Include the database connection
include('dbLogin.php'); 

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve form data
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    // Basic validation
    if (!empty($Email) && !empty($Password) && !is_numeric($Email)) {

        // First, check if the user is an admin by checking the admin table
        $admin_stmt = $conn->prepare("SELECT AdminID, Email, Password FROM admins WHERE Email = ?");
        $admin_stmt->bind_param("s", $Email);
        $admin_stmt->execute();
        $admin_result = $admin_stmt->get_result();

        // If admin exists
        if ($admin_result->num_rows == 1) {
            // Fetch the admin data
            $admin = $admin_result->fetch_assoc();

            // Verify password
            if ($admin['Password'] === $Password) {
                // Store the AdminID in the session
                $_SESSION['AdminID'] = $admin['AdminID'];
                $_SESSION['Email'] = $admin['Email'];

                // Redirect to admin dashboard
                header("Location: Admin.php");
                exit();
            } else {
                echo "<script type='text/javascript'>alert('Wrong admin username or password');</script>";
            }

        } else {
            // If not admin, check the regular users in the register table
            $user_stmt = $conn->prepare("SELECT UserID, Email, Password FROM register WHERE Email = ?");
            $user_stmt->bind_param("s", $Email);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();

            // Check if user exists
            if ($user_result->num_rows == 1) {
                // Fetch the user data
                $user = $user_result->fetch_assoc();

                // Verify password
                if ($user['Password'] === $Password) {
                    // Store the UserID in the session
                    $_SESSION['UserID'] = $user['UserID'];
                    $_SESSION['Email'] = $user['Email'];

                    // Redirect regular user to homepage
                    header("Location: Homepage.php");
                    exit();
                } else {
                    echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
                }
            } else {
                // Check if the user is a doctor
                $doctor_stmt = $conn->prepare("SELECT DoctorID, Email, Password FROM doctors WHERE Email = ?");
                $doctor_stmt->bind_param("s", $Email);
                $doctor_stmt->execute();
                $doctor_result = $doctor_stmt->get_result();

                // Check if doctor exists
                if ($doctor_result->num_rows == 1) {
                    // Fetch the doctor data
                    $doctor = $doctor_result->fetch_assoc();

                    // Verify password
                    if ($doctor['Password'] === $Password) {
                        // Store the DoctorID in the session
                        $_SESSION['DoctorID'] = $doctor['DoctorID'];
                        $_SESSION['Email'] = $doctor['Email'];

                        // Redirect doctor to their dashboard
                        header("Location: doctor.php"); // Adjust this to your actual doctor dashboard
                        exit();
                    } else {
                        echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('Wrong username or password');</script>";
                }
            }
        }

        // Close the prepared statements
        $admin_stmt->close();
        $user_stmt->close();
        $doctor_stmt->close();
    } else {
        echo "<script type='text/javascript'>alert('Please enter valid credentials');</script>";
    }
}

// Close the connection
$conn->close();
?>
