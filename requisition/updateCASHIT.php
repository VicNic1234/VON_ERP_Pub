<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:s a");

$LitID= mysql_real_escape_string($_POST['LitID']);
$EditDes= mysql_real_escape_string($_POST['EditDes']);
$EditRPDF= mysql_real_escape_string($_POST['EditRPDF']); 
$EditAmt= mysql_real_escape_string($_POST['EditAmt']);
$EditQnt= mysql_real_escape_string($_POST['EditQnt']);

if ($LitID < 1) 
{ 
 
 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  exit;
}




$sql_res=mysql_query("UPDATE cashreq SET ItemDes='$EditDes', Amount='$EditAmt', Qty='$EditQnt', relatedPDF='$EditRPDF' WHERE reqid = '$LitID'");

$result = mysql_query($sql_res, $dbhandle);



//close the connection
mysql_close($dbhandle);


 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }


?>
