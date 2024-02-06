<?php
session_start();
include ('../DBcon/db_config.php');
//include ('imagerzer.php');
//select a database to work with


//Take Value from the two guys in index page LOGIN FORM
//$BusUnt = trim(strip_tags($_POST['BusUnt']));
$Dname = mysql_real_escape_string(trim(strip_tags($_POST['Dname'])));
$DivID = mysql_real_escape_string(trim(strip_tags($_POST['DivID'])));
$Dcode = mysql_real_escape_string(trim(strip_tags($_POST['Dcode'])));
$DDes = mysql_real_escape_string(trim(strip_tags($_POST['DDes'])));

////NEw Fields //////



//execute the SQL query and return records
$result = mysql_query("SELECT * FROM department WHERE Dcode='".$Dcode."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Department with Code Name already exist";
header('Location: aDept');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO department (DeptmentName, DeptCode, Description, DivID) 
VALUES ('$Dname','$Dcode','$DDes', '$DivID');";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "New Department is Registered";
header('Location: aDept');


}
//close the connection
mysql_close($dbhandle);




?>