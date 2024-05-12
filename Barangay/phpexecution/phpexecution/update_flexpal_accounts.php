<?php
// Include the database connection file
include_once('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the session file
    require_once('retrieve_flexpal_accounts.php');

    // Retrieve user data from the session
    $user = $_SESSION['user'];

    // Form data
    $email = $_POST['email'];
    $name = $_POST['name'];
    $birthday = $_POST['date'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];
    $username = $_POST['username'];

    // Update the user's information in the database
    $stmt = $conn->prepare("UPDATE flexpal_accounts SET email=?, name=?, birthdate=?, age=?, contact=?, username=? WHERE id=?");
    $stmt->bind_param("ssssssi", $email, $name, $birthday, $age, $contact, $username, $user['id']);
    $stmt->execute();
    $stmt->close();

    // Optionally, update the user data in the session
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['birthdate'] = $birthday;
    $_SESSION['user']['age'] = $age;
    $_SESSION['user']['contact'] = $contact;
    $_SESSION['user']['username'] = $username;

    // Close the database connection
    $conn->close();

    // JavaScript code to show an alert upon successful update
    echo '<script>';
    echo '  alert("Information updated successfully!");';
    echo '  window.location.href = "https://flexpal.000webhostapp.com/Dashboardfp.php";'; // Redirect to a secure page
    echo '</script>';
    exit();
}
?>