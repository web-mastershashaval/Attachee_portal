<?php

// Include the database connection
include('../conn.php'); // Assuming your connection settings are in 'conn.php'

// Check if form data is received
if (isset($_POST['intern_id']) && isset($_POST['project_id'])) {
    $internId = $_POST['intern_id'];  // Intern ID (id_no)
    $projectId = $_POST['project_id']; // Project ID (numeric or string depending on your schema)

    // Sanitize and validate the inputs to prevent SQL injection and ensure proper data format
    $internId = $conn->real_escape_string($internId);
    $projectId = $conn->real_escape_string($projectId);

    // Further validation (optional based on your field requirements)
    if (empty($internId) || empty($projectId)) {
        echo json_encode(['success' => false, 'message' => 'Intern ID and Project ID are required.']);
        exit;
    }

    // Update the intern's project assignment
    try {
        // SQL query to update the intern's project
        $sql = "UPDATE interns SET project_id = ? WHERE id_no = ?";

        // Prepare the SQL statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("ss", $projectId, $internId);

            // Execute the query
            if ($stmt->execute()) {
                // Check if any row was affected (modified)
                if ($stmt->affected_rows > 0) {
                    echo json_encode(['success' => true, 'message' => 'Intern assigned to project successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Intern not found or project already assigned']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error executing query']);
            }

            // Close the statement
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Error preparing query']);
        }
    } catch (Exception $e) {
        // Log the exception if necessary
        error_log("Error in assigning project: " . $e->getMessage());

        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing intern ID or project ID']);
}

// Close the database connection
$conn->close();
?>
