<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $ConID = trim(strip_tags($_POST['conID']));
  $DDcomment = trim(strip_tags($_POST['DDcomment']));
  $DDapprove = trim(strip_tags($_POST['DDapprove'])); //exit;


  $Today = date('Y/m/d h:i:s a'); 
 $FDate ="";
  

if($DDapprove == "on"){
	$query1 = "UPDATE purchaseorders SET DDOfficer='".$UID."', DDOfficerComment='".$DDcomment."', DDOfficerOn='".$Today."' WHERE cid='".$ConID."'";
}
else
  {
  $query1 = "UPDATE purchaseorders SET DDOfficer='".$UID."', DDOfficerComment='".$DDcomment."', DDOfficerOn='".$FDate."' WHERE cid='".$ConID."'";
}


if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Updated ";
	header('Location: printPO?cnid='.$ConID);
mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not update ";
  header('Location: printPO?cnid='.$ConID);
//close the connection
mysql_close($dbhandle);
}



?>