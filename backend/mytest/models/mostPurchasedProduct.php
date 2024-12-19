<?php
require_once __DIR__ . '/../config/db.php'; // 引入資料庫連接配置

function getMostPurchasedProductHandler($pdo, $storeID) {
    try {
        $stmt = $pdo->prepare("
            SELECT 
                product.ProductName AS name, 
                SUM(purchases.Quantity) AS Quantity
            FROM purchases
            JOIN product ON purchases.ProductID = product.ProductID
            WHERE purchases.StoreID = ?
            GROUP BY purchases.ProductID
            ORDER BY Quantity DESC
            LIMIT 1
        ");
        $stmt->execute([$storeID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            echo json_encode($result); // 返回 JSON 格式的結果
        } else {
            echo json_encode(null); // 如果沒有結果，返回 null
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Error fetching most purchased product']);
    }
}
?>