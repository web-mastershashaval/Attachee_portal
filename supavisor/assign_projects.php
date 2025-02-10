<?php
// Include the database connection
include('../conn.php');

// Check if the form is submitted and required values are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['intern_id']) && isset($_POST['project_id'])) {
    $internId = $_POST['intern_id'];  // Intern ID (id_no)
    $projectId = $_POST['project_id']; // Project ID

    // Debugging: Print out the intern_id being received
    var_dump($_POST['intern_id']);  // Debugging line to see what intern_id is being passed

    // Sanitize inputs to prevent SQL injection
    $internId = $conn->real_escape_string(trim($internId));  // Trim and sanitize the intern ID
    $projectId = $conn->real_escape_string(trim($projectId));

    // Debugging: Print sanitized intern ID and project ID
    echo "Intern ID (sanitized): " . $internId . "<br>";
    echo "Project ID: " . $projectId . "<br>";

    // Check if the intern exists and is not already assigned to a project
    $sql = "SELECT * FROM interns WHERE TRIM(id_no) = '$internId'";  // Query to find the intern by id_no
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $intern = $result->fetch_assoc();

        // Debugging: Check the intern data fetched
        var_dump($intern);  // See if the intern data was correctly fetched

        // Check if project_id is NULL (intern not assigned to a project)
        if (empty($intern['project_id'])) {
            // Assign the project to the intern
            $sql = "UPDATE interns SET project_id = '$projectId' WHERE TRIM(id_no) = '$internId'";

            if ($conn->query($sql) === TRUE) {
                echo "Project assigned successfully.";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Intern already assigned to a project.";
        }
    } else {
        echo "Intern not found. Please check the intern ID.";  // This message will show if no intern is found
    }
} else {
    echo "Missing intern ID or project ID.";  // This message will show if the form fields are missing
}

// Close the database connection
$conn->close();
?>
