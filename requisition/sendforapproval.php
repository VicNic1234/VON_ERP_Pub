<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
//include ('../utility/notify.php');
include ('../emailsettings/emailSettings.php');

$TodayD = date("Y-m-d h:i:s a");

$StaffID = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];



$reqID = $_GET['id'];

//We need to know if this person is a DeptHead or DivHead or GM
$sql_res=mysql_query("SELECT * FROM department LEFT JOIN users ON department.hod = users.uid WHERE department.id='$DeptID'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD > 0 ) { 
	while ($row = mysql_fetch_array($sql_res)) {
       $HODID = $row['uid'];
       $HODFullname = $row['Firstname'] . " " . $row['Surname'];
       $HODEmail = $row['Email'];
       $DIVID = $row['DivID'];
     } 
}

//Head of HR

$sql_hr=mysql_query("SELECT * FROM department LEFT JOIN users ON department.hod = users.uid WHERE department.id='5'");

$isHODHR = mysql_num_rows($sql_hr);
if($isHODHR > 0 ) { 
	while ($row = mysql_fetch_array($sql_hr)) {
       $HODHRID = $row['uid'];
       $HODHRFullname = $row['Firstname'] . " " . $row['Surname'];
       $HODHREmail = $row['Email'];
     } 
}

///HEAD OF DIVISION
{
	$sql_div=mysql_query("SELECT * FROM divisions LEFT JOIN users ON divisions.DH = users.uid WHERE divisions.divid='$DIVID'");

	$isDivH = mysql_num_rows($sql_div);
	if($isDivH > 0 ) { 
		while ($row = mysql_fetch_array($sql_div)) {
	       $HDivID = $row['uid'];
	       $HDivFullname = $row['Firstname'] . " " . $row['Surname'];
	       $HDivEmail = $row['Email'];
	     } 
	}
}

///MY GM
{
	$sql_div=mysql_query("SELECT * FROM divisions LEFT JOIN users ON divisions.GM = users.uid WHERE divisions.divid='$DIVID'");

	$isDivH = mysql_num_rows($sql_div);
	if($isDivH > 0 ) { 
		while ($row = mysql_fetch_array($sql_div)) {
	       $GMID = $row['uid'];
	       $GMFullname = $row['Firstname'] . " " . $row['Surname'];
	       $GMEmail = $row['Email'];
	     } 
	}
}

///GM CS
{
	$sql_div=mysql_query("SELECT * FROM divisions LEFT JOIN users ON divisions.GM = users.uid WHERE divisions.divid='1'");

	$isDivH = mysql_num_rows($sql_div);
	if($isDivH > 0 ) { 
		while ($row = mysql_fetch_array($sql_div)) {
	       $GMCSID = $row['uid'];
	       $GMCSFullname = $row['Firstname'] . " " . $row['Surname'];
	       $GMCSEmail = $row['Email'];
	     } 
	}
}


//if GM, send to HR
if($StaffID == $GMID)
{
	$resultLeave = mysql_query("UPDATE empleave SET GMApp='$StaffID', GMAppDate='$TodayD', GMAppComment='My Request', Status='5' WHERE id = '".$reqID."'");
		require_approval_action_notification ($HODHREmail, $HODHRFullname, $reqID, "HOD of HR", "hrleave?id=".$reqID); 
}
elseif($StaffID == $HDivID)
{
	$resultLeave = mysql_query("UPDATE empleave SET DivHApp='$StaffID', DivHAppDate='$TodayD', DivHAppComment='My Request', GMApp='$GMID', Status='3' WHERE id = '".$reqID."'");
		require_approval_action_notification ($HDivEmail, $HDivFullname, $reqID, "GM of Division", "gmleave?id=".$reqID);
}
elseif($StaffID == $HODID && $DIVID == 1)
{
	$resultLeave = mysql_query("UPDATE empleave SET HODApp='$StaffID', HODAppDate='$TodayD', HODAppComment='My Request', DivHApp='$HDivID', Status='5' WHERE id = '".$reqID."'");
		require_approval_action_notification ($HODHREmail, $HODHRFullname, $reqID, "HOD of HR", "hrleave?id=".$reqID); 
}
elseif($StaffID == $HODID)
{
	$resultLeave = mysql_query("UPDATE empleave SET HODApp='$StaffID', HODAppDate='$TodayD', HODAppComment='My Request', DivHApp='$HDivID', Status='2' WHERE id = '".$reqID."'");
		require_approval_action_notification ($HODID, $HODFullname, $reqID, "Head of Division", "divleave?id=".$reqID);
}
else
{
	$resultLeave = mysql_query("UPDATE empleave SET UserApp='$StaffID', UserAppDate='$TodayD', UserAppComment='My Request', HODApp='$HODID',  Status='1' WHERE id = '".$reqID."'");
		require_approval_action_notification ($HODEmail, $HODFullname, $reqID, "Head of Department", "deptleave?id=".$reqID);
}



//Lets sned the EMail here, No time
		function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $link)
		{
			
		       
		        $MsgTitle = "Elshcon ERP [Leave Request. Awaiting your approval]";
		        $GLOBALS['mail']->Subject = $MsgTitle;
		        $GLOBALS['mail']->AddAddress($email, $fullnme);
		       

		        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/><br/><em>For Leave Request</em>';
		        $msgLink = 'https://www.elshcon.space/leave/'.$link;
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
header("Location: myleave");


?>