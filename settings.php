<?php
include_once "./conn.php";
session_start();

// If a theme is selected, save it in the session
if (isset($_POST['theme'])) {
    $_SESSION['selected_theme'] = $_POST['theme'];
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
<body class="<?php echo isset($_SESSION['selected_theme']) ? $_SESSION['selected_theme'] : 'light-mode'; ?>">

    <div class="container">
        <div class="settings-header">
            <h1>Settings Page</h1>
            <p>Manage your settings below</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h4>User Settings</h4>
                <form>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter password">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>

            <div class="col-md-6">
                <h4>Theme Settings</h4>
                <form method="POST" action="settings.php">
                    <button type="submit" name="theme" value="dark-mode" class="dark-mode-btn">Dark Mode</button>
                    <button type="submit" name="theme" value="light-mode" class="light-mode-btn">Light Mode</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
