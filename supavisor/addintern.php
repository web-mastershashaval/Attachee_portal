<?php
require '/var/www/html/Attachee_web_system/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $idNo = $_POST['id_no'];
    $role = $_POST['role'];
    $gender = $_POST['gender'];
    $faculty = $_POST['faculty'];
    $contactStart = $_POST['contact_start'];
    $contactEnd = $_POST['contact_end'];

    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $database = $client->selectDatabase('portal');
    $internsCollection = $database->selectCollection('interns');

    // Insert the new intern
    $insertResult = $internsCollection->insertOne([
        'first_name' => $firstName,
        'last_name' => $lastName,
        'id_no' => $idNo,
        'role' => $role,
        'gender' => $gender,
        'faculty' => $faculty,
        'contact_start' => $contactStart,
        'contact_end' => $contactEnd,
        'project' => null // No project assigned initially
    ]);

    // Redirect to the page after insertion (or return JSON for AJAX)
    header('Location: sp_dashboard.php'); // Change this to your desired redirect
}
?>
