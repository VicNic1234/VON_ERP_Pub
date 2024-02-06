<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID =$uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];


$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$accID = mysql_real_escape_string(trim(strip_tags($_POST['accID'])));
//HODCS
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG']))); 
$TodayD = date("Y-m-d h:i:s a");

//////////////APPROVAL DIVISION/////////////
$resultDivMy = mysql_query("SELECT * FROM divisions WHERE GM =$uid");
 while ($row = mysql_fetch_array($resultDivMy)) {
       $MyDivNme = $row['DivisionName'];
     }
     
     
    /////////\********************************************
             /*  $_SESSION['Msg'] = "Sent to Due Dilligence Officer. GM CS Out of Office!";
               
               /////\******************************************
               $url = 'https://www.elshcon.space/requisition/sendTOOfficierDD.php';
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
                */
         
//////////////\**********************************************
     //We need to get the GM of the Div now
$sql_res=mysql_query("SELECT * FROM divisions 
    INNER JOIN users ON divisions.GM = users.uid 
    WHERE divid =1"); //DeptID = '$DeptID' AND 

 $isHOD = mysql_num_rows($sql_res); 
if($isHOD < 1) { 
   // $_SESSION['ErrMsg'] = "Coporate Services Division does not have GM configured, contact HR. Thanks";
   
    $_SESSION['Msg'] = "Sent to Due Dilligence Officer. GM CS Out of Office!";
               
               /////\******************************************
               $url = 'https://www.elshcon.space/requisition/sendTOOfficierDD.php';
                $myvars = 'ReqCode=' . $ReqCode . '&hodMSG=' . $hodMSG;
                
                $ch = curl_init( $url );
                curl_setopt( $ch, CURLOPT_POST, 1);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch, CURLOPT_HEADER, 0);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
                
                $response = curl_exec( $ch );
    /////////////////////////////////////////////
    //header('Location: divppor?pdfid='.$ReqCode);
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
   // if($MyDIVID == $row['divid'])
    {
       $GMID = $row['uid'];
       $REQUID = $row['uid'];
       $GMFullname = $row['Firstname'] . " " . $row['Surname'];
       $GMDIVName = $row['DivisionName'];
       $GMEmail = $row['Email'];
    }
   
     }

//////////////////////////////////////////////////////////////////////////////
$sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $UserApp = $rowPOREQ['UserApp'];


       $CPAppDate = $rowPOREQ['CPAppDate'];
       $CPAppComment = $rowPOREQ['CPAppComment'];

     }


     if($CPAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$CPAppComment.'  | <b>'.$CPAppDate.'</b></div> <br/> '. $hodMSG;
             }

if($accID == "HODCP")
{

//Update the rpo table
    mysql_query("UPDATE poreq SET Approved='6', LastActor='C & P', Status='Approved', CSApp='".$GMID."', CPApp='".$uid."', ApprovedBy='".$staffname."', CPAppDate='".$TodayD."',  CPAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
   /*mysql_query("UPDATE poreq SET Approved='2', LastActor='Head of Department', Status='Approved', DeptHeadApp='".$HODID."', ApprovedBy='".$HODFullname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE WHERE RequestID = '$ReqCode'");*/
}
else
{
    mysql_query("UPDATE poreq SET Approved='6', LastActor='GM of Department', Status='Approved', CSApp='".$GMID."', MgrApp='".$uid."', ApprovedBy='".$staffname."', MgrAppDate='".$TodayD."',  MgrAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}
//now we have to inform the HOD
require_approval_action_notification ($GMEmail, $GMFullname, $ReqCode, "GM for " .$GMDIVName, $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/gmcsppor?pdfid='.$pdfid;
		include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$GMFullname." as [GM ] for [" .$GMDIVName ."]. Thanks";
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>