<?php 
include('includes/db_connect.php');
include('includes/header.php'); 
?>

<main class="content-wrapper">
    <section class="glam-section" style="max-width: 600px; margin: 0 auto;">
        <h2 style="color: #DAA520;">Add New Collection Item</h2>
        <form action="process-add-product.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="text" name="name" placeholder="Product Name (e.g. Navy Blue 3-Piece)" required style="padding: 10px;">
            <input type="number" name="price" placeholder="Price ($)" step="0.01" required style="padding: 10px;">
            
            <select name="category" style="padding: 10px;">
                <option value="Office">Office Wear</option>
                <option value="Casual">Casual Wear</option>
                <option value="Evening">Evening Wear</option>
            </select>

            <label>Product Image</label>
            <input type="file" name="image" required>

            <button type="submit" class="btn-gold" style="padding: 15px;">Upload to Shop</button>
        </form>
    </section>
</main>