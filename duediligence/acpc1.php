<?php
include ('../DBcon/db_config.php');
include ('../utility/notify.php');

if($_POST)
{
$q=$_POST['litem'];
$sql_res1=mysql_query("UPDATE lineitems SET ProjectControl='1', Status='QUOTED' WHERE LitID = '$q'");

$result = mysql_query($sql_res1, $dbhandle);

$sql_res2=mysql_query("UPDATE polineitems SET ProjectControl='1', Status='QUOTED' WHERE LitID = '$q'");

$result = mysql_query($sql_res2, $dbhandle);

$sqlLID = mysql_query("SELECT * FROM polineitems WHERE LitID = '$q'");
	$NoRowsqlLID = mysql_num_rows($sqlLID);
 	if ($NoRowsqlLID > 0) 
 	{
 		while ($row = mysql_fetch_array($sqlLID)) 
	  	{
	 		//Let's get ghe PO Num AND Description 
	 		$RFQCode = $row['RFQCode'];
	 		$DescriLID = $row['Description'];

 		}
 	}

//We need to notify Project Control now
notify_projects_of_intelsales_released_lineitem($q, $RFQCode, $DescriLID);


}
//close the connection
mysql_close($dbhandle);


?>
