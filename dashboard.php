<?php 
// 1. Establish database connection FIRST
include('includes/db_connect.php');

// 2. Load header (which has session_start() and cart count)
include('includes/header.php');

// 3. Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// 4. Fetch user data for profile completion
$query = "SELECT * FROM users WHERE id = '$userId'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// 5. Fetch User Order History
$orderQuery = "SELECT * FROM orders WHERE user_id = '$userId' ORDER BY created_at DESC";
$orderResult = mysqli_query($conn, $orderQuery);

// 6. Logic for Completion Percentage
$totalFields = 3;
$filledFields = 0;
if (!empty($user['address'])) $filledFields++;
if (!empty($user['phone'])) $filledFields++;
if (!empty($user['second_email'])) $filledFields++;
$completion = ($filledFields / $totalFields) * 100;
?>

<main class="content-wrapper">
    <section class="glam-section">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></h2>
        
        <?php if(isset($_GET['update']) && $_GET['update'] == 'success'): ?>
            <p style="color: #DAA520; font-weight: bold; margin-bottom: 20px;">✓ Profile updated successfully!</p>
        <?php endif; ?>

        <?php if(isset($_GET['order']) && $_GET['order'] == 'complete'): ?>
            <div style="background: #000; color: #DAA520; padding: 20px; border-radius: 5px; margin-bottom: 30px; border-left: 10px solid #DAA520;">
                <h3 style="margin: 0;">✨ Stay Glam!</h3>
                <p style="margin: 5px 0 0 0;">Your order has been placed successfully. Check the history below for updates.</p>
            </div>
        <?php endif; ?>

        <div style="display: flex; gap: 40px; flex-wrap: wrap; align-items: flex-start;">
            
            <div style="flex: 1; min-width: 300px;">
                <h3 style="text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">Your Profile</h3>
                
                <div class="profile-status">
                    <p>Style Profile Completion: <strong><?php echo round($completion); ?>%</strong></p>
                    <div class="progress-container" style="background: #eee; height: 8px; border-radius: 4px; margin: 10px 0 25px 0;">
                        <div class="progress-bar" style="width: <?php echo $completion; ?>%; background: #DAA520; height: 100%; border-radius: 4px;"></div>
                    </div>
                </div>

                <form action="process-profile-update.php" method="POST" class="profile-form">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">Shipping Address</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;" placeholder="123 Luxury Ave">
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">Phone Number</label>
                        <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.8rem; font-weight: bold; text-transform: uppercase;">Secondary Email</label>
                        <input type="email" name="second_email" value="<?php echo htmlspecialchars($user['second_email'] ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd;">
                    </div>
                    
                    <button type="submit" class="btn-gold" style="width: 100%;">Save Changes</button>
                </form>
            </div>

            <div style="flex: 1.5; min-width: 300px; border-left: 1px solid #eee; padding-left: 20px;">
                <h3 style="text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">Order History</h3>
                
                <div class="cart-table">
                    <div class="cart-row header" style="grid-template-columns: 1fr 1fr 1fr;">
                        <span>Order #</span>
                        <span>Total</span>
                        <span>Status</span>
                    </div>

                    <?php if (mysqli_num_rows($orderResult) > 0): ?>
                        <?php while($order = mysqli_fetch_assoc($orderResult)): ?>
                            <div class="cart-row" style="grid-template-columns: 1fr 1fr 1fr; padding: 12px 0; border-bottom: 1px solid #f9f9f9; font-size: 0.9rem;">
                                <span style="font-family: monospace;">GLAM-<?php echo $order['id']; ?></span>
                                <strong>$<?php echo number_format($order['total_amount'], 2); ?></strong>
                                <span>
                                    <small style="background: #000; color: #DAA520; padding: 2px 8px; border-radius: 10px; font-size: 0.7rem; font-weight: bold;">
                                        <?php echo strtoupper($order['status']); ?>
                                    </small>
                                </span>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="padding: 20px 0; color: #888;">You haven't placed any orders yet.</p>
                        <a href="index.php" class="btn-gold" style="display: inline-block; padding: 10px 20px; font-size: 0.8rem;">Start Shopping</a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>