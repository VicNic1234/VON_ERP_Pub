<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$UID = $_SESSION['uid'];

$MID = mysql_real_escape_string(trim(strip_tags($_GET['id'])));


if($MID == "" )
 { 
   	$_SESSION['ErrMsg'] = "Kindly Select Invoice";
	if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
 } 
 else 
 {
 	//Check if exist
 	$query = "UPDATE  vendorsinvoices SET Paid = 3, PaidOn='$DateG', PaidBy='$UID' WHERE cid='$MID'";

    mysql_query($query, $dbhandle);

  
$_SESSION['ErrMsgB'] = "Congratulations! Paid";
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

 }


exit;


?>
