<?php
include('config.php');

if (isset($_GET['id'])) {
    $supplierId = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete supplier from the database
    $query = "DELETE FROM suppliers WHERE id = '$supplierId'";
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
