<?php
if($_SESSION['crmuid'] == "" || $_SESSION['CustomerID'] == "")
{
	$_SESSION['ErrMsg'] = "Access Denied";
     	$dURL = "Location: ../users/logout";
		header($dURL);
     	exit;
}

?>