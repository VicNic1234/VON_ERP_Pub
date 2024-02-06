<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
//$Userid = $_SESSION['uid'];
$CRMCusID = $_SESSION['crmuid'];
$CustomerID = $_SESSION['CustomerID'];


//echo $_FILES['LogisticsFile'];
//exit;

if($_POST)
{

$LineID = mysql_real_escape_string($_POST['LineID']);
$newUpdate = mysql_real_escape_string($_POST['OEMUpdate']);
$newUpdate = str_replace(array("\r\n", "\r", "\n"), "<br />", $newUpdate);
$SQL = "INSERT INTO crmlitfeedback (LineItemID, Msg, FromCRM, ToCRM, CreatedBy) VALUES ('$LineID','$newUpdate','C','P','$CRMCusID');";

mysql_query($SQL);


$_SESSION['ErrMsgB'] = "Congratulations! Updated";
header('Location: ./');

}

//close the connection
mysql_close($dbhandle);


?>
