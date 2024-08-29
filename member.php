<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>成員</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <!--[if IE 7]>
        <link rel="stylesheet" href="css/ie7.css" type="text/css" />
    <![endif]-->

    <script>
        function toggleInputs() {
            var operation = document.getElementById("operation").value;
            var queryInputs = document.getElementById("queryInputs");
            var insertInputs = document.getElementById("insertInputs");
            var deleteInputs = document.getElementById("deleteInputs");
            var updateInputs = document.getElementById("updateInputs");

            queryInputs.style.display = "none";
            insertInputs.style.display = "none";
            deleteInputs.style.display = "none";
            updateInputs.style.display = "none";

            if (operation === "query") {
                queryInputs.style.display = "block";
            } else if (operation === "insert") {
                insertInputs.style.display = "block";
            } else if (operation === "delete") {
                deleteInputs.style.display = "block";
            } else if (operation === "update") {
                updateInputs.style.display = "block";
            }
        }
    </script>
</head>
<body>
    <div class="page">
        <div class="header">
            <a href="index.html" id="logo"><img src="images/logo.jpg" width="160" height="64" alt=""/></a>
            <ul>
                <li><a href="index.html">首頁</a></li>
                <li><a href="shoppinglist.php">購物清單</a></li>
                <li><a href="stock.php">庫存</a></li>
                <li class="selected"><a href="member.php">成員</a></li>
            </ul>
        </div>

        <div class="body">
            <div id="header">
                <h1>成員管理</h1>
            </div>

            <div id="contents">
                <!-- 操作选择表单 -->
                <form method="post" action="">
                    <label for="operation">選擇操作：</label>
                    <select id="operation" name="operation" onchange="toggleInputs()">
                        <option value="query">查詢</option>
                        <option value="insert">新增</option>
                        <option value="delete">删除</option>
                        <option value="update">更新</option>
                    </select>
                    <br>

                    <!-- 查詢输入框 -->
                    <div id="queryInputs" style="display:block;">
                        <label for="queryMember">成員名稱：</label>
                        <input type="text" id="queryMember" name="queryMember">
                        <br>
                        <label for="queryTitle">稱謂：</label>
                        <input type="text" id="queryTitle" name="queryTitle">
                    </div>

                    <!-- 新增输入框 -->
                    <div id="insertInputs" style="display:none;">
                        <label for="insertMember">成員名稱：</label>
                        <input type="text" id="insertMember" name="insertMember">
                        <br>
                        <label for="insertTitle">稱謂：</label>
                        <input type="text" id="insertTitle" name="insertTitle">
                    </div>

                    <!-- 删除输入框 -->
                    <div id="deleteInputs" style="display:none;">
                        <label for="deleteMember">成員名稱：</label>
                        <input type="text" id="deleteMember" name="deleteMember">
                    </div>

                    <!-- 更新输入框 -->
                    <div id="updateInputs" style="display:none;">
                        <label for="updateMember">成員名稱：</label>
                        <input type="text" id="updateMember" name="updateMember">
                        <br>
                        <label for="updateTitle">新的稱謂：</label>
                        <input type="text" id="updateTitle" name="updateTitle">
                    </div>

                    <input type="submit" value="執行">
                </form>
            </div>
        </div>

        <style>
            table {
                margin: 0 auto; /* 居中显示表格 */
                border-collapse: collapse; /* 合并表格边框 */
            }
            th, td {
                border: 1px solid black; /* 设置表格边框 */
                padding: 8px; /* 设置单元格内边距 */
                text-align: left; /* 文本左对齐 */
            }
            th {
                background-color: #f2f2f2; /* 设置表头背景颜色 */
            }
        </style>

        <?php
        error_reporting(E_ERROR | E_PARSE);

        function displayTable($conn) {
            $sql = "SELECT * 
                    FROM dbo.people";
            $stmt = sqlsrv_query($conn, $sql);

            if ($stmt === false) {
                echo "查询失败: " . print_r(sqlsrv_errors(), true);
            } else {
                echo "<div class='center'>";
                echo "<h2>成員列表</h2>";
                echo "</div>";

                echo "<table border='1'>";
                echo "<tr><th>名稱</th><th>稱謂</th></tr>";

                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['TheName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include "db_connect.php";

            $operation = $_POST['operation'];

            if ($operation === 'query') {
                $queryMember = $_POST['queryMember'];
                $queryTitle = $_POST['queryTitle'];
                $sql = "SELECT * FROM dbo.people WHERE 1=1";
                $params = array();

                if (!empty($queryMember)) {
                    $sql .= " AND TheName = ?";
                    $params[] = $queryMember;
                }

                if (!empty($queryTitle)) {
                    $sql .= " AND Title = ?";
                    $params[] = $queryTitle;
                }

                $stmt = sqlsrv_query($conn, $sql, $params);

                if ($stmt === false) {
                    echo "查询失败: " . print_r(sqlsrv_errors(), true);
                } else {
                    echo "<div class='center'>";
                    echo "<h2>查詢结果</h2>";
                    echo "</div>";

                    echo "<table border='1'>";
                    echo "<tr><th>名稱</th><th>稱謂</th></tr>";

                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['TheName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                }
            } elseif ($operation === 'insert') {
                $insertMember = $_POST['insertMember'];
                $insertTitle = $_POST['insertTitle'];

                $sql = "INSERT INTO dbo.people (TheName, Title) VALUES (?, ?)";
                $params = array($insertMember, $insertTitle);

                $stmt = sqlsrv_query($conn, $sql, $params);

                echo "<div class='center'>";
                if ($stmt === false) {
                    echo "新增失败: " . print_r(sqlsrv_errors(), true);
                } else {
                    echo "新增成功";
                }
                echo "</div>";

                // 操作后显示最新的成员列表
                displayTable($conn);


            } elseif ($operation === 'delete') {
                $deleteMember = $_POST['deleteMember'];

                $sql = "DELETE FROM dbo.people WHERE TheName = ?";
                $params = array($deleteMember);

                $stmt = sqlsrv_query($conn, $sql, $params);

                echo "<div class='center'>";
                if ($stmt === false) {
                    echo "删除失败: " . print_r(sqlsrv_errors(), true);
                } else {
                    echo "删除成功";
                }
                echo "</div>";

                // 操作后显示最新的成员列表
                displayTable($conn);

            } elseif ($operation === 'update') {
                $updateMember = $_POST['updateMember'];
                $updateTitle = $_POST['updateTitle'];

                $sql = "UPDATE dbo.people SET Title = ? WHERE TheName = ?";
                $params = array($updateTitle, $updateMember);

                $stmt = sqlsrv_query($conn, $sql, $params);

                echo "<div class='center'>";
                if ($stmt === false) {
                    echo "更新失败: " . print_r(sqlsrv_errors(), true);
                } else {
                    echo "更新成功";
                }
                echo "</div>";

                // 操作后显示最新的成员列表
                displayTable($conn);
            }

            

            sqlsrv_close($conn);
        } else {
            include "db_connect.php";
            displayTable($conn);
            sqlsrv_close($conn);
        }
        ?>

        <div class="footer">
            <ul>
                <li><a href="index.html">首頁</a></li>
                <li><a href="shoppinglist.php">購物清單</a></li>
                <li><a href="stock.php">庫存</a></li>
                <li><a href="member.php">成員</a></li>
            </ul>
        </div>
    </div>
</body>
</html>




