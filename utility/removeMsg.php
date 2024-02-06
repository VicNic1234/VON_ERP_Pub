<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];

$msgRID = mysql_real_escape_string(trim($_POST['msgID']));
//if($_POST)
{
//Set User for remove
  $UseridR = $Userid.",";
$sqlMsg = mysql_query("SELECT * FROM msg WHERE msgid='".$msgRID."'");
$NoRowsqlMsg = mysql_num_rows($sqlMsg);
 if ($NoRowsqlMsg > 0) {
  while ($row = mysql_fetch_array($sqlMsg)) {
    /*$msgid = $row['msgid'];
    $msgtype = $row['msgtype'];
    $msgTitle = $row['msgTitle'];*/
    $msgRep = $row['recipents']; 
    $msgactivityLog = $row['activityLog']; 
   /* $msgLink = $row['hlink'];
    $msg = $row['msg'];*/
    $msgRRep = str_replace($UseridR, "", $msgRep);

     }

 }
  $mRep = strlen($msgRRep);
  if ($mRep < 1) { $received = 1; } else { $received = 0; }
  
 //Prepare ActivityLog 
 $msgactivityLog .= "<br/> " . $StaffNme . " Viewed this message @ ".$DateG;
 //we now have to update the Recipents field
 $sql_res2=mysql_query("UPDATE msg SET activityLog='$msgactivityLog', received='$received' WHERE msgid = '$msgRID'");

$result = mysql_query($sql_res2, $dbhandle);


}

?>
