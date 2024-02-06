<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$newClass = mysql_real_escape_string(trim(strip_tags($_POST['nmeClass'])));
$idClass = mysql_real_escape_string(trim(strip_tags($_POST['idClass'])));
//$ShortCode = mysql_real_escape_string(trim(strip_tags($_POST['ShortCode'])));

if($newClass == "")
 { 
   	$_SESSION['ErrMsg'] = "No Request Category Name";
	header('Location: itcat');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM  reqcategory WHERE (CategoryName='$newClass') AND id<>'".$idClass."'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Item Category with same name already exist";
		header('Location: itcat');
		exit;
	 } 



 	$query = "UPDATE  reqcategory SET CategoryName='$newClass' WHERE id='$idClass'";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Request Category is updated.";
header('Location: itcat');

 }


exit;


?>
