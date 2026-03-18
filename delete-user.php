<?php
session_start();
include('includes/db_connect.php');

// Security check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Prevent accidental deletion of the main admin if the query was modified
    $sql = "DELETE FROM users WHERE id = '$id' AND role != 'admin'";
    mysqli_query($conn, $sql);
}

header("Location: admin.php?user_deleted=1");
exit();
?>