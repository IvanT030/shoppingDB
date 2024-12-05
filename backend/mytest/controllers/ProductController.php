<?php
require_once __DIR__ . '/../models/ProductModel.php';

function getProductsHandler($pdo) {
    $products = getAllProducts($pdo); // Call the model function with $pdo
    header('Content-Type: application/json');
    echo json_encode($products);
}

function addProductHandler($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = addProduct($pdo, $data['ProductName'], $data['Category'], $data['Price'], $data['Stock']); // Pass $pdo
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'ProductID' => $productId]);
}

function updateProductHandler($pdo, $productId) {
    $data = json_decode(file_get_contents('php://input'), true);
    $success = updateProduct($pdo, $productId, $data['Price'], $data['Stock']);
    header('Content-Type: application/json');
    echo json_encode(['status' => $success ? 'success' : 'error']);
}

function deleteProductHandler($pdo, $productId) {
    $success = deleteProduct($pdo, $productId); // Pass $pdo
    header('Content-Type: application/json');
    echo json_encode(['status' => $success ? 'success' : 'error']);
}
?>
