<?php 
// 1. Session and Database Connection
include('includes/db_connect.php'); 
include('includes/header.php'); 

// 2. Security: Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// 3. Fetch cart items joined with product details
$query = "SELECT cart.id as cart_id, products.name, products.price, products.image_path, cart.quantity 
          FROM cart 
          JOIN products ON cart.product_id = products.id 
          WHERE cart.user_id = '$userId'";
$result = mysqli_query($conn, $query);

$totalPrice = 0;
?>

<main class="content-wrapper">
    <section class="glam-section">
        <h2 style="color: #DAA520; border-left: 5px solid #000; padding-left: 15px; margin-bottom: 30px;">Your Shopping Bag</h2>
        
        <div class="cart-table">
            <div class="cart-row header">
                <span>Product</span>
                <span style="text-align: center;">Quantity</span>
                <span style="text-align: right;">Subtotal</span>
            </div>

            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($item = mysqli_fetch_assoc($result)): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $totalPrice += $subtotal;
                    $img = !empty($item['image_path']) ? $item['image_path'] : 'https://via.placeholder.com/60x80';
                ?>
                    <div class="cart-row">
                        <div class="product-info">
                            <div class="cart-img-thumb" style="background-image: url('<?php echo $img; ?>'); background-size: cover; background-position: center;"></div>
                            <div>
                                <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                                <br>
                                <small><a href="remove-from-cart.php?id=<?php echo $item['cart_id']; ?>" style="color: #ff4444; font-size: 0.75rem; text-decoration: none;">Remove</a></small>
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <span><?php echo $item['quantity']; ?></span>
                        </div>
                        <div style="text-align: right;">
                            <strong>$<?php echo number_format($subtotal, 2); ?></strong>
                        </div>
                    </div>
                <?php endwhile; ?>

                <div class="cart-total" style="text-align: right; margin-top: 40px;">
                    <p style="font-size: 1.2rem; margin-bottom: 20px;">Estimated Total: <strong>$<?php echo number_format($totalPrice, 2); ?></strong></p>
                    
                    <a href="checkout.php" class="btn-gold" style="display: inline-block; text-decoration: none; width: 240px; text-align: center; padding: 15px 0; background: #000; color: #DAA520; font-weight: bold;">
                        PROCEED TO CHECKOUT
                    </a>
                </div>

            <?php else: ?>
                <div style="padding: 60px 0; text-align: center;">
                    <p style="font-size: 1.1rem; color: #666;">Your bag is currently empty.</p>
                    <a href="index.php" class="btn-gold" style="display: inline-block; text-decoration: none; margin-top: 20px; padding: 10px 30px;">Continue Shopping</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>