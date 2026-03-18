<?php
include('includes/db_connect.php');
include('includes/header.php');

// Initialize product as null
$product = null;

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    // Fetch the specific product data
    $query = "SELECT * FROM products WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result); 
}

// If product wasn't found or ID missing, redirect back
if (!$product) {
    header("Location: admin.php");
    exit();
}
?>

<main class="content-wrapper">
    <section class="glam-section" style="max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="color: #DAA520; margin-bottom: 20px;">Edit Product: <?php echo htmlspecialchars($product['name']); ?></h2>
        
        <form action="process-edit.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column;">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            
            <label style="font-weight: bold; margin-bottom: 5px;">Product Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required style="padding: 10px; margin-bottom: 15px; border: 1px solid #ddd;">

            <label style="font-weight: bold; margin-bottom: 5px;">Price ($)</label>
            <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required style="padding: 10px; margin-bottom: 15px; border: 1px solid #ddd;">

            <label style="font-weight: bold; margin-bottom: 5px;">Category</label>
            <select name="category" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd;">
                <option value="Office" <?php if($product['category'] == 'Office') echo 'selected'; ?>>Office Wear</option>
                <option value="Casual" <?php if($product['category'] == 'Casual') echo 'selected'; ?>>Casual Wear</option>
                <option value="Evening" <?php if($product['category'] == 'Evening') echo 'selected'; ?>>Evening Wear</option>
                <option value="Party" <?php if($product['category'] == 'Party') echo 'selected'; ?>>Party Wear</option>
            </select>

            <label style="font-weight: bold; margin-bottom: 5px;">Change Product Image (Leave blank to keep current)</label>
            <div style="margin-bottom: 15px;">
                <img src="<?php echo $product['image_path']; ?>" style="width: 80px; height: 100px; object-fit: cover; display: block; margin-bottom: 10px; border: 1px solid #eee;">
                <input type="file" name="image">
            </div>

            <button type="submit" class="btn-gold" style="padding: 12px; font-weight: bold; cursor: pointer;">Update Product Details</button>
            <a href="admin.php" style="text-align: center; margin-top: 15px; color: #888; text-decoration: none; font-size: 0.9rem;">Cancel and Go Back</a>
        </form>
    </section>
</main>

<?php include('includes/footer.php'); ?>