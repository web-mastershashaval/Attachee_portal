
<?php
include"../conn.php";
// Fetch and display activity logs from the database
$sql = "SELECT * FROM activity_logs ORDER BY timestamp DESC LIMIT 10";
$result = $conn->query($sql);

// Check if there are any logs to display
if ($result->num_rows > 0) {
    // Start the table for displaying logs
    echo '<table class="table activity-log-table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Timestamp</th>';
    echo '<th>User</th>';
    echo '<th>Action</th>';
    echo '<th>Details</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Loop through and display each log entry
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['timestamp']) . '</td>';
        echo '<td>' . htmlspecialchars($row['user']) . '</td>';
        echo '<td>' . htmlspecialchars($row['action']) . '</td>';
        echo '<td>' . htmlspecialchars($row['details']) . '</td>';
        echo '</tr>';
    }

    // End the table
    echo '</tbody>';
    echo '</table>';
} else {
    // If no logs are found, display a message
    echo '<p>No activity logs found.</p>';
}