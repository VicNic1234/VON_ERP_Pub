<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $Q1 = trim(strip_tags($_POST['Q1']));
  $Q2 = trim(strip_tags($_POST['Q2']));
  
  $Q3 = trim(strip_tags($_POST['Q3']));
  $Q4 = trim(strip_tags($_POST['Q4']));
  
  $Q5 = trim(strip_tags($_POST['Q5']));
  $Q6 = trim(strip_tags($_POST['Q6']));
  
  $observation = trim(strip_tags($_POST['observation']));
  $recommendation = trim(strip_tags($_POST['recommendation']));
  
 

  $Today = date('Y/m/d h:i:s a'); 
 
  

	$query1 = "INSERT INTO survey (	uid, Q1, Q2, Q3, Q4, Q5, Q6, recommendation, observation, CreatedOn) 
	VALUES ('".$UID."','".$Q1."','".$Q2."','".$Q3."','".$Q4."','".$Q5."','".$Q6."','".$recommendation."', '".$observation."', '".$Today."');";

if(mysql_query($query1, $dbhandle))
{
  

  	$_SESSION['ErrMsgB'] = "Thanks you taking time to go through the Survey ".$ContractNo;
	header('Location: ../');
mysql_close($dbhandle);
exit;
  	
 }
 else{
echo mysql_error();
exit;
 $_SESSION['ErrMsg'] = "Oops! Did not create : ".$ContractNo;
  header('Location: ../');
//close the connection
mysql_close($dbhandle);
}



?>