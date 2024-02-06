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
       $DeparmentID = $rowPOREQ['Deparment']; $MgrAppDate = $rowPOREQ['MgrAppDate']; $MgrAppComment = $rowPOREQ['MgrAppComment'];
     }
     
//////////////////We have to get department HOD now ////////////////
$sql_dept =mysql_query("SELECT * FROM department WHERE id='$DeparmentID'");
$nHOD = mysql_num_rows($sql_dept);
if($nHOD != 0) { 
while ($row = mysql_fetch_array($sql_dept)) {
       $HeadOfDeptID = $row['hod'];
	   $DivID = $row['DivID'];
     }
}

//////////////////We have to get department HODiv now ////////////////
$sql_div =mysql_query("SELECT * FROM divisions WHERE divid='$DivID'");
$nHODiv = mysql_num_rows($sql_div);
if($nHODiv != 0) { 
while ($row = mysql_fetch_array($sql_div)) {
       $REQUID = $HeadOfDiv = $row['DH'];
     }
}
//echo $HeadOfDeptID ."FGF"; exit;
////////////////////////////////////////
$sql_res=mysql_query("SELECT * FROM users WHERE uid='$HeadOfDiv'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "Head of Division Does not exist. Thanks";
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
     
      if($MgrAppComment != "")
     {
       $ReqMSG =  '<div class="rcorners1">'.mysql_real_escape_string($MgrAppComment).'  | <b>'.$MgrAppDate.'</b></div> <br/> '. $ReqMSG;
     }

//Update the rpo table
   mysql_query("UPDATE cashreq SET Approved='3', LastActor='GM of Division', Status='Sent Back', MgrApp='".$uid."', ApprovedBy='".$staffname."', MgrAppDate='".$TodayD."',  MgrAppComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");

//now we have to inform the HOD
require_approval_action_notification ($REQEmail, $REQFullname, $ReqCode, "Head of Division", $ReqMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Request Sent Back]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view request on Elshcon ERP which was sent back to you as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashdivppor?pdfid='.$pdfid;
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