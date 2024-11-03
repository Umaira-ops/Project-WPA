<?php
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

// Check if appointment data is passed in the URL
if (isset($_GET['status']) && isset($_GET['appointment_date']) && isset($_GET['doctor_name'])) {
    // Sanitize and validate input
    $appointmentStatus = $_GET['status']; // This should be "booked"
    $appointmentDate = $_GET['appointment_date']; // Get the appointment date from the URL
    $doctorName = $_GET['doctor_name']; // Get the doctor name from the URL

    // Insert the appointment into the database
    $insertAppointmentQuery = "INSERT INTO appointments (UserID, appointment_date, status, DoctorName) VALUES (?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertAppointmentQuery);
    
    if ($insertStmt) {
        $insertStmt->bind_param("isss", $UserID, $appointmentDate, $appointmentStatus, $doctorName);
        if ($insertStmt->execute()) {
            // Redirect to the Appointments page after success
            header('Location: Appointments.php?UserID=' . urlencode($UserID));
            exit();
        } else {
            $_SESSION['error'] = "Error creating appointment: " . $insertStmt->error;
        }
    } else {
        echo "Error preparing the insert statement: " . $conn->error;
    }
} else {
    // Redirect back to appointments if parameters are missing
    $_SESSION['error'] = "Required appointment data is missing.";
    header('Location: Appointments.php?UserID=' . urlencode($UserID));
    exit();
}
?>
