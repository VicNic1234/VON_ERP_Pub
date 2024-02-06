<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['INVID'];

$sql_res=mysql_query("select * from acct_ivitems WHERE PONo = '$q' AND isActive=1");
$NoRow = mysql_num_rows($sql_res);
	if ($NoRow > 0) 
	{
		while($row=mysql_fetch_array($sql_res))
		{
		//echo //$Desp = $row['Description'];
			$PDFITmes .= '<option value="I-'.$row['poitid'].'">'.$row['description'].'</option>';
		}

	
	}
	else
	{

	}
	
$sql_res=mysql_query("select * from acct_ivmiscellaneous WHERE PONo = '$q' AND isActive=1");
$NoRow = mysql_num_rows($sql_res);
	if ($NoRow > 0) 
	{
		while($row=mysql_fetch_array($sql_res))
		{
		//echo //$Desp = $row['Description'];
			$PDFITmes .= '<option value="M-'.$row['poitid'].'">'.$row['description'].'</option>';
		}

	
	}
	else
	{

	}

	echo $PDFITmes;

}
?>
