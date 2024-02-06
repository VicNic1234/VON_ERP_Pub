<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $DocTitle = trim(strip_tags($_POST['DocTitle']));
  $DocDescr = trim(strip_tags($_POST['DocDescr']));
 // $DocLink = trim(strip_tags($_POST['DocLink']));
  //$DocFile = trim(strip_tags($_POST['DocFile']));
 

  $Today = date('Y/m/d h:i:s a'); 
 

	$query1 = "INSERT INTO legalsubjects (description, title, addedby, addedon) 
	VALUES ('".$DocDescr."','".$DocTitle."','".$UID."','".$Today."');";

if(mysql_query($query1, $dbhandle))
{
   
  	$_SESSION['ErrMsgB'] = "Subject is Added";
  header('Location: subjects');

mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not add Subject ";
  header('Location: subjects');
  

//close the connection
mysql_close($dbhandle);
}



?>