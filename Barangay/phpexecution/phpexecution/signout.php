<?php
// Start a session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: https://flexpal.000webhostapp.com/Loginfp.html");
exit();
?>