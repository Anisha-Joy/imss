<?php
// Include the database connection
include('config.php');

// Handle adding a supplier
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Insert supplier into the database
    $query = "INSERT INTO suppliers (name, contact, email, address) VALUES ('$name', '$contact', '$email', '$address')";
    if (mysqli_query($conn, $query)) {
        echo "Supplier added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!-- Form for adding supplier -->
<form method="POST" action="add.php">
    <label for="name">Name:</label>
    <input type="text" name="name" required><br>

    <label for="contact">Contact:</label>
    <input type="text" name="contact" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="address">Address:</label>
    <input type="text" name="address" required><br>

    <button type="submit">Add Supplier</button>
</form>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Supplier - Inventory Management</title>
  <link rel="stylesheet" href="the.css">
  <script src="script.js" defer></script>
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <nav>
        <ul>
          <img src="Stocksmart.png" width="30%" alt="Logo" class="logo-img">
          <li><a href="dashboard.html">Dashboard</a></li>
          <li><a href="orders.html">Orders</a></li>
          <li><a href="reports.html">Reports</a></li>
          <li><a href="suppliers.html" class="active">Suppliers</a></li>
          <li><a href="profile.html">Profile</a></li>
        </ul>
      </nav>
    </aside>

    <main class="main-content">
      <header class="top-nav">
        <h1>Add Supplier</h1>
      </header>

      <section class="form-section">
        <form action="suppliers.php?action=add" method="POST">
          <label for="name">Supplier Name:</label>
          <input type="text" id="name" name="name" required><br>
          <label for="contact">Contact:</label>
          <input type="text" id="contact" name="contact" required><br>
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required><br>
          <label for="address">Address:</label>
          <textarea id="address" name="address" required></textarea><br>
          <button type="submit">Add Supplier</button>
          <button type="button" onclick="history.back()">Cancel</button>
        </form>
      </section>
    </main>
  </div>
</body>
</html>

