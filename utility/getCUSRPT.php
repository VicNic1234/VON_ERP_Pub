<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];

//Cutomers CHEVRON, EXXON, NLNG, TOTAL, OANDO, OTHERS
//CusID 5, 27, 10, 11, 8
$CusIDs = array(5, 27, 10, 11, 8);
//Set Result Arrays

//Create array for Table
//$TableArray = array();
//$TRowArray = array();
$TRowArray = "";

$WkNO = mysql_real_escape_string(trim(strip_tags($_POST['WkNo'])));

if($WkNO == 0 || $WkNO == "")
{
   foreach ($CusIDs as $CusID) 
   {
    //Let's get the customer's details now
    $resultCUS = mysql_query("SELECT * FROM customers WHERE cusid='$CusID' ");
    $NoRowCUS = mysql_num_rows($resultCUS);
    //Customer's Name
    while ($row = mysql_fetch_array($resultCUS)) { $CusNme = $row['CustormerNme']; }


    //We need to pull RFQ from DB now
    $resultRFQ = mysql_query("SELECT * FROM rfq WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr' AND cusid='$CusID' ");
    $NoRowRFQ = mysql_num_rows($resultRFQ);
    //Total RFQ Open
    $resultRFQOP = mysql_query("SELECT polineitems.Status, polineitems.RFQCode FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr' AND rfq.cusid='$CusID' AND polineitems.Status = 'OPEN' GROUP BY polineitems.RFQCode");
    $NoRowRFQOP = mysql_num_rows($resultRFQOP);
    //Total RFQ Quoted
    $resultRFQQ = mysql_query("SELECT polineitems.Status, polineitems.RFQCode, COUNT(*),  SUM(polineitems.ExtendedCost) As TotalAmtQ FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr' AND rfq.cusid='$CusID' AND polineitems.Status = 'QUOTED' GROUP BY polineitems.RFQCode");
    $NoRowRFQQ = mysql_num_rows($resultRFQQ);
    $AmtRFQQ = 0.0;
    //Total Amount Quoted
    while ($row = mysql_fetch_array($resultRFQQ)) { $AmtRFQQ = $AmtRFQQ +  $row['TotalAmtQ']; }
    //We need to pull RFQ on TQ
    $resultRFQTQ = mysql_query("SELECT polineitems.Status, polineitems.RFQCode, COUNT(*),  SUM(polineitems.ExtendedCost) As TotalAmtQ FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr' AND rfq.cusid='$CusID' AND polineitems.OnTQ = '1' GROUP BY polineitems.RFQCode");
    $NoRowRFQOnTQ = mysql_num_rows($resultRFQTQ);
    //(RFQ Quout + RFQ TQ + (RFQ Decline))/Total RFQ
    $HitRatio = (($NoRowRFQQ  + $NoRowRFQOnTQ)/$NoRowRFQ) * 100;
    //We need to get No of PO recived and PO value
    $resultINPO = mysql_query("SELECT purchaselineitems.Status, purchaselineitems.SOCode, COUNT(*),  SUM(purchaselineitems.ExtendedCost) As TotalAmtQ FROM purchaselineitems INNER JOIN so ON purchaselineitems.SOCode = so.SONum  WHERE RIGHT(so.SOdate,4) = '$BusinessYr' AND so.cusid='$CusID' AND purchaselineitems.Status = 'CLOSED' GROUP BY purchaselineitems.SOCode");
    $NoRowPO = mysql_num_rows($resultINPO);
    $AmtPO = 0.0;
    //Total Amount Quoted
    while ($row = mysql_fetch_array($resultINPO)) { $AmtPO = $AmtPO +  $row['TotalAmtQ']; }
    //Set array
    //$TRowArray = array();
    $TRowArray .= '<tr><td>'.$CusNme.'</td><td>'.$NoRowRFQ.'</td><td>'.$NoRowRFQQ.'</td><td>$ '.number_format($AmtRFQQ).'</td><td>'.$NoRowRFQOnTQ.'</td><td>'.ceil($HitRatio).'%</td><td>'. $NoRowRFQOP.'</td><td>'. $NoRowPO.'</td><td>$ '. number_format($AmtPO).'</td></tr>';
    /*$TRowArray['TRFQR'] = $NoRowRFQ;
    $TRowArray['TRFQQ'] = $NoRowRFQQ; 
    $TRowArray['TRFQQA'] = "$ ". number_format($AmtRFQQ);  
    $TRowArray['TRFQTQ'] = $NoRowRFQOnTQ;
    $TRowArray['TRFQHitR'] = ceil($HitRatio) ."%"; 
    $TRowArray['TRFQOPN'] = $NoRowRFQOP; 
    $TRowArray['POSRV'] = $NoRowPO;
    $TRowArray['POSVAL'] = "$ ". number_format($AmtPO);
    */

    //array_push($TableArray, $TRowArray);
    
   }
    
}



/*$summary = array();
$summary['TRFQR'] = $NoRowRFQ;
$summary['TRFQQ'] = $NoRowRFQQ; 
$summary['TRFQQA'] = "$ ". number_format($AmtRFQQ);  
$summary['TRFQTQ'] = $NoRowRFQOnTQ;
$summary['TRFQHitR'] = ceil($HitRatio) ."%"; 
$summary['TRFQOPN'] = $NoRowRFQOP; 
$summary['POSRV'] = $NoRowPO;
$summary['POSVAL'] = "$ ". number_format($AmtPO);
*/

//echo json_encode($TableArray);
echo $TRowArray;

?>
