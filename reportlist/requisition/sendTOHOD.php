<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID =$uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];

$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG']))); 
$rep = mysql_real_escape_string(trim(strip_tags($_POST['rep']))); 
$actor = mysql_real_escape_string(trim(strip_tags($_POST['actor']))); 
$TodayD = date("Y-m-d h:i:s a");

//We need to HOD of the Dept now

 $sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
        while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
               $UserApp = $rowPOREQ['UserApp'];

                $DeparmentID = $rowPOREQ['Deparment'];
               $UserAppDate = $rowPOREQ['UserAppDate'];
               $UserAppComment = $rowPOREQ['UserAppComment'];

               $SupervisorAppDate = $rowPOREQ['SupervisorAppDate'];
               $SupervisorComment = $rowPOREQ['SupervisorComment'];

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
           
$sql_res=mysql_query("SELECT * FROM users WHERE uid = '$HeadOfDeptID'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD < 1) { 
	$_SESSION['ErrMsg'] = "Your Department does not have Head of Department configured. Thanks";
	//header('Location: ppor?sReqID='.$ReqCode);
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
	exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
       $HODID = $row['uid'];
       $REQUID = $row['uid'];
       
       $HODFullname = $row['Firstname'] . " " . $row['Surname'];
       $HODEmail = $row['Email'];
     }


    


     

//Update the rpo table
 if($actor == "Requester")
{

    if($UserAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$UserAppComment.'  | <b>'.$UserAppDate.'</b></div> <br/> '. $hodMSG;
             }
   mysql_query("UPDATE poreq SET Approved='2', LastActor='Requester', Status='Submitted', DeptHeadApp='".$HODID."', UserApp='".$uid."', SupervisorApp='0', ApprovedBy='".$_SESSION['Firstname']. " ".$_SESSION['SurName']."', UserAppDate='".$TodayD."',  UserAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}
 if($actor == "Supervisor")
{

     if($SupervisorComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$SupervisorComment.'  | <b>'.$SupervisorAppDate.'</b></div> <br/> '. $hodMSG;
             }
             
    mysql_query("UPDATE poreq SET Approved='2', LastActor='Supervisor of Department', Status='Approved', DeptHeadApp='".$HODID."', SupervisorApp='".$uid."', ApprovedBy='".$_SESSION['Firstname']. " ".$_SESSION['SurName']."', SupervisorAppDate='".$TodayD."', SupervisorComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}

//now we have to inform the HOD
require_approval_action_notification ($HODEmail, $HODFullname, $ReqCode, "Head of Department", $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/hodppor?pdfid='.$pdfid;
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$HODFullname." as Head of Department. Thanks";
//header('Location: ppor?sReqID='.$ReqCode);
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>