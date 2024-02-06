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
$OP = mysql_real_escape_string(trim(strip_tags($_POST['OP'])));
$EAOP = mysql_real_escape_string(trim(strip_tags($_POST['EAOP'])));
$OB = mysql_real_escape_string(trim(strip_tags($_POST['OB'])));
$OBN = mysql_real_escape_string(trim(strip_tags($_POST['OBN'])));
$TodayD = date("Y-m-d h:i:sa");


//Let's just Update
$query = "INSERT INTO mkvps (OpportunityPipeline, EAOP, OrdersBookedYTD, OrdersNotBooked, CreatedBy, Wk, Qtr, FirstDayOfWeek, DaysOfWeek) 
VALUES ('$OP','$EAOP','$OB','$OBN','$uid','$ReportWeek', '$ReportQtr', '$FirstWeekDay', '$DaysOfRtpWeek' );"; 

$result = mysql_query($query);

if (!$result)
{
//echo mysql_error();
/*$_SESSION['ErrMsg'] = "Connection to Data Pool Error!";
header('Location: rpor');*/
echo "Connection to Data Pool Error!";
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