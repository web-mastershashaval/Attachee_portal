<?php

require '/var/www/html/Attachee_web_system/vendor/autoload.php';

// Check if form data is received
if (isset($_POST['intern_id']) && isset($_POST['project_id'])) {
    $internId = $_POST['intern_id'];  // Intern ID (id_no)
    $projectId = $_POST['project_id']; // Project ID (MongoDB ObjectId)

    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $database = $client->selectDatabase('portal');
    $internsCollection = $database->selectCollection('interns');

    // Update the intern with the selected project ID
    try {
        $result = $internsCollection->updateOne(
            ['id_no' => $internId], // Use id_no instead of _id
            ['$set' => ['project' => $projectId]] // Set the project ID
        );

        if ($result->getModifiedCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Intern not found or project already assigned']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing intern ID or project ID']);
}
