<?php
// Include the database connection file
include_once('db_connection.php');

// Check if all required fields are set
if (isset($_POST['email'], $_POST['name'], $_POST['birthdate'], $_POST['age'], $_POST['contact'], $_POST['username'], $_POST['password'])) {
    // Form data
    $email = $_POST['email'];
    $name = $_POST['name'];
    $birthdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Attempt to prepare the statement for inserting into 'flexpal_accounts'
    $stmtInsertFlexpal = $conn->prepare("INSERT INTO flexpal_accounts (username, password, email, name, birthdate, age, contact) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Check if the statement preparation was successful
    if ($stmtInsertFlexpal) {
        $stmtInsertFlexpal->bind_param("sssssis", $username, $password, $email, $name, $birthdate, $age, $contact);

        if ($stmtInsertFlexpal->execute()) {
            // Get the user ID of the newly inserted record
            $userId = $stmtInsertFlexpal->insert_id;

            // Attempt to prepare the statement for inserting into 'another_table'
            $stmtInsertAnother = $conn->prepare("INSERT INTO user_info (user_id) VALUES (?)");

            // Check if the statement preparation was successful
            if ($stmtInsertAnother) {
                $stmtInsertAnother->bind_param("i", $userId);

                if ($stmtInsertAnother->execute()) {
                    header("Location: https://flexpal.000webhostapp.com/Loginfp.html");
                    echo '<script>alert("Registration Successful!")</script>'; 
                    exit();
                } else {
                    echo '<script>alert("Registration Unsuccessful, Please try again later!")</script>'; 
                }

                $stmtInsertAnother->close();
            } else {
                // Log detailed error information for debugging (do not expose in production)
                error_log("Error: " . $conn->error);
                echo "Error: Failed to prepare the statement for 'another_table'. Please try again later.";
            }
        } else {
            // Log detailed error information for debugging (do not expose in production)
            error_log("Error: " . $stmtInsertFlexpal->error);
            echo "Error: Failed to register. Please try again later.";
        }

        $stmtInsertFlexpal->close();
    } else {
        // Log detailed error information for debugging (do not expose in production)
        error_log("Error: " . $conn->error);
        echo "Error: Failed to prepare the statement for 'flexpal_accounts'. Please try again later.";
    }
} else {
    // Display an error message if required fields are missing
    echo "Error: Missing required fields.";
    var_dump($_POST);
}

$conn->close();
?>