<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$UID = $_SESSION['uid'];

$BANKGL = mysql_real_escape_string(trim(strip_tags($_POST['BANKGL'])));
$ChqNo = mysql_real_escape_string(trim(strip_tags($_POST['ChqNo'])));
$ChqAmt = mysql_real_escape_string(trim(strip_tags($_POST['ChqAmt'])));
$ChqDate = mysql_real_escape_string(trim(strip_tags($_POST['ChqDate'])));
$TranType = mysql_real_escape_string(trim(strip_tags($_POST['TranType'])));


if($BANKGL == "" || $ChqNo == "" || $ChqAmt == "" || $ChqDate == "")
 { 
   	$_SESSION['ErrMsg'] = "Kindly fill form completely ";
	if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM reciepts WHERE cheuqeNME='$ChqNo'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Reciept already exist";
		if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
		exit;
	 } 

 	$query = "INSERT INTO reciepts (cheuqeNME, TranType, Bank, Amt, CreatedBy, CreatedOn, TDate, isActive) 
VALUES ('$ChqNo', '$TranType', '$BANKGL', '$ChqAmt', '$UID', '$DateG', '$ChqDate', 1);";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Reciept is added";
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

 }


exit;


?>
