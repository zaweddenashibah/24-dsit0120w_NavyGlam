<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NAVY GLAM</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="main-header">
        <div class="header-overlay">
            <div class="logo-area">
                <h1>NAVY GLAM</h1>
                <p>Where Style meets confidence</p>
            </div>
            <nav class="top-nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Account</a></li>
                    <?php endif; ?>
                    
                    <?php
                    $count = 0;
                    if(isset($_SESSION['user_id']) && isset($conn)) {
                        $uid = $_SESSION['user_id'];
                        $countRes = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id = '$uid'");
                        if($countRes) {
                            $countData = mysqli_fetch_assoc($countRes);
                            $count = $countData['total'] ?? 0;
                        }
                    }
                    ?>
                    <li><a href="cart.php">Cart (<?php echo $count; ?>)</a></li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li><a href="admin.php" style="color: #DAA520;">Admin</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>