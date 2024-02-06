<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $EquipNme = trim(strip_tags($_POST['EquipNme']));
  $EquipCode = trim(strip_tags($_POST['EquipCode']));
  $EquipLoc = trim(strip_tags($_POST['EquipLoc']));
  $EquipMan = trim(strip_tags($_POST['EquipMan']));
  $EquipYrMake = trim(strip_tags($_POST['EquipYrMake']));
  $EquipFNo = trim(strip_tags($_POST['EquipFNo']));
  $Comment = trim(strip_tags($_POST['Comment']));

  $Today = date('Y/m/d h:i:s a'); 
 
  

	$query1 = "INSERT INTO equipments (EquipNo, EquipNme, EquipCode, EquipLoc, EquipMan, EquipYrMake, EquipFNo, RaisedBy, RaisedOn, Comment) 
	VALUES ('".$EquipFNo."','".$EquipNme."','".$EquipCode."','".$EquipLoc."','".$EquipMan."','".$EquipYrMake."', '".$EquipFNo."', '".$UID."','".$Today."','".$Comment."');";

if(mysql_query($query1, $dbhandle))
{
  $_SESSION['ErrMsgB'] = "Created ".$ContractNo;
  header('Location: newequipment');
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