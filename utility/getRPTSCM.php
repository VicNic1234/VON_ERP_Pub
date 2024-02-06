<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];

$ActionTab = ""; $LookAheadTab = "";

$WkNO = mysql_real_escape_string(trim(strip_tags($_POST['WkNo'])));
$sQt = mysql_real_escape_string(trim(strip_tags($_POST['sQt'])));


if($WkNO == 0 || $WkNO == "")
{
  $resultSCM = mysql_query("SELECT * FROM qmi_internalsales");
  $NoRowSCM = mysql_num_rows($resultSCM);
  $SN1 = 0;
   while ($row = mysql_fetch_array($resultSCM)) 
    { 

      $SN1 = $SN1 + 1;
      $ActionTab .= '<tr><td>'.$SN1.'</td><td>'.$row['ActionItem'].'</td><td>'.$row['ActionParty'].'</td><td>'.$row['ActionStatus'].'</td><td>'.$row['ActionComment'].'</td><td>'.$row['Qtr'].'</td></tr>'; 
    }  


  $resultLookA = mysql_query("SELECT * FROM qmi_internalsales_lookahead");
  $NoRowLookA = mysql_num_rows($resultLookA);
  $SN1 = 0;
   while ($row = mysql_fetch_array($resultLookA)) 
    { 

      $SN1 = $SN1 + 1;
      $LookAheadTab .= '<tr><td>'.$SN1.'</td><td>'.$row['Comment'].'</td><td>'.$row['Qtr'].'</td></tr>'; 
    }  

}
else {
 
  $resultSCM = mysql_query("SELECT * FROM qmi_internalsales WHERE Wk = '$WkNO'");
  $NoRowSCM = mysql_num_rows($resultSCM);
  $SN1 = 0;
   while ($row = mysql_fetch_array($resultSCM)) 
    { 

      $SN1 = $SN1 + 1;
      $ActionTab .= '<tr><td>'.$SN1.'</td><td>'.$row['ActionItem'].'</td><td>'.$row['ActionParty'].'</td><td>'.$row['ActionStatus'].'</td><td>'.$row['ActionComment'].'</td></tr>'; 
    }  

  $resultLookA = mysql_query("SELECT * FROM qmi_internalsales_lookahead WHERE Wk= '$WkNO'");
  $NoRowLookA = mysql_num_rows($resultLookA);
  $SN1 = 0;
   while ($row = mysql_fetch_array($resultLookA)) 
    { 

      $SN1 = $SN1 + 1;
      $LookAheadTab .= '<tr><td>'.$SN1.'</td><td>'.$row['Comment'].'</td><td>'.$row['Qtr'].'</td></tr>'; 
    } 
}

//echo $WkNO = //"Loving God the more, The King of Glory"; // $_POST['WkNo'];


$SCM = array();
$SCM['ActionTab'] = $ActionTab;
$SCM['LookAheadTab'] = $LookAheadTab; 



echo json_encode($SCM);


?>
