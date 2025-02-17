<?php
// Include the database connection
include('../conn.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $task_name = $_POST['task_name'];
    $descriptions = $_POST['task_description'];  // This should match the name attribute in the form
    $task_deadline = $_POST['task_deadline'];

    // Insert the new task into the database
    $query = "INSERT INTO tasks (task_name, descriptions, deadline, status) 
              VALUES (?, ?, ?, 'Pending')";

    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        // Print the error message if the query preparation fails
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param("sss", $task_name, $descriptions, $task_deadline);

    if ($stmt->execute()) {
        // Redirect to the task assignment page or dashboard
        header("Location: assign_tasks.php"); 
        exit();
    } else {
        // Handle errors if the task is not inserted
        echo "Error adding task: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Task</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJvP7t4z+RQmzSXnUfp2u2MlqYYfEZV4E2MljHgFftXlDQIzD+1YjciER6t7" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            height: 100vh; /* Full viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #343a40;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .form-control {
            border-radius: 8px;
            box-shadow: none;
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(38, 143, 255, 0.5);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: 600;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .d-grid {
            margin-top: 20px;
        }
        .form-control::placeholder {
            color: #6c757d;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Add Task Form -->
    <div class="container">
        <h2>Add New Task</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="task_name" class="form-label">Task Name:</label>
                <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Enter task name" required>
            </div>
            <div class="mb-3">
                <label for="descriptions" class="form-label">Task Description:</label>
                <textarea class="form-control" id="descriptions" name="task_description" rows="4" placeholder="Enter task description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="task_deadline" class="form-label">Task Deadline:</label>
                <input type="date" class="form-control" id="task_deadline" name="task_deadline" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Add Task</button>
            </div>
        </form>
        <br>
        <li><a href="sp_dashboard.php">back</a></li>
    </div>

    <!-- Bootstrap 5 JS and Popper.js (if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
