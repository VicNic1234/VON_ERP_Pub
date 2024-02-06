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
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG']))); 
$DeptIDx = mysql_real_escape_string(trim(strip_tags($_POST['ReqDept']))); 
$TodayD = date("Y-m-d h:i:s a");


  $sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
     $DeparmentID = $rowPOREQ['Deparment']; $UserAppDate = $rowPOREQ['UserAppDate']; $UserAppComment = $rowPOREQ['UserAppComment'];
      $DeptHeadApp = $rowPOREQ['DeptHeadApp'];
     }
     
 //////////////////We have to get department HOD now ////////////////
$sql_dept =mysql_query("SELECT * FROM department WHERE id='$DeparmentID'");
$nHOD = mysql_num_rows($sql_dept);
if($nHOD != 0) { 
while ($row = mysql_fetch_array($sql_dept)) {
      $REQUID =  $HeadOfDeptID = $row['hod'];
       $DivID = $row['DivID'];
     }
}    
//if($DeptIDx != "") { $DeptID = $DeptIDx; }
//We need to HOD of the Dept now
$sql_res=mysql_query("SELECT * FROM users WHERE uid = '$HeadOfDeptID'");

//$sql_res=mysql_query("SELECT * FROM department LEFT JOIN users ON department.hod = users.uid WHERE department.id = '$DeptID'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "Your Department does not have Head of Department configured. Thanks";
	//header('Location: cashrequestform?sReqID='.$ReqCode);
	 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
	exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
       $HODID = $row['uid'];
     $HODFullname = $row['Firstname'] . " " . $row['Surname'];
       $HODEmail = $row['Email'];
     }
     
   

  if($UserAppComment != "")
     {
       $hodMSG =  '<div class="rcorners1">'.mysql_real_escape_string($UserAppComment).'  | <b>'.$UserAppDate.'</b></div> <br/> '. $hodMSG;
     }


//Update the rpo table
   mysql_query("UPDATE cashreq SET Approved='2', LastActor='Requester', Status='Submitted', DeptHeadApp='".$HODID."', UserApp='".$uid."', SupervisorApp='0', ApprovedBy='".$_SESSION['Firstname']. " ".$_SESSION['SurName']."', UserAppDate='".$TodayD."',  UserAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");

//now we have to inform the HOD
require_approval_action_notification ($HODEmail, $HODFullname, $ReqCode, "Head of Department", $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [CASH REQUEST*** Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashhodppor?pdfid='.$pdfid;
		include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$HODFullname." as Head of Department. Thanks";
header('Location: cashrequestform?sReqID='.$ReqCode);
//close the connection
mysql_close($dbhandle);
exit;









?>