<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with
//Take Value from the two guys in index page LOGIN FORM
$SupNme = mysql_real_escape_string(trim(strip_tags($_POST['SupNme'])));
$SupCountry = mysql_real_escape_string(trim(strip_tags($_POST['SupCountry'])));
$SupPhone = mysql_real_escape_string(trim(strip_tags($_POST['SupPhone'])));
//$DOB = trim(strip_tags($_POST['DOB']));
//$DRange = mysql_real_escape_string(trim(strip_tags($_POST['reservation'])));
$SupPhone1 = mysql_real_escape_string(trim(strip_tags($_POST['SupPhone1'])));
$SupMail = mysql_real_escape_string(trim(strip_tags($_POST['SupMail'])));
$SupRefNo = mysql_real_escape_string(trim(strip_tags($_POST['SupRefNo'])));
$SupAdd = mysql_real_escape_string(trim(strip_tags($_POST['SupAdd'])));
$SupAdd = str_replace("'", "&#8217", $SupAdd);
$SupAdd = str_replace('"', '&#8221', $SupAdd);
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

$query = "INSERT INTO suppliers (SupNme, SupAddress, SupEMail, SupPhone1, SupPhone2, SupRefNo, SupURL, SupCountry) 
VALUES ('$SupNme','$SupAdd','$SupMail','$SupPhone','$SupPhone1','$SupRefNo','$SupURL','$SupCountry');";

$tt = mysql_query($query);
if ($tt)
{}
else
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Oops! Got issues with data bank, contarct administrator, thanks.";
header('Location: aSup');
exit;}
  
$_SESSION['ErrMsgB'] = "Congratulations! New Supplier : ".$SupNme." Registered!";
header('Location: aSup');


}
//close the connection
mysql_close($dbhandle);




?>