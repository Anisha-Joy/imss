<?php
session_start();

// Check if user is logged in, otherwise redirect to sign-in page
if (!isset($_SESSION['login_success']) || !$_SESSION['login_success']) {
    header("Location: signin.php"); // Redirect to signin if not logged in
    exit;
}

// Include the database connection
include('config.php');

// Query to check for low stock items
$sql = "SELECT name, stock_quantity, low_stock_threshold FROM products WHERE stock_quantity <= low_stock_threshold";
$result = $conn->query($sql);

$low_stock_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $low_stock_items[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Inventory Management</title>
  <link rel="stylesheet" href="the.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Updated to use CDN -->
</head>
<body>
  <div class="container">
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
      <nav>
        <ul>
          <img src="Stocksmart.png" width="30%" alt="Logo" class="logo-img">
          <li><a href="dashboard.php" class="active">Dashboard</a></li>
          <li><a href="orders.html">Orders</a></li>
          <li><a href="reports.html">Reports</a></li>
          <li><a href="suppliers.html">Suppliers</a></li>
          <li><a href="profile.php">Profile</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</h1>

      <!-- Low Stock Alert -->
      <?php if (!empty($low_stock_items)): ?>
        <div class="alert alert-warning">
          <strong>Low Stock Alert:</strong>
          <ul>
            <?php foreach ($low_stock_items as $item): ?>
              <li>
                <?php echo htmlspecialchars($item['name']); ?> 
                (Remaining: <?php echo htmlspecialchars($item['stock_quantity']); ?>, 
                Threshold: <?php echo htmlspecialchars($item['low_stock_threshold']); ?>)
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php else: ?>
        <div class="alert alert-success">
          All stock levels are sufficient.
        </div>
      <?php endif; ?>

      <!-- Overview Section -->
      <div class="dashboard">
        <button class="items-btn"><a href="items.html">Add Items</a></button>

        <!-- Sales Activity -->
        <div class="card">
          <h3>Sales Activity</h3>
          <canvas id="salesActivityChart"></canvas>
        </div>

        <!-- Inventory Summary -->
        <div class="card">
          <h3>Inventory Summary</h3>
          <canvas id="inventorySummaryChart"></canvas>
        </div>

        <!-- Top Selling Items -->
        <div class="card">
          <h3>Top Selling Items</h3>
          <canvas id="topSellingItemsChart"></canvas>
        </div>

        <!-- Purchase Orders -->
        <div class="card">
          <h3>Purchase Orders</h3>
          <canvas id="purchaseOrdersChart"></canvas>
        </div>
      </div>
    </main>
  </div>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Sales Activity Chart
      const salesActivityCtx = document.getElementById('salesActivityChart').getContext('2d');
      new Chart(salesActivityCtx, {
        type: 'bar',
        data: {
          labels: ['To be Packed', 'To be Shipped', 'To be Delivered', 'To be Invoiced'],
          datasets: [{
            label: 'Sales Activity',
            data: [5, 3, 2, 4], // Sample data
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

      // Inventory Summary Chart
      const inventorySummaryCtx = document.getElementById('inventorySummaryChart').getContext('2d');
      new Chart(inventorySummaryCtx, {
        type: 'pie',
        data: {
          labels: ['Quantity in Hand', 'Quantity to be Received'],
          datasets: [{
            label: 'Inventory Summary',
            data: [10, 5], // Sample data
            backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 159, 64, 0.2)'],
            borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)'],
            borderWidth: 1
          }]
        }
      });

      // Top Selling Items Chart
      const topSellingItemsCtx = document.getElementById('topSellingItemsChart').getContext('2d');
      new Chart(topSellingItemsCtx, {
        type: 'doughnut',
        data: {
          labels: ['Item 1', 'Item 2', 'Item 3'], // Sample items
          datasets: [{
            label: 'Top Selling Items',
            data: [8, 4, 3], // Sample data
            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
            borderWidth: 1
          }]
        }
      });

      // Purchase Orders Chart
      const purchaseOrdersCtx = document.getElementById('purchaseOrdersChart').getContext('2d');
      new Chart(purchaseOrdersCtx, {
        type: 'line',
        data: {
          labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'], // Sample labels
          datasets: [{
            label: 'Purchase Orders',
            data: [3, 7, 5, 2], // Sample data
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    });
  </script>
</body>
</html>
