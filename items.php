<?php
// Database connection
include('config.php');

// Initialize an empty message
$message = "";

// Add Item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $item_group = mysqli_real_escape_string($conn, $_POST['item_group']);
    $quantity = intval($_POST['quantity']);

    $query = "INSERT INTO items (item_name, item_group, quantity) VALUES ('$item_name', '$item_group', '$quantity')";
    if (mysqli_query($conn, $query)) {
        $message = "Item added successfully!";
    } else {
        $message = "Error adding item: " . mysqli_error($conn);
    }
}

// Edit Item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $item_id = intval($_POST['item_id']);
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $item_group = mysqli_real_escape_string($conn, $_POST['item_group']);
    $quantity = intval($_POST['quantity']);

    $query = "UPDATE items SET item_name = '$item_name', item_group = '$item_group', quantity = '$quantity' WHERE item_id = '$item_id'";
    if (mysqli_query($conn, $query)) {
        $message = "Item updated successfully!";
    } else {
        $message = "Error updating item: " . mysqli_error($conn);
    }
}

// Delete Item
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $item_id = intval($_GET['item_id']);
    $query = "DELETE FROM items WHERE item_id = '$item_id'";
    if (mysqli_query($conn, $query)) {
        $message = "Item deleted successfully!";
    } else {
        $message = "Error deleting item: " . mysqli_error($conn);
    }
}

// Fetch all items for display
$query = "SELECT * FROM items";
$result = mysqli_query($conn, $query);
$items = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Items Management</title>
  <link rel="stylesheet" href="items.css">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <img src="Stocksmart.png" width="30%" alt="Logo" class="logo">
      <nav>
        <ul>
          <li><a href="dashboard.html">Dashboard</a></li>
          <li><a href="items.php" class="active">Items</a></li>
          <li><a href="orders.html">Orders</a></li>
          <li><a href="reports.html">Reports</a></li>
          <li><a href="suppliers.html">Suppliers</a></li>
          <li><a href="profile.html">Profile</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="header">
        <h1>Items Management</h1>
      </header>

      <!-- Display messages -->
      <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
      <?php endif; ?>

      <!-- Add Item Form -->
      <section class="add-items">
        <h2>Add Item</h2>
        <form action="items.php" method="POST">
          <input type="hidden" name="action" value="add">
          <label for="item_name">Item Name:</label>
          <input type="text" id="item_name" name="item_name" required>
          <label for="item_group">Item Group:</label>
          <input type="text" id="item_group" name="item_group" required>
          <label for="quantity">Quantity:</label>
          <input type="number" id="quantity" name="quantity" required>
          <button type="submit">Add Item</button>
        </form>
      </section>

      <!-- Items Table -->
      <section class="items-list">
        <h2>Items List</h2>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Group</th>
              <th>Quantity</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $item): ?>
              <tr>
                <td><?php echo $item['item_id']; ?></td>
                <td><?php echo $item['item_name']; ?></td>
                <td><?php echo $item['item_group']; ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>
                  <!-- Edit Item Form -->
                  <form action="items.php" method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                    <input type="text" name="item_name" value="<?php echo $item['item_name']; ?>" required>
                    <input type="text" name="item_group" value="<?php echo $item['item_group']; ?>" required>
                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" required>
                    <button type="submit">Save</button>
                  </form>

                  <!-- Delete Item Form -->
                  <form action="items.php" method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                    <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>


