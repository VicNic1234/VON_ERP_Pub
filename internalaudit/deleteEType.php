<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$nmeClass = mysql_real_escape_string(trim(strip_tags($_POST['nmeClass'])));
$idClass = mysql_real_escape_string(trim(strip_tags($_POST['idClass'])));

if($idClass == "")
 { 
   $_SESSION['ErrMsg'] = "No Type Selected";
header('Location: subcat');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM equip_subcategory WHERE cid='$idClass'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist == 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Type does not exist";
		header('Location: subcat');
		exit;
	 } 

 	$sql_res=mysql_query("UPDATE equip_subcategory SET isActive=0 WHERE cid = '$idClass'");
	mysql_query($sql_res, $dbhandle);
  
	$_SESSION['ErrMsgB'] = "Type Deleted!";
	header('Location: subcat');

 }


?>
