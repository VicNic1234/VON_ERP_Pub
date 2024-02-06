<?php
error_reporting(0);
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['VEND'];
$PDFITmes= '';
/*
 LEFT JOIN users ON enlinvoices.RaisedBy = users.uid
 LEFT JOIN enlivitems ON enlinvoices.cid = ivitems.PONo
 LEFT JOIN enlivmiscellaneous ON enlinvoices.cid = enlivmiscellaneous.PONo

 GROUP BY IVNo ORDER BY enlinvoices.cid
*/
$sql_res=mysql_query("SELECT *, 

 enlinvoices.IVNo AS IVNo FROM enlinvoices 
 LEFT JOIN customers ON enlinvoices.CusSource = customers.cusid

  WHERE enlinvoices.isActive=1 AND enlinvoices.CusSource='$q' AND PostID > 0 ");
$NoRow = mysql_num_rows($sql_res);
$Invoices = '<option value=""> --- </option>';
	if ($NoRow > 0) 
	{
		while($row=mysql_fetch_array($sql_res))
		{
		    //$ItemInfo[] = $row;
			$Invoices .= '<option value="'.$row['cid'].'">'.$row['IVNo'].' </option>';
		}

		echo $Invoices;
		//echo json_encode($ItemInfo);
	}
	else
	{

	}



}
?>
