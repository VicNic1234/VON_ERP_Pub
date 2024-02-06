<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$nmeClass = mysql_real_escape_string(trim(strip_tags($_POST['nmeClass'])));
$idClass = mysql_real_escape_string(trim(strip_tags($_POST['idClass'])));

if($idClass == "")
 { 
   $_SESSION['ErrMsg'] = "No Class Selected";
header('Location: chartClass');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM acc_chart_class WHERE cid='$idClass'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist == 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Account Class does not exist";
		header('Location: chartClass');
		exit;
	 } 

 	$sql_res=mysql_query("DELETE FROM acc_chart_class WHERE cid = '$idClass'");
	mysql_query($sql_res, $dbhandle);
  
	$_SESSION['ErrMsgB'] = "Deleted!";
	header('Location: chartClass');

 }


?>
