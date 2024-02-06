<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];
$CPOfficer = $_SESSION['Firstname'] . " " . $_SESSION['Surname'];

  $conID = trim(strip_tags($_POST['conID']));
  $PDFNum = trim(strip_tags($_POST['PDFNum']));
  $PDFItem = trim(strip_tags($_POST['PDFItem']));

  $ItemDesc = trim(strip_tags($_POST['ItemDesc']));

  $ItemUnit = trim(strip_tags($_POST['ItemUnit']));
  $UnitQty = trim(strip_tags($_POST['UnitQty']));
  $UnitPrice = trim(strip_tags($_POST['UnitPrice']));
  $TotalPrice = trim(strip_tags($_POST['TotalPrice']));
  $ItemGL = trim(strip_tags($_POST['ItemGL']));
 
$CPOfficer = "C&P : ". $CPOfficer;
  $Today = date('Y/m/d h:i:s a'); 
 

	$query1 = "INSERT INTO enlivitems (PONo, PDFNUM, PDFItemID, CreatedBy, description, units, qty, unitprice, CreatedOn, ItemGL) 
	VALUES ('".$conID."','".$PDFNum."','".$PDFItem."','".$UID."','".$ItemDesc."','".$ItemUnit."','".$UnitQty."','".$UnitPrice."','".$Today."','".$ItemGL."');";
	
	

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