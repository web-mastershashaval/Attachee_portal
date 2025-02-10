<?php
// Include the database connection
include('../conn.php');  // Ensure the correct path to your connection file

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch interns and their project information
$sql = "SELECT 
            interns.id_no, 
            CONCAT(interns.first_name, ' ', interns.last_name) AS attachee_name, 
            projects.name AS project_name, 
            projects.deadline, 
            projects.status, 
            interns.faculty 
        FROM interns
        LEFT JOIN projects ON interns.project_id = projects.id";

// Execute the query
$result = $conn->query($sql);

// Check if there are any results
if ($result && $result->num_rows > 0) {
    // Loop through the results and display them in the table
    while ($intern = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($intern['id_no']) . "</td>";
        echo "<td>" . htmlspecialchars($intern['attachee_name']) . "</td>";
        echo "<td>" . (isset($intern['project_name']) ? htmlspecialchars($intern['project_name']) : 'No Project Assigned') . "</td>";
        
        // Format the deadline if available
        $deadline = isset($intern['deadline']) ? date('Y-m-d', strtotime($intern['deadline'])) : 'N/A';
        echo "<td>" . htmlspecialchars($deadline) . "</td>";
        
        // Display the project status
        echo "<td>" . (isset($intern['status']) ? htmlspecialchars($intern['status']) : 'N/A') . "</td>";
        
        echo "<td>" . htmlspecialchars($intern['faculty']) . "</td>";
        echo "<td><a href='edit_intern.php?id_no=" . urlencode($intern['id_no']) . "'>Edit</a></td>";
        echo "</tr>";
        // | <a href='delete_intern.php?id_no=" . urlencode($intern['id_no']) . "'>Delete</a>
    }
} else {
    // No interns found, display a message
    echo "<tr><td colspan='7'>No interns found.</td></tr>";
}

// Close the database connection
$conn->close();
?>
