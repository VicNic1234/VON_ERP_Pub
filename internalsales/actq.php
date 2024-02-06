<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];

if($_POST)
{
$q=$_POST['litem'];
mysql_query("UPDATE lineitems SET OnTQ='0', OnTQBy='$Userid', OnTQOn='$DateG' WHERE LitID = '$q'");
mysql_query("UPDATE polineitems SET OnTQ='0', OnTQBy='$Userid', OnTQOn='$DateG' WHERE LitID = '$q'");
}
//close the connection
mysql_close($dbhandle);


?>
