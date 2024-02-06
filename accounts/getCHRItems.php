<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['CHRCODE'];
$PDFITmes= '';
$sql_res=mysql_query("select * from cashreq WHERE RequestID = '$q' AND isActive=1");
$NoRow = mysql_num_rows($sql_res);
	if ($NoRow > 0) 
	{
		while($row=mysql_fetch_array($sql_res))
		{
		//echo //$Desp = $row['Description'];
			$PDFITmes .= '<option value="'.$row['reqid'].'">'.$row['ItemDes'].'</option>';
		}

		echo $PDFITmes;
	}
	else
	{

	}



}
?>
