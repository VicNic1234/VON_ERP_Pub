<?php
include ('../DBcon/db_config.php');
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];

if($_POST)
{
$q=$_POST['rfq'];
mysql_query("UPDATE rfq SET OnTQ='0', OnTQOn='$DateG', OnTQBy='".$Userid."' WHERE RFQid = '$q'");

$RFQresult = mysql_query("SELECT * FROM rfq WHERE RFQid='$q'");
$NoRowRFQ = mysql_num_rows($RFQresult);
if ($NoRowRFQ > 0) 
{
	while ($row = mysql_fetch_array($RFQresult)) 
	{
	 $RFQCode = $row['RFQNum'];
     mysql_query("UPDATE polineitems SET OnTQ='0', OnTQOn='$DateG', OnTQBy='".$Userid."' WHERE RFQCode = '$RFQCode'");
     mysql_query("UPDATE lineitems SET OnTQ='0', OnTQBy='$Userid', OnTQOn='$DateG' WHERE RFQCode = '$RFQCode'");

	}
}

}
//close the connection
mysql_close($dbhandle);


?>
