<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with

//Take Value from the two guys in index page LOGIN FORM
$SupID = mysql_real_escape_string(trim(strip_tags($_POST['SupID'])));
$SupName = mysql_real_escape_string(trim(strip_tags($_POST['SupName'])));
$SupTIN = mysql_real_escape_string(trim(strip_tags($_POST['SupTIN'])));
$SupGL = mysql_real_escape_string(trim(strip_tags($_POST['SupGL'])));
$SupCountry = mysql_real_escape_string(trim(strip_tags($_POST['SupCountry'])));
$SupPhone1 = mysql_real_escape_string(trim(strip_tags($_POST['SupPhone1'])));
$SupPhone2 = mysql_real_escape_string(trim(strip_tags($_POST['SupPhone2'])));
$SupAdd = mysql_real_escape_string(trim(strip_tags($_POST['SupAdd'])));
//$SupAdd = str_replace("'", "&#8217", $SupAdd);
//$SupAdd = str_replace('"', '&#8221', $SupAdd);
//$DOB = trim(strip_tags($_POST['DOB']));
$SupEmail = mysql_real_escape_string(trim(strip_tags($_POST['SupEmail'])));
$SupURL = mysql_real_escape_string(trim(strip_tags($_POST['SupURL'])));
$SupRef = mysql_real_escape_string(trim(strip_tags($_POST['SupRef'])));

if ( $SupID == "" )
{
$_SESSION['ErrMsg'] = "Oops! Error occurred, please try again, thanks.";
header('Location: aSup');
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
$query = "UPDATE suppliers SET SupNme='".$SupName."', SupTIN='".$SupTIN."', SupGL='".$SupGL."', SupAddress='".$SupAdd."', SupCountry='".$SupCountry."', SupEMail='".$SupEmail."', SupPhone1='".$SupPhone1."', SupPhone2='".$SupPhone2."', 
SupRefNo='".$SupRef."', SupURL='".$SupURL."' WHERE supid='".$SupID."'"; 


$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: aSup');

}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! Suppliers ".$SupName ."'s Details Updated!";
header('Location: aSup');
}

}
//close the connection
mysql_close($dbhandle);




?>