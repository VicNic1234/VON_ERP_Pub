<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID =  $uid = $_SESSION['uid'];
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


$resultDeptRQ = mysql_query("SELECT * FROM cashreq WHERE RequestID ='$ReqCode'");
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
       ////////////////////\***********************
       /*if($DIVID == 1) { 
               $_SESSION['Msg'] = "Sent to Due Dilligence Officer. GM CS Out of Office!";
               
               /////\******************************************
               mysql_query("UPDATE cashreq SET Approved='7', LastActor='Head of Department', Status='Approved', DivHeadApp='".$HODivID."', DeptHeadApp='".$uid."', DDOfficerApp='91', ApprovedBy='".$staffname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
                
  
               /////\******************************************
               if (isset($_SERVER["HTTP_REFERER"])) {
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                }
                exit;
           } */
        ///////////////////////////////\*********
     }

    
//////////////////////////////////////////////////////
 $resultDept = mysql_query("SELECT * FROM divisions LEFT JOIN users ON divisions.DH = users.uid WHERE divid ='$DIVID'");
 while ($row = mysql_fetch_array($resultDept)) {
       $REQUID = $HODivID = $row['uid'];
       $HODFullname = $row['Firstname'] . " " . $row['Surname'];
       $HODDIVName = $row['DivisionName'];
       $HODEmail = $row['Email'];
     }
if($HODivID == ""){ 
    $_SESSION['ErrMsg'] = "Division does not have head. Thanks";
    //header('Location: cashhodppor?pdfid='.$ReqCode);
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"] . "?pdfid=".$ReqCode);
    }
    exit; 
    }
//////////////////////////////////////////////////////////////////////////////
$sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $DeptHeadApp = $rowPOREQ['DeptHeadApp']; $DeptHeadAppDate = $rowPOREQ['DeptHeadAppDate']; $DeptHeadAppComment = $rowPOREQ['DeptHeadAppComment'];
     }

  if($DeptHeadAppComment != "")
     {
       $hodMSG =  '<div class="rcorners1">'.mysql_real_escape_string($DeptHeadAppComment).'  | <b>'.$DeptHeadAppDate.'</b></div> <br/> '. $hodMSG;
     }
//Update the rpo table
    mysql_query("UPDATE cashreq SET Approved='3', LastActor='Head of Department', Status='Approved', DivHeadApp='".$HODivID."', DeptHeadApp='".$uid."', ApprovedBy='".$staffname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
   /*mysql_query("UPDATE poreq SET Approved='2', LastActor='Head of Department', Status='Approved', DeptHeadApp='".$HODID."', ApprovedBy='".$HODFullname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE WHERE RequestID = '$ReqCode'");*/

//now we have to inform the HOD
require_approval_action_notification ($HODEmail, $HODFullname, $ReqCode, "Head of Division for " .$HODDIVName, $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [CASH REQUEST *** Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashdivppor?pdfid='.$pdfid;
		include('../notify.php');
        
        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$HODFullname." as [Head of Division] for [" .$HODDIVName ."]. Thanks";
//header('Location: cashhodppor?pdfid='.$ReqCode);
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"] . "?pdfid=".$ReqCode);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>