<?php
// MySQL connection setup

// Database credentials
$host = 'localhost';  // Database host, e.g. localhost
$username = 'root';  // Your database username
$password = '';  // Your database password
$dbname = 'portal';  // The name of your database

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
