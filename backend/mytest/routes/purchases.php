<?php  
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/PurchaseController.php';

// 添加 CORS 支援
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// 預檢請求
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
    
if (preg_match('/^\/purchases\/(\d+)$/', $path, $matches)) {
    $purchaseId = $matches[1];
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // Read the raw POST data (which should be in JSON format)
        $input = json_decode(file_get_contents("php://input"), true);
    
        // Call the update function with the decoded input data
        updatePurchaseHandler($pdo, $purchaseId, $input);
    }
    
     elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // 刪除進貨
        deletePurchaseHandler($pdo, $purchaseId);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        getAllPurchasesHandler($pdo, $purchaseId);
    } else {
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'plz allowed']);
    }
} elseif ($path === '/purchases') {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        addPurchaseHandler($pdo);
    } else {
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'get post 出錯']);
    }
}
?>