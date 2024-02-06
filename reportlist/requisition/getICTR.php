<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");

$q=$_POST['rid'];
$sql_res=mysql_query("SELECT * FROM ictreq WHERE reqid = '$q'");
while ($row = mysql_fetch_array($sql_res)) {
       $ItemDes = $row['ItemDes'];
       $Purpose = $row['Purpose'];
       $Amount = $row['Amount'];
       $Qty = $row['Qty'];
     }

//close the connection
mysql_close($dbhandle);

$ITDetails = array();
$ITDetails['ItemDes'] = $ItemDes;
$ITDetails['Purpose'] = $Purpose;
//$ITDetails['Amount'] = $Amount;
//$ITDetails['Qty'] = $Qty;


echo json_encode($ITDetails);

?>
