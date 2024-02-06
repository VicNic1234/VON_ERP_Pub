<?php
session_start();
include ('../DBcon/db_config.php');

//$BusUnt = trim(strip_tags($_POST['BusUnt']));
$Jname = trim(strip_tags($_POST['Jnme']));
$JDes = trim(strip_tags($_POST['JDes']));
$uID = trim(strip_tags($_POST['uID']));

if ( $uID == "" )
{
$_SESSION['ErrMsg'] = "Did not update!";
header('Location: aDept');
exit;
}



$query = "UPDATE jobposition SET JobPosition='".$Jname."', Description='".$JDes."' WHERE id='".$uID."'"; 



$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: aJobP');
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! ".$Jname . "'s details Updated!";
header('Location: aJobP');
}


//close the connection
mysql_close($dbhandle);




?>