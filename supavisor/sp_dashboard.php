<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
    <title>Admin Dashboard</title>
    <style>
        .side-bar {
            background-color: rgb(19, 21, 32);
            color: white;
            padding: 10px 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            width: 15vw;
            transition: transform 0.3s ease;
        }

        .side-bar.hidden {
            transform: translateX(-100%);
        }

        .side-bar li a {
            color: white;
            text-decoration: none;
        }

        .nav-item {
            list-style: none;
            padding: 8px 15px;
        }

        .nav-item a:hover {
            background-color: aliceblue;
            color: black;
        }

        #profile-img {
            border-radius: 100%;
            width: 100px;
            height: 100px;
            vertical-align: middle;
            margin-left: 34px;
        }

        #profile-img:hover {
            padding: 50px;
            transition: transform .2s;
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }
        .headings{
            margin-top: 107px ;
        }
 
        #user-name,
        #user-email {
            margin-left: 15px;
            align-content: center;
        }

        .profile {
            margin: 72px 4px;
            padding: 4px 20px;
            align-items: center;
            width: 100%;
        }

        .main {
            margin-left: 20vw;
            padding: 20px;
            padding-top: 80px;
            transition: margin-left 0.3s ease;
        }

        .main.expanded {
            margin-left: 0;
        }

        .content-col {
            padding: 20px;
            text-align: center;
            border-radius: 8px;
        }

        .top-nav-bar {
            position: fixed;
            top: 0;
            left: 16vw;
            width: 85vw;
            background-color: whitesmoke;
            z-index: 1000;
            box-shadow: 0 4px 2px -2px gray;
            display: flex;
            justify-content: space-between;
            padding: 10px;
            transition: left 0.3s ease;
        }

        .top-nav-bar.expanded {
            left: 0;
            width: 100vw;
        }

        .content-icons {
            padding: 10px;
            background-color: lightgray;
            margin: 5px;
            text-align: center;
            border-radius: 8px;
        }

        /* To keep the menu icon on the left */
        .menu-icon {
            margin-right: auto;
        }

        /* To keep the 'Such' and 'Message' icons on the right */
        .right-icons {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        /* Circular Progress Bar */
        .progress-container{
            height: 35vh;
            width: 260px;
            box-shadow: 0 5px 3px -3px black;
        }

        .progress {
            position: relative;
            margin:34px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(#ffcc00 0% 70%, #e6e6e6 70% 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 24px;
            color: black;
        }

        .progress-text {
            position: absolute;
            font-size: 20px;
            color: black;
            font-weight: bold;
        }

        /* Projects Table Styling */
        .table-container,
        .intern-table {
            height: auto; /* Adjusted height */
            width: 100%; /* Ensure table stretches to fill available space */
            box-shadow: 0 5px 3px -3px black;
            margin-top: 150px;
            table-layout: fixed; /* Ensures even distribution of columns */
        }

        .intern-table th, .intern-table td {
            text-align: left;
            padding: 16px;
            word-wrap: break-word; /* Prevents overflow */
        }

         .intern-table tr:hover {
            text-align: left;
            background-color: blue;
            color:#e6e6e6;
        }

        .intern-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        /* Flex container for positioning progress bar and projects table side by side */
        .tables-container {
            display: flex;
            align-items: stretch;
        }

        .tables-container .progress-container {
            flex: 0 0 auto;
            margin-right: 20px; /* Space between progress bar and table */
        }

        .tables-container .table-container {
            flex: 1;
            margin-top: 10px;
        }
        
        th, td {
            text-align: left;
            padding: 16px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .charts-container {
            display: flex;
            justify-content: space-between;
        }

        .chart-container {
            width: 45%;
        }

        /* Activity Logs Table */
        .activity-log-table th, .activity-log-table td {
            text-align: left;
            padding: 16px;
        }

        .activity-log-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Profile & Sidebar Section -->
            <div class="col-md-3 side-bar" id="sidebar">
                <div class="profile mb-3">
                    <img id="profile-img" src="/img/back.png" alt="profile">
                    <h4 id="user-name" class="ms-3">Username</h4>
                    <h6 id="user-email">usermail@gmail.com</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="sp_dashboard.html">
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
                        <a class="nav-link" href="/message.html">
                            <i class="fas fa-envelope"></i> Messages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
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
                        <button type="button" class="btn btn-success">Add Recode</button>
                        <button type="button" class="btn btn-danger" >Delete Recode</button>
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
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>dse-01-4117/2022</td>
                                    <td>Samba Ernest</td>
                                    <td>Attachee portal</td>
                                    <td>21/4/2025</td>
                                    <td>In progress</td>
                                    <td>Software and Networking dpt</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>dse-01-4117/2022</td>
                                    <td>Samba Ernest</td>
                                    <td>Attachee portal</td>
                                    <td>21/4/2025</td>
                                    <td>In progress</td>
                                    <td>Software and Networking dpt</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>dse-01-4117/2022</td>
                                    <td>Samba Ernest</td>
                                    <td>Attachee portal</td>
                                    <td>21/4/2025</td>
                                    <td>In progress</td>
                                    <td>Software and Networking dpt</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Intern Table -->
                <div class="col"><h2 id="users" class="headings">Users</h2></div>
                <div class="table table-strip intern-table">
                    <h4>Attachee/Interns</h4>
                    <li><a href="">All interns/Attachees</a></li>
                    <button type="button" class="btn btn-success">Add Recode</button>
                    <button type="button" class="btn btn-danger" >Delete Recode</button>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Id No</th>
                                <th>Role</th>
                                <th>Gender</th>
                                <th>Project</th>
                                <th>Faculty</th>
                                <th>Cont Start</th>
                                <th>Cont End</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John</td>
                                <td>Doe</td>
                                <td>dse-01-1234/2022</td>
                                <td>Attachee</td>
                                <td>Male</td>
                                <td>Project A</td>
                                <td>Software</td>
                                <td>01/01/2025</td>
                                <td>01/01/2026</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane</td>
                                <td>Smith</td>
                                <td>dse-01-5678/2022</td>
                                <td>Intern</td>
                                <td>Female</td>
                                <td>Project B</td>
                                <td>Networking</td>
                                <td>02/01/2025</td>
                                <td>02/01/2026</td>
                            </tr>
                        </tbody>
                    </table>
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
    </script>
</body>
</html>
