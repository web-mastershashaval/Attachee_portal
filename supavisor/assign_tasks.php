<?php
// Include the database connection file
include('../conn.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Check for successful connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch interns from the database
$interns_query = "SELECT id_no, last_name FROM interns"; 
$interns_result = $conn->query($interns_query);

// Check if there are interns
if ($interns_result->num_rows <= 0) {
    $interns_message = "No interns found.";
}

// Fetch tasks that are not assigned yet (status = 'Pending' and user_id is NULL)
$tasks_query = "SELECT id, task_name FROM tasks WHERE status = 'Pending' AND user_id IS NULL";
$tasks_result = $conn->query($tasks_query);

// Check if there are tasks to assign
if ($tasks_result->num_rows <= 0) {
    $tasks_message = "No tasks available for assignment.";
}

// Handle the form submission to assign the task
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = $_POST['task_id'];
    $intern_id_no = $_POST['intern_id'];  // id_no of the intern selected

    // Ensure both task_id and intern_id are provided
    if (!empty($task_id) && !empty($intern_id_no)) {
        // Fetch the corresponding user_id from the interns table
        $get_user_id_query = "SELECT user_id FROM interns WHERE id_no = ?";
        $stmt = $conn->prepare($get_user_id_query);
        $stmt->bind_param("i", $intern_id_no); // Assuming id_no is an integer
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        // If the user_id is found, proceed to assign the task
        if ($user_id) {
            // Assign the intern to the task
            $assign_query = "UPDATE tasks SET user_id = ? WHERE id = ?";
            $stmt = $conn->prepare($assign_query);
            
            if ($stmt === false) {
                die("Error in preparing the query: " . $conn->error);
            }

            // Bind parameters and execute the statement
            $stmt->bind_param("ii", $user_id, $task_id);

            if ($stmt->execute()) {
                $message = "Intern successfully assigned to the task.";
            } else {
                $message = "Failed to assign intern to the task: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Selected intern does not exist.";
        }
    } else {
        $message = "Please select both a task and an intern.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Task to Intern</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJvP7t4z+RQmzSXnUfp2u2MlqYYfEZV4E2MljHgFftXlDQIzD+1YjciER6t7" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            padding: 80px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #343a40;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
        .form-group {
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
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            font-weight: 600;
            padding: 10px 20px;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #218838;
        }
        .alert {
            margin-bottom: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Assign Task to Intern</h2>

        <!-- Display any messages -->
        <?php if (isset($message)) { echo "<div class='alert alert-info'>$message</div>"; } ?>
        <?php if (isset($interns_message)) { echo "<div class='alert alert-warning'>$interns_message</div>"; } ?>
        <?php if (isset($tasks_message)) { echo "<div class='alert alert-warning'>$tasks_message</div>"; } ?>

        <!-- Task Assignment Form -->
        <form method="POST">
            <div class="form-group">
                <label for="task_id" class="form-label">Select Task:</label>
                <select name="task_id" id="task_id" class="form-control" required>
                    <option value="">Select Task</option>
                    <?php while ($task = $tasks_result->fetch_assoc()) { ?>
                        <option value="<?php echo $task['id']; ?>"><?php echo $task['task_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="intern_id" class="form-label">Select Intern:</label>
                <select name="intern_id" id="intern_id" class="form-control" required>
                    <option value="">Select Intern</option>
                    <?php
                    if ($interns_result->num_rows > 0) {
                        while ($intern = $interns_result->fetch_assoc()) { ?>
                            <option value="<?php echo $intern['id_no']; ?>"><?php echo $intern['last_name']; ?></option>
                        <?php }
                    } else {
                        echo "<option>No interns available</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success btn-lg btn-block">Assign Task</button>
        </form>
        <br>
        <a href="sp_dashboard.php">Back</a>
    </div>

    <!-- Bootstrap 5 JS and Popper.js (if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
