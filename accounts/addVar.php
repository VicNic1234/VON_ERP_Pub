<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$newVar = mysql_real_escape_string(trim(strip_tags($_POST['newVar'])));
$newVarName = mysql_real_escape_string(trim(strip_tags($_POST['newVarName'])));
$newVarID = mysql_real_escape_string(trim(strip_tags($_POST['newVarID'])));

if($newVar == "")
 { 
   	$_SESSION['ErrMsg'] = "No Variable Name";
	header('Location: postingsettings');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM acc_settings WHERE variable='$newVar'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Variable already exist";
		header('Location: postingsettings');
		exit;
	 } 

 	$query = "INSERT INTO acc_settings (variable, value, valueID) 
VALUES ('$newVarName','$newVar', '$newVarID');";

if(mysql_query($query))
 {
 	$_SESSION['ErrMsgB'] = "Congratulations! New Variable is added";
	header('Location: postingsettings');
}
else
{
	echo mysql_error();
}
  


 }


exit;


?>
