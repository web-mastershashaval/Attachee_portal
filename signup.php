<?php
 include_once"./conn.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .registration-form {
      max-width: 500px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>

  <div class="registration-form">
    <h3 class="text-center mb-4">User Registration</h3>
    <form id="registerForm" action="./register.php" method="POST">
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
    <div class="invalid-feedback">Username is required.</div>
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
    <div class="invalid-feedback">Please provide a valid email address.</div>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
    <div class="invalid-feedback">Password is required.</div>
  </div>

  <div class="mb-3">
    <label for="confirmPassword" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" required>
    <div class="invalid-feedback">Please confirm your password.</div>
  </div>

  <button type="submit" class="btn btn-primary w-100">Register</button>

  <div class="link-signup">
        <span>Already have an account? <a href="index.php">Sign In</a></span>
    </div>
</form>
  </div>

  <!-- Bootstrap 5 JS (Optional for Bootstrap features) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  <script src="register.js"></script>
</body>
</html>
