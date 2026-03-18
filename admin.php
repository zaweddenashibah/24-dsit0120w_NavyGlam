<?php 
include('includes/db_connect.php');
include('includes/header.php'); 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?error=unauthorized"); exit();
}

// --- 1. HANDLE ACTIONS (Toggle Stock & Delete Message) ---
if (isset($_GET['toggle_stock'])) {
    $pid = $_GET['toggle_stock'];
    $current = $_GET['current'];
    $new = ($current == 'Available') ? 'Out of Stock' : 'Available';
    mysqli_query($conn, "UPDATE products SET stock_status = '$new' WHERE id = '$pid'");
    header("Location: admin.php"); exit();
}

if (isset($_GET['delete_msg'])) {
    $mid = $_GET['delete_msg'];
    mysqli_query($conn, "DELETE FROM messages WHERE id = '$mid'");
    header("Location: admin.php?msg=deleted"); exit();
}

// --- 2. DATA FETCHING ---
$totalSales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) as total FROM orders"))['total'] ?? 0;
$totalMsgs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM messages"))['total'];

// Search Logic
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$searchSQL = !empty($search) ? " WHERE name LIKE '%$search%' OR category LIKE '%$search%'" : "";
$prodResult = mysqli_query($conn, "SELECT * FROM products $searchSQL ORDER BY created_at DESC");

$msgResult = mysqli_query($conn, "SELECT * FROM messages ORDER BY created_at DESC");
?>

<main class="content-wrapper">
    <div style="display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap;">
        <div style="flex: 1; background: #fff; padding: 20px; border-left: 5px solid #DAA520; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
            <small style="color: #888; font-weight: bold; text-transform: uppercase;">Total Revenue</small>
            <h3 style="margin: 5px 0; font-size: 1.5rem;">$<?php echo number_format($totalSales, 2); ?></h3>
        </div>
        <div style="flex: 1; background: #fff; padding: 20px; border-left: 5px solid #000; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
            <small style="color: #888; font-weight: bold; text-transform: uppercase;">Unread Messages</small>
            <h3 style="margin: 5px 0; font-size: 1.5rem;"><?php echo $totalMsgs; ?></h3>
        </div>
    </div>

    <section class="glam-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
            <h2 style="color: #DAA520; margin:0;">Inventory Management</h2>
            
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="add-product.php" class="btn-gold" style="text-decoration: none; padding: 8px 15px; background: #000; color: #DAA520; border: 1px solid #DAA520; font-size: 0.9rem; font-weight: bold; display: inline-block;">+ Add New Product</a>
                
                <form action="admin.php" method="GET" style="display:flex; gap:5px;">
                    <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>" style="padding: 7px 10px; border: 1px solid #ddd;">
                    <button type="submit" class="btn-gold" style="padding: 7px 15px; margin:0; cursor: pointer;">Find</button>
                </form>
            </div>
        </div>

        <div class="cart-table">
            <div class="cart-row header" style="grid-template-columns: 1fr 2fr 1fr 1.5fr;">
                <span>Item</span><span>Details</span><span>Price</span><span>Actions</span>
            </div>
            
            <?php while($prod = mysqli_fetch_assoc($prodResult)): ?>
            <div class="cart-row" style="grid-template-columns: 1fr 2fr 1fr 1.5fr; padding: 10px 0; opacity: <?php echo ($prod['stock_status'] == 'Available') ? '1' : '0.5'; ?>;">
                <img src="<?php echo $prod['image_path']; ?>" alt="Product" style="width: 40px; height: 50px; object-fit: cover; border-radius: 2px;">
                <div><strong><?php echo htmlspecialchars($prod['name']); ?></strong><br><small><?php echo htmlspecialchars($prod['category']); ?></small></div>
                <div>$<?php echo number_format($prod['price'], 2); ?></div>
                <div style="display:flex; gap:12px; font-size: 0.75rem;">
                    <a href="admin.php?toggle_stock=<?php echo $prod['id']; ?>&current=<?php echo $prod['stock_status']; ?>" style="color: #000; font-weight: bold; text-decoration: none; border-bottom: 1px solid #000;">
                        <?php echo ($prod['stock_status'] == 'Available') ? 'Mark OOS' : 'Restock'; ?>
                    </a>
                    <a href="edit-product.php?id=<?php echo $prod['id']; ?>" style="color: #DAA520; text-decoration: none; font-weight: bold;">Edit</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <section class="glam-section" style="margin-top: 40px;">
        <h2 style="color: #DAA520;">Customer Inbox</h2>
        <div class="cart-table">
            <div class="cart-row header" style="grid-template-columns: 1.5fr 3fr 1fr;">
                <span>Sender</span><span>Message</span><span>Action</span>
            </div>
            
            <?php if(mysqli_num_rows($msgResult) > 0): ?>
                <?php while($m = mysqli_fetch_assoc($msgResult)): ?>
                <div class="cart-row" style="grid-template-columns: 1.5fr 3fr 1fr; padding: 15px 0; align-items: start;">
                    <div><strong><?php echo htmlspecialchars($m['name']); ?></strong><br><small><?php echo htmlspecialchars($m['email']); ?></small></div>
                    <div style="font-size: 0.85rem; color: #555;"><?php echo nl2br(htmlspecialchars($m['message'])); ?></div>
                    <div><a href="admin.php?delete_msg=<?php echo $m['id']; ?>" style="color: #ff4444; font-size: 0.8rem; font-weight: bold;" onclick="return confirm('Delete message?')">Delete</a></div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="padding: 20px; text-align: center; color: #888;">No messages found.</div>
            <?php endif; ?>
        </div>
    </section>
</main>