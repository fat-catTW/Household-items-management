<?php
header("Content-Type:text/html; charset=utf-8");
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>訂單查詢結果</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body id="wrapper-02">
    <div id="header">
        <h1>成員加入結果</h1>
    </div>
    
    <div id="contents">
        <h2><a href="member.html">回到成員</a></h2>
        <?php
        include "db_connect.php";
        
        if (!empty($_POST['TheName'])) {
            $TheName = $_POST['TheName'];
            
            // 使用预处理语句防止SQL注入
            $sql = "INSERT INTO dbo.people (TheName) VALUES (?)";
            $params = array($TheName);
            $stmt = sqlsrv_query($conn, $sql, $params);
            
            if ($stmt) {
                echo "資料插入成功";
            } else {
                echo "資料插入失敗: " . print_r(sqlsrv_errors(), true);
            }
        } else {
            echo "資料插入失敗: 名字欄位不能為空";
        }
        ?>
    </div>
</body>
</html>
