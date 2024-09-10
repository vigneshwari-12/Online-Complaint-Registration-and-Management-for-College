<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incharge Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 50%;
            margin: 50px auto;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .button-box {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 10px;
        }

        .button-container {
            display: inline-block;
            margin: 10px;
        }

        .button-container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
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
            font-size: 20px;
        }

    </style>
</head>
<body>
    <div class="container">
        <a href="admin_home_page.php" class="home-link">Homepage</a>
        <h1>Incharge Management</h1>
        <div class="button-box">
            <div class="button-container">
                <a href="add_incharge.php">Add Incharge</a>
            </div>
            <div class="button-container">
                <a href="update_incharge.php">Update Incharge</a>
            </div>
            <div class="button-container">
                <a href="delete_incharge.php">Delete Incharge</a>
            </div>
        </div>
    </div>
</body>
</html>
