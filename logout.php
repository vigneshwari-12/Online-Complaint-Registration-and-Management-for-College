<?php
session_start();
echo "<script>alert('Logout successful'); window.location.href = 'main_login.php';</script>";
session_destroy();
exit();
?>