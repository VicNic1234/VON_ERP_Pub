<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];


//$CusNAMEID = mysql_real_escape_string(trim(strip_tags($_POST['POLineItem'])));
//print_r($_POST['POLineItem']);
//exit;
$ItemNamesArray = $_POST['POLineItem']; $InvoiceID = $_POST['InvoiceID'];
$PEPONUM = $_POST['PEPONUM'];
$CMSArray = $_POST['CMK'];
$LitID = "";

//Let's get the Other

//Clear all invoice Items
  $queryINVITEM = "DELETE FROM purchaseinvoiceitems WHERE inovid = '$InvoiceID'";
  mysql_query($queryINVITEM);
$SN = 0;
 foreach ($ItemNamesArray as $value) {
  $SN = $SN + 1;
    $logID = $value['logID'];
    
    if($logID != "" && $logID != null ) 
    {
      $logID = $value['logID'];
      $Description = $value['Description'];
      $MatSer = $value['MatSer'];
      $Qty = $value['Qty'];
      $UOM = $value['UOM'];
      $DiscountPer = $value['PODiscount'];
    //$DiscountPer = $ItemNamesArray[$i]['DiscountPer'];
      $UnitCost = $value['UnitRate'];
      $ExtendedCost = $value['POAmt'];

      if($Description != "") 
      {
      
        $queryIN = "INSERT INTO purchaseinvoiceitems (logid, snid, POCode, inovid, Description, MatSer, Qty, UOM, UnitCost, ExtendedCost,
          DiscountPer, CreatedBy) 
                   VALUES ('$logID','$SN', '$PEPONUM', '$InvoiceID', '$Description','$MatSer', '$Qty', '$UOM', '$UnitCost', '$ExtendedCost', 
          '$DiscountPer', '$Userid');";
        
          mysql_query($queryIN);
     
          ////////////////////////////////////////
      }

    }
  }

//echo  $LitIDm;
//exit;

/*
$N = count($ItemNamesArray);

for($i=0; $i < $N+1; $i++)
 
  {
    
    $LitID = $ItemNamesArray[$i]['LitID'];


    if($LitID != "" && $LitID != null ) 
    {
    //$LitIDm .= $Description ." <br/>";
    $Description = $ItemNamesArray[$i]['Description'];
    $MatSer = $ItemNamesArray[$i]['MatSer'];
    $Qty = $ItemNamesArray[$i]['Qty'];
    $UOM = $ItemNamesArray[$i]['UOM'];
    $DiscountAmt = $ItemNamesArray[$i]['DiscountAmt'];
    //$DiscountPer = $ItemNamesArray[$i]['DiscountPer'];
    $UnitCost = $ItemNamesArray[$i]['UnitCost'];
    $ExtendedCost = $ItemNamesArray[$i]['ExtendedCost'];

    $querym = "UPDATE salesinvoiceitems SET snid='$i', inovid = '$InvoiceID', Status = '0', MatSer = '$MatSer', Description = '$Description',
    Qty = '$Qty', UOM = '$UOM', UnitCost = '$UnitCost', ExtendedCost = '$ExtendedCost',
    DiscountPer = '$DiscountPer', DiscountAmt = '$DiscountAmt'
            WHERE purid = '$LitID'";
             mysql_query($querym);
    }

 
  }

*/

//Clear all commision
 $queryCMC = "DELETE FROM purchaseinvoicecomm WHERE inovid = '$InvoiceID'";
  mysql_query($queryCMC);

  
$NCM = count($CMSArray);  //print_r($NCM); exit;
  for($i=0; $i < $NCM+1; $i++)
  {
    
    $CMDescription = $CMSArray[$i]['Description'];
    $CMDiscountPer = $CMSArray[$i]['DiscountPer'];
    $CMCommID = $CMSArray[$i]['CommID'];
    $CMNature = $CMSArray[$i]['Nature'];


    if($CMDescription != "") 
    {
    
    $queryCM = "INSERT INTO purchaseinvoicecomm (inovid, PONum, Description, DiscountPer, Nature, CommID, CreatedBy) 
               VALUES ('$InvoiceID', '$PEPONUM','$CMDescription', '$CMDiscountPer','$CMNature', '$CMCommID', '$Userid');";
               mysql_query($queryCM);
    }

  }


 echo $InvoiceID;
////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////

//$InvoiceDetails = array();
//$InvoiceDetails['Msg'] = $Msg;




//echo $Msg;//json_encode($InvoiceDetails);


?>
