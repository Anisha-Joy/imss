<?php
include('db_connect.php');
session_start(); // Start session at the beginning

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php'); // Redirect to login
    exit();
}

$user_id = intval($_SESSION['user_id']); // Ensure valid integer

// Fetch user data
$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error fetching user data: " . mysqli_error($conn));
}
$user = mysqli_fetch_assoc($result);

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $user['password'];

    $update_query = "UPDATE users SET username='$username', email='$email', password='$password' WHERE user_id='$user_id'";
    if (mysqli_query($conn, $update_query)) {
        header('Location: profile.php'); // Redirect after updating
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>


