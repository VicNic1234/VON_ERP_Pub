<?php
session_start();
include ('../DBcon/db_config.php');

$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$uid = $_SESSION['uid'];
$Dept = $_SESSION['Dept'];

$desp = trim(strip_tags($_POST['desp']));
$desp = str_replace("'", "&#8217", $desp);
$desp = str_replace('”', '&#8221', $desp);
$desp = str_replace('“', '&#8221', $desp);
$desp = str_replace('"', '&#8221', $desp);
$ppor = trim(strip_tags($_POST['ppor']));
$amt = trim(strip_tags($_POST['amt']));
$qnt = trim(strip_tags($_POST['qnt']));
$rqid = trim(strip_tags($_POST['rqid']));//rqid
$TodayD = date("Y/m/d h:i:sa");


//Let's just Update
$query = "INSERT INTO poreq (staffID, staffName, ItemDes, Purpose, Amount, Qty, RequestID, Deparment, RequestDate) VALUES ('$uid','$staffname','$desp','$ppor','$amt','$qnt', '$rqid', '$Dept', '$TodayD' );"; 

$result = mysql_query($query);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!";
header('Location: rpor');
exit;
}
else
{
$_SESSION['ErrMsgB'] = "PO Request Made!";
header('Location: rpor');
exit;
}


//close the connection
mysql_close($dbhandle);




?>