<?php
session_start();
error_reporting(0);

include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$UID = $_SESSION['uid'];
$fid=$_POST['fid'];
$ty=$_POST['ty'];
if($ty == "new"){
$sql_res=mysql_query("UPDATE filereq SET isActive='0', DeletedOn='".$DateG."', DeletedBy='".$UID."' WHERE fid = '$fid'");

$result = mysql_query($query, $dbhandle);
echo "OKNEW";
}
if($ty == "old"){
$sql_res=mysql_query("UPDATE cashreq SET attachment='', fDeletedBy='$UID', fDeletedOn='$DateG' WHERE reqid = '$fid'");

$result = mysql_query($query, $dbhandle);
echo "OKOLD";
}

//close the connection
mysql_close($dbhandle);


?>
