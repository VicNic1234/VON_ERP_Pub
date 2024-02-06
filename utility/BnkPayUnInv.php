<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];

$InvNoTab = "";
$CheqNo = "";
$VenID = mysql_real_escape_string(trim(strip_tags($_POST['VenID'])));
$TTPayable = 0.0;

if($VenID == 0 || $VenID == "") { exit; }
else 
{
   
    $resultInvoiceNum = mysql_query("SELECT * FROM purchaseinvoice WHERE venid = '$VenID' AND Status=2 ");
    $NoRowInvONo = mysql_num_rows($resultInvoiceNum);
    if($NoRowInvONo > 0)
    {
        while ($row = mysql_fetch_array($resultInvoiceNum))
        { 
           $OptInvNo .= '<option value='.$row['InvoiceNo'].'>'.$row['InvoiceNo'].'</option>';
           $InvoiceID = $row['InvoiceNo'];
           $Currency = $row['Currency'];
            //////////////////////////////////////////////////////
          $InvAmtQ = mysql_query("SELECT * FROM gl_entries WHERE InvoiceID = '$InvoiceID' /*AND Nature='Credit' */ AND SystemDescr='Payables Inovice'");
             $NoRowInvAmtQ = mysql_num_rows($InvAmtQ);
             $CheckPoint = 0;
             if($NoRowInvAmtQ > 0)
             {
                 while ($rowgl = mysql_fetch_array($InvAmtQ)) 
                 {  
                    if($CheckPoint == 0 ) { $GLAmt = (float)str_replace(',', '', $rowgl['Amount']); }
                    if($CheckPoint == 1 ) { $SubGLT = (float)str_replace(',', '', $rowgl['Amount']); }
                    $CheckPoint = $CheckPoint + 1;
                 }
             }
          ///////////////////////////////////////////////////////////
             ///GET SOURCE RATE
             $PostRate = $row['NGNCRate'];
             $SourceVaue = number_format($GLAmt/$PostRate, 2);

            ///////////////////////////////////////////////////////////

              $ChkApply = '<input title="Conversion Rate @ '.$PostRate.', Amt Excl VAT : '.number_format($SubGLT, 2).'" type="checkbox" checked class="applychk" id="'.$row['siid'].'" name="invno['.$row['siid'].']" invid="'.$row['InvoiceNo'].'" value="'.$InvoiceID.'" amt="'.$SubGLT.'" cnsr="'.$PostRate.'" tamt="'.$GLAmt.'" sttamt="'.$GLAmt.'" />';
              $InvNoTab .= '<tr>
              <td>'.$InvoiceID.'</td>
              <td>'.$row['InvDate'].'</td>
              <td>'.$row['CusONo'].'</td>
              <td>'.$row['OrderNo'].'</td>
              <td>'.$Currency.' <span id="sv'.$row['siid'].'">'.$SourceVaue.'</span></td>
              <td>NGN <span id="bv'.$row['siid'].'">'.number_format($GLAmt, 2).'</span></td>
              <td>'.$ChkApply.'</td></tr>';

              $TTPayable = $TTPayable + $GLAmt;
            
        }
    }

    $resultCheqNum = mysql_query("SELECT * FROM pecheques WHERE venid = '$VenID' AND isActive=1 ");
    $NoRowCheqNo = mysql_num_rows($resultCheqNum);
    if($NoRowCheqNo > 0)
    {
        while ($row = mysql_fetch_array($resultCheqNum))
        { 
           $CheqNo .= '<option value='.$row['ChequeNo'].'>'.$row['ChequeNo'].'</option>';
           
        }
    }
   
}

$InvoiceDetails = array();
$InvoiceDetails['OptInvNo'] = $OptInvNo;
$InvoiceDetails['InvNoTab'] = $InvNoTab;
$InvoiceDetails['TotalTradePayable'] = $TTPayable;
$InvoiceDetails['CheqNo'] = $CheqNo;


echo json_encode($InvoiceDetails);


?>
