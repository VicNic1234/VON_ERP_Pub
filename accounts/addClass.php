<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$newClass = mysql_real_escape_string(trim(strip_tags($_POST['newClass'])));

if($newClass == "")
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

 	$query = "INSERT INTO acc_chart_class (class_name, isActive) 
VALUES ('$newClass', 1);";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Account Class is added";
header('Location: chartClass');

 }


exit;


?>
