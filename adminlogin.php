<?php
session_start(); // Start session to track user login
include('config.php'); // Include your database configuration file

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password']; // Raw password, will be checked against the database

        // Query to check if the admin exists
        $query = "SELECT * FROM users WHERE email = '$email' AND role = 'admin'"; // Only fetch admin role
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verify password against stored hash (assuming you store password hashes)
            if (password_verify($password, $user['password'])) {
                // Store session variables for admin access
                $_SESSION['admin_id'] = $user['user_id'];
                $_SESSION['admin_email'] = $user['email'];
                $_SESSION['admin_role'] = $user['role'];
                $_SESSION['login_success'] = true;

                // Redirect to the admin dashboard
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "No admin found with that email.";
        }
    } else {
        echo "Email and password are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In</title>
  <link rel="stylesheet" href="signin.css">
</head>
<body>
  <div class="signin-container">
    <!-- Logo -->
    <div class="logo-container">
      <img src="Stocksmart.png" width="10%" alt="Logo" class="logo-img">
    </div>
<!-- Admin Login Form -->
    <form id="admin-login" class="signin-form hidden" action="admin_login.php" method="POST">
      <h2>Admin Sign In</h2>
      <div class="form-group">
        <label for="admin-email">Email:</label>
        <input type="email" id="admin-email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="admin-password">Password:</label>
        <input type="password" id="admin-password" name="password" placeholder="Enter your password" required>
      </div>
      <button type="submit" class="signin-btn">Sign In</button>
    </form>
