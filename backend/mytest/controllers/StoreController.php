<?php
require_once __DIR__ . '/../models/StoreModel.php';

function getStoresHandler($pdo) {
    $stores = getAllStores($pdo);
    header('Content-Type: application/json');
    echo json_encode($stores);
}

function getStoreDetailsHandler($pdo, $storeId) {
    $store = getStoreById($pdo, $storeId);
    header('Content-Type: application/json');
    echo json_encode($store);
}

function addStoreHandler($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    $storeId = addStore($pdo, $data['StoreName'], $data['StoreNumber'], $data['City']);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'StoreID' => $storeId]);
}

function updateStoreHandler($pdo, $storeId) {
    $data = json_decode(file_get_contents('php://input'), true);
    $success = updateStore($pdo, $storeId, $data['StoreName'], $data['StoreNumber'], $data['City']);
    header('Content-Type: application/json');
    echo json_encode(['status' => $success ? 'success' : 'error']);
}

function deleteStoreHandler($pdo, $storeId) {
    $success = deleteStore($pdo, $storeId);
    header('Content-Type: application/json');
    echo json_encode(['status' => $success ? 'success' : 'error']);
}
?>
