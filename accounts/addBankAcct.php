<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$newDes = mysql_real_escape_string(trim(strip_tags($_POST['newDes'])));
$newAccNum = mysql_real_escape_string(trim(strip_tags($_POST['newAccNum'])));
$newAccNme = mysql_real_escape_string(trim(strip_tags($_POST['newAccNme'])));
$newSortCode = mysql_real_escape_string(trim(strip_tags($_POST['newSortCode'])));
$newBnkNme = mysql_real_escape_string(trim(strip_tags($_POST['newBnkNme'])));
$newBnkAdd = mysql_real_escape_string(trim(strip_tags($_POST['newBnkAdd'])));
$newGLAcct = mysql_real_escape_string(trim(strip_tags($_POST['newGLAcct'])));
$newStatus = mysql_real_escape_string(trim(strip_tags($_POST['newStatus'])));
$newCurr = mysql_real_escape_string(trim(strip_tags($_POST['newCurr'])));
$UserID = $_SESSION['uid'];

if($newDes == "")
 { 
   	$_SESSION['ErrMsg'] = "No Bank Account Description";
	header('Location: banksettings');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM bankaccount WHERE description='$newDes' OR acctnum='$newAccNum' ");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Bank Account already exist";
		header('Location: banksettings');
		exit;
	 } 

 	$query = "INSERT INTO bankaccount (description, acctnum, acctnme, sortcode, bnkname, bnkaddress, GLAcct, isActive, currency) 
VALUES ('$newDes','$newAccNum', '$newAccNme', '$newSortCode', '$newBnkNme', '$newBnkAdd', '$newGLAcct', '$newStatus', '$newCurr');";

if(mysql_query($query))
 {
 	$_SESSION['ErrMsgB'] = "Congratulations! $newDes is added as Bank";
	header('Location: banksettings');
}
else
{
	echo mysql_error();
}
  


 }


exit;


?>
