<?php
include ('../DBcon/db_config.php');

if($_POST)
{

$CusID = mysql_real_escape_string(trim(strip_tags($_POST['CusID'])));
$AddType = mysql_real_escape_string(trim(strip_tags($_POST['AddType'])));
//mysql_real_escape_string(trim(strip_tags(exit;
$sql_res=mysql_query("select * from customers where cusid ='$CusID'");
$NoRow = mysql_num_rows($sql_res);
if ($NoRow > 0) 
{
	while($row=mysql_fetch_array($sql_res))
	{
		$Add1 = $row['CusAddress'];
		$Add2 = $row['CusAddress2'];

	}

	if($AddType == "DDP Location")
	{
		echo $Add1;
	}
	else
	{
		echo $Add2;
	}

}

}

?>
