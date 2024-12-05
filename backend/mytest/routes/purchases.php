<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/PurchaseController.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    getPurchasesHandler($pdo);
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>
