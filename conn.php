<?php
// MongoDB connection setup
require 'vendor/autoload.php';  // Make sure MongoDB client is autoloaded

use MongoDB\Client;

// Create a new MongoDB client instance
$mongoClient = new Client("mongodb://localhost:27017");  // Ensure MongoDB is running on localhost

// Select the 'portal' database (replace 'portal' with your database name if it's different)
$database = $mongoClient->portal;  

// Select the 'users' collection (replace 'users' with your collection name if needed)
$usersCollection = $database->users;  

// Verify the connection and collection setup
if (!$usersCollection) {
    echo "Error: MongoDB collection not found!";
    exit;  // Stop script execution if collection is not found
}
?>
