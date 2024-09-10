<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 50%;
            margin: 50px auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form {
            text-align: center;
        }

        input[type="text"], button {
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: px 10px;
            background-color: #dc3545; /* Red color for delete button */
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #c82333; /* Darker shade of red on hover */
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
    <a href="manage-incharge-details.php" class="home-link">Manage Incharge</a>
    <div class="container">
        <h2>Delete User Details</h2>
        <div class="form">
            <form action="delete_incharge.php" method="post">
                <input type="text" name="username" placeholder="Username to Delete" required>
                <button type="submit" name="delete_incharge">Delete User</button>
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
if (isset($_POST['delete_incharge'])) {
    $username = $_POST['username'];
    $check_sql = "SELECT * FROM management_details WHERE Name='$username'";
    $result = $conn->query($check_sql);
    if ($result->num_rows == 0) {
        echo  "<script>alert('User with the given Student ID does not exist');</script>";
    } else {
        $sql = "DELETE FROM management_details WHERE Name='$username'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('User deleted successfully');</script>";
        } else {
            echo  "<script>alert('Error in deleting user');</script>";
        }
    }
}
$conn->close();
?>