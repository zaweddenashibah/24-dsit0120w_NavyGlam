<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['reset_email']);
    
    // Check if user exists
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($check) > 0) {
        // In a real app, you'd generate a token and mail() it.
        // For now, we redirect with a message.
        header("Location: login.php?reset=sent");
    } else {
        header("Location: login.php?error=notfound");
    }
    exit();
}
?>