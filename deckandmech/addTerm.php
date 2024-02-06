<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

   $conID = trim(strip_tags($_POST['conID']));
  $Term = mysql_real_escape_string(trim(strip_tags($_POST['Term'])));
 

  $Today = date('Y/m/d h:i:s a'); 
 

	$query1 = "INSERT INTO terms (module, TransID, Terms, CreatedBy, CreatedOn) 
	VALUES ('RFQ','".$conID."','".$Term."','".$UID."','".$Today."');";

if(mysql_query($query1, $dbhandle))
{
   
  	$_SESSION['ErrMsgB'] = "Term is Added";
  header('Location: viewrfq?cnid='.$conID);

mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not add term ";
  header('Location: viewrfq?cnid='.$conID);

//close the connection
mysql_close($dbhandle);
}



?>