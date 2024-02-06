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


$resultDeptRQ = mysql_query("SELECT * FROM poreq WHERE RequestID ='$ReqCode'");
 while ($row = mysql_fetch_array($resultDeptRQ)) {
       //$reqid = $row['reqid'];
       $DeptID = $row['Deparment'];
      
     }
//////////////////////////////////////////////////////////////////
$resultDept = mysql_query("SELECT * FROM department WHERE id ='$DeptID'");
 while ($row = mysql_fetch_array($resultDept)) {
       //$reqid = $row['reqid'];
       $Department = $row['DeptmentName'];
       $DIVID = $row['DivID'];
     }

    
//////////////////////////////////////////////////////
 $resultDept = mysql_query("SELECT * FROM divisions LEFT JOIN users ON divisions.DH = users.uid WHERE divid ='$DIVID'");
 while ($row = mysql_fetch_array($resultDept)) {
       $HODivID = $row['uid'];
       $REQUID = $row['uid'];
       
       $HODFullname = $row['Firstname'] . " " . $row['Surname'];
       $HODDIVName = $row['DivisionName'];
       $HODEmail = $row['Email'];
     }
if($HODivID == ""){ 
    $_SESSION['ErrMsg'] = "Division does not have head. Thanks";
    //header('Location: hodppor?pdfid='.$ReqCode);
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit; 
    }
//////////////////////////////////////////////////////////////////////////////


$sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $UserApp = $rowPOREQ['UserApp'];

       $UserAppComment = $rowPOREQ['UserAppComment'];
       $UserAppDate = $rowPOREQ['UserAppDate'];

       $SupervisorComment = $rowPOREQ['SupervisorComment'];
       $SupervisorAppDate = $rowPOREQ['SupervisorAppDate'];

       $DeptHeadAppDate = $rowPOREQ['DeptHeadAppDate'];
       $DeptHeadAppComment = $rowPOREQ['DeptHeadAppComment'];

       $DivHeadAppDate = $rowPOREQ['DivHeadAppDate'];
       $DivHeadAppComment = $rowPOREQ['DivHeadAppComment'];

       $CSAppDate = $rowPOREQ['CSAppDate'];
       $CSAppComment = $rowPOREQ['CSAppComment'];

       $MgrAppDate = $rowPOREQ['MgrAppDate'];
       $MgrAppComment = $rowPOREQ['MgrAppComment'];

     }



    

if($actor == "HOD")
{

     if($DeptHeadAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$DeptHeadAppComment.'  | <b>'.$DeptHeadAppDate.'</b></div> <br/> '. $hodMSG;
             }
//Update the rpo table
    mysql_query("UPDATE poreq SET Approved='3', LastActor='Head of Department', Status='Approved', DivHeadApp='".$HODivID."', DeptHeadApp='".$uid."', ApprovedBy='".$staffname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}

if($actor == "Requester")
{

    if($UserAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$UserAppComment.'  | <b>'.$UserAppDate.'</b></div> <br/> '. $hodMSG;
             }
//Update the rpo table
    mysql_query("UPDATE poreq SET Approved='3', LastActor='Requester', Status='Submitted', DivHeadApp='".$HODivID."', UserApp='".$uid."', ApprovedBy='".$staffname."', UserAppDate='".$TodayD."',  UserAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}

if($actor == "Supervisor")
{

    if($SupervisorComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$SupervisorComment.'  | <b>'.$SupervisorAppDate.'</b></div> <br/> '. $hodMSG;
             }
//Update the rpo table
    mysql_query("UPDATE poreq SET Approved='3', LastActor='Supervisor', Status='Submitted', DivHeadApp='".$HODivID."', SupervisorApp='".$uid."', ApprovedBy='".$staffname."', SupervisorAppDate='".$TodayD."',  SupervisorComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}
   /*mysql_query("UPDATE poreq SET Approved='2', LastActor='Head of Department', Status='Approved', DeptHeadApp='".$HODID."', ApprovedBy='".$HODFullname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE WHERE RequestID = '$ReqCode'");*/

//now we have to inform the HOD
require_approval_action_notification ($HODEmail, $HODFullname, $ReqCode, "Head of Division for " .$HODDIVName, $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/divppor?pdfid='.$pdfid;
		include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$HODFullname." as [Head of Division] for [" .$HODDIVName ."]. Thanks";
//header('Location: hodppor?pdfid='.$ReqCode);
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>