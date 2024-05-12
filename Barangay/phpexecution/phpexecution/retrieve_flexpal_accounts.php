<?php
// Start a session at the very beginning
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo '<script>';
    echo 'alert("You are not logged in. Redirecting to login page.");';
    echo 'window.location.href = "https://flexpal.000webhostapp.com/Loginfp.html";';
    echo '</script>';
    exit();
}

// Retrieve user data from the session
$user = $_SESSION['user'];
?>
