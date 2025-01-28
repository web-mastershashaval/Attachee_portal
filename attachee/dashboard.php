<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attachee Dashboard</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Global Styles */
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f4f6f9;
  color: #333;
}

.dashboard {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

header {
  background-color: #4CAF50;
  color: white;
  padding: 15px;
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

h1 {
  margin: 0;
}

.navbar {
  display: flex;
  gap: 20px;
}

.navbar a {
  color: white;
  text-decoration: none;
  font-size: 16px;
}

.navbar a:hover {
  text-decoration: underline;
}

.notifications {
  font-size: 14px;
}

main {
  display: flex;
  gap: 20px;
  padding: 20px;
  flex-grow: 1;
}

.dashboard-main {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.dashboard-main .task-list, 
.dashboard-main .daily-log,
.dashboard-main .time-tracking,
.dashboard-main .upcoming-tasks {
  background-color: white;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h2 {
  font-size: 18px;
  margin-bottom: 10px;
}

textarea {
  width: 100%;
  height: 150px;
  padding: 10px;
  font-size: 14px;
  border-radius: 4px;
  border: 1px solid #ddd;
  margin-bottom: 10px;
  resize: none;
}

button {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}

.sidebar {
  width: 250px;
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.sidebar h3 {
  font-size: 16px;
  margin-bottom: 10px;
}

.sidebar ul {
  list-style: none;
  padding: 0;
}

.sidebar ul li {
  margin-bottom: 10px;
}

.sidebar ul li a {
  text-decoration: none;
  color: #4CAF50;
}

footer {
  background-color: #333;
  color: white;
  text-align: center;
  padding: 15px;
}

footer a {
  color: #fff;
  text-decoration: none;
}

footer a:hover {
  text-decoration: underline;
}

  </style>
</head>
<body>
  <div class="dashboard">
    <!-- Header with navigation and notifications -->
    <header>
      <div class="header-content">
        <h1>Attachee Dashboard</h1>
        <nav class="navbar">
          <a href="#">Home</a>
          <a href="#">Profile</a>
          <a href="#">Tasks</a>
          <a href="#">Feedback</a>
          <a href="#">Resources</a>
          <a href="#">Messages</a>
        </nav>
        <div class="notifications">
          <span>🔔 3 New Notifications</span>
        </div>
      </div>
    </header>

    <!-- Main content area -->
    <main>
      <section class="dashboard-main">
        <!-- Current Tasks -->
        <div class="task-list">
          <h2>Current Tasks</h2>
          <ul id="task-list">
            <!-- Dynamic content for tasks -->
          </ul>
        </div>

        <!-- Daily Log Section -->
        <div class="daily-log">
          <h2>Daily Log</h2>
          <textarea id="log-entry" placeholder="Write your daily progress..."></textarea>
          <button onclick="submitLog()">Submit Log</button>
        </div>

        <!-- Time Tracking Section -->
        <div class="time-tracking">
          <h2>Time Tracking</h2>
          <p>Logged Hours: <span id="logged-hours">0</span> hours</p>
          <button onclick="logTime()">Log Time</button>
        </div>

        <!-- Upcoming Tasks Section -->
        <div class="upcoming-tasks">
          <h2>Upcoming Tasks</h2>
          <ul id="upcoming-tasks-list">
            <!-- Dynamic content for upcoming tasks -->
          </ul>
        </div>
      </section>

      <!-- Sidebar with Quick Links and Resources -->
      <aside class="sidebar">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="#">Profile</a></li>
          <li><a href="#">Learning Resources</a></li>
          <li><a href="#">Feedback</a></li>
        </ul>
        <h3>Learning Resources</h3>
        <ul>
          <li><a href="#">Resource 1</a></li>
          <li><a href="#">Resource 2</a></li>
          <li><a href="#">Resource 3</a></li>
        </ul>
      </aside>
    </main>

    <!-- Footer with support and legal information -->
    <footer>
      <p>Contact Support: <a href="mailto:support@example.com">support@example.com</a></p>
      <p>&copy; 2025 Attachee Dashboard | <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a></p>
    </footer>
  </div>

</body>
</html>
<script>
// Sample tasks and upcoming tasks for the dashboard
const tasks = [
  { name: "Task 1", status: "In Progress", deadline: "2025-01-30" },
  { name: "Task 2", status: "Pending", deadline: "2025-02-10" },
  { name: "Task 3", status: "Completed", deadline: "2025-01-20" }
];

const upcomingTasks = [
  { name: "Task 4", deadline: "2025-02-15" },
  { name: "Task 5", deadline: "2025-02-20" }
];

// Function to display current tasks on the dashboard
function displayTasks() {
  const taskList = document.getElementById("task-list");
  taskList.innerHTML = "";

  tasks.forEach((task) => {
    const taskItem = document.createElement("li");
    taskItem.innerHTML = `
      <div><strong>${task.name}</strong></div>
      <div>Status: ${task.status}</div>
      <div>Deadline: ${task.deadline}</div>
    `;
    taskList.appendChild(taskItem);
  });
}

// Function to display upcoming tasks
function displayUpcomingTasks() {
  const upcomingTasksList = document.getElementById("upcoming-tasks-list");
  upcomingTasksList.innerHTML = "";

  upcomingTasks.forEach((task) => {
    const taskItem = document.createElement("li");
    taskItem.innerHTML = `
      <div><strong>${task.name}</strong></div>
      <div>Deadline: ${task.deadline}</div>
    `;
    upcomingTasksList.appendChild(taskItem);
  });
}

// Function to submit the daily log
function submitLog() {
  const logEntry = document.getElementById("log-entry").value;
  if (logEntry) {
    alert("Log Submitted: " + logEntry);
    document.getElementById("log-entry").value = ""; // Clear the log entry field
  } else {
    alert("Please enter something in your daily log.");
  }
}

// Function to log time
let loggedHours = 0;
function logTime() {
  loggedHours += 1; // Simulate logging 1 hour each time
  document.getElementById("logged-hours").textContent = loggedHours;
}

// Initialize the dashboard with tasks and upcoming tasks
document.addEventListener("DOMContentLoaded", function () {
  displayTasks();
  displayUpcomingTasks();
});

</script>
