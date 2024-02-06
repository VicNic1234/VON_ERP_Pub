<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
    
//echo $_FILES['LogisticsFile'];
//exit;

if($_POST)
{

$q = mysql_real_escape_string(trim($_POST['rfqID'])); //rfqMUN
$p = mysql_real_escape_string(trim($_POST['rfqMUN'])); //rfqMUN
//////////////////////////////////////////////////////////
	if (isset($_FILES['RFQFile']) && $_FILES['RFQFile']['size'] > 0) 
{ 
	//echo "File dey";
	//exit;
 $sizemdia = $_FILES['RFQFile']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  header('Location: aRFQ');
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

  $DBfilelnk = '../RFQAttach/' . $fileSpNme;
$success = move_uploaded_file($_FILES['RFQFile']['tmp_name'],'../RFQAttach/' . $fileSpNme );
////// ADD NEW ATTACHMENT
$resultOldAttach = mysql_query("SELECT * FROM rfq WHERE RFQid ='".$q."'");
 $NoRowOldAttach = mysql_num_rows($resultOldAttach);
 if ($NoRowOldAttach > 0) 
  {
	while ($row = mysql_fetch_array($resultOldAttach)) {
	  $AttachUpdate = $row['Attachment'];
	 // $POID = $row['POID'];		
     }
   }

//$AttachUpdate = $AttachUpdate . "</br> <a href='" . $DBfilelnk . "'> Created on - ".$DateG."</a></br>";
$AttachUpdate = $AttachUpdate . "</br> " . $DBfilelnk;


$sqlres = mysql_query("UPDATE rfq SET Attachment='".$AttachUpdate."' WHERE RFQid = '".$q."'", $dbhandle);

 //mysql_query($sqlres, $dbhandle);
//if ($sqlres)
//{echo "done";}
//else
//{echo "not done";}
//exit;
}
////////////////////////////////////////////////////////
///////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////


$newUpdate = mysql_real_escape_string(trim($_POST['RFQUpdate']));

//Let get the Previous Update
$resultOldUpdate = mysql_query("SELECT * FROM rfq WHERE RFQid ='".$q."'");
 $NoRowOldUpdate = mysql_num_rows($resultOldUpdate);
 //////////////////////////////////////////////////////////

  if ($NoRowOldUpdate > 0) 
  {
	while ($row = mysql_fetch_array($resultOldUpdate)) {
	  $RFQUpdate = $row['RFQUpdate'];
	  $RFQid = $row['RFQid'];		
     }
   }

//$TodaysDate = date("Y/m/d");
   //Append the NewUpdate to Old
   	$RFQUpdate  = $RFQUpdate . "</br>" . $newUpdate . " : Created On - " .$DateG." : By - " .$StaffNme. " </br>";

$sql_res=mysql_query("UPDATE rfq SET RFQUpdate='$RFQUpdate' WHERE RFQid = '$q'");

$result = mysql_query($sql_res, $dbhandle);

$_SESSION['ErrMsgB'] = "Congratulations! RFQ Info. Updated for : ".$p;
 header('Location: aRFQ');

/*if (!$result)
{
//echo mysql_error();
//$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
//header('Location: Q?sRFQ='.$LIRFQ);
}
else
{

}*/

}
//close the connection
mysql_close($dbhandle);


?>
