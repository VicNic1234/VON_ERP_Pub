<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $ID = trim(strip_tags($_GET['id']));
  

  $Today = date('Y/m/d h:i:s a'); 
 
  

	$query1 = "UPDATE legalmeetings SET isActive=0 WHERE sdid='".$ID."'";


if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Meeting Deleted";
	header('Location: meetings');
mysql_close($dbhandle);
exit;
  	
 }
 else{
echo mysql_error();
exit;
 $_SESSION['ErrMsg'] = "Oops! Meeting Not Deleted";
  header('Location: meetings');
//close the connection
mysql_close($dbhandle);
}



?>