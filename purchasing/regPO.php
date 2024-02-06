<?php
session_start();
include ('../DBcon/db_config.php');
include ('../utility/notify.php');
//select a database to work with
$StaffID = $_SESSION['uid'];

///////////////////////////////////
$POSup = mysql_real_escape_string(trim($_POST['POSup']));
$resultSUP1 = mysql_query("SELECT * FROM suppliers WHERE SupNme='$POSup'");
$NoRowSUP1 = mysql_num_rows($resultSUP1);
 
if ($NoRowSUP1 > 0) { while ($row = mysql_fetch_array($resultSUP1)) { $POSupID = $row['supid']; } }  

//$PODisAmt = mysql_real_escape_string(trim($_POST['DisAmt']));
$pTax = mysql_real_escape_string(trim($_POST['pTax']));
$PODate = mysql_real_escape_string(trim(strip_tags($_POST['PODate'])));
//$POSupSt = mysql_real_escape_string(trim(strip_tags($_POST['POSupSt'])));
$POSupSt = mysql_real_escape_string(trim(strip_tags($_SESSION['uid'])));
$DeliLoc = mysql_real_escape_string(trim(strip_tags($_POST['DeliLoc'])));
$PONo = mysql_real_escape_string(trim(strip_tags($_POST['PONo'])));
$SubTotal = mysql_real_escape_string(trim(strip_tags($_POST['SubTotal'])));
$sTax = mysql_real_escape_string(trim(strip_tags($_POST['sTax'])));
$sTotal = mysql_real_escape_string(trim(strip_tags($_POST['rTotal'])));
  
  //////////////////////////////////

$aDoor = $_POST['poli_cap'];

$TDay = date("Y-m-d h:i:sa");

//execute the SQL query and return records
$result = mysql_query("SELECT * FROM po WHERE PONum='".$PONo."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
  
$_SESSION['ErrMsg'] = "PO Number already exist";
header('Location: PO');
exit;
}


  $ItemDetails = "";
  $ItemPrice ="";
  $ItemD = "";
  $ItemIDs = "";

  $NotifyLogistics = 0;
  

  if(count($aDoor) < 1) 
  {
    $_SESSION['ErrMsg'] = "You didn't select any item.";
   header('Location: PO');
   // echo count($aDoor);
	exit;
  } 
  else
  {
    $N = count($aDoor);
	  $ItemDm ="";
	
    //echo("You selected $N Item(s): <br/> ");
    //echo("<center>	<li> You selected $N Item(s): </li> </center>");
    for($i=0; $i < $N; $i++)
    {
	  $ItemD = $ItemD. "<br />" . $aDoor[$i];
	  $RawITD = explode("@&@",$aDoor[$i]);
	  $ItemDm .= $RawITD[0]."<br/>";
    $CDrp = mysql_real_escape_string(trim($RawITD[0]));
    $CDrp = $RawITD[0];
    if (/*$RawITD[9] == "POR" || */  $RawITD[10] == "WH0")
    {
       //Now here we would need to do a query to purpolate our Logistics Table but should not be Trackalbe by Logistics;
    $querylg = "INSERT INTO logistics (POID, lineItID, Description, POAmt, Qty, UOM, OEM, MartServNo, PODiscount, UnitRate, DueDate, sOpen, OPWh, OPWhBy, createdOPWhByOn) 
    VALUES ('$PONo','$RawITD[1]','$CDrp','$RawITD[2]', '$RawITD[3]', '$RawITD[4]', '$POSup', '$RawITD[5]', '$RawITD[6]', '$RawITD[7]', '$RawITD[8]', '0', '1', '$StaffID', '$TDay' )";
    $qresultlg = mysql_query($querylg); $NotifyLogistics = 1;
    //Notifiy Warehouse using PO COde


    }
    else
    {
    //Now here we would need to do a query to purpolate our Logistics Table;
    $querylg = "INSERT INTO logistics (POID, lineItID, Description, POAmt, Qty, UOM, OEM, MartServNo, PODiscount, UnitRate, DueDate, sOpen) 
    VALUES ('$PONo','$RawITD[1]','$CDrp','$RawITD[2]', '$RawITD[3]', '$RawITD[4]', '$POSup', '$RawITD[5]', '$RawITD[6]', '$RawITD[7]', '$RawITD[8]', '1')";
    $qresultlg = mysql_query($querylg); $NotifyWarehouse = 1; 
    //Notifiy Logistics using PO COde

    }

    // Now we would have to make the item unavalible in pursing table
    $query = "UPDATE purchaselineitems SET Status='CLOSED' WHERE LitID='".$RawITD[1]."'"; 

    $result = mysql_query($query, $dbhandle);

	
    }
  }

$ItemDetails = $ItemDm;
//exit;

//$ItemDetails = mysql_real_escape_string(trim($ItemD));




{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO po (PONum, Status, Supplier, SupplierID, StaffID, ItemsN, ItemsDetails, SubTotal, Tax, Total, POdate, POLocation, POAssignStaff, ItemList, pTax, Discount) 
VALUES ('$PONo','0','$POSup', '$POSupID', '$StaffID','$N','$ItemDetails','$SubTotal','$sTax','$sTotal','$PODate', '$DeliLoc', '$POSupSt', '$ItemIDs', '$pTax', '$PODisAmt')";

$qresult = mysql_query($query);

if($qresult)
{
$_SESSION['ErrMsgB'] = "Congratulations! New PO Registered, set To be treated by Accounts";
header('Location: PO');

if($NotifyWarehouse == 1)  //Notifiy Warehouse using PO COde
  {
    notify_warehouse_of_po_creation($PONo, $POSup, $N, $ItemDetails);
  }

if($NotifyLogistics == 1) //Notifiy Logistics using PO COde
  {
    notify_logistics_of_po_creation($PONo, $POSup, $N, $ItemDetails);
  }
    
}
else
{
$_SESSION['ErrMsg'] = mysql_error();
header('Location: PO');
}
  



}
//close the connection
mysql_close($dbhandle);




?>