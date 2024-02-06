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
$actor = mysql_real_escape_string(trim(strip_tags($_POST['actor'])));
$TodayD = date("Y-m-d h:i:s a");

//Lets get HOD Info
$sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $HeadOfDeptID = $rowPOREQ['DeptHeadApp'];
       $MgrAppDate = $rowPOREQ['MgrAppDate'];
       $MgrAppComment = $rowPOREQ['MgrAppComment'];

       $DivHeadAppComment = $rowPOREQ['DivHeadAppComment'];
       $DivHeadAppDate = $rowPOREQ['DivHeadAppDate'];


     }

////////////////////////////////////////
$sql_res=mysql_query("SELECT * FROM users WHERE uid='$HeadOfDeptID'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "Head of Department Does not exist. Thanks";
	//header('Location: divppor?pdfid='.$ReqCode);
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
	exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
       $REQFullname = $row['Firstname'] . " " . $row['Surname'];
       $REQEmail = $row['Email'];
       $REQUID = $row['uid'];
       
     }

//Update the rpo table
     if($actor == "GM of Division")
     {

         if($MgrAppComment != "")
             {
                $ReqMSG = '<div class="rcorners1">'.$MgrAppComment.'  | <b>'.$MgrAppDate.'</b></div> <br/> '. $ReqMSG;
             }
             
        mysql_query("UPDATE poreq SET Approved='2', LastActor='GM of Division', Status='Sent Back', MgrApp='".$uid."', ApprovedBy='".$staffname."', MgrAppDate='".$TodayD."',  MgrAppComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");

             
     }
else
{

    if($DivHeadAppComment != "")
             {
                $ReqMSG = '<div class="rcorners1">'.$DivHeadAppComment.'  | <b>'.$DivHeadAppDate.'</b></div> <br/> '. $ReqMSG;
             }

   mysql_query("UPDATE poreq SET Approved='2', LastActor='Head of Division', Status='Sent Back', DivHeadApp='".$uid."', ApprovedBy='".$staffname."', DivHeadAppDate='".$TodayD."',  DivHeadAppComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");

   
}

//now we have to inform the HOD
require_approval_action_notification ($REQEmail, $REQFullname, $ReqCode, "Head of Department", $ReqMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Request Sent Back]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view request on Elshcon ERP which was sent back to you as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/hodppor?pdfid='.$pdfid;
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Request have been sent back to ".$REQFullname." as Head of Department. Thanks";
//header('Location: divppor?pdfid='.$ReqCode);
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"] . "?pdfid=".$ReqCode);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>