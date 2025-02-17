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
    $id_no = $_POST['id_no'] ?? '';  // Intern ID field for intern login
    $is_intern_login = isset($_POST['login_type']) && $_POST['login_type'] === 'intern';  // Check if intern login is requested

    // Basic validation: Check if the email or intern ID and password are provided
    if (!$is_intern_login && (empty($email) || empty($password))) {
        echo "Both email and password are required.";
        exit;
    } elseif ($is_intern_login && (empty($id_no) || empty($password))) {
        echo "Both intern ID and password are required.";
        exit;
    }

    // If it's an intern login
    if ($is_intern_login) {
        try {
            // Prepare the statement to fetch the intern based on intern ID
            $stmt = $conn->prepare("SELECT * FROM users WHERE id_no = ? AND role = 'intern'");
            $stmt->bind_param("s", $id_no);  // Bind intern ID parameter
            $stmt->execute();
            $result = $stmt->get_result();

            // If intern exists, verify the password
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Successful intern login, start the session and store intern info
                    $_SESSION['user_id'] = $user['id'];       // Store the user ID in session
                    $_SESSION['email'] = $user['email'];      // Store the user email (if needed for intern)
                    $_SESSION['role'] = $user['role'];        // Store the user role (intern)

                    // Redirect to intern dashboard
                    header('Location: ./attachee/dashboard.php');
                    exit;
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "No account found with that intern ID.";
            }

            // Close statement
            $stmt->close();

        } catch (Exception $e) {
            echo "Error with MySQL query: " . $e->getMessage();
            exit;
        }
    } else {
        // If it's a user login
        try {
            // Prepare the statement to fetch the user based on email
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);  // Bind email parameter
            $stmt->execute();
            $result = $stmt->get_result();

            // If user exists, verify the password
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

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
    }
} else {
    echo "Invalid request method.";
}
?>
