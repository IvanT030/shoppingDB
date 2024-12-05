<?php
function getAllPurchases($pdo) {
    $sql = "SELECT * FROM purchases";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
