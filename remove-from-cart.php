<?php
session_start();
include('includes/db_connect.php');

// 1. Security Check: Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 2. Get the Cart Item ID from the URL
if (isset($_GET['id'])) {
    $cart_id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = $_SESSION['user_id'];

    // 3. Delete the item (ensure it belongs to the logged-in user)
    $sql = "DELETE FROM cart WHERE id = '$cart_id' AND user_id = '$user_id'";
    
    if (mysqli_query($conn, $sql)) {
        // Redirect back to cart with a success message
        header("Location: cart.php?removed=success");
        exit();
    } else {
        echo "Error removing item: " . mysqli_error($conn);
    }
} else {
    // If no ID is provided, just go back to the cart
    header("Location: cart.php");
    exit();
}
?>