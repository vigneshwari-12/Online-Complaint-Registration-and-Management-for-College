<?php
// Start the session
session_start();

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login_page.php");
    exit;
}

// Get username from session
$username = $_SESSION['username'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $type_block = $_POST['type_block'];
    $type_complaint = $_POST['type_complaint'];
    $type_priority = $_POST['type_priority'];
    $complaint = $_POST['complaint'];

    // Validate form data
    if ($type_block == "--select--" || $type_complaint == "--select--" || $type_priority == "--select--") {
        // If any field is not selected, display an alert message
        echo "<script>alert('Please select an option for all fields.');</script>";
    } elseif (empty($complaint)) {
        // If complaint field is empty, display an alert message
        echo "<script>alert('Please enter details of the issue.');</script>";
    } else {
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

        // Generate random ID of length 4
        $complaint_id = substr(str_shuffle("0123456789"), 0, 4);

        // Insert data into database
        $sql = "INSERT INTO complaint_details(Student_id,query_id,block_issue,complaint_type,priority,details_of_issue) VALUES ('$username', '$complaint_id','$type_block', '$type_complaint', '$type_priority', '$complaint')";

        if ($conn->query($sql) === TRUE) {
            // If data inserted successfully, send email notification and display success message
            $management_email = getManagementEmail($conn,$type_complaint); // Retrieve management email
            sendEmailNotification($username, $complaint_id, $type_block, $type_complaint, $type_priority, $complaint, $management_email);
            echo "<script>alert('Complaint registered successfully.'); window.location.href='homepage.php';</script>";
        } else {
            // If an error occurred, display an alert message
            echo "<script>alert('Error registering complaint. Please try again later.');</script>";
        }
        $conn->close();
    }
}

// Function to retrieve management email from database based on type of complaint
function getManagementEmail($conn, $type_of_complaint) {
    // SQL query to retrieve management email based on type of complaint
    $sql = "SELECT Email FROM management_details WHERE Department = '$type_of_complaint'";

    // Execute query
    $result = $conn->query($sql);

    // Check if query executed successfully and returned a row
    if ($result->num_rows > 0) {
        // Fetch management email from the first row
        $row = $result->fetch_assoc();
        return $row['Email'];
    } else {
        // If no row found, return empty string
        return "";
    }
}


// Function to send email notification
function sendEmailNotification($username, $complaint_id, $type_block, $type_complaint, $type_priority, $complaint, $management_email) {
    // Email configuration
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'miniproject131704@gmail.com'; // Replace with your Gmail username
    $mail->Password = '12@project'; // Replace with your Gmail password or app-specific password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 587;
    $mail->setFrom('miniproject131704@gmail.com'); // Replace with your Gmail username
    $mail->addAddress($management_email); // Send email to management
    $mail->isHTML(true);
    
    // Email subject and body
    $mail->Subject = "Complaint Registered by Student: $username";
    $mail->Body = "Complaint ID: $complaint_id<br>Block: $type_block<br>Type: $type_complaint<br>Priority: $type_priority<br>Details: $complaint";

    // Send email
    $mail->send();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Form</title>
    <style>
       h1 {
            color: blue;
        }
        body {
            font-family: Arial, sans-serif;
            background-image: url("complaintracking-img.png");
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
             background-color: #fffffff6;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 700px;
        }

        /* Style for the link */
        .main-page-link {
            position: absolute;
            left: 20px;
            top: 20px;
            color: black;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <!-- Link to the main page -->
    <a href="homepage.php" class="main-page-link">Homepage</a>
    
    <h1>Register a Complaint</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <!-- Choose block or department in which issue is to be resolved -->
        <h3>Issue in block: </h3>
        <select id="type_block" name="type_block">
            <option value="--select--">--select--</option>
            <option value="Admin">Admin</option>
            <option value="Canteen">Canteen</option>
            <option value="CSE Block">CSE Block</option>
            <option value="ECE Block">ECE Block</option>
            <option value="EEE Block">EEE Block</option>
            <option value="Ground/Auditiorium">Ground/Auditiorium</option>
            <option value="Hostel">Hostel</option>
            <option value="IT Block">IT Block</option>
            <option value="Library">Library</option>
        </select>

        <h3>Select type of Complaint:</h3>
        <select id="type_complaint" name="type_complaint">
            <option value="--select--">--select--</option>
            <option value="Carpentery">Carpentery</option>
            <option value="Electricity">Electricity</option>
            <option value="Gardening">Gardening</option>
            <option value="General Maintainance">General Maintainance</option>
            <option value="Plumber">Plumber</option>
        </select>

        <!-- Priority -->
        <h3>Priority: </h3>
        <select id="type_priority" name="type_priority">
            <option value="--select--">--select--</option>
            <option value="1">1-Crtitcal</option>
            <option value="2">2-High</option>
            <option value="3">3-Medium</option>
            <option value="4">4-Low</option>
        </select>

        <h3>Details of the issue: </h3>
        <textarea id="complaint" name="complaint" rows="8" cols="70" required></textarea><br>
        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>
