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
$sProduct = mysql_real_escape_string(trim(strip_tags($_POST['sProduct'])));
$CusProj = mysql_real_escape_string(trim(strip_tags($_POST['CusProj'])));
$ProdRef = mysql_real_escape_string(trim(strip_tags($_POST['ProdRef'])));
$ProdLine = mysql_real_escape_string(trim(strip_tags($_POST['ProdLine'])));
$ValueEst = mysql_real_escape_string(trim(strip_tags($_POST['ValueEst'])));
$KOStatus = mysql_real_escape_string(trim(strip_tags($_POST['KOStatus']))); 
$KOclose = mysql_real_escape_string(trim(strip_tags($_POST['KOclose']))); //integratedservice
$ARM = mysql_real_escape_string(trim(strip_tags($_POST['ARM']))); //integratedservice
$TodayD = date("Y-m-d h:i:sa");


//Let's just Update
$query = "INSERT INTO qmi_kops (ProductID, CusProj, ProdRef, ProdLine, ValueEst, KOStatus, KOclose, CreatedBy, Wk, Qtr, FirstDayOfWeek, DaysOfWeek, arm) 
VALUES ('$sProduct', '$CusProj','$ProdRef','$ProdLine','$ValueEst', '$KOStatus', '$KOclose', '$uid','$ReportWeek', '$ReportQtr', '$FirstWeekDay', '$DaysOfRtpWeek', '$ARM' );"; 

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