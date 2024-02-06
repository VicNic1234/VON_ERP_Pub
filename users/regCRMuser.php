<?php
session_start();
include ('../DBcon/db_config.php');
include ('imagerzer.php');
//select a database to work with

  

//Take Value from the two guys in index page LOGIN FORM
$CRMUsername = mysql_real_escape_string(trim(strip_tags($_POST['CRMUsername'])));
$CRMEmail = mysql_real_escape_string(trim(strip_tags($_POST['CRMEmail'])));
$CRMCus = trim(strip_tags($_POST['CRMCus']));
$CRMPassword = mysql_real_escape_string(trim(strip_tags($_POST['CRMPassword'])));

////NEw Fields //////


if ($CRMUsername == "" || $CRMPassword == "")
{
$_SESSION['ErrMsg'] = "Both Username and Password are required";
header('Location: admin');
exit;
}
//execute the SQL query and return records
$result = mysql_query("SELECT * FROM userext WHERE username='".$CRMUsername ."' OR email='".$CRMEmail."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
$_SESSION['ErrMsg'] = "Username already exist as CRM user";
header('Location: admin');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO userext (username, password, CustomerID, CRMemail, isActive) 
VALUES ('$CRMUsername','$CRMPassword','$CRMCus','$CRMEmail', 1);";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "CRM User have been Registered";
header('Location: admin');


}

//close the connection
mysql_close($dbhandle);




?>