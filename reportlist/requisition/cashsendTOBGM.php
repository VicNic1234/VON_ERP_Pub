<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID = $uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];

$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$ReqMSG = mysql_real_escape_string(trim(strip_tags($_POST['ReqMSG'])));
$TodayD = date("Y-m-d h:i:s a");

//Lets get Div Head Info
$sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
      $REQUID = $GM = $rowPOREQ['MgrApp']; $DDOfficerAppDate= $rowPOREQ['DDOfficerAppDate']; $DDOfficerAppComment = $rowPOREQ['DDOfficerAppComment'];
     }

////CHK GM CS
 $sqlGMCS=mysql_query("SELECT * FROM divisions WHERE divid='1'");
while ($rowGMSC = mysql_fetch_array($sqlGMCS)) {
       $GMCSID = $rowGMSC['GM'];
     }    
////////////////////////////////////////
$sql_res=mysql_query("SELECT * FROM users WHERE uid='$GM'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "GM CS does not exist. Thanks";
	header('Location: cashofficeddppor?pdfid='.$ReqCode);
	exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
       $REQFullname = $row['Firstname'] . " " . $row['Surname'];
       $REQEmail = $row['Email'];
     }
     
      if($DDOfficerAppComment != "")
     {
       $ReqMSG =  '<div class="rcorners1">'.mysql_real_escape_string($DDOfficerAppComment).'  | <b>'.$DDOfficerAppDate.'</b></div> <br/> '. $ReqMSG;
     }

//Update the rpo table
   mysql_query("UPDATE cashreq SET Approved='4', LastActor='Officer of Due Dilligence', Status='Sent Back', DDOfficerApp='".$uid."', ApprovedBy='".$staffname."', DDOfficerAppDate='".$TodayD."',  DDOfficerAppComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");
//echo mysql_error($dbhandle);
//exit;
//now we have to inform the HOD
require_approval_action_notification ($REQEmail, $REQFullname, $ReqCode, "GM of Division", $ReqMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Request Sent Back]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view request on Elshcon ERP which was sent back to you as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashmgppor?pdfid='.$pdfid;
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Request have been sent back to ".$REQFullname." as GM of CS. Thanks";
header('Location: cashofficeddppor?pdfid='.$ReqCode);
//close the connection
mysql_close($dbhandle);
exit;









?>