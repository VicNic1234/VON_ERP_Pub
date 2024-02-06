<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$setid = mysql_real_escape_string(trim(strip_tags($_POST['setid'])));
$actstate = mysql_real_escape_string(trim(strip_tags($_POST['actstate'])));
if($actstate == "true"){ $actstate = 1; } else { $actstate = 0; }

	$sql_res=mysql_query("UPDATE acc_settings SET isActive='$actstate' WHERE id = '$setid'");



$result = mysql_query($sql_res, $dbhandle);

mysql_close($dbhandle);
exit;


?>
