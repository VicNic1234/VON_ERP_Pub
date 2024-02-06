<?php
session_start();
include ('../DBcon/db_config.php');
//include ('imagerzer.php');
//select a database to work with


//Take Value from the two guys in index page LOGIN FORM
$BusYear = trim(strip_tags($_POST['BusYear']));
$HDay = trim(strip_tags($_POST['HDay']));
$HTitle = trim(strip_tags($_POST['HTitle']));
//$DeptU = trim(strip_tags($_POST['DeptU']));


////NEw Fields //////



//execute the SQL query and return records
$result = mysql_query("SELECT * FROM holidaymgt WHERE HolidayTitle='".$HTitle."' OR (HolidayDay='".$HDay."' AND BusYear='".$BusYear."')");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Either there is already a holiday for this day or Holidsy with same title already exist";
header('Location: dholiday');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO holidaymgt (HolidayTitle, BusYear, HolidayDay) 
VALUES ('$HTitle','$BusYear', '$HDay');";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Holiday is Registered";
header('Location: dholiday');


}
//close the connection
mysql_close($dbhandle);




?>