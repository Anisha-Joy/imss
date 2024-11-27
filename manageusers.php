<?php
session_start();

// Include database connection
include('config.php');




// Fetch all users
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Admin Actions</h2>
            <ul>
                <li><a href="manageusers.php" class="active">Manage Users</a></li>
                <li><a href="manageproducts.php">Manage Products</a></li>
                <li><a href="viewreports.php">View Reports</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </aside>

        <div class="main-content">
            <header>
                <h1>Manage Users</h1>
            </header>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                <?php while ($user = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $user['user_id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $user['user_id']; ?>">Edit</a>
                            <a href="delete_user.php?id=<?php echo $user['user_id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
