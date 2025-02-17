<?php


// Include the database connection
include('../conn.php');  // Ensure this path is correct for the connection file

// Check if the user ID (user_id) is stored in the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];  // Get the logged-in user's ID

    // SQL query to fetch the intern's assigned projects based on the user ID
    $sql = "SELECT 
                projects.id AS project_id,
                projects.name AS project_name, 
                projects.deadline, 
                projects.status, 
                interns.faculty
            FROM projects 
            JOIN interns ON projects.id = interns.project_id
            JOIN users ON users.id = interns.user_id  
            WHERE interns.user_id = ?";  // Using parameterized query to prevent SQL injection

    // Prepare the statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        // Bind the user's ID to the query
        $stmt->bind_param("i", $user_id);  // "i" denotes an integer parameter for user_id

        // Execute the query
        if ($stmt->execute()) {
            // Get the result
            $result = $stmt->get_result();

            // Check if there are any results (assigned projects)
            if ($result->num_rows > 0) {
                // Loop through the results and display them in the table
                while ($project = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($user_id) . "</td>";  // Displaying user_id
                    echo "<td>" . htmlspecialchars($project['project_name']) . "</td>";

                    // Format the deadline if available
                    $deadline = isset($project['deadline']) ? date('Y-m-d', strtotime($project['deadline'])) : 'N/A';
                    echo "<td>" . htmlspecialchars($deadline) . "</td>";

                    // Display the project status
                    echo "<td>" . (isset($project['status']) ? htmlspecialchars($project['status']) : 'N/A') . "</td>";

                    echo "<td>" . htmlspecialchars($project['faculty']) . "</td>";
                    echo "<td><a href='view_project.php?id=" . urlencode($project['project_id']) . "'>View</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No projects assigned to this intern.</td></tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Error executing query: " . $stmt->error . "</td></tr>";
        }

        $stmt->close();
    } else {
        echo "<tr><td colspan='6'>Error preparing the SQL statement: " . $conn->error . "</td></tr>";
    }
} else {
    echo "<tr><td colspan='6'>You must be logged in to view your projects.</td></tr>";
}

// Close the database connection
$conn->close();
?>
