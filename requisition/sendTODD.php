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
$TodayD = date("Y-m-d h:i:s a");

//First we need to get the DIVID
/*$sqlDept=mysql_query("SELECT * FROM department WHERE id = '$DeptID'");

$isDept = mysql_num_rows($sqlDept);
if($isDept < 1) { 
    $_SESSION['ErrMsg'] = "Your Department is not configured, contact HR. Thanks";
    header('Location: divppor?pdfid='.$ReqCode);
    exit; 
}

while ($rowDIV = mysql_fetch_array($sqlDept)) {
       $MyDIVID = $rowDIV['DivID'];
     }
*/
////////////////////////////////////////////////////////////////////////////
     //We need to get all concerns in Due Diligence now
    $sql_res=mysql_query("SELECT * FROM users WHERE DeptID='11'"); //DeptID = '$DeptID' AND 

 $isHOD = mysql_num_rows($sql_res); 
if($isHOD < 1) { 
    $_SESSION['ErrMsg'] = "No Due Diligence Officer configured, contact HR. Thanks";
    //header('Location: gmppor?pdfid='.$ReqCode);
    //exit; 
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
   
    {
       //$GMID = $row['uid'];
       $DDFullname = $row['Firstname'] . " " . $row['Surname'];
       //$GMDIVName = $row['DivisionName'];
       $REQUID = $row['uid'];
       
       $DDEmail = $row['Email'];
    }

    //now we have to inform the DD
require_approval_action_notification ($DDEmail, $DDFullname, $ReqCode, "Due Diligence Officer", $hodMSG); 
   
     }

//////////////////////////////////////////////////////////////////////////////
//Lets get HOD Info
$sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $UserApp = $rowPOREQ['UserApp'];


       $DDOfficerAppDate = $rowPOREQ['DDOfficerAppDate'];
       $DDOfficerAppComment = $rowPOREQ['DDOfficerAppComment'];

     }


     if($DDOfficerAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$DDOfficerAppComment.'  | <b>'.$DDOfficerAppDate.'</b></div> <br/> '. $hodMSG;
             }


//Update the rpo table
    mysql_query("UPDATE poreq SET Approved='8', LastActor='Officer Due Diligence', Status='Approved', DDApp='".$GMDD."', DDOfficerApp='".$uid."', ApprovedBy='".$staffname."', DDOfficerAppDate='".$TodayD."',  DDOfficerAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");


//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/gmddppor?pdfid='.$pdfid;
		include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to Due Diligence for action. Thanks";
//header('Location: gmppor?pdfid='.$ReqCode);
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit; 
//close the connection
mysql_close($dbhandle);
exit;









?>