<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login_page.php");
    exit;
}

// Get username from session
$username = $_SESSION['username'];

// Database connection
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

// Query to retrieve complaints for the current user
$sql = "SELECT * FROM complaint_details WHERE Student_id = '$username'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            background-image:url("complaint_status.png");
            background-size: 100% auto;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
        }

        strong {
            color: #333;
        }
        .main-page-link {
            position: absolute;
            left: 20px;
            top: 20px;
            color: black;
            text-decoration: none;
            font-size:20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<a href="status_complaint.php" class="status-complaint-link">Status of Complaints</a>
<div class="container">
    <h2>Complaint Details</h2>
    <?php
    // Check if complaint ID, status, and details are provided in the URL
    if (isset($_GET['id']) && isset($_GET['status']) && isset($_GET['details'])) {
        // Output the complaint details
        echo "<p><strong>Complaint ID:</strong> " . $_GET['id'] . "</p>";
        echo "<p><strong>Status:</strong> " . $_GET['status'] . "</p>";
        echo "<p><br><strong>Date and time of raised query:</strong> " . $_GET['dateandtime'] . "</p>";
        echo "<p><strong>Details:</strong> " . $_GET['details'] . "</p>";
    } else {
        // If any required parameter is missing, display an error message
        echo "<p>Error: Missing parameters.</p>";
    }
    ?>
</div>
</body>
</html>