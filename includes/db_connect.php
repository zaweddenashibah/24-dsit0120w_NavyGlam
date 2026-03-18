<?php
// Database configuration
$host     = 'localhost';
$username = 'root'; // Default XAMPP username
$password = '';     // Default XAMPP password (empty)
$dbname   = 'navy_glam';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If it fails, show the error
    die("Connection failed: " . $conn->connect_error);
}

// If it works, this variable $conn is now available for index.php to use.
?>