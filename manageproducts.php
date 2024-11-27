<?php
session_start();

// Include database connection
include('config.php');

// Fetch all products from the products table
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Admin Actions</h2>
            <ul>
                <li><a href="manageusers.php">Manage Users</a></li>
                <li><a href="manageproducts.php" class="active">Manage Products</a></li>
                <li><a href="viewreports.php">View Reports</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </aside>

        <div class="main-content">
            <header>
                <h1>Manage Products</h1>
            </header>

            <table>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Low Stock Threshold</th>
                    <th>Actions</th>
                </tr>
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $product['product_id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['category_id']; ?></td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['stock_quantity']; ?></td>
                        <td><?php echo $product['low_stock_threshold']; ?></td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $product['product_id']; ?>">Edit</a>
                            <a href="delete_product.php?id=<?php echo $product['product_id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>