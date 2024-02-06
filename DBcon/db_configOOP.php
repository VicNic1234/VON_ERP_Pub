<?php

$username = "von_db_user";
$password = "von_db_password";
$hostname = "localhost"; 

date_default_timezone_set("Africa/Lagos");
//connection to the database
/*$dbhandle = mysql_connect($hostname, $username, $password)
  or die(mysql_error());
$selected = mysql_select_db("plantsecure",$dbhandle)
// $selected = mysql_select_db("myowgmda_plantdb",$dbhandle)
 or die("Network Error");	
*/

 $dbhandle = mysqli_connect($hostname,$username, $password,"von_db");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Data Bank Not Accessiable: " . mysqli_connect_error();
  }
  
 
 
  
	

     
?>