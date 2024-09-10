<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
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

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container a {
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button-container a:hover {
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
    
<a href="admin_home_page.php" class="home-link">Homepage</a>
    <div class="container">
        <h1>User Management</h1>
        <div class="button-container">
            <a href="add_user.php">Add User Details</a>
            <a href="update_user.php">Update User Details</a>
            <a href="delete_user.php">Delete User Details</a>
        </div>
    </div>
</body>
</html>
