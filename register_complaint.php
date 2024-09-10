<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login_page.php");
    exit;
}

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
    } elseif ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        // If file upload encountered an error, display an alert message
        echo "<script>alert('File upload failed.');</script>";
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
        $file_data = file_get_contents($_FILES['file']['tmp_name']);

        // Prepare and bind parameters for inserting into database
        $stmt = $conn->prepare("INSERT INTO complaint_details (Student_id, query_id, block_issue, complaint_type, priority, details_of_issue, file_data) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $_SESSION['username'], $complaint_id, $type_block, $type_complaint, $type_priority, $complaint, $file_data);

        // Execute the statement
        if ($stmt->execute()) {
            // If data inserted successfully, send email notification and display success message
            $management_email = getManagementEmail($conn, $type_complaint); // Retrieve management email
            sendEmailNotification($_SESSION['username'], $complaint_id, $type_block, $type_complaint, $type_priority, $complaint, $management_email);
            echo "<script>alert('Complaint registered successfully.'); window.location.href='homepage.php';</script>";
        } else {
            // If an error occurred, display an alert message
            echo "<script>alert('Error registering complaint. Please try again later.');</script>";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}

// Function to retrieve management email from database based on type of complaint
function getManagementEmail($conn, $type_of_complaint) {
    // SQL query to retrieve management email based on type of complaint
    $sql = "SELECT Email FROM management_details WHERE Department = ?";

    // Prepare and bind parameter for the query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $type_of_complaint);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

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
    $sender_name="Online Complaint Registration";
    $sender_email="miniproject131704@gmail.com";
    $subject = "Complaint Registered by Student: $username";
    $body="Complaint ID: $complaint_id\nBlock: $type_block\nType: $type_complaint\nPriority: $type_priority\nDetails: $complaint";
    if(mail($management_email,$subject,$body,"From: $sender_name <$sender_email>"))
    {
        echo "<script>alert('Email Sent');</script>";
    }
    else
    {
        echo "<script>alert('Email Failed');</script>";
    }
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

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
        <h3>Upload File:</h3>
        <input type="file" name="file">
        <h3>Details of the issue: </h3>
        <textarea id="complaint" name="complaint" rows="8" cols="70" required></textarea><br>
        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>
