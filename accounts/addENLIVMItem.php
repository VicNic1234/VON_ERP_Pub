<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $conID = trim(strip_tags($_POST['conID']));
  $ItemDesc = trim(strip_tags($_POST['ItemDesc']));
  $ItemImpact = trim(strip_tags($_POST['ItemImpact']));
  $ItemPrice = trim(strip_tags($_POST['ItemPrice']));
  $AmtType = trim(strip_tags($_POST['AmtType']));
  $ItemGL = trim(strip_tags($_POST['ItemGL']));
 
  //$DocFile = trim(strip_tags($_POST['DocFile']));
 

  $Today = date('Y/m/d h:i:s a'); 
 

	$query1 = "INSERT INTO enlivmiscellaneous (PONo, CreatedBy, description, Impact, price, AmtType, CreatedOn, ItemGL) 
	VALUES ('".$conID."','".$UID."','".$ItemDesc."','".$ItemImpact."','".$ItemPrice."','".$AmtType."','".$Today."', '".$ItemGL."');";

if(mysql_query($query1, $dbhandle))
{
   
  	$_SESSION['ErrMsgB'] = "Item is Added";
  header('Location: viewenlinvoice?poid='.$conID);

mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not add Item ";
  header('Location: viewenlinvoice?poid='.$conID);

//close the connection
mysql_close($dbhandle);
}



?>