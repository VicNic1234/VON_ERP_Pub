<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID =$uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];

if($uid < 1) {
     $_SESSION['ErrMsg'] = "Oops!Timed Out. Kindly Logout and Login Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit;
    }

$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$ReqMSG = mysql_real_escape_string(trim(strip_tags($_POST['ReqMSG'])));
$TodayD = date("Y-m-d h:i:s a");

//Lets get Div Head Info
$sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $GM = $rowPOREQ['MgrApp'];
       $CPAppDate = $rowPOREQ['CPAppDate'];
       $CPAppComment = $rowPOREQ['CPAppComment'];
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
	$_SESSION['ErrMsg'] = "GM does not exist in the Division. Thanks";
	if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
	exit; 
 }
}
while ($row = mysql_fetch_array($sql_res)) {
       $REQFullname = $row['Firstname'] . " " . $row['Surname'];
       $REQEmail = $row['Email'];
       $REQUID = $row['uid'];
       
     }


      if($CPAppComment != "")
     {
        $ReqMSG = '<div class="rcorners1">'.mysql_real_escape_string($CPAppComment).'  | <b>'.$CPAppDate.'</b></div> <br/> '. $ReqMSG;
     }

//Update the rpo table
   mysql_query("UPDATE poreq SET Approved='4', LastActor='C & P', Status='Sent Back', CPApp='".$uid."', ApprovedBy='".$staffname."', CPAppDate='".$TodayD."',  CPAppComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");

//now we have to inform the HOD
require_approval_action_notification ($REQEmail, $REQFullname, $ReqCode, "GM of Division", $ReqMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Request Sent Back]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view request on Elshcon ERP which was sent back to you as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/gmppor?pdfid='.$pdfid;
		include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Request have been sent back to ".$REQFullname." as GM of Division. Thanks";
//header('Location: mgddppor?pdfid='.$ReqCode);
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>