<?php 
include('includes/db_connect.php');
include('includes/header.php');

// 1. Check if a category is selected
$categoryFilter = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : '';

// 2. Build the query
$sql = "SELECT * FROM products";
if (!empty($categoryFilter)) {
    $sql .= " WHERE category = '$categoryFilter'";
}
$sql .= " ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<main class="content-wrapper">
    <section class="glam-section">
        <h2 style="color: #DAA520;">
            <?php echo !empty($categoryFilter) ? htmlspecialchars($categoryFilter) . " Collection" : "All Collections"; ?>
        </h2>

        <div class="category-nav" style="margin: 20px 0; display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="shop.php" class="btn-filter <?php echo empty($categoryFilter) ? 'active' : ''; ?>">All</a>
            <a href="shop.php?cat=Office" class="btn-filter <?php echo $categoryFilter == 'Office' ? 'active' : ''; ?>">Office Wear</a>
            <a href="shop.php?cat=Casual" class="btn-filter <?php echo $categoryFilter == 'Casual' ? 'active' : ''; ?>">Casual</a>
            <a href="shop.php?cat=Evening" class="btn-filter <?php echo $categoryFilter == 'Evening' ? 'active' : ''; ?>">Evening</a>
            <a href="shop.php?cat=Party" class="btn-filter <?php echo $categoryFilter == 'Party' ? 'active' : ''; ?>">Party</a>
        </div>

        <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px; margin-top: 30px;">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($prod = mysqli_fetch_assoc($result)): ?>
                    <div class="product-card" style="border: 1px solid #eee; padding: 15px; text-align: center; transition: 0.3s;">
                        <img src="<?php echo !empty($prod['image_path']) ? $prod['image_path'] : 'images/placeholder.jpg'; ?>" 
                             style="width: 100%; height: 300px; object-fit: cover; margin-bottom: 15px;">
                        <h4 style="margin-bottom: 10px;"><?php echo htmlspecialchars($prod['name']); ?></h4>
                        <p style="color: #DAA520; font-weight: bold; margin-bottom: 15px;">$<?php echo number_format($prod['price'], 2); ?></p>
                        
                        <form action="process-cart-add.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                            <button type="submit" class="btn-gold" style="width: 100%;">Add to Bag</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products found in this collection yet.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>