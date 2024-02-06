<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$addClass = mysql_real_escape_string(trim(strip_tags($_POST['addClass'])));
$addType = mysql_real_escape_string(trim(strip_tags($_POST['addType'])));
$addAcct = mysql_real_escape_string(trim(strip_tags($_POST['addAcct'])));
$addCode = mysql_real_escape_string(trim(strip_tags($_POST['addCode'])));

if($addClass == "" || $addType == "" || $addAcct == "" || $addCode == "")
 { 
   $_SESSION['ErrMsg'] = "Kindly Complete details of new Bin";
header('Location: bins');
exit;
 } 
 else 
 {

 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM wh_bins WHERE account_code='$addCode'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Code already exist";
		header('Location: bins');
		exit;
	 } 

 	$query = "INSERT INTO wh_bins (account_code, account_name, account_type, isActive) 
    VALUES ('$addCode', '$addAcct', '$addType', 1);";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Bin is added";
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
