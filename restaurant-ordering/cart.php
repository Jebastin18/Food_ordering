<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get cart items with details
$cartItems = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $itemId => $quantity) {
        $item = getItemById($conn, $itemId);
        if ($item) {
            $item['quantity'] = $quantity;
            $item['subtotal'] = $quantity * $item['price'];
            $cartItems[] = $item;
            $total += $item['subtotal'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Food Ordering System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Food Ordering</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Menu</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="cart.php" class="btn btn-outline-light active">
                        <i class="bi bi-cart3"></i> Cart
                        <?php if(count($cartItems) > 0): ?>
                            <span class="badge bg-danger"><?= count($cartItems) ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        <h1 class="mb-4">Your Cart</h1>
        
        <?php if(count($cartItems) > 0): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($cartItems as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="images/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="img-thumbnail me-2" style="width: 50px;">
                                            <?= $item['name'] ?>
                                        </div>
                                    </td>
                                    <td>₹<?= number_format($item['price'], 2) ?></td>
                                    <td>
                                        <form action="update_cart.php" method="post" class="d-flex align-items-center">
                                            <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                            <select name="quantity" class="form-select form-select-sm w-auto me-2" onchange="this.form.submit()">
                                                <?php for($i = 1; $i <= 10; $i++): ?>
                                                    <option value="<?= $i ?>" <?= $i == $item['quantity'] ? 'selected' : '' ?>><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </form>
                                    </td>
                                    <td>₹<?= number_format($item['subtotal'], 2) ?></td>
                                    <td>
                                        <form action="remove_from_cart.php" method="post">
                                            <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th>₹<?= number_format($total, 2) ?></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Continue Shopping
                </a>
                <a href="checkout.php" class="btn btn-success">
                    Proceed to Checkout <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                Your cart is empty. <a href="index.php" class="alert-link">Browse our menu</a> to add items.
            </div>
        <?php endif; ?>
    </div>

   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
