<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];


//$VenID = mysql_real_escape_string(trim(strip_tags($_POST['VenID']))); 
$InvoiceNum = mysql_real_escape_string(trim(strip_tags($_POST['InvoiceNum'])));
$ExRateNGN = mysql_real_escape_string(trim(strip_tags($_POST['ExchangeRate'])));
$OptGLRevenue = mysql_real_escape_string(trim(strip_tags($_POST['OptGLRevenue'])));
$OptGLTradeRev = mysql_real_escape_string(trim(strip_tags($_POST['OptGLTradeRev'])));
$Descrp = mysql_real_escape_string(trim(strip_tags($_POST['Descrp'])));  
//$InDivision = mysql_real_escape_string(trim(strip_tags($_POST['InDivision'])));  
$OptGLValueAdd = mysql_real_escape_string(trim(strip_tags($_POST['OptGLValueAdd'])));  
$drAccVal = mysql_real_escape_string(trim(strip_tags($_POST['drAccVal'])));  
$trAccVal = mysql_real_escape_string(trim(strip_tags($_POST['trAccVal'])));  
$vadddrAccval = mysql_real_escape_string(trim(strip_tags($_POST['vadddrAccval'])));  
//$NGNCRate = mysql_real_escape_string(trim(strip_tags($_POST['NGNCRate'])));
/*
   var InvoiceNum = $('#invn').val(); 
      var OptGLRevenue = $('#OptGLRevenue').val();
      var OptGLValueAdd = $('#OptGLValueAdd').val();
      var ExchangeRate = $('#ExchangeRate').val();
      var trAcctVal = $('#trAcctVal').val();
      var drAccVal = $('#drAccVal').val();
      var Descrp = $('#Descrp').val();
      var CurrencyN = $('#CurrencyN').val();
      var InvDate = $('#invDate').val();
*/


//if(!$InvoiceNum || !$InvoiceNum) { $Msg = "Kindly select the Customer and Order No.";}
//else 
{ 
    //here We would Read Vendor's Invoice Info details
  
    $resultInvoiceNum = mysql_query("SELECT * FROM salesinvoice WHERE InvoiceNo = '$InvoiceNum'");
    $NoRowInvONo = mysql_num_rows($resultInvoiceNum);
    if($NoRowInvONo > 0)
    {
        while ($row = mysql_fetch_array($resultInvoiceNum))
        { 
          $so = $row['so'];
          $CusONo = $row['CusONo'];
          $cusid = $row['cusid'];
          $OrderNo = $row['OrderNo'];
          $InvDate = $row['InvoDate'];
          $Currency = $row['Currency'];
          $NGNCRate = $row['NGNCRate'];
          $AuditLog = $row['AuditLog'];
          $Status = $row['Status'];
          //$isActive = $row['isActive'];
      
        ///////////////////////////////////////////////////////
        }

        

        if($cusid != "" && $cusid != null && $Status == 1) //
        {
            //Here have to insert now
            //Set AuditLog
             
          /////////////////// POST (Debit)  TO TRADE RECIVABLE GL ///////////////////////////////
          $queryIN1 = "INSERT INTO gl_entries (GLID, Nature, mthNature, Amount, Description, SystemDescr, InvoiceID, CusONo, CusID, CreatedBy) 
                   VALUES ('$OptGLTradeRev','Debit', 'Increase', '$trAccVal', '$Descrp', 'Receivable Inovice','$InvoiceNum', '$CusONo', '$cusid', '$Userid');";
        mysql_query($queryIN1);
        /////////////////// POST (Credit) TO SALES/REVENUE GL ///////////////////////////////
        $queryIN2 = "INSERT INTO gl_entries (GLID, Nature, mthNature, Amount, Description, SystemDescr, InvoiceID, CusONo, CusID, CreatedBy) 
                   VALUES ('$OptGLRevenue','Credit', 'Increase', '$drAccVal', '$Descrp', 'Sales/Revenue Inovice','$InvoiceNum', '$CusONo', '$cusid', '$Userid');";
        mysql_query($queryIN2);
        /////////////////// POST TO VALUE ADDED GL ///////////////////////////////
        $queryIN3 = "INSERT INTO gl_entries (GLID, Nature, mthNature, Amount, Description, SystemDescr, InvoiceID, CusONo, CusID, CreatedBy) 
                   VALUES ('$OptGLValueAdd','Credit', 'Increase', '$vadddrAccval', '$Descrp', 'Receivable Inovice','$InvoiceNum', '$CusONo', '$cusid', '$Userid');";
        
         //if(mysql_query($queryIN3)) { 

          $AuditLog .= "User:$Userid Posted Trade Receivable For Invoice:$InvoiceNum at:$DateG <br/>";
             $querym = "UPDATE salesinvoice SET Status='2', NGNCRate='$ExRateNGN', AuditLog='$AuditLog' WHERE InvoiceNo = '$InvoiceNum'";
             mysql_query($querym);

          echo $Msg = "Posted!"; exit; 
        // else { echo $Msg = "Oops! An Error Occured"; exit; }
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
