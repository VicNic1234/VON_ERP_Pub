<?php
session_start([
    'cookie_lifetime' => 4545386400,
]);

error_reporting(0);
include ('../DBcon/db_configOOP.php');
//select a database to work with

$Uname = trim(strip_tags($_POST['Uname']));

$pwd = trim(strip_tags($_POST['pwd']));
if ($Uname == "" or $pwd == "")
{
$_SESSION['ErrMsg'] = "Enter Username or Password";
header('Location: users/login');
exit;
}
//execute the SQL query and return records
$result = mysqli_query($dbhandle, "SELECT * FROM users WHERE (StaffID='".$Uname."' OR Email='".$Uname."') AND password='".$pwd ."'");
//check if user exist
$NoRow = $result->num_rows; 


if ($NoRow > 0) 
{
	//fetch tha data from the database
	while($row = $result->fetch_assoc()) {
	  $_SESSION['uid'] = $row['uid'];
	  $_SESSION['SurName'] = $row['Surname'];
	  $_SESSION['Firstname'] = $row['Firstname'];
	  $_SESSION['Gender'] = $row['Gender'];
	  $_SESSION['StaffID'] = $row['StaffID'];
	  $_SESSION['DateReg'] = $row['DateReg'];
	  $_SESSION['Email'] = $row['Email'];
	  $_SESSION['Phone'] = $row['Phone'];
	  $_SESSION['DoB'] = $row['DoB'];
	  $_SESSION['Picture'] = $row['Picture'];
	  $_SESSION['Dept'] = $row['Dept'];
	  $_SESSION['HDept'] = $row['HDept']; 
      $_SESSION['HDiv'] = $row['HDiv']; 
      $_SESSION['Mgr'] = $row['Mgr']; 
	  $_SESSION['CEO'] = $row['CEO'];
	  $_SESSION['DeptID'] = $row['DeptID'];
	  $_SESSION['porA'] = $row['porApproval'];
	  $UAct = $row['isActive'];

	  $dURL = $row['Dept'];
	  $_SESSION['rptQMI'] = $row['rptQMI'];
	  $_SESSION['viewQMI'] = $row['viewQMI'];
	  $_SESSION['Role'] = $row['Role'];
	  $_SESSION['LockDownTime'] = 300000; //30 secs
	  $_SESSION['ErrMsg'] = "";
	  $_SESSION['version'] = "0.1";
	  $_SESSION['AccessModule'] = $row['AccessModule'];
	  //$_SESSION['CEO'] = "29,63,61,18";

	  $_SESSION['CompanyName'] = "ELSHCON NIG. LIMITED";
	  $_SESSION['CompanyAbbr'] = "ENL";
	  $_SESSION['CompanyWebsite'] = "https://www.elshcon.space";
	  $_SESSION['CompanyLogo'] = "0.1";
	  $_SESSION['BusinessYear'] = "2022";
	   $_SESSION['AcctBusinessYear'] = "2022";
	  $_SESSION['LastPostDay'] = "2020-01-01";
	  $_SESSION['EPRurl'] = "https://www.elshcon.space";
	  //$_SESSION['EPRurl'] = "2.1";
     }


/////////////////////////////////////
     if ($UAct == 0)
     {
     	$_SESSION['ErrMsg'] = "Your Account is deactivate. Kindly contact Admin";
     	$dURL = "Location: login";
		header($dURL);
     	exit;
     }
//////////////////////////////////////
 	if ($dURL == "superadmin")
		{
		$dURL = "Location: ../";
		header($dURL);
		exit;
		}
	else
		{
		//$dURL = "Location: ../".$dURL;
		$dURL = "Location: ../";
		header($dURL);
		exit;
		}
/////////////////////////////////

}
else
{

$resultEX = mysqli_query($dbhandle, "SELECT * FROM userext WHERE (username='".$Uname."') AND password='".$pwd ."'");
//check if user exist
$NoRowEx = $resultEX->num_rows;


if ($NoRowEx > 0) 
{
	//fetch tha data from the database
	while($row = $resultEX->fetch_assoc()) {
	   $UAct = $row['isActive']; 
	   $_SESSION['crmuid'] = $row['uid'];  
	   $_SESSION['CustomerID'] = $row['CustomerID']; 
	  //$_SESSION['EPRurl'] = "2.1";
     }


/////////////////////////////////////
     if ($UAct == 0)
     {
     	$_SESSION['ErrMsg'] = "Your Account is deactivate. Kindly contact Admin";
     	$dURL = "Location: ./";
		header($dURL);
     	exit;
     }
     elseif ($UAct == 1)
     { 
       $_SESSION['LockDownTime'] = 300000; //30 secs
	    $_SESSION['ErrMsg'] = "";
	    $_SESSION['version'] = "2.1";
	  $_SESSION['AccessModule'] = $row['AccessModule'];
	  $_SESSION['CEO'] = "29,63,61,18";

	  $_SESSION['CompanyName'] = "PE ENERGY LIMITED";
	  $_SESSION['CompanyAbbr'] = "PEEL";
	  $_SESSION['CompanyWebsite'] = "https://www.planterp.space";
	  $_SESSION['CompanyLogo'] = "2.1";
	  $_SESSION['BusinessYear'] = "2017";
	  $_SESSION['EPRurl'] = "https://www.planterp.space";
     	$dURL = "Location: ../crm";
		header($dURL);
     	exit;
     }


}
	
$_SESSION['ErrMsg'] = "Wrong Username or Password";
header('Location: login');
}
//close the connection
$dbhandle->close();




?>