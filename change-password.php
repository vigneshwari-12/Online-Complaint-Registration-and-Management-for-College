<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Change Password</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-image:url("");
    text-align: center;
  }
  form {
    width: 60%; /* Increased length of the container */
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
  }
  label, input {
    width: 48%;
    margin-bottom: 10px;
  }
  input[type="password"] {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }
  input[type="submit"] {
    width: 45%; /* Decreased width of the "Change Password" button */
    margin: 20px auto; /* Center the button horizontally */
    padding: 10px 20px;
    font-size: 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  input[type="submit"]:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>
  <h1><center>Change Password</center></h1>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="current-password">Current Password:</label>
    <input type="password" id="current-password" name="current-password" required>
    <br><br>
    <label for="new-password">New Password:</label>
    <input type="password" id="new-password" name="new-password" required>
    <br><br>
    <label for="confirm-password">Confirm New Password:</label>
    <input type="password" id="confirm-password" name="confirm-password" required>
    <br><br>
    <input type="submit" value="Change Password">
  </form>

  <?php
  // Check if the form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Retrieve the current password, new password, and confirm password from the form
      $currentPassword = $_POST["current-password"];
      $newPassword = $_POST["new-password"];
      $confirmPassword = $_POST["confirm-password"];

      // Check if current password matches the password in the session
      if ($currentPassword !== $_SESSION["password"]) {
          echo "<p style='text-align: center;'><br>Incorrect current password.<br></p>";
          exit; // Exit the script
      }

      // Perform validation to ensure new password and confirm password match
      if ($newPassword !== $confirmPassword) {
          // Passwords do not match, handle this error (redirect or display error message)
          echo "<p style='text-align: center;'><br>New password and confirm password do not match.<br></p>";
          exit; // Exit the script
      }

     $conn = new mysqli("localhost","root","", "user_database");
      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      // Retrieve the username (student_id) directly from the database based on the entered current password
      $sql = "SELECT Student_id FROM student_details WHERE Password = '$currentPassword'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $studentId = $row["Student_id"];

          // Hash the new password before updating it in the database
          $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

          // Update the password in the database for the retrieved username
          $updateSql = "UPDATE student_details SET Password ='$newPassword'  WHERE Student_id ='$studentId'";
          $updateStmt = $conn->prepare($updateSql);
          if ($updateStmt->execute()) {
              echo "<p style='text-align: center;'><br>Password Updated Successfully<br></p>";
          } else {
              echo "<p style='text-align:center;'>Error updating password: " . $conn->error . "</p>";
          }
      } else {
          echo "<p style='text-align:center;'>No user found with the entered password.</p>";
      }

      // Close the database connection
      $stmt->close();
      $conn->close();
  }
  ?>
  <p><a href="homepage.php">Go back to homepage</a></p>
</body>
</html>
