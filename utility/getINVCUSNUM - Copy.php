<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];


$CusOrdNumID = mysql_real_escape_string(trim(strip_tags($_POST['CusOrdNum'])));
/*
if($CusOrdNumID == "") {}
else 
{

    $resultCusOrdNumLinetem = mysql_query("SELECT * FROM purchaselineitems LEFT JOIN so ON purchaselineitems.SOCode = so.SONUM WHERE so.poID =$CusOrdNumID ");
    $NoRowCusONo = mysql_num_rows($resultCusOrdNumLinetem);
    if($NoRowCusONo > 0)
    {   $SN = 0; $SubT = 0.0;
        while ($row = mysql_fetch_array($resultCusOrdNumLinetem))
        { 
          $SN = $SN + 1; 
          $LitID = $row['LitID'];
          $CusONo = $row['CusONo'];
          $Currenm = $row['Currency']; 

          //We need to Register it on the salesinvoiceitems table if not there
          //$siiid = mysql_result(mysql_query("SELECT purid FROM salesinvoiceitems WHERE purid='$LitID'"),0);
          $resultSII = mysql_query("SELECT * FROM salesinvoiceitems WHERE purid='$LitID'"); $NoRowSII = mysql_num_rows($resultSII);

          if($NoRowSII > 0)
          {
                  /*while ($row2 = mysql_fetch_array($resultSII))
                    { 
                      $InvoicLineItem .= '<tr id="li'.$SN.'">
                      <td><input type="hidden" name="POLineItem[][LitID]" value="'.$row2['purid'].'" />'.$row2['purid'].'</td>
                      <td><input type="hidden" name="POLineItem[][MatSer]" value="'.$row2['MatSer'].'" />'.$row2['MatSer'].'</td>
                      <td><input type="hidden" name="POLineItem[][Description]" value="'.$row2['Description'].'" />'.$row2['Description'].'</td>
                      <td><input type="hidden" name="POLineItem[][Qty]" value="'.$row2['Qty'].'" />'.$row2['Qty'].'</td>
                      <td><input type="hidden" name="POLineItem[][UOM]" value="'.$row2['UOM'].'" />'.$row2['UOM'].'</td>
                      <td><input type="hidden" name="POLineItem[][DiscountAmt]" value="'.$row2['DiscountAmt'].'" />'.$row2['DiscountAmt'].'</td>
                      <td><input type="hidden" name="POLineItem[][UnitCost]" value="'.$row2['UnitCost'].'" />'.$row2['UnitCost'].'</td>
                      <td><input type="hidden" name="POLineItem[][ExtendedCost]" value="'.$row2['ExtendedCost'].'" />'.$row2['ExtendedCost'].'</td>
                      <td class="no-print"><i class="fa fa-edit" LitID="'.$row2['purid'].'" MatSer="'.$row2['MatSer'].
                      '" Description="'.$row2['Description'].'" Qty="'.$row2['Qty'].
                      '" UOM="'.$row2['UOM'].'" DiscountAmt="'.$row2['DiscountAmt'].
                      '" UnitCost="'.$row2['UnitCost'].'" ExtendedCost="'.$row2['ExtendedCost'].
                      '" SNUM="'.$SN.
                      '" onclick="editLIT(this);"></i></td>
                      </tr>';
                      $Currenm = $row2['Currency'];  
                      $NGNCRate = $row2['NGNCRate'];  
                      $SubT = $SubT + $row2['ExtendedCost'];
                      
                    }
                    
          }
          else
          {
              
              $LITIDm = $row['LitID']; $MatSerm = $row['MatSer']; $Descrim = $row['Description']; $Qtym = $row['Qty']; 
              $UOMm = $row['UOM']; $DisAmtm = $row['DiscountAmt']; $UnitCm = $row['UnitCost']; $ExtCm = $row['ExtendedCost']; 
              $SOCode = $row['SOCode']; $CusONo = $row['CusONo']; $Customerm = $row['Customer']; $cusnme = $row['cusnme']; 
              $cusid = $row['cusid']; $Currenm = $row['Currency']; 
              //$DisAmtm = $row['DiscountAmt']; $UnitCm = $row['UnitCost']; $ExtCm = $row['ExtendedCost']; 
              
              $InvoicLineItem .= '<tr id="li'.$SN.'">
              <td><input type="hidden" name="POLineItem['.$SN.'][LitID]" value="'.$row['LitID'].'" />'.$row['LitID'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][MatSer]" value="'.$row['MatSer'].'" />'.$row['MatSer'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][Description]" value="'.$row['Description'].'" />'.$row['Description'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][Qty]" value="'.$row['Qty'].'" />'.$row['Qty'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][UOM]" value="'.$row['UOM'].'" />'.$row['UOM'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][DiscountAmt]" value="'.$row['DiscountAmt'].'" />'.$row['DiscountAmt'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][UnitCost]" value="'.$row['UnitCost'].'" />'.$row['UnitCost'].'</td>
              <td><input type="hidden" name="POLineItem['.$SN.'][ExtendedCost]" value="'.$row['ExtendedCost'].'" />'.$row['ExtendedCost'].'</td>
              <td class="no-print"><i class="fa fa-edit" LitID="'.$row['LitID'].'" MatSer="'.$row['MatSer'].
              '" Description="'.$row['Description'].'" Qty="'.$row['Qty'].
              '" UOM="'.$row['UOM'].'" DiscountAmt="'.$row['DiscountAmt'].
              '" UnitCost="'.$row['UnitCost'].'" ExtendedCost="'.$row['ExtendedCost']. 
              '" SNUM="'.$SN.
              '" onclick="editLIT(this);"></i></td>
              </tr>';
              $SubT = $SubT + $row['ExtendedCost'];
              //We need to insert it now to salesinvoice table
              /* $querym = "INSERT INTO salesinvoiceitems (purid, SOCode, CusONo, Customer, cusnme, cusid, Currency, MatSer, Description, Qty, UOM, DiscountAmt, UnitCost, ExtendedCost) 
               VALUES ('$LITIDm', '$SOCode', '$CusONo', '$Customerm','$cusnme','$cusid', '$Currenm', '$MatSerm','$Descrim','$Qtym','$UOMm','$DisAmtm','$UnitCm','$ExtCm');";
               mysql_query($querym);
               

               $NewInvoice = "YES";
               
        }

        }
    }

    


}
*/
////////////////////////////////////////////////////////////////////////////////////////
if($CusOrdNumID == "") {}
else 
{
    $resultCusOrdNumLinetem = mysql_query("SELECT * FROM so WHERE poID ='$CusOrdNumID'");
    $NoRowCusONo = mysql_num_rows($resultCusOrdNumLinetem);
    if($NoRowCusONo > 0)
    {  $SN = 0; $SubT = 0.0;
        while ($row = mysql_fetch_array($resultCusOrdNumLinetem))
        { 
         
         $ItemsDetails = $row['ItemsDetails'];
        
        }
    }

    $ItemDetail = explode("<br>",$ItemsDetails);
    $N = count($ItemDetail);

    /*
        $LITIDm = $row['LitID']; $MatSerm = $row['MatSer']; $Descrim = $row['Description']; $Qtym = $row['Qty']; 
              $UOMm = $row['UOM']; $DisAmtm = $row['DiscountAmt']; $UnitCm = $row['UnitCost']; $ExtCm = $row['ExtendedCost']; 
              $SOCode = $row['SOCode']; $CusONo = $row['CusONo']; $Customerm = $row['Customer']; $cusnme = $row['cusnme']; 
              $cusid = $row['cusid']; $Currenm = $row['Currency'];
    */

    for($i=0; $i < $N; $i++)
    {
    
     $RawITD = explode("@&@",$ItemDetail[$i]);
     //$ItemDm .= $RawITD[2]."<br/>";
     $POLitID = $RawITD[1];
     $SN = $SN + 1;
           $resultPOLinetem = mysql_query("SELECT * FROM polineitems WHERE LitID ='$POLitID'");
           //$NoRowPOLine= mysql_num_rows($resultPOLinetem);
             while ($row = mysql_fetch_array($resultPOLinetem))
              { 
               
                $LITIDm = $row['LitID']; $MatSerm = $row['MatSer']; $Descrim = $row['Description']; $Qtym = $row['Qty']; 
                $UOMm = $row['UOM']; $DisAmtm = $row['DiscountAmt']; $UnitCm = $row['UnitCost']; $ExtCm = $row['ExtendedCost']; 
                //$SOCode = $row['SOCode']; $CusONo = $row['CusONo']; $Customerm = $row['Customer']; $cusnme = $row['cusnme']; 
                //$cusid = $row['cusid']; 
                $Currenm = $row['Currency'];

                $InvoicLineItem .= '<tr id="li'.$SN.'">
                <td><input type="hidden" name="POLineItem['.$SN.'][LitID]" value="'.$row['LitID'].'" />'.$row['LitID'].'</td>
                <td><input type="hidden" name="POLineItem['.$SN.'][MatSer]" value="'.$row['MatSer'].'" />'.$row['MatSer'].'</td>
                <td><input type="hidden" name="POLineItem['.$SN.'][Description]" value="'.$row['Description'].'" />'.$row['Description'].'</td>
                <td><input type="hidden" name="POLineItem['.$SN.'][Qty]" value="'.$row['Qty'].'" />'.$row['Qty'].'</td>
                <td><input type="hidden" name="POLineItem['.$SN.'][UOM]" value="'.$row['UOM'].'" />'.$row['UOM'].'</td>
                <td><input type="hidden" name="POLineItem['.$SN.'][DiscountAmt]" value="'.$row['DiscountAmt'].'" />'.$row['DiscountAmt'].'</td>
                <td><input type="hidden" name="POLineItem['.$SN.'][UnitCost]" value="'.$row['UnitCost'].'" />'.$row['UnitCost'].'</td>
                <td><input type="hidden" name="POLineItem['.$SN.'][ExtendedCost]" value="'.$row['ExtendedCost'].'" />'.$row['ExtendedCost'].'</td>
                <td class="no-print"><i class="fa fa-edit" LitID="'.$row['LitID'].'" MatSer="'.$row['MatSer'].
                '" Description="'.$row['Description'].'" Qty="'.$row['Qty'].
                '" UOM="'.$row['UOM'].'" DiscountAmt="'.$row['DiscountAmt'].
                '" UnitCost="'.$row['UnitCost'].'" ExtendedCost="'.$row['ExtendedCost']. 
                '" SNUM="'.$SN.
                '" onclick="editLIT(this);"></i></td>
                </tr>';
                $SubT = $SubT + $row['ExtendedCost'];
              
              }
          


    }
}
////////////////////////////////////////////////////////////////////////////////////////////

$InvoiceDetails = array();
$InvoiceDetails['CurOdrdItemNum'] = $NoRowCusONo;
$InvoiceDetails['CusID'] = $CusID;
$InvoiceDetails['Curr'] = $Currenm;
$InvoiceDetails['NGNCRate'] = $NGNCRate;
$InvoiceDetails['InvNum'] = $InvNum; 
$InvoiceDetails['PurOrder'] = $CusONo; 
$InvoiceDetails['NewInvoice'] = $NewInvoice; 
$InvoiceDetails['SubTotal'] = $SubT; 
$InvoiceDetails['InvoiceItemTable'] = $InvoicLineItem; 



echo json_encode($InvoiceDetails);


?>
