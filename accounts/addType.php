<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$newClass = mysql_real_escape_string(trim(strip_tags($_POST['nmeClass'])));
$accType = mysql_real_escape_string(trim(strip_tags($_POST['accType'])));

if($newClass == "" || $accType == "")
 { 
   $_SESSION['ErrMsg'] = "No Class Name or Account Type";
header('Location: chartType');
 } 
 else 
 {

 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM acc_chart_types WHERE name='$accType'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Account Type already exist";
		header('Location: chartType');
		exit;
	 } 
 	$query = "INSERT INTO acc_chart_types (name, class_id, isActive) 
    VALUES ('$accType', '$newClass', 1);";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Account Type is added";
header('Location: chartType');

 }


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
