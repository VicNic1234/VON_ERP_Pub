<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$nmeClass = mysql_real_escape_string(trim(strip_tags($_POST['nmeClass'])));
$idClass = mysql_real_escape_string(trim(strip_tags($_POST['idClass'])));

if($idClass == "")
 { 
   $_SESSION['ErrMsg'] = "No Station Selected";
header('Location: stations');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM equip_stations WHERE cid='$idClass'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist == 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Equipment Location does not exist";
		header('Location: stations');
		exit;
	 } 

 	$sql_res=mysql_query("UPDATE equip_stations SET isActive=0 WHERE cid = '$idClass'");
	mysql_query($sql_res, $dbhandle);
  
	$_SESSION['ErrMsgB'] = "Equipment Location Deleted!";
	header('Location: stations');

 }


?>
