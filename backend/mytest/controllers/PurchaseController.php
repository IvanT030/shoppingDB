<?php
require_once __DIR__ . '/../models/PurchaseModel.php';

// 獲取所有進貨記錄
function getAllPurchasesHandler($pdo, $storeId) {
    try {
        $purchases = getAllPurchases($pdo, $storeId);
        header('Content-Type: application/json');
        echo json_encode($purchases);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => '無法獲取進貨記錄']);
    }
}

// 新增進貨
function addPurchaseHandler($pdo) {
    $input = json_decode(file_get_contents('php://input'), true);

    // 驗證必要欄位
    if (!isset($input['StoreID'], $input['ProductID'], $input['Quantity'], $input['PurchaseDate'], $input['ExpirationDate'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => '缺少必要的欄位']);
        return;
    }

    try {
        $newPurchase = addPurchase($pdo, $input);
        echo json_encode($newPurchase);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => '無法新增進貨']);
    }
}

// 更新進貨
function updatePurchaseHandler($pdo, $purchaseId) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['StoreID'], $input['ProductID'], $input['Quantity'], $input['PurchaseDate'], $input['ExpirationDate'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => '缺少必要的欄位']);
        return;
    }

    try {
        $result = updatePurchase($pdo, $purchaseId, $input);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => '進貨更新成功']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => '進貨記錄不存在']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => '無法更新進貨']);
    }
}

// 刪除進貨
function deletePurchaseHandler($pdo, $purchaseId) {
    try {
        $result = deletePurchase($pdo, $purchaseId);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => '進貨已刪除']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => '進貨記錄不存在']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => '無法刪除進貨']);
    }
}
?>