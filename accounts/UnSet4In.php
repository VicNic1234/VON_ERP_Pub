<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];

if($_POST)
{
$q=$_POST['litem'];
$sql_res=mysql_query("UPDATE logistics SET SetForIn='0', SetForInBy ='".$Userid."' WHERE logID = '$q'");

$result = mysql_query($sql_res, $dbhandle);

//accountinvoice
$sql_res1=mysql_query("UPDATE accountinvoice SET SetForIn='0' WHERE logID = '$q'");

$result = mysql_query($sql_res1, $dbhandle);
if (!$result)
{
//echo mysql_error();
//$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
//header('Location: Q?sRFQ='.$LIRFQ);
}
else
{
//$_SESSION['ErrMsgB'] = "Congratulations! Line Item : ".$LIID . " Quoted!";
//header('Location: Q?sRFQ='.$LIRFQ);
}

}
//close the connection
mysql_close($dbhandle);


?>
