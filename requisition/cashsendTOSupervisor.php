<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID = $uid = $_SESSION['uid'];

$DeptID = $_SESSION['DeptID'];

$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG']))); 
$TodayD = date("Y-m-d h:i:s a");

 $sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
      $UserAppDate = $rowPOREQ['UserAppDate']; $UserAppComment = $rowPOREQ['UserAppComment'];
      $DeptID = $rowPOREQ['Deparment'];
     }


//We need to HOD of the Dept now
$sql_res=mysql_query("SELECT * FROM department ON users.uid = department.supervisor WHERE department.id = '$DeptID'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "Your Department does not have Supervisor configured. Thanks";
	header('Location: cashrequestform?sReqID='.$ReqCode);
	exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
       $REQUID = $SupervisorID = $row['uid'];
       $SupervisorFullname = $row['Firstname'] . " " . $row['Surname'];
       $SupervisorEmail = $row['Email'];
     }

 
  if($MgrAppComment != "")
     {
       $hodMSG =  '<div class="rcorners1">'.mysql_real_escape_string($UserAppComment).'  | <b>'.$UserAppDate.'</b></div> <br/> '. $hodMSG;
     }
//Update the rpo table
   mysql_query("UPDATE cashreq SET Approved='1', LastActor='Requester', Status='Submitted', SupervisorApp='".$SupervisorID."', UserApp='".$uid."', ApprovedBy='".$_SESSION['Firstname']. " ".$_SESSION['SurName']."', UserAppDate='".$TodayD."',  UserAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");

//now we have to inform the HOD
require_approval_action_notification ($SupervisorEmail, $SupervisorFullname, $ReqCode, "Supervisor of Department", $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [CASH REQUEST *** Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashsupervisorppor?pdfid='.$pdfid;
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$SupervisorFullname." as Supervisor of Department. Thanks";
header('Location: cashrequestform?sReqID='.$ReqCode);
//echo mysql_error();
//close the connection
mysql_close($dbhandle);
exit;









?>