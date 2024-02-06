<?php
session_start();
include ('../DBcon/db_config.php');

//$BusUnt = trim(strip_tags($_POST['BusUnt']));
$Dname = mysql_real_escape_string(trim(strip_tags($_POST['Dnme'])));
$Divnme = mysql_real_escape_string(trim(strip_tags($_POST['Divnme'])));
$Dcode = mysql_real_escape_string(trim(strip_tags($_POST['Dcode'])));
$DDes = mysql_real_escape_string(trim(strip_tags($_POST['DDes'])));
$uID = mysql_real_escape_string(trim(strip_tags($_POST['uID'])));
$SDept = mysql_real_escape_string(trim(strip_tags($_POST['SDept'])));
$HDept = mysql_real_escape_string(trim(strip_tags($_POST['HDept'])));

if ( $uID == "" )
{
$_SESSION['ErrMsg'] = "Did not update!";
header('Location: aDept');
exit;
}



$query = "UPDATE department SET DeptmentName='".$Dname."', DivID='".$Divnme."', DeptCode='".$Dcode."', Description='".$DDes."', hod='".$HDept."', supervisor='".$SDept."' WHERE id='".$uID."'"; 



$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: aDept');
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! ".$Dname . "'s details Updated!";
header('Location: aDept');
}


//close the connection
mysql_close($dbhandle);




?>