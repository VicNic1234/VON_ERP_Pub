<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with
//Take Value from the two guys in index page LOGIN FORM
$SupNme = mysql_real_escape_string(trim(strip_tags($_POST['SupNme'])));
$SupSCode = mysql_real_escape_string(trim(strip_tags($_POST['SupSCode'])));
$SupCountry = mysql_real_escape_string(trim(strip_tags($_POST['SupCountry'])));
$SupPhone2 = mysql_real_escape_string(trim(strip_tags($_POST['SupPhone2'])));
$Today = date("F j, Y, g:i a");
$USERID = $_SESSION['uid'];
$SupDir = mysql_real_escape_string(trim(strip_tags($_POST['SupDir'])));
$SupYrReg = mysql_real_escape_string(trim(strip_tags($_POST['SupYrReg'])));
$SupENLRegNo = mysql_real_escape_string(trim(strip_tags($_POST['SupENLRegNo'])));
$SupLevel = mysql_real_escape_string(trim(strip_tags($_POST['SupLevel'])));
$SupCore = mysql_real_escape_string(trim(strip_tags($_POST['SupCore'])));
$SupCat = mysql_real_escape_string(trim(strip_tags($_POST['SupCat'])));
//$DOB = trim(strip_tags($_POST['DOB']));
//$DRange = mysql_real_escape_string(trim(strip_tags($_POST['reservation'])));
$SupPhone1 = mysql_real_escape_string(trim(strip_tags($_POST['SupPhone1'])));
$SupMail = mysql_real_escape_string(trim(strip_tags($_POST['SupMail'])));
$SupRefNo = mysql_real_escape_string(trim(strip_tags($_POST['SupRefNo'])));
$SupAdd = mysql_real_escape_string(trim(strip_tags($_POST['SupAdd'])));
$SupTIN = mysql_real_escape_string(trim(strip_tags($_POST['SupTIN'])));
$SupGL = mysql_real_escape_string(trim(strip_tags($_POST['SupGL'])));
$SupBusD = mysql_real_escape_string(trim(strip_tags($_POST['SupBusD'])));
//$SupAdd = str_replace("'", "&#8217", $SupAdd);
//$SupAdd = str_replace('"', '&#8221', $SupAdd);
$SupURL = mysql_real_escape_string(trim(strip_tags($_POST['SupURL'])));
$SupCountry = mysql_real_escape_string(trim(strip_tags($_POST['SupCountry'])));

//execute the SQL query and return records
$result = mysql_query("SELECT * FROM suppliers WHERE SupNme='".$SupNme."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Supplier With Same Name Already Exist";
header('Location: aSup');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');

$query = "INSERT INTO suppliers (SupNme, SupSCode, SupAddress, SupEMail, SupPhone1, SupPhone2, SupRefNo, SupURL, SupCountry, SupTIN, SupGL, SupBusD, SupDir, SupYrReg, SupENLRegNo, SupLevel, SupCore, SupCat, CreatedOn, Createdby) 
VALUES ('$SupNme','$SupSCode','$SupAdd','$SupMail','$SupPhone1','$SupPhone2','$SupRefNo','$SupURL','$SupCountry','$SupTIN','$SupGL', '$SupBusD','$SupDir','$SupYrReg', '$SupENLRegNo','$SupLevel','$SupCore', '$SupCat', '$Today', '$USERID');";

$tt = mysql_query($query);
if ($tt)
{}
else
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Oops! Got issues with data bank, contact administrator, thanks.";
header('Location: aSup');
exit;}
  
$_SESSION['ErrMsgB'] = "Congratulations! New Supplier : ".$SupNme." Registered!";
header('Location: aSup');


}
//close the connection
mysql_close($dbhandle);




?>