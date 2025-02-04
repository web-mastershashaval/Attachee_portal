<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure Composer's autoload file is included
require dirname(__FILE__) . '/../vendor/autoload.php';

// Use the MongoDB BSON ObjectID class for MongoDB document IDs
use MongoDB\BSON\ObjectID;
use MongoDB\Client;

// Start the session to access session variables
session_start();

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

// Check if the user is logged in (session variable is set)
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Debugging: Check if user_id is correctly set
    echo "Session User ID: " . $userId . "<br>";

    // Validate that user_id is a valid 24-character hexadecimal string (ObjectID format)
    if (preg_match('/^[a-f0-9]{24}$/', $userId)) {
        try {
            // Create a MongoDB ObjectID from the session user_id
            $objectId = new ObjectID($userId);
            echo "MongoDB ObjectID: " . $objectId . "<br>";

            // Fetch the user's data from the MongoDB collection
            $user = $usersCollection->findOne(['_id' => $objectId]);

            if ($user) {
                // If the user is found, assign the values
                $username = $user['username'];
                $email = $user['email'];
                echo "Username: " . $username . "<br>";
                echo "Email: " . $email . "<br>";
            } else {
                // If the user is not found in the database
                echo "User not found.<br>";
            }
        } catch (Exception $e) {
            // Catch any MongoDB related exceptions and print the error
            echo "Error with MongoDB query: " . $e->getMessage();
            exit;
        }
    } else {
        echo "Invalid user ID format.<br>";
        exit;
    }
} else {
    // If the user is not logged in, redirect to the login page
    header('Location: login.php');
    exit;
}

// Select the 'interns' collection (replace 'interns' with your collection name if needed)
$internsCollection = $database->interns;

// Fetch the list of interns/attachees from the collection
$interns = $internsCollection->find();

// Debug: Check if the query returned any results
if ($interns->isDead()) {
    echo "No interns found in the collection.<br>";
} else {
    echo "Intern data fetched successfully.<br>";
}

// Prepare the data for displaying
$internsData = [];
foreach ($interns as $intern) {
    $internsData[] = [
        'first_name' => $intern['first_name'],
        'last_name' => $intern['last_name'],
        'id_no' => $intern['id_no'],
        'role' => $intern['role'],
        'gender' => $intern['gender'],
        'project' => $intern['project'],
        'faculty' => $intern['faculty'],
        'contact_start' => $intern['contact_start'],
        'contact_end' => $intern['contact_end'],
    ];
}


?>