<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get all active categories
$categories = getAllActiveCategories($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Ordering System</title>
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
                        <a class="nav-link active" href="index.php">Menu</a>
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

    <!-- Main Content -->
    <div class="container my-4">
        <h1 class="text-center mb-4">Our Menu</h1>
        
        <!-- Categories -->
        <div class="row mb-4">
            <?php foreach($categories as $category): ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <!-- <img src="images/Ambur-Chicken-Biriyani.jpg?= $category['image'] ?>" class="card-img-top" alt="<?= $category['name'] ?>"> -->
                    <img src="images/<?= htmlspecialchars($category['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($category['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $category['name'] ?></h5>
                        <p class="card-text"><?= $category['description'] ?></p>
                        <a href="category.php?id=<?= $category['id'] ?>" class="btn btn-primary">View Items</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
