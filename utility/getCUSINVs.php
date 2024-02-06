<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];

$TRowArray = "";
$CusID = mysql_real_escape_string(trim(strip_tags($_POST['CusID'])));


if($CusID == 0 || $CusID == "") { }
else 
{
   // $OptInvNo .= '<option value="0">New InvoiceNo.</option>';
    $resultInvoiceNum = mysql_query("SELECT * FROM salesinvoice WHERE cusid = '$CusID' ");
    $NoRowInvONo = mysql_num_rows($resultInvoiceNum);
    if($NoRowInvONo > 0)
    {
        while ($row = mysql_fetch_array($resultInvoiceNum))
        { 
          //$OptInvNo .= '<option value="'.$row['InvoiceNo'].'">'.$row['InvoiceNo'].'</option>';
          $InvoiceTable .= '<tr><td>'.$row['InvoiceNo'].'</td><td>'.$row['InvoDate'].'</td><td>'.$row['TermDay'].'</td><td>'.$row['Currency'].'</td><td>'.$row['NGNCRate'].'</td></tr>';
        }
    }

    $resultOrderNum = mysql_query("SELECT * FROM so WHERE cusid = '$CusID' ");
    $NoRowOrdNo = mysql_num_rows($resultOrderNum);
    if($NoRowOrdNo > 0)
    {
        while ($row = mysql_fetch_array($resultOrderNum))
        { 
          $OptOrdNo .= '<option value="'.$row['poID'].'">'.$row['CusONo'].'</option>';
        }
    }

    //Let's Get Customer's Address
    $resultCusInfo = mysql_query("SELECT * FROM customers WHERE cusid = $CusID ");
    $NoRowCusInfo = mysql_num_rows($resultCusInfo);
    if($NoRowCusInfo > 0)
    {
        while ($rown = mysql_fetch_array($resultCusInfo))
        { 
          $CusAdddress = $rown['CusAddress'];
          $InvoiceAdd = $rown['InvoiceAdd'];
          $VendorCode = $rown['VendorCode'];
          $CusEmail = $rown['email'];
          $CusURL = $rown['webaddress'];

        }

        if($CusEmail != "") { $CusEmail = "Email: ".  $CusEmail;} if($CusURL != ""){ "URL: ".  $CusURL; }
    }
}

$InvoiceDetails = array();
//$InvoiceDetails['OptInvNo'] = $OptInvNo;
$InvoiceDetails['InvTab'] = $InvoiceTable;

$InvoiceDetails['OptOrdNo'] = $OptOrdNo;
//$InvoiceDetails['CusAddress'] = $CusAdddress; //Email: accounts@pengrg.com
$InvoiceDetails['CusAddress'] = $InvoiceAdd; //Email: accounts@pengrg.com 
$InvoiceDetails['VendorCode'] = $VendorCode; 
$InvoiceDetails['CusEmail'] = $CusEmail; 
$InvoiceDetails['CusURL'] = $CusURL; 



echo json_encode($InvoiceDetails);


?>
