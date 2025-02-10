<?php
// Include the database connection file
include('../conn.php');  // Make sure to include your database connection


// Assuming the user ID is stored in the session
$user_id = $_SESSION['user_id'];  // Replace with the actual session variable for user_id

// Query to get the total number of tasks for the user
$total_query = "SELECT COUNT(*) AS total_tasks FROM tasks WHERE user_id = ?";
$total_stmt = $conn->prepare($total_query);
$total_stmt->bind_param("i", $user_id);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_tasks = $total_row['total_tasks'];  // Store total tasks count

// Query to get the number of completed tasks
$completed_query = "SELECT COUNT(*) AS completed_tasks FROM tasks WHERE user_id = ? AND status = 'Completed'";
$completed_stmt = $conn->prepare($completed_query);
$completed_stmt->bind_param("i", $user_id);
$completed_stmt->execute();
$completed_result = $completed_stmt->get_result();
$completed_row = $completed_result->fetch_assoc();
$completed_tasks = $completed_row['completed_tasks'];  // Store completed tasks count

// Query to get the number of pending tasks
$pending_query = "SELECT COUNT(*) AS pending_tasks FROM tasks WHERE user_id = ? AND status = 'Pending'";
$pending_stmt = $conn->prepare($pending_query);
$pending_stmt->bind_param("i", $user_id);
$pending_stmt->execute();
$pending_result = $pending_stmt->get_result();
$pending_row = $pending_result->fetch_assoc();
$pending_tasks = $pending_row['pending_tasks'];  // Store pending tasks count

// Close the connection
$conn->close();
?>
