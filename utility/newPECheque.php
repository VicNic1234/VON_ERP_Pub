<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];


$chqNUM = mysql_real_escape_string(trim(strip_tags($_POST['chqNUM'])));
$VenNAMEID = mysql_real_escape_string(trim(strip_tags($_POST['VenNAMEID'])));

if($VenNAMEID == 0 || $chqNUM == "") {}
else 
{   //Check if InvoiceNum Already Exit
     $resultInvoiceNum = mysql_query("SELECT * FROM pecheques WHERE ChequeNo = '$chqNUM' ");
    $NoRowInvONo = mysql_num_rows($resultInvoiceNum); 
    if($NoRowInvONo > 0) { $Msg = "Cheque No. Already Exist"; }
    else {
    //Here have to insert now
    $querym = "INSERT INTO pecheques (venid, ChequeNo, CreatedBy) VALUES ('$VenNAMEID', '$chqNUM', '$Userid');";
               mysql_query($querym);

    $resultInvoiceNum = mysql_query("SELECT * FROM pecheques WHERE venid = '$VenNAMEID' ");
    $NoRowInvONo = mysql_num_rows($resultInvoiceNum);
    if($NoRowInvONo > 0)
    {
        while ($row = mysql_fetch_array($resultInvoiceNum))
        { 
          $OptInvNo .= '<option value="'.$row['ChequeNo'].'">'.$row['ChequeNo'].'</option>';
        }
    }

     $Msg = "Cheque Number Registered";
    }
}

////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////

$InvoiceDetails = array();
$InvoiceDetails['OptCheqNo'] = $OptInvNo;
$InvoiceDetails['Msg'] = $Msg;




echo json_encode($InvoiceDetails);


?>
