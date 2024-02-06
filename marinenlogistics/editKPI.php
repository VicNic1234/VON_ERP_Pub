<?php
session_start();
include ('../DBcon/db_config.php');

  
$UID = $_SESSION['uid'];
$TDay = date("Y-m-d h:i:s a");


//Take Value from the two guys in index page KPI FORM
$kpiid = trim(strip_tags($_POST['kpiid']));
$KPIClass = trim(strip_tags($_POST['KPIClass']));
$KPINme = trim(strip_tags($_POST['KPINme']));

{

$query = "UPDATE hse_kpi SET kpi_name='$KPINme', class_name='$KPIClass' WHERE id='$kpiid'"; 


 if (mysql_query($query))
{
		$_SESSION['ErrMsgB'] = "Congratulations! New KPI is Updated";
        mysql_close($dbhandle);
		header('Location: hsekpi');  exit;
}
else
{
		$_SESSION['ErrMsg'] = "Error! Contact admin";
		header('Location: hsekpi'); exit;
}

}
//close the connection
mysql_close($dbhandle);




?>