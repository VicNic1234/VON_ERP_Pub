<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];


$invnNUM = mysql_real_escape_string(trim(strip_tags($_POST['invnNUM'])));
$CusNAMEID = mysql_real_escape_string(trim(strip_tags($_POST['CusNAMEID'])));

if($CusNAMEID == 0 || $invnNUM == "") {}
else 
{   //Check if InvoiceNum Already Exit
     $resultInvoiceNum = mysql_query("SELECT * FROM salesinvoice WHERE InvoiceNo = '$invnNUM' ");
    $NoRowInvONo = mysql_num_rows($resultInvoiceNum); 
    if($NoRowInvONo > 0) { $Msg = "Invoice Number Already Exit"; }
    else {
    //Here have to insert now
    $querym = "INSERT INTO salesinvoice (cusid, InvoiceNo, CreatedBy) VALUES ('$CusNAMEID', '$invnNUM', '$Userid');";
               mysql_query($querym);

    $resultInvoiceNum = mysql_query("SELECT * FROM salesinvoice WHERE cusid = '$CusNAMEID' ");
    $NoRowInvONo = mysql_num_rows($resultInvoiceNum);
    if($NoRowInvONo > 0)
    {
        while ($row = mysql_fetch_array($resultInvoiceNum))
        { 
          $OptInvNo .= '<option value="'.$row['InvoiceNo'].'">'.$row['InvoiceNo'].'</option>';
        }
    }

     $Msg = "Invoice Number Created";
    }
}

////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////

$InvoiceDetails = array();
$InvoiceDetails['OptInvNo'] = $OptInvNo;
$InvoiceDetails['Msg'] = $Msg;




echo json_encode($InvoiceDetails);


?>
