<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
//include ('../utility/notify.php');
include ('../emailsettings/emailSettings.php');

$TodayD = date("Y-m-d h:i:s a");

$SNDUID =$StaffID = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];



$reqID = $_GET['id'];

$sql_res=mysql_query("SELECT * FROM empleave 
	LEFT JOIN department ON  empleave.Dept = department.id
    LEFT JOIN divisions ON  department.DivID = divisions.divid
	LEFT JOIN users ON divisions.DH = users.uid WHERE empleave.id='$reqID'");

$isHOD = mysql_num_rows($sql_res);
if($isHOD > 0 ) { 
	while ($row = mysql_fetch_array($sql_res)) {
       $HODID = $row['uid'];
       $REQUID = $row['uid'];
       
       $HODFullname = $row['Firstname'] . " " . $row['Surname'];
       $HODEmail = $row['Email'];
       $DIVID = $row['DivID'];
     } 
}

//We need to know if this person is a DeptHead or DivHead or GM
$resultLeave = mysql_query("UPDATE empleave SET HODApp='$StaffID', HODAppDate='$TodayD', HODAppComment='Approved', DivHApp='$HODID', Status='2' WHERE id = '".$reqID."'");
		require_approval_action_notification ($HODEmail, $HODFullname, $reqID, "Head Of Division"); 




//Lets sned the EMail here, No time
		function require_approval_action_notification ($email, $fullnme, $pdfid, $role)
		{
			
		       
		        $MsgTitle = "Elshcon ERP [Approved by Head of Dept Leave]";
		        $GLOBALS['mail']->Subject = $MsgTitle;
		        $GLOBALS['mail']->AddAddress($email, $fullnme);
		       

		        $msgBody = 'Kindly check you leave Request on Elshcon ERP which requires your attention as ' .$role . ',<br/><br/><br/>';
		        $msgLink = 'https://www.elshcon.space/leave/divleave';
				include('../notify.php');
				
		        $GLOBALS['mail']->Body = $msg;      //HTML Body
		      
		   
		        $GLOBALS['mail']->Send();
		}

     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }


?>