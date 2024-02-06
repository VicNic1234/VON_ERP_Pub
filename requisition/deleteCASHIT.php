<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");

$q=$_POST['rid'];
$sql_res=mysql_query("UPDATE cashreq SET isActive='0' WHERE reqid = '$q'");

$result = mysql_query($query, $dbhandle);

$home_url = "rpor";
header('Location: ' . $home_url);
//close the connection
mysql_close($dbhandle);


?>
