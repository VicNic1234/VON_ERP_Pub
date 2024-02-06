<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

   $conID = trim(strip_tags($_POST['conID']));
  $LiDescription = mysql_real_escape_string(trim(strip_tags($_POST['LiDescription'])));
  $LiQty = trim(strip_tags($_POST['LiQty']));
  $LiRate = trim(strip_tags($_POST['LiRate']));
  $LiTRate = trim(strip_tags($_POST['LiTRate']));
  $UOM = trim(strip_tags($_POST['UOM']));
  //$DocFile = trim(strip_tags($_POST['DocFile']));
 

  $Today = date('Y/m/d h:i:s a'); 
 

	$query1 = "INSERT INTO lineitems (RFQCode, Status, Description, Qty, UOM, UnitCost, ExtendedCost, addedby, addedon) 
	VALUES ('".$conID."','OPEN','".$LiDescription."','".$LiQty."','".$UOM."','".$LiRate."','".$LiTRate."','".$UID."','".$Today."');";

if(mysql_query($query1, $dbhandle))
{
   
  	$_SESSION['ErrMsgB'] = "Line Item is Added";
  header('Location: viewrfq?cnid='.$conID);

mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not add Item ";
  header('Location: viewrfq?cnid='.$conID);

//close the connection
mysql_close($dbhandle);
}



?>