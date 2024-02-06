<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$newCompcontri = mysql_real_escape_string(trim(strip_tags($_POST['newCompcontri'])));
$newCalMethod = mysql_real_escape_string(trim(strip_tags($_POST['newCalMethod'])));
$newPolicyApp = mysql_real_escape_string(trim(strip_tags($_POST['newPolicyApp'])));
$newEarnFreq = mysql_real_escape_string(trim(strip_tags($_POST['newEarnFreq'])));
$newGLApp = mysql_real_escape_string(trim(strip_tags($_POST['newGLApp'])));
$newTaxable = mysql_real_escape_string(trim(strip_tags($_POST['newTaxable'])));
$UserID = $_SESSION['uid'];

if($newCompcontri == "")
 { 
   	$_SESSION['ErrMsg'] = "No Company Contribution Name";
	header('Location: companycontributions');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM compcontri_settings WHERE Description='$newCompcontri'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Deduction already exist";
		header('Location: companycontributions');
		exit;
	 } 

 	$query = "INSERT INTO compcontri_settings (Description, CalMethod, AppliedToStaffGroup, EarningFrequ, GLMaster, Taxable, CreatedBy) 
VALUES ('$newCompcontri','$newCalMethod', '$newPolicyApp', '$newEarnFreq', '$newGLApp', '$newTaxable', '$UserID');";

if(mysql_query($query))
 {
 	$_SESSION['ErrMsgB'] = "Congratulations! $newCompcontri is added";
	header('Location: companycontributions');
}
else
{
	echo mysql_error();
}
  


 }


exit;


?>
