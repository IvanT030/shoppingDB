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

// 根據請求方法分發到相應的處理器
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo json_encode(getAllProducts($pdo));
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addProductHandler($pdo); // 新增商品
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // 獲取 URL 路徑中的 ProductID
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uriParts = explode('/', $uri);
    $productId = end($uriParts);  // 获取 URL 中的最后部分（ProductID）

    if ($productId) {
        parse_str(file_get_contents("php://input"), $_PUT);  // 获取 PUT 请求中的数据
        updateProductHandler($pdo, $productId, $_PUT);  // 调用更新商品的处理函数
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Product ID is required.']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    deleteProductHandler($pdo, $_DELETE['id']);
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>
