<?php
$serverName = "DESKTOP-LLG2J1G\SQLEXPRESS"; // SQL Server 地址
$connectionOptions = array(
    "Database" => "CCUFood",
    "Uid" => "Hsiao",
    "PWD" => "123456",
    "CharacterSet" => "UTF-8"
);

// 建立连接
try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=CCUFood", "Hsiao", "123546");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
