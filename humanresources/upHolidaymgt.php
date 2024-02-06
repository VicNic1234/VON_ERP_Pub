<?php
session_start();
include ('../DBcon/db_config.php');

$BusYear = trim(strip_tags($_POST['BusYear']));
$HDay = trim(strip_tags($_POST['HDay']));
$HTitle = trim(strip_tags($_POST['HTitle']));
$uID = trim(strip_tags($_POST['uID']));

if ( $uID == "" )
{
$_SESSION['ErrMsg'] = "Did not update!";
header('Location: holidaymgt');
exit;
}

//DeptmentID, BusYear, NWkDays, LeaveTitle

$query = "UPDATE holidaymgt SET BusYear='".$BusYear."', HolidayDay='".$HDay."', HolidayTitle='".$HTitle."' WHERE id='".$uID."'"; 

$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: leavemgt');
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! ".$HTitle . "' details Updated!";
header('Location: leavemgt');
}


//close the connection
mysql_close($dbhandle);




?>