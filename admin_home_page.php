<?php
// Start the session
session_start();

// Check if the user is logged in
if(!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: management_login.php");
    exit;
}

// Get the username from the session
$username = $_SESSION['username'];

// Check if the alert message has been shown before
if (!isset($_SESSION['alert_shown'])) {
    // Display the welcome message with the username
    echo "<script>alert('Welcome Admin, $username!');</script>";
    
    // Set the session variable to indicate that the message has been shown
    $_SESSION['alert_shown'] = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home Page</title>
<style>
  body {
    font-family: Arial, sans-serif;
    text-align: center;
    background-image: url("homeimg.png");
    background-size: 100% auto;
    align-items: center;

  }
  .button {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px;
    font-size: 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
  }
  .button:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>
  <br>
  <h1>Online Complaint Registration</h1>
  <h2>G.Narayanamma Institute of Technology and Sciences for Women</h2>
  <h3>Admin Page</h3>
  <br><br>
  <a href="change-password-admin.php" class="button">Change Password</a>
  <a href="manage-user-details.php" class="button">Manage User Details</a>
  <a href="manage-incharge-details.php" class="button">Manage Incharge Details</a>
  <a href="admin_logout.php" class="button">Logout</a>
</body>
</html>
