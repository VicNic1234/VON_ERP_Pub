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
$image->square(400);
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
$MiddleName = mysql_real_escape_string(trim(strip_tags($_POST['Mname'])));
$Gender = trim(strip_tags($_POST['Gender']));
$ModeOfEmp = mysql_real_escape_string(trim(strip_tags($_POST['MOE'])));
$BusUnt = mysql_real_escape_string(trim(strip_tags($_POST['BusUnt'])));
$jbtitle = mysql_real_escape_string(trim(strip_tags($_POST['jbtitle'])));
$posti = mysql_real_escape_string(trim(strip_tags($_POST['posti'])));
$rptmgr = mysql_real_escape_string(trim(strip_tags($_POST['rptmgr'])));
$empsta = mysql_real_escape_string(trim(strip_tags($_POST['empsta'])));
$DOJ = mysql_real_escape_string(trim(strip_tags($_POST['DOJ'])));
$YOEx = mysql_real_escape_string(trim(strip_tags($_POST['YOEx'])));
$WkEx = mysql_real_escape_string(trim(strip_tags($_POST['WkEx'])));
$WkPhn = mysql_real_escape_string(trim(strip_tags($_POST['WkPhn'])));
//$DOB = trim(strip_tags($_POST['DOB']));
$DOB = mysql_real_escape_string(trim(strip_tags($_POST['DOB'])));
$staffid = trim(strip_tags($_POST['staffid']));
$staffphn = mysql_real_escape_string(trim(strip_tags($_POST['staffphn'])));
$staffmail = mysql_real_escape_string(trim(strip_tags($_POST['staffmail'])));
$dept = mysql_real_escape_string(trim(strip_tags($_POST['dept'])));

////NEw Fields //////


if ($staffid == "")
{
$_SESSION['ErrMsg'] = "Staff ID is Required. Thanks";
header('Location: register');
exit;
}
//execute the SQL query and return records
$result = mysql_query("SELECT * FROM users WHERE Email <> '' AND (StaffID='".$staffid."' OR Email='".$staffmail ."')");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Staff with ID Number of Email already exist";
header('Location: register');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO users (StaffID, DeptID, Firstname, Middlename, Surname, Gender, Email, Phone, DoB, Picture, 
ModeOfEmp, BusinessUnit, JobTitle, JobPosition, RptMgr, EmployeeStatus, DateOfJoining, YearsOfExp, WorkExt, WorkPhone, isActive) 
VALUES ('$staffid','$dept','$FirstName', '$MiddleName', '$SurName','$Gender','$staffmail','$staffphn','$DOB','$data',
'$ModeOfEmp','$BusUnt','$jbtitle','$posti','$rptmgr','$empsta','$DOJ','$YOEx','$WkEx','$WkPhn', 1);";

mysql_query($query);
// echo mysql_error($dbhandle); 
$_SESSION['ErrMsgB'] = "Congratulations! New Staff Registered";
header('Location: register');


}
//close the connection
mysql_close($dbhandle);




?>