<?php
session_start(); // Start the session

// Destroy the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session itself

// Redirect to the login page or homepage
header("Location: loginpage.php");
exit();
?>
