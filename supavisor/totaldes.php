<?php
include_once "../conn.php";

// Fetch total interns
$total_interns_sql = "SELECT COUNT(*) AS total_interns FROM interns";
$total_interns_result = $conn->query($total_interns_sql);
$total_interns = ($total_interns_result && $total_interns_result->num_rows > 0) ? $total_interns_result->fetch_assoc()['total_interns'] : 0;

// Fetch active tasks (assuming active tasks have 'status' = 'active')
$active_tasks_sql = "SELECT COUNT(*) AS active_tasks FROM tasks WHERE status = 'active'";
$active_tasks_result = $conn->query($active_tasks_sql);
$active_tasks = ($active_tasks_result && $active_tasks_result->num_rows > 0) ? $active_tasks_result->fetch_assoc()['active_tasks'] : 0;

// Fetch upcoming tasks (assuming 'deadline' is the field to check for upcoming tasks)
$upcoming_tasks_sql = "SELECT COUNT(*) AS upcoming_tasks FROM tasks WHERE deadline > NOW()";
$upcoming_tasks_result = $conn->query($upcoming_tasks_sql);
$upcoming_tasks = ($upcoming_tasks_result && $upcoming_tasks_result->num_rows > 0) ? $upcoming_tasks_result->fetch_assoc()['upcoming_tasks'] : 0;

// Fetch pending approvals (assuming there is a task_approvals table with a 'status' column indicating 'pending')
$pending_approvals_sql = "SELECT COUNT(*) AS pending_approvals FROM task_approvals WHERE status = 'pending'";
$pending_approvals_result = $conn->query($pending_approvals_sql);
$pending_approvals = ($pending_approvals_result && $pending_approvals_result->num_rows > 0) ? $pending_approvals_result->fetch_assoc()['pending_approvals'] : 0;
?>