<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS to center the login form */
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
    <script>
        // JavaScript to toggle the fields based on selected login type
        function toggleLoginFields() {
            var loginType = document.querySelector('input[name="login_type"]:checked').value;

            // Show/hide fields based on login type
            if (loginType == 'user') {
                document.getElementById('email').required = true;
                document.getElementById('id_no').required = false;
                document.getElementById('email').style.display = 'block';
                document.getElementById('id_no').style.display = 'none';
            } else {
                document.getElementById('email').required = false;
                document.getElementById('id_no').required = true;
                document.getElementById('email').style.display = 'none';
                document.getElementById('id_no').style.display = 'block';
            }
        }

        // Set the initial state of the form
        window.onload = function() {
            toggleLoginFields(); // Call on page load to set the correct visibility and requirements
        };
    </script>
</head>
<body>
    <div class="container login-container">
        <h2 class="text-center mb-4">Login</h2>
        <!-- Login Form -->
        <form method="POST" action="tester.php">
            <!-- Choose Login Type -->
            <div class="form-group mb-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="login_type" value="user" checked onclick="toggleLoginFields()">
                    <label class="form-check-label">User Login</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="login_type" value="intern" onclick="toggleLoginFields()">
                    <label class="form-check-label">Intern Login</label>
                </div>
            </div>

            <!-- Email or Intern ID (show one at a time) -->
            <div class="form-group mb-4">
                <label for="email" class="form-label">Email:</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Enter your email">
                
                <label for="id_no" class="form-label mt-3">Intern ID:</label>
                <input type="text" name="id_no" id="id_no" class="form-control" placeholder="Enter your intern ID" style="display: none;">
            </div>

            <!-- Password -->
            <div class="form-group mb-4">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
            <li>Have no Account ? `<a href="signup.php"> signup</a></li>
        </form>
    </div>

    <!-- Bootstrap 5 JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
