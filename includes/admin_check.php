<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If not logged in OR if the role is not admin, redirect to login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php?error=no_access");
    exit();
}
?>