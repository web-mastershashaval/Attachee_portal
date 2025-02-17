<?php
include"./dash.php"; 
include_once "./header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
    <link rel="stylesheet" href="../styles/spdash.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="<?php echo isset($_SESSION['selected_theme']) ? $_SESSION['selected_theme'] : 'light-mode'; ?> container-fluid">
        <div class="row">
            <!-- Profile & Sidebar Section -->
            <div class="col-md-3 side-bar" id="sidebar">
                 <div class="profile mb-3">
                 <img id="profile-img" src="../uploads/profile_pictures/"<?php echo htmlspecialchars($profile_picture); ?>" alt="profile">
                    <h4 id="user-name" class="ms-3"><?php echo htmlspecialchars($username); ?></h4>
                    <h6 id="user-email"><?php echo htmlspecialchars($email); ?></h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="sp_dashboard.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reports">
                            <i class="fas fa-chart-line"></i> Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#projects">
                            <i class="fas fa-project-diagram"></i> Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#users">
                            <i class="fas fa-user"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#notifications">
                            <i class="fas fa-bell"></i> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../message.php">
                            <i class="fas fa-envelope"></i> Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../settings.php">
                            <i class="fas fa-cogs"></i> Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="../logout.php">
                            <i class="fas fa-sign-out-alt"></i> Log out
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main Content Section -->
            <div class="col-md-9 main" id="mainContent">
            <div class="row top-nav-bar" id="topNavBar">
                    <div class="content-icons menu-icon fas fa-bars" id="menuIcon"></div>
                    <div class="right-icons">
                        <div class="content-icons fas fa-search"></div>
                        <!-- <div class="fas fa-envelope content-icons"></div> -->
                    </div>
                </div>
                <div class="col"><h2>Intern/Attachee Management Dashboard</h2></div>
                <?php include"totaldes.php";?>
                <div class="row mt-5">
                    <div class="col-sm-3 content-col bg-primary text-white">
                        <h6>Total Interns</h6>
                        <h5><?php echo $total_interns; ?></h5>
                    </div>
                    <div class="col-sm-3 content-col bg-success text-white">
                        <h6>Active Tasks</h6>
                        <h5><?php echo $active_tasks; ?></h5>
                    </div>
                    <div class="col-sm-3 content-col bg-warning text-dark">
                        <h6>Upcoming Tasks</h6>
                        <h5><?php echo $upcoming_tasks; ?></h5>
                    </div>
                    <div class="col-sm-3 content-col bg-danger text-white">
                        <h6>Pending Approvals</h6>
                        <h5><?php echo $pending_approvals; ?></h5>
                    </div>
                </div>
                
                <!-- Charts Section -->
                <div class="col"><h2 id="reports" class="headings">Reports</h2></div>
                <div class="charts-container mt-4">
                    <div class="chart-container">
                        <h4>Intern Performance</h4>
                        <canvas id="internPerformanceChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <h4>Active Tasks Overview</h4>
                        <canvas id="taskOverviewChart"></canvas>
                    </div>
                </div>

                    <!-- Activity Logs Section -->
                    <div class="col"><h2 id="reports" class="headings">Activity Logs</h2></div>
                    <div class="table-container mt-4">
                        <!-- Display the activity logs -->
                        <?php include('get_activity_logs.php'); ?>
                    </div>

                <div class="col"><h2 id="projects" class="headings">Projects</h2></div>
                <!-- Projects Table -->
                <div class="tables-container mt-4">
                    <div class="progress-container">
                        <div class="row">  
                            <div class="col"><h4>Actions needed</h4></div>
                            <div class="progress">
                                <span class="progress-text">70%</span> 
                            </div>
                        </div>
                    </div>

                    <?php
                        // Include the database connection
                        include('../conn.php');

                        // Initialize success and error messages
                        $successMessage = '';
                        $errorMessage = '';

                        // Check if the form is submitted
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['project_name'])) {
                            $project_name = $_POST['project_name'];

                            // Sanitize the input to prevent SQL injection
                            $project_name = $conn->real_escape_string($project_name);

                            // Insert the project into the database
                            $sql = "INSERT INTO projects (name) VALUES ('$project_name')";

                            if ($conn->query($sql) === TRUE) {
                                $successMessage = "Project added successfully!";
                            } else {
                                $errorMessage = "Error: " . $conn->error;
                            }
                        }
                        ?>
                    <!-- Projects Table -->
                <div class="table-container">
                <h4>Projects</h4>
                <!-- Display the data -->
                <button id="addProjectBtn" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProjectModal">Add Project</button>
                <a href="assign_tasks.php" class="btn btn-info" role="button">AssignTasks</a>
                <a href="add_tasks.php" class="btn btn-info" role="button">Add Task</a>
                    <!-- Display success or error messages -->
                    <?php if ($errorMessage): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($errorMessage); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($successMessage): ?>
                        <div class="alert alert-success" role="alert">
                            <?= htmlspecialchars($successMessage); ?>
                        </div>
                    <?php endif; ?>
                <li><a href="">All projects</a></li>
                <table class="projects-table table-striped">
                    <thead>
                        <tr>
                            <th>Id No</th>
                            <th>Attachee Name</th>
                            <th>Project Name</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Faculty</th>
                            <th>Actions</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php include "code.php"; ?>
                    </tbody>
                </table>

            <!-- Intern Table -->
    <div class="col">
        <h2 id="users" class="headings">Users</h2>
    </div>
    <div class="table table-strip intern-table">
        <h4>Attachee/Interns</h4>
        <li><a href="">All interns/Attachees</a></li>
        <button id="addRecordBtn" type="button" class="btn btn-success">Add Record</button>
        <table>
     <thead>
        <tr>
            <th>No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Id No</th>
            <th>Role</th>
            <th>Gender</th>
            <th>Faculty</th>
            <th>Cont Start</th>
            <th>Cont End</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $index = 1; 
        foreach ($internsData as $intern): 
        ?>
            <tr>
                <td><?= $index++; ?></td>
                <td><?= htmlspecialchars(isset($intern['first_name']) ? $intern['first_name'] : ''); ?></td>
                <td><?= htmlspecialchars(isset($intern['last_name']) ? $intern['last_name'] : ''); ?></td>
                <td><?= htmlspecialchars(isset($intern['id_no']) ? $intern['id_no'] : ''); ?></td>
                <td><?= htmlspecialchars(isset($intern['role']) ? $intern['role'] : ''); ?></td>
                <td><?= htmlspecialchars(isset($intern['gender']) ? $intern['gender'] : ''); ?></td>
                <td><?= htmlspecialchars(isset($intern['faculty']) ? $intern['faculty'] : ''); ?></td>
                <td><?= htmlspecialchars(isset($intern['contact_start']) ? $intern['contact_start'] : ''); ?></td>
                <td><?= htmlspecialchars(isset($intern['contact_end']) ? $intern['contact_end'] : ''); ?></td>
                <td>
                    <button class="btn btn-danger" onclick="openDeleteModal('<?= htmlspecialchars($intern['id_no']); ?>')">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    </div>
    </div>
    
    </div>
    <!-- Notifications Section -->
<div class="col"><h2 id="notifications" class="headings">Notifications</h2></div>
                <div class="table-container mt-4">
                    <ul id="notification-list">
                        <!-- Notifications will be appended here -->
                    </ul>
                </div>
    </div>
    

<!-- Add Intern Modal -->
<div class="modal" id="addInternModal" tabindex="-1" role="dialog" aria-labelledby="addInternModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInternModalLabel">Add Intern</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addInternForm" action="" method="POST">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="idNo">ID No</label>
                        <input type="text" class="form-control" id="idNo" name="id_no" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <input type="text" class="form-control" id="role" name="role" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <input type="text" class="form-control" id="gender" name="gender" required>
                    </div>
                    <div class="form-group">
                        <label for="faculty">Faculty</label>
                        <input type="text" class="form-control" id="faculty" name="faculty" required>
                    </div>
                    <div class="form-group">
                        <label for="contactStart">Contact Start</label>
                        <input type="date" class="form-control" id="contactStart" name="contact_start" required>
                    </div>
                    <div class="form-group">
                        <label for="contactEnd">Contact End</label>
                        <input type="date" class="form-control" id="contactEnd" name="contact_end" required>
                    </div>
                    <button type="submit" class="btn btn-success">Save Intern</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Intern Modal -->
<div class="modal" id="deleteInternModal" tabindex="-1" role="dialog" aria-labelledby="deleteInternModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteInternModalLabel">Delete Intern</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this intern?</p>
                <form id="deleteInternForm" action="delete_intern.php" method="POST">
                    <input type="hidden" name="intern_id" id="internId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php
// Include the database connection
include('../conn.php');

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['intern_id']) && isset($_POST['project_id'])) {
    $internId = $_POST['intern_id'];  // Intern ID (id_no)
    $projectId = $_POST['project_id']; // Project ID

    // Sanitize inputs to prevent SQL injection
    $internId = $conn->real_escape_string($internId);
    $projectId = $conn->real_escape_string($projectId);

    // SQL query to assign project to intern
    $sql = "UPDATE interns SET project_id = '$projectId' WHERE id_no = '$internId'";

    if ($conn->query($sql) === TRUE) {
        echo "Project assigned successfully.";

        // Optionally, log the activity here
        log_activity($username, 'Assign Project', "Assigned project ID $projectId to intern ID $internId");
        
        // Redirect back to the dashboard or refresh the page
        header('Location: sp_dashboard.php');
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Missing intern ID or project ID.";
}
?>


<!-- Modal for Assigning Intern to a Project -->
<div class="modal" id="assignProjectModal" tabindex="-1" role="dialog" aria-labelledby="assignProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignProjectModalLabel">Assign Project to Intern</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="assignProjectForm" action="assign_projects.php" method="POST">
                    <div class="form-group">
                        <label for="projectSelect">Select Project</label>
                        <select class="form-control" id="projectSelect" name="project_id">
                            <?php
                                // Fetch available projects from the database
                                $projects = []; // Replace this with your actual fetching of projects from the database
                                $sql = "SELECT id, name FROM projects"; // Sample SQL query, replace it with your actual one
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" id="internId" name="intern_id">
                    <button type="submit" class="btn btn-primary">Assign Project</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Add Project Modal -->
<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProjectForm" method="POST">
                    <div class="mb-3">
                        <label for="project_name" class="form-label">Project Name</label>
                        <input type="text" name="project_name" id="project_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Project</button>
                </form>
            </div>
        </div>
    </div>
</div>




 <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (Bootstrap dependency) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Other JS libraries (e.g., Chart.js) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Your custom JS script (spjs.js) -->
<script src="../styles/spjs.js"></script>

    
    
    <script>
       // Function to open the delete confirmation modal
    function openDeleteModal(internId) {
        // Set the intern_id value in the hidden field
        document.getElementById('internId').value = internId;
        // Show the modal
        $('#deleteInternModal').modal('show');
    }

     // Open the Add Intern modal when the "Add Record" button is clicked
     $('#addRecordBtn').click(function() {
        $('#addInternModal').modal('show');
    });

    $('#addInternForm').on('submit', function(e) {
    e.preventDefault(); // Prevent form from submitting normally

    // AJAX request to submit the form
    $.ajax({
        type: "POST",
        url: "dash.php",
        data: $(this).serialize(),
        success: function(response) {
            alert('Intern added successfully!');
            $('#addInternModal').modal('hide'); // Close the modal
            location.reload(); // Refresh the page to show new data
        }
    });
});

        // Data for Intern Performance Chart
        const internPerformanceChart = document.getElementById('internPerformanceChart').getContext('2d');
        new Chart(internPerformanceChart, {
            type: 'bar',
            data: {
                labels: ['John Doe', 'Jane Smith', 'Samba Ernest'],
                datasets: [{
                    label: 'Performance Score',
                    data: [80, 75, 85],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Data for Task Overview Chart
        const taskOverviewChart = document.getElementById('taskOverviewChart').getContext('2d');
        new Chart(taskOverviewChart, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Active Tasks',
                    data: [10, 12, 15, 20],
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.1
                }]
            }
        });

   
    function openAssignModal(internId) {
    // Set the internId in the hidden field in the modal
    document.getElementById('internId').value = internId;

    // Show the modal
    $('#assignProjectModal').modal('show');
}


// Close the modal
function closeModal() {
    $('#assignProjectModal').modal('hide');
}

  // Get the button that opens the modal
 var addRecordBtn = document.getElementById('addProjectBtn');

// Get the modal
var addProjectModal = new bootstrap.Modal(document.getElementById('addProjectModal'));

// When the "Add Project" button is clicked, show the modal
addProjectBtn.addEventListener('click', function() {
    addProjectModal.show();  // This opens the modal programmatically
});

function fetchNotifications() {
        fetch('notify.php')  // Replace with the correct PHP script to fetch notifications
            .then(response => response.json())
            .then(data => {
                const notificationList = document.getElementById('notification-list');
                notificationList.innerHTML = '';  // Clear previous notifications
                data.forEach(notification => {
                    const li = document.createElement('li');
                    li.classList.add('notification');
                    li.innerHTML = notification.message;
                    li.addEventListener('click', function() {
                        markAsRead(notification.id);
                    });
                    notificationList.appendChild(li);
                });
            })
            .catch(error => console.log('Error fetching notifications:', error));
    }

    function markAsRead(notificationId) {
        fetch('mark_as_read.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ notification_id: notificationId })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Notification marked as read', data);
            fetchNotifications();  // Refresh notifications list
        })
        .catch(error => console.log('Error marking notification as read:', error));
    }

    // Fetch notifications every 5 seconds
    setInterval(fetchNotifications, 5000);
    // Fetch notifications initially
    fetchNotifications();


    </script>

</body>
</html>
