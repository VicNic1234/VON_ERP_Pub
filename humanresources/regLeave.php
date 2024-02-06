<?php
session_start();
include ('../DBcon/db_config.php');
//include ('imagerzer.php');
//select a database to work with


//Take Value from the two guys in index page LOGIN FORM
$BusYear = trim(strip_tags($_POST['BusYear']));
$WkDays = trim(strip_tags($_POST['WkDays']));
$LvTl = trim(strip_tags($_POST['LvTl']));
$DeptU = trim(strip_tags($_POST['DeptU']));


////NEw Fields //////



//execute the SQL query and return records
$result = mysql_query("SELECT * FROM leavemgt WHERE LeaveTitle='".$LvTl."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Leave Group with same title already exist";
header('Location: leavemgt');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO leavemgt (DeptmentID, BusYear, NWkDays, LeaveTitle) 
VALUES ('$DeptU','$BusYear', '$WkDays', '$LvTl');";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Leave Group is Registered";
header('Location: leavemgt');


}
//close the connection
mysql_close($dbhandle);




?>