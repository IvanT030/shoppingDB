<?php  
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// 添加 CORS 支援
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// 處理預檢請求
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if (preg_match('/^\/products\/(\d+)$/', $path, $matches)) {
    $productId = $matches[1];
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // Handle PUT request for updating the product
        parse_str(file_get_contents("php://input"), $_PUT);
        updateProductHandler($pdo, $productId, $_PUT); // Call the update function
    } else {
        http_response_code(405); // Method Not Allowed
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    }
} elseif ($path === '/products') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        getProductsHandler($pdo); // Directly call the controller function to get all products
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        addProductHandler($pdo); // Add a new product
    } else {
        http_response_code(405); // Method Not Allowed
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    }
}
?>
