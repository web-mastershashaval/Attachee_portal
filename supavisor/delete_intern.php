<?php
// Connection variables
$servername = "localhost";  // Your MySQL server
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$dbname = "portal";         // Your MySQL database name

// Create connection to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the intern_id is set and form is being submitted
if (isset($_POST['intern_id'])) {
    // Sanitize the intern ID to prevent SQL injection
    $intern_id = $conn->real_escape_string($_POST['intern_id']);

    // SQL query to delete the intern based on id_no
    $sql = "DELETE FROM interns WHERE id_no = '$intern_id'";

    // Execute the query and check if the delete operation was successful
    if ($conn->query($sql) === TRUE) {
        // If successful, redirect back to the dashboard
        header('Location: sp_dashboard.php');
        exit;
    } else {
        // If there is an error, show it
        echo "Error: " . $conn->error;
    }
}

// Close the MySQL connection
$conn->close();
?>
