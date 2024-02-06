<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:s a");


$KPIClass = mysql_real_escape_string(trim(strip_tags($_POST['KPIClass'])));
$KPINme = mysql_real_escape_string(trim(strip_tags($_POST['KPINme'])));

if($KPIClass == "" || $KPINme == "" )
 { 
   $_SESSION['ErrMsg'] = "Kindly Complete details of new KPI";
header('Location: hsekpi');
exit;
 } 
 else 
 {

 	

 	$query = "INSERT INTO hse_kpi (kpi_name, class_name, isActive) 
    VALUES ('$KPINme', '$KPIClass',  1);";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New KPI is added";
header('Location: hsekpi');

 }



?>
