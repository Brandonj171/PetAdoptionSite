<?php
require_once 'config.php';

try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Database connection successful.";
} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage();
}
