<?php
require_once __DIR__ . '/../models/PurchaseModel.php';

function getPurchasesHandler($pdo) {
    $purchases = getAllPurchases($pdo);
    header('Content-Type: application/json');
    echo json_encode($purchases);
}
?>
