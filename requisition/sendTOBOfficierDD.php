<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID = $uid = $_SESSION['uid'];

$DeptID = $_SESSION['DeptID'];
if($uid < 1) {
     $_SESSION['ErrMsg'] = "Oops! Timed Out. Kindly Logout and Login Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}

$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$ReqMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG'])));
$actor = mysql_real_escape_string(trim(strip_tags($_POST['actor'])));
$TodayD = date("Y-m-d h:i:s a");

//Lets get Supervisor Info
/*$sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $UserApp = $rowPOREQ['SupervisorApp'];
     }
*/


$resultDD = mysql_query("SELECT * FROM users WHERE DeptID=11");
 while ($row = mysql_fetch_array($resultDD)) {
       $OffcierDD = $row['uid'];
       $OfficerDDNme = $row['Firstname'] . " " . $row['Surname']; 
       $OfficerDDEmail = $row['Email']; 
       $REQUID = $row['uid'];
       

     }

      $isHOD = mysql_num_rows($resultDD); 
if($isHOD < 1 ) { 
    $_SESSION['ErrMsg'] = "No Staff in Due Dilligenc Office, contact HR. Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    //header('Location: cashdivppor?pdfid='.$ReqCode);
    exit; 
}

$sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $DDAppComment = $rowPOREQ['DDAppComment'];
       $DDAppDate = $rowPOREQ['DDAppDate'];
     }

     if($DDAppComment != "")
             {
                $ReqMSG = '<div class="rcorners1">'.$DDAppComment.'  | <b>'.$DDAppDate.'</b></div> <br/> '. $ReqMSG;
             }
//Update the rpo table
mysql_query("UPDATE poreq SET Approved='7', LastActor='GM of DD', Status='Approved', DDOfficerApp='".$OffcierDD."', DDApp='".$uid."', ApprovedBy='".$_SESSION['Firstname']. " ".$_SESSION['SurName']."', DDAppDate='".$TodayD."',  DDAppComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");

//now we have to inform the HOD
require_approval_action_notification ($REQEmail, $REQFullname, $ReqCode, "Officer of Due Diligence", $ReqMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Request Sent Back]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view request on Elshcon ERP which was sent back to you as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/officeddppor?pdfid='.$pdfid;
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Request have been sent back to ".$REQFullname." as Supervisor. Thanks";
//header('Location: hodppor?pdfid='.$ReqCode);
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>