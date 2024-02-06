<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");

$q=$_GET['cnid'];
$sql_res=mysql_query("UPDATE hir SET isActive='0' WHERE hirid = '$q'");

$result = mysql_query($query, $dbhandle);

$home_url = "hir";
header('Location: ' . $home_url);
//close the connection
mysql_close($dbhandle);


?>
