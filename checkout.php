<?php 
include('includes/db_connect.php'); 
include('includes/header.php'); 

// 1. Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// 2. Fetch User Info (for shipping)
$userQuery = "SELECT * FROM users WHERE id = '$userId'";
$userResult = mysqli_query($conn, $userQuery);
$user = mysqli_fetch_assoc($userResult);

// 3. Fetch Cart Items (for the order summary)
$cartQuery = "SELECT products.name, products.price, cart.quantity 
              FROM cart 
              JOIN products ON cart.product_id = products.id 
              WHERE cart.user_id = '$userId'";
$cartResult = mysqli_query($conn, $cartQuery);

$grandTotal = 0;
?>

<main class="content-wrapper">
    <section class="glam-section">
        <h2 style="color: #DAA520;">Checkout Confirmation</h2>
        <p>Review your details before finalizing your order.</p>

        <div style="display: flex; gap: 50px; flex-wrap: wrap; margin-top: 30px;">
            
            <div style="flex: 1; min-width: 300px;">
                <h3 style="color: #DAA520; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Shipping Information</h3>
                <?php if(empty($user['address']) || empty($user['phone'])): ?>
                    <div style="background: #fff5f5; padding: 20px; border: 1px solid #feb2b2; border-radius: 5px;">
                        <p style="color: #c53030; font-weight: bold; margin-bottom: 10px;">⚠ Your profile is incomplete.</p>
                        <p style="font-size: 0.9rem; margin-bottom: 15px;">We need your delivery address and phone number to ship your items.</p>
                        <a href="dashboard.php" class="btn-gold" style="display: inline-block; text-decoration: none; padding: 10px 20px;">Complete Profile</a>
                    </div>
                <?php else: ?>
                    <div style="line-height: 1.8;">
                        <p><strong>Deliver to:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                        <p style="font-size: 0.8rem; margin-top: 15px; color: #888;">
                            Need to change this? <a href="dashboard.php" style="color: #DAA520; font-weight: bold;">Edit Profile</a>
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <div style="flex: 1; min-width: 300px; background: #fff; border: 1px solid #eee; padding: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                <h3 style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Order Summary</h3>
                
                <?php if(mysqli_num_rows($cartResult) > 0): ?>
                    <?php while($item = mysqli_fetch_assoc($cartResult)): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $grandTotal += $subtotal;
                    ?>
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f9f9f9; padding: 12px 0;">
                            <span style="font-size: 0.95rem;"><?php echo htmlspecialchars($item['name']); ?> <small style="color: #888;">(x<?php echo $item['quantity']; ?>)</small></span>
                            <span style="font-weight: bold;">$<?php echo number_format($subtotal, 2); ?></span>
                        </div>
                    <?php endwhile; ?>

                    <div style="margin-top: 25px; font-size: 1.3rem; font-weight: bold; display: flex; justify-content: space-between; color: #000;">
                        <span>Grand Total:</span>
                        <span style="color: #DAA520;">$<?php echo number_format($grandTotal, 2); ?></span>
                    </div>

                    <?php if(!empty($user['address'])): ?>
                        <form action="process-order.php" method="POST">
                            <button type="submit" class="btn-gold" style="width: 100%; margin-top: 25px; cursor: pointer;">Place Order Now</button>
                        </form>
                    <?php endif; ?>

                <?php else: ?>
                    <p style="text-align: center; color: #888;">Your cart is empty.</p>
                    <a href="shop.php" style="display: block; text-align: center; margin-top: 15px; color: #DAA520;">Go back to Shop</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>