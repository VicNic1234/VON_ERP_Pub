<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];


$VendorPONo = mysql_real_escape_string(trim(strip_tags($_POST['VendorPONo'])));

if($VendorPONo == "") {}
else 
{
  ///////////////////////////////////////////////////////////////
    $resultCusOrder = mysql_query("SELECT lineItID As LOGID, LitID As PURID, logistics.POID As LOGPO, SOCode, so.SONum, so.CusONo FROM logistics LEFT JOIN purchaselineitems 
      ON logistics.lineItID = purchaselineitems.LitID LEFT JOIN so ON purchaselineitems.SOCode = so.SONum WHERE logistics.POID='$VendorPONo'");
    $NoRowCusOrder = mysql_num_rows($resultCusOrder); 
    
    if($NoRowCusOrder > 0)
    {   
        while ($rowr = mysql_fetch_array($resultCusOrder))
        { 
          $SOCode = $rowr['SOCode'];
          $CusONo = $rowr['CusONo'];
        }
    }


////////////////////////////////////////////////////////////////////////
    $resultVenOrdNumLinetem = mysql_query("SELECT * FROM logistics LEFT JOIN po ON logistics.POID = po.PONum
    LEFT JOIN poinfo ON logistics.POID = poinfo.PONum
    WHERE po.PONum ='$VendorPONo'");
    $NoRowVenONo = mysql_num_rows($resultVenOrdNumLinetem); 
    
    if($NoRowVenONo > 0)
    {   $SN = 0; $SubT = 0.0;
        while ($row = mysql_fetch_array($resultVenOrdNumLinetem))
        { 
          $SN = $SN + 1; 
          $LogID = $row['logID'];
          $PONo = $row['POID'];
          //We need to Register it on the purchaseinvoiceitems table if not there
          $resultSII = mysql_query("SELECT * FROM purchaseinvoiceitems WHERE logid='$LogID'"); $NoRowSII = mysql_num_rows($resultSII);

          if($NoRowSII > 0)
          {
                  /*while ($row2 = mysql_fetch_array($resultSII))
                    { 
                      $InvoicLineItem .= '<tr id="li'.$SN.'">
                      <td><input type="hidden" name="POLineItem['.$SN.'][logid]" value="'.$row2['logid'].'" />'.$row2['logid'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][MatSer]" value="'.$row2['MatSer'].'" />'.$row2['MatSer'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][Description]" value="'.$row2['Description'].'" />'.$row2['Description'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][Qty]" value="'.$row2['Qty'].'" />'.$row2['Qty'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][UOM]" value="'.$row2['UOM'].'" />'.$row2['UOM'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][PODiscount]" value="'.$row2['DiscountAmt'].'" />'.$row2['DiscountAmt'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][UnitRate]" value="'.$row2['UnitCost'].'" />'.$row2['UnitCost'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][POAmt]" value="'.$row2['ExtendedCost'].'" />'.$row2['ExtendedCost'].'</td>
                      <td class="no-print"><i class="fa fa-edit" LogID="'.$row2['logid'].'" MatSer="'.$row2['MatSer'].
                      '" Description="'.$row2['Description'].'" Qty="'.$row2['Qty'].
                      '" UOM="'.$row2['UOM'].'" PODiscount="'.$row2['DiscountAmt'].
                      '" UnitRate="'.$row2['UnitCost'].'" POAmt="'.$row2['ExtendedCost'].
                      '" SNUM="'.$SN.
                      '" onclick="editLIT(this);"></i></td>
                      </tr>';
                      $Currenm = $row2['Currency'];  
                      $NGNCRate = $row2['NGNCRate'];  
                      $SubT = $SubT + $row2['ExtendedCost'];
                    }
                    */
          }
          else
          {
              $logID = $row['logID']; $MatSerm = $row['MartServNo']; $Descrim = $row['Description']; $Qtym = $row['Qty']; 
              $UOMm = $row['UOM']; $DisAmtm = $row['PODiscount']; $UnitCm = $row['UnitRate']; $ExtCm = $row['POAmt']; 
              $POCode = $row['POID']; $PONo = $row['POID']; 
              $venid = $row['SupplierID']; $Currenm = $row['CurrencySymb']; 
              //$DisAmtm = $row['DiscountAmt']; $UnitCm = $row['UnitCost']; $ExtCm = $row['ExtendedCost']; 
              
              $InvoicLineItem .= '<tr id="li'.$SN.'">
              <td><input type="hidden" name="POLineItem['.$SN.'][logID]" value="'.$row['logID'].'" />'.$row['logID'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][MatSer]" value="'.$row['MartServNo'].'" />'.$row['MartServNo'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][Description]" value="'.$row['Description'].'" />'.$row['Description'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][Qty]" value="'.$row['Qty'].'" />'.$row['Qty'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][UOM]" value="'.$row['UOM'].'" />'.$row['UOM'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][PODiscount]" value="'.$row['PODiscount'].'" />'.$row['PODiscount'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][UnitRate]" value="'.$row['UnitRate'].'" />'.$row['UnitRate'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][POAmt]" value="'.$row['POAmt'].'" />'.$row['POAmt'].'</td>
              <td class="no-print"><i style="display:none" class="fa fa-edit" logID="'.$row['logID'].'" MatSer="'.$row['MartServNo'].
              '" Description="'.$row['Description'].'" Qty="'.$row['Qty'].
              '" UOM="'.$row['UOM'].'" UnitRate="'.$row['UnitRate'].
              '" PODiscount="'.$row['PODiscount'].'" POAmt="'.$row['POAmt']. 
              '" SNUM="'.$SN.
              '" onclick="editLIT(this);"></i></td>
              </tr>';
              $SubT = $SubT + $row['POAmt'];
              //We need to insert it now to salesinvoice table
               //$querym = "INSERT INTO purchaseinvoiceitems (logid, POCode, POID, venid, Currency, MatSer, Description, Qty, UOM, DiscountAmt, UnitCost, ExtendedCost) 
               //VALUES ('$LogID', '$PONo', '$PONo', '$venid', '$Currenm', '$MatSerm','$Descrim','$Qtym','$UOMm','$DisAmtm','$UnitCm','$ExtCm');";
               //mysql_query($querym);

               $NewInvoice = "YES";
        }

        }
    }

    


}

////////////////////////////////////////////////////////////////////////////////////////
          /*
          $InvoicLineItem .= '<tr>
          <td><input type="hidden" name="POLineItem['.$row['LitID'].'][LitID]" value="'.$row['LitID'].'" />'.$row['LitID'].'</td>
          <td><input type="hidden" name="POLineItem['.$row['LitID'].'][MatSer]" value="'.$row['MatSer'].'" />'.$row['MatSer'].'</td>
          <td><input type="hidden" name="POLineItem['.$row['LitID'].'][Description]" value="'.$row['Description'].'" />'.$row['Description'].'</td>
          <td><input type="hidden" name="POLineItem['.$row['LitID'].'][Qty]" value="'.$row['Qty'].'" />'.$row['Qty'].'</td>
          <td><input type="hidden" name="POLineItem['.$row['LitID'].'][UOM]" value="'.$row['UOM'].'" />'.$row['UOM'].'</td>
          <td><input type="hidden" name="POLineItem['.$row['LitID'].'][DiscountAmt]" value="'.$row['DiscountAmt'].'" />'.$row['DiscountAmt'].'</td>
          <td><input type="hidden" name="POLineItem['.$row['LitID'].'][UnitCost]" value="'.$row['UnitCost'].'" />'.$row['UnitCost'].'</td>
          <td><input type="hidden" name="POLineItem['.$row['LitID'].'][ExtendedCost]" value="'.$row['ExtendedCost'].'" />'.$row['ExtendedCost'].'</td>
          <td class="no-print"><i class="fa fa-edit" LitID="'.$row['LitID'].'" MatSer="'.$row['MatSer'].
          '" Description="'.$row['Description'].'" Qty="'.$row['Qty'].
          '" UOM="'.$row['UOM'].'" DiscountAmt="'.$row['DiscountAmt'].
          '" UnitCost="'.$row['UnitCost'].'" ExtendedCost="'.$row['ExtendedCost'].
          '" onclick="editLIT(this);"></i></td>
          </tr>';
          $CusID = $row['cusid']; $TotalAmt = $row['Total']; 
          $Currency = $row['Currency'];
          */
////////////////////////////////////////////////////////////////////////////////////////////

$InvoiceDetails = array();
$InvoiceDetails['VenOdrdItemNum'] = $NoRowVenONo;
$InvoiceDetails['VenID'] = $CusID;
$InvoiceDetails['Curr'] = $Currenm;
$InvoiceDetails['NGNCRate'] = $NGNCRate;
$InvoiceDetails['InvNum'] = $InvNum; 
$InvoiceDetails['PurOrder'] = $CusONo; 
$InvoiceDetails['NewInvoice'] = $NewInvoice; 
$InvoiceDetails['SubTotal'] = $SubT; 
$InvoiceDetails['InvoiceItemTable'] = $InvoicLineItem; 
$InvoiceDetails['PurchaseOrderV'] = $VendorPONo; 
$InvoiceDetails['CusOrder'] = $CusONo; 
$InvoiceDetails['PESONum'] = $SOCode; 



echo json_encode($InvoiceDetails);


?>
