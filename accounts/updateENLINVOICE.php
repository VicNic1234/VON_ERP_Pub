<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

 $ConID = trim(strip_tags($_POST['conID']));
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
  $ENLBANK = trim(strip_tags($_POST['ENLBANK']));
    $CRDGL = trim(strip_tags($_POST['DBDGL']));
    $NGNRate = trim(strip_tags($_POST['NGNRate']));
    
  


  $Today = date('Y/m/d h:i:s a'); 
 

  $query1 = "UPDATE enlinvoices SET NGNRate='".$NGNRate."', CRDGL='".$CRDGL."', BnkID='".$ENLBANK."', IVNo='".$ENLInvoiceID."', Comment='".$Comment."', conDiv='".$conDiv."', IVDate='".$InvoiceDate."', ENLATTN='".$ENLATTN."', CUSATTN='".$CUSATTN."', CusSource='".$CusSource."', RaisedBy='".$UID."', RaisedOn='".$Today."', Currency='".$currency."', ContNum='".$ContNum."', PONUM='".$ENLPONum."', ServicENum='".$ServicENum."', VenCode='".$VenCode."', Bank='".$Bank."' WHERE cid='".$ConID."'";

 



if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Updated ".$ENLInvoiceID;
	header('Location: viewenlinvoice?poid='.$ConID);
mysql_close($dbhandle);
exit;
  	
 }
 else{
echo mysql_error();
exit;
 $_SESSION['ErrMsg'] = "Oops! Did not update : ".$ENLInvoiceID;
  header('Location: viewenlinvoice?poid='.$ConID);

//close the connection
mysql_close($dbhandle);
}



?>