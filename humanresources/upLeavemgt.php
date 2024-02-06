<?php
session_start();
include ('../DBcon/db_config.php');

$BusYear = trim(strip_tags($_POST['BusYear']));
$WkDays = trim(strip_tags($_POST['WkDays']));
$LvTl = trim(strip_tags($_POST['LvTl']));
$DeptU = trim(strip_tags($_POST['DeptU']));
$uID = trim(strip_tags($_POST['uID']));

if ( $uID == "" )
{
$_SESSION['ErrMsg'] = "Did not update!";
header('Location: leavemgt');
exit;
}

//DeptmentID, BusYear, NWkDays, LeaveTitle

$query = "UPDATE leavemgt SET DeptmentID='".$DeptU."', BusYear='".$BusYear."', NWkDays='".$WkDays."', LeaveTitle='".$LvTl."' WHERE id='".$uID."'"; 



$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: leavemgt');
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! ".$LvTl . "' Leave Group details Updated!";
header('Location: leavemgt');
}


//close the connection
mysql_close($dbhandle);




?>