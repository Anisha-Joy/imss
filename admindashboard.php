<?php
session_start();

// Include database connection
include('config.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect to login page if not an admin or not logged in
    header("Location: signin.php");
    exit();
}

// Fetch data to display on the dashboard (e.g., number of users, stock, etc.)
$query_users = "SELECT COUNT(*) AS user_count FROM users";
$result_users = mysqli_query($conn, $query_users);
$user_data = mysqli_fetch_assoc($result_users);

$query_products = "SELECT COUNT(*) AS product_count FROM products";  // Assuming you have a products table
$result_products = mysqli_query($conn, $query_products);
$product_data = mysqli_fetch_assoc($result_products);

// You can add more queries as needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Link to your CSS for styling -->
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Welcome, Admin</h1>
            <p>Manage your inventory and users from here</p>
        </header>

        <div class="dashboard-info">
            <div class="info-box">
                <h3>Total Users</h3>
                <p><?php echo $user_data['user_count']; ?></p>
            </div>
            <div class="info-box">
                <h3>Total Products</h3>
                <p><?php echo $product_data['product_count']; ?></p>
            </div>
        </div>

        <div class="dashboard-actions">
            <h3>Admin Actions</h3>
            <ul>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="view_reports.php">View Reports</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </div>

        <footer>
            <p>&copy; 2024 Your Company Name. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
