<?php
session_start();
include ('../DBcon/db_config.php');

if (trim(strip_tags($_POST['ssv'])) != "")
{

$uomnme = mysql_real_escape_string(trim(strip_tags($_POST['uomnme'])));
$uomabbr = mysql_real_escape_string(trim(strip_tags($_POST['uomabbr'])));


//Let's just Update
$query = "UPDATE uom SET UOMNme='".$uomnme."', UOMAbbr='".$uomabbr."' WHERE UOMid='".trim(strip_tags($_POST['ssv']))."'"; 

$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: Cus');
exit;
}
{
$_SESSION['ErrMsgB'] = "Updated!";
header('Location: aUOM');
exit;
}


}  
  


//Take Value from the two guys in index page LOGIN FORM
$uomnme = mysql_real_escape_string(trim(strip_tags($_POST['uomnme'])));
$uomabbr = mysql_real_escape_string(trim(strip_tags($_POST['uomabbr'])));


//execute the SQL query and return records
$result = mysql_query("SELECT * FROM uom WHERE UOMNme='".$uomnme ."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "UOM already exist";
header('Location: aUOM');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO uom (UOMNme, UOMAbbr) 
VALUES ('$uomnme','$uomabbr');";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New UOM is Registered";
header('Location: aUOM');


}
//close the connection
mysql_close($dbhandle);




?>