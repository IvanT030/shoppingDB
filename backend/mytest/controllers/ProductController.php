<?php
require_once __DIR__ . '/../models/ProductModel.php';

// 獲取所有商品
function getProductsHandler($pdo) {
    try {
        $products = getAllProducts($pdo);
        header('Content-Type: application/json');
        echo json_encode($products);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => '無法獲取商品列表']);
    }
}

/* 獲取特定商品
function getProductByIdHandler($pdo, $productId) {
    try {
        $product = getProductById($pdo, $productId); // 從模型調用
        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404); // 商品不存在
            echo json_encode(['status' => 'error', 'message' => '商品不存在']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => '無法獲取商品']);
    }
}*/

// 添加新商品
function addProductHandler($pdo) {
    $input = json_decode(file_get_contents('php://input'), true);

    // 驗證必要欄位
    if (!isset($input['ProductName'], $input['Category'], $input['Price'], $input['SalesVolume'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => '缺少必要的欄位']);
        return;
    }

    try {
        $newProduct = addProduct($pdo, $input); // 調用模型函數
        echo json_encode($newProduct); // 返回新增的商品資料
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => '無法添加商品']);
    }
}

// 更新商品
function updateProductHandler($pdo, $productId) {
    $input = json_decode(file_get_contents('php://input'), true);

    // 驗證必要欄位
    if (!isset($input['ProductName'], $input['Category'], $input['Price'], $input['SalesVolume'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => '缺少必要的欄位']);
        return;
    }

    try {
        $result = updateProduct($pdo, $productId, $input); // 調用模型函數
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => '商品更新成功']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => '商品不存在']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => '無法更新商品']);
    }
}

/* 刪除商品
function deleteProductHandler($pdo, $productId) {
    try {
        $result = deleteProduct($pdo, $productId); // 調用模型函數
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => '商品已刪除']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => '商品不存在']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => '無法刪除商品']);
    }
}
?>*/