<?php

// Include your database connection file
require_once('db_connection.php');

// Include the file to retrieve user data from the session
require_once('retrieve_flexpal_accounts.php');

// Retrieve user data from the session
$user = $_SESSION['user'];

// Process the POST data
if (isset($_POST['date'])) {
    // Get the user ID from the retrieved user data
    $userId = $user['id'];
    $date = $_POST['date'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT completed FROM user_info WHERE user_id = ? AND date = ?");
    $stmt->bind_param("is", $userId, $date);
    $stmt->execute();
    $stmt->bind_result($completed);
    $stmt->fetch();
    $stmt->close();

    // Return the result as JSON
    header('Content-Type: application/json');
    echo json_encode(['completed' => $completed]);
} else {
    // Handle the case where 'date' is not set in the POST request
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Date not provided']);
}

// Close the database connection
$conn->close();

?>