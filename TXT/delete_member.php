<?php
header("Content-Type:text/html; charset=utf-8");
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>資料刪除結果</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body id="wrapper-02">
    <div id="header">
        <h1>資料刪除結果</h1>
    </div>
    
    <div id="contents">
        <h2><a href="member.html">回到成員</a></h2>
        <?php
        include "db_connect.php";

        if (!empty($_POST['Name'])) {
            $TheName = $_POST['Name'];

            // 使用预处理语句防止SQL注入
            $sql = "DELETE FROM dbo.people WHERE TheName = ?";
            $params = array($TheName);

            $stmt = sqlsrv_query($conn, $sql, $params);

            if ($stmt) {
                echo "資料刪除成功";
            } else {
                echo "資料刪除失敗: " . print_r(sqlsrv_errors(), true);
            }
        } else {
            echo "資料刪除失敗: 名字欄位不能為空";
        }
        ?>
    </div>
</body>
</html>

