<?php
include_once "./conn.php";

// Query to get all users from the database
$query = "SELECT id, username, profile_picture FROM users ORDER BY id DESC";
$result = $conn->query($query);

// Initialize an empty array to hold the user data
$users = [];

// Loop through the result set and add each user to the users array
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

// Return the users array as a JSON response
echo json_encode($users);
?>
