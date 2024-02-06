<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$newClass = mysql_real_escape_string(trim(strip_tags($_POST['nmeClass'])));
$idClass = mysql_real_escape_string(trim(strip_tags($_POST['idClass'])));
$ShortCode = mysql_real_escape_string(trim(strip_tags($_POST['ShortCode'])));

if($newClass == "")
 { 
   	$_SESSION['ErrMsg'] = "No Item Category Name";
	header('Location: itcat');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM  itemcategory WHERE (CategoryName='$newClass' OR ShortCode='$ShortCode') AND id<>'".$idClass."'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Item Category with same name or Short Code already exist";
		header('Location: itcat');
		exit;
	 } 



 	$query = "UPDATE  itemcategory SET CategoryName='$newClass', ShortCode='$ShortCode' WHERE id='$idClass'";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Item Category is updated.";
header('Location: itcat');

 }


exit;


?>
