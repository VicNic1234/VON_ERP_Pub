<?php
session_start();
include ('../DBcon/db_config.php');

  
$UID = $_SESSION['uid'];
$TDay = date("Y-m-d h:i:s a");


//Take Value from the two guys in index page JHA FORM
$KPIDATAID = trim(strip_tags($_GET['id']));

$AuditLog = "Deleted By : ".$UID. " On : ".$TDay;

{

$query = "UPDATE hse_kpi_data SET isActive=0, AuditLog='$AuditLog' WHERE id='$KPIDATAID'"; 


 if (mysql_query($query))
{
		$_SESSION['ErrMsgB'] = "KPI Data is Deleted";
        mysql_close($dbhandle);
		header('Location: reckpi');  exit;
}
else
{
		$_SESSION['ErrMsg'] = "Error! Contact admin";
		header('Location: reckpi'); exit;
}

}
//close the connection
mysql_close($dbhandle);




?>