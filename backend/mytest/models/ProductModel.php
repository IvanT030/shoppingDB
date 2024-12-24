<?php
// 獲取所有商品
function getAllProducts($pdo) {
    $stmt = $pdo->query("SELECT * FROM product");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 獲取單個商品
function getProductById($pdo, $productId) {
    $stmt = $pdo->prepare("SELECT * FROM product WHERE ProductID = ?");
    $stmt->execute([$productId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 添加新商品
function addProduct($pdo, $input) {
    $stmt = $pdo->prepare("
        INSERT INTO product (ProductName, Category, Price, SaleVolume)
        VALUES (:ProductName, :Category, :Price, :SaleVolume)
    ");
    $stmt->execute([
        ':ProductName' => $input['ProductName'],
        ':Category' => $input['Category'],
        ':Price' => $input['Price'],
        ':SaleVolume' => $input['SaleVolume'],
    ]);

    return [
        'ProductID' => $pdo->lastInsertId(),
        'ProductName' => $input['ProductName'],
        'Category' => $input['Category'],
        'Price' => $input['Price'],
        'SaleVolume' => $input['SaleVolume'],
    ];
}

// 更新商品
function updateProduct($pdo, $productId, $input) {
    $stmt = $pdo->prepare("
        UPDATE product
        SET ProductName = :ProductName,
            Category = :Category,
            Price = :Price,
            SaleVolume = :SaleVolume
        WHERE ProductID = :ProductID
    ");
    $stmt->execute([
        ':ProductName' => $input['ProductName'],
        ':Category' => $input['Category'],
        ':Price' => $input['Price'],
        ':ProductID' => $productId,
        ':SaleVolume' => $input['SaleVolume'],
    ]);

    return $stmt->rowCount() > 0; // 返回是否有影響的行數
}

// 刪除商品
function deleteProduct($pdo, $productId) {
    $stmt = $pdo->prepare("DELETE FROM product WHERE ProductID = ?");
    $stmt->execute([$productId]);
    return $stmt->rowCount() > 0; // 返回是否刪除成功
}
?>