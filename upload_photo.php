<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: management_login.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["photo"]) && $_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
    // Get username from session
    $username = $_SESSION['username'];
    
    // Get form data
    $complaint_id = $_POST['query_id'];

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

    // Define the target directory to store the uploaded photos
    $target_dir = "uploads/";

    // Generate a unique filename for the uploaded photo
    $file_name = uniqid() . "_" . basename($_FILES["photo"]["name"]);

    // Set the target path for the uploaded photo
    $target_path = $target_dir . $file_name;

    // Move the uploaded photo to the target directory
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_path)) {
        // Insert the uploaded photo path and complaint ID into the database
        $stmt = $conn->prepare("INSERT INTO management_photos (query_id, photo_management) VALUES (?, ?)");
        $stmt->bind_param("ss", $complaint_id, $target_path);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "The photo has been added to the database successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Photo upload failed
        echo "Sorry, there was an error uploading your file.";
    }

    // Close database connection
    $conn->close();
}
?>
