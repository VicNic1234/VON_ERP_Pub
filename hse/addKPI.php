<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:s a");


$KPINme = mysql_real_escape_string(trim(strip_tags($_POST['KPINme'])));
$KPIDate = mysql_real_escape_string(trim(strip_tags($_POST['KPIDate'])));
$KPIData = mysql_real_escape_string(trim(strip_tags($_POST['KPIData'])));

if($KPIData == "" || $KPINme == "" )
 { 
   $_SESSION['ErrMsg'] = "Kindly Complete details of new KPI";
header('Location: reckpi');
exit;
 } 
 else 
 {

 	

 	$query = "INSERT INTO hse_kpi_data (kpi_name, kpi_date, kpi_data, isActive) 
    VALUES ('$KPINme', '$KPIDate', '$KPIData',  1);";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New KPI is added";
header('Location: reckpi');

 }



?>
