<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$itemCatID = mysql_real_escape_string(trim(strip_tags($_POST['itemCatID'])));


if($itemCatID == "")
 { 
   exit;
 } 
 else 
 {
 	//Get Sequence
 	$getSequence = mysql_query("SELECT * FROM sysvar WHERE VariableName ='WHItemCount'");
	$NoRowSeq = mysql_num_rows($getSequence);

	if($NoRowSeq > 0)
	 { 
	   	 while ($row = mysql_fetch_array($getSequence)) {
			      $variableValue = $row['variableValue'];
			   }
			   
			 $variableValue =  str_pad($variableValue,3,"0",STR_PAD_LEFT);
		//exit;
	 } 

 	//ShortCode
 	$chkExist = mysql_query("SELECT * FROM  itemcategory WHERE id ='".$itemCatID."'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	 while ($row = mysql_fetch_array($chkExist)) {
			    echo $ShortCode = $row['ShortCode'] . "/" . $variableValue;
			   }
		exit;
	 } 
	else
	{
		exit;
	}

 }


exit;


?>
