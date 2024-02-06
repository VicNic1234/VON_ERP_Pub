<?php
session_start();
//error_reporting(0);
if((strpos($_SESSION['AccessModule'], "projectcontrols") > -1)) {}
else { 	$_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }
?>