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
$CMSArray = $_POST['CMK'];
$LitID = "";

//Let's get the Other




$CusONo = $_POST['CusONoW'];
//Clear all invoice Items
  $queryINVITEM = "DELETE FROM salesinvoiceitems WHERE inovid = '$InvoiceID'";
  mysql_query($queryINVITEM);

 foreach ($ItemNamesArray as $value) {

    $LitID = $value['LitID'];
    
    if($LitID != "" && $LitID != null ) 
    {
      $LitID = $value['LitID'];
      $Description = $value['Description'];
      $MatSer = $value['MatSer'];
      $Qty = $value['Qty'];
      $UOM = $value['UOM'];
      $DiscountAmt = $value['DiscountAmt'];
    //$DiscountPer = $ItemNamesArray[$i]['DiscountPer'];
      $UnitCost = $value['UnitCost'];
      $ExtendedCost = $value['ExtendedCost'];

      if($Description != "") 
      {
      
        $queryIN = "INSERT INTO salesinvoiceitems (purid, inovid, Description, MatSer, Qty, UOM, UnitCost, ExtendedCost,
          DiscountPer, DiscountAmt, CreatedBy) 
                   VALUES ('$LitID','$InvoiceID', '$Description','$MatSer', '$Qty', '$UOM', '$UnitCost', '$ExtendedCost', 
          '$DiscountPer', '$DiscountAmt', '$Userid');";
        
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
 $queryCMC = "DELETE FROM salesinvoicecomm WHERE inovid = '$InvoiceID'";
  mysql_query($queryCMC);

  
$NCM = count($CMSArray);  //print_r($NCM); exit;
  for($i=0; $i < $NCM+1; $i++)
  {
    
    $CMDescription = $CMSArray[$i]['Description'];
    $CMDiscountPer = $CMSArray[$i]['DiscountPer'];


    if($CMDescription != "") 
    {
    
    $queryCM = "INSERT INTO salesinvoicecomm (inovid, Description, DiscountPer, CreatedBy) 
               VALUES ('$InvoiceID', '$CMDescription', '$CMDiscountPer', '$Userid');";
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
