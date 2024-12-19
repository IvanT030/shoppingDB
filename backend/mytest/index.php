<?php  
header('Access-Control-Allow-Origin: *'); // Allow all origins (or specify a domain like 'http://localhost:5173')
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); // Allowed HTTP methods
header('Access-Control-Allow-Headers: Content-Type, Authorization'); 
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Send a successful response to preflight request (CORS preflight check)
    http_response_code(200);
    exit;
}
require_once __DIR__ . '/config/db.php'; // Include the database connection

$requestUri = str_replace('/mytest', '', $_SERVER['REQUEST_URI']); // Adjust for subfolder

// Parse the URI to extract the path and query
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path'];
$query = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';

if (preg_match('/^\/products\/(\d+)$/', $path, $matches) || $path === '/products') {
    require_once __DIR__ . '/routes/products.php';
}elseif (preg_match('/^\/purchases\/(\d+)$/', $path, $matches) || $path === '/purchases') {
    require_once __DIR__ . '/routes/purchases.php';
} elseif ($path === '/stores') {
    require_once __DIR__ . '/routes/stores.php';
} elseif ($path === '/join') {
    require_once __DIR__ . '/models/join.php';
} elseif (preg_match('/^\/mostPurchasedProduct\/(\d+)$/', $path, $matches)) {
    $storeID = $matches[1]; // 提取 storeID
    require_once __DIR__ . '/models/mostPurchasedProduct.php';
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        getMostPurchasedProductHandler($pdo, $storeID);
    } else {
        http_response_code(405); // 方法不被允许
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    }
}else {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => '404 Not Found']);
}
?>
