<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $EquipNme = trim(strip_tags($_POST['VehicleNme']));
  $EquipCode = trim(strip_tags($_POST['VehicleCode']));
  $EquipYrMake = trim(strip_tags($_POST['VehicleYrMake']));
  $Comment = trim(strip_tags($_POST['Comment']));

  $Today = date('Y/m/d h:i:s a'); 
 
  

	$query1 = "INSERT INTO vehicles (EquipNme, EquipCode, EquipYrMake, EquipFNo, RaisedBy, RaisedOn, Comment) 
	VALUES ('".$EquipNme."','".$EquipCode."','".$EquipYrMake."', '".$EquipFNo."', '".$UID."','".$Today."','".$Comment."');";

if(mysql_query($query1, $dbhandle))
{
  $_SESSION['ErrMsgB'] = "Created ".$ContractNo;
  header('Location: newvehicle');
mysql_close($dbhandle);
exit;
}
/*
if(mysql_query($query1, $dbhandle))
{
   //Read CONCount
              $CONcount = mysql_query("SELECT * FROM sysvar WHERE variableName = 'CONTRACTCOUNT'");
              while ($row = mysql_fetch_array($CONcount)) { $CONcount = $row{'variableValue'}; }

              $CONcount = intval($CONcount) + 1;
   $query2 = "UPDATE sysvar SET variableValue='".$CONcount."' WHERE variableName = 'CONTRACTCOUNT'";
   mysql_query($query2, $dbhandle);


  	$_SESSION['ErrMsgB'] = "Created ".$ContractNo;
	header('Location: newcontract');
mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not create : ".$ContractNo;
  header('Location: newcontract');
//close the connection
mysql_close($dbhandle);
}
*/


?>