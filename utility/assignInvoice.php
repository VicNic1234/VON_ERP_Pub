<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];


$CusNAMEID = mysql_real_escape_string(trim(strip_tags($_POST['CusNAMEID']))); 
$CusAddress = mysql_real_escape_string(trim(strip_tags($_POST['CusAddress']))); 
$CusOrderNo = mysql_real_escape_string(trim(strip_tags($_POST['CusOrderNo']))); 
$InvoiceNum = mysql_real_escape_string(trim(strip_tags($_POST['InvoiceNum'])));
$nVendorCode = mysql_real_escape_string(trim(strip_tags($_POST['nVendorCode'])));
$CurrencyN = mysql_real_escape_string(trim(strip_tags($_POST['CurrencyN'])));
$InvDate = mysql_real_escape_string(trim(strip_tags($_POST['InvDate'])));
$TermDay = mysql_real_escape_string(trim(strip_tags($_POST['TermDay'])));
//$CurrencyN = mysql_real_escape_string(trim(strip_tags($_POST['CurrencyN'])));
$NGNCRate = mysql_real_escape_string(trim(strip_tags($_POST['NGNCRate'])));


//if(!$CusNAMEID || !$CusOrderNo) { $Msg = "Kindly select the Customer and Order No.";}
//else 
{ 
    //here We would Update Customer's details
    $queryCUS = "UPDATE customers SET VendorCode='$nVendorCode', InvoiceAdd='$CusAddress' 
             WHERE cusid = '$CusNAMEID'";
             mysql_query($queryCUS);
    //Check if the invoice is already assgined
    $resultInvoiceNum = mysql_query("SELECT * FROM salesinvoice WHERE InvoiceNo = '$InvoiceNum'");
    $NoRowInvONo = mysql_num_rows($resultInvoiceNum);
    if($NoRowInvONo > 0)
    {
        while ($row = mysql_fetch_array($resultInvoiceNum))
        { 
          $OrderNom = $row['OrderNo'];
          $AuditLog = $row['AuditLog'];
          /////////////////////////////////////////////////////
         $NInvoiceNum = mysql_query("SELECT * FROM so WHERE poID = '$OrderNom'");
        $NNoRowInvONo = mysql_num_rows($NInvoiceNum);
        if($NNoRowInvONo > 0)
        {
            while ($row = mysql_fetch_array($NInvoiceNum))
            { 
              $NOrderNom = $row['CusONo'];
              $SONum = $row['SONum'];
            }
        }
        ///////////////////////////////////////////////////////
        }

        

        if($OrderNom == "" || $OrderNom == null || $OrderNom == $CusOrderNo)
        {
            //Here have to insert now
            //Set AuditLog
             $AuditLog .= " User:$Userid Assigned Invoice:$InvoiceNum to  $CusOrderNo at:$DateG <br/>";
             $querym = "UPDATE salesinvoice SET TermDay='$TermDay', InvoDate='$InvDate', SONum='$SONum', CusONo='$NOrderNom', OrderNo='$CusOrderNo', NGNCRate='$NGNCRate', AuditLog='$AuditLog', VendorCode='$nVendorCode', Currency='$CurrencyN' 
             WHERE InvoiceNo = '$InvoiceNum'";
             mysql_query($querym);
            //$Msg = $InvoiceNum;
            $Msg = "Invoice Number Assigned Successfully!";
        }
        else
        {
            $Msg = "Invoice Number can not be Assigned, Already in use in ORDER NUM : ".$NOrderNom;
        }
    }
    else
    {
        $Msg = "Invoice Number Does not exist";
    }


//////////////////////////////////////////////////////////


    

}

////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////

//$InvoiceDetails = array();
//$InvoiceDetails['Msg'] = $Msg;




echo $Msg;//json_encode($InvoiceDetails);


?>
