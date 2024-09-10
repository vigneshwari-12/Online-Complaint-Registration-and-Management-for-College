<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Authentication</title>
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
        <h2>Management Login</h2>
        <form id="login-form" class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <button type="button" id="reset-password-btn" onclick="resetPassword()">Reset Password</button>
        </form>
    </div>
    <div id="reset-password-form" class="reset-password-form">
        <h2>Reset Password</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="reset_password" value="true">
            <input type="hidden" name="username" value="">
            <input type="password" name="new_password" id="new-password" placeholder="New Password" required>
            <input type="password" name="confirm_password" id="confirm-password" placeholder="Confirm Password" required>
            <button type="submit">Reset</button>
        </form>
    </div>
    <script>
        function submitForm() {
            document.getElementById("login-form").submit();
        }
        function resetPassword() {
            var username = document.getElementsByName("username")[0].value;
            document.getElementById("reset-password-form").style.display = "block";
            document.getElementById("reset-password-form").getElementsByTagName("input")[1].value = username;
        }
    </script>
</body>
</html>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
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

    if (isset($_POST['reset_password'])) {
        // Code to handle resetting password
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        $username = $_POST['username'];
        
        if ($newPassword === $confirmPassword) {
            // Update the password in the database
            $sql = "UPDATE management_details SET Password='$newPassword' WHERE Username='$username'";
            if ($conn->query($sql) === TRUE) {
                echo "Password updated successfully";
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            echo "Passwords do not match.";
        }
    } else {
        // Retrieve data from form
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // SQL query to check if the username and password match
        $sql = "SELECT * FROM management_details WHERE Username='$username' AND Password='$password'";
        $result = $conn->query($sql);

        // Check if there is a match
        if ($result->num_rows > 0) {
            // Redirect to homepage if credentials are correct
            header("Location: management_homepage.php");
            exit();
        } else {
         ?>
            <script>
            window.alert("Incorrect username or password. Please try again.");
            </script>
   <?php
        }
    }

    $conn->close();
}
?>
