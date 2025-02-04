<?php

require '/var/www/html/Attachee_web_system/vendor/autoload.php'; // Include MongoDB client

// Connect to MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017"); // Your MongoDB URI
$database = $client->selectDatabase('portal');
$internsCollection = $database->selectCollection('interns');
$projectsCollection = $database->selectCollection('projects');

// Perform aggregation to join the projects with interns
$internsWithProjects = $internsCollection->aggregate([
    [
        '$lookup' => [
            'from' => 'projects', // the projects collection
            'localField' => 'project_id', // the field in interns collection that references projects
            'foreignField' => '_id', // the field in projects collection to match with
            'as' => 'project_details' // alias for the project data
        ]
    ],
    [
        '$unwind' => '$project_details' // Unwind the project_details array
    ]
]);

// Output the results
foreach ($internsWithProjects as $intern) {
    echo "Intern Name: " . $intern['first_name'] . " " . $intern['last_name'] . "\n";
    echo "Project Name: " . $intern['project_details']['project_name'] . "\n";
}

?>

