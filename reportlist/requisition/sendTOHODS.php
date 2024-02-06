<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID =$uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];

$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG']))); 
$TodayD = date("Y-m-d h:i:s a");

//We need to HOD of the Dept now
$sql_res=mysql_query("SELECT * FROM users WHERE DeptID = '$DeptID' AND HDept=1");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "Your Department does not have Head of Department configured. Thanks";
	header('Location: supervisorppor?pdfid='.$ReqCode);
	exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
       $HODID = $row['uid'];
       $REQUID = $row['uid'];
       
       $HODFullname = $row['Firstname'] . " " . $row['Surname'];
       $HODEmail = $row['Email'];
     }

//Update the rpo table
   mysql_query("UPDATE poreq SET Approved='2', LastActor='Supervisor of Department', Status='Approved', DeptHeadApp='".$HODID."', SupervisorApp='".$uid."', ApprovedBy='".$_SESSION['Firstname']. " ".$_SESSION['SurName']."', SupervisorAppDate='".$TodayD."', SupervisorComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");

//now we have to inform the HOD
require_approval_action_notification ($HODEmail, $HODFullname, $ReqCode, "Head of Department", $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/hodppor?pdfid='.$pdfid;
		include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$HODFullname." as Head of Department. Thanks";
header('Location: supervisorppor?pdfid='.$ReqCode);
//close the connection
mysql_close($dbhandle);
exit;









?>