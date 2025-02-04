<?php
include_once "./conn.php";
// Start session to handle user authentication
session_start();

// Check if the MongoDB collection is initialized
if (!$usersCollection) {
    echo "Error: MongoDB collection not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data from POST request
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Basic validation: Check if both email and password are provided
    if (empty($email) || empty($password)) {
        echo "Both email and password are required.";
        exit;
    }

    // Query MongoDB to check if the user exists
    try {
        $user = $usersCollection->findOne(['email' => $email]);

        // If user exists, verify the password
        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Successful login, start the session and store user info
                $_SESSION['user_id'] = (string) $user['_id'];  // Store the user ID in session
                $_SESSION['email'] = $user['email'];           // Store the user email
                $_SESSION['role'] = $user['role'];             // Store the user role (Admin or User)

                // Redirect based on user role
                if ($user['role'] == 'Admin') {
                    header('Location: admin_dashboard.php');  // Redirect to Admin dashboard
                    exit;
                } else {
                    header('Location: /supavisor/sp_dashboard.php');   // Redirect to User dashboard
                    exit;
                }
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No account found with that email.";
        }
    } catch (Exception $e) {
        echo "Error with MongoDB query: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid request method.";
}
?>