<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$UID = $_SESSION['uid'];


$CompanyRegNo = mysql_real_escape_string(trim(strip_tags($_POST['CompanyRegNo'])));
$TAXTINNo = mysql_real_escape_string(trim(strip_tags($_POST['TAXTINNo'])));
$NHFNo = mysql_real_escape_string(trim(strip_tags($_POST['NHFNo'])));
$NHISNo = mysql_real_escape_string(trim(strip_tags($_POST['NHISNo'])));
$ITFLevyNo = mysql_real_escape_string(trim(strip_tags($_POST['ITFLevyNo'])));
$NSITFNo = mysql_real_escape_string(trim(strip_tags($_POST['NSITFNo'])));
$commtype1 = mysql_real_escape_string(trim(strip_tags($_POST['commtype1'])));

/*
if($ChqNo == "" || $cid == "")
 { 
   	$_SESSION['ErrMsg'] = "Kindly fill form completely ";
	if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
 } 
 else */
 {
 

	 //echo $cid; exit;

 	$query = "UPDATE payrollsettings SET CompanyRegNo='$CompanyRegNo', TAXTINNo='$TAXTINNo', NHFNo='$NHFNo', NHISNo='$NHISNo', ITFLevyNo='$ITFLevyNo', NSITFNo='$NSITFNo', ProRataCal='$commtype1' WHERE pyid='1'";

      mysql_query($query, $dbhandle);
     $_SESSION['ErrMsgB'] = "Congratulations! Updated";
     if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }

 }


exit;


?>
