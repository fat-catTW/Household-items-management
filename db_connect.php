<?php
     header("Content-Type:text/html; charset=utf-8");
     $serverName="DESKTOP-LLG2J1G\SQLEXPRESS";
     $connectionInfo=array("Database"=>"Household","UID"=>"Hsiao","PWD"=>"123456","CharacterSet" => "UTF-8");
     $conn=sqlsrv_connect($serverName,$connectionInfo);
        echo "<br><br>";
        echo "<div class = 'center'>";
         if($conn){
             echo "Success!!!<br />";
         }else{
             echo "Error!!!<br />";
             die(print_r(sqlsrv_errors(),true));
         }
         echo "</div>";
?>