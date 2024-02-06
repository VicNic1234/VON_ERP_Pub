<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$UID = $_SESSION['uid'];

$q=$_POST['rid'];
$sql_res=mysql_query("UPDATE cashreq SET isActive='0', DeletedBy='$UID', DeletedOn='$DateG' WHERE reqid = '$q'");

$result = mysql_query($query, $dbhandle);

if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  exit;
//close the connection
mysql_close($dbhandle);


?>
