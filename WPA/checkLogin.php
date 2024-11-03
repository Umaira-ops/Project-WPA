<?php
include ('dbLogin.php'); 
$Email = $_POST ['Email'];
$Password = $_POST ['Password'];

$sql = "SELECT * FROM login WHERE Email = '$Email' and Password = '$Password'";
$result = $conn -> query($sql);

if ($result->num_rows == 1) 
    {
        header("Location: Dashboard.php");
    } 
    else 
    {
        echo "Wrong username and password";
    }
$conn -> close();
?>