// Example JS to place in your footer or a separate script file
function addToCart(productId) {
    const isLoggedIn = false; // This would be dynamically set by your backend

    if (!isLoggedIn) {
        alert("Please Login or Signup to start shopping at NAVY GLAM.");
        window.location.href = "login.php";
    } else {
        // Logic to actually add the item to the database/session cart
        console.log("Product " + productId + " added to cart!");
        alert("Added to cart successfully!");
    }
}

function proceedToCheckout() {
    // In a real app, you'd check if the cart is empty first.
    // For now, we redirect to our "Coming Soon" page.
    window.location.href = "payment-coming-soon.php";
}