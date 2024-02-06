<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $VendSource = trim(strip_tags($_POST['VendSource']));
  $InvoiceDate = trim(strip_tags($_POST['InvoiceDate']));
  $ENLATTN = trim(strip_tags($_POST['ENLATTN']));
  $VENDATTN = trim(strip_tags($_POST['VENDATTN']));
  $conDiv = trim(strip_tags($_POST['conDiv']));
  $Comment = addslashes(trim(strip_tags($_POST['Comment'])));
  $VenInvoiceID = trim(strip_tags($_POST['VenInvoiceID']));
  $totalSum = trim(strip_tags($_POST['totalSum']));
  $currency = trim(strip_tags($_POST['currency']));
  $PDFNum = trim(strip_tags($_POST['PDFNum']));
  $ENLPONum = trim(strip_tags($_POST['ENLPONum']));
  $Scope = addslashes(trim(strip_tags($_POST['Scope'])));

  $Today = date('Y/m/d h:i:s a'); 
 
  
if (isset($_FILES['VENFile']) && $_FILES['VENFile']['size'] > 0) 
{ 
 
}
////////////////////////////////////////////////////////
$sizemdia = $_FILES['VENFile']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  header('Location: newinvoice');
  exit;
  }
//Let's set new Name for file
 $ftmpName  = $_FILES['VENFile']['tmp_name']; 
        $fimgName = $_FILES['VENFile']['name'];
        

        send1:    
        $FILEID = date('Ymd_his');
       $ext = pathinfo($fimgName, PATHINFO_EXTENSION); 
       // $temp = explode(".", $_FILES["file"]["name"]);
        //$newfilename = round(microtime(true)) . '.' . end($temp);
         if (file_exists("../INVAttach/" . $FILEID .".". $ext )) { goto send1; } else
            {
              $FILEURL = "../INVAttach/" . $FILEID .".". $ext;
            }
        
         

/////////////////////////////////////////////////////////////
//Here we need to send details to Contract Table
        if (isset($_FILES['VENFile']) && $_FILES['VENFile']['size'] > 0) 
        { 
          move_uploaded_file($ftmpName, $FILEURL);
          
        }
        else
        {
          $FILEURL = "";
        }

	$query1 = "INSERT INTO vendorsinvoices (IVNo, Comment, conDiv, IVDate, ENLATTN, VENATTN, VendSource, RaisedBy, RaisedOn, FileLink, Currency, PDFNUM, PONUM, ScopeOfSW) 
	VALUES ('".$VenInvoiceID."','".$Comment."','".$conDiv."','".$InvoiceDate."','".$ENLATTN."', '".$VENDATTN."', '".$VendSource."','".$UID."','".$Today."', '".$FILEURL."', '".$currency."', '".$PDFNum."', '".$ENLPONum."', '".$Scope."');";

if(mysql_query($query1, $dbhandle))
{
  

  	$_SESSION['ErrMsgB'] = "Registered ".$VenInvoiceID;
	header('Location: newinvoice');
mysql_close($dbhandle);
exit;
  	
 }
 else{
echo mysql_error();
exit;
 $_SESSION['ErrMsg'] = "Oops! Did not register : ".$VenInvoiceID;
  header('Location: newinvoice');
//close the connection
mysql_close($dbhandle);
}



?>