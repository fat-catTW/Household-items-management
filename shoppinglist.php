<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>購物清單管理</title>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
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
            <li class="selected"><a href="shoppinglist.php">購物清單</a></li>
            <li><a href="stock.php">庫存</a></li>
            <li><a href="member.php">成員</a></li>
        </ul>
    </div>
    <div class="body">
        <div id="header">
            <h1>購物清單</h1>
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
                    <label for="queryMember">所有人：</label>
                    <input type="text" id="queryMember" name="queryMember">
                    <br>
                    <label for="queryProduct">產品：</label>
                    <input type="text" id="queryProduct" name="queryProduct">
                    <br>
                    <label for="queryPrice">價格：</label>
                    <input type="text" id="queryPrice" name="queryPrice">
                    <br>
                    <label for="queryNumber">數量：</label>
                    <input type="text" id="queryNumber" name="queryNumber">
                    <br>
                </div>

                <!-- 新增输入框 -->
                <div id="insertInputs" style="display:none;">
                    <label for="insertID">ID：</label>
                    <input type="text" id="insertID" name="insertID">
                    <br>
                    <label for="insertProduct">產品：</label>
                    <input type="text" id="insertProduct" name="insertProduct">
                    <br>
                    <label for="insertPrice">價格：</label>
                    <input type="text" id="insertPrice" name="insertPrice">
                    <br>
                    <label for="insertNumber">數量：</label>
                    <input type="text" id="insertNumber" name="insertNumber">
                    <br>
                    <label for="insertOwner">所有人：</label>
                    <input type="text" id="insertOwner" name="insertOwner">
                </div>

                <!-- 删除输入框 -->
                <div id="deleteInputs" style="display:none;">
                    <label for="deleteID">ID：</label>
                    <input type="text" id="deleteID" name="deleteID">
                </div>

                <!-- 更新输入框 -->
                <div id="updateInputs" style="display:none;">
                    <label for="updateID">ID：</label>
                    <input type="text" id="updateID" name="updateID">
                    <br>
                    <label for="updateProduct">產品：</label>
                    <input type="text" id="updateProduct" name="updateProduct">
                    <br>
                    <label for="updatePrice">價格：</label>
                    <input type="text" id="updatePrice" name="updatePrice">
                    <br>
                    <label for="updateNumber">數量：</label>
                    <input type="text" id="updateNumber" name="updateNumber">
                    <br>
                    <label for="updateOwner">所有人：</label>
                    <input type="text" id="updateOwner" name="updateOwner">
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
        $sql = "SELECT sl.*, p.Title 
                FROM dbo.shoppinglist sl
                LEFT JOIN dbo.people p ON sl.owner = p.TheName";
        $stmt = sqlsrv_query($conn, $sql);

        if ($stmt === false) {
            echo "查詢失敗：" . print_r(sqlsrv_errors(), true);
        } else {
            echo "<div class='center'>";
            echo "<h2>購物清單列表</h2>";
            echo "</div>";

            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>產品</th><th>價格</th><th>數量</th><th>所有人</th><th>稱謂</th></tr>";

            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['product']) . "</td>";
                echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                echo "<td>" . htmlspecialchars($row['number']) . "</td>";
                echo "<td>" . htmlspecialchars($row['owner']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include "db_connect.php";

        $operation = $_POST['operation'];

        if ($operation ==='query') {
            $queryMember = $_POST['queryMember'];
            $queryProduct = $_POST['queryProduct'];
            $queryPrice = $_POST['queryPrice'];
            $queryNumber = $_POST['queryNumber'];

            $sql = "SELECT s.*, p.Title 
			FROM dbo.shoppinglist s 
			LEFT JOIN people p ON s.owner = p.TheName 
			WHERE 1=1";

            if (!empty($queryMember)) {
                $sql .= " AND owner = '$queryMember'";
            }

            if (!empty($queryProduct)) {
				$sql .= " AND product = '$queryProduct'";
            }
                    
            if (!empty($queryPrice)) {
                $sql .= " AND price = '$queryPrice'";
            }

            if (!empty($queryNumber)) { 
				$sql .= " AND number = '$queryNumber'";
			}

			if (!empty($queryTitle)) { // 如果有稱謂的查詢條件
				$sql .= " AND p.Title = '$queryTitle'";
			}

            $stmt = sqlsrv_query($conn, $sql, $params);

            if ($stmt === false) {
                echo "查询失败: " . print_r(sqlsrv_errors(), true);
            } else {
                echo "<div class='center'>";
                echo "<h2>查詢结果</h2>";
                echo "</div>";

                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>產品</th><th>價格</th><th>數量</th><th>所有人</th><th>稱謂</th></tr>";

                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['product']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['owner']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
        } elseif ($operation === 'insert') {
            $insertID = $_POST['insertID'];
            $insertProduct = $_POST['insertProduct'];
            $insertPrice = $_POST['insertPrice'];
            $insertNumber = $_POST['insertNumber'];
            $insertOwner = $_POST['insertOwner'];

            $sql = "INSERT INTO dbo.shoppinglist (ID, product, price, number, owner) VALUES (?, ?, ?, ?, ?)";
            $params = array($insertID, $insertProduct, $insertPrice, $insertNumber, $insertOwner);

            $stmt = sqlsrv_query($conn, $sql, $params);
            
            echo "<div class='center'>";
            if ($stmt === false) {
                echo "新增失败: " . print_r(sqlsrv_errors(), true);
            } else {
                echo "新增成功";
            }
            echo "</div>";

            // 操作后显示最新的购物清单列表
            displayTable($conn);
        } elseif ($operation === 'delete') {
            $deleteID = $_POST['deleteID'];

            $sql = "DELETE FROM dbo.shoppinglist WHERE ID = ?";
            $params = array($deleteID);

            $stmt = sqlsrv_query($conn, $sql, $params);
            
            echo "<div class='center'>";
            if ($stmt === false) {
                echo "删除失败: " . print_r(sqlsrv_errors(), true);
            } else {
                echo "删除成功";
            }
            echo "</div>";

            // 操作后显示最新的购物清单列表
            displayTable($conn);
        } elseif ($operation === 'update') {
            $updateID = $_POST['updateID'];
            $updateProduct = $_POST['updateProduct'];
            $updatePrice = $_POST['updatePrice'];
            $updateNumber = $_POST['updateNumber'];
            $updateOwner = $_POST['updateOwner'];

            // 查詢現有值
            $sql = "SELECT * FROM dbo.shoppinglist WHERE ID = ?";
            $params = array($updateID);
            $stmt = sqlsrv_query($conn, $sql, $params);
            if ($stmt === false) {
                echo "查詢現有資料失敗：" . print_r(sqlsrv_errors(), true);
                sqlsrv_close($conn);
                exit();
            }
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

            // 使用現有值作為默認值
            if (empty($updateProduct)) {
                $updateProduct = $row['product'];
            }
            if (empty($updateNumber)) {
                $updateNumber = $row['number'];
            }
            if (empty($updatePrice)) {
                $updatePrice = $row['price'];
            }
            if (empty($updateOwner)) {
                $updateOwner = $row['owner'];
            }


            $sql = "UPDATE dbo.shoppinglist SET product = ?, price = ?, number = ?, owner = ? WHERE ID = ?";
            $params = array($updateProduct, $updatePrice, $updateNumber, $updateOwner, $updateID);

            $stmt = sqlsrv_query($conn, $sql, $params);
            
            echo "<div class='center'>";
            if ($stmt === false) {
                echo "更新失败: " . print_r(sqlsrv_errors(), true);
            } else {
                echo "更新成功";
            }
            echo "</div>";

            // 操作后显示最新的购物清单列表
            displayTable($conn);
        }

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
        <p>&#169; 人生就像打電話 &#169; 不是你先掛，就是我先掛。</p>
        <div class="connect">
            <a href="http://facebook.com/freewebsitetemplates" id="facebook">facebook</a>
            <a href="http://twitter.com/fwtemplates" id="twitter">twitter</a>
            <a href="http://www.youtube.com/fwtemplates" id="vimeo">vimeo</a>
        </div>
    </div>
</div>
</body>
</html>



