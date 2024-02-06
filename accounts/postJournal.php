<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];

$REQCODE = mysql_real_escape_string(trim(strip_tags($_POST['REQCODE'])));
$BANKGL = mysql_real_escape_string(trim(strip_tags($_POST['BANKGL'])));
$ChqNo = mysql_real_escape_string(trim(strip_tags($_POST['ChqNo'])));
$RECEIVER = mysql_real_escape_string(trim(strip_tags($_POST['RECEIVER'])));
$CusID = mysql_real_escape_string(trim(strip_tags($_POST['CusID'])));
$CusInv = mysql_real_escape_string(trim(strip_tags($_POST['CusInv'])));
$trandate = mysql_real_escape_string(trim(strip_tags($_POST['transactiondate'])));
//$remark = mysql_real_escape_string(trim(strip_tags($_POST['remark'])));
 $payerDECV = mysql_real_escape_string(trim(strip_tags($_POST['payerDECV']))); 
// = mysql_real_escape_string(trim(strip_tags($_POST['receiveDECV']))); 
$NGNTCURR = mysql_real_escape_string(trim(strip_tags($_POST['NGNTCURR'])));
$OLDTAMT = $TAMT= mysql_real_escape_string(trim(strip_tags($_POST['TAMT']))); 
$TCurr = mysql_real_escape_string(trim(strip_tags($_POST['TCurr']))); 
$BusUnit = mysql_real_escape_string(trim(strip_tags($_POST['BusUnit']))); 
if($TCurr != "NGN") { $TAMT = floatval($NGNTCURR) * floatval($OLDTAMT);  }
$DrDesc = $_POST['DrDesc'];

$CrDesc = $_POST['CrDesc'];
$TRANCODE = date("Ymdhis")."JN";

$TodayD = date("Y-m-d h:i:s a");

if(count($DrDesc) < 1) 
  {
    $_SESSION['ErrMsg'] = "No GL account added to be credited.";
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit;
  }
  else
  {

    //Lets get BANK GL Code
        $resultGLBnk = mysql_query("SELECT * FROM bankaccount INNER JOIN acc_chart_master ON bankaccount.GLAcct =  acc_chart_master.mid WHERE bankaccount.baccid = '$BANKGL'");
            //check if user exist
             $NoRowBnkSet = mysql_num_rows($resultGLBnk);
            if ($NoRowBnkSet > 0) 
              {
                while ($row = mysql_fetch_array($resultGLBnk)) 
                {
                  $acctid = $row['baccid'];
                  $acctbnkDesp = $row['description'];
                  $CRDGLIDacctid = $row['mid'];
                }
            }
    ////////////////////////////// CREDIT ///////////////////////////
    $query = "INSERT INTO postings (REQCODE, BankAccount, ChqNo, ReceivedBy, GLImpacted, GLDescription, TransactionAmount, PostedAmount, 
         TransacType, TransactionDate, Remark, PostedBy, PostedOn, RptType, CRCenter, CounterTrans, Currency, NGNTCURR, CusID, ENLINVOICE) VALUES ('','$BANKGL','$ChqNo','$RECEIVER','$CRDGLIDacctid','$payerDECV','$TAMT','$OLDTAMT', 'DEBIT', '$trandate', 'Bank to be Debited', '$uid', '$TodayD', 'Jonrnal', '$BusUnit', '0', '$TCurr', '$NGNTCURR', '$CusID', '$CusInv' );";

    mysql_query($query);
   
    $LastTranID1 = $TRANCODE; ///mysql_insert_id();
    //////////////////////////////////////////////////////////
    $N = count($DrDesc);
      for($i=0; $i < $N; $i++)
    {
      
      $RawITD = explode("@&@",$DrDesc[$i]);
      $GLDes = $RawITD[0];
      $GLID = $RawITD[1];
      $OLDGLAmt = $GLAmt = $RawITD[2];
      if($TCurr != "NGN") { $GLAmt = floatval($NGNTCURR) * floatval($OLDGLAmt);  }
      $BusUnit = $RawITD[3];
      $EquipC = $RawITD[4];
      $CHSItemDesc = $RawITD[5];
      $CHSItemQty = $RawITD[6];
      $CHRNum = $RawITD[7];
      $CHSItem = $RawITD[8];
      $POSTType = $RawITD[9];
      $VENID = $RawITD[10];
      $ItemType = $RawITD[11];
      $mJob = $RawITD[12];

      if($POSTType == "VENDINV")
      {
        ///////////////READ INVOICE NUM
        $inv_res=mysql_query("select * from enlinvoices WHERE cid = '$CHRNum'");
        while($row=mysql_fetch_array($inv_res))
        {
        
          $INVNUM = $row['IVNo'];
          $CusSource = $row['CusSource'];
        }

        ////////////////////////////////////

        $query1 = "INSERT INTO postings (ENLINVOICE, REQCODE, CHRID, ItemQty, BankAccount, ChqNo, ReceivedBy, GLImpacted, GLDescription, TransactionAmount, PostedAmount,
         TransacType, TransactionDate, Remark, PostedBy, PostedOn, RptType, Currency, CRCenter, CounterTrans, CusID, NGNTCURR, mItem, mJob) VALUES ('$CHRNum','$INVNUM', '$CHSItem', '$CHSItemQty', '$BANKGL','$ChqNo','$RECEIVER','$GLID','$GLDes','$GLAmt', '$OLDGLAmt', 'CREDIT', '$trandate', '$CHSItemDesc', '$uid', '$TodayD', 'Jonrnal', '$TCurr', '$BusUnit',  '$LastTranID1', '$CusSource', '$NGNTCURR', '$ItemType', '$mJob');";

         mysql_query($query1);

         $LastTranID2 = mysql_insert_id();
        if($ItemType == 1){
        mysql_query("UPDATE enlivmiscellaneous SET PostedOn='".$TodayD."', PostID='".$LastTranID2."' WHERE poitid = '$CHSItem'");
        }
        else
        {
            mysql_query("UPDATE enlivitems SET PostedOn='".$TodayD."', PostID='".$LastTranID2."' WHERE poitid = '$CHSItem'");
        }
      }
      else
      {
        $query1 = "INSERT INTO postings (ENLINVOICE, REQCODE, CHRID, ItemQty, BankAccount, ChqNo, ReceivedBy, GLImpacted, GLDescription, TransactionAmount, PostedAmount,
         TransacType, TransactionDate, Remark, PostedBy, PostedOn, RptType, Currency, CRCenter, CounterTrans, NGNTCURR, mItem, mJob) VALUES ('$CHRNum', '$CHRNum', '$CHSItem', '$CHSItemQty', '$BANKGL','$ChqNo','$RECEIVER','$GLID','$GLDes','$GLAmt', '$OLDGLAmt', 'CREDIT', '$trandate', '$CHSItemDesc', '$uid', '$TodayD', 'Jonrnal', '$TCurr', '$BusUnit',  '$LastTranID1', '$NGNTCURR', '$ItemType', '$mJob');";

         mysql_query($query1);

         $LastTranID2 = mysql_insert_id();

       // mysql_query("UPDATE cashreq SET Approved='17', LastActor='Account Officer', Status='Cash Paid Out', PostedBy='".$uid."', ApprovedBy='".$staffname."', PostedOn='".$TodayD."', PostID='".$LastTranID2."' WHERE reqid = '$CHSItem'");

      }
        
    }
    
    
    
        if(count($CrDesc) > 0) 
          {
             $N = count($CrDesc);
              for($i=0; $i < $N; $i++)
            {
              
              $RawITD = explode("@&@",$CrDesc[$i]);
              $GLDes = $RawITD[0];
              $GLID = $RawITD[1];
              $OLDGLAmt = $GLAmt = $RawITD[2];
              if($TCurr != "NGN") { $GLAmt = floatval($NGNTCURR) * floatval($OLDGLAmt);  }
              $BusUnit = $RawITD[3];
              $EquipC = $RawITD[4];
              $CHSItemDesc = $RawITD[5];
              $CHSItemQty = $RawITD[6];
              $CHRNum = $RawITD[7];
              $CHSItem = $RawITD[8];
              $POSTType = $RawITD[9];
              $VENID = $RawITD[10];
              $ItemType = $RawITD[11];
              $mJob = $RawITD[12];
        
              if($POSTType == "VENDINV")
              {
                ///////////////READ INVOICE NUM
                $inv_res=mysql_query("select * from enlinvoices WHERE cid = '$CHRNum'");
                while($row=mysql_fetch_array($inv_res))
                {
                
                  $INVNUM = $row['IVNo'];
                  $CusSource = $row['CusSource'];
                }
        
                ////////////////////////////////////
        
                $query1 = "INSERT INTO postings (ENLINVOICE, REQCODE, CHRID, ItemQty, BankAccount, ChqNo, ReceivedBy, GLImpacted, GLDescription, TransactionAmount, PostedAmount,
                 TransacType, TransactionDate, Remark, PostedBy, PostedOn, RptType, Currency, CRCenter, CounterTrans, CusID, NGNTCURR, mItem, mJob) VALUES ('$CHRNum','$INVNUM', '$CHSItem', '$CHSItemQty', '$BANKGL','$ChqNo','$RECEIVER','$GLID','$GLDes','$GLAmt', '$OLDGLAmt', 'DEBIT', '$trandate', '$CHSItemDesc', '$uid', '$TodayD', 'Jonrnal', '$TCurr', '$BusUnit',  '$LastTranID1', '$CusSource', '$NGNTCURR', '$ItemType', '$mJob');";
        
                 mysql_query($query1);
        
                 $LastTranID2 = mysql_insert_id();
        
               
                if($ItemType == 1){
                    mysql_query("UPDATE enlivmiscellaneous SET PostedOn='".$TodayD."', PostID='".$LastTranID2."' WHERE poitid = '$CHSItem'");
                    }
                    else
                    {
                        mysql_query("UPDATE enlivitems SET PostedOn='".$TodayD."', PostID='".$LastTranID2."' WHERE poitid = '$CHSItem'");
                    }
                
              }
              else
              {
                $query1 = "INSERT INTO postings (ENLINVOICE, REQCODE, CHRID, ItemQty, BankAccount, ChqNo, ReceivedBy, GLImpacted, GLDescription, TransactionAmount, PostedAmount,
                 TransacType, TransactionDate, Remark, PostedBy, PostedOn, RptType, Currency, CRCenter, CounterTrans, NGNTCURR, mItem, mJob) VALUES ('$CHRNum','$CHRNum', '$CHSItem', '$CHSItemQty', '$BANKGL','$ChqNo','$RECEIVER','$GLID','$GLDes','$GLAmt','$OLDGLAmt', 'DEBIT', '$trandate', '$CHSItemDesc', '$uid', '$TodayD', 'Jonrnal', '$TCurr', '$BusUnit',  '$LastTranID1', '$NGNTCURR', '$ItemType', '$mJob');";
        
                 mysql_query($query1);
        
                 $LastTranID2 = mysql_insert_id();
        
                //mysql_query("UPDATE cashreq SET Approved='17', LastActor='Account Officer', Status='Cash Paid Out', PostedBy='".$uid."', ApprovedBy='".$staffname."', PostedOn='".$TodayD."', PostID='".$LastTranID2."' WHERE reqid = '$CHSItem'");
        
              }
                
            }
          }

   
  }




//Lets get Requester Info
/*
$sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$REQCODE'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $staffID = $rowPOREQ['staffID'];
     }
*/


////////////////////////////////////////
/*
$sql_res=mysql_query("SELECT * FROM users WHERE uid='$staffID'");

$isHOD = mysql_num_rows($sql_res);

while ($row = mysql_fetch_array($sql_res)) {
       $REQFullname = $row['Firstname'] . " " . $row['Surname'];
       $REQEmail = $row['Email'];
     }
*/   


         



   /*mysql_query("UPDATE cashreq SET Approved='17', LastActor='Account Officer', Status='Cash Paid Out', PostedBy='".$uid."', ApprovedBy='".$staffname."', PostedOn='".$TodayD."', PostID='".$LastTranID1."' WHERE reqid = '$REQCODE'");*/

//now we have to inform the HOD
 // require_approval_action_notification ($REQEmail, $REQFullname, $REQCODE, "Requester", "Cash Released by Acounts"); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Cash Released]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view request on Elshcon ERP which was actedon by Acounts Office to you as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashrequestform?sReqID='.$pdfid;
		$Favicon = "https://www.elshcon.space/mBOOT/plant.png";
        
       
        $msg = '<!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="'.$Favicon.'">

        </head>
        <body style="margin:0px; font-family:Sans-serif, sans-serif; background:#D6D6D6;">
        <div style="padding:15px; background:#000033; font-size: 2em; color:#FFF; border-radius:7px;">
        <center>
        
        <center style="display:inline; font-weight:800;"> <img src="'.$Favicon.'" /> </center>
        </center>
        </div>
        <div style="padding:24px; margin:12px; margin-bottom:12px; font-size:15px; color:#8F8F8F; background:#E8E8E8; border-radius:7px;">
        Dear '.$fullnme.',<br /><br/> '.$msgBody.'<br/><br /> 
        <center>
        <a href="'.$msgLink.'" style="padding:12px; font-weight:600; text-decoration:none; background:#EC7600; color:#000033; border-radius:12px; cursor:pointer;">
        View Request </a>
        </center> 
        <br /> or copy and paste the link below in your browser <br />  '.$msgLink.' <br />
        <br /><br />Best Regards,<br />
        Support Team<br /> 
        Elshcon ERP<br /> 
        <br />
       

        </div> 
        <div style="padding:13px; background:#333333; font-size:11px; color:#F8F8F8; border-radius:7px;">
        <center style="font-size:11px;">
         &copy; 2018 Elshcon Nigeria Limited, the Elshcon logo, and Elshcon ERP 
        </center>  
         <center style="font-size:11px;">
         are registered trademarks of Elshcon Nigeria Limited 
        </center>  
         <center style="font-size:11px;">
         in Nigeria and/or other countries. All rights reserved. 
        </center>  
        </div>
        </body>
        </html>';

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Posted. Thanks";
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
mysql_close($dbhandle);
exit;









?>