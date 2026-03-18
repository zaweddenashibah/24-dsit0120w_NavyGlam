<?php 
include('includes/db_connect.php');
include('includes/header.php'); 

// Fetch all products
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC");
?>

<header class="hero-section">
    <div class="hero-content">
        <h1>NAVY GLAM</h1>
        <p>Where Style Meets Confidence</p>
    </div>
</header>

<main class="content-wrapper">
    <section class="glam-section">
        <h2 class="section-title">Latest Collections</h2>
        
        <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; margin-top: 40px;">
            
            <?php while($prod = mysqli_fetch_assoc($result)): 
                // SAFETY CHECK: Prevents "Undefined array key" errors
                $display_status = (isset($prod['stock_status'])) ? $prod['stock_status'] : 'Available'; 
            ?>
            
            <div class="product-card" style="position: relative; border: 1px solid #f2f2f2; padding: 20px; text-align: center; background: #fff; transition: transform 0.3s ease;">
                
                <?php if($display_status === 'Out of Stock'): ?>
                    <span style="position: absolute; top: 15px; right: 15px; background: #000; color: #DAA520; padding: 5px 12px; font-size: 0.7rem; font-weight: bold; z-index: 2; border: 1px solid #DAA520; letter-spacing: 1px;">SOLD OUT</span>
                <?php endif; ?>

                <div class="img-container" style="height: 380px; overflow: hidden; margin-bottom: 20px; background: #fdfdfd;">
                    <img src="<?php echo htmlspecialchars($prod['image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($prod['name']); ?>"
                         style="width: 100%; height: 100%; object-fit: cover; transition: 0.5s; <?php echo ($display_status === 'Out of Stock') ? 'filter: grayscale(1) opacity(0.5);' : ''; ?>">
                </div>

                <h3 style="font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 10px; color: #333;">
                    <?php echo htmlspecialchars($prod['name']); ?>
                </h3>
                
                <p style="color: #DAA520; font-weight: bold; margin-bottom: 20px; font-size: 1.2rem;">
                    $<?php echo number_format($prod['price'], 2); ?>
                </p>

                <?php if($display_status === 'Available'): ?>
                    <a href="process-cart-add.php?id=<?php echo $prod['id']; ?>" class="btn-gold" style="display: block; width: 100%; text-decoration: none; padding: 12px 0; background: #000; color: #DAA520; border: 1px solid #000; font-weight: bold; text-transform: uppercase; font-size: 0.85rem;">
                        Add to Bag
                    </a>
                <?php else: ?>
                    <button disabled style="display: block; width: 100%; padding: 12px 0; background: #f8f8f8; border: 1px solid #eee; color: #bbb; cursor: not-allowed; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">
                        Currently Unavailable
                    </button>
                <?php endif; ?>
                
            </div>
            <?php endwhile; ?>

        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>