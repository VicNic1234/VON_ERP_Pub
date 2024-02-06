<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];


$VenID = mysql_real_escape_string(trim(strip_tags($_POST['VenID']))); 
$PEPO = mysql_real_escape_string(trim(strip_tags($_POST['PEPO']))); 
$InvoiceNum = mysql_real_escape_string(trim(strip_tags($_POST['InvoiceNum'])));
$nVendorCode = mysql_real_escape_string(trim(strip_tags($_POST['VendorCode'])));
$CurrencyN = mysql_real_escape_string(trim(strip_tags($_POST['CurrencyN'])));
$TINNoNum = mysql_real_escape_string(trim(strip_tags($_POST['TINNoNum'])));
$PESONumV = mysql_real_escape_string(trim(strip_tags($_POST['PESONumV']))); 
$CusOrderV = mysql_real_escape_string(trim(strip_tags($_POST['CusOrderV']))); 
$VenNAME = mysql_real_escape_string(trim(strip_tags($_POST['VenNAME'])));
$InvDateV = mysql_real_escape_string(trim(strip_tags($_POST['InvDateV'])));
$TermsD = mysql_real_escape_string(trim(strip_tags($_POST['TermsD'])));
//$NGNCRate = mysql_real_escape_string(trim(strip_tags($_POST['NGNCRate'])));


//if(!$CusNAMEID || !$CusOrderNo) { $Msg = "Kindly select the Customer and Order No.";}
//else 
{ 
    //here We would Update Customer's details
    $queryVen = "UPDATE suppliers SET SupRefNo='$VendorCode', SupTIN='$TINNoNum' 
             WHERE supid = '$VenID'";
             mysql_query($queryVen);
    //Check if the invoice is already assgined
    $resultInvoiceNum = mysql_query("SELECT * FROM purchaseinvoice WHERE InvoiceNo = '$InvoiceNum'");
    $NoRowInvONo = mysql_num_rows($resultInvoiceNum);
    if($NoRowInvONo > 0)
    {
        while ($row = mysql_fetch_array($resultInvoiceNum))
        { 
          $OrderNom = $row['OrderNo'];
          $AuditLog = $row['AuditLog'];
          /////////////////////////////////////////////////////
        /* $NInvoiceNum = mysql_query("SELECT * FROM so WHERE poID = '$OrderNom'");
        $NNoRowInvONo = mysql_num_rows($NInvoiceNum);
        if($NNoRowInvONo > 0)
        {
            while ($row = mysql_fetch_array($NInvoiceNum))
            { 
              $NOrderNom = $row['CusONo'];
              $SONum = $row['SONum'];
            }
        }*/
        ///////////////////////////////////////////////////////
        }

        

        if($OrderNom == "" || $OrderNom == null || $OrderNom == $PEPO)
        {
            //Here have to insert now
            //Set AuditLog
             $AuditLog .= "User:$Userid Assigned Invoice:$InvoiceNum to  $PEPO at:$DateG <br/>";
             $querym = "UPDATE purchaseinvoice SET so='$PESONumV', CusONo='$CusOrderV', OrderNo='$PEPO', TermDay='$TermsD', 
             VendorCode='$nVendorCode', Currency='$CurrencyN', AuditLog='$AuditLog', InvDate='$InvDateV'
             WHERE InvoiceNo = '$InvoiceNum'";
             mysql_query($querym);
            //$Msg = $InvoiceNum;
            $Msg = "Invoice Number Assigned Successfully!";
        }
        else
        {
            $Msg = "Invoice Number can not be Assigned, Already in use";
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
