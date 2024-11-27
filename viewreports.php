<?php
session_start();

// Include database connection
include('config.php');

// Fetch total sales, low-stock products, and total users for the reports
$totalSalesQuery = "SELECT SUM(price * quantity) AS total_sales FROM products";
$totalSalesResult = mysqli_query($conn, $totalSalesQuery);
$totalSales = mysqli_fetch_assoc($totalSalesResult)['total_sales'];

$lowStockQuery = "SELECT COUNT(*) AS low_stock_count FROM products WHERE stock_quantity < low_stock_threshold";
$lowStockResult = mysqli_query($conn, $lowStockQuery);
$lowStockCount = mysqli_fetch_assoc($lowStockResult)['low_stock_count'];

$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
$totalUsersResult = mysqli_query($conn, $totalUsersQuery);
$totalUsers = mysqli_fetch_assoc($totalUsersResult)['total_users'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Admin Actions</h2>
            <ul>
                <li><a href="manageusers.php">Manage Users</a></li>
                <li><a href="manageproducts.php">Manage Products</a></li>
                <li><a href="view_reports.php" class="active">View Reports</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </aside>

        <div class="main-content">
            <header>
                <h1>Reports Overview</h1>
            </header>

            <div class="reports">
                <div class="report-box">
                    <h3>Total Sales</h3>
                    <p><?php echo $totalSales ? "$" . number_format($totalSales, 2) : "No sales data available"; ?></p>
                </div>

                <div class="report-box">
                    <h3>Low-Stock Products</h3>
                    <p><?php echo $lowStockCount; ?> product(s)</p>
                </div>

                <div class="report-box">
                    <h3>Total Users</h3>
                    <p><?php echo $totalUsers; ?> user(s)</p>
                </div>
            </div>

            <div class="detailed-reports">
                <h2>Low-Stock Products</h2>
                <table>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Stock Quantity</th>
                        <th>Low Stock Threshold</th>
                    </tr>
                    <?php
                    // Fetch and display low-stock products
                    $lowStockDetailsQuery = "SELECT product_id, name, stock_quantity, low_stock_threshold 
                                             FROM products WHERE stock_quantity < low_stock_threshold";
                    $lowStockDetailsResult = mysqli_query($conn, $lowStockDetailsQuery);

                    while ($product = mysqli_fetch_assoc($lowStockDetailsResult)): ?>
                        <tr>
                            <td><?php echo $product['product_id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['stock_quantity']; ?></td>
                            <td><?php echo $product['low_stock_threshold']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

