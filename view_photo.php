<?php
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

// Get complaint ID from URL parameter
if(isset($_GET['id'])) {
    $complaint_id = $_GET['id'];

    // Retrieve photo data from the database based on complaint ID
    $sql = "SELECT file_data FROM complaint_details WHERE query_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $complaint_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch photo data
        $row = $result->fetch_assoc();
        
        // Set appropriate header for image display
        header("Content-type: image/jpeg"); // Change this according to your image type

        // Output the photo data
        echo $row['file_data'];
    } else {
        // If no photo found for the complaint ID, display a default image or an error message
        // For example, you can display a placeholder image:
        $default_image = file_get_contents("path/to/default.jpg"); // Provide path to your default image
        header("Content-type: image/jpeg"); // Change this according to your default image type
        echo $default_image;
    }
} else {
    // If complaint ID is not provided in the URL parameter, display an error message
    echo "Error: Complaint ID not provided.";
}

// Close database connection
$conn->close();
?>
