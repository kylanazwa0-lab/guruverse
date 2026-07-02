<?php
// ============================================
// modules/member/products/get_products.php
// ============================================

header('Content-Type: application/json; charset=utf-8');
require_once '../../../database/config.php';

$conn = getConnection();
$type = $_GET['type'] ?? null;

if ($type) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE type = ? ORDER BY created_at DESC");
    $stmt->bind_param('s', $type);
} else {
    $stmt = $conn->prepare("SELECT * FROM products ORDER BY created_at DESC");
}

$stmt->execute();
$result = $stmt->get_result();
$products = [];

while ($row = $result->fetch_assoc()) {
    $row['price_formatted'] = 'Rp' . number_format($row['price'], 0, ',', '.');
    $products[] = $row;
}

echo json_encode(['success' => true, 'data' => $products]);

$stmt->close();
$conn->close();
