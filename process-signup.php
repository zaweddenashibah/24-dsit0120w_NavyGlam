<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php?signup=success");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>