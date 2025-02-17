<?php
include_once "../conn.php";
include_once "../supavisor/header.php";

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Assuming user_id is stored in the session after login
$user_id = $_SESSION['user_id'] ?? null;  // Added null check to prevent undefined index errors

if ($user_id) {
    // Fetch the user's current settings from the database
    $sql = "SELECT * FROM user_settings WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_settings = $result->fetch_assoc();
        $selected_theme = $user_settings['theme'];
        $username = $user_settings['username'];
        $email = $user_settings['email'];
    } else {
        // Default values if no settings are saved yet
        $selected_theme = 'light-mode';
        $username = '';
        $email = '';
        echo "<div class='alert alert-warning'>No settings found for this user. Please update your settings.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>User not logged in!</div>";
}

// Handle theme change form submission
if (isset($_POST['theme'])) {
    $theme = $_POST['theme'];

    // Update the theme in the database
    $update_theme_sql = "UPDATE user_settings SET theme = ? WHERE user_id = ?";
    $stmt = $conn->prepare($update_theme_sql);
    $stmt->bind_param('si', $theme, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['selected_theme'] = $theme;
        header("Location: settings.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle user settings update (username, email, password, profile_picture)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_settings'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Hash the password if it's provided

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $upload_dir = 'uploads/profile_pictures/'; // Directory where profile pictures will be stored

        // Ensure directory exists and create if not
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);  // Create the directory if it doesn't exist
        }

        // Ensure the file name is unique (e.g., prepend with timestamp)
        $file_name = time() . '-' . basename($_FILES['profile_picture']['name']);
        $file_path = $upload_dir . $file_name;
        
        // Check if the file is an image (Optional but recommended)
        $image_type = mime_content_type($_FILES['profile_picture']['tmp_name']);
        if (strpos($image_type, 'image') === false) {
            echo "<div class='alert alert-danger'>Please upload a valid image file.</div>";
            exit;
        }

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file_path)) {
            // File uploaded successfully
        } else {
            echo "<div class='alert alert-danger'>Error uploading the file.</div>";
            exit;
        }
    }

    // Prepare the query for updating user settings
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Update the user settings in the database with the new password and profile picture
        $update_user_sql = "UPDATE users SET username = ?, email = ?, password = ?, profile_picture = ? WHERE id = ?";
        $stmt = $conn->prepare($update_user_sql);
        $stmt->bind_param('ssssi', $username, $email, $hashed_password, $file_name, $user_id);
    } else {
        // Update without password if password field is empty
        $update_user_sql = "UPDATE users SET username = ?, email = ?, profile_picture = ? WHERE id = ?";
        $stmt = $conn->prepare($update_user_sql);
        $stmt->bind_param('sssi', $username, $email, $file_name, $user_id);
    }

    // Execute the update query
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Settings saved successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Settings Page</title>
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

        .settings-header {
            margin-top: 50px;
            text-align: center;
        }

        .dark-mode-btn, .light-mode-btn {
            cursor: pointer;
        }

        .dark-mode-btn {
            background-color: #222222;
            color: white;
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
        }

        .light-mode-btn {
            background-color: #f9f9f9;
            color: black;
            padding: 10px 20px;
            border: none;
        }
    </style>
</head>
<body class="<?php echo htmlspecialchars($selected_theme); ?>">

    <div class="container">
        <div class="settings-header">
            <h1>Settings Page</h1>
            <p>Manage your settings below</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h4>User Settings</h4>
               <!-- HTML form for user settings -->
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo $username; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                        <small class="form-text text-muted">Leave empty if you don't want to change your password.</small>
                    </div>

                    <!-- Profile picture input -->
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture</label>
                        <input type="file" id="profile_picture" name="profile_picture" class="form-control">
                    </div>

                    <button type="submit" name="save_settings" class="btn btn-primary">Save Settings</button>
                </form>
            </div>

            <div class="col-md-6">
                <h4>Theme Settings</h4>
                <form method="POST">
                    <button type="submit" name="theme" value="dark-mode" class="dark-mode-btn">Dark Mode</button>
                    <button type="submit" name="theme" value="light-mode" class="light-mode-btn">Light Mode</button>
                </form>
            </div>
        </div>
    </div>
  <a href="./dashboard.php"> Go Back</a>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
