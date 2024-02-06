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

//Lets get HOD Info
$sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $DeparmentID = $rowPOREQ['Deparment']; $DivHeadAppDate = $rowPOREQ['DivHeadAppDate']; $DivHeadAppComment = $rowPOREQ['DivHeadAppComment'];
     }
     
//////////////////We have to get department HOD now ////////////////
$sql_dept =mysql_query("SELECT * FROM department WHERE id='$DeparmentID'");
$nHOD = mysql_num_rows($sql_dept);
if($nHOD != 0) { 
while ($row = mysql_fetch_array($sql_dept)) {
       $REQUID = $HeadOfDeptID = $row['hod'];
     }
}
//echo $HeadOfDeptID ."FGF"; exit;
////////////////////////////////////////
$sql_res=mysql_query("SELECT * FROM users WHERE uid='$HeadOfDeptID'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "Head of Department Does not exist. Thanks";
	//header('Location: cashdivppor?pdfid='.$ReqCode);
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
	exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
       $REQFullname = $row['Firstname'] . " " . $row['Surname'];
       $REQEmail = $row['Email'];
     }
     
      if($DivHeadAppComment != "")
     {
       $ReqMSG =  '<div class="rcorners1">'.mysql_real_escape_string($DivHeadAppComment).'  | <b>'.$DivHeadAppDate.'</b></div> <br/> '. $ReqMSG;
     }

//Update the rpo table
   mysql_query("UPDATE cashreq SET Approved='2', LastActor='Head of Division', Status='Sent Back', DivHeadApp='".$uid."', ApprovedBy='".$staffname."', DivHeadAppDate='".$TodayD."',  DivHeadAppComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");

//now we have to inform the HOD
require_approval_action_notification ($REQEmail, $REQFullname, $ReqCode, "Head of Department", $ReqMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Request Sent Back]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view request on Elshcon ERP which was sent back to you as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashhodppor?pdfid='.$pdfid;
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Request have been sent back to ".$REQFullname." as Head of Department. Thanks";
//header('Location: cashdivppor?pdfid='.$ReqCode);
 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>