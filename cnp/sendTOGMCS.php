<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];


$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['ReqMSG']))); 
$TodayD = date("Y-m-d h:i:s a");

//////////////APPROVAL DIVISION/////////////
$resultDivMy = mysql_query("SELECT * FROM divisions WHERE GM =$uid");
 while ($row = mysql_fetch_array($resultDivMy)) {
       $MyDivNme = $row['DivisionName'];
     }
////////////////////////////////////////////////////////////////////////////
     //We need to get the GM of the Div now
$sql_res=mysql_query("SELECT * FROM divisions 
    INNER JOIN users ON divisions.GM = users.uid 
    WHERE divid =1"); //DeptID = '$DeptID' AND 

 $isHOD = mysql_num_rows($sql_res); 
if($isHOD < 1) { 
    $_SESSION['ErrMsg'] = "Coporate Services Division does not have GM configured, contact HR. Thanks";
    header('Location: hodppor?pdfid='.$ReqCode);
    exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
   // if($MyDIVID == $row['divid'])
    {
       $GMID = $row['uid'];
       $GMFullname = $row['Firstname'] . " " . $row['Surname'];
       $GMDIVName = $row['DivisionName'];
       $GMEmail = $row['Email'];
    }
   
     }

//////////////////////////////////////////////////////////////////////////////



//Update the rpo table
    mysql_query("UPDATE poreq SET Approved='4', LastActor='Head of Department [C&P]', Status='Approved', MgrApp='".$GMID."', DivHeadApp='".$uid."', ApprovedBy='".$staffname."', DivHeadAppDate='".$TodayD."',  DivHeadAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
   /*mysql_query("UPDATE poreq SET Approved='2', LastActor='Head of Department', Status='Approved', DeptHeadApp='".$HODID."', ApprovedBy='".$HODFullname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE WHERE RequestID = '$ReqCode'");*/

//now we have to inform the HOD
require_approval_action_notification ($GMEmail, $GMFullname, $ReqCode, "GM for " .$GMDIVName, $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://elshcon.space/requisition/mgcsppor?pdfid='.$pdfid;
		$Favicon = "https://www.elshcon.space/mBOOT/plant.png";
        
       
        $msg = '<!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="'.$Favicon.'">

        </head>
        <body style="margin:0px; font-family:Sans-serif, sans-serif; background:#D6D6D6;">
        <div style="padding:15px; background:#000033; font-size: 2em; color:#FFF; border-radius:7px;">
        <center>
        
        <center style="display:inline; font-weight:800;"> <img src="'.$Favicon.'" /> </center>
        </center>
        </div>
        <div style="padding:24px; margin:12px; margin-bottom:12px; font-size:15px; color:#8F8F8F; background:#E8E8E8; border-radius:7px;">
        Dear '.$fullnme.',<br /><br/> '.$msgBody.'<br/><br /> 
        <center>
        <a href="'.$msgLink.'" style="padding:12px; font-weight:600; text-decoration:none; background:#EC7600; color:#000033; border-radius:12px; cursor:pointer;">
        View Request </a>
        </center> 
        <br /> or copy and paste the link below in your browser <br />  '.$msgLink.' <br />
        <br /><br />Best Regards,<br />
        Support Team<br /> 
        Elshcon ERP<br /> 
        <br />
       

        </div> 
        <div style="padding:13px; background:#333333; font-size:11px; color:#F8F8F8; border-radius:7px;">
        <center style="font-size:11px;">
         &copy; 2018 Elshcon Nigeria Limited, the Elshcon logo, and Elshcon ERP 
        </center>  
         <center style="font-size:11px;">
         are registered trademarks of Elshcon Nigeria Limited 
        </center>  
         <center style="font-size:11px;">
         in Nigeria and/or other countries. All rights reserved. 
        </center>  
        </div>
        </body>
        </html>';

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$GMFullname." as [GM ] for [" .$GMDIVName ."]. Thanks";
header('Location: hodppor?pdfid='.$ReqCode);
//close the connection
mysql_close($dbhandle);
exit;









?>