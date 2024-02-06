<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $CusSource = trim(strip_tags($_POST['CusSource']));
  $InvoiceDate = trim(strip_tags($_POST['InvoiceDate']));
  $ENLATTN = trim(strip_tags($_POST['ENLATTN']));
  $CUSATTN = trim(strip_tags($_POST['CUSATTN']));
  $conDiv = trim(strip_tags($_POST['conDiv']));
  $Comment = trim(strip_tags($_POST['Comment']));
  $VenCode = trim(strip_tags($_POST['VenCode']));
  $ServicENum = trim(strip_tags($_POST['ServicENum']));
  $Comment = trim(strip_tags($_POST['Comment']));
  $currency = trim(strip_tags($_POST['currency']));
  $ENLInvoiceID = trim(strip_tags($_POST['ENLInvoiceID']));
  $ContNum = trim(strip_tags($_POST['ContNum']));
  $ENLPONum = trim(strip_tags($_POST['ENLPONum']));
  $NGNRate = trim(strip_tags($_POST['NGNRate']));
  
  $Today = date('Y/m/d h:i:s a'); 
 
  

	$query1 = "INSERT INTO enlinvoices (IVNo, NGNRate, Comment, conDiv, IVDate, ENLATTN, CUSATTN, CusSource, RaisedBy, RaisedOn, FileLink, Currency, ContNum, PONUM, ServicENum, VenCode, Bank) 
	VALUES ('".$ENLInvoiceID."','".$NGNRate."','".$Comment."','".$conDiv."','".$InvoiceDate."','".$ENLATTN."', '".$CUSATTN."', '".$CusSource."','".$UID."','".$Today."', '".$FILEURL."', '".$currency."', '".$ContNum."', '".$ENLPONum."', '".$ServicENum."', '".$VenCode."', '".$Bank."');";

if(mysql_query($query1, $dbhandle))
{
  

  	$_SESSION['ErrMsgB'] = "Registered ".$ENLInvoiceID;
	header('Location: enlinvoice');
mysql_close($dbhandle);
exit;
  	
 }
 else{
echo mysql_error();
exit;
 $_SESSION['ErrMsg'] = "Oops! Did not register : ".$VenInvoiceID;
  header('Location: enlinvoice');
//close the connection
mysql_close($dbhandle);
}



?>