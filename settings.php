<?php
session_start();

// Include database connection
include('config.php');

// Initialize message variable
$message = "";
$messageClass = ""; // To differentiate between success and error messages

// Update admin settings (e.g., password change)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        $message = "New passwords do not match.";
        $messageClass = "error";
    } else {
        // Validate current password and update to the new password
        $user_id = $_SESSION['user_id']; // Assuming user ID is stored in the session
        $query = "SELECT password FROM users WHERE user_id = '$user_id' AND role = 'admin'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($current_password, $user['password'])) {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $update_query = "UPDATE users SET password = '$hashed_password' WHERE user_id = '$user_id' AND role = 'admin'";

                if (mysqli_query($conn, $update_query)) {
                    $message = "Password updated successfully.";
                    $messageClass = "success";

                    // Auto-hide message after 3 seconds using JavaScript
                    echo '<script>
                            setTimeout(function() {
                                const messageElement = document.querySelector(".message.success");
                                if (messageElement) {
                                    messageElement.style.display = "none";
                                }
                            }, 3000);
                          </script>';
                } else {
                    $message = "Error updating password. Please try again.";
                    $messageClass = "error";
                }
            } else {
                $message = "Current password is incorrect.";
                $messageClass = "error";
            }
        } else {
            $message = "User not found or unauthorized access.";
            $messageClass = "error";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Admin Actions</h2>
            <ul>
                <li><a href="manageusers.php">Manage Users</a></li>
                <li><a href="manageproducts.php">Manage Products</a></li>
                <li><a href="viewreports.php">View Reports</a></li>
                <li><a href="settings.php" class="active">Settings</a></li>
            </ul>
        </aside>

        <div class="main-content">
            <header>
                <h1>Settings</h1>
            </header>

            <!-- Display success or error message -->
            <?php if (!empty($message)): ?>
                <p class="message <?php echo $messageClass; ?>"><?php echo $message; ?></p>
            <?php endif; ?>

            <!-- Password Change Form -->
            <form action="settings.php" method="POST">
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" id="current_password" required>

                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" required>

                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>

                <button type="submit">Update Password</button>
            </form>
        </div>
    </div>
</body>
</html>


  
     