<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];

$TRowArray = "";
$VenID = mysql_real_escape_string(trim(strip_tags($_POST['VenID'])));


if($VenID == 0 || $VenID == "") { }
else 
{
   // $OptInvNo .= '<option value="0">New InvoiceNo.</option>';
    $resultInvoiceNum = mysql_query("SELECT * FROM purchaseinvoice WHERE venid = '$VenID' ");
    $NoRowInvONo = mysql_num_rows($resultInvoiceNum);
    if($NoRowInvONo > 0)
    {
        while ($row = mysql_fetch_array($resultInvoiceNum))
        { 
          $OptInvNo .= '<option value="'.$row['InvoiceNo'].'">'.$row['InvoiceNo'].'</option>';
        }
    }

    $resultOrderNum = mysql_query("SELECT * FROM purchaseorders WHERE VendSource = '$VenID' ");
    $NoRowOrdNo = mysql_num_rows($resultOrderNum);
    if($NoRowOrdNo > 0)
    {
        while ($row = mysql_fetch_array($resultOrderNum))
        { 
          $OptOrdNo .= '<option value="'.$row['PONo'].'">'.$row['PONo'].'</option>';
        }
    }

    //Let's Get Suppliers's Address
    $resultSupInfo = mysql_query("SELECT * FROM suppliers WHERE supid = $VenID ");
    $NoRowSupInfo = mysql_num_rows($resultSupInfo);
    if($NoRowSupInfo > 0)
    {
        while ($rown = mysql_fetch_array($resultSupInfo))
        { 
          $SupNme = $rown['SupNme'];
          $SupAddress = $rown['SupAddress'];
          $SupEmail = $rown['SupEMail'];
          $SupURL = $rown['SupURL'];
          $SupPhone1 = $rown['SupPhone2'];
          $SupRefNo = $rown['SupRefNo'];
          $TINNo = $rown['SupTIN'];
          $SupGL = $rown['SupGL'];

        }

        if($SupEmail != "") { $SupEmail = "Email: ".  $SupEmail;} if($SupURL != ""){ "URL: ".  $SupURL; }
    }
}

$InvoiceDetails = array();
$InvoiceDetails['OptInvNo'] = $OptInvNo;
$InvoiceDetails['OptOrdNo'] = $OptOrdNo;
$InvoiceDetails['SupAddress'] = $SupAddress; //Email: accounts@pengrg.com
$InvoiceDetails['SupNme'] = $SupNme; //$SupGL
$InvoiceDetails['SupGL'] = $SupGL; //$SupGL
$InvoiceDetails['SupEmail'] = $SupEmail; 
$InvoiceDetails['SupURL'] = $SupURL; 
$InvoiceDetails['SupPhone'] = $SupPhone1; 
$InvoiceDetails['SupRefNo'] = $SupRefNo; 
$InvoiceDetails['TINNOV'] = $TINNo; 



echo json_encode($InvoiceDetails);


?>
