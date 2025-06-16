<?php
function getAllActiveCategories($conn) {
    $stmt = $conn->prepare("SELECT * FROM categories WHERE status = 'active' ORDER BY name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get category by ID
function getCategoryById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get all active items in a category
function getActiveItemsByCategory($conn, $categoryId) {
    $stmt = $conn->prepare("SELECT * FROM items WHERE category_id = :category_id AND status = 'active' ORDER BY name");
    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get item by ID
function getItemById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM items WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function createOrder($conn, $customerName, $customerPhone, $paymentMethod, $items, $total) {
    try {
        $today = date('Y-m-d');
        $conn->beginTransaction();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE order_date = :today");
        $stmt->bindParam(':today', $today);
        $stmt->execute();
        $tokenCount = $stmt->fetchColumn();
        $tokenNumber = $tokenCount + 1;
        $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_phone, payment_method, total_amount, token_number, order_date) 
                                VALUES (:customer_name, :customer_phone, :payment_method, :total_amount, :token_number, :order_date)");
        $stmt->bindParam(':customer_name', $customerName);
        $stmt->bindParam(':customer_phone', $customerPhone);
        $stmt->bindParam(':payment_method', $paymentMethod);
        $stmt->bindParam(':total_amount', $total);
        $stmt->bindParam(':token_number', $tokenNumber);
        $stmt->bindParam(':order_date', $today);
        $stmt->execute();
        $orderId = $conn->lastInsertId();
        foreach ($items as $item) {
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, item_id, quantity, price) 
                                    VALUES (:order_id, :item_id, :quantity, :price)");
            $stmt->bindParam(':order_id', $orderId);
            $stmt->bindParam(':item_id', $item['id']);
            $stmt->bindParam(':quantity', $item['quantity']);
            $stmt->bindParam(':price', $item['price']);
            $stmt->execute();
        }
        $conn->commit();
        return $orderId;
    } catch (Exception $e) {
        $conn->rollBack();
        return false;
    }
}
function getOrderById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getOrderItems($conn, $orderId) {
    $stmt = $conn->prepare("
        SELECT oi.*, i.name 
        FROM order_items oi
        JOIN items i ON oi.item_id = i.id
        WHERE oi.order_id = :order_id
    ");
    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
