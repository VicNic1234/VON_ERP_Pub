<?php
error_reporting(0);
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['VEND'];
$PDFITmes= '';
/*
 LEFT JOIN suppliers ON vendorsinvoices.VendSource = suppliers.supid
 LEFT JOIN users ON vendorsinvoices.RaisedBy = users.uid
 LEFT JOIN ivitems ON vendorsinvoices.cid = ivitems.PONo
 LEFT JOIN ivmiscellaneous ON vendorsinvoices.cid = ivmiscellaneous.PONo
*/
$sql_res=mysql_query("SELECT *, 

 acct_vendorsinvoices.IVNo AS IVNo FROM acct_vendorsinvoices 

  WHERE isActive=1 AND VendSource='$q' AND PostID > 0 ORDER BY cid");
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
