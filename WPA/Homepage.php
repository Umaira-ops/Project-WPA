<?php
session_start(); // Start the session
if (isset($_SESSION['UserID'])) {
    // Store the UserID in a variable
    $userID = $_SESSION['UserID'];
} else {
    // Redirect to login page if session is not set
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="home.css">
<title> Dashboard </title>
<script>
// JavaScript to display the UserID as a popup
window.onload = function() {
    var userID = "<?php echo htmlspecialchars($userID); ?>";
    alert("Welcome! Your UserID is: " + userID);
};
</script>
</head>
<body>
<h1> DASHBOARD </h1>
<ul>
  <li><a class="active" href="Homepage.php">Home</a></li>
  <li><a href="Records.php?UserID=<?php echo htmlspecialchars($userID); ?>">Health Records</a></li>
  <li><a href="Appointments.php">Appointments</a></li>
  <li><a href="Routine.php">Therapy</a></li>
  <li><a href="about.php">About</a></li>
  <li><a href="profile.php">Profile</a></li>
  <li class="split"><a href="login.php">Logout</a></li>
</ul>

<img src="img5.jpg" alt="Project">
<img src="gif.GIF" alt="Project">

<div class= "container">
  <div class="info-container">
      <h2> <br>Child Health Care: A Guide for Parents </h2>
      <p> <b> Why Is Child Health Care Important? </b><br>
      Child health care is crucial because it lays the foundation for a child's overall 
      development and future well-being. Early health care interventions ensure that children
      receive necessary vaccinations, proper nutrition, and timely medical attention, which are 
      essential for preventing diseases and promoting healthy growth. Good health care during 
      childhood supports the development of strong immune systems, cognitive abilities, and 
      emotional well-being, enabling children to thrive in their educational and social environments.</p><br><br>
      
      <p> <b> What Are the Risks of Poor Child Health Care? </b><br>
      Poor child health care can have severe and long-lasting consequences on a child's 
      overall well-being and development. Children who do not receive adequate health care
      are at a higher risk of suffering from chronic illnesses, malnutrition, and developmental 
      delays. These health issues can lead to difficulties in learning and social interactions,
      making it harder for children to succeed in school and later in life. Additionally, poor 
      health care can result in higher rates of infant and child mortality, as well as increased 
      vulnerability to infectious diseases. <br> </p>
      <br>
      <p> We care about your well-being! Take a few minutes to complete our health survey and gain 
        insights into your emotional status. Your responses will help us provide better support and 
        resources tailored to your needs. Understanding your emotions is the first step towards a 
        healthier, happier you. <br>
        <h3>Click the link below to get started!</h3>
        <p style="text-align:center;"><a href="Form.php">Test Now</a></p>
  </div>
</div>

</body>
</html>
