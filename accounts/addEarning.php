<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$newEarning = mysql_real_escape_string(trim(strip_tags($_POST['newEarning'])));
$newCalMethod = mysql_real_escape_string(trim(strip_tags($_POST['newCalMethod'])));
$newPolicyApp = mysql_real_escape_string(trim(strip_tags($_POST['newPolicyApp'])));
$newEarnFreq = mysql_real_escape_string(trim(strip_tags($_POST['newEarnFreq'])));
$newGLApp = mysql_real_escape_string(trim(strip_tags($_POST['newGLApp'])));
$newTaxable = mysql_real_escape_string(trim(strip_tags($_POST['newTaxable'])));
$UserID = $_SESSION['uid'];

if($newEarning == "")
 { 
   	$_SESSION['ErrMsg'] = "No Earning Name";
	header('Location: earningssettings');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM earnings_settings WHERE Description='$newEarning'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Earning already exist";
		header('Location: earningssettings');
		exit;
	 } 

 	$query = "INSERT INTO earnings_settings (Description, CalMethod, AppliedToStaffGroup, EarningFrequ, GLMaster, Taxable, CreatedBy) 
VALUES ('$newEarning','$newCalMethod', '$newPolicyApp', '$newEarnFreq', '$newGLApp', '$newTaxable', '$UserID');";

if(mysql_query($query))
 {
 	$_SESSION['ErrMsgB'] = "Congratulations! $newEarning is added";
	header('Location: earningssettings');
}
else
{
	echo mysql_error();
}
  


 }


exit;


?>
