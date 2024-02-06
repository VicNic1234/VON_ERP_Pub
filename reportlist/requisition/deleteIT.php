<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$UID = $_SESSION['uid'];

$q=$_POST['rid'];
$sql_res=mysql_query("UPDATE poreq SET isActive='0', DeletedBy='$UID', DeletedOn='$DateG' WHERE reqid = '$q'");

$result = mysql_query($query, $dbhandle);

$home_url = "rpor";
header('Location: ' . $home_url);
//close the connection
mysql_close($dbhandle);


?>
