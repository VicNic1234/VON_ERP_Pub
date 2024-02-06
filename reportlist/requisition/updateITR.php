<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:s a");

$LitID= mysql_real_escape_string($_POST['LitID']);
$EditDes= mysql_real_escape_string($_POST['EditDes']);
$EditCat= mysql_real_escape_string($_POST['EditCat']);

$sql_res=mysql_query("UPDATE ictreq SET ItemDes='$EditDes', Purpose='$EditCat' WHERE reqid = '$LitID'");

$result = mysql_query($sql_res, $dbhandle);


$home_url = "ict";
header('Location: ' . $home_url);
//close the connection
mysql_close($dbhandle);


?>
