<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticeboard</title>
    <style>
        /* Styles for the large container */
        #noticeboard-container {
            width: 80%; /* Adjust the width as needed */
            margin: 0 auto; /* Center the container horizontally */
            padding: 20px; /* Add padding for spacing */
            border: 2px solid #ccc; /* Add a border for visibility */
            border-radius: 10px; /* Add rounded corners */
        }

        /* Styles for each small container */
        .notice-container {
            margin-bottom: 20px; /* Add spacing between each container */
            padding: 10px; /* Add padding for spacing inside each container */
            border: 1px solid #ddd; /* Add a border for visibility */
            border-radius: 5px; /* Add rounded corners */
            background-color: #f9f9f9; /* Add background color */
        }

        /* Styles for specific elements within each container */
        .notice-container p {
            margin: 5px 0; /* Adjust spacing for paragraphs */
            font-size: 16px; /* Adjust font size */
        }

        /* Additional styles for the large container */
        #notices {
            list-style: none; /* Remove default list styles */
            padding: 0; /* Remove padding for list */
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
    <center><h1>Noticeboard</h1></center>
    <br>
    <div id="noticeboard-container">
    <a href="management_homepage.php" class="main-page-link">Homepage</a>
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "user_database";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Query to retrieve notices
        $sql = "SELECT * FROM complaint_details";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<div class="notice-container">';
                echo "<p>Student ID: " . $row["Student_id"] . "</p>";
                echo "<p>Issue is in: " . $row["block_issue"] . "</p>";
                echo "<p>Complaint is about: " . $row["complaint_type"] . "</p>";
                echo "<p>Complaint raised at: " . $row["time_of_complaint"] . "</p>";
                echo "<p>Complaint Details: " . $row["details_of_issue"] . "</p>";
                if($row["status_of_complaint"] == "") {
                    echo "<p>Status: Complaint Received</p>";
                } else {
                    echo "<p>Status: " . $row["status_of_complaint"] . "</p>";
                }
                echo '</div>';
            }
        } else {
            echo "<p>No notices found.</p>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
