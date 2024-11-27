<?php
// Include the database connection
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Insert the user data into the users table
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if (mysqli_query($conn, $query)) {
        echo "User registered successfully!";
        header('Location: signin.php');  // Redirect to signin page
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


