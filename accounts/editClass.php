<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$nmeClass = mysql_real_escape_string(trim(strip_tags($_POST['nmeClass'])));
$idClass = mysql_real_escape_string(trim(strip_tags($_POST['idClass'])));

if($nmeClass == "")
 { 
   $_SESSION['ErrMsg'] = "No Class Name";
header('Location: chartClass');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM acc_chart_class WHERE class_name='$newClass'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Account Class already exist";
		header('Location: chartClass');
		exit;
	 } 

 	$sql_res=mysql_query("UPDATE acc_chart_class SET class_name='$nmeClass' WHERE cid = '$idClass'");
	mysql_query($sql_res, $dbhandle);
  
	$_SESSION['ErrMsgB'] = "Update!";
	header('Location: chartClass');

 }


?>
