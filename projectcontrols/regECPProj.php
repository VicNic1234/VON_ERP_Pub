<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];
 
/*
if (isset($_FILES['RFQFile']) && $_FILES['RFQFile']['size'] > 0) 
{ 
  $tmpName  = $_FILES['RFQFile']['tmp_name']; 
  $fp = fopen($tmpName, 'r');
  $data = fread($fp, filesize($tmpName));
  $data = addslashes($data);
  fclose($fp);
}
*/
//Take Value from the two guys in index page LOGIN FORM
$ProjSO = mysql_real_escape_string(trim(strip_tags($_POST['ProjSO']))); 
$POName = mysql_real_escape_string(trim(strip_tags($_POST['POName']))); 
$SOClient = trim(strip_tags($_POST['SOClient']));
$SOEndUser = trim(strip_tags($_POST['SOEndUser'])); 
$SOOEM = "";
foreach ($_POST['SOOEM'] as $OEMID)
    {
           // print "You are selected $OEMID<br/>";
            $SOOEM .= $OEMID . ",";
    }
  
//echo $SOOEM = trim(strip_tags($_POST['SOOEM'])); exit;
$SOEndUser = trim(strip_tags($_POST['SOEndUser']));
$PORDate = trim(strip_tags($_POST['PORDate']));
$POADate = trim(strip_tags($_POST['POADate']));
$ProjSDate = trim(strip_tags($_POST['ProjSDate']));
$ProjEDate = trim(strip_tags($_POST['ProjEDate']));
$SODiv = trim(strip_tags($_POST['SODiv']));
$POGoal = mysql_real_escape_string(trim(strip_tags($_POST['POGoal'])));
$PODescrip = mysql_real_escape_string(trim(strip_tags($_POST['PODescrip'])));
$ConDate = trim(strip_tags($_POST['ConDate']));
$ExtDate = trim(strip_tags($_POST['ExtDate']));


//execute the SQL query and return records
$result = mysql_query("SELECT * FROM epcprojectdetails WHERE ProjSO='".$ProjSO."'");
//check if user exist
$NoRow = mysql_num_rows($result); 


if ($NoRow > 0) 
{
	
//At this point we nned to Update the Record
	$sql_res=mysql_query("UPDATE epcprojectdetails SET ProjectName='$POName', ClientName='$SOClient', Division='$SODiv', EndUser='$SOEndUser', 
		ProjectGoal='$POGoal', ProjectOEM='$SOOEM', POReceivedDate='$PORDate', POAcknowledgedDate='$POADate', 
		ProjectStartDate='$ProjSDate', ProjectEndDate='$ProjEDate', 
		ContractualDate='$ConDate', ExtensionDate='$ExtDate', ItemDescription='$PODescrip' WHERE ProjSO = '$ProjSO'");
	 //mysql_query($sql_res, $dbhandle);
//echo mysql_error();
	$_SESSION['ErrMsgB'] = "Ok! Project Details is updated";
		header('Location: EPCMileStone?sSO='.$ProjSO);
exit;
}

else
{

//At this point we need t insert the Records

$query = "INSERT INTO epcprojectdetails (ProjSO, ProjectName, ClientName, Division, EndUser, ProjectGoal, ProjectOEM, POReceivedDate, POAcknowledgedDate, ProjectStartDate, ProjectEndDate, ContractualDate, ExtensionDate, ItemDescription, CreatedBy) 
VALUES ('$ProjSO','$POName','$SOClient','$SODiv','$SOEndUser','$POGoal','$SOOEM','$PORDate','$POADate','$ProjSDate','$ProjEDate','$ConDate','$ExtDate','$PODescrip', '$Userid');";

$regResult = mysql_query($query);
 if ($regResult)
 {
$_SESSION['ErrMsgB'] = "Ok! Project Details is updated";
header('Location: EPCMileStone?sSO='.$ProjSO);

}
else
{
$_SESSION['ErrMsg'] = "Oops! Connection to Data Pool Error!!";
header('Location: EPCMileStone?sSO='.$ProjSO);
}

}
//close the connection
mysql_close($dbhandle);




?>