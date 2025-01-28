<?php include_once  "./conn.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/styles/css/bootstrap.min.css">
    <link rel="stylesheet" href="/styles/css/bootstrap-reboot.min.css"> 
    <title>Sign In</title>
    <style>
        /* Styling for the overall page */
        body {
            background-color: #f0f0f5; /* Soft background color */
            font-family: Arial, sans-serif;
        }

        .form-container {
            background-color: #ffffff; /* White background for the form */
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: auto;
            margin-top: 5%;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .form-control {
            width: 100%; /* Make input fields take up the full width of the container */
            border-radius: 8px;
            padding: 12px;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem; /* Adds space between the input fields */
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.5);
        }

        .btn-primary {
            border-radius: 8px;
            font-size: 1.1rem;
            padding: 12px;
            margin-top: 1rem; 
        }

        .d-grid {
            margin-top: 1rem;
            margin-left: 155px; 
        }

        .link-signup {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .link-signup a {
            text-decoration: none;
            color: #007bff;
        }

        .link-signup a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <form action="register.php" method="POST" class="form-container">
        <h2>Sign In</h2>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" id="useremail" placeholder="Email" required> 
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
        </div>
        <div class="d-grid gap-1">
            <button type="submit" class="btn btn-primary">Sign In</button>
        </div>
        <div class="link-signup">
            <span>Don't have an account? <a href="signup.php">Sign Up</a></span>
        </div>
    </form>

    <!-- Bootstrap JavaScript Bundle (includes Popper.js) -->
    <script src="/styles/js/bootstrap.bundle.min.js"></script>
</body>
</html>
