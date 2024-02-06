<?php

$username = "von_db_user";
$password = "von_db_password";
$hostname = "localhost"; 
$LastEntryDate = "2024/01/01";
$PresentBusYear = "2024";
date_default_timezone_set("Africa/Lagos");
//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
  or die(mysql_error());
$selected = mysql_select_db("von_db",$dbhandle)
// $selected = mysql_select_db("myowgmda_plantdb",$dbhandle)
 or die("Network Error");	

	

     
?>