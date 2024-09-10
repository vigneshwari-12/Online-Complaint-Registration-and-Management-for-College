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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .details-container {
            max-width: 800px; /* Increased width */
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; /* Added margin at the bottom */
        }

        .details-container h2 {
            font-size: 24px; /* Increased font size */
            text-align: center;
            margin-bottom: 20px;
        }

        .details-container p {
            font-size: 18px; /* Increased font size */
            margin-bottom: 10px;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 150px;
        }

        .button {
            margin-bottom: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #007bff;
            color: #fff;
        }

        .main-page-link {
            position: absolute;
            left: 20px;
            top: 20px;
            color: black;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<a href="status_complaint_management.php" class="main-page-link">View Complaints</a>
<div class="container">
    <div class="details-container">
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
    <div class="button-container">
        <button class="button" onclick="changeStatus('In Progress')">Mark as In Progress</button>
        <button class="button" onclick="changeStatus('Resolved')">Mark as Resolved</button>
    </div>
</div>

<script>
    function changeStatus(newStatus) {
        // Get the complaint ID from the URL
        var complaintId = <?php echo isset($_GET['id']) ? $_GET['id'] : 'null'; ?>;

        if (complaintId) {
            // Send an AJAX request to update the status
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Check if the status was updated successfully
                    if (xhr.responseText.trim() === 'success') {
                        // Reload the page to reflect the updated status
                        location.reload();
                    } else {
                        alert('Failed to update status. Please try again.');
                    }
                }
            };
            xhr.send("id=" + complaintId + "&status=" + newStatus);
        } else {
            alert('Failed to get complaint ID.');
        }
    }
</script>

</body>
</html>
