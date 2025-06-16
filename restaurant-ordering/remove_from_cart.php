<?php
session_start();

// Check if item ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $itemId = (int)$_POST['item_id'];
    
    // Remove from cart
    if (isset($_SESSION['cart'][$itemId])) {
        unset($_SESSION['cart'][$itemId]);
    }
}

// Redirect back to cart
header('Location: cart.php');
exit;
