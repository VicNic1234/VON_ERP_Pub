<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];

if($_POST)
{
$q=$_POST['litem'];
$sql_res=mysql_query("UPDATE logistics SET SetForIn='1', SetForInBy ='".$Userid."' WHERE logID = '$q'");

$result = mysql_query($sql_res, $dbhandle);

if (!$result)
{
//echo mysql_error();
//$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
//header('Location: Q?sRFQ='.$LIRFQ);

	//We need to Move a copy to Accounts now
	$resultLI = mysql_query("SELECT * FROM logistics LEFT JOIN purchaselineitems ON logistics.LineItID=purchaselineitems.LitID Where logID ='$q' ");
 	$NoRowLI = mysql_num_rows($resultLI);

 	if ($NoRowLI > 0) {
	 
	while ($row = mysql_fetch_array($resultLI)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	  $LitID = $row{'logID'};
	  $MatSer = $row['MartServNo'];
	  $Description = $row ['Description'];
	  $Qty = $row ['Qty'];
	  $UOM = $row ['UOM'];
      $OEM = $row ['OEM'];
      //Let's get OEM Id
      $OEMID = 0;
      $Qoem = mysql_query("SELECT * FROM suppliers WHERE SupNme ='$OEM'");
      while ($OEMrow = mysql_fetch_array($Qoem))
      {
         $OEMID = $OEMrow ['supid'];
      }
     // exit;
      //Let's get CusID
      $CUSID = 0;
       $Cus = $row ['Customer'];
       $QCus = mysql_query("SELECT cusid FROM customers WHERE cussnme ='$Cus' OR CustormerNme='$Cus'");
       while ($CUSrow = mysql_fetch_array($QCus))
      {
        $CUSID = $CUSrow ['cusid'];
      }
      //exit;
	  $RFQn = $row ['POID'];
	  $UnitWeight = $row ['UnitWeight'];
	  $HScode = $row ['HScode'];
	  $DueDate = $row ['DueDate'];
	 
	  $UnitCost = $row ['UnitCost'];
	  $ExtendedCost = $row ['ExtendedCost'];
	  $DiscountAmt = $row ['DiscountAmt'];
	  $Discount = $row ['Discount'];
	  $Currency = $row ['Currency'];
	  $UnitWeight = $row ['UnitWeight'];
	  $ExWeight = $row ['ExWeight'];
	  $Remark = $row ['Remark'];
	  //$DueDate = DateTime::createFromFormat('Y/m/d', $DueDate)->format('Y/m/d');
	  $date=date_create($DueDate);
      $DueDate = date_format($date,"Y/m/d");
	  $ToDay = date("Y/m/d");
	  /*if($DueDate > $ToDay) {$DueDate = "<b style='color:green'>". $DueDate ."</b>"; }
	  	else {$DueDate = "<b style='color:red'>". $DueDate ."</b>";}
	  $OEMUpdate = $row ['OEMUpdate'];
	  $OEMUpdate = str_replace(array("\r\n", "\r", "\n"), "<br />", $OEMUpdate);//nl2br($OEMUpdate);
	  */
	  $DeliveryToWrkLocation = $row ['DeliveryToWrkLocation'];
	  //$FOBExWorks = $row ['FOBExWorks'];
	  $DELIVERY = $row ['DELIVERY'];
	  $WorkLocation = $row ['WorkLocation'];
	  $Statu = $row ['Status'];
	  $RVFm = $row ['RVFm'];
	  $RWBill = $row ['RWBill'];
	    $OPWh = $row ['OPWh'];
		  $CreatedOPWhByOn = $row ['CreatedOPWhByOn'];
	    $CreatedRVFmByOn = $row ['CreatedRVFmByOn'];
	    $CreatedRWBillByOn = $row ['CreatedRWBillByOn'];
	    $pAttach = $row ['AttachmentUpdate'];
	    $PO = $row ['SetForIn'];


	    /////////////////////////////////////////////////////
	    //Insert in Account Log Table
	//accountinvoice
	//Let's check if already there
	$AV = mysql_query("SELECT * FROM accountinvoice Where logID ='$LitID' ");
 	$NoRowAV = mysql_num_rows($AV);

 	if ($NoRowAV > 0) {
 		$query2=mysql_query("UPDATE accountinvoice SET OEMID='$OEMID', CUSID='$CUSID', POID='".$RFQn."', logID='".$LitID."', SetForIn='1', SetForInBy ='".$Userid."', UOM ='".$UOM."',
 		UnitRate='".$UnitCost."', POAmt='".$ExtendedCost."', Qty='".$Qty."', PODiscount='".$DiscountAmt."', DiscountPercent='".$Discount."',
 		DueDate='".$DueDate."', Description='".$Description."', MartServNo='".$MatSer."',  Currency='".$Currency."', UnitWeight='".$UnitWeight."',
 		ExWeight='".$ExWeight."', POComment='".$Remark."'  WHERE logID = '$q'");
		$result3 = mysql_query($query2, $dbhandle);
 	}
 	else
 	{
	 	$insQuery = "INSERT INTO accountinvoice (OEMID, CUSID, POID, logID, SetForIn, SetForInBy, UOM, UnitRate, POAmt, Qty, PODiscount, DiscountPercent, DueDate, Description, MartServNo, Currency, UnitWeight, ExWeight, POComment ) 
		VALUES ( '$OEMID', '$CUSID', '$RFQn', '$LitID', '1', '".$Userid."', '$UOM', '$UnitCost', '$ExtendedCost', '$Qty', '$DiscountAmt', '$Discount', '$DueDate', '$Description', '$MatSer', '$Currency', '$UnitWeight', '$ExWeight',
	   '$Remark');"; 
		mysql_query($insQuery);
 	}


	}

	
 }

}
else
{
//$_SESSION['ErrMsgB'] = "Congratulations! Line Item : ".$LIID . " Quoted!";
//header('Location: Q?sRFQ='.$LIRFQ);
}

}
//close the connection
mysql_close($dbhandle);


?>
