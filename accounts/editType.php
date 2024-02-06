<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$nmeClass = mysql_real_escape_string(trim(strip_tags($_POST['nmeClass'])));
$accType = mysql_real_escape_string(trim(strip_tags($_POST['accType'])));
$idType = mysql_real_escape_string(trim(strip_tags($_POST['idType'])));

if($nmeClass == "" || $accType == "")
 { 
   $_SESSION['ErrMsg'] = "Type Name is required";
	header('Location: chartType');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM acc_chart_types WHERE name='$accType' AND id <> '$idType' ");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 

	   	$_SESSION['ErrMsg'] = "Account Type already exist";
		header('Location: chartType');
		exit;
	 } 
 	
 	$sql_res=mysql_query("UPDATE acc_chart_types SET name='$accType', class_id='$nmeClass' WHERE id = '$idType'");
	mysql_query($sql_res, $dbhandle);
  
	$_SESSION['ErrMsgB'] = "Update!";
	header('Location: chartType');

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
