<?php
require_once __DIR__ . '/config/db.php'; // Include the database connection

$requestUri = str_replace('/mytest', '', $_SERVER['REQUEST_URI']); // Adjust for subfolder

if ($requestUri === '/products') {
    require_once __DIR__ . '/routes/products.php';
} elseif ($requestUri === '/purchases') {
    require_once __DIR__ . '/routes/purchases.php';
} elseif ($requestUri === '/stores') {
    require_once __DIR__ . '/routes/stores.php';
} else {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => '404 Not Found']);
}
?>
