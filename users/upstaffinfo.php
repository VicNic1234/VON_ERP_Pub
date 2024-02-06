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
$uid = trim(strip_tags($_POST['uid']));
$ModeOfEmp = mysql_real_escape_string(trim(strip_tags($_POST['MOE'])));
$BusUnt = mysql_real_escape_string(trim(strip_tags($_POST['BusUnt'])));
$jbtitle = mysql_real_escape_string(trim(strip_tags($_POST['jbtitle'])));
$posti = mysql_real_escape_string(trim(strip_tags($_POST['posti'])));
$rptmgr = mysql_real_escape_string(trim(strip_tags($_POST['rptmgr'])));
$empsta = mysql_real_escape_string(trim(strip_tags($_POST['empsta'])));
$DOJ = mysql_real_escape_string(trim(strip_tags($_POST['DOJ']))); 
$YOEx = mysql_real_escape_string(trim(strip_tags($_POST['YOEx'])));
$WkEx = mysql_real_escape_string(trim(strip_tags($_POST['WkEx']))); 
//exit;
$WkPhn = mysql_real_escape_string(trim(strip_tags($_POST['WkPhn'])));
//$DOB = trim(strip_tags($_POST['DOB']));
$DOB = mysql_real_escape_string(trim(strip_tags($_POST['DOB'])));
$staffid = trim(strip_tags($_POST['staffid']));
$staffphn = mysql_real_escape_string(trim(strip_tags($_POST['staffphn'])));
$staffmail = mysql_real_escape_string(trim(strip_tags($_POST['staffmail'])));
$dept = mysql_real_escape_string(trim(strip_tags($_POST['dept'])));



////NEw Fields //////


if ($uid == "")
{
$_SESSION['ErrMsg'] = "Oops! Kindly try again";
header('Location: register');
exit;
}
//execute the SQL query and return records
$result = mysql_query("SELECT * FROM users WHERE uid='".$uid."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
	if(!$data)
{
	$query = "UPDATE users SET StaffID='".$staffid."', DeptID='".$dept."', 
	Firstname='".$FirstName."', Surname='".$SurName."', Gender='".$Gender."', Email='".$staffmail."', 
	Phone='".$staffphn."', DoB='".$DOB."', Middlename = '".$MiddleName."',
	ModeOfEmp='".$ModeOfEmp."', BusinessUnit='".$BusUnt."', JobTitle='".$jbtitle."', JobPosition='".$posti."', RptMgr='".$rptmgr."', 
	EmployeeStatus='".$empsta."', DateOfJoining='".$DOJ."', YearsOfExp='".$YOEx."', WorkExt='$WkEx', WorkPhone='".$WkPhn."' WHERE uid='".$uid."'";
}
else
{
    $query = "UPDATE users SET StaffID='".$staffid."', DeptID='".$dept."', 
	Firstname='".$FirstName."', Surname='".$SurName."', Gender='".$Gender."', Email='".$staffmail."', 
	Phone='".$staffphn."', DoB='".$DOB."', Picture='".$data."', Middlename = '".$MiddleName."',
	ModeOfEmp='".$ModeOfEmp."', BusinessUnit='".$BusUnt."', JobTitle='".$jbtitle."', JobPosition='".$posti."', RptMgr='".$rptmgr."', 
	EmployeeStatus='".$empsta."', DateOfJoining='".$DOJ."', YearsOfExp='".$YOEx."', WorkExt='$WkEx', WorkPhone='".$WkPhn."' WHERE uid='".$uid."'";

}



mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! Staff info. is updated";

if(($_POST['indivall']) == "YES"){
header('Location: mydetails');
}
else 
{
header('Location: employee?dc='.$uid);
}

}

else
{

$_SESSION['ErrMsg'] = "Oops! Kindly try again";
header('Location: register');
exit;

}
//close the connection
mysql_close($dbhandle);




?>