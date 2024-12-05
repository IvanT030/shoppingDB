<?php
require_once __DIR__ . '/config/db.php';

try {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Connected successfully! Tables in the database:\n";
    print_r($tables);
} catch (PDOException $e) {
    echo "Database query failed: " . $e->getMessage();
}
?>
