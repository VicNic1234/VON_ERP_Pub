<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$newDeduction = mysql_real_escape_string(trim(strip_tags($_POST['newDeduction'])));
$newCalMethod = mysql_real_escape_string(trim(strip_tags($_POST['newCalMethod'])));
$newPolicyApp = mysql_real_escape_string(trim(strip_tags($_POST['newPolicyApp'])));
$newEarnFreq = mysql_real_escape_string(trim(strip_tags($_POST['newEarnFreq'])));
$newGLApp = mysql_real_escape_string(trim(strip_tags($_POST['newGLApp'])));
$newTaxable = mysql_real_escape_string(trim(strip_tags($_POST['newTaxable'])));
$UserID = $_SESSION['uid'];

if($newDeduction == "")
 { 
   	$_SESSION['ErrMsg'] = "No newDeduction Name";
	header('Location: deductionssettings');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM deductions_settings WHERE Description='$newDeduction'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Deduction already exist";
		header('Location: deductionssettings');
		exit;
	 } 

 	$query = "INSERT INTO deductions_settings (Description, CalMethod, AppliedToStaffGroup, EarningFrequ, GLMaster, Taxable, CreatedBy) 
VALUES ('$newDeduction','$newCalMethod', '$newPolicyApp', '$newEarnFreq', '$newGLApp', '$newTaxable', '$UserID');";

if(mysql_query($query))
 {
 	$_SESSION['ErrMsgB'] = "Congratulations! $newDeduction is added";
	header('Location: deductionssettings');
}
else
{
	echo mysql_error();
}
  


 }


exit;


?>
