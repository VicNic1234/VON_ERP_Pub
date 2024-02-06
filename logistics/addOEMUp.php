<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];

//echo $_FILES['LogisticsFile'];
//exit;

if($_POST)
{

$q = mysql_real_escape_string(trim($_POST['LIID'])); //
$LIDpuc = mysql_real_escape_string(trim($_POST['LIDpuc'])); //LIDpuc
$POID = mysql_real_escape_string(trim($_POST['LIRFQ'])); //
$AllowBupdate = mysql_real_escape_string(trim($_POST['bulkupdate'])); 

$convtRPn = mysql_real_escape_string(trim($_POST['convtRPn'])); 
$aFrAmt = mysql_real_escape_string(trim($_POST['aFrAmt'])); 
$aLhAmt = mysql_real_escape_string(trim($_POST['aLhAmt'])); 
//exit;
//////////////////////////////////////////////////////////
	if (isset($_FILES['LOFile']) && $_FILES['LOFile']['size'] > 0) 
{ 
	//echo "File dey";
	//exit;
 $sizemdia = $_FILES['LOFile']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  header('Location: Qchk');
  exit;
  }
//Let's set new Name for file
// ensure a safe filename
    $fileSpNme = preg_replace("/[^A-Z0-9._-]/i", "_", basename( $_FILES['LOFile']['name']));
 
    // don't overwrite an existing file
    $i = 0;
    $parts = pathinfo($fileSpNme);
    while (file_exists('../LogisticsAttach/'. $fileSpNme)) {
        $i++;
        $fileSpNme = $parts["filename"] . "-" . $i . "." . $parts["extension"];
    }

  $DBfilelnk = '../LogisticsAttach/' . $fileSpNme;
 move_uploaded_file($_FILES['LOFile']['tmp_name'], $DBfilelnk);


}
////////////////////////////////////////////////////////
///////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////


$newUpdate = mysql_real_escape_string($_POST['OEMUpdate']);
$newUpdate = str_replace(array("\r\n", "\r", "\n"), "<br />", $newUpdate);

//Let get the Previous Update

 if ($AllowBupdate == "on")
        {
          $resultOldUpdate = mysql_query("SELECT * FROM logistics WHERE POID ='$POID'", $dbhandle);
        }
        else
        {
          $resultOldUpdate = mysql_query("SELECT * FROM logistics WHERE logID = '$q'", $dbhandle);
        }

 $NoRowOldUpdate = mysql_num_rows($resultOldUpdate);
 
 //////////////////////////////////////////////////////////

  if ($NoRowOldUpdate > 0) 
  {
	while ($row = mysql_fetch_array($resultOldUpdate)) {
    $OEMUpdate = $row['OEMUpdate'];
    $AttachUpdate = $row['AttachmentUpdate'];
	  $logIDn = $row['logID'];
	  $POID = $row['POID'];	
    $OEMUpdate  = $OEMUpdate . "<br/>" . $newUpdate . " : Created On - " .$DateG."<br/>";
    $AttachUpdate = $AttachUpdate."<br/>". $DBfilelnk;
    if ($DBfilelnk != ""){
          $sql_res="UPDATE logistics SET OEMUpdate='$OEMUpdate', AttachmentUpdate='$AttachUpdate' WHERE logID = '$logIDn'";
          mysql_query($sql_res, $dbhandle);
        }
        else
        {
          $sql_res="UPDATE logistics SET OEMUpdate='$OEMUpdate' WHERE logID = '$logIDn'";
          mysql_query($sql_res, $dbhandle);
        }
        

        

     }
   }


   //However, we need to set figures here
      $sql_res1="UPDATE purchaselineitems SET aLocalHandling='$aLhAmt', UpdatedLocalHandlingBy='$Userid', UpdatedLocalHandlingOn='$DateG', aFreight='$aFrAmt', 
      UpdatedFreightBy='$Userid', UpdatedFreightOn='$DateG', ConvertRatePerN='$convtRPn' WHERE LitID ='$LIDpuc'";
         $re = mysql_query($sql_res1, $dbhandle);


$_SESSION['ErrMsgB'] = "Congratulations! OEM Info. Updated for : ".$q;
header('Location: Qchk?sRFQ='.$POID);
/*
if (!$re)
{
//echo mysql_error();
//$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
//header('Location: Q?sRFQ='.$LIRFQ);
}
else
{
echo "Donw";
}
*/
}

//close the connection
mysql_close($dbhandle);


?>
