<?php
// Include MongoDB client
require '/var/www/html/Attachee_web_system/vendor/autoload.php';

// Connect to MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017"); // Replace with your MongoDB connection string
$database = $client->selectDatabase('portal');
$internsCollection = $database->selectCollection('interns');
$projectsCollection = $database->selectCollection('projects');

// Get data from the POST request
$internId = $_POST['intern_id'];
$projectId = new MongoDB\BSON\ObjectId($_POST['project_id']);  // MongoDB expects ObjectId type

// Update the intern's record to assign the project
$updateInternResult = $internsCollection->updateOne(
    ['_id' => new MongoDB\BSON\ObjectId($internId)],
    ['$set' => ['project' => $projectId]]
);

// Mark the project as assigned
$updateProjectResult = $projectsCollection->updateOne(
    ['_id' => $projectId],
    ['$set' => ['assigned' => true]]
);

// Check if both updates were successful
if ($updateInternResult->getModifiedCount() > 0 && $updateProjectResult->getModifiedCount() > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
