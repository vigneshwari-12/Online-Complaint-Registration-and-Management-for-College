<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Management Details</title>
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
            font-size: 28px;
        }
        .form {
            margin-top: 20px;
        }
        input[type="text"], input[type="password"], select, button {
            display: block;
            margin-bottom: 20px;
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 18px;
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
    <a href="manage-incharge-details.php" class="home-link">Manage Incharge</a>
    <div class="container">
        <center>
            <h2>Add Management Details</h2>
            <div class="form">
                <form action="add_incharge.php?action=add" method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="text" name="phone_number" placeholder="Phone Number" required>
                    <select name="department" required>
                    <option value="--select--">--select--</option>
                        <option value="Carpentery">Carpentery</option>
                        <option value="Electricity">Electricity</option>
                        <option value="Gardening">Gardening</option>
                        <option value="General Maintainance">General Maintainance</option>
                        <option value="Plumber">Plumber</option>
                    </select>
                    <button type="submit" name="add_user">Add User</button>
                </form>
            </div>
        </center>
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
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    $department = $_POST['department'];
    $check_sql = "SELECT * FROM management_details WHERE Name='$username'";
    $result = $conn->query($check_sql);
    if ($result->num_rows > 0) {
        echo  "<script>alert('User with the same Username already exists');</script>";
    } else {
        $sql = "INSERT INTO management_details (Name, Password, PhoneNumber, Department) VALUES ('$username', '$password', '$phone_number', '$department')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('User added successfully');</script>";
        } else {
            echo  "<script>alert('Error in adding user details');</script>";
        }
    }
}
$conn->close();
?>
