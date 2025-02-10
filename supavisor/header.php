<?php
// Start the session at the beginning of the script if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database credentials
$host = 'localhost';  // Database host, e.g. localhost
$username = 'root';   // Your database username
$password = '';       // Your database password
$dbname = 'portal';   // The name of your database

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if theme is already set in session
if (isset($_SESSION['selected_theme'])) {
    $selected_theme = $_SESSION['selected_theme'];  // Apply the saved theme from session
} else {
    // Default to light mode if no theme is selected
    $selected_theme = 'light-mode';
}

// Check if user is logged in and retrieve their settings
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user settings from the database using prepared statements (for security)
    $sql = "SELECT * FROM user_settings WHERE user_id = ? LIMIT 1";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $user_id); // 'i' means integer (user_id is expected to be an integer)
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user_settings = $result->fetch_assoc();

            // Debugging: Show the result to ensure correct data is fetched
            var_dump($user_settings); // Check the array returned from the database

            // Store user settings in session (for global use across pages)
            $_SESSION['username'] = $user_settings['username'];  
            $_SESSION['email'] = $user_settings['email'];
        } else {
            // Handle the case if no user settings are found
            echo "No settings found for this user.";
        }
        $stmt->close(); // Close the prepared statement here
    } else {
        // Handle error if the query preparation fails
        echo "Error: " . $conn->error;
    }
} else {
    // Handle the case if the user is not logged in
    echo "User is not logged in.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body.dark-mode {
            background-color: #181818;
            color: white;
        }

        .dark-mode .container {
            background-color: #222222;
        }

        .dark-mode .btn {
            background-color: #007bff;
            color: white;
        }

        .dark-mode .form-control {
            background-color: #555555;
            color: white;
        }

        .dark-mode .form-check-input:checked {
            background-color: #007bff;
        }

        .light-mode {
            background-color: #f9f9f9;
            color: black;
        }
    </style>
</head>
<body class="<?= htmlspecialchars($selected_theme); ?>">  

</body>
</html>
