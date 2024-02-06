<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$newClass = mysql_real_escape_string(trim(strip_tags($_POST['newStation'])));
$description = mysql_real_escape_string(trim(strip_tags($_POST['description'])));

if($newClass == "")
 { 
   	$_SESSION['ErrMsg'] = "No Type Name";
	header('Location: subcat');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM equip_subcategory WHERE station_name='$newClass'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Equipment Type already exist";
		header('Location: subcat');
		exit;
	 } 

 	$query = "INSERT INTO equip_subcategory (station_name, description, isActive) 
VALUES ('$newClass', '$description', 1);";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Equipment Type is added";
header('Location: subcat');

 }


exit;


?>
