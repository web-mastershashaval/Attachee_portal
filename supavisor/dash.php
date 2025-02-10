<?php
// Start the session to track user activities
session_start();

// Include the database connection
include('../conn.php');

// Function to log activity in the database
function log_activity($user, $action, $details) {
    global $conn;  // Access the global database connection

    // Prepare the SQL statement to insert a new log entry
    $stmt = $conn->prepare("INSERT INTO activity_logs (user, action, details) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $action, $details); // Bind parameters to the prepared statement

    // Execute the statement
    $stmt->execute();

    // Close connections
    $stmt->close();
}

// Check if the user is logged in (using session)
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Sanitize the user input to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Fetch user data from the database
    $sql = "SELECT * FROM users WHERE id = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        $username = $user['username'];
        $email = $user['email'];

        // Log the activity: User logged in
        log_activity($username, 'Login', 'User logged into the system.');

        // Display user information
        echo "Username: " . htmlspecialchars($username) . "<br>";
        echo "Email: " . htmlspecialchars($email) . "<br>";

    } else {
        echo "User not found.<br>";
    }
} else {
    // If the user is not logged in, redirect to the login page
    header('Location: login.php');
    exit;
}
// Query to fetch the user data including profile_picture
$query = "SELECT username, email, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $profile_picture);
$stmt->fetch();
$stmt->close();

// If the user has a profile picture, display it; otherwise, use a default image
$profile_picture_path = (!empty($profile_picture)) ? "uploads/profile_pictures/$profile_picture" : "../img/gtr.jpg"; // Default image if no picture is set

// Handle form submission for adding an intern
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form inputs to prevent SQL injection
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $id_no = $conn->real_escape_string($_POST['id_no']);
    $role = $conn->real_escape_string($_POST['role']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $faculty = $conn->real_escape_string($_POST['faculty']);
    $contact_start = $conn->real_escape_string($_POST['contact_start']);
    $contact_end = $conn->real_escape_string($_POST['contact_end']);

    // Check if all fields are filled
    if (empty($first_name) || empty($last_name) || empty($id_no) || empty($role) || empty($gender) || empty($faculty) || empty($contact_start) || empty($contact_end)) {
        echo "Please fill all required fields.";
        exit;
    }

    // SQL query to insert intern data
    $sql = "INSERT INTO interns (first_name, last_name, id_no, role, gender, faculty, contact_start, contact_end)
            VALUES ('$first_name', '$last_name', '$id_no', '$role', '$gender', '$faculty', '$contact_start', '$contact_end')";

    if ($conn->query($sql) === TRUE) {
        // Log the activity: Added a new intern
        log_activity($username, 'Add Intern', 'Added new intern: ' . $first_name . ' ' . $last_name);

        // Redirect to the dashboard (or you can choose to stay on the same page)
        header('Location: sp_dashboard.php');
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle intern deletion
if (isset($_GET['delete_intern_id'])) {
    // Sanitize the intern ID to prevent SQL injection
    $intern_id = $conn->real_escape_string($_GET['delete_intern_id']);

    // Fetch the intern's name before deleting for logging purposes
    $sql = "SELECT first_name, last_name FROM interns WHERE id = '$intern_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $intern = $result->fetch_assoc();
        $intern_name = $intern['first_name'] . ' ' . $intern['last_name'];

        // SQL query to delete the intern
        $sql = "DELETE FROM interns WHERE id = '$intern_id'";

        if ($conn->query($sql) === TRUE) {
            // Log the activity: Deleted an intern
            log_activity($username, 'Delete Intern', 'Deleted intern: ' . $intern_name);

            // Redirect back to the dashboard
            header('Location: sp_dashboard.php');
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Intern not found.<br>";
    }
}

// Fetch interns from the database
$internsData = [];
$sql = "SELECT * FROM interns";
$internsResult = $conn->query($sql);

// Check if there are any interns
if ($internsResult->num_rows > 0) {
    // Fetch interns data
    while ($intern = $internsResult->fetch_assoc()) {
        $internsData[] = $intern;
    }
} else {
    echo "No interns found in the database.<br>";
}

// Close the database connection
$conn->close();
?>