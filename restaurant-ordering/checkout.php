<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Redirect if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Get cart items with details
$cartItems = [];
$total = 0;

foreach ($_SESSION['cart'] as $itemId => $quantity) {
    $item = getItemById($conn, $itemId);
    if ($item) {
        $item['quantity'] = $quantity;
        $item['subtotal'] = $quantity * $item['price'];
        $cartItems[] = $item;
        $total += $item['subtotal'];
    }
}

// Process checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = $_POST['customer_name'] ?? '';
    $customerPhone = $_POST['customer_phone'] ?? '';
    $paymentMethod = $_POST['payment_method'] ?? '';
    
    if (empty($customerName) || empty($customerPhone) || empty($paymentMethod)) {
        $error = "Please fill all required fields";
    } else {
        // Create order
        $orderId = createOrder($conn, $customerName, $customerPhone, $paymentMethod, $cartItems, $total);
        
        if ($orderId) {
            // Clear cart
            $_SESSION['cart'] = [];
            
            // Redirect to order confirmation
            header("Location: order_confirmation.php?id=$orderId");
            exit;
        } else {
            $error = "Failed to process your order. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Food Ordering System</title>
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
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        <h1 class="mb-4">Checkout</h1>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="checkout.php" method="post" id="checkout-form">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="customer_phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_upi" value="upi" required>
                                    <label class="form-check-label" for="payment_upi">
                                        UPI
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_card" value="card">
                                    <label class="form-check-label" for="payment_card">
                                        Card
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_cash" value="cash">
                                    <label class="form-check-label" for="payment_cash">
                                        Cash
                                    </label>
                                </div>
                            </div>
                            
                            <div id="upi-details" class="payment-details mb-3 d-none">
                                <div class="alert alert-info">
                                    <p>Scan the QR code or use UPI ID: jebastinr817@okicici</p>
                                    <img src="images/qr.jpeg" alt="UPI QR Code" class="img-fluid" style="max-width: 200px;">
                                </div>
                            </div>
                            
                            <div id="card-details" class="payment-details mb-3 d-none">
                                <div class="mb-3">
                                    <label for="card_number" class="form-label">Card Number</label>
                                    <input type="text" class="form-control" id="card_number" placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="expiry_date" class="form-label">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiry_date" placeholder="MM/YY">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cvv" placeholder="123">
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
            
 <div class="col-md-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h5 class="mb-0 fw-semibold text-center">Order Summary</h5>
        </div>
        <div class="card-body bg-light rounded-bottom-4">
            <div class="mb-3">
                <?php foreach($cartItems as $item): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2 px-2 py-1 bg-white rounded shadow-sm">
                        <span class="text-muted"><?= $item['name'] ?> x <?= $item['quantity'] ?></span>
                        <span class="fw-semibold text-dark">₹<?= number_format($item['subtotal'], 2) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
            <div class="d-flex justify-content-between px-2">
                <strong class="text-dark">Total</strong>
                <strong class="text-success">₹<?= number_format($total, 2) ?></strong>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.payment-details').forEach(div => {
                    div.classList.add('d-none');
                });
                if (this.value === 'upi') {
                    document.getElementById('upi-details').classList.remove('d-none');
                } else if (this.value === 'card') {
                    document.getElementById('card-details').classList.remove('d-none');
                }
            });
        });
    </script>
</body>
</html>
