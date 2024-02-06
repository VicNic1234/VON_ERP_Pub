<?php
session_start();
include ('../DBcon/db_config.php');
//include ('imagerzer.php');
//select a database to work with


//Take Value from the two guys in index page LOGIN FORM
$Bname = mysql_real_escape_string(trim(strip_tags($_POST['Bname'])));
//$DeptU = trim(strip_tags($_POST['DeptU']));


////NEw Fields //////



//execute the SQL query and return records
$result = mysql_query("SELECT * FROM divisions WHERE DivisionName='".$Bname."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Division with Name already exist";
header('Location: aDiv');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO divisions (DivisionName) 
VALUES ('$Bname');";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "New Division is Registered";
header('Location: aDiv');
exit;

}
//close the connection
mysql_close($dbhandle);




?>