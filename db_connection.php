<?php
$host = "localhost"; // Host name
$port = 4306; // MySQL port
$username = "root"; // MySQL username
$password = ""; // MySQL password
$database = "agrimanage_mysql"; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
