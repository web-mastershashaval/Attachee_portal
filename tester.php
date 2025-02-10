<?php
include_once './conn.php';  // Ensure this file contains the correct MySQL connection

// Start session to handle user authentication
session_start();

// Check if the MySQL connection is established
if (!$conn) {
    echo "Error: MySQL connection failed!";
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

    // Query MySQL to check if the user exists
    try {
        // Prepare the statement to fetch the user based on email
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);  // Bind email parameter
        $stmt->execute();
        $result = $stmt->get_result();

        // Debugging: Check if the query returns any rows
        // var_dump($result);  // Uncomment to check the result

        // If user exists, verify the password
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Debugging: Output the user data
            // var_dump($user);  // Uncomment to check the fetched user data

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Successful login, start the session and store user info
                $_SESSION['user_id'] = $user['id'];      // Store the user ID in session
                $_SESSION['email'] = $user['email'];     // Store the user email
                $_SESSION['role'] = $user['role'];       // Store the user role (Admin or User)

                // Redirect based on user role
                if ($user['role'] == 'admin') {
                    // Admin role redirection
                    header('Location: ./supavisor/sp_dashboard.php');  // Redirect to Admin dashboard
                    exit;
                } else {
                    // User role redirection
                    header('Location: ./attachee/dashboard.php');   // Redirect to User dashboard
                    exit;
                }
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No account found with that email.";
        }

        // Close statement
        $stmt->close();

    } catch (Exception $e) {
        echo "Error with MySQL query: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid request method.";
}
?>
