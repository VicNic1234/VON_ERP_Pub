<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$editClass = mysql_real_escape_string(trim(strip_tags($_POST['editClass'])));
$accID = mysql_real_escape_string(trim(strip_tags($_POST['accID'])));
$editType = mysql_real_escape_string(trim(strip_tags($_POST['editType'])));
$eaccCode = mysql_real_escape_string(trim(strip_tags($_POST['eaccCode'])));
$eaccNme = mysql_real_escape_string(trim(strip_tags($_POST['eaccNme'])));

if($editType == "" || $eaccNme == "" || $accID == "")
 { 
   $_SESSION['ErrMsg'] = "Bin Name is required";
	header('Location: bins');
 } 
 else 
 {

 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM wh_bins WHERE (account_code='$eaccCode' OR account_name='$eaccNme') AND mid <> '$accID'  ");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Bin Name or Code is already used in another storage";
		header('Location: bins');
		exit;
	 } 
	 
 	$sql_res=mysql_query("UPDATE wh_bins SET account_code='$eaccCode', account_name='$eaccNme', account_type='$editType' WHERE mid = '$accID'");
	mysql_query($sql_res, $dbhandle);
  
	$_SESSION['ErrMsgB'] = "Updated!";
	header('Location: bins');

 }

exit;
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
