<?php
header("Content-Type:text/html; charset=utf-8");
?>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>訂單查詢結果</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body id="wrapper-02">
  <div id="header">
    <h1>成員查詢結果</h1>
  </div>
    
<div id="contents">
<h2> <a href="member.html">回到成員</a> </h2>
<?php   		
		include"db_connect.php";
		if($_POST['TheName']!=''){
        $TheName=$_POST['TheName'];
		$sql="SELECT TheName FROM dbo.people WHERE TheName ='$TheName'";
		}
		else{
			$sql="SELECT * FROM dbo.people ";
		}

		$qury=sqlsrv_query($conn,$sql) or die("sql error".sqlsrv_errors());

		while($row=sqlsrv_fetch_array($qury))
		{
			echo "成員:".$row['TheName']."<br/>";
		}
?>
</div>

</body></html>