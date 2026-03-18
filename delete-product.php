<?php
session_start();
include('includes/db_connect.php');

// Security check: only admins allowed
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Optional: You could also delete the physical image file here using unlink()
    
    $sql = "DELETE FROM products WHERE id = '$id'";
    mysqli_query($conn, $sql);
}

header("Location: admin.php?delete=success");
exit();
?>