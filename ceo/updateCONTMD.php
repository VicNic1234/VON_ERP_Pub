<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $ConID = trim(strip_tags($_POST['ConID']));
  $MDcomment = trim(strip_tags($_POST['MDcomment']));
 $MDapprove = trim(strip_tags($_POST['MDapprove'])); 


  $Today = date('Y/m/d h:i:s a'); 
 
  

if($MDapprove == "on"){
	$query1 = "UPDATE contracts SET MDOfficeComment='".$MDcomment."', MDOffice='".$UID."', MDOfficeOn='".$Today."' WHERE cid='".$ConID."'";
}
else
  {
    $query1 = "UPDATE contracts SET MDOfficeComment='".$MDcomment."', MDOffice='".$UID."', MDOfficeOn='' WHERE cid='".$ConID."'";
}


if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Update ".$ContractNo;
	header('Location: viewcon?cnid='.$ConID);
mysql_close($dbhandle);
exit;
  	
 }
 else{
echo mysql_error();
exit;
 $_SESSION['ErrMsg'] = "Oops! Did not update : ".$ContractNo;
  header('Location: viewcon?cnid='.$ConID);
//close the connection
mysql_close($dbhandle);
}



?>