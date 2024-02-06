<?php
session_start();
include ('../DBcon/db_config.php');
include ('../utility/notify.php');
$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];

if($_POST)
{

$q=$_POST['litem'];

$sql_res=mysql_query("UPDATE logistics SET OPWh='1', RWBill='1', RVFm='1', CreatedOPWhByOn='" .$DateG ."', OPWhBy='".$Userid ."' WHERE logID = '$q'");


if (mysql_query($sql_res))
{
//echo mysql_error();
//$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
//header('Location: Q?sRFQ='.$LIRFQ);
}
else
{
//$_SESSION['ErrMsgB'] = "Congratulations! Line Item : ".$LIID . " Quoted!";
//header('Location: Q?sRFQ='.$LIRFQ);
$sqlLID = mysql_query("SELECT * FROM logistics WHERE logID = '$q'");
	$NoRowsqlLID = mysql_num_rows($sqlLID);
 	if ($NoRowsqlLID > 0) 
 	{
 		while ($row = mysql_fetch_array($sqlLID)) 
	  	{
	 		//Let's get ghe PO Num AND Description 
	 		$POIDCode = $row['POID'];
	 		$DescriLID = $row['Description'];

 		}
 	}
notify_warehouse_of_logistic_released_lineitem($q, $POIDCode, $DescriLID);


}

}
//close the connection
mysql_close($dbhandle);


?>
