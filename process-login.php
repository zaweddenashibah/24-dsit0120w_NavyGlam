<?php
session_start();
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Ensure your 'users' table has a 'role' column (admin or user)
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            // Store session data
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['full_name'];
            $_SESSION['role'] = $row['role']; 

            // Redirect based on your existing files
            if ($_SESSION['role'] === 'admin') {
                // If they are an admin, send them to admin.php in the root
                header("Location: admin.php");
            } else {
                // If they are a regular user, send them to dashboard.php
                header("Location: dashboard.php");
            }
            exit();
            
        } else {
            die("Invalid password. <a href='login.php'>Try again</a>");
        }
    } else {
        die("No account found. <a href='signup.php'>Sign up</a>");
    }
}
?>