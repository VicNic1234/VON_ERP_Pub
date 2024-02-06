<?php
session_start();
include ('../DBcon/db_config.php');
include ('imagerzer.php');
//select a database to work with

  


//Take Value from the two guys in index page LOGIN FORM
$SSName = mysql_real_escape_string(trim(strip_tags($_POST['SSName'])));
$CourseT = mysql_real_escape_string(trim(strip_tags($_POST['CourseT'])));
$Trainer = mysql_real_escape_string(trim(strip_tags($_POST['Trainer'])));
$Gender = trim(strip_tags($_POST['Gender']));
$Venue = mysql_real_escape_string(trim(strip_tags($_POST['Venue'])));
$Duration = mysql_real_escape_string(trim(strip_tags($_POST['Duration'])));
$StrDate = mysql_real_escape_string(trim(strip_tags($_POST['StrDate'])));

$UID = $_SESSION['uid'];
 $Today = date('Y/m/d h:i:s a'); 
////NEw Fields //////


/*if ($staffid == "")
{
$_SESSION['ErrMsg'] = "Staff ID is Required. Thanks";
header('Location: training');
exit;
}*/
//execute the SQL query and return records
/*$result = mysql_query("SELECT * FROM users WHERE Email <> '' AND (StaffID='".$staffid."' OR Email='".$staffmail ."')");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Staff with ID Number of Email already exist";
header('Location: training');
exit;
}*/

//else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO regtraining (userid, Title, Trainer, Venue, Duration, StartDate, RegisteredOn, RegisteredBy, Attended, isActive) 
VALUES ('$SSName','$CourseT','$Trainer', '$Venue', '$Duration','$StrDate','$Today','$UID','0', 1);";

if(mysql_query($query)) {} else { //echo mysql_error($dbhandle);  exit; 
} 
// 
$_SESSION['ErrMsgB'] = "Congratulations! New Training Registered";
header('Location: training');


}
//close the connection
mysql_close($dbhandle);




?>