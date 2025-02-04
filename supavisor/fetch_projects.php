<?php
require '/var/www/html/Attachee_web_system/vendor/autoload.php'; // Ensure path is correct

$client = new MongoDB\Client("mongodb://localhost:27017");
$database = $client->selectDatabase('portal'); // Replace with actual DB name

// Fetch intern data
$internsCollection = $database->selectCollection('interns'); // Replace with actual collection name
$internsData = $internsCollection->find()->toArray(); // Fetch all interns data

// Fetch projects data (replace with your collection and query)
$projectsCollection = $database->selectCollection('projects');
$projectsData = $projectsCollection->find()->toArray(); // Fetch all projects data

// Check if we got any intern data
if (empty($internsData)) {
    die("No intern data found");
}

// Convert BSONDocument to Array and combine intern data with projects data
foreach ($projectsData as &$project) {
    // Convert BSONDocument to Array
    $projectArray = $project->getArrayCopy(); // Convert the BSON object to a plain array
    
    // Assuming your project data contains an 'id_no' to match intern data
    foreach ($internsData as $intern) {
        if ($intern['id_no'] === $projectArray['id_no']) { // Match by 'id_no' field
            // Add intern data to project
            $projectArray['attachee_name'] = $intern['first_name'] . ' ' . $intern['last_name'];
            $projectArray['faculty'] = $intern['faculty'];
            $projectArray['deadline'] = date('Y-m-d', strtotime($intern['contact_end'] . ' -1 week')); // 1 week before contact end
            
            // Update the project data with the combined information
            $project = $projectArray; // Update the project array with the intern data
            break;
        }
    }
}

// Output combined projects data for debugging
echo '<pre>';
print_r($projectsData); // Debugging the combined projects data
echo '</pre>';
?>
