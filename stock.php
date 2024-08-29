<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>庫存</title>
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

    window.onload = function() {
        // 預設選擇查詢操作
        document.getElementById("operation").value = "query";
        toggleInputs();
    };
    </script>
</head>
<body>
    <div class="page">
        <div class="header">
            <a href="index.html" id="logo"><img src="images/logo.jpg" width="160" height="64" alt=""/></a>
            <ul>
                <li><a href="index.html">首頁</a></li>
                <li><a href="shoppinglist.php">購物清單</a></li>
                <li class="selected"><a href="stock.php">庫存</a></li>
                <li><a href="member.php">成員</a></li>
            </ul>
        </div>
        <div class="body">
            <div id="header">
                <h1>庫存管理</h1>
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
                    <div id="queryInputs" style="display:none;">
                        <label for="queryOwner">所有人：</label>
                        <input type="text" id="queryOwner" name="queryOwner">
                        <br>
                        <label for="queryPrice">價格：</label>
                        <input type="text" id="queryPrice" name="queryPrice">
                        <br>
                        <label for="queryLocation">存放地點：</label>
                        <input type="text" id="queryLocation" name="queryLocation">
                        <br>
                        <label for="queryProduct">產品：</label>
                        <input type="text" id="queryProduct" name="queryProduct">
						<br>
    					<label for="queryTitle">稱謂：</label>
    					<input type="text" id="queryTitle" name="queryTitle">
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
                        <label for="insertQuantity">數量：</label>
                        <input type="text" id="insertQuantity" name="insertQuantity">
                        <br>
                        <label for="insertLocation">存放地點：</label>
                        <input type="text" id="insertLocation" name="insertLocation">
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
                        <label for="updateID">要更改資料的ID：</label>
                        <input type="text" id="updateID" name="updateID">
                        <br>
                        <label for="updateProduct">產品：</label>
                        <input type="text" id="updateProduct" name="updateProduct">
                        <br>
                        <label for="updateProduct">價格：</label>
                        <input type="text" id="updatePrice" name="updatePrice">
                        <br>
                        <label for="updateQuantity">數量：</label>
                        <input type="text" id="updateQuantity" name="updateQuantity">
                        <br>
                        <label for="updateLocation">存放地點：</label>
                        <input type="text" id="updateLocation" name="updateLocation">
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

            include "db_connect.php";

            // 如果是 POST 请求，执行相应操作
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $operation = $_POST['operation'];

                if ($operation === 'query') {
                    $queryOwner = $_POST['queryOwner'];
                    $queryPrice = $_POST['queryPrice'];
                    $queryLocation = $_POST['queryLocation'];
                    $queryProduct = $_POST['queryProduct'];
					$queryTitle = $_POST['queryTitle'];

                    $sql = "SELECT s.*, p.Title 
					FROM dbo.stock s 
					LEFT JOIN people p ON s.owner = p.TheName 
					WHERE 1=1";

                    if (!empty($queryOwner)) {
                        $sql .= " AND owner = '$queryOwner'";
                    }
                    
                    if (!empty($queryPrice)) {
                        $sql .= " AND price = '$queryPrice'";
                    }

                    if (!empty($queryLocation)) {
                        $sql .= " AND place = '$queryLocation'";
                    }

                    if (!empty($queryProduct)) {
						$sql .= " AND product = '$queryProduct'";
                    }

					if (!empty($queryTitle)) { // 如果有稱謂的查詢條件
						$sql .= " AND p.Title = '$queryTitle'";
					}

                    $stmt = sqlsrv_query($conn, $sql);

                    if ($stmt === false) {
                        echo "查詢失败：" . print_r(sqlsrv_errors(), true);
                    } else {
                        echo "<div class='center'>";
                        echo "<h2>查詢结果</h2>";
                        echo "</div>";

                        echo "<table border='1'>";
                        echo "<tr><th>ID</th><th>產品</th><th>價格</th><th>數量</th><th>存放地點</th><th>所有人</th><th>稱謂</th></tr>";

        				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            				echo "<tr>";
            				echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
            				echo "<td>" . htmlspecialchars($row['product']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['price']) . "</td>";
            				echo "<td>" . htmlspecialchars($row['number']) . "</td>";
            				echo "<td>" . htmlspecialchars($row['place']) . "</td>";
            				echo "<td>" . htmlspecialchars($row['owner']) . "</td>";
            				echo "<td>" . htmlspecialchars($row['Title']) . "</td>"; // 顯示Title
            				echo "</tr>";
                        }

                        echo "</table>";
                    }
                } elseif ($operation === 'insert') {
                    $insertID = $_POST['insertID'];
                    $insertProduct = $_POST['insertProduct'];
                    $insertPrice = $_POST['insertPrice'];
                    $insertQuantity = $_POST['insertQuantity'];
                    $insertLocation = $_POST['insertLocation'];
                    $insertOwner = $_POST['insertOwner'];

                    $sql = "INSERT INTO dbo.stock (ID, product, price, number, place, owner) VALUES (?, ?, ?, ?, ?, ?)";

                    $params = array($insertID, $insertProduct, $insertPrice, $insertQuantity, $insertLocation, $insertOwner);
                    $stmt = sqlsrv_query($conn, $sql, $params);

                    echo "<div class='center'>";
                    if ($stmt === false) {
                        echo "新增失败：" . print_r(sqlsrv_errors(), true);
                    } else {
                        echo "新增成功";
                    }
                    echo "</div>";

                    // 在新增後執行預設查詢
                    $sql = "SELECT s.*, p.Title 
					FROM dbo.stock s 
					LEFT JOIN people p ON s.owner = p.TheName";
					$stmt = sqlsrv_query($conn, $sql);

					if ($stmt === false) {
						echo "查詢失敗：" . print_r(sqlsrv_errors(), true);
					} else {
						echo "<div class='center'>";
						echo "<h2>庫存列表</h2>";
						echo "</div>";

						echo "<table border='1'>";
						echo "<tr><th>ID</th><th>產品</th><th>價格</th><th>數量</th><th>存放地點</th><th>所有人</th><th>稱謂</th></tr>";

						while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
							echo "<tr>";
							echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
							echo "<td>" . htmlspecialchars($row['product']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['price']) . "</td>";
							echo "<td>" . htmlspecialchars($row['number']) . "</td>";
							echo "<td>" . htmlspecialchars($row['place']) . "</td>";
							echo "<td>" . htmlspecialchars($row['owner']) . "</td>";	
							echo "<td>" . htmlspecialchars($row['Title']) . "</td>"; // 顯示Title
							echo "</tr>";
						}

						echo "</table>";
                    }
                } elseif ($operation === 'delete') {
                    $deleteID = $_POST['deleteID'];
                    $sql = "DELETE FROM dbo.stock WHERE ID = ?";

                    $params = array($deleteID);
                    $stmt = sqlsrv_query($conn, $sql, $params);

                    echo "<div class='center'>";
                    if ($stmt === false) {
                        echo "刪除失败：" . print_r(sqlsrv_errors(), true);
                    } else {
                        echo "刪除成功";
                    }
                    echo "</div>";

                    // 在刪除後執行預設查詢
                    $sql = "SELECT s.*, p.Title 
					FROM dbo.stock s 
					LEFT JOIN people p ON s.owner = p.TheName";
					$stmt = sqlsrv_query($conn, $sql);

					if ($stmt === false) {
						echo "查詢失敗：" . print_r(sqlsrv_errors(), true);
					} else {
						echo "<div class='center'>";
						echo "<h2>庫存列表</h2>";
						echo "</div>";

						echo "<table border='1'>";
						echo "<tr><th>ID</th><th>產品</th><th>價格</th><th>數量</th><th>存放地點</th><th>所有人</th><th>稱謂</th></tr>";

						while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
							echo "<tr>";
							echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
							echo "<td>" . htmlspecialchars($row['product']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['price']) . "</td>";
							echo "<td>" . htmlspecialchars($row['number']) . "</td>";
							echo "<td>" . htmlspecialchars($row['place']) . "</td>";
							echo "<td>" . htmlspecialchars($row['owner']) . "</td>";	
							echo "<td>" . htmlspecialchars($row['Title']) . "</td>"; // 顯示Title
							echo "</tr>";
						}

						echo "</table>";
                    }
                } elseif ($operation === 'update') {
                    $updateID = $_POST['updateID'];
                    $updateProduct = $_POST['updateProduct'];
                    $updatePrice = $_POST['updatePrice'];
                    $updateQuantity = $_POST['updateQuantity'];
                    $updateLocation = $_POST['updateLocation'];
                    $updateOwner = $_POST['updateOwner'];

                    // 查詢現有值
                    $sql = "SELECT * FROM dbo.stock WHERE ID = ?";
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
                    if (empty($updatePrice)) {
                        $updatePrice = $row['price'];
                    }
                    if (empty($updateQuantity)) {
                        $updateQuantity = $row['number'];
                    }
                    if (empty($updateLocation)) {
                        $updateLocation = $row['place'];
                    }
                    if (empty($updateOwner)) {
                        $updateOwner = $row['owner'];
                    }

                    $sql = "UPDATE dbo.stock SET product = ?, price = ?, number = ?, place = ?, owner = ? WHERE ID = ?";
                    $params = array($updateProduct, $updatePrice, $updateQuantity, $updateLocation, $updateOwner, $updateID);
                    $stmt = sqlsrv_query($conn, $sql, $params);

                    echo "<div class='center'>";
                    if ($stmt === false) {
                        echo "更新失败：" . print_r(sqlsrv_errors(), true);
                    } else {
                        echo "更新成功";
                    }
                    echo "</div>";

                    // 在更新後執行預設查詢
					$sql = "SELECT s.*, p.Title 
					FROM dbo.stock s 
					LEFT JOIN people p ON s.owner = p.TheName";
					$stmt = sqlsrv_query($conn, $sql);

					if ($stmt === false) {
						echo "查詢失敗：" . print_r(sqlsrv_errors(), true);
					} else {
						echo "<div class='center'>";
						echo "<h2>庫存列表</h2>";
						echo "</div>";

						echo "<table border='1'>";
						echo "<tr><th>ID</th><th>產品</th><th>價格</th><th>數量</th><th>存放地點</th><th>所有人</th><th>稱謂</th></tr>";

						while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
							echo "<tr>";
							echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
							echo "<td>" . htmlspecialchars($row['product']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['price']) . "</td>";
							echo "<td>" . htmlspecialchars($row['number']) . "</td>";
							echo "<td>" . htmlspecialchars($row['place']) . "</td>";
							echo "<td>" . htmlspecialchars($row['owner']) . "</td>";	
							echo "<td>" . htmlspecialchars($row['Title']) . "</td>"; // 顯示Title
							echo "</tr>";
						}

						echo "</table>";
					}
				}
			}

			sqlsrv_close($conn);
		
	?>

	<div class="footer">
		<ul>
			<li><a href="index.html">首頁</a></li>
			<li><a href="shoppinglist.php">購物清單</a></li>
			<li><a href="stock.php">庫存</a></li>
			<li><a href="member.php">成員</a></li>
		</ul>
		<p>&#169; 我半夜都喝 &#169; 威士忌配牛奶，超好喝的啦!</p>
		<div class="connect">
			<a href="http://facebook.com/freewebsitetemplates" id="facebook">facebook</a>
			<a href="http://twitter.com/fwtemplates" id="twitter">twitter</a>
			<a href="http://www.youtube.com/fwtemplates" id="vimeo">vimeo</a>
		</div>
	</div>
</div>
</body>
</html>






