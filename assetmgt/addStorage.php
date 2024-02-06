<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$Station = mysql_real_escape_string(trim(strip_tags($_POST['Station'])));
$nStorage = mysql_real_escape_string(trim(strip_tags($_POST['nStorage'])));

if($nStorage == "")
 { 
   	$_SESSION['ErrMsg'] = "No Storage Name";
	header('Location: storages');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM wh_storages WHERE name='$nStorage'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Warehouse Storage already exist";
		header('Location: storages');
		exit;
	 } 

 	$query = "INSERT INTO wh_storages (name, class_id, isActive) 
VALUES ('$nStorage', '$Station', 1);";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Warehouse Storage is added";
header('Location: storages');

 }


exit;


?>
