<?php
session_start();
include('includes/db_connect.php');

// Security: Check if the user is actually logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    
    // 1. Collect and sanitize the new data
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $second_email = mysqli_real_escape_string($conn, $_POST['second_email']);

    // 2. Update the users table
    $sql = "UPDATE users SET 
            address = '$address', 
            phone = '$phone', 
            second_email = '$second_email' 
            WHERE id = '$userId'";

    if (mysqli_query($conn, $sql)) {
        // 3. Redirect back to dashboard with a success flag
        header("Location: dashboard.php?update=success");
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>