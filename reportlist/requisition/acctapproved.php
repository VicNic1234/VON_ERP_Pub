<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];

if($uid < 1) {
     $_SESSION['ErrMsg'] = "Oops!Timed Out. Kindly Logout and Login Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    //header('Location: cashdivppor?pdfid='.$ReqCode);
    exit; 
  }
$ReqCode = mysql_real_escape_string(trim(strip_tags($_GET['cid'])));
//$ActionOfMD = mysql_real_escape_string(trim(strip_tags($_GET['ActionOfMD']))); 
//$Mgs = mysql_real_escape_string(trim(strip_tags($_GET['Mgs'])));
$TodayD = date("Y-m-d h:i:s a");

  function getUserinfo($uid)
     {
        $resultUserInfo = mysql_query("SELECT * FROM users WHERE uid ='$uid'");
        while ($row = mysql_fetch_array($resultUserInfo)) 
        {
             $CCFullname = $row['Firstname'] . " " . $row['Surname'];
             $CCEmail = $row['Email'];
             //$mail->AddCC($CCEmail, $CCFullname);
             $GLOBALS['mail']->AddCC($CCEmail, $CCFullname);
             return $UserNNE = $row['Email'];
        }
     }
//Lets get all Actors email
$sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $Requester = $rowPOREQ['staffID'];

         $SupervisorApp = getUserinfo($row['SupervisorApp']);
        

         $DeptHeadApp = getUserinfo($row['DeptHeadApp']);
        

         $DivHeadApp = getUserinfo($row['DivHeadApp']);
        

         $CPApp = getUserinfo($row['CPApp']);
        

         $MgrApp = getUserinfo($row['MgrApp']);
        

         $CSApp = getUserinfo($row['CSApp']);
        


         $DDOfficerApp = getUserinfo($row['DDOfficerApp']);
         

         $DDApp = getUserinfo($row['DDApp']);
        

         
     }

//Lets get Requester's Info
$sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $Requester = $rowPOREQ['UserApp'];
     }

////////////////////////////////////////
$sql_res=mysql_query("SELECT * FROM users WHERE uid='$Requester'");

while ($row = mysql_fetch_array($sql_res)) {
       $REQFullname = $row['Firstname'] . " " . $row['Surname'];
       $REQEmail = $row['Email'];
       $REQDeptID = $row['DeptID'];
     }
///////////////////////////////////////
$sql_resD=mysql_query("SELECT * FROM users WHERE DeptID='$REQDeptID' Where Supervisor=1 OR HDept=1 OR HDiv=1");
while ($row = mysql_fetch_array($sql_resD)) {
       $CCFullname = $row['Firstname'] . " " . $row['Surname'];
       $CCEmail = trim($row['Email']);
       //$REQDeptID = $row['DeptID'];
       $mail->AddCC($CCEmail, $CCFullname);
     }
///////////////////////////////////////

//Copy C&S DivHead and Finance DivHead
///////////////////////////////////////
$sql_resF=mysql_query("SELECT * FROM users WHERE DeptID='2' Where HDept=1 OR HDiv=1");
while ($row = mysql_fetch_array($sql_resF)) {
       $CCFullname = $row['Firstname'] . " " . $row['Surname'];
       $CCEmail = trim($row['Email']);
       //$REQDeptID = $row['DeptID'];
       $mail->AddCC($CCEmail, $CCFullname);
     }
///////////////////////////////////////
     

     

if($ActionOfMD == "MDApprove") { $Apn = 11; $ReqMSG = "Approved"; }
if($ActionOfMD == "MDKeepInView") { $Apn = 14; $ReqMSG = "Keep In View"; }
if($ActionOfMD == "MDCancel") { $Apn = 15; $ReqMSG = "Cancelled"; }
//FOR APPROV
   mysql_query("UPDATE cashreq SET Approved='16', LastActor='GM Accounts', ApprovedBy='$staffname', SetForPaymentOn='$TodayD', SetForPaymentBy='$uid' WHERE RequestID = '$ReqCode'");

//now we have to inform the HOD
require_approval_action_notification ($REQEmail, $REQFullname, $ReqCode, "Requester", $Mgs); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Processing Payment]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view request on Elshcon ERP which in being Treated By Accounts Office,<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://elshcon.space/requisition/cashrequestform?sReqID='.$pdfid;
		$Favicon = "https://www.elshcon.space/mBOOT/plant.png";
        
       
        $msg = '<!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="'.$SFavicon.'">

        </head>
        <body style="margin:0px; font-family:Sans-serif, sans-serif; background:#D6D6D6;">
        <div style="padding:15px; background:#000033; font-size: 2em; color:#FFF; border-radius:7px;">
        <center>
        
        <center style="display:inline; font-weight:800;"> <img src="'.$GLOBALS['Favicon'].'" /> </center>
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
$_SESSION['ErrMsgB'] = "Approved By Accounts Office,  ".$REQFullname." have been notified. Thanks";
 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>