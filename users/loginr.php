<?php
session_start();
include ('db_config.php');
//select a database to work with
$selected = mysql_select_db("myowgmda_plantdb",$dbhandle)
  or die("Network Error");
  


$Uname = trim(strip_tags($_POST['Uname']));
$pwd = trim(strip_tags($_POST['pwd']));
if ($Uname == "" or $pwd == "")
{
$_SESSION['ErrMsg'] = "Enter Username or Password";
header('Location: login');
exit;
}
//execute the SQL query and return records
$result = mysql_query("SELECT * FROM users WHERE (StaffID='".$Uname."' OR Email='".$Uname."') AND password='".$pwd ."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($result)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	  $_SESSION['uid'] = $row{'uid'};
	  $_SESSION['SurName'] = $row['Surname'];
	  $_SESSION['Firstname'] = $row ['Firstname'];
	  $_SESSION['Gender'] = $row ['Gender'];
	  $_SESSION['StaffID'] = $row ['StaffID'];
	  $_SESSION['DateReg'] = $row ['DateReg'];
	  $_SESSION['Email'] = $row ['Email'];
	  $_SESSION['Phone'] = $row ['Phone'];
	  $_SESSION['DoB'] = $row ['DoB'];
	  $_SESSION['Picture'] = $row ['Picture'];
	  $_SESSION['Dept'] = $row ['Dept'];
	  $_SESSION['Role'] = $row ['Role'];
	  
	  $_SESSION['ErrMsg'] = "";
     }
	  
//$_SESSION['ErrMsg'] = "Staff with ID Number of Email already exist";
if ($_SESSION['Role'] == "admin" AND $_SESSION['Dept'] == "admin") {
header('Location: ./');
exit;
}
if ($_SESSION['Role'] == "admin" AND $_SESSION['Dept'] == "Accounts") {
header('Location: account');
exit;
}

}

else
{
$_SESSION['ErrMsg'] = "Wrong Username or Password";
header('Location: login');
}
//close the connection
mysql_close($dbhandle);




?>