<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];

$CusIDs = array(5, 27, 10, 11, 8);
//$Divs = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
$TRowArray = "";

$WkNO = mysql_real_escape_string(trim(strip_tags($_POST['WkNo'])));
$oFirstDay = mysql_real_escape_string(trim(strip_tags($_POST['FirstDay'])));
$oLastDay = mysql_real_escape_string(trim(strip_tags($_POST['LastDay'])));

 //2/1/2017
   $FirstDayEx = explode("/", $oFirstDay); $FirstDay = $FirstDayEx[2] . "-" . $FirstDayEx[1] . "-" . $FirstDayEx[0];
   $LastDayEx = explode("/", $oLastDay); $LastDay = $LastDayEx[2] . "-" . $LastDayEx[1] . "-" . $LastDayEx[0];
   $NOPO = 0; $NOVAL = 0.0; $NOMRK = 0.0; $GWTHCHARTArray = array(); $BUSUNITArray = array(); $OEMCHARTArray = array();
   $OEMs = array(); $COMPCHARTArray = array(); $COMPs = array();
if($WkNO == 0 || $WkNO == "")
{
      //We need to pull Recieved POs
    $resultRPO = mysql_query("SELECT businessunit.BussinessUnit, SUM(MarkUp) As MarkUp,  SUM(ExtendedCost) As ExtendedCost, COUNT(*) As Count, Currency FROM purchaselineitems LEFT JOIN businessunit ON purchaselineitems.Division = businessunit.id WHERE LEFT(purchaselineitems.CreatedOn,4) = '$BusinessYr' GROUP BY purchaselineitems.Division");
    $NoRowRPO = mysql_num_rows($resultRPO);
    while ($row = mysql_fetch_array($resultRPO)) { 
      //We have to build the Table body now
      $BUSUNITArray[] = $row['BussinessUnit']; $GWTHCHARTArray[] = ceil($row['ExtendedCost']);
      $GrowthEngine .= '<tr><td>'.$row['BussinessUnit'].'</td><td>'.$row['Count'].'</td><td>'.$row['Currency'].' '. number_format(ceil($row['MarkUp'])).'</td><td>'.$row['Currency'].' '.number_format(ceil($row['ExtendedCost'])).'</td></tr>';
      $NOPO = $NOPO + $row['Count'];
      $NOVAL = $NOVAL + $row['ExtendedCost'];
      $NOMRK = $NOMRK + $row['MarkUp'];
      
    }

      //We need to pull Recieved POs
    $resultpCUS = mysql_query("SELECT businessunit.BussinessUnit, Customer, SUM(MarkUp) As MarkUp,  SUM(ExtendedCost) As ExtendedCost, COUNT(*) As Count, Currency FROM purchaselineitems LEFT JOIN businessunit ON purchaselineitems.Division = businessunit.id WHERE LEFT(purchaselineitems.CreatedOn,4) = '$BusinessYr' GROUP BY purchaselineitems.Customer");
    $NoRowpCUS = mysql_num_rows($resultpCUS);
    while ($row = mysql_fetch_array($resultpCUS)) { 
      //We have to build the Table body now
      $COMPs[] = $row['Customer'];
      $COMPCHARTArray[] = ceil($row['ExtendedCost']);
      $PERCUS .= '<tr><td>'.$row['Customer'].'</td><td>'.$row['Count'].'</td><td>'.$row['Currency'].' '.number_format(ceil($row['MarkUp'])).'</td><td>'.$row['Currency'].' '.number_format(ceil($row['ExtendedCost'])).'</td></tr>';

    }

      //We need to pull Recieved POs
    $resultpOEM = mysql_query("SELECT logistics.OEM As OEM, Customer, SUM(MarkUp) As MarkUp,  SUM(ExtendedCost) As ExtendedCost, COUNT(*) As Count, Currency FROM purchaselineitems LEFT JOIN logistics ON purchaselineitems.LitID = logistics.lineItID WHERE LEFT(purchaselineitems.CreatedOn,4) = '$BusinessYr' GROUP BY logistics.OEM");
    $NoRowpOEM = mysql_num_rows($resultpOEM);
    while ($row = mysql_fetch_array($resultpOEM)) { 
      //We have to build the Table body now
      $OEMs[] = $row['OEM'];
      $OEMCHARTArray[] = ceil($row['ExtendedCost']);
      $PEROEM .= '<tr><td>'.$row['OEM'].'</td><td>'.$row['Count'].'</td><td>'.$row['Currency'].' '.number_format(ceil($row['MarkUp'])).'</td><td>'.$row['Currency'].' '.number_format(ceil($row['ExtendedCost'])).'</td></tr>';

    }
   
}
else {

      //We need to pull Recieved POs
    $resultRPO = mysql_query("SELECT businessunit.BussinessUnit, SUM(MarkUp) As MarkUp,  SUM(ExtendedCost) As ExtendedCost, COUNT(*) As Count, purchaselineitems.CreatedOn, purchaselineitems.Currency FROM purchaselineitems LEFT JOIN businessunit ON purchaselineitems.Division = businessunit.id WHERE STR_TO_DATE(purchaselineitems.CreatedOn, '%Y-%m-%d') between '$FirstDay' AND '$LastDay' GROUP BY purchaselineitems.Division");
    $NoRowRPO = mysql_num_rows($resultRPO);
    while ($row = mysql_fetch_array($resultRPO)) { 
      //We have to build the Table body now
      $BUSUNITArray[] = $row['BussinessUnit']; $GWTHCHARTArray[] = ceil($row['ExtendedCost']);
      $GrowthEngine .= '<tr><td>'.$row['BussinessUnit'].'</td><td>'.$row['Count'].'</td><td>'.$row['Currency'].' '. number_format(ceil($row['MarkUp'])).'</td><td>'.$row['Currency'].' '.number_format(ceil($row['ExtendedCost'])).'</td></tr>';
      $NOPO = $NOPO + $row['Count'];
      $NOVAL = $NOVAL + $row['ExtendedCost'];
      $NOMRK = $NOMRK + $row['MarkUp'];

    }

     //We need to pull Recieved POs
    $resultpCUS = mysql_query("SELECT Customer, businessunit.BussinessUnit, SUM(MarkUp) As MarkUp,  SUM(ExtendedCost) As ExtendedCost, COUNT(*) As Count, purchaselineitems.CreatedOn, purchaselineitems.Currency FROM purchaselineitems LEFT JOIN businessunit ON purchaselineitems.Division = businessunit.id WHERE STR_TO_DATE(purchaselineitems.CreatedOn, '%Y-%m-%d') between '$FirstDay' AND '$LastDay' GROUP BY purchaselineitems.Customer");
    $NoRowpCUS = mysql_num_rows($resultpCUS);
    while ($row = mysql_fetch_array($resultpCUS)) { 
      //We have to build the Table body now
      $COMPs[] = $row['Customer'];
      $COMPCHARTArray[] = ceil($row['ExtendedCost']);
      $PERCUS .= '<tr><td>'.$row['Customer'].'</td><td>'.$row['Count'].'</td><td>'.$row['Currency'].' '.number_format(ceil($row['MarkUp'])).'</td><td>'.$row['Currency'].' '.number_format(ceil($row['ExtendedCost'])).'</td></tr>';

    }

      //We need to pull Recieved POs
    $resultpOEM = mysql_query("SELECT logistics.OEM As OEM, Customer, SUM(MarkUp) As MarkUp,  SUM(ExtendedCost) As ExtendedCost, COUNT(*) As Count, Currency FROM purchaselineitems LEFT JOIN logistics ON purchaselineitems.LitID = logistics.lineItID WHERE STR_TO_DATE(purchaselineitems.CreatedOn, '%Y-%m-%d') between '$FirstDay' AND '$LastDay' GROUP BY logistics.OEM");
    $NoRowpOEM = mysql_num_rows($resultpOEM);
    while ($row = mysql_fetch_array($resultpOEM)) { 
      //We have to build the Table body now
      $OEMs[] = $row['OEM'];
      $OEMCHARTArray[] = ceil($row['ExtendedCost']);
      $PEROEM .= '<tr><td>'.$row['OEM'].'</td><td>'.$row['Count'].'</td><td>'.$row['Currency'].' '.number_format(ceil($row['MarkUp'])).'</td><td>'.$row['Currency'].' '.number_format(ceil($row['ExtendedCost'])).'</td></tr>';

    }
 
  
}

$summary = array();

$GWTHCHART = array(
  
    (object)array(
        'name' => 'PO Values',
        'data' => $GWTHCHARTArray//[3.9, 4.2,45 , 8.5, 67, 15.2]
    )
    
); 

$OEMCHART = array(
  
    (object)array(
        'name' => 'OEMs',
        'data' => $OEMCHARTArray//[3.9, 4.2,45 , 8.5, 67, 15.2]
    )
    
);

$COMPCHART = array(
  
    (object)array(
        'name' => 'Companies',
        'data' => $COMPCHARTArray//[3.9, 4.2,45 , 8.5, 67, 15.2]
    )
    
);

$summary['OEMs'] = $OEMs; 
$summary['COMPs'] = $COMPs; 
$summary['BUSUNIT'] = $BUSUNITArray; 
$summary['GWTHCHART'] = $GWTHCHART;
$summary['OEMCHART'] = $OEMCHART;
$summary['COMPCHART'] = $COMPCHART;
$summary['GrowthEngine'] = $GrowthEngine;
$summary['PERCUS'] = $PERCUS;
$summary['NOPO'] = number_format($NOPO);
$summary['NOVAL'] = number_format($NOVAL);
$summary['NOMRK'] = number_format($NOMRK); 
$summary['PEROEM'] = $PEROEM;

echo json_encode($summary);


?>
