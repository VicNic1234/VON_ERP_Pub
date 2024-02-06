<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID = $uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];


$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG']))); 
$role = mysql_real_escape_string(trim(strip_tags($_POST['role']))); 
$TodayD = date("Y-m-d h:i:s a");

//////////////APPROVAL DIVISION/////////////
$sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $DeptID = $DeparmentID = $rowPOREQ['Deparment'];
     }
////////////////////////////////////////////////////////////////////////////
     //We need to get the GM of the Div now
$sql_res=mysql_query("SELECT * FROM department LEFT JOIN divisions ON department.DivID = divisions.divid
    INNER JOIN users ON divisions.GM = users.uid 
    WHERE department.id ='".$DeptID."'"); //DeptID = '$DeptID' AND 

 $isHOD = mysql_num_rows($sql_res); 
 /*
if($isHOD < 1) {
    
    /////////////////////////\
    while ($rowGMCHK = mysql_fetch_array($sql_res)) {
           if($rowGMCHK['divid'] == 1) { 
               $_SESSION['Msg'] = "Sent to Due Dilligence Officer. GM CS Out of Office!";
               
               /////\******************************************
               $url = 'https://www.elshcon.space/requisition/cashsendTOOfficierDD.php';
                $myvars = 'ReqCode=' . $ReqCode . '&hodMSG=' . $hodMSG;
                
                $ch = curl_init( $url );
                curl_setopt( $ch, CURLOPT_POST, 1);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch, CURLOPT_HEADER, 0);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
                
                $response = curl_exec( $ch );
               /////\******************************************
               if (isset($_SERVER["HTTP_REFERER"])) {
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                }
                exit;
           }
     }
    ///////////////////////////////
    $_SESSION['ErrMsg'] = "Your Division does not have GM configured, contact HR. Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit; 
} */

$REQUID = 0;
while ($row = mysql_fetch_array($sql_res)) {
   // if($MyDIVID == $row['divid'])
    {
      $REQUID =  $GMDD = $row['uid']; 
       $GMFullname = $row['Firstname'] . " " . $row['Surname'];
       $GMDIVName = $row['DivisionName'];
       $GMEmail = $row['Email'];
    }
   
     }
     
     if($REQUID < 1) {
        goto bypass;
    }

//////////////////////////////////////////////////////////////////////////////
if($role != "HOD")
{
$sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $DivHeadApp = $rowPOREQ['DivHeadApp']; $DivHeadAppDate = $rowPOREQ['DivHeadAppDate']; $DivHeadAppComment = $rowPOREQ['DivHeadAppComment']; $DeparmentID = $rowPOREQ['Deparment'];
     }

  if($DivHeadAppComment != "")
     {
       $hodMSG =  '<div class="rcorners1">'.$DivHeadAppComment.'  | <b>'.$DivHeadAppDate.'</b></div> <br/> '. $hodMSG;
     }

//Update the rpo table
    mysql_query("UPDATE cashreq SET Approved='4', LastActor='Head of Division', Status='Approved', MgrApp='".$GMDD."', DivHeadApp='".$uid."', ApprovedBy='".$staffname."', DivHeadAppDate='".$TodayD."',  DivHeadAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
   /*mysql_query("UPDATE poreq SET Approved='2', LastActor='Head of Department', Status='Approved', DeptHeadApp='".$HODID."', ApprovedBy='".$HODFullname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE WHERE RequestID = '$ReqCode'");*/
}
else
{
    $sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $DeptHeadApp = $rowPOREQ['DeptHeadApp']; $DeptHeadAppDate = $rowPOREQ['DeptHeadAppDate']; $DeptHeadAppComment = $rowPOREQ['DeptHeadAppComment'];
     }

  if($DeptHeadAppComment != "")
     {
       $hodMSG =  '<div class="rcorners1">'.mysql_real_escape_string($DeptHeadAppComment).'  | <b>'.$DeptHeadAppDate.'</b></div> <br/> '. $hodMSG;
     }

//Update the rpo table
    mysql_query("UPDATE cashreq SET Approved='4', LastActor='Head of Department', Status='Approved', MgrApp='".$GMDD."', DeptHeadApp='".$uid."', ApprovedBy='".$staffname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}
//now we have to inform the HOD
require_approval_action_notification ($GMEmail, $GMFullname, $ReqCode, "GM for " .$GMDIVName, $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [CASH REQUEST *** Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashgmppor?pdfid='.$pdfid;
		include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}


///////////////////////////////////////


/////////////////*****************

$_SESSION['ErrMsgB'] = "Your request have been moved to ".$GMFullname." as [GM ] for [" .$GMDIVName ."]. Thanks";
 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
exit;


//////////////////************************************///////////////////////////////////////////////
bypass:
  //  echo "Ok";
  //  exit;
    $sql_res=mysql_query("SELECT * FROM divisions 
    INNER JOIN users ON divisions.GM = users.uid 
    WHERE divid =3"); //DeptID = '$DeptID' AND 

 $isHOD = mysql_num_rows($sql_res); 
if($isHOD < 1) { 
    $_SESSION['ErrMsg'] = "Due Dilligence Division does not have GM configured, contact HR. Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
   // if($MyDIVID == $row['divid'])
    {
       $REQUID  = $GMDD = $row['uid'];
       $GMFullname = $row['Firstname'] . " " . $row['Surname'];
       $GMDIVName = $row['DivisionName'];
       $GMEmail = $row['Email'];
    }
   
     }

//////////////////////////////////////////////////////////////////////////////
$sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
      $DDOfficerAppDate = $rowPOREQ['DDOfficerAppDate']; $DDOfficerAppComment = $rowPOREQ['DDOfficerAppComment'];
     }

  if($DDOfficerAppComment != "")
     {
       $hodMSG =  '<div class="rcorners1">'.mysql_real_escape_string($DDOfficerAppComment).'  | <b>'.$DDOfficerAppDate.'</b></div> <br/> '. $hodMSG;
     }


//Update the rpo table
    mysql_query("UPDATE cashreq SET Approved='8', LastActor='DD Officer', Status='Approved', DDApp='".$GMDD."', DDOfficerApp='".$uid."', ApprovedBy='".$staffname."', DDOfficerAppDate='".$TodayD."',  DDOfficerAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
   /*mysql_query("UPDATE poreq SET Approved='2', LastActor='Head of Department', Status='Approved', DeptHeadApp='".$HODID."', ApprovedBy='".$HODFullname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE WHERE RequestID = '$ReqCode'");*/

//now we have to inform the HOD
require_approval_action_notificationmm ($GMEmail, $GMFullname, $ReqCode, "GM for " .$GMDIVName, $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notificationmm ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [CASH REQUEST *** Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashmgddppor?pdfid='.$pdfid;
		include('../notify.php');
        
        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$GMFullname." as [GM ] for [" .$GMDIVName ."]. Thanks";
 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
///////////////////////////*************************************////////////////////////////////////////
//close the connection
mysql_close($dbhandle);
exit;











?>