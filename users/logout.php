<?php
session_start(); 
error_reporting(0);

  $_SESSION['uid'] = "";
	  $_SESSION['SurName'] = "";
	  $_SESSION['Firstname'] = "";
	  $_SESSION['Gender'] = "";
	  $_SESSION['StaffID'] = "";
	  $_SESSION['DateReg'] = "";
	  $_SESSION['Email'] = "";
	  $_SESSION['Phone'] = "";
	  $_SESSION['DoB'] = "";
	  $_SESSION['Picture'] = "";
	  $_SESSION['Role'] = "";
	  $_SESSION['Dept'] = "";
	  $_SESSION['porApproval'] = "";
	  $_SESSION['AccessModule'] = "";
	  
	   
	  $_SESSION['porA'] = "";

	  $_SESSION['rptQMI'] = "";
	  $_SESSION['viewQMI'] = "";
	  $_SESSION['Role'] = "";
	  $_SESSION['LockDownTime'] = 300000; //30 secs
	  $_SESSION['ErrMsg'] = "";
	  $_SESSION['version'] = "";
	  $_SESSION['AccessModule'] = "";
	  $_SESSION['crmuid'] = "";
	  $_SESSION['CustomerID'] = "";
	  $_SESSION['CompanyName'] = "";
	  $_SESSION['CompanyAbbr'] = "";
	  $_SESSION['CompanyWebsite'] = "";
	  $_SESSION['CompanyLogo'] = "";
	  $_SESSION['BusinessYear'] = "";
	  $_SESSION['EPRurl'] = "";



$home_url = "login";
header('Location: ' . $home_url);

//session_destory();

?>
	

	
	 


