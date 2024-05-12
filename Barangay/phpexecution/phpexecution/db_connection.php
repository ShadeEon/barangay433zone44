<?php
$servername = "localhost";
$username = "id21868330_jem123";
$password = "Flexpal23.";
$dbname = "id21868330_flexpal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>