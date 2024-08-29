<?php
include 'db_connection.php'; // 包含数据库连接文件

header('Content-Type: application/json');

$sql = "SELECT * FROM restaurants";
$stmt = $conn->query($sql);
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($restaurants);
?>
