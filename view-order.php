<?php
include('includes/db_connect.php');
include('includes/header.php');

// 1. Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?error=unauthorized");
    exit();
}

// 2. Handle Status Update
if (isset($_POST['update_status'])) {
    $newStatus = mysqli_real_escape_string($conn, $_POST['order_status']);
    $oid = mysqli_real_escape_string($conn, $_POST['order_id']);
    
    $updateSql = "UPDATE orders SET status = '$newStatus' WHERE id = '$oid'";
    if (mysqli_query($conn, $updateSql)) {
        $msg = "Order status updated successfully!";
    }
}

// 3. Fetch Order & Customer Details
if (isset($_GET['id'])) {
    $orderId = mysqli_real_escape_string($conn, $_GET['id']);
    
    $orderQuery = "SELECT orders.*, users.full_name, users.email 
                   FROM orders 
                   JOIN users ON orders.user_id = users.id 
                   WHERE orders.id = '$orderId'";
    $orderRes = mysqli_query($conn, $orderQuery);
    $order = mysqli_fetch_assoc($orderRes);

    // Fetch Items in this order
    $itemQuery = "SELECT order_items.*, products.name, products.image_path 
                  FROM order_items 
                  JOIN products ON order_items.product_id = products.id 
                  WHERE order_items.order_id = '$orderId'";
    $itemsResult = mysqli_query($conn, $itemQuery);
} else {
    header("Location: admin.php");
    exit();
}
?>

<main class="content-wrapper">
    <section class="glam-section">
        <h2 style="color: #DAA520;">Order Details: #GLAM-<?php echo $orderId; ?></h2>
        <a href="admin.php" style="text-decoration: none; color: #888; font-size: 0.8rem;">&larr; Back to Dashboard</a>

        <?php if(isset($msg)): ?>
            <div style="background: #d4edda; color: #155724; padding: 10px; margin: 20px 0; border-radius: 4px;"><?php echo $msg; ?></div>
        <?php endif; ?>

        <div style="display: flex; gap: 40px; margin-top: 30px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px; background: #f9f9f9; padding: 20px; border-radius: 8px;">
                <h4 style="text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid #ddd;">Customer Info</h4>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($order['full_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                <p><strong>Order Date:</strong> <?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
                <p><strong>Current Status:</strong> <span class="badge-new"><?php echo strtoupper($order['status']); ?></span></p>
            </div>

            <div style="flex: 1; min-width: 250px; background: #fff; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
                <h4 style="text-transform: uppercase; margin-bottom: 15px;">Update Order Status</h4>
                <form action="" method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $orderId; ?>">
                    <select name="order_status" style="width: 100%; padding: 10px; margin-bottom: 15px;">
                        <option value="Pending" <?php if($order['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Processing" <?php if($order['status'] == 'Processing') echo 'selected'; ?>>Processing</option>
                        <option value="Shipped" <?php if($order['status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                        <option value="Delivered" <?php if($order['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                        <option value="Cancelled" <?php if($order['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>
                    <button type="submit" name="update_status" class="btn-gold" style="width: 100%;">Update Status</button>
                </form>
            </div>
        </div>

        <h3 style="margin-top: 50px; text-transform: uppercase; letter-spacing: 1px;">Items Purchased</h3>
        <div class="cart-table" style="margin-top: 20px;">
            <div class="cart-row header" style="grid-template-columns: 1fr 3fr 1fr 1fr;">
                <span>Image</span>
                <span>Product Name</span>
                <span>Qty</span>
                <span>Price</span>
            </div>

            <?php while($item = mysqli_fetch_assoc($itemsResult)): ?>
                <div class="cart-row" style="grid-template-columns: 1fr 3fr 1fr 1fr; padding: 15px 0; align-items: center;">
                    <div><img src="<?php echo $item['image_path']; ?>" style="width: 60px; height: 80px; object-fit: cover; border: 1px solid #eee;"></div>
                    <div style="font-weight: bold;"><?php echo htmlspecialchars($item['name']); ?></div>
                    <div><?php echo $item['quantity']; ?></div>
                    <div>$<?php echo number_format($item['price'], 2); ?></div>
                </div>
            <?php endwhile; ?>

            <div style="text-align: right; margin-top: 30px; font-size: 1.5rem;">
                <strong>Order Total: <span style="color: #DAA520;">$<?php echo number_format($order['total_amount'], 2); ?></span></strong>
            </div>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>