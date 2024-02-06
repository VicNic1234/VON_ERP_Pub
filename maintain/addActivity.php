<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:s a");

$UID = $_SESSION['uid'];
$conID = mysql_real_escape_string(trim(strip_tags($_POST['conID'])));
$Activity = mysql_real_escape_string(trim(strip_tags($_POST['Activity'])));
$PartsReplaces = mysql_real_escape_string(trim(strip_tags($_POST['PartsReplaces'])));
$Remarks = mysql_real_escape_string(trim(strip_tags($_POST['Remarks'])));
$DueDate = mysql_real_escape_string(trim(strip_tags($_POST['DueDate'])));

if($Activity == "")
 { 
   	$_SESSION['ErrMsg'] = "No Activity Name";
    header('Location: viewequip?cnid='.$conID);
 } 
 else 
 {
 	//Check if exist
 	/*$chkExist = mysql_query("SELECT * FROM equip_manufacturers WHERE station_name='$newClass'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Equipment Manufacturer already exist";
		header('Location: manufacturers');
		exit;
	 }
	 */ 

 	$query = "INSERT INTO maintain_activities (equipid, action, remark, partereplaced, raisedby, raisedon, duedate) 
VALUES ('$conID', '$Activity', '$Remarks', '$PartsReplaces', '$UID', '$DateG', '$DueDate');";

mysql_query($query);
  
	$_SESSION['ErrMsgB'] = "Congratulations! New Activity is added";
   header('Location: viewequip?cnid='.$conID);


 }


exit;


?>
