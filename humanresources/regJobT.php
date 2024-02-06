<?php
session_start();
include ('../DBcon/db_config.php');
//include ('imagerzer.php');
//select a database to work with


//Take Value from the two guys in index page LOGIN FORM
//$BusUnt = trim(strip_tags($_POST['BusUnt']));
$Jname = trim(strip_tags($_POST['Jname']));
$JDes = trim(strip_tags($_POST['JDes']));

////NEw Fields //////



//execute the SQL query and return records
$result = mysql_query("SELECT * FROM jobtitle WHERE JobTitle='".$Jname."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Job Title already exist";
header('Location: aJobT');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO jobtitle (JobTitle, Description) 
VALUES ('$Jname','$JDes');";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "New Job Title is Registered";
header('Location: aJobT');
exit;

}
//close the connection
mysql_close($dbhandle);




?>