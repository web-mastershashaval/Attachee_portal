<?php include "dash.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
    <link rel="stylesheet" href="/styles/spdash.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="<?php echo isset($_SESSION['selected_theme']) ? $_SESSION['selected_theme'] : 'light-mode'; ?> container-fluid">
        <div class="row">
            <!-- Profile & Sidebar Section -->
            <div class="col-md-3 side-bar" id="sidebar">
                <div class="profile mb-3">
                    <img id="profile-img" src="/img/back.png" alt="profile">
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
                        <a class="nav-link" href="#">
                            <i class="fas fa-bell"></i> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/message.php">
                            <i class="fas fa-envelope"></i> Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/settings.php">
                            <i class="fas fa-cogs"></i> Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-sign-out-alt"></i> Log out
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main Content Section -->
            <div class="col-md-9 main" id="mainContent">
                <div class="col"><h2>Intern/Attachee Management Dashboard</h2></div>
                <div class="row top-nav-bar" id="topNavBar">
                    <div class="content-icons menu-icon fas fa-bars" id="menuIcon"></div>
                    <div class="right-icons">
                        <div class="content-icons fas fa-search"></div>
                        <div class="fas fa-envelope content-icons"></div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-sm-3 content-col bg-primary text-white">
                        <h6>Total Interns</h6>
                        <h5>25</h5>
                    </div>
                    <div class="col-sm-3 content-col bg-success text-white">
                        <h6>Active Tasks</h6>
                        <h5>22</h5>
                    </div>
                    <div class="col-sm-3 content-col bg-warning text-dark">
                        <h6>Upcoming Tasks</h6>
                        <h5>6</h5>
                    </div>
                    <div class="col-sm-3 content-col bg-danger text-white">
                        <h6>Pending Approvals</h6>
                        <h5>2</h5>
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
                    <table class="table activity-log-table table-striped">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2025-01-25 12:45:00</td>
                                <td>Admin</td>
                                <td>Login</td>
                                <td>Admin logged into the dashboard</td>
                            </tr>
                            <tr>
                                <td>2025-01-25 13:30:00</td>
                                <td>John Doe</td>
                                <td>Task Update</td>
                                <td>John Doe updated Task #102</td>
                            </tr>
                            <tr>
                                <td>2025-01-25 14:00:00</td>
                                <td>Admin</td>
                                <td>Project Added</td>
                                <td>Added a new project: Attachee Portal</td>
                            </tr>
                        </tbody>
                    </table>
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

                    <!-- Projects Table -->
                <div class="table-container">
                <h4>Projects</h4>
                <li><a href="">All projects</a></li>
                <button type="button" class="btn btn-success">Add Record</button>
                <table class="projects-table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Id No</th>
                            <th>Attachee Name</th>
                            <th>Project Name</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Faculty</th>
                            <th>Actions</th> <!-- Action column for buttons -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be dynamically inserted by JavaScript -->
                        <td><?= htmlspecialchars(isset($intern['id_no']) ? $intern['id_no'] : ''); ?></td>
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
                    <?php if (empty($intern['project'])): ?>
                        <button class="btn btn-primary" onclick="openAssignModal('<?= htmlspecialchars($intern['id_no']); ?>')">Assign Intern</button>
                    <?php else: ?>
                        <span>Assigned to Project</span>
                    <?php endif; ?>
                    <button class="btn btn-danger" onclick="openDeleteModal('<?= htmlspecialchars($intern['id_no']); ?>')">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    </div>
            </div>
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
                <form id="addInternForm" action="addintern.php" method="POST">
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
                    <div class="form-group">y>
                    <!-- Data will be dynamically inserted by JavaScript -->
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

<!-- Add Intern Button -->
<button id="addRecordBtn" type="button" class="btn btn-success" data-toggle="modal" data-target="#addInternModal">Add Record</button>

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
                <form id="deleteInternForm" method="POST">
                    <input type="hidden" name="intern_id" id="internId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
                <form id="assignProjectForm">
                    <div class="form-group">
                        <label for="projectSelect">Select Project</label>
                        <select class="form-control" id="projectSelect" name="project">
                            <!-- Projects will be populated dynamically using JavaScript -->
                        </select>
                    </div>
                    <input type="hidden" id="internId" name="intern_id">
                    <button type="submit" class="btn btn-primary">Assign Project</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Optional Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    
    <script>
        // Toggle Sidebar
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const topNavBar = document.getElementById('topNavBar');
        const menuIcon = document.getElementById('menuIcon');

        menuIcon.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            mainContent.classList.toggle('expanded');
            topNavBar.classList.toggle('expanded');
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
     });

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

    // Optional: If you want to handle form submission via Ajax to prevent a full page reload
    $('#addInternForm').submit(function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Gather form data
    var formData = $(this).serialize();
    
    // Log the form data to the console for debugging
    console.log(formData);

    // Submit the form data using Ajax
    $.ajax({
        url: 'addintern.php', // The PHP file to handle form submission
        type: 'POST',
        data: formData,
        success: function(response) {
            console.log(response);  // Log the response from the server
            var result = JSON.parse(response);
            if (result.success) {
                alert("Intern added successfully!");
                location.reload(); // Reload the page to show the updated list
            } else {
                alert("Failed to add intern: " + result.message);
            }
        },
        error: function(xhr, status, error) {
            alert("An error occurred: " + error);
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

    fetch('fetch_projects.php')
    .then(response => response.json())
    .then(data => {
        // Check if there is an error in the data
        if (data.error) {
            console.error(data.error);
            alert(data.error); // Display the error on the frontend
            return;
        }

        const tableBody = document.querySelector('.projects-table tbody');
        tableBody.innerHTML = ''; // Clear existing rows before adding new ones

        // If no data is available
        if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="8">No projects available.</td></tr>';
            return;
        }

        // Loop through the data and create table rows
        data.forEach((project, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>require 'vendor/autoload.php';
                <td>${project.id_no}</td>
                <td>${project.attachee_name}</td>
                <td>${project.project_name}</td>
                <td>${project.deadline}</td>
                <td>${project.status}</td>
                <td>${project.faculty}</td>
                <td><button class="btn btn-primary">View Details</button></td>
            `;
            tableBody.appendChild(row);
        });
    })
    .catch(error => {
        console.error('Error fetching project data:', error);
        const tableBody = document.querySelector('.projects-table tbody');
        tableBody.innerHTML = '<tr><td colspan="8">Error loading data.</td></tr>';
    });
   

 // Open the Assign Project Modal
 function openAssignModal(internId) {
    // Populate the modal with intern data and project options
    document.getElementById('internId').value = internId;

    // Fetch projects from the backend and populate the dropdown
    fetch('/supavisor/get_projects.php')
        .then(response => response.json())
        .then(data => {
            const projectSelect = document.getElementById('projectSelect');
            data.forEach(project => {
                const option = document.createElement('option');
                option.value = project.id; // MongoDB project _id
                option.textContent = project.name;
                projectSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching projects:', error));

    // Show the modal
    $('#assignProjectModal').modal('show');
}



// Open the modal and load projects when the "Assign Intern" button is clicked
function openAssignModal(internId) {
    // Set the intern ID in the hidden input field
    document.getElementById('internId').value = internId;
    
    // Load the projects dynamically
    loadProjects();

    // Show the modal
    const modal = document.getElementById('assignProjectModal');
    modal.style.display = 'block';
}

// Close the modal
function closeModal() {
    const modal = document.getElementById('assignProjectModal');
    modal.style.display = 'none';
}

document.getElementById('assignProjectForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const internId = document.getElementById('internId').value;
    const projectId = document.getElementById('projectSelect').value;

    if (projectId === "") {
        alert("Please select a project!");
        return;
    }

    const formData = new FormData();
    formData.append('intern_id', internId);
    formData.append('project_id', projectId);

    // Send the data to the server
    fetch('/supavisor/assign_project.php', { // Create a new PHP script to handle the update
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Project assigned successfully!");
            // Optionally refresh the page or close the modal
            location.reload(); // This will reload the page to reflect changes
        } else {
            alert("Error assigning project!");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong, please try again.");
    });
});


    </script>

</body>
</html>
