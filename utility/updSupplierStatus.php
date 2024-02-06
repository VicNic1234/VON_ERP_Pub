<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with
//Take Value from the two guys in index page LOGIN FORM
$SUPID = mysql_real_escape_string(trim(strip_tags($_POST['SUPID'])));
$SupStatus = mysql_real_escape_string(trim(strip_tags($_POST['SupStatus'])));

$isActive = 1;
if($SupStatus != "ACTIVE") { $isActive = 0; }

$query = "UPDATE suppliers SET Status='$SupStatus', isActive='$isActive' WHERE supid='$SUPID' ";

 
if (mysql_query($query))
{
    $_SESSION['ErrMsgB'] = "Congratulations! Updated Supplier Status!";
 header('Location: aSup');
}
else
{
    
//echo mysql_error();
$_SESSION['ErrMsg'] = "Oops! Got issues with data bank, contact administrator, thanks.";
header('Location: aSup');
exit;
  



}
//close the connection
mysql_close($dbhandle);




?>