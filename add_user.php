<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User Details</title>
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

        input[type="text"], input[type="password"], button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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
        <h2>Add User Details</h2>
        <div class="form">
            <form action="add_user.php?action=add" method="post">
                <input type="text" name="student_id" placeholder="Student ID" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="text" name="phone_number" placeholder="Phone Number" required>
                <button type="submit" name="add_user">Add User</button>
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
if (isset($_POST['add_user'])) {
    $student_id = $_POST['student_id'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    
    // Check if the user already exists
    $check_sql = "SELECT * FROM student_details WHERE Student_id='$student_id'";
    $result = $conn->query($check_sql);
    if ($result->num_rows > 0) {
        echo  "<script>alert('User with the same Student ID already exists');</script>";
    } else {
        // Insert user into database
        $sql = "INSERT INTO student_details(Student_id, Password, PhoneNumber) VALUES ('$student_id', '$password', '$phone_number')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('User added successfully');</script>";
        } else {
            echo  "<script>alert('Error in adding user details');</script>";
        }
    }
}
$conn->close();
?>
