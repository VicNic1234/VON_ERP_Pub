<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:s a");
$UID = $_SESSION['uid'];

$EquipID = mysql_real_escape_string(trim(strip_tags($_POST['EquipNme'])));
$CaliDate = mysql_real_escape_string(trim(strip_tags($_POST['CaliDate'])));
$DueDate = mysql_real_escape_string(trim(strip_tags($_POST['DueDate'])));
$CalibratedBy = mysql_real_escape_string(trim(strip_tags($_POST['CalibratedBy'])));
$AnalysisBy = mysql_real_escape_string(trim(strip_tags($_POST['AnalysisBy'])));
$Comment = mysql_real_escape_string(trim(strip_tags($_POST['Comment'])));

if($EquipID == "" || $CalibratedBy == "" )
 { 
	   $_SESSION['ErrMsg'] = "Kindly Complete details of new Data";
	   header('Location: calilog');
	   exit;
 } 
 else 
 {

 	

 	$query = "INSERT INTO calibration_log (equipid, calibratedby, calibratedon, analysisby, duedate, comment, recdate, recby) 
    VALUES ('$EquipID', '$CalibratedBy', '$CaliDate', '$AnalysisBy', '$DueDate', '$Comment', '$DateG', '$UID');";

	mysql_query($query);
	  
	$_SESSION['ErrMsgB'] = "Congratulations! New Record is added";
	header('Location: calilog');

 }



?>
