<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];

$CusIDs = array(5, 27, 10, 11, 8);
$TRowArray = "";

$WkNO = mysql_real_escape_string(trim(strip_tags($_POST['WkNo'])));
$oFirstDay = mysql_real_escape_string(trim(strip_tags($_POST['FirstDay'])));
$oLastDay = mysql_real_escape_string(trim(strip_tags($_POST['LastDay'])));

 //2/1/2017
   $FirstDayEx = explode("/", $oFirstDay); $FirstDay = $FirstDayEx[2] . "-" . $FirstDayEx[1] . "-" . $FirstDayEx[0];
   $LastDayEx = explode("/", $oLastDay); $LastDay = $LastDayEx[2] . "-" . $LastDayEx[1] . "-" . $LastDayEx[0];

if($WkNO == 0 || $WkNO == "")
{
  //We need to pull RFQ from DB now
  //$resultRFQ = mysql_query("SELECT * FROM rfq INNER JOIN (SELECT DISTINCT RFQCode FROM polineitems) polineitems ON rfq.RFQNum = polineitems.RFQCode WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr'");
  $resultRFQ = mysql_query("SELECT * FROM rfq WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr'");
  $NoRowRFQ = mysql_num_rows($resultRFQ);
  //Total RFQ Open
  //$resultRFQQ = mysql_query("SELECT DISTINCT RFQCode FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr'");
  $resultRFQOP = mysql_query("SELECT polineitems.Status, polineitems.RFQCode FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr' AND polineitems.Status = 'OPEN' GROUP BY polineitems.RFQCode");
  $NoRowRFQOP = mysql_num_rows($resultRFQOP);
  //Total RFQ Quoted
  //$resultRFQQ = mysql_query("SELECT DISTINCT RFQCode FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr'");
  $resultRFQQ = mysql_query("SELECT polineitems.Status, polineitems.RFQCode, COUNT(*),  SUM(polineitems.ExtendedCost) As TotalAmtQ FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr' AND polineitems.Status = 'QUOTED' GROUP BY polineitems.RFQCode");
  $NoRowRFQQ = mysql_num_rows($resultRFQQ);
  $AmtRFQQ = 0.0;
  //Total Amount Quoted
   while ($row = mysql_fetch_array($resultRFQQ)) { $AmtRFQQ = $AmtRFQQ +  $row['TotalAmtQ']; }
   //We need to pull RFQ on TQ
  $resultRFQTQ = mysql_query("SELECT polineitems.Status, polineitems.RFQCode, COUNT(*),  SUM(polineitems.ExtendedCost) As TotalAmtQ FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr' AND polineitems.OnTQ = '1' GROUP BY polineitems.RFQCode");
  $NoRowRFQOnTQ = mysql_num_rows($resultRFQTQ);
   //we have to get Hit Ratio Now
  //(RFQ Quout + RFQ TQ + (RFQ Decline))/Total RFQ
   $HitRatio = (($NoRowRFQQ  + $NoRowRFQOnTQ)/$NoRowRFQ) * 100;
  //We need to get No of PO recived and PO value
  $resultINPO = mysql_query("SELECT purchaselineitems.Status, purchaselineitems.SOCode, COUNT(*),  SUM(purchaselineitems.ExtendedCost) As TotalAmtQ FROM purchaselineitems INNER JOIN so ON purchaselineitems.SOCode = so.SONum  WHERE RIGHT(so.SOdate,4) = '$BusinessYr' AND purchaselineitems.Status = 'CLOSED' GROUP BY purchaselineitems.SOCode");
  $NoRowPO = mysql_num_rows($resultINPO);
  $AmtPO = 0.0;

  //Total Amount Quoted
   while ($row = mysql_fetch_array($resultINPO)) { $AmtPO = $AmtPO +  $row['TotalAmtQ']; }  

}
else {
 
     //We need to pull RFQ from DB now
  //$resultRFQ = mysql_query("SELECT * FROM rfq INNER JOIN (SELECT DISTINCT RFQCode FROM polineitems) polineitems ON rfq.RFQNum = polineitems.RFQCode WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr'");
  $resultRFQ = mysql_query("SELECT * FROM rfq WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr' AND STR_TO_DATE(DateCreated, '%Y-%m-%d') between '$FirstDay' AND '$LastDay'");
  $NoRowRFQ = mysql_num_rows($resultRFQ);
  //Total RFQ Open
  //$resultRFQQ = mysql_query("SELECT DISTINCT RFQCode FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr'");
  $resultRFQOP = mysql_query("SELECT polineitems.Status, polineitems.RFQCode FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr' AND STR_TO_DATE(rfq.DateCreated, '%Y-%m-%d') between '$FirstDay' AND '$LastDay' AND polineitems.Status = 'OPEN' GROUP BY polineitems.RFQCode");
  $NoRowRFQOP = mysql_num_rows($resultRFQOP);
  //Total RFQ Quoted
  //$resultRFQQ = mysql_query("SELECT DISTINCT RFQCode FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr'");
  $resultRFQQ = mysql_query("SELECT polineitems.Status, polineitems.RFQCode, COUNT(*),  SUM(polineitems.ExtendedCost) As TotalAmtQ FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE STR_TO_DATE(rfq.DateCreated, '%Y-%m-%d') between '$FirstDay' AND '$LastDay' AND polineitems.Status = 'QUOTED' GROUP BY polineitems.RFQCode");
  $NoRowRFQQ = mysql_num_rows($resultRFQQ);
  $AmtRFQQ = 0.0;
  //Total Amount Quoted
   while ($row = mysql_fetch_array($resultRFQQ)) { $AmtRFQQ = $AmtRFQQ +  $row['TotalAmtQ']; }
   //We need to pull RFQ on TQ
  $resultRFQTQ = mysql_query("SELECT polineitems.Status, polineitems.RFQCode, COUNT(*),  SUM(polineitems.ExtendedCost) As TotalAmtQ FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE STR_TO_DATE(rfq.DateCreated, '%Y-%m-%d') between '$FirstDay' AND polineitems.OnTQ = '1' GROUP BY polineitems.RFQCode");
  $NoRowRFQOnTQ = mysql_num_rows($resultRFQTQ);
   //we have to get Hit Ratio Now
  //(RFQ Quout + RFQ TQ + (RFQ Decline))/Total RFQ
   $HitRatio = (($NoRowRFQQ  + $NoRowRFQOnTQ)/$NoRowRFQ) * 100;
  //We need to get No of PO recived and PO value
  $resultINPO = mysql_query("SELECT purchaselineitems.Status, purchaselineitems.SOCode, COUNT(*),  SUM(purchaselineitems.ExtendedCost) As TotalAmtQ FROM purchaselineitems INNER JOIN so ON purchaselineitems.SOCode = so.SONum  WHERE STR_TO_DATE(so.SOdate, '%d/%m/%Y') between '$oFirstDay' AND '$oLastDay' AND purchaselineitems.Status = 'CLOSED' GROUP BY purchaselineitems.SOCode");
  $NoRowPO = mysql_num_rows($resultINPO);
  $AmtPO = 0.0;

  //Total Amount Quoted
   while ($row = mysql_fetch_array($resultINPO)) { $AmtPO = $AmtPO +  $row['TotalAmtQ']; } 

}

//echo $WkNO = //"Loving God the more, The King of Glory"; // $_POST['WkNo'];


$summary = array();
$summary['nTRFQR'] = $NoRowRFQ;
$summary['nTRFQQ'] = $NoRowRFQQ; 
$summary['nTRFQQA'] = $AmtRFQQ;  
$summary['nTRFQTQ'] = $NoRowRFQOnTQ;
$summary['nTRFQHitR'] = $HitRatio; 
$summary['nTRFQOPN'] = $NoRowRFQOP; 
$summary['nPOSRV'] = $NoRowPO;
$summary['nPOSVAL'] = $AmtPO;

$summary['TRFQR'] = $NoRowRFQ;
$summary['TRFQQ'] = $NoRowRFQQ; 
$summary['TRFQQA'] = number_format($AmtRFQQ);  
$summary['TRFQTQ'] = $NoRowRFQOnTQ;
$summary['TRFQHitR'] =  ceil($HitRatio). "%"; 
$summary['TRFQOPN'] = $NoRowRFQOP; 
$summary['POSRV'] = $NoRowPO;
$summary['POSVAL'] = number_format($AmtPO);


///////////////////////////////////////////////////////TABLE /////////////////////////////////
$NoRowRFQPlus = 0.0; $NoRowRFQQPlus = 0.0; $AmtRFQQPlus = 0.0; $NoRowRFQOnTQPlus = 0.0; $HitRatioPlus = 0.0; 
$NoRowRFQOPPlus = 0.0; $NoRowPOPlus = 0.0; $AmtPOPlus = 0.0;
////////////////////////////////////////////////////////////////////
$cusArray = array(); $TRFQRArray = array(); $TRFQQArray = array(); $TRFQQAArray = array(); $TRFQTQArray = array(); 
    $TRFQHitRArray = array(); $TRFQOPNArray = array(); $POSRVArray = array(); $POSVALArray = array();

///////////////////////////////////////////////////////////////////////////

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
    $NoRowRFQPlus = $NoRowRFQPlus + $NoRowRFQ;
    //Total RFQ Open
    $resultRFQOP = mysql_query("SELECT polineitems.Status, polineitems.RFQCode FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr' AND rfq.cusid='$CusID' AND polineitems.Status = 'OPEN' GROUP BY polineitems.RFQCode");
    $NoRowRFQOP = mysql_num_rows($resultRFQOP);
    $NoRowRFQOPPlus = $NoRowRFQOPPlus + $NoRowRFQOP;
    //Total RFQ Quoted
    $resultRFQQ = mysql_query("SELECT polineitems.Status, polineitems.RFQCode, COUNT(*),  SUM(polineitems.ExtendedCost) As TotalAmtQ FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr' AND rfq.cusid='$CusID' AND polineitems.Status = 'QUOTED' GROUP BY polineitems.RFQCode");
    $NoRowRFQQ = mysql_num_rows($resultRFQQ);
    $NoRowRFQQPlus = $NoRowRFQQPlus + $NoRowRFQQ;
    $AmtRFQQ = 0.0;
    //Total Amount Quoted
    while ($row = mysql_fetch_array($resultRFQQ)) { $AmtRFQQ = $AmtRFQQ +  $row['TotalAmtQ']; }
    $AmtRFQQPlus = $AmtRFQQPlus + $AmtRFQQ;
    //We need to pull RFQ on TQ
    $resultRFQTQ = mysql_query("SELECT polineitems.Status, polineitems.RFQCode, COUNT(*),  SUM(polineitems.ExtendedCost) As TotalAmtQ FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE LEFT(rfq.DateCreated,4) = '$BusinessYr' AND rfq.cusid='$CusID' AND polineitems.OnTQ = '1' GROUP BY polineitems.RFQCode");
    $NoRowRFQOnTQ = mysql_num_rows($resultRFQTQ);
    $NoRowRFQOnTQPlus = $NoRowRFQOnTQPlus + $NoRowRFQOnTQ;
    //(RFQ Quout + RFQ TQ + (RFQ Decline))/Total RFQ
    $HitRatio = (($NoRowRFQQ  + $NoRowRFQOnTQ)/$NoRowRFQ) * 100;
    $HitRatioPlus = $HitRatioPlus + $HitRatio;
    //We need to get No of PO recived and PO value
    $resultINPO = mysql_query("SELECT purchaselineitems.Status, purchaselineitems.SOCode, COUNT(*),  SUM(purchaselineitems.ExtendedCost) As TotalAmtQ FROM purchaselineitems INNER JOIN so ON purchaselineitems.SOCode = so.SONum  WHERE RIGHT(so.SOdate,4) = '$BusinessYr' AND so.cusid='$CusID' AND purchaselineitems.Status = 'CLOSED' GROUP BY purchaselineitems.SOCode");
    $NoRowPO = mysql_num_rows($resultINPO);
    $NoRowPOPlus = $NoRowPOPlus + $NoRowPO;
    $AmtPO = 0.0;
    //Total Amount Quoted
    while ($row = mysql_fetch_array($resultINPO)) { $AmtPO = $AmtPO +  $row['TotalAmtQ']; }
    $AmtPOPlus = $AmtPOPlus + $AmtPO;
    //Set array
    //$TRowArray = array();
    $TRowArray .= '<tr><td style="background:#ACDDC7; font-size:10px;">'.$CusNme.'</td><td>'.$NoRowRFQ.'</td><td>'.$NoRowRFQQ.'</td><td>'.number_format($AmtRFQQ).'</td><td>'.$NoRowRFQOnTQ.'</td><td>'.ceil($HitRatio).'%</td><td>'. $NoRowRFQOP.'</td><td>'. $NoRowPO.'</td><td>'. number_format($AmtPO).'</td></tr>';
    $cusArray[] = $CusNme; 
    
    $TRFQRArray[] = $NoRowRFQ; $TRFQQArray[] = $NoRowRFQQ; $TRFQQAArray[] = $AmtRFQQ; $TRFQTQArray[] = $NoRowRFQOnTQ; 
    $TRFQHitRArray[] = ceil($HitRatio); $TRFQOPNArray[] = $NoRowRFQOP; $POSRVArray[] = $NoRowPO; $POSVALArray[] = $AmtPO;

   }
    
}
else
{
  
    
  foreach ($CusIDs as $CusID) 
   {
    //Let's get the customer's details now
    $resultCUS = mysql_query("SELECT * FROM customers WHERE cusid='$CusID' ");
    $NoRowCUS = mysql_num_rows($resultCUS);
    //Customer's Name
    while ($row = mysql_fetch_array($resultCUS)) { $CusNme = $row['CustormerNme']; $CusNmen = $row['CusNme']; }


    //We need to pull RFQ from DB now
    $resultRFQ = mysql_query("SELECT * FROM rfq WHERE STR_TO_DATE(DateCreated, '%Y-%m-%d') between '$FirstDay' AND '$LastDay' AND cusid='$CusID' ");
    $NoRowRFQ = mysql_num_rows($resultRFQ);
    $NoRowRFQPlus = $NoRowRFQPlus + $NoRowRFQ;
    //Total RFQ Open
    $resultRFQOP = mysql_query("SELECT polineitems.Status, polineitems.RFQCode FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE STR_TO_DATE(rfq.DateCreated, '%Y-%m-%d') between '$FirstDay' AND '$LastDay' AND rfq.cusid='$CusID' AND polineitems.Status = 'OPEN' GROUP BY polineitems.RFQCode");
    $NoRowRFQOP = mysql_num_rows($resultRFQOP);
    $NoRowRFQOPPlus = $NoRowRFQOPPlus + $NoRowRFQOP;
    //Total RFQ Quoted
    $resultRFQQ = mysql_query("SELECT polineitems.Status, polineitems.RFQCode, COUNT(*),  SUM(polineitems.ExtendedCost) As TotalAmtQ FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE STR_TO_DATE(DateCreated, '%Y-%m-%d') between '$FirstDay' AND '$LastDay' AND rfq.cusid='$CusID' AND polineitems.Status = 'QUOTED' GROUP BY polineitems.RFQCode");
    $NoRowRFQQ = mysql_num_rows($resultRFQQ);
    $NoRowRFQQPlus = $NoRowRFQQPlus + $NoRowRFQQ;
    $AmtRFQQ = 0.0;
    //Total Amount Quoted
    while ($row = mysql_fetch_array($resultRFQQ)) { $AmtRFQQ = $AmtRFQQ +  $row['TotalAmtQ']; }
    $AmtRFQQPlus = $AmtRFQQPlus + $AmtRFQQ;
    //We need to pull RFQ on TQ
    $resultRFQTQ = mysql_query("SELECT polineitems.Status, polineitems.RFQCode, COUNT(*),  SUM(polineitems.ExtendedCost) As TotalAmtQ FROM polineitems INNER JOIN rfq ON polineitems.RFQCode = rfq.RFQNum  WHERE STR_TO_DATE(rfq.DateCreated, '%Y-%m-%d') between '$FirstDay' AND '$LastDay' AND rfq.cusid='$CusID' AND polineitems.OnTQ = '1' GROUP BY polineitems.RFQCode");
    $NoRowRFQOnTQ = mysql_num_rows($resultRFQTQ);
    $NoRowRFQOnTQPlus = $NoRowRFQOnTQPlus + $NoRowRFQOnTQ;
    //(RFQ Quout + RFQ TQ + (RFQ Decline))/Total RFQ
    $HitRatio = (($NoRowRFQQ  + $NoRowRFQOnTQ)/$NoRowRFQ) * 100;
    $HitRatioPlus = $HitRatioPlus + $HitRatio;
    //We need to get No of PO recived and PO value
    $resultINPO = mysql_query("SELECT purchaselineitems.Status, purchaselineitems.SOCode, COUNT(*),  SUM(purchaselineitems.ExtendedCost) As TotalAmtQ FROM purchaselineitems INNER JOIN so ON purchaselineitems.SOCode = so.SONum  WHERE STR_TO_DATE(so.SOdate, '%d/%m/%Y') between '$oFirstDay' AND '$oLastDay' AND so.cusid='$CusID' AND purchaselineitems.Status = 'CLOSED' GROUP BY purchaselineitems.SOCode");
    $NoRowPO = mysql_num_rows($resultINPO);
    $NoRowPOPlus = $NoRowPOPlus + $NoRowPO;
    $AmtPO = 0.0;
    //Total Amount Quoted
    while ($row = mysql_fetch_array($resultINPO)) { $AmtPO = $AmtPO +  $row['TotalAmtQ']; }
    $AmtPOPlus = $AmtPOPlus + $AmtPO;
    //Set array
    //$TRowArray = array();
    $TRowArray .= '<tr><td style="background:#ACDDC7; font-size:10px;">'.$CusNme.'</td><td>'.$NoRowRFQ.'</td><td>'.$NoRowRFQQ.'</td><td>'.number_format($AmtRFQQ).'</td><td>'.$NoRowRFQOnTQ.'</td><td>'.ceil($HitRatio).'%</td><td>'. $NoRowRFQOP.'</td><td>'. $NoRowPO.'</td><td>'. number_format($AmtPO).'</td></tr>';
    $cusArray[] = $CusNme; 
   
    $TRFQRArray[] = $NoRowRFQ; $TRFQQArray[] = $NoRowRFQQ; $TRFQQAArray[] = $AmtRFQQ; $TRFQTQArray[] = $NoRowRFQOnTQ; 
    $TRFQHitRArray[] = ceil($HitRatio); $TRFQOPNArray[] = $NoRowRFQOP; $POSRVArray[] = $NoRowPO; $POSVALArray[] = $AmtPO;

   }

}

    $NoRowRFQ =  $summary['nTRFQR'] - $NoRowRFQPlus;
    $NoRowRFQQ = $summary['nTRFQQ'] - $NoRowRFQQPlus; 
    $AmtRFQQ = $summary['nTRFQQA'] - $AmtRFQQPlus;  
    $NoRowRFQOnTQ = $summary['nTRFQTQ'] - $NoRowRFQOnTQPlus;
    //$HitRatio = $summary['TRFQHitR'] - $HitRatioPlus;
    $HitRatio = (($NoRowRFQQ  + $NoRowRFQOnTQ)/$NoRowRFQ) * 100; 
    $NoRowRFQOP = $summary['nTRFQOPN'] - $NoRowRFQOPPlus; 
    $NoRowPO = $summary['nPOSRV'] - $NoRowPOPlus;
    $AmtPO = $summary['nPOSVAL'] - $AmtPOPlus;

    $TRowArray .= '<tr><td style="background:#ACDDC7; font-size:10px;">Others</td><td>'.$NoRowRFQ.'</td><td>'.$NoRowRFQQ.'</td><td>'.number_format($AmtRFQQ).'</td><td>'.$NoRowRFQOnTQ.'</td><td>'.ceil($HitRatio).'%</td><td>'. $NoRowRFQOP.'</td><td>'. $NoRowPO.'</td><td>'. number_format($AmtPO).'</td></tr>';
    $cusArray[] = "Others"; 
    $TRFQRArray[] = $NoRowRFQ; $TRFQQArray[] = $NoRowRFQQ; $TRFQQAArray[] = $AmtRFQQ; $TRFQTQArray[] = $NoRowRFQOnTQ; 
    $TRFQHitRArray[] = ceil($HitRatio); $TRFQOPNArray[] = $NoRowRFQOP; $POSRVArray[] = $NoRowPO; $POSVALArray[] = $AmtPO;

 $LineData = array();
 $LineData ['TRFQR'] = $ChartTRFQR;
 $summary['tabTAB'] = $TRowArray; 
 

 $ChartData = array(
    (object)array(
        'name' => 'Total RFQ',
        'data' => $TRFQRArray//[7.0, 6.9, 9.5, 14.5, 35.8, 42] //
    ),
    (object)array(
        'name' => 'Total RFQ Quoted',
        'data' => $TRFQQArray//[34, 4.2, 43.5, 8.5, 11.9, 15.2] //
    ),
   (object)array(
        'name' => 'RFQ On TQ',
        'data' => $TRFQTQArray//[3.9, 4.2, 5.7, 8.5, 11.9, 15.2]
    ),
   
     (object)array(
        'name' => 'Total RFQ Open',
        'data' => $TRFQOPNArray//[3.9, 4.2, 5.7, 8.5, 11.9, 15.2]
    ),
   
);

$ChartData = array(
    (object)array(
        'name' => 'Total RFQ Received',
        'data' => $TRFQRArray//[7.0, 6.9, 9.5, 14.5, 35.8, 42] //
    ),
    (object)array(
        'name' => 'Total RFQ Quoted',
        'data' => $TRFQQArray//[34, 4.2, 43.5, 8.5, 11.9, 15.2] //
    ),
   (object)array(
        'name' => 'RFQ On TQ',
        'data' => $TRFQTQArray//[3.9, 4.2, 5.7, 8.5, 11.9, 15.2]
    ),
   
     (object)array(
        'name' => 'Total RFQ Open',
        'data' => $TRFQOPNArray//[3.9, 4.2, 5.7, 8.5, 11.9, 15.2]
    ),
);

$TRFQRData = array(
    (object)array(
        'name' => 'Total RFQ Received',
        'data' => $TRFQRArray//[7.0, 6.9, 9.5, 14.5, 35.8, 42] //
    ),
);

$TRFQQData = array(
    (object)array(
        'name' => 'Total RFQ Quoted',
        'data' => $TRFQQArray//[7.0, 6.9, 9.5, 14.5, 35.8, 42] //
    ),
);

$TRFQTQData = array(
    (object)array(
        'name' => 'RFQ On TQ',
        'data' => $TRFQTQArray//[7.0, 6.9, 9.5, 14.5, 35.8, 42] //
    ),
);

$TRFQOPNData = array(
    (object)array(
        'name' => 'Total RFQ Open',
        'data' => $TRFQOPNArray//[7.0, 6.9, 9.5, 14.5, 35.8, 42] //
    ),
);



 $POChartData = array(
  
    (object)array(
        'name' => 'Total RFQ AMT Quoted (USD)',
        'data' => $TRFQQAArray//[34, 4.2, 43.5, 8.5, 11.9, 15.2] //
    ),
    (object)array(
        'name' => 'Total POs Value (USD)',
        'data' => $POSVALArray//[3.9, 4.2,45 , 8.5, 67, 15.2]
    )
    
);

 $POBAR = array(
  
    (object)array(
        'name' => 'Hit Ratio',
        'data' => $TRFQHitRArray//[3.9, 4.2,45 , 8.5, 67, 15.2]
    )
    
);

 $summary['chartDATA'] = $ChartData; 
 $summary['chartPODATA'] = $POChartData; 
 $summary['chartPOBAR'] = $POBAR;

 $summary['TRFQRData'] = $TRFQRData; 
 $summary['TRFQQData'] = $TRFQQData; 
 $summary['TRFQTQData'] = $TRFQTQData; 
 $summary['TRFQOPNData'] = $TRFQOPNData; 

echo json_encode($summary);


?>
