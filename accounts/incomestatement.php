<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');


$EXZ = $_POST['EXZ'];

  

$FromD = $_POST['FromD'];
if($FromD != "")
{
$FromD = DateTime::createFromFormat('Y/m/d', $FromD)->format('Y/m/d');

$ToD = $_POST['ToD'];
$ToD = DateTime::createFromFormat('Y/m/d', $ToD)->format('Y/m/d');
}


//Before Anything We need to get Total Reveunes
//Let's Read ChartClass
$RecChartMaster = "";
//Let's get the Assest 
$TotalRevenues0 = getTotalRevenues();  $TotalRevenuesY0 = getTotalRevenuesY(); 
////////////////////NON CURRENT ASSSTE
    $RecChartMaster .= '<tr><td><b>REVENUES</b></td><td>-</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
$T7 = 0.0; $TY7 = 0.0; $SetAmtPerZ = 0.0; $SetAmtPerZY = 0.0;
$ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=7 ORDER BY name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   // $cid = $row{'id'};
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
   }

  }

  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=7 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    ////  
     
    if(getTotalAmt($cid) != 0 && $EXZ == 1)
    {
        
        $SetAmt = getTotalAmt($cid);  $SetAmtY = getTotalAmtYTD($cid);
        $SetAmtPer = ($SetAmt/$TotalRevenues0) * 100; $SetAmtPerY = ($SetAmtY/$TotalRevenuesY0) * 100;
        $SetAmtPerZ += $SetAmtPer; $SetAmtPerZY += $SetAmtPerY;
        
       $T7 += floatval($SetAmt);
       $TY7 += floatval($SetAmtY);
       
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>'. number_format($SetAmt, 2).'</td><td>'. number_format($SetAmtPer,2).'</td><td>'. number_format($SetAmtY, 2).'</td><td>'. number_format($SetAmtPerY,2).'</td></tr>';
    }
    else if ( $EXZ == 0)
     {
         $SetAmt = getTotalAmt($cid);  $SetAmtY = getTotalAmtYTD($cid);
        $SetAmtPer = ($SetAmt/$TotalRevenues0) * 100; $SetAmtPerY = ($SetAmtY/$TotalRevenuesY0) * 100;
        $SetAmtPerZ += $SetAmtPer; $SetAmtPerZY += $SetAmtPerY;
         $T7 += floatval($SetAmt);
       $TY7 += floatval($SetAmtY);
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>'. number_format($SetAmt, 2).'</td><td>'. number_format($SetAmtPer,2).'</td><td>'. number_format($SetAmtY, 2).'</td><td>'. number_format($SetAmtPerY,2).'</td></tr>';
    }
   }

  }

  ///SUB TOTAL
     $RecChartMaster .= '<tr><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td></tr>';
  $RecChartMaster .= '<tr style=""><td>Total Income</td><td style="border-bottom: 2px solid #000;">'.number_format($T7, 2).'</td><td>'.number_format($SetAmtPerZ, 2).'</td><td style="border-bottom: 2px solid #000;">'.number_format($TY7, 2).'</td><td>'.number_format($SetAmtPerZY, 2).'</td></tr>';
 // $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
    $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
$T8 = 0.0; $TY8 = 0.0; $SetAmtPerZ = 0.0; $SetAmtPerZY = 0.0;
/////////////////////// CURRENT ASSET
  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=8 ORDER BY name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   // $cid = $row{'id'};
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td> &nbsp; </td><td>&nbsp;</td><td>&nbsp;</td></tr>';
   }

  }

  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=8 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    if(getTotalAmt($cid) != 0 && $EXZ == 1)
    {
        $SetAmt = getTotalAmt($cid);  $SetAmtY = getTotalAmtYTD($cid);
        $SetAmtPer = ($SetAmt/$TotalRevenues0) * 100; $SetAmtPerY = ($SetAmtY/$TotalRevenuesY0) * 100;
        $SetAmtPerZ += $SetAmtPer; $SetAmtPerZY += $SetAmtPerY;
        
       $T8 += floatval($SetAmt); $TY8 += floatval($SetAmtY);
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>'. number_format($SetAmt, 2).'</td><td>-</td><td>'. number_format($SetAmtY, 2).'</td><td>-</td></tr>';
    }
    else if ( $EXZ == 0)
     {
         $SetAmt = getTotalAmt($cid);  $SetAmtY = getTotalAmtYTD($cid);
        $SetAmtPer = ($SetAmt/$TotalRevenues0) * 100; $SetAmtPerY = ($SetAmtY/$TotalRevenuesY0) * 100;
        $SetAmtPerZ += $SetAmtPer; $SetAmtPerZY += $SetAmtPerY;
        
       $T8 += floatval($SetAmt); $TY8 += floatval($SetAmtY);
       $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>'. number_format($SetAmt, 2).'</td><td>-</td><td>'. number_format($SetAmtY, 2).'</td><td>-</td></tr>';
    }
   }

  }

  ///SUB TOTAL

  $RecChartMaster .= '<tr style=""><td>Total Other Income</td><td style="border-bottom: 2px solid #000;">'.number_format($T8, 2).'</td><td>'.number_format($SetAmtPerZ, 2).'</td><td style="border-bottom: 2px solid #000;">'.number_format($TY8, 2).'</td><td>'.number_format($SetAmtPerZY, 2).'</td></tr>';

$RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
$RecChartMaster .= '<tr style=""><td><b><em>TOTAL REVENUES</em></b></td><td style="border-bottom: 2px solid #000;"><b>'.number_format($T8 + $T7,2).'</b></td><td>&nbsp;</td><td style="border-bottom: 2px solid #000;"><b>'.number_format($TY8 + $TY7, 2).'</b></td><td>&nbsp;</td></tr>';
$RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
$TotalRevenues = $T8 + $T7;
$TotalRevenuesY = $TY8 + $TY7;
$T6 = 0.0; $TY6 = 0.0; $SetAmtPerZ = 0.0; $SetAmtPerYZ = 0.0;
/////////////////////// Non-current liability
  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=6 ORDER BY name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   // $cid = $row{'id'};
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td> &nbsp; </td><td> &nbsp; </td><td> &nbsp; </td></tr>';
   }

  }

  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=6 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    if(getTotalAmt($cid) != 0 && $EXZ == 1)
    {
        $SetAmt = getTotalAmt($cid);  $SetAmtY = getTotalAmtYTD($cid);
        $SetAmtPer = ($SetAmt/$TotalRevenues) * 100; $SetAmtPerY = ($SetAmtY/$TotalRevenuesY) * 100;
        $SetAmtPerZ += $SetAmtPer; $SetAmtPerZY += $SetAmtPerY;
        
        
       $T6 += floatval($SetAmt); $TY6 += floatval($SetAmtY);
       
       
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>'. number_format($SetAmt, 2).'</td><td>'. number_format($SetAmtPer,2).'</td><td>'. number_format($SetAmtY, 2).'</td><td>'. number_format($SetAmtPerY,2).'</td></tr>';
    }
    else if ( $EXZ == 0)
     {
        $SetAmt = getTotalAmt($cid);  $SetAmtY = getTotalAmtYTD($cid);
        $SetAmtPer = ($SetAmt/$TotalRevenues) * 100; $SetAmtPerY = ($SetAmtY/$TotalRevenuesY) * 100;
        $SetAmtPerZ += $SetAmtPer; $SetAmtPerZY += $SetAmtPerY;
        
         $T6 += floatval($SetAmt); $TY6 += floatval($SetAmtY);
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>'. number_format(getTotalAmt($cid), 2).'</td><td>'. number_format($SetAmtPer,2).'</td><td>'. number_format($SetAmtY, 2).'</td><td>'. number_format($SetAmtPerY,2).'</td></tr>';
    }
   }

  }
 
  $RecChartMaster .= '<tr><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td></tr>';
//$RecChartMaster .= '<tr style=""><td><b><em>TOTAL REVENUES</em></b></td><td>-</td><td style="border-bottom: 2px solid #000;"><b>'.number_format($T8 + $T7).'</b></td></tr>';
  $RecChartMaster .= '<tr style=""><td><b><em>TOTAL COST OF SALES</em></b></td><td style="border-bottom: 2px solid #000;"><b>'. number_format($T6, 2).'</b></td><td>'.number_format($SetAmtPerZ, 2).'</td><td style="border-bottom: 2px solid #000;"><b>'. number_format($TY6, 2).'</b></td><td>'.number_format($SetAmtPerZY, 2).'</td></tr>';

$RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
$GROSSPROFIT = floatval($T7) + floatval($T8) - floatval($T6);
$GROSSPROFITY = floatval($TY7) + floatval($TY8) - floatval($TY6); // floatval($TotalRevenues) + floatval($T6);//
    $RecChartMaster .= '<tr style="border-bottom: 2px solid #000;"><td><b>GROSS PROFIT</b></td><td style="border-bottom: 2px solid #000;">'. number_format($GROSSPROFIT, 2).'</td><td>&nbsp;</td>
    </td><td style="border-bottom: 2px solid #000;">'. number_format($GROSSPROFITY, 2).'</td><td>&nbsp;</td></tr>';

 $RecChartMaster .= '<tr><td colspan="5"></td></tr>';
 //$RecChartMaster .= '<tr><td colspan="3"></td></tr>';

/////////////////////////////
    ////////////////////
    $RecChartMaster .= '<tr><td><b>EXPENSES</b></td><td>-</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
$T5 = 0.0; $TY5 = 0.0; $SetAmtPerZ = 0.0; $SetAmtPerYZ = 0.0;
$ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=5 ORDER BY name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   // $cid = $row{'id'};
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
   }

  }

  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=5 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    //// 
    if(getTotalAmt($cid) != 0 && $EXZ == 1)
    {
        $SetAmt = getTotalAmt($cid);  $SetAmtY = getTotalAmtYTD($cid);
        $SetAmtPer = ($SetAmt/$TotalRevenues) * 100; $SetAmtPerY = ($SetAmtY/$TotalRevenuesY) * 100;
        $SetAmtPerZ += $SetAmtPer; $SetAmtPerZY += $SetAmtPerY;
      
       $T5 += floatval($SetAmt); $TY5 += floatval($SetAmtY);
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>'. number_format(getTotalAmt($cid), 2).'</td><td>'. number_format($SetAmtPer,2).'</td><td>'. number_format(getTotalAmtYTD($cid), 2).'</td><td>'. number_format($SetAmtPerY,2).'</td></tr>';
    }
    else if ( $EXZ == 0)
     {
        $SetAmt = getTotalAmt($cid);  $SetAmtY = getTotalAmtYTD($cid);
        $SetAmtPer = ($SetAmt/$TotalRevenues) * 100; $SetAmtPerY = ($SetAmtY/$TotalRevenuesY) * 100;
        $SetAmtPerZ += $SetAmtPer; $SetAmtPerZY += $SetAmtPerY;
      
       $T5 += floatval($SetAmt); $TY5 += floatval($SetAmtY);
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>'. number_format(getTotalAmt($cid), 2).'</td><td>'. number_format($SetAmtPer,2).'</td><td>'. number_format(getTotalAmtYTD($cid), 2).'</td><td>'. number_format($SetAmtPerY,2).'</td></tr>';
    }
   }

  }

  ///SUB TOTAL
$RecChartMaster .= '<tr><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td></tr>';
   $RecChartMaster .= '<tr style="border-bottom: 2px solid #000"><td><b><em>TOTAL EXPENSES</em> </b></td><td style="border-bottom: 2px solid #000;">'. number_format($T5, 2).'</td><td>'.number_format($SetAmtPerZ, 2).'</td><td style="border-bottom: 2px solid #000;">'. number_format($TY5, 2).'</td><td>'.number_format($SetAmtPerZY, 2).'</td></tr>';

    $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
    $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';

  /////////////////TAX
/*
   $ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=3 ORDER BY name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td> &nbsp; </td></tr>';
   }

  }

  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=3 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><em>'.$AccTClass.'</em></td><td>-</td><td>'.getTotalAmt($cid).'</td></tr>';
   }

  }

  $RecChartMaster .= '<tr style="border-top: 2px solid #000"><td>Total Current Liabilities</td><td>-</td><td style="border-top: 2px solid #000; border-bottom: 2px solid #000;">-</td></tr>';

*/
$TOTALEXP = floatval($T5); //+ floatval($T6);
  //$RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
  // $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
   // $RecChartMaster .= '<tr style="border-bottom: 2px solid #000; border-top: 2px solid #000"><td><b>TOTAL EXPENSES</b></td><td>-</td><td style="border-bottom: 2px solid #000; border-top: 2px solid #000">'. number_format($TOTALEXP).'</td></tr>';
$NETPL = floatval($GROSSPROFIT) - floatval($T5);
$NETPLY = floatval($GROSSPROFITY) - floatval($TY5);
    //$RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
   // $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
    $RecChartMaster .= '<tr><td><b>NET PROFIT/LOSS</b></td><td style="border-bottom: 2px double #000;">'. number_format($NETPL, 2) .'</td><td>&nbsp;</td><td style="border-bottom: 2px double #000;">'. number_format($NETPLY, 2) .'</td><td>&nbsp;</td></tr>';
$RecChartMaster .= '<tr style="border-bottom: 2px solid #000;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';

$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];



?>
<?php
function getTotalAmt($MasterID)
{
    
   $FromD = $GLOBALS['FromD']; 
   $ToD = $GLOBALS['ToD'];
    $MTOTAL = 0.0;
   
    { 
        
        
        $resultChartMaster = mysql_query("SELECT * FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             
             WHERE acc_chart_master.mid = $MasterID AND postings.isActive=1
             ORDER BY acc_chart_master.mid, postings.TransactionDate");
    }
    
            $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                $mid = $row['tncid'];
                $acid = $row{'account_code'};
                $id2 = $row{'account_code2'};
                $name = $row['account_name'];
                $type_name = $row['name']; //ClassName
                $TT = $row['TransacType']; //ClassName
                $TD = $row['TransactionDate']; //ClassName
                if($TD != "")
                {
                $TDm = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');
                }
                
                $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
                $class_name = $row['ClassName']; //ClassName
                $classID = $row['CID']; //ClassName
                 if($FromD != "")
                 {
                        if($FromD <= $TDm && $TDm <= $ToD) //
                        {
                            if($TT =="CREDIT") { $CRD = $TAmount; } else { $CRD = ''; }
                            if($TT =="DEBIT") { $DRD = $TAmount; } else { $DRD = ''; }
                            $MTOTAL = $MTOTAL + floatval($TAmount);
                        }
                 }
                 else
                 {
                            if($TT =="CREDIT") { $CRD = $TAmount; } else { $CRD = ''; }
                            if($TT =="DEBIT") { $DRD = $TAmount; } else { $DRD = ''; }
                            $MTOTAL = $MTOTAL + floatval($TAmount);
                 }
                
              }

            }

  return $MTOTAL;
}

function getTotalAmtYTD($MasterID)
{
    
  $ToD = $GLOBALS['ToD'];
   $FromD = "2019/01/01";

  $resultChartMaster = mysql_query("SELECT * FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
            
             WHERE acc_chart_master.mid = $MasterID AND postings.isActive=1
             ORDER BY acc_chart_master.mid, postings.TransactionDate");
    
            $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                $mid = $row['tncid'];
                $acid = $row{'account_code'};
                $id2 = $row{'account_code2'};
                $name = $row['account_name'];
                $type_name = $row['name']; //ClassName
                $TT = $row['TransacType']; //ClassName
                $TD = $row['TransactionDate']; //ClassName
                if($TD != "")
                {
                $TDm = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');
                }
                
                $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
                $class_name = $row['ClassName']; //ClassName
                $classID = $row['CID']; //ClassName
                
                
                 if($FromD != "")
                 {
                        if($FromD <= $TDm && $TDm <= $ToD) //
                        {
                            if($TT =="CREDIT") { $CRD = $TAmount; } else { $CRD = ''; }
                            if($TT =="DEBIT") { $DRD = $TAmount; } else { $DRD = ''; }
                            $MTOTAL = $MTOTAL + floatval($TAmount);
                        }
                 }
                 else
                 {
                            if($TT =="CREDIT") { $CRD = $TAmount; } else { $CRD = ''; }
                            if($TT =="DEBIT") { $DRD = $TAmount; } else { $DRD = ''; }
                            $MTOTAL = $MTOTAL + floatval($TAmount);
                 }
                    
               
                
              }

            }

  return $MTOTAL;
}

function getTotalRevenues()
{
    $TypeID = 7;
  $FromD = $GLOBALS['FromD']; 
   $ToD = $GLOBALS['ToD'];
    $MTOTAL = 0.0;
    
     
         $resultChartMaster = mysql_query("SELECT * FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             LEFT JOIN acc_chart_types ON acc_chart_master.account_type = acc_chart_types.id
             WHERE (acc_chart_types.id = 7 OR acc_chart_types.id = 8)  AND postings.isActive=1");
   
   

         $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                $mid = $row['tncid'];
                $acid = $row{'account_code'};
                $id2 = $row{'account_code2'};
                $name = $row['account_name'];
                $type_name = $row['name']; //ClassName
                $TT = $row['TransacType']; //ClassName
                $TD = $row['TransactionDate']; //ClassName
                if($TD != "")
                {
                $TDm = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');
                }
                
                $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
                $class_name = $row['ClassName']; //ClassName
                $classID = $row['CID']; //ClassName
                
                if($ToD != "")
                 {
                        if( $TDm <= $ToD) //$FromD <= $TDm &&
                        {
                            if($TT =="CREDIT") { $CRD = $TAmount; } else { $CRD = ''; }
                            if($TT =="DEBIT") { $DRD = $TAmount; } else { $DRD = ''; }
                            $MTOTAL = $MTOTAL + floatval($TAmount);
                        }
                 }
                 else
                 {
                            if($TT =="CREDIT") { $CRD = $TAmount; } else { $CRD = ''; }
                            if($TT =="DEBIT") { $DRD = $TAmount; } else { $DRD = ''; }
                            $MTOTAL = $MTOTAL + floatval($TAmount);
                 }
               
                
              }

            }

  return $MTOTAL;
}

function getTotalRevenuesY()
{
    $TypeID = 7;
  $FromD = "2019/01/01";//$GLOBALS['FromD']; 
   $ToD = $GLOBALS['ToD'];
    $MTOTAL = 0.0;
    
     
         $resultChartMaster = mysql_query("SELECT * FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             LEFT JOIN acc_chart_types ON acc_chart_master.account_type = acc_chart_types.id
             WHERE (acc_chart_types.id = 7 OR acc_chart_types.id = 8)  AND postings.isActive=1");
   
   

         $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                $mid = $row['tncid'];
                $acid = $row{'account_code'};
                $id2 = $row{'account_code2'};
                $name = $row['account_name'];
                $type_name = $row['name']; //ClassName
                $TT = $row['TransacType']; //ClassName
                $TD = $row['TransactionDate']; //ClassName
                if($TD != "")
                {
                $TDm = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');
                }
                
                $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
                $class_name = $row['ClassName']; //ClassName
                $classID = $row['CID']; //ClassName
                
                
                 if($ToD != "")
                 {
                        if($FromD <= $TDm && $TDm <= $ToD) //
                        {
                            if($TT =="CREDIT") { $CRD = $TAmount; } else { $CRD = ''; }
                            if($TT =="DEBIT") { $DRD = $TAmount; } else { $DRD = ''; }
                            $MTOTAL = $MTOTAL + floatval($TAmount);
                        }
                 }
                 else
                 {
                            if($TT =="CREDIT") { $CRD = $TAmount; } else { $CRD = ''; }
                            if($TT =="DEBIT") { $DRD = $TAmount; } else { $DRD = ''; }
                            $MTOTAL = $MTOTAL + floatval($TAmount);
                 }
               
                
              }

            }

  return $MTOTAL;
}

//echo getTotalRevenues(); exit;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Accounts</title>
	<link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="../mBOOT/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../mBOOT/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
     <link href="../plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
       <link href="../mBOOT/jquery-ui.css" rel="stylesheet" type="text/css">
    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script type="text/javascript" src="../bootstrap/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	var preLoadTimer;
	var interchk = <?php echo $_SESSION['LockDownTime']; ?>;
	$(this).mousemove(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).keypress(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).scroll(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).mousedown(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	//checktime
	setInterval(function()
	{
	preLoadTimer++;
	if (preLoadTimer > 10)
	{
	window.location.href="../users/lockscreen";
	}
	}, interchk )//30 Secs

});


   function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    if (charCode == 189)
    {
      return true;
    }
    return true;
}
</script>


  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

       <?php include('../topmenu2.php') ?>
      <!-- Left side column. contains the logo and sidebar -->
        <?php include('leftmenu.php') ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Accounts - Income Statement [Profit/Loss] Report
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Profit/Loss Report</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <?php if ($G == "")
           {} else {
echo

'<div class="alert alert-danger alert-dismissable">' .
                                       '<i class="fa fa-info-circle"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                         '<center>'.  $G. '</center> '.
                                    '</div>' ; 
                  $_SESSION['ErrMsg'] = "";}

 if ($B == "")
           {} else {
echo

'<div class="alert alert-info alert-dismissable">' .
                                       '<i class="fa fa-info-circle"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                        '<center>'.  $B. '</center> '.
                                    '</div>' ; 
                  $_SESSION['ErrMsgB'] = "";}
?>
          <!-- Info boxes -->
          <div class="row">
           <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Profit/Loss Report</h3>
                  <div class="box-tools pull-right">
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      
                        <div class="col-md-6 col-md-offset-3" style="background-color: #FF6868; border-radius: 25px;">
                        <form role="form" action="incomestatement" method="POST" ><div class="form-group">
              <div class="form-group col-md-6">
                <label>From: </label>
                <input type="text" class="form-control datep" id="FromD" name="FromD" placeholder="Click to set date" value="<?php echo $FromD; ?>" readonly required >
              </div>
              <div class="form-group col-md-6">
                <label>To: </label>
                <input type="text" class="form-control datep" id="ToD" name="ToD" placeholder="Click to set date" readonly value="<?php echo $ToD; ?>" required >
              </div>
              <div class="form-group col-md-6">
                  <span class="btn btn-success pull-right" ><label> 
                     <?php if($EXZ == 1) { ?>
                     <input name="EXZ" type="checkbox" checked value="1"  /> Exclude Zero Balance Accounts </label> 
                     <?php } else { ?>
                     <input name="EXZ" type="checkbox" value="1"  /> Exclude Zero Balance Accounts </label>
                     <?php } ?>
                     </span>
              </div>
              <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i></button><br/></form>
              </div>
                      
                    </div> 
                  </div>
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                 <!--<button class="btn btn-success pull-right" id="addAcct" onclick="addAcc(this)" > Add Account Master</button>-->
                 <button class="btn btn-success pull-left" onclick="ExportToExcel()" > Export To Excel</button>
                 <!--<span class="btn btn-success pull-right" ><label> 
                     <?php if($EXZ == 1) { ?>
                     <input id="EXZ" type="checkbox" checked value="1" onclick="setZero(this)" /> Exclude Zero Balance Accounts </label> 
                     <?php } else { ?>
                     <input id="EXZ" type="checkbox" value="0" onclick="setZero(this)" /> Exclude Zero Balance Accounts </label>
                     <?php } ?>
                     </span>-->
                     <script>
                         function setZero(elem)
                         {
                             var EXZ = 0;
                             if($(elem).is(":checked"))
                             { EXZ = 1; } else { EXZ = 0; }
                             window.location = "?EXZ="+EXZ;
                         }
                     </script>
                </div><!-- /.box-header -->
                <div class="box-body">
                   <table id="userTab" class="table table-bordered table-striped">
                       <thead>
                            <tr>
                        <th colspan="5"><center style="font-size:1.5em">ELSHCON NIGERIA LIMITED</center></th>
                      </tr>
                      <tr>
                        <th colspan="5"><center style="font-size:1.5em">INCOME STATEMENT</center></th>
                      </tr>
                      <tr>
                        <th colspan="5"><center style="font-size:1.2em">FROM: <?php echo $FromD; ?> &nbsp;  &nbsp;  &nbsp; TO: <?php echo $ToD; ?> </center></th>
                      </tr>
                    </thead>
                    <thead>
                      <tr>
                        <th>--</th>
                        
                        <th>(NGN)</th>
                        <th>&nbsp;</th>
                        <th>Yr To Date (NGN)</th>
                        <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $RecChartMaster; ?>
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
            
        </div><!-- /.row -->


          

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

       <?php include('../footer.php') ?>
      

       <div class="row">

              <div class="box box-primary">
                
                
                <!-- Modal form-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                      </div>
                      <div class="modal-body" id="modal-bodyku">
                      </div>
                      <div class="modal-footer" id="modal-footerq">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end of modal ------------------------------>
                    </div>
    </div>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='../plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="../plugins/chartjs/Chart.min.js" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard2.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
     <script src="../mBOOT/jquery-ui.js"></script>
    <script type="text/javascript">
     
    </script>

    <script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>
    
    <script type="text/javascript">
     function ExportToExcel()
      {
        var Dat = "Profit/Loss"; //+ new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "Profit/Loss",
              filename: Dat,
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true
            });
      }
     </script>

     <script type="text/javascript">
       $(".datep").datepicker({dateFormat : 'yy/mm/dd', changeYear: true, changeMonth: true});
     </script>


  </body>
</html>