<?php
session_start();
include ('../DBcon/db_config.php');

  
$UID = $_SESSION['uid'];
$TDay = date("Y-m-d h:i:s a");


//Take Value from the two guys in index page KPI FORM
$ppeid = trim(strip_tags($_POST['ppeid']));
$PPENme = trim(strip_tags($_POST['PPENme']));

{

$query = "UPDATE ppe_kit SET ppe_name='$PPENme' WHERE id='$ppeid'"; 


 if (mysql_query($query))
{
		$_SESSION['ErrMsgB'] = "Congratulations! PPE is Updated";
        mysql_close($dbhandle);
		header('Location: ppekit');  exit;
}
else
{
		$_SESSION['ErrMsg'] = "Error! Contact admin";
		header('Location: ppekit'); exit;
}

}
//close the connection
mysql_close($dbhandle);




?>