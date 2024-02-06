<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with

//Take Value from the two guys in index page LOGIN FORM
//$firstnme = mysql_real_escape_string(trim(strip_tags($_POST['firstnme'])));
$uID = mysql_real_escape_string(trim(strip_tags($_POST['uid'])));
//$LIRFQ = str_replace("'", "&#8217", $LIRFQ);
//$LIRFQ = str_replace('"', '&#8221', $LIRFQ);
//$surnme = mysql_real_escape_string(trim(strip_tags($_POST['surnme'])));
/*$Gender = mysql_real_escape_string(trim(strip_tags($_POST['Gender'])));
//$DOB = trim(strip_tags($_POST['DOB']));
$staffid = mysql_real_escape_string(trim(strip_tags($_POST['staffid'])));
//$LIDes = str_replace("'", "&#8217", $LIDes);
//$LIDes = str_replace('"', '&#8221', $LIDes);
$staffphn = mysql_real_escape_string(trim(strip_tags($_POST['staffphn'])));
$LIemai = mysql_real_escape_string(trim(strip_tags($_POST['LIemai'])));
*/

if ( $uID == "" )
{
$_SESSION['ErrMsg'] = "Did not remove!";
header('Location: register');
exit;
}


{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
//$query = "DELETE FROM users WHERE uid='".$uID."'"; 
$query = "UPDATE users SET isActive = 0, isAvalible = 0 WHERE uid='".$uID."'"; 


$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: register');
}
else
{
$_SESSION['ErrMsgB'] = "User Removed!";
header('Location: register');
}

}
//close the connection
mysql_close($dbhandle);




?>