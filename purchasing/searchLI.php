<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['search'];
$sql_res=mysql_query("select * from purchaselineitems WHERE LitID = '$q'");
$NoRow = mysql_num_rows($sql_res);
	if ($NoRow > 0) 
	{
		while($row=mysql_fetch_array($sql_res))
		{
		echo $Desp = $row['Description'];

		}
	}
	else
	{

	}

}
?>
