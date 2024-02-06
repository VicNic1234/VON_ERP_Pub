<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$editClass = mysql_real_escape_string(trim(strip_tags($_POST['editClass'])));
$accID = mysql_real_escape_string(trim(strip_tags($_POST['accID'])));
$editType = mysql_real_escape_string(trim(strip_tags($_POST['editType'])));
$eaccCode = mysql_real_escape_string(trim(strip_tags($_POST['eaccCode'])));
$eaccNme = mysql_real_escape_string(trim(strip_tags($_POST['eaccNme'])));

if($accID == "")
 { 
   $_SESSION['ErrMsg'] = "Account is required";
	header('Location: chartMaster');
 } 
 else 
 {

 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM acc_chart_master WHERE mid = '$accID'  ");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist == 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Account does not exist";
		header('Location: chartMaster');
		exit;
	 } 
	 
 	$sql_res=mysql_query("DELETE FROM acc_chart_master WHERE mid = '$accID'");
	mysql_query($sql_res, $dbhandle);
  
	$_SESSION['ErrMsgB'] = "Deleted!";
	header('Location: chartMaster');

 }


mysql_close($dbhandle);
exit;


?>
