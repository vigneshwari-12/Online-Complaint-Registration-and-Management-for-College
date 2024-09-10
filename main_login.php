<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirect Buttons</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url("logins_page.jpg");
            background-size: 100% auto;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        h1 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .button-container {
            text-align: center;
        }
        
        .redirect-button {
            display: block; /* Change buttons to block elements */
            width: 200px; /* Adjust button width if needed */
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            border: 2px solid #333;
            border-radius: 5px;
            background-color: #f0f0f0;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Online Complaint Registration and Management For College</h1>
    <div class="button-container">
        <button class="redirect-button" onclick="window.location.href='login_page.php'">User Login</button>
        <button class="redirect-button" onclick="window.location.href='management_login.php'">Management Login</button>
        <button class="redirect-button" onclick="window.location.href='adminlogin_page.php'">Admin Login</button>
    </div>
</body>
</html>
