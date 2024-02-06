<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID = $uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];

$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$ReqMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG'])));
$TodayD = date("Y-m-d h:i:s a");

//Lets get HOD Info
$sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $UserApp = $rowPOREQ['UserApp'];  $SupervisorAppDate = $rowPOREQ['SupervisorAppDate'];  $SupervisorComment = $rowPOREQ['SupervisorComment'];
     }

////////////////////////////////////////
$sql_res=mysql_query("SELECT * FROM users WHERE uid='$UserApp'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "User Does not exist. Thanks";
	  if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
	exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
       $REQUID = $row['uid'];
       $REQFullname = $row['Firstname'] . " " . $row['Surname'];
       $REQEmail = $row['Email'];
     }

   if($SupervisorComment != "")
     {
       $ReqMSG =  '<div class="rcorners1">'.mysql_real_escape_string($SupervisorComment).'  | <b>'.$SupervisorAppDate.'</b></div> <br/> '. $ReqMSG;
     }
//Update the rpo table
   mysql_query("UPDATE cashreq SET Approved='0', LastActor='Supervisor of Department', Status='Sent Back', SupervisorApp='".$uid."', DeptHeadApp='0', ApprovedBy='".$staffname."', SupervisorAppDate='".$TodayD."',  SupervisorComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");

//now we have to inform the HOD
require_approval_action_notification ($REQEmail, $REQFullname, $ReqCode, "Requester", $ReqMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Request Sent Back]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view request on Elshcon ERP which was sent back to you as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashrequestform?sReqID='.$pdfid;
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Request have been sent back to ".$REQFullname." as Requester. Thanks";
  if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>