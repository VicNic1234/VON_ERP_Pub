<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID =$uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];

$ReqID = mysql_real_escape_string(trim(strip_tags($_POST['ReqID'])));
$HODID = mysql_real_escape_string(trim(strip_tags($_POST['HODID'])));
$HODNme = mysql_real_escape_string(trim(strip_tags($_POST['HODNme'])));
$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$ReqMSG = mysql_real_escape_string(trim(strip_tags($_POST['ReqMSG'])));
$TodayD = date("Y-m-d h:i:s a");

//Lets get requester Info
$sql_res=mysql_query("SELECT * FROM users WHERE uid='$ReqID'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "Requester Does not exist. Thanks";
	header('Location: hodppor?pdfid='.$ReqCode);
	exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
       $REQFullname = $row['Firstname'] . " " . $row['Surname'];
       $REQEmail = $row['Email'];
       $REQUID = $row['uid'];
       
     }

$sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
        while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
               $UserApp = $rowPOREQ['UserApp'];


               $DeptHeadAppDate = $rowPOREQ['DeptHeadAppDate'];
               $DeptHeadAppComment = $rowPOREQ['DeptHeadAppComment'];

             }


             if($DeptHeadAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$DeptHeadAppComment.'  | <b>'.$DeptHeadAppDate.'</b></div> <br/> '. $hodMSG;
             }
//Update the rpo table
   mysql_query("UPDATE poreq SET Approved='0', LastActor='Head of Department', Status='Sent Back', DeptHeadApp='".$HODID."', ApprovedBy='".$HODNme."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");

//now we have to inform the HOD
require_approval_action_notification ($REQEmail, $REQFullname, $ReqCode, "Requester", $ReqMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Request Sent Back]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view your request on Elshcon ERP which was sent back to you as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/ppor?sReqID='.$pdfid;
		include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Request have been sent back to ".$REQFullname." as Requester. Thanks";
header('Location: hodppor?pdfid='.$ReqCode);
//close the connection
mysql_close($dbhandle);
exit;









?>