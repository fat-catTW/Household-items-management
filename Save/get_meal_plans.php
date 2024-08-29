<?php
include 'db_connection.php'; // 包含数据库连接文件

header('Content-Type: application/json');

$user_id = $_GET['user_id']; // 获取用户 ID

$sql = "SELECT mp.id, r.name, r.address, mp.meal_date 
        FROM meal_plans mp
        JOIN restaurants r ON mp.restaurant_id = r.id
        WHERE mp.user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$mealPlans = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($mealPlans);
?>
