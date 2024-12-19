<?php
// 獲取所有進貨記錄
function getAllPurchases($pdo, $storeId) {
    $stmt = $pdo->prepare("SELECT * FROM purchases Where StoreID = ?");
    $stmt->execute([$storeId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 新增進貨
function addPurchase($pdo, $input) {
    $stmt = $pdo->prepare("
        INSERT INTO purchases (StoreID, ProductID, Quantity, PurchaseDate, ExpirationDate)
        VALUES (:StoreID, :ProductID, :Quantity, :PurchaseDate, :ExpirationDate)
    ");
    $stmt->execute([
        ':StoreID' => $input['StoreID'],
        ':ProductID' => $input['ProductID'],
        ':Quantity' => $input['Quantity'],
        ':PurchaseDate' => $input['PurchaseDate'],
        ':ExpirationDate' => $input['ExpirationDate'],
    ]);

    return [
        'PurchaseID' => $pdo->lastInsertId(),
        'StoreID' => $input['StoreID'],
        'ProductID' => $input['ProductID'],
        'Quantity' => $input['Quantity'],
        'PurchaseDate' => $input['PurchaseDate'],
        'ExpirationDate' => $input['ExpirationDate'],
    ];
}

// 更新進貨
function updatePurchase($pdo, $purchaseId, $input) {
    $stmt = $pdo->prepare("
        UPDATE purchases
        SET StoreID = :StoreID,
            ProductID = :ProductID,
            Quantity = :Quantity,
            PurchaseDate = :PurchaseDate,
            ExpirationDate = :ExpirationDate
        WHERE PurchaseID = :PurchaseID
    ");
    $stmt->execute([
        ':StoreID' => $input['StoreID'],
        ':ProductID' => $input['ProductID'],
        ':Quantity' => $input['Quantity'],
        ':PurchaseDate' => $input['PurchaseDate'],
        ':ExpirationDate' => $input['ExpirationDate'],
        ':PurchaseID' => $purchaseId,
    ]);

    return $stmt->rowCount() > 0;
}

// 刪除進貨
function deletePurchase($pdo, $purchaseId) {
    $stmt = $pdo->prepare("DELETE FROM purchases WHERE `PurchaseID = ?");
    $stmt->execute([$purchaseId]);
    return $stmt->rowCount() > 0;
}
?>