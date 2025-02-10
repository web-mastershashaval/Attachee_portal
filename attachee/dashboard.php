<?php 
include "../conn.php"; 
session_start(); // Start the session

// Check if the user is logged in by verifying the session variable
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}
include "../supavisor/header.php";
include "tasks.php";
// Retrieve user data from session, with fallbacks in case they aren't set
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';  // Fallback if username is not set
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'No email provided'; // Fallback if email is not set
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'default.jpg'; // Fallback if profile picture is not set

// Debugging - check the session contents
// echo '<pre>';
// var_dump($_SESSION); // Prints all session data for debugging
// echo '</pre>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/spdash.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Profile & Sidebar Section -->
            <div class="col-md-3 side-bar" id="sidebar">
                <div class="profile mb-3">
                    <img id="profile-img" src="../uploads/profile_pictures/<?php echo htmlspecialchars($profile_picture); ?>" alt="profile">
                    <h4 id="user-name" class="ms-3"><?php echo htmlspecialchars($username); ?></h4>
                    <h6 id="user-email"><?php echo htmlspecialchars($email); ?></h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tasks">
                            <i class="fas fa-tasks"></i> My Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#projects">
                            <i class="fas fa-project-diagram"></i> My Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#notifications">
                            <i class="fas fa-bell"></i> Notifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./message.php">
                            <i class="fas fa-envelope"></i> Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">
                            <i class="fas fa-cogs"></i> Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">
                            <i class="fas fa-sign-out-alt"></i> Log out
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content Section -->
            <div class="col-md-9 main" id="mainContent">
            <div class="row top-nav-bar" id="topNavBar">
                   
                    <div class="right-icons">
                         <div class="content-icons menu-icon fas fa-bars" id="menuIcon"></div>
                        <div class="content-icons fas fa-search"></div>
                        <!-- <div class="fas fa-envelope content-icons"></div> -->
                    </div>
                </div>
                <div class="col"><h2>Welcome to your Dashboard</h2></div>

                <div class="row mt-5">
                <div class="col-sm-4 content-col bg-primary text-white">
                    <h6>Total Tasks</h6>
                    <h5><?php echo $total_tasks; ?></h5> <!-- Display total tasks -->
                </div>
                <div class="col-sm-4 content-col bg-success text-white">
                    <h6>Completed Tasks</h6>
                    <h5><?php echo $completed_tasks; ?></h5> <!-- Display completed tasks -->
                </div>
                <div class="col-sm-4 content-col bg-warning text-dark">
                    <h6>Pending Tasks</h6>
                    <h5><?php echo $pending_tasks; ?></h5> <!-- Display pending tasks -->
                </div>
                </div>

               <!-- Tasks Section -->
                <div class="col"><h2 id="tasks" class="headings">My Tasks</h2></div>
                <div class="table-container mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Task Name</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include the database connection and fetch tasks for the logged-in user
                            include('../conn.php');  // Make sure to include your connection file
                            

                            // Assuming the user ID is stored in the session
                            $user_id = $_SESSION['user_id'];

                            // Query to fetch tasks for the logged-in user
                            $query = "SELECT task_name, deadline, status FROM tasks WHERE user_id = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                // Loop through tasks and display them
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['task_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['deadline']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                    echo "<td><button class='btn btn-info'>View</button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                // No tasks found for the user
                                echo "<tr><td colspan='4'>No tasks assigned.</td></tr>";
                            }

                            // Close the connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- Projects Section -->
                <div class="col"><h2 id="projects" class="headings">My Projects</h2></div>
                <div class="table-container mt-4">
                <?php
                    // Initialize error and success message variables
                    $errorMessage = '';
                    $successMessage = '';

                    // Your existing PHP logic here, where you might set these variables
                    // For example, if you have some conditions for success or failure, you can assign values to them:

                    // Example of setting the variables
                    if (isset($someConditionThatFails)) {
                        $errorMessage = "There was an error processing your request.";
                    }

                    if (isset($someConditionThatSucceeds)) {
                        $successMessage = "Your action was successful!";
                    }
                    ?>
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id No</th>
                            <th>Project Name</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Faculty</th>
                            <th>Actions</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php include "projects.php"; ?>
                    </tbody>
                </table>

                <!-- Notifications Section -->
                <div class="col"><h2 id="notifications" class="headings">Notifications</h2></div>
                <div class="table-container mt-4">
                    <ul>
                        <!-- Replace with PHP to display notifications -->
                        <li>New task assigned: Task 1</li>
                        <li>Project update: Project 2 completed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

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
</script>

</html>
