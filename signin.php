<?php
session_start(); // Start the session
include('config.php'); // Include database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate email and password
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password']; // Raw password

        // Query to retrieve user data by email
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result); // Fetch user details

            // Verify password using the hashed password in the database
            if (password_verify($password, $user['password'])) {
                // Store user details in the session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role']; // Role (admin or user)
                $_SESSION['login_success'] = true;

                // Redirect based on role
                if ($user['role'] == 'admin') {
                    header("Location: admindashboard.php"); // Redirect to admin dashboard
                } else {
                    header("Location:user.php"); // Redirect to user dashboard
                }
                exit();
            } else {
                $error_message = "Invalid email or password!";
            }
        } else {
            $error_message = "No account found with that email!";
        }
    } else {
        $error_message = "Email and password are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Inventory Management</title>
    <link rel="stylesheet" href="signin.css">
</head>
<body>
    <div class="signin-container">
        <h2>Sign In</h2>

        <!-- Display error message -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message" style="color: red; margin-bottom: 1em;">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="signin.php">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="signin-btn">Sign In</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
</body>
</html>




