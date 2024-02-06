<?php
session_start();
include ('../DBcon/db_config.php');
include ('../utility/notify.php');
//select a database to work with
$sizemdia = $_FILES['SOFile']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  header('Location: RaiseQchk');
  exit;
  }
//Let's set new Name for file
// ensure a safe filename
    $fileSpNme = preg_replace("/[^A-Z0-9._-]/i", "_", basename( $_FILES['SOFile']['name']));
 
    // don't overwrite an existing file
    $i = 0;
    $parts = pathinfo($fileSpNme);
    while (file_exists('../SOAttach/'. $fileSpNme)) {
        $i++;
        $fileSpNme = $parts["filename"] . "-" . $i . "." . $parts["extension"];
    }

  $DBfilelnk = '../SOAttach/' . $fileSpNme;
$success = move_uploaded_file($_FILES['SOFile']['tmp_name'],'../SOAttach/' . $fileSpNme );
/////////////////////////////////////////////////////////////

///////////////////////////////////
$Remark = mysql_real_escape_string(trim($_POST['Remark'])); //CusONo SOCus SODiv

$SODiv = mysql_real_escape_string(trim($_POST['SODiv'])); 
$pTax = mysql_real_escape_string(trim($_POST['pTax']));
$CusONo = mysql_real_escape_string(trim($_POST['CusONo']));
$SOCus = mysql_real_escape_string(trim($_POST['SOCus']));

$SODate = mysql_real_escape_string(trim(strip_tags($_POST['SODate'])));

//$POSupSt = mysql_real_escape_string(trim(strip_tags($_POST['POSupSt'])));
$SOSupSt = mysql_real_escape_string(trim(strip_tags($_SESSION['uid'])));
$DeliLoc = mysql_real_escape_string(trim(strip_tags($_POST['DeliLoc'])));
$SONo = mysql_real_escape_string(trim(strip_tags($_POST['SONo'])));
$SubTotal = mysql_real_escape_string(trim(strip_tags($_POST['SubTotal'])));
$sTax = mysql_real_escape_string(trim(strip_tags($_POST['sTax'])));
$sTotal = mysql_real_escape_string(trim(strip_tags($_POST['sTotal'])));
$SOType = mysql_real_escape_string(trim(strip_tags($_POST['SOType'])));

if($SOSupSt < 0) {
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>Kindly Login. Thanks</strong>";
  header('Location: ../users/logout');
  exit;
}

//execute the SQL query and return records
$result = mysql_query("SELECT * FROM so WHERE SONum='".$SONo."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
  
$_SESSION['ErrMsg'] = "SO Number already exist";
header('Location: RaiseQchk');
exit;
}

$resultCUS = mysql_query("SELECT * FROM customers Where cussnme ='$SOCus'");
//check if user exist
 $NoRowCUS = mysql_num_rows($resultCUS);
 if ($NoRowCUS > 0) 
            {
              //fetch tha data from the database
              while ($row = mysql_fetch_array($resultCUS)) {
                $SOCusID = $row['cusid'];
                $SOCusSName = $row['cussnme'];
                $SOCusFName = $row['CustormerNme'];
              }
              
            }
  //////////////////////////////////
$aDoor = $_POST['poli_cap'];
//var_dump($_POST['poli_cap']);
//exit;
  $ItemDetails = "";
  $ItemPrice ="";
  $ItemD = "";
  $ItemIDs = "";
  if(empty($aDoor)) 
  {
    $_SESSION['ErrMsgB'] = "You didn't select any item.";
    header('Location: RaiseQchk');
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
	  $ItemD = $ItemD. "<br>" . $aDoor[$i];
	  $RawITD = explode("@&@",$aDoor[$i]);
	  $ItemDm .= $RawITD[2]."<br/>";
    $POLitID = $RawITD[1];

    //Now here we would need to do a query to purpolate our po Table by Taking the ID of Line item in polineitems and move them to purchaselineitems
    //$querylg = "INSERT INTO logistics (POID, lineItID, Description, POAmt, PODiscount, Qty, UOM) 
    //VALUES ('$PONo','$RawITD[1]','$RawITD[0]','$RawITD[2]', '$pTax', '$RawITD[3]', '$RawITD[4]' )";
    $result = mysql_query("SELECT * FROM polineitems WHERE LitID='".$POLitID."'");
//check if user exist
 //$NoRow = mysql_num_rows($result);
 while ($row = mysql_fetch_array($result)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
    //$LitID = $row{'LitID'};
    $MatSer = $row['MatSer'];
    $Description = mysql_real_escape_string(trim($row['Description']));
    $Qty = $row['Qty'];
    $UOM = $row['UOM'];
    $RFQn = $row['RFQCode'];
    $Price = $row['UnitDDPrice'];
    $Currency = $row['Currency'];
    $UnitWeight = $row['UnitWeight'];
    $ExWeight = $row['ExWeight'];
    $UnitCost = $row['UnitCost'];
    $Discount = $row['Discount'];
    $DiscountAmt = $row['DiscountAmt'];
    
    $HScode = $row['HScode'];
    $HsTarrif = $row['HsTarrif'];
    $PackingPercent = $row['PackingPercent'];
    $ExportPacking = $row['ExportPackaging'];
    $InsurePercent = $row['InsurePercent'];
    $Insure = $row['Insurance'];
    $DeliveryToWrkLocation = $row['DeliveryToWrkLocation'];
     $pLocalHandling = $row['pLocalHandling'];
     $LocalHandling = $row['LocalHandling'];
     $ExCost = $row['ExtendedCost'];
    //$FOBExWorks = $row ['FOBExWorks'];
    $DELIVERY = $row['DELIVERY'];
    $WorkLocation = $row['WorkLocation'];
    $ExPrice = $Price * $Qty;
    $Statu = $row['Status'];
    $CreateSO = $row['CreateSO'];
    $markupperc = $row['markupperc'];
    //$Tech = $row ['Tech'];
    $MarkUpDirect = $row['MarkUpDirect'];
    $MarkUpAmt = $row['MarkUp'];
    $FreightDirect = $row['FreightDirect'];
    $FreightPercent = $row['FreightPercent'];
    $FreightAmt = $row['Freight'];
    $FOBExWorks = $row['FOBExWorks'];
    $ForeignCost = $row['ForeignCost'];
    $CustomDuty = $row['CustomDuty'];
    $CustomSubCharge = $row['CustomSubCharge'];
    $ETLSCharge = $row['ETLSCharge'];
    $LocalCost = $row['LocalCost'];
    $ExDDPrice = $row['ExDDPrice'];

  }
//exit;
  //here lets push it to purchaselineitems TABLE
 $insQuery = "INSERT INTO purchaselineitems (SOCode, cusid, cusnme, MatSer, Description, Qty, UOM, Currency, UnitCost, ExtendedCost, Discount, DiscountAmt, UnitWeight, ExWeight, 
  PackingPercent, ExportPackaging, InsurePercent, Insurance, FreightPercent, Freight, FreightDirect, ForeignCost, HScode, HsTarrif,
  CustomDuty, CustomSubCharge, ETLSCharge, LocalHandling, pLocalHandling, MarkUp, MarkUpDirect, markupperc, LocalCost, ExDDPrice, DELIVERY, WorkLocation, DeliveryToWrkLocation,
  Customer, Remark, Division, POLitID) VALUES ('$SONo', '$SOCusID', '$SOCusSName', '$MatSer', '$Description', '$Qty', '$UOM', '$Currency', '$UnitCost', '$ExCost', '$Discount', '$DiscountAmt', '$UnitWeight', '$ExWeight',
   '$PackingPercent', '$ExportPacking', '$InsurePercent', '$Insure', '$FreightPercent', '$FreightAmt', '$FreightDirect', '$ForeignCost', '$HScode', '$HsTarrif',
   '$CustomDuty', '$CustomSubCharge', '$ETLSCharge', '$LocalHandling', '$pLocalHandling', '$MarkUpAmt', '$MarkUpDirect', '$markupperc', '$LocalCost', '$ExDDPrice', '$DELIVERY', '$WorkLocation', '$DeliveryToWrkLocation',
   '$SOCusFName', '$Remark', '$SODiv', '$POLitID');"; 
	mysql_query($insQuery);

    }
    //exit;
  }
//echo $ItemDetails = $ItemDm;
//exit;

$ItemDetails = mysql_real_escape_string(trim($ItemD));





{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO so (SONum, SOType, Status, Customer, cusid, cusnme, CusONo, ItemsN, ItemsDetails, SubTotal, Tax, Total, SOdate, SOLocation, SOAssignStaff, ItemList, pTax, Attachment) 
VALUES ('$SONo','$SOType','0','$SOCusFName', '$SOCusID', '$SOCusSName', '$CusONo', '$N','$ItemDetails','$SubTotal','$sTax','$sTotal','$SODate', '$DeliLoc', '$SOSupSt', '$ItemIDs', '$pTax', '$DBfilelnk')";

$qresult = mysql_query($query);

if($qresult)
{

    if (isset($_POST['rev'])) {
     //Read SOCount
                  
    } else {
     
     $SOcount = mysql_query("SELECT * FROM sysvar WHERE variableName = 'SOCount'");
                  while ($row = mysql_fetch_array($SOcount)) { $nSOCount = $row{'variableValue'}; }

                  $nSOCount = intval($nSOCount) + 1;
       $query1 = "UPDATE sysvar SET variableValue='".$nSOCount."' WHERE variableName = 'SOCount'";
       mysql_query($query1, $dbhandle);
     
       // Alternate code
    }
 





$_SESSION['ErrMsgB'] = "Congratulations! New SO Raised, set To be treated by Purchasing";
notify_purchasing_of_project_so_creation($SONo, $SOType, $SOCusFName, $N, $ItemDetails);
header('Location: RaiseQchk');
}
else
{
$_SESSION['ErrMsg'] = mysql_error();
header('Location: RaiseQchk');
}
  



}
//close the connection
mysql_close($dbhandle);




?>