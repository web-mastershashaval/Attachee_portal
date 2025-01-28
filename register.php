<?php
include_once "conn.php";
error_reporting();

// SIGN-IN Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the fields are not empty
    if (empty($email) || empty($password)) {
        echo "Both email and password are required.";
        exit;
    }

    // Query to check if the user exists
    $sql = "SELECT id, email, password, role FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Start a session and store user info
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            echo "Login successful! Welcome " . $user['role'];
            // Redirect to a dashboard or home page based on user role
            if ($user['role'] == 'Admin') {
                header('Location: supavisor/sp_dashboard.php');  // Redirect to admin dashboard
            } else {
                header('Location: user_dashboard.php');  // Redirect to user dashboard
            }
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "No account found with that email.";
    }
}

// SIGN-UP Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmPassword']) && isset($_POST['role'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);  // Capturing role

    // Validate required fields
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword) || empty($role)) {
        echo "All fields are required.";
        exit;
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $sql_check = "SELECT email FROM users WHERE email='$email'";
    $result_check = mysqli_query($conn, $sql_check);
    if (mysqli_num_rows($result_check) > 0) {
        echo "Email is already registered.";
        exit;
    }

    // Insert user data into the database
    $sql_insert = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashedPassword', '$role')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Registration successful!";
        header('Location:  index.php');
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

$conn->close();
?>
