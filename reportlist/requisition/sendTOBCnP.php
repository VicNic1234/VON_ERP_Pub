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
$ReqMSG = mysql_real_escape_string(trim(strip_tags($_POST['ReqMSG'])));
$TodayD = date("Y-m-d h:i:s a");

//Lets get HOD Info
$sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $HeadOfDeptID = $rowPOREQ['CPApp']; $MgrAppDate = $rowPOREQ['MgrAppDate']; $MgrAppComment = $rowPOREQ['MgrAppComment'];
     }

////////////////////////////////////////
$sql_res=mysql_query("SELECT * FROM users WHERE uid='$HeadOfDeptID'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "Head of Department of C&P Does not exist. Thanks";
	 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"] . "?pdfid=".$ReqCode);
    }
    exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
       $REQFullname = $row['Firstname'] . " " . $row['Surname'];
       $REQEmail = $row['Email'];
       $REQUID = $row['uid'];

     }

     if($MgrAppComment != "")
     {
        $ReqMSG = '<div class="rcorners1">'.mysql_real_escape_string($MgrAppComment).'  | <b>'.$MgrAppDate.'</b></div> <br/> '. $ReqMSG;
     }

//Update the rpo table
   mysql_query("UPDATE poreq SET Approved='6', LastActor='GM Corporate Services', Status='Sent Back', MgrApp='".$uid."', ApprovedBy='".$staffname."', MgrAppDate='".$TodayD."', MgrAppComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");

//now we have to inform the HOD
require_approval_action_notification ($REQEmail, $REQFullname, $ReqCode, "Head of C&P", $ReqMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Request Sent Back]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view request on Elshcon ERP which was sent back to you as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/cnp/hodppor?pdfid='.$pdfid;
		
        include('../notify.php');
        
        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Request have been sent back to ".$REQFullname." as Head of C&P. Thanks";
 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit; 
//close the connection
mysql_close($dbhandle);
exit;









?>