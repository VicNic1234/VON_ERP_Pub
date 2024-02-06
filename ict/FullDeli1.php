<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];

if($_POST)
{
$q=$_POST['litem'];
$sql_res=mysql_query("UPDATE logistics SET GoodsDisp='1', GoodsRv='1', PartialDeli='1', FullDeli='1', CreatedFullDeliByOn='".$Userid . " - On " .$DateG ."', FullDeliveryOn='".$DateG."' WHERE logID = '$q'");

$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
//$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
//header('Location: Q?sRFQ='.$LIRFQ);
}
else
{
//$_SESSION['ErrMsgB'] = "Congratulations! Line Item : ".$LIID . " Quoted!";
//header('Location: Q?sRFQ='.$LIRFQ);
}

}
//close the connection
mysql_close($dbhandle);


?>
