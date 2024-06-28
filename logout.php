<?php
// Start the session
session_start();

// Unset the userId session variable
unset($_SESSION['userId']);

// Destroy the session
session_destroy();

// Redirect the user to the login page or any other desired page
header("Location: loginPage.php");
exit();
?>
