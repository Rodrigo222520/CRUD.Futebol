<?php
// Database connection configuration
$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'futebol_db';

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8");
?>
