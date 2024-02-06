<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];

$InvNoTab = "";
$InvoiceID = mysql_real_escape_string(trim(strip_tags($_POST['InvoiceID'])));
//$InvDateV = mysql_real_escape_string(trim(strip_tags($_POST['InvDateV'])));


if($InvoiceID == 0 || $InvoiceID == "") { exit; }
else 
{
   // $OptInvNo .= '<option value="0">New InvoiceNo.</option>';
  //////////Let's first get the GL Value now
          $GLAmt = 0.0;
           
             


  ////////////////////////////////////////////////////////////////
    $resultInvoiceNum = mysql_query("SELECT * FROM purchaseinvoice WHERE InvoiceNo = '$InvoiceID' AND Status=2 ");
    $NoRowInvONo = mysql_num_rows($resultInvoiceNum);
    if($NoRowInvONo > 0)
    {
        while ($row = mysql_fetch_array($resultInvoiceNum))
        { 
          
          //////////////////////////////////////////////////////
          $InvAmtQ = mysql_query("SELECT * FROM gl_entries WHERE InvoiceID = '$InvoiceID' AND Nature='Credit' AND SystemDescr='Payables Inovice'");
             $NoRowInvAmtQ = mysql_num_rows($InvAmtQ);

             if($NoRowInvAmtQ > 0)
             {
               while ($rowgl = mysql_fetch_array($InvAmtQ)) {  $GLAmt = (float)str_replace(',', '', $rowgl['Amount']); }
             }
          ///////////////////////////////////////////////////////////
              $ChkApply = '<input type="checkbox" id="'.$row['siid'].'" invid="'.$row['InvoiceID'].'" name="invno['.$row['siid'].']" />';
              $InvNoTab .= '<tr><td>'.$InvoiceID.'</td><td>'.$row['InvDate'].'</td>
              <td>'.$row['CusONo'].'</td><td>'.$row['OrderNo'].'</td><td>'.$row['NGNCRate'].'</td>
              <td>'.number_format($GLAmt, 2).'</td><td>'.$ChkApply.'</td></tr>';
          
        }
    }

    /*$resultOrderNum = mysql_query("SELECT * FROM po WHERE Supplierid = '$VenID' ");
    $NoRowOrdNo = mysql_num_rows($resultOrderNum);
    if($NoRowOrdNo > 0)
    {
        while ($row = mysql_fetch_array($resultOrderNum))
        { 
          $OptOrdNo .= '<option value="'.$row['PONum'].'">'.$row['PONum'].'</option>';
        }
    }
    */

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
$InvoiceDetails['InvNoTab'] = $InvNoTab;
$InvoiceDetails['GLAmt'] = $GLAmt;
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
