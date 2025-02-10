<?php
// Include the database connection
include('../conn.php');

// Initialize error and success messages
$errorMessage = '';
$successMessage = '';

// Check if the intern ID is passed via GET for editing
if (isset($_GET['id_no'])) {
    $internId = $conn->real_escape_string($_GET['id_no']); // Sanitize the intern ID

    // Fetch intern details and project details from the database
    $sql = "SELECT interns.*, projects.deadline, projects.status FROM interns 
            LEFT JOIN projects ON interns.project_id = projects.id
            WHERE interns.id_no = '$internId'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $intern = $result->fetch_assoc(); // Fetch intern details along with project details
        } else {
            $errorMessage = "Intern not found.";  // Handle case where no intern is found
        }
    } else {
        $errorMessage = "Error executing query: " . $conn->error;  // Handle query failure
    }
} else {
    $errorMessage = "Intern ID is missing.";  // Handle missing intern ID
}

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $faculty = $_POST['faculty'];
    $contact_start = $_POST['contact_start'];
    $contact_end = $_POST['contact_end'];
    $project_id = $_POST['project_id'];
    $status = $_POST['status']; // New field for project status
    $deadline = $_POST['deadline']; // New field for project deadline
    $id_no = $_POST['id_no']; // Hidden field for intern ID

    // Sanitize inputs to prevent SQL injection
    $first_name = $conn->real_escape_string($first_name);
    $last_name = $conn->real_escape_string($last_name);
    $gender = $conn->real_escape_string($gender);
    $faculty = $conn->real_escape_string($faculty);
    $contact_start = $conn->real_escape_string($contact_start);
    $contact_end = $conn->real_escape_string($contact_end);
    $project_id = $conn->real_escape_string($project_id);
    $status = $conn->real_escape_string($status);
    $deadline = $conn->real_escape_string($deadline);

    // SQL query to update intern and project details
    $sql = "UPDATE interns 
            SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', 
                faculty = '$faculty', contact_start = '$contact_start', contact_end = '$contact_end', project_id = '$project_id' 
            WHERE id_no = '$id_no'";

    if ($conn->query($sql) === TRUE) {
        // If project info is updated, update the projects table as well
        $updateProjectSql = "UPDATE projects 
                             SET status = '$status', deadline = '$deadline' 
                             WHERE id = '$project_id'";

        if ($conn->query($updateProjectSql) === TRUE) {
            $successMessage = "Intern details and project details updated successfully!";
        } else {
            $errorMessage = "Error updating project details: " . $conn->error;
        }
    } else {
        $errorMessage = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Intern Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Intern Details</h2>

    <!-- Display error message if any -->
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <!-- Display success message if any -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($intern)): ?>
        <!-- Edit Intern Form -->
        <form action="edit_intern.php" method="POST">
            <input type="hidden" name="id_no" value="<?= htmlspecialchars($intern['id_no']) ?>">

            <!-- First Name -->
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="<?= htmlspecialchars($intern['first_name']) ?>" required>
            </div>

            <!-- Last Name -->
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="<?= htmlspecialchars($intern['last_name']) ?>" required>
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender" class="form-select" required>
                    <option value="female" <?= $intern['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                    <option value="male" <?= $intern['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                    <option value="other" <?= $intern['gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>

            <!-- Faculty -->
            <div class="mb-3">
                <label for="faculty" class="form-label">Faculty</label>
                <input type="text" name="faculty" id="faculty" class="form-control" value="<?= htmlspecialchars($intern['faculty']) ?>" required>
            </div>

            <!-- Contact Start Date -->
            <div class="mb-3">
                <label for="contact_start" class="form-label">Contact Start</label>
                <input type="date" name="contact_start" id="contact_start" class="form-control" value="<?= htmlspecialchars($intern['contact_start']) ?>" required>
            </div>

            <!-- Contact End Date -->
            <div class="mb-3">
                <label for="contact_end" class="form-label">Contact End</label>
                <input type="date" name="contact_end" id="contact_end" class="form-control" value="<?= htmlspecialchars($intern['contact_end']) ?>" required>
            </div>

            <!-- Project Assignment -->
            <div class="mb-3">
                <label for="project_id" class="form-label">Assign Project</label>
                <select name="project_id" id="project_id" class="form-select" required>
                    <option value="">Select Project</option>
                    <?php
                    // Fetch available projects from the database
                    $projectQuery = "SELECT id, name FROM projects";
                    $projectResult = $conn->query($projectQuery);
                    while ($project = $projectResult->fetch_assoc()) {
                        echo "<option value='" . $project['id'] . "' " . ($project['id'] == $intern['project_id'] ? 'selected' : '') . ">" . $project['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Project Deadline -->
            <div class="mb-3">
                <label for="deadline" class="form-label">Project Deadline</label>
                <input type="date" name="deadline" id="deadline" class="form-control" value="<?= htmlspecialchars($intern['deadline']) ?>" required>
            </div>

            <!-- Project Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Project Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="active" <?= $intern['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="completed" <?= $intern['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="pending" <?= $intern['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Intern</button>
        </form>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">
            Intern ID not found or invalid.
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
