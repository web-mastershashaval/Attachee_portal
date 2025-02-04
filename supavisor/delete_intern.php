<?php
require '/var/www/html/Attachee_web_system/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $internId = $_POST['intern_id']; // Get the intern ID from the form

    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $database = $client->selectDatabase('portal');
    $internsCollection = $database->selectCollection('interns');

    // Delete the intern by ID
    $deleteResult = $internsCollection->deleteOne(['id_no' => $internId]);

    // Redirect or handle response
    if ($deleteResult->getDeletedCount() > 0) {
        echo "Intern deleted successfully";
        header('Location: sp_dashboard.php'); // Redirect after deletion
    } else {
        echo "Intern not found.";
    }
}
?>
