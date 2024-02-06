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

$sql_hr=mysql_query("SELECT * FROM department LEFT JOIN users ON department.hod = users.uid WHERE department.id='5'");

$isHODHR = mysql_num_rows($sql_hr);
if($isHODHR > 0 ) { 
	while ($row = mysql_fetch_array($sql_hr)) {
       $REQUID = $row['uid'];
       $HODHRID = $row['uid']; 
       $HODHRFullname = $row['Firstname'] . " " . $row['Surname'];
       $HODHREmail = $row['Email'];
     } 
}

//We need to know if this person is a DeptHead or DivHead or GM
$resultLeave = mysql_query("UPDATE empleave SET GMApp='$StaffID', GMAppDate='$TodayD', GMAppComment='Approved', HRApp='$HODHRID', Status='5' WHERE id = '".$reqID."'");
		require_approval_action_notification ($HODHRID, $HODHRFullname, $reqID, "Head Of HR"); 




//Lets sned the EMail here, No time
		function require_approval_action_notification ($email, $fullnme, $pdfid, $role)
		{
			
		       
		        $MsgTitle = "Elshcon ERP [Approved by GM of Division Leave]";
		        $GLOBALS['mail']->Subject = $MsgTitle;
		        $GLOBALS['mail']->AddAddress($email, $fullnme);
		       

		        $msgBody = 'Kindly check you leave Request on Elshcon ERP which requires your attention as ' .$role . ',<br/><br/><br/>';
		        $msgLink = 'https://www.elshcon.space/leave/hrleave';
				
				include('../notify.php');

		        $GLOBALS['mail']->Body = $msg;      //HTML Body
		      
		   
		        $GLOBALS['mail']->Send();
		}
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }


?>