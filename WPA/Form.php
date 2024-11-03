<?php
session_start(); // Start the session at the beginning
include('dbLogin.php'); // Ensure you have this file to connect to your database

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Make sure UserID is set
    if (!isset($_SESSION['UserID'])) {
        header('Location: login.php'); // Redirect to login if not logged in
        exit();
    }

    $userId = $_SESSION['UserID']; // Get UserID from session

    // Initialize counts
    $sad = 0;
    $okay = 0;
    $happy = 0;

    // Tally responses for all questions
    for ($i = 1; $i <= 8; $i++) {
        if (isset($_POST["question$i"])) {
            switch ($_POST["question$i"]) {
                case 1:
                    $sad++;
                    break;
                case 2:
                    $okay++;
                    break;
                case 3:
                    $happy++;
                    break;
            }
        }
    }

    // Calculate score based on the counts
    $Score = ($sad * 1) + ($okay * 2) + ($happy * 3);

    // Prepare the SQL statement
    $createdAt = date('Y-m-d'); // Use only the current date in 'Y-m-d' format

    // Insert into the database
    $query = "INSERT INTO `health_records` (`UserID`, `sad`, `okay`, `happy`, `Score`, `created_at`) 
              VALUES ('$userId', '$sad', '$okay', '$happy', '$Score', '$createdAt')";

    // Execute the query and handle the result
    if (mysqli_query($conn, $query)) {
        // Success alert and redirect
        echo "<script type='text/javascript'>alert('Record saved successfully.'); window.location.href = 'Records.php?UserID=$userId';</script>";
    } else {
        // Improved error handling for insert/update
        die('Insert/Update failed: ' . mysqli_error($conn));
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="f1.css">
    <title>Question</title>
    <script>
        function selectOption(element, questionId) {
            // Get all image options for the specific question
            const images = document.querySelectorAll(`div.image-options img[data-question='${questionId}']`);

            // Deselect all other options
            images.forEach(img => {
                img.classList.remove('selected');
            });

            // Select the clicked option
            element.classList.add('selected');

            // Update the hidden input with the selected value
            const value = element.getAttribute('data-value');
            console.log(`Setting value for ${questionId}: ${value}`); // Debugging line
            document.getElementById(questionId).value = value;
        }

        function validateForm() {
            let allAnswered = true; // Assume all questions are answered initially

            for (let i = 1; i <= 8; i++) {
                const value = document.getElementById(`question${i}`).value;
                if (value === "") {
                    allAnswered = false; // Found an unanswered question
                    break; // No need to check further
                }
            }

            if (!allAnswered) {
                alert("Please answer all questions."); // Single alert for all unanswered questions
                return false; // Prevent form submission
            }

            return true; // Allow form submission if all questions are answered
        }
    </script>
</head>
<body>
    <form id="surveyForm" method="post" action="Form.php" onsubmit="return validateForm();">
        <input type="hidden" name="UserID" value="<?php echo htmlspecialchars($userId); ?>"> 
        <h1>QUESTION</h1>

        <label>1. How are you feeling today?</label><br>
        <div class="image-options">
            <img src="sad.gif" alt="Sad" data-value="1" data-question="question1" onclick="selectOption(this, 'question1')">
            <img src="okay.jpg" alt="Okay" data-value="2" data-question="question1" onclick="selectOption(this, 'question1')">
            <img src="happy.jpg" alt="Happy" data-value="3" data-question="question1" onclick="selectOption(this, 'question1')">
        </div>
        <input type="hidden" id="question1" name="question1" value="">

        <label>2. How do you feel when you think about things that bother you?</label><br>
        <div class="image-options">
            <img src="sad.gif" alt="Sad" data-value="1" data-question="question2" onclick="selectOption(this, 'question2')">
            <img src="okay.jpg" alt="Okay" data-value="2" data-question="question2" onclick="selectOption(this, 'question2')">
            <img src="happy.jpg" alt="Happy" data-value="3" data-question="question2" onclick="selectOption(this, 'question2')">
        </div>
        <input type="hidden" id="question2" name="question2" value="">

        <label>3. How do you feel when you think about fun things?</label><br>
        <div class="image-options">
            <img src="sad.gif" alt="Sad" data-value="1" data-question="question3" onclick="selectOption(this, 'question3')">
            <img src="okay.jpg" alt="Okay" data-value="2" data-question="question3" onclick="selectOption(this, 'question3')">
            <img src="happy.jpg" alt="Happy" data-value="3" data-question="question3" onclick="selectOption(this, 'question3')">
        </div>
        <input type="hidden" id="question3" name="question3" value="">

        <label>4. How do you feel after you sleep?</label><br>
        <div class="image-options">
            <img src="sad.gif" alt="Sad" data-value="1" data-question="question4" onclick="selectOption(this, 'question4')">
            <img src="okay.jpg" alt="Okay" data-value="2" data-question="question4" onclick="selectOption(this, 'question4')">
            <img src="happy.jpg" alt="Happy" data-value="3" data-question="question4" onclick="selectOption(this, 'question4')">
        </div>
        <input type="hidden" id="question4" name="question4" value="">

        <label>5. How do you feel when you think about school or home?</label><br>
        <div class="image-options">
            <img src="sad.gif" alt="Sad" data-value="1" data-question="question5" onclick="selectOption(this, 'question5')">
            <img src="okay.jpg" alt="Okay" data-value="2" data-question="question5" onclick="selectOption(this, 'question5')">
            <img src="happy.jpg" alt="Happy" data-value="3" data-question="question5" onclick="selectOption(this, 'question5')">
        </div>
        <input type="hidden" id="question5" name="question5" value="">

        <label>6. How do you feel when you talk to someone about your feelings?</label><br>
        <div class="image-options">
            <img src="sad.gif" alt="Sad" data-value="1" data-question="question6" onclick="selectOption(this, 'question6')">
            <img src="okay.jpg" alt="Okay" data-value="2" data-question="question6" onclick="selectOption(this, 'question6')">
            <img src="happy.jpg" alt="Happy" data-value="3" data-question="question6" onclick="selectOption(this, 'question6')">
        </div>
        <input type="hidden" id="question6" name="question6" value="">

        <label>7. How do you feel about playing or doing fun things?</label><br>
        <div class="image-options">
            <img src="sad.gif" alt="Sad" data-value="1" data-question="question7" onclick="selectOption(this, 'question7')">
            <img src="okay.jpg" alt="Okay" data-value="2" data-question="question7" onclick="selectOption(this, 'question7')">
            <img src="happy.jpg" alt="Happy" data-value="3" data-question="question7" onclick="selectOption(this, 'question7')">
        </div>
        <input type="hidden" id="question7" name="question7" value="">

        <label>8. How do you feel when you have lots of energy or can't sit still?</label><br>
        <div class="image-options">
            <img src="sad.gif" alt="Sad" data-value="1" data-question="question8" onclick="selectOption(this, 'question8')">
            <img src="okay.jpg" alt="Okay" data-value="2" data-question="question8" onclick="selectOption(this, 'question8')">
            <img src="happy.jpg" alt="Happy" data-value="3" data-question="question8" onclick="selectOption(this, 'question8')">
        </div>
        <input type="hidden" id="question8" name="question8" value="">

        <button type="submit">Submit</button>
    </form>
</body>
</html>
