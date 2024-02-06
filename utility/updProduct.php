<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with

//Take Value from the two guys in index page LOGIN FORM
$ProdID = mysql_real_escape_string(trim(strip_tags($_POST['ProdID'])));
$ProdName = mysql_real_escape_string(trim(strip_tags($_POST['ProdName'])));


if ( $SupID == "" )
{
$_SESSION['ErrMsg'] = "Oops! Error occurred, please try again, thanks.";
header('Location: aProduct');
exit;
}


/*execute the SQL query and return records
$result = mysql_query("SELECT * FROM rfq WHERE RFQNum='".$RFQNo."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "RFQ Number already exist";
header('Location: InternalSales');
exit;
}

else */
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "UPDATE product SET productname='".$ProdName."' WHERE pid='".$ProdID."'"; 


$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: aProduct');

}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! Product ".$ProdName ."'s Details Updated!";
header('Location: aProduct');
}

}
//close the connection
mysql_close($dbhandle);




?>