<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $ID = trim(strip_tags($_GET['id']));
  $cnID = trim(strip_tags($_GET['cnid']));
 

  $Today = date('Y/m/d h:i:s a'); 
 
  

	$query1 = "UPDATE supportingdoc SET isActive=0 WHERE sdid='".$ID."'";


if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Doc Deleted";
	header('Location: viewequip?cnid='.$cnID);
mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Doc Not Deleted";
  header('Location: viewequip?cnid='.$cnID);
//close the connection
mysql_close($dbhandle);
}



?>