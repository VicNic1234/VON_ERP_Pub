<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with
$USERID = $_SESSION['uid'];
  
$DateG = date("Y-m-d h:i:s a");


//Take Value from the two guys in index page LOGIN FORM
$idClass = mysql_real_escape_string(trim(strip_tags($_POST['idClass'])));
$CaseComment = mysql_real_escape_string(trim(strip_tags($_POST['CaseComment'])));
$rstate = mysql_real_escape_string(trim(strip_tags($_POST['rstate'])));



if ( $idClass == "" )
{
$_SESSION['ErrMsg'] = "Did not update because Issue was not selected!";
header('Location: treatreq');
exit;
}



{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "UPDATE ictreq SET Status='".$rstate."', ActorComment='".$CaseComment."' WHERE reqid='".$idClass."'";

$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error(); exit;
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: treatreq');
}
else
{
 

$_SESSION['ErrMsgB'] = " Request have been updated!";
header('Location: treatreq');
}



}
//close the connection
mysql_close($dbhandle);




?>