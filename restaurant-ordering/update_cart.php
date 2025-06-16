<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Check if item ID and quantity are provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id']) && isset($_POST['quantity'])) {
    $itemId = (int)$_POST['item_id'];
    $quantity = (int)$_POST['quantity'];
    
    // Update cart
    if ($quantity > 0) {
        $_SESSION['cart'][$itemId] = $quantity;
    } else {
        unset($_SESSION['cart'][$itemId]);
    }
}

// Redirect back to cart
header('Location: cart.php');
exit;
