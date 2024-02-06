<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];


//$VenID = mysql_real_escape_string(trim(strip_tags($_POST['VenID']))); 
$InvoiceNum = mysql_real_escape_string(trim(strip_tags($_POST['InvNo'])));
$ExRateNGN = mysql_real_escape_string(trim(strip_tags($_POST['ExchangeRate'])));
$GLTPayable = mysql_real_escape_string(trim(strip_tags($_POST['GLTPayable'])));
$GLDebit = mysql_real_escape_string(trim(strip_tags($_POST['GLDebit']))); 
$GLVadd = mysql_real_escape_string(trim(strip_tags($_POST['GLVadd']))); 
$Descrp = mysql_real_escape_string(trim(strip_tags($_POST['Descrp'])));  
$InDivision = mysql_real_escape_string(trim(strip_tags($_POST['InDivision'])));  
$vadddrAccVal = mysql_real_escape_string(trim(strip_tags($_POST['vadddrAccVal'])));  
$drAccVal = mysql_real_escape_string(trim(strip_tags($_POST['drAccVal'])));  
$trAccVal = mysql_real_escape_string(trim(strip_tags($_POST['trAccVal'])));  
//$NGNCRate = mysql_real_escape_string(trim(strip_tags($_POST['NGNCRate'])));


//if(!$InvoiceNum || !$InvoiceNum) { $Msg = "Kindly select the Customer and Order No.";}
//else 
{ 
    //here We would Read Vendor's Invoice Info details
  
    $resultInvoiceNum = mysql_query("SELECT * FROM purchaseinvoice WHERE InvoiceNo = '$InvoiceNum'");
    $NoRowInvONo = mysql_num_rows($resultInvoiceNum);
    if($NoRowInvONo > 0)
    {
        while ($row = mysql_fetch_array($resultInvoiceNum))
        { 
          $so = $row['so'];
          $CusONo = $row['CusONo'];
          $venid = $row['venid'];
          $OrderNo = $row['OrderNo'];
          $InvDate = $row['InvDate'];
          $Currency = $row['Currency'];
          $NGNCRate = $row['NGNCRate'];
          $AuditLog = $row['AuditLog'];
          $Status = $row['Status'];
          $isActive = $row['isActive'];
      
        ///////////////////////////////////////////////////////
        }

        

        if($venid != "" && $venid != null && $isActive == 1 && $Status == 1) //
        {
           
          /////////////////// POST TO TRADE PAYABLE GL ///////////////////////////////
          $queryIN1 = "INSERT INTO gl_entries (GLID, Nature, mthNature, Amount, Description, SystemDescr, InvoiceID, CusONo, VenID, DivisionID, CreatedBy) 
                   VALUES ('$GLTPayable','Credit', 'Increase', '$trAccVal', '$Descrp', 'Payables Inovice','$InvoiceNum', '$CusONo', '$venid', '$InDivision', '$Userid');";
        mysql_query($queryIN1);
        /////////////////// POST TO INVENTORY OR DEBIT GL ///////////////////////////////
        $queryIN2 = "INSERT INTO gl_entries (GLID, Nature, mthNature, Amount, Description, SystemDescr, InvoiceID, CusONo, VenID, DivisionID, CreatedBy) 
                   VALUES ('$GLDebit','Debit', 'Increase', '$drAccVal', '$Descrp', 'Payables Inovice','$InvoiceNum', '$CusONo', '$venid', '$InDivision', '$Userid');";
        mysql_query($queryIN2);
        /////////////////// POST TO VALUE ADDED GL ///////////////////////////////
        $queryIN3 = "INSERT INTO gl_entries (GLID, Nature, mthNature, Amount, Description, SystemDescr, InvoiceID, CusONo, VenID, DivisionID, CreatedBy) 
                   VALUES ('$GLVadd','Debit', 'Increase', '$vadddrAccVal', '$Descrp', 'Payables Inovice','$InvoiceNum', '$CusONo', '$venid', '$InDivision', '$Userid');";
        
         if(mysql_query($queryIN3)) { 

          $AuditLog .= "User:$Userid Posted Trade Payable For Invoice:$InvoiceNum at:$DateG <br/>";
             $querym = "UPDATE purchaseinvoice SET Status='2', NGNCRate='$ExRateNGN', AuditLog='$AuditLog' WHERE InvoiceNo = '$InvoiceNum'";
             mysql_query($querym);

          echo $Msg = "Posted!"; exit; }
         else { echo $Msg = "Oops! An Error Occured"; exit; }
          ////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else
        {
           echo $Msg = "Can not be Posted!, Transaction have been posted before now!";
            exit;
        }
    }
    else
    {
        echo $Msg = "Invoice Number Does not exist";
        exit;
    }


//////////////////////////////////////////////////////////


    

}

////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////

//$InvoiceDetails = array();
//$InvoiceDetails['Msg'] = $Msg;




echo $Msg;//json_encode($InvoiceDetails);


?>
