<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");

$q=$_GET['litem'];
$sql_res=mysql_query("UPDATE poreq SET Approved='2', ApprovedBy='".$_SESSION['Firstname']. " ".$_SESSION['SurName']."', ApprovedDate='".$DateG."' WHERE reqid = '$q'");

$result = mysql_query($query, $dbhandle);


$home_url = "APOR";
header('Location: ' . $home_url);
//close the connection
mysql_close($dbhandle);


?>
