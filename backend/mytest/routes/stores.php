<?php
require_once __DIR__ . '/../controllers/StoreController.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        getStoreDetailsHandler($pdo, $_GET['id']);
    } else {
        getStoresHandler($pdo);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addStoreHandler($pdo);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    updateStoreHandler($pdo, $_PUT['id']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    deleteStoreHandler($pdo, $_DELETE['id']);
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>
