<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID = $uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];


$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG'])));  //
$ddofficer = mysql_real_escape_string(trim(strip_tags($_POST['ddofficer'])));  //ddofficer
$Role = mysql_real_escape_string(trim(strip_tags($_POST['role'])));  //ddofficer
$TodayD = date("Y-m-d h:i:s a");

//////////////APPROVAL DIVISION/////////////

$resultDD = mysql_query("SELECT * FROM users WHERE DeptID=11");
 while ($row = mysql_fetch_array($resultDD)) {
       $REQUID = $OffcierDD = $row['uid'];
       $OfficerDDNme = $row['Firstname'] . " " . $row['Surname']; ;

     }
////////////////////////////////////////////////////////////////////////////
 
 $isHOD = mysql_num_rows($resultDD); 
if($isHOD < 1 ) { 
    $_SESSION['ErrMsg'] = "No Staff in Due Dilligenc Office, contact HR. Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    //header('Location: cashdivppor?pdfid='.$ReqCode);
    exit; 
}

   
     

//////////////////////////////////////////////////////////////////////////////



//Update the rpo table
if($Role == "Head of Division")
{
    
    
     $sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
      $DivHeadAppDate = $rowPOREQ['DivHeadAppDate']; $DivHeadAppComment = $rowPOREQ['DivHeadAppComment'];
     }

  if($DivHeadAppComment != "")
     {
       $hodMSG =  '<div class="rcorners1">'.mysql_real_escape_string($DivHeadAppComment).'  | <b>'.$DivHeadAppDate.'</b></div> <br/> '. $hodMSG;
     }

    mysql_query("UPDATE cashreq SET Approved='7', LastActor='Head of Division', Status='Approved', DDOfficerApp='".$OffcierDD."', DivHeadApp='".$uid."', ApprovedBy='".$staffname."', DivHeadAppDate='".$TodayD."',  DivHeadAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}

if($Role == "Head of Department")
{
    
     $sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
      $DeptHeadAppDate = $rowPOREQ['DeptHeadAppDate']; $DeptHeadAppComment = $rowPOREQ['DeptHeadAppComment'];
     }

  if($DeptHeadAppComment != "")
     {
       $hodMSG =  '<div class="rcorners1">'.$DeptHeadAppComment.'  | <b>'.$DeptHeadAppDate.'</b></div> <br/> '. $hodMSG;
     }

    mysql_query("UPDATE cashreq SET Approved='7', LastActor='Head of Department', Status='Approved', DDOfficerApp='".$OffcierDD."', DeptHeadApp='".$uid."', ApprovedBy='".$staffname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}

   /*mysql_query("UPDATE poreq SET Approved='2', LastActor='Head of Department', Status='Approved', DeptHeadApp='".$HODID."', ApprovedBy='".$HODFullname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE WHERE RequestID = '$ReqCode'");*/

//now we have to inform the HOD
require_approval_action_notification ($GMEmail, $GMFullname, $ReqCode, "Officer for Due Dilligence", $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [CASH REQUEST *** Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashofficeddppor?pdfid='.$pdfid;
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$OfficerDDNme." as [Officer ] for [Due Dilligence]. Thanks";

if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//header('Location: cashdivppor?pdfid='.$ReqCode);
//close the connection
mysql_close($dbhandle);
exit;









?>