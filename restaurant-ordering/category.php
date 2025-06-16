<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$categoryId = $_GET['id'];
$category = getCategoryById($conn, $categoryId);
if (!$category) {
    header('Location: index.php');
    exit;
}
$items = getActiveItemsByCategory($conn, $categoryId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $category['name'] ?> - Food Ordering System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Tasty Bites</a>
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
                    <a href="cart.php" class="btn btn-outline-light">
                        <i class="bi bi-cart3"></i> Cart
                        <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <span class="badge bg-danger"><?= count($_SESSION['cart']) ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?= $category['name'] ?></h1>
            <a href="index.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Menu
            </a>
        </div>
        <div class="row">
            <?php if(count($items) > 0): ?>
                <?php foreach($items as $item): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="images/<?= $item['image'] ?>" class="card-img-top" alt="<?= $item['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $item['name'] ?></h5>
                            <p class="card-text"><?= $item['description'] ?></p>
                            <p class="card-text text-primary fw-bold">₹<?= number_format($item['price'], 2) ?></p>
                            <form action="add_to_cart.php" method="post">
                                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                <div class="d-flex align-items-center mb-3">
                                    <label for="quantity-<?= $item['id'] ?>" class="me-2">Quantity:</label>
                                    <select name="quantity" id="quantity-<?= $item['id'] ?>" class="form-select form-select-sm w-25">
                                        <?php for($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No items available in this category at the moment.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
