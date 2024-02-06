<?php
session_start();
include ('../DBcon/db_config.php');
include ('imagerzer.php');
//select a database to work with

  
if (isset($_FILES['StaffPhoto']) && $_FILES['StaffPhoto']['size'] > 0) 
{ 
  $tmpName  = $_FILES['StaffPhoto']['tmp_name']; 
  $imgName = $_FILES['StaffPhoto']['name'];

  // Load the original image
$image = new SimpleImage($tmpName);
// Create a squared version of the image
$image->square(100);
$image->save('userpix/'.$imgName);
$data=addslashes(file_get_contents('userpix/'.$imgName));

  //$fp = fopen($tmpName, 'r');
  //$data = fread($fp, filesize($tmpName));
  //$data = addslashes($data);
  //fclose($fp);
}

//Take Value from the two guys in index page LOGIN FORM
$SurName = mysql_real_escape_string(trim(strip_tags($_POST['Surname'])));
$FirstName = mysql_real_escape_string(trim(strip_tags($_POST['Fname'])));
$Gender = trim(strip_tags($_POST['Gender']));
$BusUnt = mysql_real_escape_string(trim(strip_tags($_POST['BusUnt'])));
$staffid = mysql_real_escape_string(trim(strip_tags($_POST['staffid'])));
$staffphn = mysql_real_escape_string(trim(strip_tags($_POST['staffphn'])));
$staffmail = mysql_real_escape_string(trim(strip_tags($_POST['staffmail'])));
$staffPass = mysql_real_escape_string(trim(strip_tags($_POST['staffPass'])));
$dept = mysql_real_escape_string(trim(strip_tags($_POST['dept'])));

////NEw Fields //////


if ($staffmail == "")
{
$_SESSION['ErrMsg'] = "Enter Username or Password";
header('Location: register');
exit;
}
//execute the SQL query and return records
//$result = mysql_query("SELECT * FROM users WHERE StaffID='".$staffid."' OR Email='".$staffmail ."'");
$result = mysql_query("SELECT * FROM users WHERE Email='".$staffmail ."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Staff with ID Number or Email already exist";
header('Location: admin');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO users (StaffID, DeptID, Firstname, Surname, Gender, Email, Phone, Picture, 
BusinessUnit, Password, isActive) 
VALUES ('$staffid','$dept','$FirstName','$SurName','$Gender','$staffmail','$staffphn','$data',
	'$BusUnt', '$staffPass', 1);";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "User have been Registered";
header('Location: admin');


}

//close the connection
mysql_close($dbhandle);




?>