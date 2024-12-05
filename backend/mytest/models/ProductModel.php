<?php
function getAllProducts($pdo) {
    $sql = "SELECT * FROM product"; // Use the correct table name
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addProduct($pdo, $name, $category, $price, $stock) {
    $sql = "INSERT INTO product (ProductName, Category, Price, Stock) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $category, $price, $stock]);
    return $pdo->lastInsertId();
}

function updateProduct($pdo, $productId, $price, $stock) {
    $sql = "UPDATE product SET Price = ?, Stock = ? WHERE ProductID = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$price, $stock, $productId]);
}

function deleteProduct($pdo, $productId) {
    $sql = "DELETE FROM product WHERE ProductID = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$productId]);
}
?>
