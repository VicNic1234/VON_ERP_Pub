<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];

$supid = mysql_real_escape_string(trim(strip_tags($_POST['supid'])));

if($supid == 0 || $supid == "") { exit; }
else 
{
   
    $resultSupplier = mysql_query("SELECT * FROM suppliers WHERE supid = '$supid' ");
    $NoRowNo = mysql_num_rows($resultSupplier);
    if($NoRowNo > 0)
    {
        while ($row = mysql_fetch_array($resultSupplier))
        { 
         echo  $SupSCode = $row['SupSCode'];
            
        }
    }

    
   
}




?>
