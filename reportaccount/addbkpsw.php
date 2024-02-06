<?php
session_start();
include ('../DBcon/db_config.php');

//$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$uid = $_SESSION['uid'];
$Dept = $_SESSION['Dept'];


$ReportWeek = mysql_real_escape_string(trim(strip_tags($_POST['ReportWeek'])));
$ReportQtr = mysql_real_escape_string(trim(strip_tags($_POST['ReportQtr'])));
$FirstWeekDay = mysql_real_escape_string(trim(strip_tags($_POST['FirstWeekDay'])));
$DaysOfRtpWeek = mysql_real_escape_string(trim(strip_tags($_POST['DaysOfRtpWeek'])));
$SSOP = mysql_real_escape_string(trim(strip_tags($_POST['SSOP'])));
$BOOP = mysql_real_escape_string(trim(strip_tags($_POST['BOOP'])));
$FOOP = mysql_real_escape_string(trim(strip_tags($_POST['FOOP'])));
$APOP = mysql_real_escape_string(trim(strip_tags($_POST['APOP'])));
$RePO = mysql_real_escape_string(trim(strip_tags($_POST['RePO']))); 

$SSEstVal = mysql_real_escape_string(trim(strip_tags($_POST['SSEstVal']))); 
$BOEstVal = mysql_real_escape_string(trim(strip_tags($_POST['BOEstVal']))); 
$FOEstVal = mysql_real_escape_string(trim(strip_tags($_POST['FOEstVal']))); 
$APEstVal = mysql_real_escape_string(trim(strip_tags($_POST['APEstVal']))); 
$ReEstVal = mysql_real_escape_string(trim(strip_tags($_POST['ReEstVal']))); 
$TodayD = date("Y-m-d h:i:sa");


//Let's just Update
$query = "INSERT INTO breakdowninsales (SourcingStageNOP, SourcingStageEstValue, BudgetaryOfferNOP, BudgetaryOfferEstValue, FirmOfferNOP, FirmOfferEstValue, AnticipatingPOsNOP, AnticipatingPOsEstValue, ReceivedPOsNOP, ReceivedPOsEstValue, CreatedBy, Wk, Qtr, FirstDayOfWeek, DaysOfWeek) 
VALUES ('$SSOP', '$SSEstVal','$BOOP','$BOEstVal','$FOOP','$FOEstVal','$APOP','$APEstVal', '$RePO','$ReEstVal', '$uid','$ReportWeek', '$ReportQtr', '$FirstWeekDay', '$DaysOfRtpWeek' );"; 

$result = mysql_query($query);

if (!$result)
{
echo mysql_error();
/*$_SESSION['ErrMsg'] = "Connection to Data Pool Error!";
header('Location: rpor');*/
//echo "Connection to Data Pool Error!";
exit;
}
else
{
/*$_SESSION['ErrMsgB'] = "PO Request Made!";
header('Location: rpor');*/
echo "Reported!";
exit;
}


//close the connection
mysql_close($dbhandle);




?>