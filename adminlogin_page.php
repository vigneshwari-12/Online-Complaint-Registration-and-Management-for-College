<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Authentication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background-image: url('login_img.jpg');
            background-size: 100% auto;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color:#273746;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        h2 {
            color:#f4f4f4;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"],
        input[type="date"],
        button {
            display: block;
            width: 95%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            align:center;
            width: 40%;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .reset-password-form {
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form id="login-form" class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <button type="button" id="reset-password-btn">Reset Password</button>
        </form>
    </div>
    <script>
        document.getElementById("reset-password-btn").addEventListener("click", function() {
            var username = document.getElementsByName("username")[0].value;
            if (username.trim() === "") {
                alert("Please enter your username first.");
                return;
            }
            var confirmReset = confirm("Are you sure you want to reset your password to your username?");
            if (confirmReset) {
                // Send AJAX request to update password
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    //if (xhr.readyState === 4 && xhr.status === 200) {
                        //alert(xhr.responseText);
                    //}
                };
                xhr.send("reset_password=1&username=" + encodeURIComponent(username));
		        window.alert("Password reset successful");
            }
        });
    </script>
</body>
</html>

<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "user_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['reset_password'])) {
        $username = $_POST['username'];
        $sql = "UPDATE admin_details SET Password='$username' WHERE Name='$username'";
        if ($conn->query($sql) === TRUE) {
            echo "Password reset successful";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        // Retrieve data from form for login
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // SQL query to check if the username and password match
        $sql = "SELECT * FROM admin_details WHERE Name='$username' AND Password='$password'";
        $result = $conn->query($sql);

        // Check if there is a match
        if ($result->num_rows > 0) {
            // Store username in session
            $_SESSION['username'] = $username;
            $_SESSION['password']=$password;
            // Redirect to homepage if credentials are correct
            header("Location: admin_home_page.php?username=" . urlencode($username));
            exit();
        } else {
            // Display error message for incorrect credentials
            echo '<script>alert("Incorrect username or password. Please try again.");</script>';
        }
    }
    $conn->close();
}
?>