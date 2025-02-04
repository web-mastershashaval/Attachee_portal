<?php
// Include MongoDB connection
include_once './conn.php'; // Ensure this includes the MongoDB connection logic

// Check if the collection is properly initialized
if (!$usersCollection) {
    echo "Error: MongoDB collection not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data from POST request
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Basic validation
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required.";
        exit;  // Stop execution if fields are missing
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

    // Check if email already exists in MongoDB
    try {
        $existingUser = $usersCollection->findOne(['email' => $email]);
        if ($existingUser) {
            echo "Email is already registered.";
            exit;
        }
    } catch (Exception $e) {
        echo "Error with MongoDB query: " . $e->getMessage();
        exit;
    }

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Assign default role as 'User'
    $role = 'User'; // Default role is User, can be changed later by Admin

    // Prepare user data for MongoDB insertion
    $userDocument = [
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword,
        'role' => $role,  // Add role field
    ];

    // Insert the user into the MongoDB collection
    try {
        $insertResult = $usersCollection->insertOne($userDocument);

        if ($insertResult->getInsertedCount() == 1) {
            // Registration successful, redirect to login page
            header('Location: ./index.php'); // Assuming 'login.php' is your login page
            exit;  // Make sure to call exit after header redirection to prevent further code execution
        } else {
            echo "Error during registration.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid request method.";
}

?>
