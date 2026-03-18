<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert into database
    $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        // Redirect back to contact page with a success flag
        header("Location: contact.php?sent=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>