<?php

// Include your database connection file
require_once('db_connection.php');

// Include the file to retrieve user data from the session
require_once('retrieve_flexpal_accounts.php');

// Retrieve user data from the session
$user = $_SESSION['user'];

// Process the POST data
if (isset($_POST['date'], $_POST['completed'])) {
    // Get the user ID from the retrieved user data
    $userId = $user['id'];

    $date = $_POST['date'];
    $completed = $_POST['completed'];

    // Convert the completed value to an integer
    $completed = intval($completed);

    // Check if the date already exists for the user
    $stmt = $conn->prepare("SELECT user_id FROM user_info WHERE user_id = ? AND date = ?");
    $stmt->bind_param("is", $userId, $date);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Date exists, update 'completed'
        $stmtUpdate = $conn->prepare("UPDATE user_info SET completed = ? WHERE user_id = ? AND date = ?");
        $stmtUpdate->bind_param("iis", $completed, $userId, $date);

        if ($stmtUpdate->execute()) {
            echo "Data updated successfully";
        } else {
            echo "Error updating data: " . $stmtUpdate->error;
        }

        $stmtUpdate->close();
    } else {
        // Date does not exist, insert new record
        $stmtInsert = $conn->prepare("INSERT INTO user_info (user_id, date, completed) VALUES (?, ?, ?)");
        $stmtInsert->bind_param("iss", $userId, $date, $completed);

        if ($stmtInsert->execute()) {
            echo "Data inserted successfully";
        } else {
            echo "Error inserting data: " . $stmtInsert->error;
        }

        $stmtInsert->close();
    }

    $stmt->close();
} else {
    echo "Error: 'date' or 'completed' is not set in the POST request.";
}

// Close the database connection
$conn->close();
?>