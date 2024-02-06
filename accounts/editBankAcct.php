<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$accid = mysql_real_escape_string(trim(strip_tags($_POST['accid'])));
$editDes = mysql_real_escape_string(trim(strip_tags($_POST['editDes'])));
$editAccNum = mysql_real_escape_string(trim(strip_tags($_POST['editAccNum'])));
$editAccNme = mysql_real_escape_string(trim(strip_tags($_POST['editAccNme']))); 
$editSortCode = mysql_real_escape_string(trim(strip_tags($_POST['editSortCode']))); 
$editBnkNme = mysql_real_escape_string(trim(strip_tags($_POST['editBnkNme']))); 
$editBnkAdd = mysql_real_escape_string(trim(strip_tags($_POST['editBnkAdd']))); 
$editGLAcct = mysql_real_escape_string(trim(strip_tags($_POST['editGLAcct']))); 
$editStatus = mysql_real_escape_string(trim(strip_tags($_POST['editStatus']))); 
$editCurr = mysql_real_escape_string(trim(strip_tags($_POST['editCurr']))); 

if($accid == "")
 { 
   	$_SESSION['ErrMsg'] = "No Complete Bank Details";
	header('Location: banksettings');
 } 
 else 
 {

 	$query = "UPDATE bankaccount SET description='".$editDes."', acctnum='".$editAccNum."', 
 	 acctnme ='".$editAccNme."', sortcode ='".$editSortCode."', bnkname ='".$editBnkNme."', bnkaddress ='".$editBnkAdd."',
 	 GLAcct ='".$editGLAcct."', isActive ='".$editStatus."', currency ='".$editCurr."'
 	  WHERE baccid = '$accid'";
 	//Check if exist
 	/*
 	$chkExist = mysql_query("SELECT * FROM acc_settings WHERE variable='$newVarName'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Variable already exist";
		header('Location: settings');
		exit;
	 } 
	 */

 	


if(mysql_query($query))
 {
 	$_SESSION['ErrMsgB'] = "Bank is Update";
	header('Location: banksettings');
}
else
{
	echo mysql_error();
}
  


 }


exit;


?>
