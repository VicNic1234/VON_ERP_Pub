<?php
session_start();
include ('../DBcon/db_config.php');
include ('imagerzer.php');


//Take Value from the two guys in index page LOGIN FORM
$uID = mysql_real_escape_string(trim(strip_tags($_POST['uID'])));
$CRMUsername = mysql_real_escape_string(trim(strip_tags($_POST['CRMUsername'])));
$CRMEmail = mysql_real_escape_string(trim(strip_tags($_POST['CRMEmail'])));

$CRMPassword = mysql_real_escape_string(trim(strip_tags($_POST['CRMPassword'])));


if (  $uID == "")
{
$_SESSION['ErrMsg'] = "Did not update!";
header('Location: admin');
exit;
}


{


    $query = "UPDATE userext SET username='".$CRMUsername."', CRMemail='".$CRMEmail."', password='".$CRMPassword."' WHERE uid='".$uID."'"; 




$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: admin');
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! ".$surnme . "'s details Updated!";
header('Location: admin');
}

}
//close the connection
mysql_close($dbhandle);




?>