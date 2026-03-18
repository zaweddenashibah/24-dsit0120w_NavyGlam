<?php
session_start();
include('includes/db_connect.php');

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // 1. Fetch current cart items to calculate total and prepare for migration
    $cartQuery = "SELECT cart.product_id, cart.quantity, products.price 
                  FROM cart 
                  JOIN products ON cart.product_id = products.id 
                  WHERE cart.user_id = '$userId'";
    $cartResult = mysqli_query($conn, $cartQuery);

    if (mysqli_num_rows($cartResult) > 0) {
        $grandTotal = 0;
        $items = [];
        
        while ($row = mysqli_fetch_assoc($cartResult)) {
            $grandTotal += ($row['price'] * $row['quantity']);
            $items[] = $row;
        }

        // 2. Insert into the main 'orders' table
        $orderSql = "INSERT INTO orders (user_id, total_amount, status) 
                     VALUES ('$userId', '$grandTotal', 'Pending')";
        
        if (mysqli_query($conn, $orderSql)) {
            $orderId = mysqli_insert_id($conn); // Get the ID of the order we just created

            // 3. Move items to 'order_items' table
            foreach ($items as $item) {
                $pId = $item['product_id'];
                $qty = $item['quantity'];
                $prc = $item['price'];
                
                $itemSql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                            VALUES ('$orderId', '$pId', '$qty', '$prc')";
                mysqli_query($conn, $itemSql);
            }

            // 4. Finally, clear the cart
            mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$userId'");

            header("Location: dashboard.php?order=complete");
            exit();
        } else {
            header("Location: checkout.php?error=order_failed");
            exit();
        }
    } else {
        header("Location: shop.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>