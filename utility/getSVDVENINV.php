<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];


$IvnID = mysql_real_escape_string(trim(strip_tags($_POST['IvnID'])));

if($IvnID == "") { echo "NoInvoic"; exit; }
else 
{
      //////////////////////////////////////////////////////////////////////////////
        $resultINV = mysql_query("SELECT * FROM purchaseinvoice WHERE InvoiceNo='$IvnID'"); 
        $NoRowINV = mysql_num_rows($resultINV);

          if($NoRowINV > 0)
          {
                  while ($row = mysql_fetch_array($resultINV))
                    { 
                       $InvNum = $row['InvoiceNo'];
                       $VenID = $row['venid'];
                       $PEELSO = $row['so'];
                       $PEEPONo = $row['OrderNo'];
                       $CusONo = $row['CusONo'];
                       $VendorCode = $row['VendorCode'];
                       $Currenm = $row['Currency']; 
                       $InvDate = $row['InvDate']; 
                       $TermDay = $row['TermDay']; 

                    }
          }
          

      ///////////////////////////////////////////////////////////////////////////////
     $resultSI = mysql_query("SELECT * FROM purchaseinvoiceitems WHERE inovid='$IvnID'"); $NoRowSI = mysql_num_rows($resultSI);

          if($NoRowSI > 0)
          {       $SN = 0; $SubT = 0.0;
                  while ($row2 = mysql_fetch_array($resultSI))
                    { 
                      $SN = $SN + 1;
                      $LiID = $row2['logid'];
                      if($LiID == 0) {$LiIDn = "-"; } else { $LiIDn = $LiID; }
                      $InvoicLineItem .= '<tr id="li'.$SN.'">
                      <td><input type="hidden" name="POLineItem['.$SN.'][logID]" value="'.$LiID.'" />'.$LiIDn.'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][MatSer]" value="'.$row2['MatSer'].'" />'.$row2['MatSer'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][Description]" value="'.$row2['Description'].'" />'.$row2['Description'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][Qty]" value="'.$row2['Qty'].'" />'.$row2['Qty'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][UOM]" value="'.$row2['UOM'].'" />'.$row2['UOM'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][PODiscount]" value="'.$row2['DiscountPer'].'" />'.$row2['DiscountPer'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][UnitRate]" value="'.$row2['UnitCost'].'" />'.$row2['UnitCost'].'</td>
                      <td><input type="hidden" name="POLineItem['.$SN.'][POAmt]" value="'.$row2['ExtendedCost'].'" />'.$row2['ExtendedCost'].'</td>
                      <td class="no-print"><i style="display:none" class="fa fa-edit" LitID="'.$LiID.'" MatSer="'.$row2['MatSer'].
                      '" Description="'.$row2['Description'].'" Qty="'.$row2['Qty'].
                      '" UOM="'.$row2['UOM'].'" PODiscount="'.$row2['DiscountPer'].
                      '" UnitRate="'.$row2['UnitCost'].'" POAmt="'.$row2['ExtendedCost'].
                      '" SNUM="'.$SN.
                      '" onclick="editLIT(this);"></i></td>
                      </tr>';
                       //$CusONon = $row2['CusONo'];
                       $SubT = $SubT +  $row2['ExtendedCost'];
                    }
          }


    $resultSII = mysql_query("SELECT * FROM purchaseinvoicecomm WHERE inovid='$IvnID'"); $NoRowSII = mysql_num_rows($resultSII);

          if($NoRowSII > 0)
          {       $SNn = 0; $ASubT = 0.0;
                  while ($row2 = mysql_fetch_array($resultSII))
                    { 
                      $SNn = $SNn + 1;
                      $CommPer = $row2['CommID'];
                      $CommPer = $row2['Nature'];
                      $CommPer = $row2['DiscountPer'];
                      $CommCost = ($CommPer * $SubT)/100;
                      $InvoicCommission .= '<tr id="'.$SNn.'">
                      
                      
                      <td colspan="6" align="right">
                      <input type="hidden" name="CMK['.$SNn.'][Description]" value="'.$row2['Description'].'" />
                      <input type="hidden" name="CMK['.$SNn.'][DiscountPer]" value="'.$row2['DiscountPer'].'" />
                      <input type="hidden" name="CMK['.$SNn.'][CommID]" value="'.$row2['CommID'].'" />
                      <input type="hidden" name="CMK['.$SNn.'][Nature]" value="'.$row2['Nature'].'" />
                      <b>'.$row2['Description'].' ('.$row2['DiscountPer'].'%)</b>
                      </td>

                      <td align="right"> <b>'.$Currenm.'</b> </td>
                      <td>'.number_format($CommCost,2).'</td>
                      <td class="no-print"><i class="text-red fa fa-trash"'.
                      '" Description="'.$row2['Description'].
                      '" DiscountPer="'.$row2['DiscountPer'].
                      '" rwID="'.$row2['siid'].
                      '" CMN="'.$SNn.
                      '" onclick="removeCOM(this);"></i></td>
                      </tr>';
                      if($row2['Nature'] == "add"){ $ASubT = $ASubT +  $CommCost; }
                      elseif($row2['Nature'] == "subtract"){ $SSubT = $SSubT +  $CommCost; }
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
//$InvoiceDetails['CurOdrdItemNum'] = $NoRowCusONo;
//$NoRowINV = 7;
$InvoiceDetails['VenID'] = $VenID;
$InvoiceDetails['Curr'] = $Currenm;  
$InvoiceDetails['InvDate'] = $InvDate; 
$InvoiceDetails['TermDay'] = $TermDay; 
$InvoiceDetails['InvNum'] = $InvNum; 
$InvoiceDetails['PurOrder'] = $PEEPONo; 
$InvoiceDetails['so'] = $PEELSO; 
$InvoiceDetails['CusONo'] = $CusONo; 
//$InvoiceDetails['PurOrder'] = $CusONo; 
$InvoiceDetails['SubTotal'] = number_format($SubT, 2); 
$InvoiceDetails['TTotal'] = number_format($ASubT + $SubT - $SSubT, 2);
$InvoiceDetails['TComm'] = number_format($ASubT);  //
$InvoiceDetails['TCommSub'] = number_format($SSubT);  

$InvoiceDetails['VendorCode'] = $VendorCode; 
$InvoiceDetails['InvoiceItemTable'] = $InvoicLineItem;  
$InvoiceDetails['InvoiceCommissionTable'] = $InvoicCommission;  



echo json_encode($InvoiceDetails);


?>
