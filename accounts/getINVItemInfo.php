<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['INVItem'];

$qM = explode("-",$q);
$qT = $qM[1];
if($qM[0] == "I")
{
$sql_res=mysql_query("select * from acct_ivitems WHERE poitid = '$qT'");
$NoRow = mysql_num_rows($sql_res);
//$ItemInfo[] = "";
	if ($NoRow > 0) 
	{
		while($row=mysql_fetch_array($sql_res))
		{
		    //$row['unitprice'] = 546.00;
		    $row['mItem'] = 0;
		    $ItemInfo[] = $row;
		}

		echo json_encode($ItemInfo);
	}
	else
	{

	}
}

if($qM[0] == "M")
{
    $sql_res=mysql_query("select * from acct_ivmiscellaneous WHERE poitid = '$qT'");
    $NoRow = mysql_num_rows($sql_res);

	if ($NoRow > 0) 
	{
		while($row=mysql_fetch_array($sql_res))
		{
		   
		    $SN =  $SN  + 1;
                $sdid = $row['poitid'];
                $description = $row['description'];
                $mprice = $row['price'];
                $Impact = $row['Impact'];
                $CONID = $row['PONo'];
                $CreatedBy = $row['CreatedBy'];
                $isActive = $row['isActive'];
                $AmtType = $row['AmtType'];
               
                $MainTotal = getTotalSum($CONID);
                
                    if($Impact == "ADD") { 
                      $Impact = "+"; 
                      if($AmtType == "DIRECT")
                      {
                       $MainTotal = $MainTotal + $mprice;
                      }
                      else{ $MainTotal = ($MainTotal * $mprice)/100; $PERT = "%"; }
                    }
                    else { 
                      $Impact = "-"; 
                      
                      if($AmtType == "DIRECT")
                      {
                       $MainTotal = $MainTotal - $mprice;
                      }
                      else{ $MainTotal = $MainTotal - ($MainTotal * $mprice)/100; $PERT = "% of Sub Total"; }
                
                    }
                    
                    $row['unitprice'] = $MainTotal;
                    $row['mItem'] = 1;
                     $ItemInfo[] = $row;
		    
		}
		
		

		echo json_encode($ItemInfo);
	}
	else
	{

	}
}




}

  function getTotalSum($CONID)
{
        /*Get Line Item */
$resultPOIt = mysql_query("SELECT * FROM acct_ivitems Where PONo='".$CONID."' AND isActive=1");
$NoRowPOIt = mysql_num_rows($resultPOIt);
 $SN = 0; $SubTotal = 0; $MainTotal = 0;
if ($NoRowPOIt > 0) {
  while ($row = mysql_fetch_array($resultPOIt)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $PDFNUM = $row['PDFNUM'];
    $PDFItemID = $row['PDFItemID'];
    $description = $row['description'];
    $units = $row['units'];
    $qty = $row['qty'];
    $unitprice = $row['unitprice'];
    $totalprice = floatval($unitprice) * floatval($qty);
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $delDoc = "";
    $SubTotal = $SubTotal + $totalprice;
    
    
   
  }
 } 



$MainTotal =  $SubTotal;


return floatval($MainTotal);

}
?>
