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
   $_SESSION['ErrMsg'] = "Bin is required";
	header('Location: bins');
 } 
 else 
 {

 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM wh_bins WHERE mid = '$accID'  ");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist == 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Bin does not exist";
		header('Location: bins');
		exit;
	 } 
	 
 	$sql_res=mysql_query("DELETE FROM wh_bins WHERE mid = '$accID'");
	mysql_query($sql_res, $dbhandle);
  
	$_SESSION['ErrMsgB'] = "Deleted!";
	header('Location: bins');

 }


mysql_close($dbhandle);
exit;


?>
