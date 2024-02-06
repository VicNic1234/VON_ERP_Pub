<?php
session_start();
include ('../DBcon/db_config.php');

 
 
  
if (isset($_FILES['RFQFile']) && $_FILES['RFQFile']['size'] > 0) 
{ 
  $tmpName  = $_FILES['RFQFile']['tmp_name']; 
  $fp = fopen($tmpName, 'r');
  $data = fread($fp, filesize($tmpName));
  $data = addslashes($data);
  fclose($fp);
}

//Take Value from the two guys in index page LOGIN FORM
$RFQSource = trim(strip_tags($_POST['RFQSource']));
$RFQScope = trim(strip_tags($_POST['RFQScope']));
$RFQEllapes = trim(strip_tags($_POST['RFQEllapes']));
//$DOB = trim(strip_tags($_POST['DOB']));
$DRange = mysql_real_escape_string(trim(strip_tags($_POST['reservation'])));
$RFQCus = trim(strip_tags($_POST['RFQCus']));
$PEAss = trim(strip_tags($_POST['PEAss']));
$Comment = trim(strip_tags($_POST['Comment']));
$ReqNo = trim(strip_tags($_POST['ReqNo']));
$RFQNo = trim(strip_tags($_POST['RFQNo']));


//execute the SQL query and return records
$result = mysql_query("SELECT * FROM rfq WHERE RFQNum='".$RFQNo."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "RFQ Number already exist";
header('Location: RFQ');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO rfq (RFQNum, Customer, Scope, DateRange, Source, Attachment, CompanyRefNo, PENjobCode, BuyersNme, PEAID, Comment, Ellapes, Status) 
VALUES ('$RFQNo','$RFQCus','$RFQScope','$DRange','$RFQSource','$data','$ReqNo','$ReqNo','$RFQCus','$PEAss','$Comment','$RFQEllapes','OPEN');";

$regResult = mysql_query($query);
 if ($regResult)
 {
$_SESSION['ErrMsgB'] = "Congratulations! New RFQ $RFQNo is Registered, you can now add Line Item(s)";
header('Location: addLi?sRFQ='.$RFQNo);
}
else
{
$_SESSION['ErrMsg'] = "Error! Contact admin";
header('Location: RFQ');
}

}
//close the connection
mysql_close($dbhandle);




?>