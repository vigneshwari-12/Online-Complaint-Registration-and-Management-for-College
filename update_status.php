<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: management_login.php");
    exit;
}

// Get the complaint ID and new status from the POST request
$complaintId = $_POST['id'];
$newStatus = $_POST['status'];

// Database connection parameters
$servername = "localhost";
$username_db = "root";
$password_db = "";
$database = "user_database";

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the status of the complaint in the database
$sql = "UPDATE complaint_details SET status_of_complaint = '$newStatus' WHERE query_id = '$complaintId'";

if ($conn->query($sql) === TRUE) {
    // If the status is updated successfully, return 'success'
    echo 'success';
} else {
    // If there's an error, return the error message
    echo "Error updating status: " . $conn->error;
}

// Close database connection
$conn->close();
?>
