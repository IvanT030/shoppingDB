<?php
require_once __DIR__ . '/../config/db.php'; // 引入資料庫連接配置

// 確認請求方法為 GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['storeID'])) {
        $storeID = $_GET['storeID'];
        getPurchasesByStoreHandler($pdo, $storeID); // 呼叫帶有 storeID 的處理函數
    } else {
        getAllPurchasesHandler($pdo); // 返回所有進貨記錄
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}

// 根據 StoreID 獲取進貨記錄
function getPurchasesByStoreHandler($pdo, $storeID) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM Purchases WHERE StoreID = ?");
        $stmt->execute([$storeID]); // 執行查詢，傳入 storeID
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result); // 返回 JSON 格式的結果
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Error fetching purchases']);
    }
}

// 獲取所有進貨記錄
function getAllPurchasesHandler($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM Purchases");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result); // 返回 JSON 格式的結果
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Error fetching purchases']);
    }
}
?>
