<?php

require '/var/www/html/Attachee_web_system/vendor/autoload.php';

// Connect to MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017"); // Replace with your MongoDB connection string
$database = $client->selectDatabase('portal');
$projectsCollection = $database->selectCollection('projects');

// Fetch all projects from the projects collection
$projects = $projectsCollection->find(); // Fetch projects collection

// Prepare an array to send back to the frontend
$projectArray = [];
foreach ($projects as $project) {
    $projectArray[] = [
        'id' => (string)$project['_id'], // Convert ObjectId to string
        'name' => $project['project_name'], // Assuming 'project_name' field exists
    ];
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($projectArray);
