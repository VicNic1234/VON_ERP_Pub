<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];


//$CusNAMEID = mysql_real_escape_string(trim(strip_tags($_POST['POLineItem'])));
//print_r($_POST['POLineItem']);
//exit;
$ItemNamesArray = $_POST['invno']; $BankGL = $_GET['bnkgl']; $BankAMT = $_GET['bnkamt'];
$BankChq = $_GET['bnkchq']; $BankTDate = $_GET['bnktdate']; $BankID = $_GET['bnkid']; $INVNO = $_GET['invno'];  
//$PEPONUM = $_POST['PEPONUM'];
//$CMSArray = $_POST['CMK'];
$LitID = "";

//Let's get the Other

//Clear all invoice Items
  //$queryINVITEM = "DELETE FROM purchaseinvoiceitems WHERE inovid = '$InvoiceID'";
  //mysql_query($queryINVITEM);
$SN = 0; $BNKINvoice = "";
$INVOn = count($ItemNamesArray);

 foreach ($ItemNamesArray as $value) {
  $SN = $SN + 1;
    $InvoiceNum = $value['InvoiceNum'];
    
    if($InvoiceNum != "" && $InvoiceNum != null ) 
    {
      $InvoiceNum = $value['InvoiceNum'];
      $BNKINvoice .= $InvoiceNum .", ";
      $ScrDAmt = $value['ScrDAmt'];
      $TPGLAcct = $value['TPGLAcct'];
      $TPAmt = $value['TPAmt'];
      $DeGLAcctF = $value['DeGLAcct'];

      //GET REAL GL ID NOW
      $resultREALGL = mysql_query("SELECT * FROM acc_settings WHERE id = '$DeGLAcctF'");
        $NoRowGLIDNo = mysql_num_rows($resultREALGL);
        if($NoRowGLIDNo > 0)
        {
            while ($rowGLD = mysql_fetch_array($resultREALGL))
            { 
              $DeGLAcct = $rowGLD['valueID'];
            }
        }


      ///////////////////////////////////////////////////// 



      $DeAmt = $value['DeAmt'];
      $PostRemark = $value['PostRemark'];
   

      if($InvoiceNum != "") 
      {

        //Get Invoice Attributes
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
        }

      
      } 


                if( $Status == 2 )
        {
        /////////////////// POST TO TRADE PAYABLE GL ///////////////////////////////
         $queryIN1 = "INSERT INTO gl_entries (GLID, Nature, mthNature, Amount, Description, SystemDescr, InvoiceID, CusONo, VenID, DivisionID, CreatedBy) 
                   VALUES ('$TPGLAcct','Debit', 'Decrease', '$TPAmt', '$PostRemark', 'Vendor (Bank Payment)','$InvoiceNum', '$CusONo', '$venid', '', '$Userid');";
        mysql_query($queryIN1);

        /////////////////// POST TO DEDUCTION ///////////////////////////////
        $queryIN2 = "INSERT INTO gl_entries (GLID, Nature, mthNature, Amount, Description, SystemDescr, InvoiceID, CusONo, VenID, DivisionID, CreatedBy) 
                   VALUES ('$DeGLAcct','Credit', 'Increase', '$DeAmt', '$PostRemark', 'Vendor (Bank Payment)','$InvoiceNum', '$CusONo', '$venid', '', '$Userid');";
        mysql_query($queryIN2);

      
          ////////////////////////////////////////

      }
      else
        { 
          echo $Msg = "Can not be Posted!, Transaction have been posted before now!";
          exit; }

    }
  }

  //FOR SINGLE TRANSACTION
  if($INVOn == 0)
  {
    $BNKINvoice = $InvoiceNum = $INVNO; 
    $PostRemark = "Trade Payble Deducted";
     //Get Invoice Attributes
        $resultInvoiceNum = mysql_query("SELECT * FROM purchaseinvoice WHERE InvoiceNo = '$INVNO'");
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
        }

                 if( $Status == 2 )
        {
        /////////////////// POST TO TRADE PAYABLE GL ///////////////////////////////
         $queryIN1 = "INSERT INTO gl_entries (GLID, Nature, mthNature, Amount, Description, SystemDescr, InvoiceID, CusONo, VenID, DivisionID, CreatedBy) 
                   VALUES ('516','Debit', 'Decrease', '$BankAMT', '$PostRemark', 'Vendor (Bank Payment)','$INVNO', '$CusONo', '$venid', '', '$Userid');";
        mysql_query($queryIN1);

        /////////////////// POST TO DEDUCTION ///////////////////////////////
       /* $queryIN2 = "INSERT INTO gl_entries (GLID, Nature, mthNature, Amount, Description, SystemDescr, InvoiceID, CusONo, VenID, DivisionID, CreatedBy) 
                   VALUES ('$DeGLAcct','Credit', 'Increase', '$DeAmt', '$PostRemark', 'Vendor (Bank Payment)','$InvoiceNum', '$CusONo', '$venid', '', '$Userid');";
        mysql_query($queryIN2);
        */

      
          ////////////////////////////////////////

      }
      else
        { 
          echo $Msg = "Can not be Posted!, Transaction have been posted before nffow!".$INVNO;
          exit; }
  }
  

    $AuditLog .= "User:$Userid Posted Bank Payment For Invoice:$InvoiceNum at:$DateG <br/>";
             $querym = "UPDATE purchaseinvoice SET Status='3', AuditLog='$AuditLog' WHERE InvoiceNo = '$InvoiceNum'";
             mysql_query($querym);

  /////////////////// POST TO DEDUCTION BANK ///////////////////////////////
     $queryIN3 = "INSERT INTO gl_entries (GLID, BANKID, Nature, mthNature, Amount, Description, SystemDescr, InvoiceID, CusONo, VenID, DivisionID, CreatedBy) 
                   VALUES ('$BankGL', '$BankID', 'Credit', 'Decrease', '$BankAMT', 'PE Bank Acct Deducted', 'Vendor (Bank Payment)','$BNKINvoice', '$CusONo', '$venid', '', '$Userid');";
      


  if(mysql_query($queryIN3))
        {

          $NewTranscID = mysql_insert_id();

          /////////////////// UPDATE BANK PAYMENT TABLE ///////////////////////////////
         $queryIN4 = "INSERT INTO bankpayment (TrancID, TransAmt, TransDate, InvoiceNo, ChequeNo, VendorCode, CreatedBy) 
         VALUES ('$NewTranscID','$BankAMT', '$BankTDate', '$BNKINvoice', '$BankChq', '$venid', '$Userid');";
     
          mysql_query($queryIN4);


          echo $Msg = "Posted!"; exit; }
         else { echo $Msg = "Oops! An Error Occured"; exit; }




?>
