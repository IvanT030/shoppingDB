<?php
require_once __DIR__ . '/../config/db.php'; // 引入数据库连接配置

// 确保请求方法为 GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    getAllJoinedPurchases($pdo); // 获取所有联结数据
} else {
    http_response_code(405); // 方法不被允许
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}

// 获取所有联结数据
function getAllJoinedPurchases($pdo) {
    try {
        // 修复后的 SQL 查询
        $stmt = $pdo->prepare("
            SELECT 
                stores.StoreID,
                stores.StoreName,
                stores.City,
                Purchases.ProductID,
                Purchases.Quantity,
                Purchases.PurchaseDate,
                Purchases.ExpirationDate
            FROM 
                stores
            INNER JOIN 
                Purchases
            ON 
                stores.StoreID = Purchases.StoreID
        ");
        $stmt->execute(); // 没有参数需要传递
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // 获取所有查询结果
        echo json_encode($result); // 将结果转换为 JSON 格式并输出
    } catch (Exception $e) {
        http_response_code(500); // 内部服务器错误
        echo json_encode(['status' => 'error', 'message' => 'Error fetching joined data', 'details' => $e->getMessage()]);
    }
}
?>