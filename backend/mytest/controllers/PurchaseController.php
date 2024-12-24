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

    // Validate the required fields (including PurchaseID)
    if (!isset($input['PurchaseID'], $input['StoreID'], $input['ProductID'], $input['Quantity'], $input['PurchaseDate'], $input['ExpirationDate'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        return;
    }

    // Prepare the query to insert a new purchase
    try {
        // Check if the provided PurchaseID already exists
        $stmt = $pdo->prepare("SELECT * FROM purchases WHERE PurchaseID = :PurchaseID");
        $stmt->execute([':PurchaseID' => $input['PurchaseID']]);
        $existingPurchase = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingPurchase) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'PurchaseID already exists']);
            return;
        }

        // Proceed with the insert if PurchaseID is unique
        $stmt = $pdo->prepare("
            INSERT INTO purchases (PurchaseID, StoreID, ProductID, Quantity, PurchaseDate, ExpirationDate)
            VALUES (:PurchaseID, :StoreID, :ProductID, :Quantity, :PurchaseDate, :ExpirationDate)
        ");

        // Execute the query with the input data
        $stmt->execute([
            ':PurchaseID' => $input['PurchaseID'],  // Insert manually provided PurchaseID
            ':StoreID' => $input['StoreID'],
            ':ProductID' => $input['ProductID'],
            ':Quantity' => $input['Quantity'],
            ':PurchaseDate' => $input['PurchaseDate'],
            ':ExpirationDate' => $input['ExpirationDate']
        ]);

        // Fetch the inserted data to return in the response
        $newPurchase = [
            'PurchaseID' => $input['PurchaseID'],  // Use the provided PurchaseID
            'StoreID' => $input['StoreID'],
            'ProductID' => $input['ProductID'],
            'Quantity' => $input['Quantity'],
            'PurchaseDate' => $input['PurchaseDate'],
            'ExpirationDate' => $input['ExpirationDate']
        ];

        // Return the newly created purchase as a JSON response
        echo json_encode($newPurchase);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Error adding purchase']);
    }
}

// 更新進貨
function updatePurchaseHandler($pdo, $purchaseId) {
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate the required fields
    if (!isset($input['StoreID'], $input['ProductID'], $input['Quantity'], $input['PurchaseDate'], $input['ExpirationDate'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => '缺少必要的欄位']);
        return;
    }

    try {
        // Attempt to update purchase
        $result = updatePurchase($pdo, $purchaseId, $input);

        // Check if the update was successful
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => '進貨更新成功']);
        } else {
            // If no rows were affected, return a 404 (not found) response
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => '進貨記錄不存在']);
        }
    } catch (PDOException $e) {
        // Handle the error and check if it's related to the trigger
        if ($e->getCode() == '45000') { 
            echo json_encode(['status' => 'error', 'message' => '觸發器錯誤：進貨數量不能為負']);
        } else {
            echo json_encode(['status' => 'error', 'message' => '無法更新進貨', 'details' => $e->getMessage()]);
        }
    } catch (Exception $e) {
        // Catch other types of exceptions and return a generic error message
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => '無法更新進貨', 'details' => $e->getMessage()]);
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