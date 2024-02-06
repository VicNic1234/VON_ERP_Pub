<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$nmeClass = mysql_real_escape_string(trim(strip_tags($_POST['nmeClass'])));
$idClass = mysql_real_escape_string(trim(strip_tags($_POST['idClass'])));
$description = mysql_real_escape_string(trim(strip_tags($_POST['description']))); 

if($nmeClass == "")
 { 
   $_SESSION['ErrMsg'] = "No Manufacturer Name";
header('Location: manufacturers');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM equip_manufacturers WHERE station_name='$newClass'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Manufacturer already exist";
		header('Location: manufacturers');
		exit;
	 } 

 	$sql_res=mysql_query("UPDATE equip_manufacturers SET station_name='$nmeClass', description='$description' WHERE cid = '$idClass'");
	mysql_query($sql_res, $dbhandle);
  
	$_SESSION['ErrMsgB'] = "Equipment Manufacturer Updated!";
	header('Location: manufacturers');

 }


?>
