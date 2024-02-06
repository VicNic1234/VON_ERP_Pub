<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with
//Take Value from the two guys in index page LOGIN FORM
$ProdNme = mysql_real_escape_string(trim(strip_tags($_POST['ProdNme'])));

//execute the SQL query and return records
$result = mysql_query("SELECT * FROM product WHERE productname='".$ProdNme."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Product With Same Name Already Exist";
header('Location: aProduct');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');

$query = "INSERT INTO product (productname) 
VALUES ('$ProdNme');";

$tt = mysql_query($query);
if ($tt)
{}
else
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Oops! Got issues with data bank, contact administrator, thanks.";
header('Location: aProduct');
exit;}
  
$_SESSION['ErrMsgB'] = "Congratulations! New Product : ".$ProductNme." Registered!";
header('Location: aProduct');


}
//close the connection
mysql_close($dbhandle);




?>