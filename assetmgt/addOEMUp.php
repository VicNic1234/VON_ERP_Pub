<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];

if($_POST)
{
$q= mysql_real_escape_string(trim($_POST['LIID']));
$newUpdate = mysql_real_escape_string(trim($_POST['OEMUpdate']));
$Inv = mysql_real_escape_string(trim($_POST['InvoiceN']));
$Shipn = mysql_real_escape_string(trim($_POST['ShipmentN']));
$DRN = mysql_real_escape_string(trim($_POST['DRN']));
$GRPSN = mysql_real_escape_string(trim($_POST['GRPSN']));
$GRPSD = mysql_real_escape_string(trim($_POST['GRPSD']));

//Let get the Previous Update
$resultOldUpdate = mysql_query("SELECT * FROM logistics WHERE logID ='".$q."'");
 $NoRowOldUpdate = mysql_num_rows($resultOldUpdate);
 //////////////////////////////////////////////////////////

  if ($NoRowOldUpdate > 0) 
  {
	while ($row = mysql_fetch_array($resultOldUpdate)) {
	  $OEMUpdate = $row['DeliveryUpdate'];
	  $POID = $row['POID'];		
     }
   }

//$TodaysDate = date("Y/m/d");
   //Append the NewUpdate to Old
   	$OEMUpdate  = $OEMUpdate . "</br>" . $newUpdate . " : Created On - " .$DateG."</br>";

$sql_res=mysql_query("UPDATE logistics SET DeliveryUpdate='$OEMUpdate', InvoiceN='$Inv', ShipmentN='$Shipn', DeliveryRN='$DRN', GRSlipN='$GRPSN', GRSlipDate='$GRPSD' WHERE logID = '$q'");

$result = mysql_query($query, $dbhandle);

$_SESSION['ErrMsgB'] = "Congratulations! Delivery Info. Updated for : ".$q;
 header('Location: Qchk?sRFQ='.$POID);

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
