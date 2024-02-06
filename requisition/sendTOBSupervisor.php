<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID = $uid = $_SESSION['uid'];

$DeptID = $_SESSION['DeptID'];

$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$ReqMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG'])));
$actor = mysql_real_escape_string(trim(strip_tags($_POST['actor'])));
$TodayD = date("Y-m-d h:i:s a");

//Lets get Supervisor Info
/*$sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $UserApp = $rowPOREQ['SupervisorApp'];
     }
*/

$resultDeptHnSuperV = mysql_query("SELECT * FROM department WHERE id='$DeptID'");
        while ($row = mysql_fetch_array($resultDeptHnSuperV)) 
        {
              if($row['supervisor'] > 0) { $mySupervisor = $row['supervisor']; }
        }

////////////////////////////////////////
$sql_res=mysql_query("SELECT * FROM users WHERE uid='$mySupervisor'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "Supervisor Does not exist. Thanks";
	//header('Location: hodppor?pdfid='.$ReqCode);
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



  $sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $DeptHeadAppDate = $rowPOREQ['DeptHeadAppDate'];
       $DeptHeadAppComment = $rowPOREQ['DeptHeadAppComment'];

       $DivHeadAppDate = $rowPOREQ['DivHeadAppDate'];
       $DivHeadAppComment = $rowPOREQ['DivHeadAppComment'];

     }

//Update the rpo table
if($actor == "HOD") {

  if($DeptHeadAppComment != "")
             {
                $ReqMSG = '<div class="rcorners1">'.$DeptHeadAppComment.'  | <b>'.$DeptHeadAppDate.'</b></div> <br/> '. $ReqMSG;
             }

   mysql_query("UPDATE poreq SET Approved='1', LastActor='Head of Department', Status='Sent Back',  DeptHeadApp='".$uid."', ApprovedBy='".$staffname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");


}

if($actor == "HODiv") {

  if($DivHeadAppComment != "")
             {
                $ReqMSG = '<div class="rcorners1">'.$DivHeadAppComment.'  | <b>'.$DivHeadAppDate.'</b></div> <br/> '. $ReqMSG;
             }
             
   mysql_query("UPDATE poreq SET Approved='1', LastActor='Head of Division', Status='Sent Back',  DivHeadApp='".$uid."', ApprovedBy='".$staffname."', DivHeadAppDate='".$TodayD."',  DivHeadAppComment='".$ReqMSG."' WHERE RequestID = '$ReqCode'");
}


//now we have to inform the HOD
require_approval_action_notification ($REQEmail, $REQFullname, $ReqCode, "Supervisor", $ReqMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Request Sent Back]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view request on Elshcon ERP which was sent back to you as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/supervisorppor?pdfid='.$pdfid;
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Request have been sent back to ".$REQFullname." as Supervisor. Thanks";
//header('Location: hodppor?pdfid='.$ReqCode);
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>