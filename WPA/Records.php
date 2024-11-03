<?php
// Include the database connection
include('dbLogin.php');

// Set the timezone to Malaysia
date_default_timezone_set('Asia/Kuala_Lumpur');

// Start the session
session_start();
if (!isset($_SESSION['UserID'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$UserID = $_SESSION['UserID']; // Get UserID from session

// Fetch all records for the user
$query = "SELECT sad, okay, happy, Score, created_at FROM health_records WHERE UserID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $UserID);
$stmt->execute();
$result = $stmt->get_result();
$needsAppointment = false; // Flag for appointment

// Function to get a random doctor from the database
function getRandomDoctor($conn) {
    $doctorQuery = "SELECT Name FROM doctors ORDER BY RAND() LIMIT 1"; // Random doctor query
    $doctorResult = $conn->query($doctorQuery);
    
    if ($doctorResult && $doctorResult->num_rows > 0) {
        $doctorRow = $doctorResult->fetch_assoc();
        return $doctorRow['Name']; // Return the doctor's name
    }
    return null; // Return null if no doctor is found
}

// Function to generate random appointment time until 6 PM
function getRandomTime() {
    $hour = rand(8, 18); // From 8 AM to 6 PM
    $minute = str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
    return sprintf('%02d:%s:00', $hour, $minute);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="home.css">
    <title>Records</title>
</head>
<body>

<h1>HEALTH RECORDS</h1>

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

<div class="records-container">
    <table>
        <tr>
            <th>SAD</th>
            <th>OKAY</th>
            <th>HAPPY</th>
            <th>SCORE / 24</th>
            <th>Date</th>
            <th>MENTAL STATUS</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalScore = $row["Score"];
                $createdAt = $row["created_at"];

                // Evaluate mental status
                if ($totalScore >= 21) {
                    $status = 'High';
                    $needsAppointment = true; // Set flag to true if conditions met
                } elseif ($totalScore >= 17) {
                    $status = 'Moderate';
                    $needsAppointment = true; // Set flag to true if conditions met
                } else {
                    $status = 'Normal';
                }

                // Convert created_at to Malaysia's timezone and format (only date)
                $formattedDate = date("d-m-Y", strtotime($createdAt)); // Only date format

                // Display the results in the table
                echo "<tr>
                        <td>" . htmlspecialchars($row["sad"]) . "</td>
                        <td>" . htmlspecialchars($row["okay"]) . "</td>
                        <td>" . htmlspecialchars($row["happy"]) . "</td>
                        <td>" . htmlspecialchars($totalScore) . "</td>
                        <td>" . htmlspecialchars($formattedDate) . "</td>
                        <td>" . htmlspecialchars($status) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No results found</td></tr>";
        }

        // Close the statement
        $stmt->close();
        ?>
    </table>
<br>
<?php 
if ($needsAppointment): 
    // Get a random doctor
    $doctorName = getRandomDoctor($conn); 

    if ($doctorName) {
        // Set the appointment date to the next day with a random time until 6 PM
        $nextDayAppointmentDate = date("Y-m-d", strtotime("+1 day")) . ' ' . getRandomTime();
?>
    <div style="text-align: center; margin-top: 20px;">
        <a href="booked.php?UserID=<?php echo urlencode($UserID); ?>&appointment_date=<?php echo urlencode($nextDayAppointmentDate); ?>&status=<?php echo urlencode('booked'); ?>&doctor_name=<?php echo urlencode($doctorName); ?>" style="padding: 10px 20px; background-color: blue; color: white; text-decoration: none; border-radius: 5px;">
            Book Appointment
        </a>
    </div>

<?php 
    } else {
        echo "<p style='color:red;'>No doctors available to book an appointment.</p>";
    }
endif; 
?>

    <br><br>
    <table class="small-table">
        <tr>
            <th>Mental Status</th>
            <th>Score Range</th>
        </tr>
        <tr>
            <td>Normal</td>
            <td><16</td>
        </tr>
        <tr>
            <td>Moderate</td>
            <td>17 - 20</td>
        </tr>
        <tr>
            <td>High Concern</td>
            <td>21 - 24</td>
        </tr>
    </table>
</div>
</body>
</html>
