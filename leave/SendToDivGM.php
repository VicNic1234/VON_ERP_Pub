<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
//include ('../utility/notify.php');
include ('../emailsettings/emailSettings.php');

$TodayD = date("Y-m-d h:i:s a");

$StaffID = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];


$reqID = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$ReqMSG = mysql_real_escape_string(trim(strip_tags($_POST['ReqMSG'])));

$sql_res=mysql_query("SELECT * FROM empleave 
	LEFT JOIN department ON  empleave.Dept = department.id
    LEFT JOIN divisions ON  department.DivID = divisions.divid
	LEFT JOIN users ON divisions.GM = users.uid WHERE empleave.id='$reqID'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD > 0 ) { 
	while ($row = mysql_fetch_array($sql_res)) {
       $HODID = $row['uid'];
       $HODFullname = $row['Firstname'] . " " . $row['Surname'];
       $HODEmail = $row['Email'];
       $DIVID = $row['DivID'];

       $DivHAppComment = $row['DivHAppComment'];
	       $DivHAppDate = $row['DivHAppDate'];
     } 
}

if($DivHAppComment != "") { $ReqMSG = '<div class="rcorners1">'.$DivHAppComment.'  | <b>'.$DivHAppDate.'</b></div> <br/> '. $ReqMSG; }
//We need to know if this person is a DeptHead or DivHead or GM
if($DIVID == 1){
$resultLeave = mysql_query("UPDATE empleave SET DivHApp='$StaffID', DivHAppDate='$TodayD', DivHAppComment='$ReqMSG', GMApp='$HODID', Status='4' WHERE id = '".$reqID."'");
		require_approval_action_notification ($HODEmail, $HODFullname, $reqID, "GM Of Division"); 
}
else
{
    $resultLeave = mysql_query("UPDATE empleave SET DivHApp='$StaffID', DivHAppDate='$TodayD', DivHAppComment='$ReqMSG', GMApp='$HODID', Status='3' WHERE id = '".$reqID."'");
		require_approval_action_notification ($HODEmail, $HODFullname, $reqID, "GM Of Division"); 
}



//Lets sned the EMail here, No time
		function require_approval_action_notification ($email, $fullnme, $pdfid, $role)
		{
			
		       
		        $MsgTitle = "Elshcon ERP [Approved Leave by Head of Division]";
		        $GLOBALS['mail']->Subject = $MsgTitle;
		        $GLOBALS['mail']->AddAddress($email, $fullnme);
		       

		        $msgBody = 'Kindly check you leave Request on Elshcon ERP which requires your attention as ' .$role . ',<br/><br/><br/>';
		        $msgLink = 'https://www.elshcon.space/leave/gmleave';
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
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }



?>