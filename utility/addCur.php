<?php
session_start();
include ('../DBcon/db_config.php');

if (trim(strip_tags($_POST['ssv'])) != "")
{


$curnme = mysql_real_escape_string(trim(strip_tags($_POST['curnme'])));
$curhnme = mysql_real_escape_string(trim(strip_tags($_POST['curhnme'])));
$curabv = mysql_real_escape_string(trim(strip_tags($_POST['curabv'])));
//$DOB = trim(strip_tags($_POST['DOB']));
//$cusphn2 = mysql_real_escape_string(trim(strip_tags($_POST['cusphn2'])));
$cursym = mysql_real_escape_string(trim(strip_tags($_POST['cursym'])));
$curex = mysql_real_escape_string(trim(strip_tags($_POST['curex'])));
$curexUSD = mysql_real_escape_string(trim(strip_tags($_POST['curexUSD'])));
$curcon = mysql_real_escape_string(trim(strip_tags($_POST['curcon'])));

//Let's just Update
$query = "UPDATE currencies SET Abbreviation='".$curabv."', Symbol='".$cursym."', CurrencyName='".$curnme."', HunderthName='".$curhnme."', Country='".$curcon."', ExRateToNaria='".$curex."', ExRateToUSD='".$curexUSD."' WHERE curID='".trim(strip_tags($_POST['ssv']))."'"; 

$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: aCur');
exit;
}
{
$_SESSION['ErrMsgB'] = "Updated!";
header('Location: aCur');
exit;
}


}  
  


//Take Value from the two guys in index page LOGIN FORM
$curnme = mysql_real_escape_string(trim(strip_tags($_POST['curnme'])));
$curhnme = mysql_real_escape_string(trim(strip_tags($_POST['curhnme'])));
$curabv = mysql_real_escape_string(trim(strip_tags($_POST['curabv'])));
//$DOB = trim(strip_tags($_POST['DOB']));
//$cusphn2 = mysql_real_escape_string(trim(strip_tags($_POST['cusphn2'])));
$cursym = mysql_real_escape_string(trim(strip_tags($_POST['cursym'])));
$curex = mysql_real_escape_string(trim(strip_tags($_POST['curex'])));
$curexUSD = mysql_real_escape_string(trim(strip_tags($_POST['curexUSD'])));
$curcon = mysql_real_escape_string(trim(strip_tags($_POST['curcon'])));


//execute the SQL query and return records
$result = mysql_query("SELECT * FROM currencies WHERE CurrencyName='".$curnme."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Currency with ".$curnme." as name already exist";
header('Location: aCur');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO currencies (Abbreviation, Symbol, CurrencyName, HunderthName, Country, ExRateToNaria, ExRateToUSD) 
VALUES ('$curabv','$cursym','$curnme','$curhnme','$curcon','$curex','$curexUSD' );";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Currency is Registered";
header('Location: aCur');


}
//close the connection
mysql_close($dbhandle);




?>