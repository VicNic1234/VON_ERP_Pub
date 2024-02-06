<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$acctid = mysql_real_escape_string(trim(strip_tags($_POST['acctid'])));
$accttype = mysql_real_escape_string(trim(strip_tags($_POST['accttype']))); 
$actstate = mysql_real_escape_string(trim(strip_tags($_POST['actstate'])));
if($actstate == "true"){ $actstate = 1; } else { $actstate = 0; }
if ($accttype == "Class")
{ 
	$sql_res=mysql_query("UPDATE acc_chart_class SET isActive='$actstate' WHERE cid = '$acctid'");
}

if ($accttype == "Master")
{ 
	$sql_res=mysql_query("UPDATE acc_chart_master SET isActive='$actstate' WHERE account_code = '$acctid'");
}

if ($accttype == "Type")
{ 
	$sql_res=mysql_query("UPDATE acc_chart_types SET isActive='$actstate' WHERE id = '$acctid'");
}


$result = mysql_query($sql_res, $dbhandle);

mysql_close($dbhandle);
exit;


?>
