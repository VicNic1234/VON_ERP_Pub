<?php
session_start();
include ('../DBcon/db_config.php');

$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$uid = $_SESSION['uid'];
$Dept = $_SESSION['DeptID'];

$desp = mysql_real_escape_string(trim(strip_tags($_POST['des'])));
$reqcat = mysql_real_escape_string(trim(strip_tags($_POST['reqcat']))); 
$rqid = mysql_real_escape_string(trim(strip_tags($_POST['rqid']))); 
$TodayD = date("Y-m-d h:i:s a");

$RECount = explode("-",$rqid); 
$RECount = intval(ltrim($RECount[2], '0')); 
$NewCount = intval($RECount) + 1;
//exit;
//Let's just Update
$query = "INSERT INTO ictreq (staffID, staffName, ItemDes, Purpose, RequestID, Deparment, RequestDate, Status) VALUES ('$uid','$staffname','$desp','$reqcat','$rqid', '$Dept', '$TodayD', 'Open' );"; 



if (mysql_query($query))
{
//echo mysql_error();
$_SESSION['ErrMsgB'] = "Request Sent To ICT!";
//Update Count
$sql_res=mysql_query("UPDATE sysvar SET variableValue='$NewCount' WHERE variableName = 'ICTCOUNT'");


///////////////////////////////////////
header('Location: ict');
exit;

}
else
{
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!";
header('Location: ict');
exit;
}


//close the connection
mysql_close($dbhandle);




?>