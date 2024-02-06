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
$image->square(50);
$image->save('userpix/'.$imgName);
$data=addslashes(file_get_contents('userpix/'.$imgName));

  //$fp = fopen($tmpName, 'r');
  //$data = fread($fp, filesize($tmpName));
  //$data = addslashes($data);
  //fclose($fp);
}

//Take Value from the two guys in index page LOGIN FORM
$SurName = trim(strip_tags($_POST['Surname']));
$FirstName = trim(strip_tags($_POST['Fname']));
$Gender = trim(strip_tags($_POST['Gender']));
//$DOB = trim(strip_tags($_POST['DOB']));
$DOB = mysql_real_escape_string(trim(strip_tags($_POST['DOB'])));
$staffid = trim(strip_tags($_POST['staffid']));
$staffphn = trim(strip_tags($_POST['staffphn']));
$staffmail = trim(strip_tags($_POST['staffmail']));
$dept = trim(strip_tags($_POST['dept']));
$staffrole = trim(strip_tags($_POST['staffrole']));
$fpwsd = trim(strip_tags($_POST['fpwsd']));

if ($staffid == "" or $fpwsd == "")
{
$_SESSION['ErrMsg'] = "Enter Username or Password";
header('Location: register');
exit;
}
//execute the SQL query and return records
$result = mysql_query("SELECT * FROM users WHERE StaffID='".$staffid."' OR Email='".$staffmail ."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	/*//fetch tha data from the database
	while ($row = mysql_fetch_array($result)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	  $_SESSION['uid'] = $row{'id'};
	  $_SESSION['ucountry'] = $row['country'];
	  $_SESSION['usex'] = $row ['gender'];
	  $_SESSION['dob'] = $row ['dateofbirth'];
	  $_SESSION['userpix'] = $row ['userprofilepicture'];
	  $_SESSION['proskill'] = $row ['professionalskills'];
	  $_SESSION['mobileno'] = $row ['mobilenumber'];
	  $_SESSION['favorquote'] = $row ['favouritequote'];
	  $_SESSION['placelived'] = $row ['placeyouvelived'];
	  $_SESSION['about'] = $row ['writeaboutyourself'];
	  $_SESSION['username'] = $row ['username'];
	  $_SESSION['ErrMsg'] = "";
header('Location: user.php');
exit;
	  */
$_SESSION['ErrMsg'] = "Staff with ID Number of Email already exist";
header('Location: register');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO users (StaffID, Dept, Password, Role, Firstname, Surname, Gender, Email, Phone, DoB, Picture) 
VALUES ('$staffid','$dept','$fpwsd','$staffrole','$FirstName','$SurName','$Gender','$staffmail','$staffphn','$DOB','$data');";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Staff Registered";
header('Location: register');


}
//close the connection
mysql_close($dbhandle);




?>