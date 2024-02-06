<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $Item = trim(strip_tags($_POST['id']));
  $poid = trim(strip_tags($_POST['poid']));

  $Today = date('Y/m/d h:i:s a'); 
 

if($Item != "")
{
  $query1 = "UPDATE pomiscellaneous SET isActive='0' WHERE poitid='".$Item."'";
}
else
{
  $_SESSION['ErrMsg'] = "Oops! Did not delete ";
  header('Location: viewpo?poid='.$poid);
  exit;
}


if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Item Deleted";
	header('Location: viewpo?poid='.$poid);
mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not delete ";
  header('Location: viewpo?poid='.$poid);

//close the connection
mysql_close($dbhandle);
}



?>