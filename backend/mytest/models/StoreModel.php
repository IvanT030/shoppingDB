<?php
function getAllProducts($pdo) {
    $sql = "SELECT * FROM Products";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all products
}

function getProductById($pdo, $productId) {
    $sql = "SELECT * FROM Products WHERE ProductID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$productId]);
    return $stmt->fetch(PDO::FETCH_ASSOC); // Return the product
}

function addProduct($pdo, $name, $category, $price, $stock) {
    $sql = "INSERT INTO Products (ProductName, Category, Price, Stock) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $category, $price, $stock]);
    return $pdo->lastInsertId(); // Return new product ID
}

function updateProduct($pdo, $productId, $price, $stock) {
    $sql = "UPDATE Products SET Price = ?, Stock = ? WHERE ProductID = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$price, $stock, $productId]); // Return success/failure
}

function deleteProduct($pdo, $productId) {
    $sql = "DELETE FROM Products WHERE ProductID = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$productId]); // Return success/failure
}
?>
