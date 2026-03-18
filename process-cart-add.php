<?php
session_start();
include('includes/db_connect.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=please_login");
    exit();
}

$uid = $_SESSION['user_id'];
// Support both POST (form) and GET (link)
$pid = isset($_POST['product_id']) ? $_POST['product_id'] : (isset($_GET['id']) ? $_GET['id'] : null);

if ($pid) {
    $pid = mysqli_real_escape_string($conn, $pid);

    // Check if item already exists in cart
    $check = mysqli_query($conn, "SELECT id FROM cart WHERE user_id = '$uid' AND product_id = '$pid'");
    
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$uid' AND product_id = '$pid'");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$uid', '$pid', 1)");
    }
    
    header("Location: cart.php");
} else {
    header("Location: index.php");
}
exit();
?>