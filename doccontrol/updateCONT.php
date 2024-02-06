<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $ConID = trim(strip_tags($_POST['conID']));
  $legalcomment = trim(strip_tags($_POST['legalcomment']));
 $legelapprove = trim(strip_tags($_POST['legelapprove'])); //exit;


  $Today = date('Y/m/d h:i:s a'); 
 $FDate ="";
  

if($legelapprove == "on"){
	$query1 = "UPDATE contracts SET LegalOfficer='".$UID."', LegalOfficerComment='".$legalcomment."', LegalOfficerOn='".$Today."' WHERE cid='".$ConID."'";
}
else
  {
  $query1 = "UPDATE contracts SET LegalOfficer='".$UID."', LegalOfficerComment='".$legalcomment."', LegalOfficerOn='".$FDate."' WHERE cid='".$ConID."'";
}


if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Updated ";
	header('Location: viewcon?cnid='.$ConID);
mysql_close($dbhandle);
exit;
  	
 }
 else{
echo mysql_error();
exit;
 $_SESSION['ErrMsg'] = "Oops! Did not update ";
  header('Location: viewcon?cnid='.$ConID);
//close the connection
mysql_close($dbhandle);
}



?>