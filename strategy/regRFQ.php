<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

  $chkmRFQNo = trim(strip_tags($_POST['chkmRFQNo']));
  $mLIRFQ = trim(strip_tags($_POST['mLIRFQ']));
  if ($chkmRFQNo == "on" &&  $mLIRFQ == "")
  {
  	$_SESSION['ErrMsg'] = "RFQ Number to inherit, not selected";
	header('Location: RFQ');
  	exit;
  }
 
  
if (isset($_FILES['RFQFile']) && $_FILES['RFQFile']['size'] > 0) 
{ 
 /* $tmpName  = $_FILES['RFQFile']['tmp_name']; 
  $fp = fopen($tmpName, 'r');
  $data = fread($fp, filesize($tmpName));
  $data = addslashes($data);
  fclose($fp); */
}
////////////////////////////////////////////////////////
$sizemdia = $_FILES['RFQFile']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  header('Location: RFQ');
  exit;
  }
//Let's set new Name for file
// ensure a safe filename
    $fileSpNme = preg_replace("/[^A-Z0-9._-]/i", "_", basename( $_FILES['RFQFile']['name']));
 
    // don't overwrite an existing file
    $i = 0;
    $parts = pathinfo($fileSpNme);
    while (file_exists('../RFQAttach/'. $fileSpNme)) {
        $i++;
        $fileSpNme = $parts["filename"] . "-" . $i . "." . $parts["extension"];
    }

  $DBfilelnk = '</br> ../RFQAttach/' . $fileSpNme;
$success = move_uploaded_file($_FILES['RFQFile']['tmp_name'],'../RFQAttach/' . $fileSpNme );
/////////////////////////////////////////////////////////////

//Take Value from the two guys in index page LOGIN FORM
$RFQSource = trim(strip_tags($_POST['RFQSource'])); 
$RFQDiv = trim(strip_tags($_POST['RFQDiv'])); //
$RFQScope = trim(strip_tags($_POST['RFQScope']));
$RFQEllapes = trim(strip_tags($_POST['RFQEllapes']));
//$DOB = trim(strip_tags($_POST['DOB']));
$DRange = mysql_real_escape_string(trim(strip_tags($_POST['reservation'])));
$RFQCus = trim(strip_tags($_POST['RFQCus']));
//Let's Set Customers ID now
$resultCUS = mysql_query("SELECT cusid FROM customers Where cussnme ='$RFQCus'");
//check if user exist
 $NoRowCUS = mysql_num_rows($resultCUS);
 if ($NoRowCUS > 0) 
            {
              //fetch tha data from the database
              while ($row = mysql_fetch_array($resultCUS)) {
                $RFQCusID = $row['cusid'];
              }
              
            }
//exit;
//$PEAss = trim(strip_tags($_POST['PEAss']));
$PEAss = $_SESSION['uid'];
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
$query = "INSERT INTO rfq (RFQNum, Customer, cusid, Scope, DateRange, Source, Attachment, CompanyRefNo, PENjobCode, BuyersNme, PEAID, Comment, Ellapes, Status, MirriorRFQ, RFQDiv) 
VALUES ('$RFQNo','$RFQCus', '$RFQCusID', '$RFQScope','$DRange','$RFQSource','$DBfilelnk','$ReqNo','$ReqNo','$RFQCus','$PEAss','$Comment','$RFQEllapes','OPEN', '$mLIRFQ', '$RFQDiv');";

$regResult = mysql_query($query);
 if ($regResult)
 {
 	if ($chkmRFQNo == "on" &&  $mLIRFQ != "")
  {
  	$prevRFQ = mysql_query("SELECT * FROM lineitems WHERE RFQCode = '$mLIRFQ'");
	$NoRowprevRFQ = mysql_num_rows($prevRFQ);
	if ($NoRowprevRFQ > 1)
	{
	while ($row = mysql_fetch_array($prevRFQ)) {
	

	$query = "INSERT INTO lineitems (RFQCode, MatSer, Description, Qty, UOM, Price, Currency, UnitCost, ExtendedCost, Division) 
	VALUES ('".$RFQNo."','".$row{'MatSer'}."','".$row{'Description'}."','".$row{'Qty'}."','".$row{'UOM'}."','".$row{'Price'}."','".$row{'Currency'}."', '".$row{'UnitCost'}."', '".$row{'ExtendedCost'}."', '".$RFQDiv."');";
	mysql_query($query);
	/////////////////////////////////
	$liID = mysql_insert_id();
	$query1 = "INSERT INTO polineitems (LitID, RFQCode, MatSer, Description, Qty, UOM, Price, Currency, UnitCost, ExtendedCost, Division) 
	VALUES ('".$liID."','".$RFQNo."','".$row{'MatSer'}."','".$row{'Description'}."','".$row{'Qty'}."','".$row{'UOM'}."','".$row{'Price'}."','".$row{'Currency'}."', '".$row{'UnitCost'}."', '".$row{'ExtendedCost'}."', '".$RFQDiv."');";
	
	}
   }

   //Read RFQCount
              $RFQcount = mysql_query("SELECT * FROM sysvar WHERE variableName = 'RFQCount'");
              while ($row = mysql_fetch_array($RFQcount)) { $nRFQCount = $row{'variableValue'}; }

              $nRFQCount = intval($nRFQCount) + 1;
   $query1 = "UPDATE sysvar SET variableValue='".$nRFQCount."' WHERE variableName = 'RFQCount'";
   mysql_query($query1, $dbhandle);


  	$_SESSION['ErrMsgB'] = "Created ".$RFQNo." and Inherited  line items from ".$mLIRFQ;
	header('Location: RFQ');
  	exit;
  }

   //Read RFQCount
              $RFQcount = mysql_query("SELECT * FROM sysvar WHERE variableName = 'RFQCount'");
              while ($row = mysql_fetch_array($RFQcount)) { $nRFQCount = $row{'variableValue'}; }

              $nRFQCount = intval($nRFQCount) + 1;
   $query1 = "UPDATE sysvar SET variableValue='".$nRFQCount."' WHERE variableName = 'RFQCount'";
   mysql_query($query1, $dbhandle);
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