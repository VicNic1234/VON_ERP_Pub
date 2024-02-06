<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");

$q=$_GET['litem'];
$sql_res=mysql_query("UPDATE poreq SET Approved='1', ApprovedBy='".$_SESSION['Firstname']. " ".$_SESSION['SurName']."', ApprovedDate='".$DateG."' WHERE reqid = '$q'");

$result = mysql_query($query, $dbhandle);

//Let's get the full details of this item onow

$QresultLI = mysql_query("SELECT * FROM poreq WHERE reqid = '$q'"); //WHERE Status='OPEN'
$QNoRowLI = mysql_num_rows($QresultLI);

if ($QNoRowLI > 0) {
  while ($row = mysql_fetch_array($QresultLI )) {
  	$SONo = $row['RequestID'];//"POR";
    $desp = $row['ItemDes'];
    $Qty = $row['Qty'];
    $amt = $row['Amount'];
    $Exprice =  $Qty * $amt;       
     }
   }  


$iuery = "INSERT INTO purchaselineitems (SOCode, Description, Qty, UnitCost, ExtendedCost) VALUES ('$SONo','$desp','$Qty','$amt','$Exprice');"; 
$rg = mysql_query($iuery);


$home_url = "APOR";
header('Location: ' . $home_url);
//close the connection
mysql_close($dbhandle);


?>
