<?php
session_start();
include ('../DBcon/db_config.php');

  
$UID = $_SESSION['uid'];
$TDay = date("Y-m-d h:i:s a");


//Take Value from the two guys in index page JHA FORM
$KPIDATAID = trim(strip_tags($_GET['id']));

$AuditLog = "Deleted By : ".$UID. " On : ".$TDay;

{

$query = "UPDATE calibration_log SET isActive=0, AuditLog='$AuditLog' WHERE calid='$KPIDATAID'"; 


 if (mysql_query($query))
{
		$_SESSION['ErrMsgB'] = "Record is Deleted";
        mysql_close($dbhandle);
		header('Location: calilog');  exit;
}
else
{
		$_SESSION['ErrMsg'] = "Error! Contact admin";
		header('Location: calilog'); exit;
}

}
//close the connection
mysql_close($dbhandle);




?>