<?php
session_start();
include ('../DBcon/db_config.php');

$Bname = mysql_real_escape_string(trim(strip_tags($_POST['Bnme'])));
$GMDiv = mysql_real_escape_string(trim(strip_tags($_POST['GMDiv'])));
$HDiv = mysql_real_escape_string(trim(strip_tags($_POST['HDiv'])));
$uID = mysql_real_escape_string(trim(strip_tags($_POST['uID'])));
//$DeptU = trim(strip_tags($_POST['DeptU']));

if ( $uID == "" )
{
$_SESSION['ErrMsg'] = "Did not update!";
header('Location: aDiv');
exit;
}



$query = "UPDATE divisions SET DivisionName='".$Bname."', GM='".$GMDiv."', DH='".$HDiv."' WHERE divid='".$uID."'"; 



$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: aDiv');
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! ".$Bname . "' info details Updated!";
header('Location: aDiv');
}


//close the connection
mysql_close($dbhandle);




?>