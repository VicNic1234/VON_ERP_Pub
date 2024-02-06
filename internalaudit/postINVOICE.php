<?php
//error_reporting(E_ALL); ini_set('display_errors', 1);
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');

$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];
$TodayD = date("Y-m-d h:i:s a");

$CONID = $_POST['poid'];



function GETGL($GLID)
{
    $GLAccounts = mysql_query("SELECT * FROM acc_chart_master WHERE mid='".$GLID."'"); 
 while ($row = mysql_fetch_array($GLAccounts)) {
     //$reqid = $row['reqid'];
     $acctvariable = $row['account_code'];
     $GLmid = $row['mid'];
      $GLAcct = $row['account_name'];
 }
     return '['. $acctvariable .'] ' .$GLAcct;
   // return '<b title="">['. $acctvariable .']</b>';
}

 $resultLI = mysql_query("SELECT * FROM acct_vendorsinvoices 
 LEFT JOIN suppliers ON acct_vendorsinvoices.VendSource = suppliers.supid
 LEFT JOIN users ON acct_vendorsinvoices.ENLATTN = users.uid
 WHERE cid='".$CONID."'
 "); //WHERE isActive=1 ORDER BY cid

$NoRowLI = mysql_num_rows($resultLI); 
//fetch tha data from the database
   if ($NoRowLI > 0) 
   {
   $SN = 1;
  while ($row = mysql_fetch_array($resultLI)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     
    $cid = $row['cid'];
    $PONUM = $row['PONUM'];
    $IVNo = $row['IVNo'];
    $Comment = $row['Comment'];
    $conDiv = $row['conDiv'];
    $IVDate = $row['IVDate'];
    $ENLATTN = $row['ENLATTN'];
    $VENATTN = $row['$VENATTN'];
    $Currency = $row['Currency'];
    $PDFNUM = $row['PONUM'];
    $ATTNME = $row['Firstname'] . " " . $row['Surname'];
    $ATTPHONE = $row['Phone'];
    $ATTEMAIL = $row['Email'];
    $Currency = $row['Currency'];
    $PDFNUM = $row['PONUM'];
    $SupNme = $row['SupNme'];
    $SupAddress = $row['SupAddress'];
    //$SupCountry = $row['SupCountry'];
    $SupPhone1 = $row['SupPhone1'];
    $VendSource = $row['VendSource'];
    $ContNum = $row['ContNum'];
    $BnkID = $row['BnkID'];
    $PostID = $row['PostID']; 
    
    $IVDate = $row['IVDate'];
    
    
    $NGNRate = $row['NGNRate'];
    
    $ENLBANK = $row['ENLBANK']; 
    
   $CRDGL = $row['CRDGL'];
    
    
    
    $ServicENum = $row['ServicENum'];
    $VenCode = $row['VendSource'];
    $BnkID = $row['BnkID'];
    /*$DDOfficerComment = $row['DDOfficerComment'];
    $DDOfficerOn = $row['DDOfficerOn'];*/
    //$DDOfficer = getUserInfo($row['DDOfficer']);
    $RaisedBy = $row['RaisedBy'];

    }
    
    if($PostID == 1) 
    {
        $_SESSION['ErrMsg'] = "Oops! Already Posted. Thanks";
        if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
       }
       exit;
    }
  }
  else
  {
    $_SESSION['ErrMsg'] = "Oops! an error occured, try again";
   if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit;
  }
  
  function getTotalSum($CONID)
{
        /*Get Line Item */
$resultPOIt = mysql_query("SELECT * FROM acct_ivitems Where PONo='".$CONID."' AND isActive=1");
$NoRowPOIt = mysql_num_rows($resultPOIt);
 $SN = 0; $SubTotal = 0; $MainTotal = 0;
if ($NoRowPOIt > 0) {
  while ($row = mysql_fetch_array($resultPOIt)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $PDFNUM = $row['PDFNUM'];
    $PDFItemID = $row['PDFItemID'];
    $description = $row['description'];
    $units = $row['units'];
    $qty = $row['qty'];
    $unitprice = $row['unitprice'];
    $totalprice = floatval($unitprice) * floatval($qty);
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $delDoc = "";
    $SubTotal = $SubTotal + $totalprice;
    
    
   
  }
 } 





$MainTotal =  $SubTotal;
//PO Miscellaneous
           /*Get M Item */
$resultPOM = mysql_query("SELECT * FROM acct_ivmiscellaneous Where PONo='".$CONID."' AND isActive=1");
$NoRowPOM = mysql_num_rows($resultPOM);
 $SN = 0;
if ($NoRowPOM > 0) {
  while ($row = mysql_fetch_array($resultPOM)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $description = $row['description'];
    $mprice = $row['price'];
    $Impact = $row['Impact'];
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $AmtType = $row['AmtType'];
    $delDoc = "";
   

    if($Impact == "ADD") { 
      $Impact = "+"; 
      if($AmtType == "DIRECT")
      {
       $MainTotal = $MainTotal + $mprice;
      }
      else{ $MainTotal = $MainTotal + ($SubTotal * $mprice)/100; $PERT = "%"; }
    }
    else { 
      $Impact = "-"; 
      
      if($AmtType == "DIRECT")
      {
       $MainTotal = $MainTotal - $mprice;
      }
      else{ $MainTotal = $MainTotal - ($SubTotal * $mprice)/100; $PERT = "% of Sub Total"; }

    }
}
}

return ($MainTotal);

}
  
  $BANKGL = $BnkID;
  $RaisedBy = $RaisedBy;
  $trandate = $IVDate;
  
   $CUSID = $VendSource;
      $ENLIV = $cid;
      $Currency = $Currency;
      $GLAmt = getTotalSum($cid);
      $GLDes = "Trade Payable";
  //$ChqNo = $ENLIV;
  $ChqNo = "";
   //First we need to Debit the Customer now
    $query1 = "INSERT INTO postings (ChqNo, VINVOICE, REQCODE, BankAccount, ReceivedBy, GLImpacted, GLDescription, TransactionAmount, 
         TransacType, TransactionDate, Remark, PostedBy, PostedOn, RptType, Currency, CounterTrans, VendorID) 
         VALUES ('$ChqNo', '$ENLIV','VENCREDIT', '$BANKGL','$RaisedBy','602','$GLDes','$GLAmt', 'CREDIT', '$trandate', '$Comment', '$uid', '$TodayD', 'Payable', '$Currency', '0', '$VenCode');";

         mysql_query($query1);

         $LastTranID1 = mysql_insert_id();
         mysql_query("UPDATE acct_vendorsinvoices SET PostedOn='".$TodayD."', PostID='".$LastTranID1."', PostedBy='".$uid."' WHERE cid = '$ENLIV'");
  
      /*Get Line Item */
$resultPOIt = mysql_query("SELECT * FROM acct_ivitems Where PONo='".$CONID."' AND isActive=1");
$NoRowPOIt = mysql_num_rows($resultPOIt);
 $SN = 0; $SubTotal = 0; $MainTotal = 0;
if ($NoRowPOIt > 0) {
  while ($row = mysql_fetch_array($resultPOIt)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $PDFNUM = $row['PDFNUM'];
    $PDFItemID = $row['PDFItemID'];
    $description = $row['description'];
    $units = $row['units'];
    $qty = $row['qty'];
    $unitprice = $row['unitprice'];
    $totalprice = floatval($unitprice) * floatval($qty);
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $ItemGL = $row['ItemGL'];
    $delDoc = "";
    $SubTotal = $SubTotal + $totalprice;
      $delDoc = '<a href="deldoc?id='.$sdid.'"><i class="fa fa-trash"></i></a>';
      
      
      $GLDes = GETGL($ItemGL);
      $GLID = $ItemGL;
      $GLAmt = $totalprice;
      //$BusUnit = $RawITD[3];
     // $EquipC = $RawITD[4];
      $CHSItemDesc = $description;
      $CHSItemQty = $qty;
      $CHRNum = $PDFNUM;
      $CHSItem = $sdid;
     // $POSTType = $RawITD[9];
      $CUSID = $CusSource;
      $ENLIV = $cid;
      $Currency = $Currency;
  //$ChqNo = $ENLIV;
  $ChqNo = "";
   // exit;
    $query1 = "INSERT INTO postings (VINVOICE, REQCODE, CHRID, ItemQty, BankAccount, ChqNo, ReceivedBy, GLImpacted, GLDescription, TransactionAmount, 
         TransacType, TransactionDate, Remark, PostedBy, PostedOn, RptType, Currency, CRCenter, CounterTrans, VendorID, NGNTCURR) VALUES ('$ENLIV','$CHRNum', '$CHSItem', '$CHSItemQty', '$BANKGL','$ChqNo','$RaisedBy','$GLID','$GLDes','$GLAmt', 'DEBIT', '$trandate', '$CHSItemDesc', '$uid', '$TodayD', 'Payable', '$Currency', '$BusUnit',  '$LastTranID1', '$VenCode', '$NGNTCURR');";

         mysql_query($query1);

         $LastTranID2 = mysql_insert_id();

        mysql_query("UPDATE acct_ivitems SET PostedOn='".$TodayD."', PostID='".$LastTranID2."' WHERE poitid = '$CHSItem'");
  }
 }
 
 

 

$MainTotal =  $SubTotal;
//PO Miscellaneous
           /*Get M Item */
$resultPOM = mysql_query("SELECT * FROM acct_ivmiscellaneous Where PONo='".$CONID."' AND isActive=1");
$NoRowPOM = mysql_num_rows($resultPOM);
 $SN = 0;
if ($NoRowPOM > 0) {
  while ($row = mysql_fetch_array($resultPOM)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $description = $row['description'];
    $mprice = floatval($row['price']);
    $Impact = $row['Impact'];
    $ImpactM = $row['Impact'];
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $isActive = $row['isActive'];
    $ItemGL = $row['ItemGL'];
     $AmtType = $row['AmtType'];
    $delDoc = "";
   

    if($Impact == "ADD") { 
      $Impact = "+"; 
      if($AmtType == "DIRECT")
      {
       $MainTotal = floatval($MainTotal) + $mprice;
       $totalprice = floatval($mprice);
      }
      else{ $MainTotal = floatval($MainTotal) + (floatval($SubTotal) * $mprice)/100; $PERT = "% of Sub Total";
      $totalprice = (floatval($SubTotal) * $mprice)/100; }
     
    }
    else { 
      $Impact = "-"; 
      
      if($AmtType == "DIRECT")
      {
       $MainTotal = $MainTotal - $mprice;
       $totalprice = floatval($mprice);
      }
      else{ $MainTotal = $MainTotal - ($SubTotal * $mprice)/100; $PERT = "% of Sub Total"; 
          $totalprice = (floatval($SubTotal) * $mprice)/100;
      }

    }
    
    
      $GLDes = GETGL($ItemGL);
      $GLID = $ItemGL;
      $GLAmt = $totalprice;
      //$BusUnit = $RawITD[3];
     // $EquipC = $RawITD[4];
      $CHSItemDesc = $description;
      $CHSItemQty = 1;
      $CHRNum = 0;
      $CHSItem = $sdid;
      $POSTType = $RawITD[9];
      $CUSID = $CusSource;
      $ENLIV = $cid;
      $Currency = $Currency;
    $ChqNo = "";
    //exit;
    if($ImpactM == "ADD") { 
    $query1 = "INSERT INTO postings (VINVOICE, REQCODE, CHRID, ItemQty, BankAccount, ChqNo, ReceivedBy, GLImpacted, GLDescription, TransactionAmount, 
         TransacType, TransactionDate, Remark, PostedBy, PostedOn, RptType, Currency, CRCenter, CounterTrans, VendorID, NGNTCURR) VALUES ('$ENLIV','$CHRNum', '$CHSItem', '$CHSItemQty', '$BANKGL','$ChqNo','$RaisedBy','$GLID','$GLDes','$GLAmt', 'DEBIT', '$trandate', '$CHSItemDesc', '$uid', '$TodayD', 'Payable', '$Currency', '$BusUnit',  '$LastTranID1', '$VenCode', '$NGNTCURR');";
    }
    else
    {
         $query1 = "INSERT INTO postings (VINVOICE, REQCODE, CHRID, ItemQty, BankAccount, ChqNo, ReceivedBy, GLImpacted, GLDescription, TransactionAmount, 
         TransacType, TransactionDate, Remark, PostedBy, PostedOn, RptType, Currency, CRCenter, CounterTrans, VendorID, NGNTCURR) VALUES ('$ENLIV','$CHRNum', '$CHSItem', '$CHSItemQty', '$BANKGL','$ChqNo','$RaisedBy','$GLID','$GLDes','$GLAmt', 'DEBIT', '$trandate', '$CHSItemDesc', '$uid', '$TodayD', 'Payable', '$Currency', '$BusUnit',  '$LastTranID1', '$VenCode', '$NGNTCURR');";
    
    }
         mysql_query($query1);

         $LastTranID2 = mysql_insert_id();

        mysql_query("UPDATE acct_ivmiscellaneous SET PostedOn='".$TodayD."', PostID='".$LastTranID2."' WHERE poitid = '$CHSItem'");
      
    
    
    
    
   
  }
 }
 
 
//exit;


///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Posted. Thanks";
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
mysql_close($dbhandle);
exit;









?>