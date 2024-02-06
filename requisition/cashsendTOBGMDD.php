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
       $GMDD = $rowPOREQ['DDApp'];  $MDComment = $rowPOREQ['MDComment'];  $MDAppDate = $rowPOREQ['MDAppDate'];
     }

////CHK GM CS
 $sqlGMCS=mysql_query("SELECT * FROM divisions WHERE divid='3'");
while ($rowGMSC = mysql_fetch_array($sqlGMCS)) {
      $REQUID = $GMDDID = $rowGMSC['GM'];
     }    
////////////////////////////////////////
$sql_res=mysql_query("SELECT * FROM users WHERE uid='$GMDDID'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "GM Due Dilligence is not configured. Thanks";
	header('Location: cashmdppor?pdfid='.$ReqCode);
	exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
       $REQFullname = $row['Firstname'] . " " . $row['Surname'];
       $REQEmail = $row['Email'];
     }

  if($MDComment != "")
     {
       $ReqMSG =  '<div class="rcorners1">'.mysql_real_escape_string($MDComment).'  | <b>'.$MDAppDate.'</b></div> <br/> '. $ReqMSG;
     }
     
//Update the rpo table
   mysql_query("UPDATE cashreq SET Approved='8', LastActor='MD\'s Office' , Status='Sent Back', MDApp='".$uid."', ApprovedBy='".$staffname."', MDAppDate='".$TodayD."',  MDComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");

//now we have to inform the HOD
require_approval_action_notification ($REQEmail, $REQFullname, $ReqCode, "GM of Due Dilligence", $ReqMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Request Sent Back]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view request on Elshcon ERP which was sent back to you as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashmgddppor?pdfid='.$pdfid;
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Request have been sent back to ".$REQFullname." as GM of Due Dilligence. Thanks";
header('Location: cashmdppor?pdfid='.$ReqCode);
//close the connection
mysql_close($dbhandle);
exit;









?>