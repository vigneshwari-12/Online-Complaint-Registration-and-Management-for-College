<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User Details</title>
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

        input[type="text"], button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #c82333;
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
        <h2>Delete User Details</h2>
        <div class="form">
            <form action="delete_user.php" method="post">
                <input type="text" name="student_id" placeholder="Student ID to Delete" required>
                <button type="submit" name="delete_user">Delete User</button>
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
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['delete_user'])) {
    $student_id = $_POST['student_id'];
    
    // Check if the user exists
    $check_sql = "SELECT * FROM student_details WHERE Student_id='$student_id'";
    $result = $conn->query($check_sql);
    if ($result->num_rows == 0) {
        echo  "<script>alert('User with the given Student ID does not exist');</script>";
    } else {
        // Delete user from the database
        $sql = "DELETE FROM student_details WHERE Student_id='$student_id'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('User deleted successfully');</script>";
        } else {
            echo  "<script>alert('Error in deleting user');</script>";
        }
    }
}
$conn->close();
?>