<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$orderId = $_GET['id'];
$order = getOrderById($conn, $orderId);
if (!$order) {
    header('Location: index.php');
    exit;
}
$orderItems = getOrderItems($conn, $orderId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Food Ordering System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
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
    <div class="container my-5">
    <div class="card shadow border-0">
        <div class="card-header bg-success text-white text-center py-4">
            <i class="bi bi-check-circle-fill display-4"></i>
            <h3 class="mt-2 mb-0">Order Confirmed</h3>
            <p class="mb-0">Thank you for your order!</p>
        </div>
        <div class="card-body p-5">
            <!-- Order and Customer Details -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="fw-bold">Order Details</h5>
                    <p><strong>Order ID:</strong> #<?= $order['id'] ?></p>
                    <p><strong>Date:</strong> <?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?></p>
                    <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($order['customer_phone']) ?></p>
                    <p><strong>Payment:</strong> <?= ucfirst($order['payment_method']) ?></p>
                </div>
                <div class="col-md-6 text-center">
                    <h5 class="fw-bold">Your Token Number</h5>
                    <div class="bg-light border border-success rounded py-3 mb-2">
                        <span class="display-3 fw-bold text-success"><?= $order['token_number'] ?></span>
                    </div>
                    <small class="text-muted">Please show this token at the counter.</small>
                </div>
            </div>

            <!-- Order Summary Table -->
            <h5 class="fw-bold mb-3">Order Summary</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orderItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td class="text-center"><?= $item['quantity'] ?></td>
                            <td class="text-end">₹<?= number_format($item['price'], 2) ?></td>
                            <td class="text-end">₹<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th class="text-end">₹<?= number_format($order['total_amount'], 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Buttons -->
            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-success px-4">Continue Shopping</a>
                <button onclick="window.print()" class="btn btn-outline-dark ms-2">
                    <i class="bi bi-printer"></i> Print Receipt
                </button>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
