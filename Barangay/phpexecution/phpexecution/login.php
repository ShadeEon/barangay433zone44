<?php
// Include the database connection file
include_once('db_connection.php');

// Start a session at the very beginning
session_start();

// Form data
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare the SQL statement to retrieve user information based on the username
$stmt = $conn->prepare("SELECT * FROM flexpal_accounts WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Check if the user exists and verify the password
if ($user && password_verify($password, $user['password'])) {
    // Store all user data in the session
    $_SESSION['user'] = $user;

    // Redirect to a secure page after successful login
    header("Location: https://flexpal.000webhostapp.com/Dashboardfp.php");
    exit();
} else {
    // Display an alert with a JavaScript redirect and retain the username in the URL
    echo '<script>';
    echo '  var username = "' . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . '";';  // Escape and retain username
    echo '  alert("Username or Password is incorrect, Please try again later.");';
    echo '  window.location.href = "https://flexpal.000webhostapp.com/Loginfp.html?username=" + encodeURIComponent(username);';
    echo '</script>';
    exit();  // Make sure to exit after displaying the alert
}

$conn->close();
?>