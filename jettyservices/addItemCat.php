<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$newClass = mysql_real_escape_string(trim(strip_tags($_POST['newStation'])));
$ShortCode = mysql_real_escape_string(trim(strip_tags($_POST['ShortCode'])));
//$description = mysql_real_escape_string(trim(strip_tags($_POST['description'])));

if($newClass == "")
 { 
   	$_SESSION['ErrMsg'] = "No Item Category Name";
	header('Location: itcat');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM  itemcategory WHERE CategoryName='$newClass' OR ShortCode='$ShortCode'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Item Category already exist";
		header('Location: itcat');
		exit;
	 } 

 	$query = "INSERT INTO  itemcategory (CategoryName, ShortCode, isActive) 
VALUES ('$newClass', '$ShortCode', 1);";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Item Category is added";
header('Location: itcat');

 }


exit;


?>
