<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$UID = $_SESSION['uid'];


$PostGL = mysql_real_escape_string(trim(strip_tags($_POST['PostGL'])));
$PostDesc = mysql_real_escape_string(trim(strip_tags($_POST['PostDesc'])));
$PostRemark = mysql_real_escape_string(trim(strip_tags($_POST['PostRemark'])));
$PostDate = mysql_real_escape_string(trim(strip_tags($_POST['PostDate']))); 
$PostAmt = mysql_real_escape_string(trim(strip_tags($_POST['PostAmt'])));
$ReceivedBy = mysql_real_escape_string(trim(strip_tags($_POST['ReceivedBy'])));
$PID = mysql_real_escape_string(trim(strip_tags($_POST['PID']))); 


if($PID == "" || $PostGL == "")
 { 
   	$_SESSION['ErrMsg'] = "Kindly fill form completely ";
	if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
 } 
 else 
 {
 
	 //echo $cid; exit;
    $Log = "Update On ".$DateG." by ". $UID;
 	$query = "UPDATE postings1 SET GLImpacted='$PostGL', GLDescription='$PostGL', Remark='$PostRemark',  TransactionAmount='$PostAmt', TransactionDate='$PostDate', isActive='1', UpdateLog='$Log', ReceivedBy='$ReceivedBy'
 	WHERE tncid='$PID'";

if (mysql_query($query, $dbhandle))
  {
$_SESSION['ErrMsgB'] = "Congratulations! Posting is Update";
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    
 }
 else
 {
     echo mysql_error();
 }

 }


exit;


?>
