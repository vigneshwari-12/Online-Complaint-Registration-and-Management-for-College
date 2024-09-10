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

// Query to retrieve complaints for the current user using prepared statement
$sql = "SELECT query_id, status_of_complaint, time_of_complaint, details_of_issue FROM complaint_details WHERE Student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Close the prepared statement
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Tracking</title>
    <style>
        body {
            background-color: rgba(199, 148, 167, 0.1);
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 70%;
            margin: auto;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 20px;
            color: #330;
        }
        th {
            background-color: #f2f2f2;
        }
        .details-link {
            color: blue;
            text-decoration: underline;
            cursor: pointer;
            margin-right: 10px;
        }
        .main-page-link {
            position: absolute;
            left: 20px;
            top: 20px;
            color: blue;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <br>
    <a href="homepage.php" class="main-page-link">Homepage</a>
    <h1><center>Complaint Tracking</center></h1>
    <br>
    <table>
        <tr>
            <th>Complaint ID</th>
            <th>Status</th>
            <th>Details</th>
            <th>Photo</th>
        </tr>
        <?php
        // Check if there are complaints
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["query_id"] . "</td>";
                echo "<td>" . $row["status_of_complaint"] . "</td>";
                // Create a link to details page with complaint details as URL parameters
                echo "<td><a href='complaint_details.php?id=" . $row["query_id"] . "&status=" . urlencode($row["status_of_complaint"]) . "&dateandtime=" . urlencode($row["time_of_complaint"]) . "&details=" . urlencode($row["details_of_issue"]) . "' class='details-link'>View Details</a></td>";
                // Create a link to view the photo from the database
                echo "<td><a href='view_photo.php?id=" . $row["query_id"] . "' class='details-link'>View Photo</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No complaints found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
