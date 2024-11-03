<?php
include('dbLogin.php');
session_start(); // Start session to access UserID
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="appoint.css">
    <title>About Us</title>
</head>
<body>
    <h1>ABOUT OUR SYSTEM</h1>
    <ul>
    <li><a class="active" href="Homepage.php">Home</a></li>
    <li><a href="Records.php?UserID=<?php echo isset($_SESSION['UserID']) ? htmlspecialchars($_SESSION['UserID']) : ''; ?>">Health Records</a></li>
    <li><a href="Appointments.php">Appointments</a></li>
    <li><a href="Routine.php">Therapy</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="profile.php">Profile</a></li>
    <li class="split"><a href="login.php">Logout</a></li>
</ul>


    <br><br>
    <div class="info-container">
        <p>Our system is designed to track the mental health of children, whether they are in good condition or in critical condition. We conduct this test to understand the psychology of children.</p>
        <br>

        <h2>How to Know if You're Experiencing <b>Depression</b></h2>
        <p><b>What is Depression?</b></p>
        <p>Feeling sad is a normal human experience, but feeling too much sadness can cause distress and life problems. When too much sadness affects your life, you might have <b>depression</b>. <b>Depression</b> is a type of mental health condition called a mood disorder. Mood disorders primarily affect a person's emotional state. Episodes of depression last at least two weeks at a time, but they can last for months or even years.</p>
        <p><b>Symptoms of Depression:</b></p>
        <ol>
            <li>Feeling or appearing low, empty inside, or irritable most of the day every day.</li>
            <li>Losing interest in activities you would normally enjoy.</li>
            <li>Changes in sleep, either not being able to sleep or sleeping too much.</li>
            <li>Feeling exhausted even when you seem to be getting enough sleep.</li>
        </ol>

        <hr>
        <h2>How to Know if You're Experiencing <b>Anxiety</b></h2>
        <p><b>What is Anxiety?</b></p>
        <p><b>Anxiety</b> is an emotion that you feel when you're worried about something. Your body tenses up, and your mind becomes fixated on the thing you're worried about. It can be hard to concentrate on anything else. When <b>anxiety</b> gets so out of hand that it starts to interfere with your daily life, you might have an <b>anxiety disorder</b>.</p>
        <p><b>Symptoms of Anxiety:</b></p>
        <ol>
            <li>Feeling restless and irritable.</li>
            <li>Difficulty concentrating.</li>
            <li>Muscle pain, tightness, or soreness.</li>  
        </ol>

        <hr>
        <h2>How to Know if You're Experiencing <b>ADHD</b></h2>
        <p><b>What is ADHD?</b></p>
        <p><b>ADHD</b> or <b>Attention Deficit Hyperactivity Disorder</b> is a real and common mental health condition that can affect both children and adults.</p>
        <p><b>Symptoms of ADHD:</b></p>
        <ol>
            <li>Being unable to sit still, especially in calm or quiet surroundings.</li>
            <li>Constantly fidgeting.</li>
            <li>Being unable to concentrate on tasks.</li>  
            <li>Acting without thinking.</li>
        </ol>

        <hr>
        <h2>How to Know if You're Experiencing <b>Bipolar Disorder</b></h2>
        <p><b>What is Bipolar Disorder?</b></p>
        <p><b>Bipolar disorder</b> is a mental illness that causes unusual shifts in a person's mood, energy, activity levels, and concentration.</p>
        <p><b>Symptoms of Bipolar Disorder:</b></p>
        <ol>
            <li>Lacking energy.</li>
            <li>Feeling sad, hopeless, or irritable most of the time.</li>
            <li>Difficulty concentrating and remembering things.</li>  
            <li>Feelings of guilt and despair.</li>
        </ol>
    </div>
</body>
</html>
