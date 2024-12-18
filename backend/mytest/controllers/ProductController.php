<?php
require_once __DIR__ . '/../models/ProductModel.php';

function getProductsHandler($pdo) {
    $products = getAllProducts($pdo); // Call the model function with $pdo
    header('Content-Type: application/json');
    echo json_encode($products);
}

function addProductHandler($pdo) {
    $input = json_decode(file_get_contents('php://input'), true);

    // 檢查必填欄位
    if (!isset($input['ProductName'], $input['Category'], $input['Price'], $input['Stock'], $input['SaleVolume'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => '缺少必要的欄位']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO product (ProductName, Category, Price, Stock, SaleVolume)
            VALUES (:ProductName, :Category, :Price, :Stock, :SaleVolume)
        ");
        $stmt->execute([
            ':ProductName' => $input['ProductName'],
            ':Category' => $input['Category'],
            ':Price' => $input['Price'],
            ':Stock' => $input['Stock'],
            ':SaleVolume' => $input['SaleVolume'],
        ]);

        $lastId = $pdo->lastInsertId();
        echo json_encode([
            'ProductID' => $lastId,
            'ProductName' => $input['ProductName'],
            'Category' => $input['Category'],
            'Price' => $input['Price'],
            'Stock' => $input['Stock'],
            'SaleVolume' => $input['SaleVolume'],
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

function getProductByIdHandler($pdo, $productId) {
    try {
        // Prepare the SQL query to get the product by ID
        $stmt = $pdo->prepare("SELECT * FROM product WHERE ProductID = ?");
        $stmt->execute([$productId]); // Pass the product ID as a parameter
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Return the product data as a JSON response
            echo json_encode($product);
        } else {
            http_response_code(404); // Not found
            echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal server error
        echo json_encode(['status' => 'error', 'message' => 'Error fetching product']);
    }
}

function updateProductHandler($pdo, $productID) {
    // 解析前端發送的 JSON 請求
    $input = json_decode(file_get_contents('php://input'), true);

    // 確保所有欄位都存在
    if (!isset($input['ProductName'], $input['Category'], $input['Price'], $input['Stock'], $input['SaleVolume'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => '缺少必要的欄位']);
        return;
    }

    // 更新數據庫
    try {
        $stmt = $pdo->prepare("
            UPDATE product 
            SET ProductName = :ProductName, 
                Category = :Category, 
                Price = :Price, 
                Stock = :Stock, 
                SaleVolume = :SaleVolume
            WHERE ProductID = :ProductID
        ");
        $stmt->execute([
            ':ProductName' => $input['ProductName'],
            ':Category' => $input['Category'],
            ':Price' => $input['Price'],
            ':Stock' => $input['Stock'],
            ':SaleVolume' => $input['SaleVolume'],
            ':ProductID' => $productID
        ]);

        // 確認是否有更新行數，避免錯誤的 ID
        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => '商品更新成功']);
        } else {
            // 若沒有任何行數受影響，表示沒有找到該商品
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

function deleteProductHandler($pdo, $productId) {
    try {
        $stmt = $pdo->prepare("DELETE FROM product WHERE ProductID = ?");
        $stmt->execute([$productId]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Product deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
