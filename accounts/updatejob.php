<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$UID = $_SESSION['uid'];

//$BANKGL = mysql_real_escape_string(trim(strip_tags($_POST['BANKGL'])));
$ChqNo = mysql_real_escape_string(trim(strip_tags($_POST['ChqNo'])));
$cid = mysql_real_escape_string(trim(strip_tags($_POST['cid'])));
//$ChqAmt = mysql_real_escape_string(trim(strip_tags($_POST['ChqAmt'])));
$ChqDate = mysql_real_escape_string(trim(strip_tags($_POST['ChqDate'])));

if($ChqNo == "" || $cid == "")
 { 
   	$_SESSION['ErrMsg'] = "Kindly fill form completely ";
	if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM jobs WHERE cheuqeNME='$ChqNo' AND chid <> '$cid");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Job with same title already exist";
		if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
		exit;
	 } 
	 
	 //echo $cid; exit;

 	$query = "UPDATE jobs SET cheuqeNME='$ChqNo', TDate='$ChqDate' WHERE chid='$cid'";

mysql_query($query, $dbhandle);
  
$_SESSION['ErrMsgB'] = "Congratulations! Job is Updated";
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

 }


exit;


?>
