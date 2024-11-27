<!-- orders.php -->
<?php
// Fetch orders from the database
$query = "SELECT * FROM orders";
$result = mysqli_query($conn, $query);

echo "<table>";
echo "<tr><th>Order ID</th><th>Customer Name</th><th>Total Amount</th><th>Status</th><th>Order Date</th><th>Actions</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>" . $row['OrderID'] . "</td><td>" . $row['CustomerName'] . "</td><td>" . $row['TotalAmount'] . "</td><td>" . $row['Status'] . "</td><td>" . $row['OrderDate'] . "</td><td><a href='order_details.php?OrderID=" . $row['OrderID'] . "'>View Details</a></td></tr>";
}
echo "</table>";
?>
