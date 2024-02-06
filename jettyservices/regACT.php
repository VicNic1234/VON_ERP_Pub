<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $ActivityType = trim(strip_tags($_POST['ActivityType']));
  $ActivityStartDate = trim(strip_tags($_POST['ActivityStartDate']));
  $EquipUsed = trim(strip_tags($_POST['EquipUsed']));
  $Activities = trim(strip_tags($_POST['Activities']));
  $Tonnage = trim(strip_tags($_POST['Tonnage']));
  $Vessel = trim(strip_tags($_POST['Vessel']));
  $Remark = trim(strip_tags($_POST['Remark']));
  $EDA = trim(strip_tags($_POST['EDA']));
  $EDD = trim(strip_tags($_POST['EDD']));
  //$Comment = trim(strip_tags($_POST['Comment']));

  $Today = date('Y/m/d h:i:s a'); 
 
  

	$query1 = "INSERT INTO jettyreport (ActivityType, ActivityStartDate, EquipUsed, CreatedBy, CreatedOn, Activities, Tonnage, Vessel, Comment, EDA, EDD) 
	VALUES ('".$ActivityType."','".$ActivityStartDate."', '".$EquipUsed."', '".$UID."','".$Today."', '".$Activities."', '$Tonnage', '$Vessel', '$Remark', '$EDA', '$EDD');";

if(mysql_query($query1, $dbhandle))
{
  $_SESSION['ErrMsgB'] = "Created ".$ActivityType;
  header('Location: jettyreport');
mysql_close($dbhandle);
exit;
}
echo mysql_error();
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