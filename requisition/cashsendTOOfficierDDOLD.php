<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID = $uid = $_SESSION['uid'];

$DeptID = $_SESSION['DeptID'];
if($SNDUID < 1) {
     $_SESSION['ErrMsg'] = "Oops!Timed Out. Kindly Logout and Login Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    //header('Location: cashdivppor?pdfid='.$ReqCode);
    exit; 
}
$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG']))); 
$rep = mysql_real_escape_string(trim(strip_tags($_POST['rep']))); 
$actor = mysql_real_escape_string(trim(strip_tags($_POST['actor']))); 
$TodayD = date("Y-m-d h:i:s a");


$resultDD = mysql_query("SELECT * FROM users WHERE DeptID=11");
 while ($row = mysql_fetch_array($resultDD)) {
       $REQUID = $OffcierDD = $row['uid'];
       $OfficerDDNme = $row['Firstname'] . " " . $row['Surname']; 
       $OfficerDDEmail = $row['Email']; 

     }
//Update the rpo table

 $isHOD = mysql_num_rows($resultDD); 
if($isHOD < 1 ) { 
    $_SESSION['ErrMsg'] = "No Staff in Due Dilligenc Office, contact HR. Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    //header('Location: cashdivppor?pdfid='.$ReqCode);
    exit; 
}

    $sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
      $MgrAppDate = $rowPOREQ['MgrAppDate']; $MgrAppComment = $rowPOREQ['MgrAppComment'];
     }

  if($MgrAppComment != "")
     {
       $hodMSG =  '<div class="rcorners1">'.mysql_real_escape_string($MgrAppComment).'  | <b>'.$MgrAppDate.'</b></div> <br/> '. $hodMSG;
     }

 //if($actor == "GM of Divison")
{
   mysql_query("UPDATE cashreq SET Approved='7', LastActor='GM of Divison', Status='Approved', DDOfficerApp='".$OffcierDD."', MgrApp='".$uid."', ApprovedBy='".$_SESSION['Firstname']. " ".$_SESSION['SurName']."', MgrAppDate='".$TodayD."',  MgrAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}


//now we have to inform the HOD
require_approval_action_notification ($OfficerDDEmail, $OfficerDDNme, $ReqCode, "Office of Due Dilligence", $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [CASH REQUEST *** Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashofficeddppor?pdfid='.$pdfid;
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$OfficerDDNme." as Officer in Due Dilligence. Thanks";
//header('Location: ppor?sReqID='.$ReqCode);
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>