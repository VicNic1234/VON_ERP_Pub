<?php
session_start();
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];
//
$NCRCategory = trim(strip_tags($_POST['NCRCategory']));
$rptDate = trim(strip_tags($_POST['rptDate']));
$Client = trim(strip_tags($_POST['Client']));
//$DOB = trim(strip_tags($_POST['DOB']));
$AAD = mysql_real_escape_string(trim(strip_tags($_POST['AAD'])));
$Des = mysql_real_escape_string(trim(strip_tags($_POST['Des'])));
$RootC = mysql_real_escape_string(trim(strip_tags($_POST['RootC'])));
$CorAct = mysql_real_escape_string(trim(strip_tags($_POST['CorAct'])));
$AgrDate = trim(strip_tags($_POST['AgrDate']));
$PrvAct = trim(strip_tags($_POST['PrvAct']));
$PersonResp = trim(strip_tags($_POST['PersonResp']));
$AuditorResp = trim(strip_tags($_POST['AuditorResp']));
$Veri = trim(strip_tags($_POST['Verification']));


{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO noncon (Category, RptDate, Client, AuditArea, Description, RootCause, CorrectiveAction, AgreedDate, PreventiveAction, Verification, PersonResponsible, Auditor, CreatedBy) 
VALUES ('$NCRCategory','$rptDate','$Client','$AAD','$Des','$RootC','$CorAct','$AgrDate','$PrvAct', '$Veri','$PersonResp','$AuditorResp','$UID');";

$regResult = mysql_query($query);
 if ($regResult)
 {
$_SESSION['ErrMsgB'] = "Congratulations!";
header('Location: newnoncon');
}
else
{
   
$_SESSION['ErrMsg'] = "Error! Kindly Contact Admin";
header('Location: newnoncon');
}

}
//close the connection
mysql_close($dbhandle);




?>