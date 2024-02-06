<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


//$nmeClass = mysql_real_escape_string(trim(strip_tags($_POST['nmeClass'])));
//$accType = mysql_real_escape_string(trim(strip_tags($_POST['accType'])));
$idType = mysql_real_escape_string(trim(strip_tags($_POST['idType'])));

if($idType == "")
 { 
   $_SESSION['ErrMsg'] = "Account Type not selected";
	header('Location: chartType');
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM acc_chart_types WHERE id='$idType'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist == 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Account Type does not exist";
		header('Location: chartType');
		exit;
	 } 
 	
 	$sql_res=mysql_query("DELETE FROM acc_chart_types WHERE id = '$idType'");
	mysql_query($sql_res, $dbhandle);
  
	$_SESSION['ErrMsgB'] = "Deleted!";
	header('Location: chartType');

 }



mysql_close($dbhandle);
exit;


?>
