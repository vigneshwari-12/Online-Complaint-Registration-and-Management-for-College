<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: management_login.php");
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

// Department ID to filter the results
$sql_department_id = "SELECT Department FROM management_details WHERE Name='$username'";
$result_department_id = $conn->query($sql_department_id);

// Check if the query was successful
if ($result_department_id) {
    // Fetch the department ID
    $row_department_id = $result_department_id->fetch_assoc();
    $department_id = $row_department_id['Department'];

    // Query to retrieve details from complaint_details table based on department ID
    $sql = "SELECT * FROM complaint_details WHERE complaint_type = '$department_id'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Complaints</title>
    <style>
        body{
            background-color:rgba(199, 148, 167, 0.1);
        }
        table {
            border-collapse: collapse;
            width: 70%; /* Reduced width */
            height: 50px;
            margin: auto; /* Center the table */
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 20px; /* Increase font size */
            color: #330; /* Darken text color */
        }
        th {
            background-color: #f2f2f2;
        }

        /* Style for the link */
        .details-link {
            color: blue;
            text-decoration: underline;
            cursor: pointer;
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
<a href="management_homepage.php" class="main-page-link">Homepage</a>
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
            echo "<td><a href='status_management.php?id=" . $row["query_id"] . "&status=" . urlencode($row["status_of_complaint"]) . "&dateandtime=" . urlencode($row["time_of_complaint"])."&details=" . urlencode($row["details_of_issue"]) . "' class='details-link'>View Details</a></td>";
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
    } else {
        echo "Error retrieving complaints: " . $conn->error;
    }
} else {
    echo "Error retrieving department ID: " . $conn->error;
}

// Close database connection
$conn->close();
?>
