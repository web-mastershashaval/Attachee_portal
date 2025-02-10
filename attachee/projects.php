<?php
// Include the database connection
include('../conn.php');  // Ensure the correct path to your connection file

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an 'id_no' is passed in the URL (using GET method)
if (isset($_GET['id_no']) && !empty($_GET['id_no'])) {
    $id_no = $_GET['id_no'];

    // SQL query to fetch the intern's project information based on the id_no
    $sql = "SELECT 
                interns.id_no, 
                projects.name AS project_name, 
                projects.deadline, 
                projects.status, 
                interns.faculty 
            FROM interns
            LEFT JOIN projects ON interns.project_id = projects.id
            WHERE interns.id_no = ?";  // Use a parameterized query for security

    // Prepare the statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter
        $stmt->bind_param("s", $id_no);  // "s" denotes a string parameter

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if there are any results
        if ($result && $result->num_rows > 0) {
            // Loop through the results and display them in the table
            while ($intern = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($intern['id_no']) . "</td>";
                echo "<td>" . (isset($intern['project_name']) ? htmlspecialchars($intern['project_name']) : 'No Project Assigned') . "</td>";
                
                // Format the deadline if available
                $deadline = isset($intern['deadline']) ? date('Y-m-d', strtotime($intern['deadline'])) : 'N/A';
                echo "<td>" . htmlspecialchars($deadline) . "</td>";
                
                // Display the project status
                echo "<td>" . (isset($intern['status']) ? htmlspecialchars($intern['status']) : 'N/A') . "</td>";
                
                echo "<td>" . htmlspecialchars($intern['faculty']) . "</td>";
                echo "<td><a href='edit_intern.php?id_no=" . urlencode($intern['id_no']) . "'>View</a></td>";
                echo "</tr>";
            }
        } else {
            // No results found for the specific intern, display a message
            echo "<tr><td colspan='7'>No projects found for this intern.</td></tr>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // If the SQL query failed to prepare
        echo "<tr><td colspan='7'>Error in SQL query preparation.</td></tr>";
    }
} else {
    // If no 'id_no' is provided in the URL, display a message
    echo "<tr><td colspan='7'>No intern specified.</td></tr>";
}

// Close the database connection
$conn->close();
?>
