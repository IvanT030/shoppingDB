<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/ProductController.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo json_encode(getAllProducts($pdo));
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addProductHandler($pdo); // Pass $pdo to the controller
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $productId = $_PUT['id'] ?? null;
    if ($productId) {
        updateProductHandler($pdo, $productId);
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Product ID is required.']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    deleteProductHandler($pdo, $_DELETE['id']); // Pass $pdo to the controller
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>
