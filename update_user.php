<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }

        .form {
            margin-top: 20px;
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        select, input[type="text"], button {
            flex: 1;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px; /* Increase font size */
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
        
        .home-link {
            position: absolute;
            top: 10px;
            left: 10px;
            text-decoration: none;
            color: #333333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <a href="manage-user-details.php" class="home-link">Manage Users</a>
    <div class="container">
        <h2>Update User Details</h2>
        <div class="form">
            <form action="update_user.php" method="post">
                <div class="form-row">
                    <input type="text" name="student_id" placeholder="Student ID" required>
                </div>
                <div class="form-row">
                    <select name="update_field">
                        <option value="Password">Password</option>
                        <option value="PhoneNumber">PhoneNumber</option>
                    </select>
                    <input type="text" name="new_value" placeholder="New Value" required>
                </div>
                <button type="submit" name="update_user">Update User</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['update_user'])) {
    $student_id = $_POST['student_id'];
    $update_field = $_POST['update_field'];
    $new_value = $_POST['new_value'];
    
    $sql = "UPDATE student_details SET $update_field='$new_value' WHERE Student_id='$student_id'";
    $result = $conn->query($sql);

    if ($conn->affected_rows > 0) {
        echo "<script>alert('User details updated successfully');</script>";
    } else {
        echo "<script>alert('Error in updating user details');</script>";
    }
}

$conn->close();
?>
