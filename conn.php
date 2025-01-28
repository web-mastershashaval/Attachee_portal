<?php
$servername = "localhost";
$db_name = "portal";
$username = "root";
$password = "sambaman";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db_name);

// Check connection
if (mysqli_connect_errno()) {
    // Use mysqli_connect_errno() to get a more detailed error
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";  // If connection is successful, this will be printed