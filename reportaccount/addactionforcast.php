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
$ActionI = mysql_real_escape_string(trim(strip_tags($_POST['ActionI'])));
$ActionP = mysql_real_escape_string(trim(strip_tags($_POST['ActionP'])));
$ActionS = mysql_real_escape_string(trim(strip_tags($_POST['ActionS'])));
$ActionC = mysql_real_escape_string(trim(strip_tags($_POST['ActionC'])));
$TodayD = date("Y-m-d h:i:sa");


//Let's just Update
$query = "INSERT INTO actionforcast (ActionItem, ActionParty, ActionStatus, ActionComments, CreatedBy, Wk, Qtr, FirstDayOfWeek, DaysOfWeek) 
VALUES ('$ActionI','$ActionP','$ActionS','$ActionC','$uid','$ReportWeek', '$ReportQtr', '$FirstWeekDay', '$DaysOfRtpWeek' );"; 

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