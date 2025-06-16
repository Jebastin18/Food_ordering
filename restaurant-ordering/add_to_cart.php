<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if item ID and quantity are provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id']) && isset($_POST['quantity'])) {
    $itemId = (int)$_POST['item_id'];
    $quantity = (int)$_POST['quantity'];
    
    // Validate item exists and is active
    $item = getItemById($conn, $itemId);
    if ($item && $item['status'] == 'active' && $quantity > 0) {
        // Add to cart
        if (isset($_SESSION['cart'][$itemId])) {
            $_SESSION['cart'][$itemId] += $quantity;
        } else {
            $_SESSION['cart'][$itemId] = $quantity;
        }
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => "{$item['name']} added to cart."
        ];
    }
}

$referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header("Location: $referer");
exit;
