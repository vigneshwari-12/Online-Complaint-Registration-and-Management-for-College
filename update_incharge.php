<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Management Details</title>
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

        .form-row {
            margin-bottom: 10px;
        }

        select, input[type="text"], button {
            margin-bottom: 10px;
            padding: 10px;
            width: 100%;
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
    <a href="manage-incharge-details.php" class="home-link">Manage Incharge</a>
    <div class="container">
        <h2>Update Management Details</h2>
        <div class="form">
            <form action="update_incharge.php" method="post">
                <div class="form-row">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="form-row">
                    <select name="update_field">
                        <option value="Password">Password</option>
                        <option value="PhoneNumber">PhoneNumber</option>
                        <option value="Department">Department</option>
                    </select>
                </div>
                <div class="form-row">
                    <input type="text" name="new_value" placeholder="New Value" required>
                </div>
                <button type="submit" name="update_incharge">Update Incharge</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
$conn = new mysqli("localhost", "root", "", "user_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['update_incharge'])) {
    $username = $_POST["username"];
    $update_field = $_POST['update_field'];
    $new_value = $_POST['new_value'];
    $check_sql = "SELECT * FROM management_details WHERE Name='$username'";
    $result = $conn->query($check_sql);
    if ($result->num_rows == 0) {
        echo  "<script>alert('User with the given Username does not exist');</script>";
    } else {
        $sql = "UPDATE management_details SET $update_field='$new_value' WHERE Name='$username'";
        if ($conn->query($sql) == TRUE) {
            echo "<script>alert('User details updated successfully');</script>";
        } else {
            echo "<script>alert('Error in updating user details');</script>";
        }
    }
}
$conn->close();
?>
