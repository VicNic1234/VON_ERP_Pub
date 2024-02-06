<?php
session_start();
include ('../DBcon/db_config.php');

$Bname = mysql_real_escape_string(trim(strip_tags($_POST['Bnme'])));
$BDes = mysql_real_escape_string(trim(strip_tags($_POST['BDes'])));
$uID = mysql_real_escape_string(trim(strip_tags($_POST['uID'])));
//$DeptU = trim(strip_tags($_POST['DeptU']));

if ( $uID == "" )
{
$_SESSION['ErrMsg'] = "Did not update!";
header('Location: aDept');
exit;
}



$query = "UPDATE businessunit SET BussinessUnit='".$Bname."', Descript='".$BDes."' WHERE id='".$uID."'"; 



$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: aBus');
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! ".$Bname . "' Business Unit info details Updated!";
header('Location: aBus');
}


//close the connection
mysql_close($dbhandle);




?>