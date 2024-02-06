<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:s a");

$ReqCode= mysql_real_escape_string($_POST['ReqCID']);
$DeptID= mysql_real_escape_string($_POST['DeptID']);




$sql_res=mysql_query("UPDATE cashreq SET Deparment='$DeptID' WHERE RequestID='$ReqCode'");

$result = mysql_query($sql_res, $dbhandle); 
//echo mysql_error($dbhandle); exit;

 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  
//close the connection
mysql_close($dbhandle);


?>
