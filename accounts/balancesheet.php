<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');

$PageTitle = "Balance Sheet";
$EXZ = $_POST['EXZ'];

 function DisplayAmt($DisAmt)
 {
     if($DisAmt < 0) { $DisAmt = ($DisAmt * -1); return "(". number_format($DisAmt, 2) . ")"; }
     else
     {
       return number_format($DisAmt, 2);
     }
    
 }
 
 function rmvneg($DisAmt)
 {
     if($DisAmt < 0) { $DisAmt = ($DisAmt * -1); return number_format($DisAmt, 2) ; }
     else
     {
       return number_format($DisAmt, 2);
     } 
 }

$FromD = $_POST['FromD'];
if($FromD != "")
{
$FromD = DateTime::createFromFormat('Y/m/d', $FromD)->format('Y/m/d');

$ToD = $_POST['ToD'];
$ToD = DateTime::createFromFormat('Y/m/d', $ToD)->format('Y/m/d');
}

//Let's compute NET Income Now
////INCOME
$INCOMEBAL = 0.0;
  $ChartClassMK = mysql_query("SELECT * FROM acc_chart_types Where class_id=3 ORDER BY name");
$NoRowClassMk = mysql_num_rows($ChartClassMK);
if ($NoRowClassMk > 0) {
  while ($row = mysql_fetch_array($ChartClassMK)) {
   $acctypeid = $row['id'];
   /////////////////////////////////////////////////////////////
    $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type='$acctypeid' ORDER BY account_name");
    $NoRowClass = mysql_num_rows($ChartClassQ);
    if ($NoRowClass > 0) {
      while ($row = mysql_fetch_array($ChartClassQ)) {
        $cid = $row{'mid'};
        $cname = $row['account_name'];
        $AccTClass = $cname;
        if(getTotalAmt($cid) != 0 && $EXZ == 1)
        {
            $INCOMEBAL += floatval(getTotalAmt($cid));
            //$RecChartMaster .= '<tr><td><a href="viewacct?TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. number_format(getTotalAmt($cid)).'</td></tr>';
        }
        else if ( $EXZ == 0)
         {
            $INCOMEBAL += floatval(getTotalAmt($cid));
            //$RecChartMaster .= '<tr><td><a href="viewacct?TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. number_format(getTotalAmt($cid)).'</td></tr>';
        }
       
       }
    
      }
   ////////////////////////////////////////////////////////////
   }

  }

//echo $INCOMEBAL. "<br/>"; //exit;

////EXPENSES
$EXPBAL = 0.0;
  $ChartClassMK = mysql_query("SELECT * FROM acc_chart_types Where class_id=4 ORDER BY name");
$NoRowClassMk = mysql_num_rows($ChartClassMK);
if ($NoRowClassMk > 0) {
  while ($row = mysql_fetch_array($ChartClassMK)) {
   $acctypeid = $row['id'];
   /////////////////////////////////////////////////////////////
    $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type='$acctypeid' ORDER BY account_name");
    $NoRowClass = mysql_num_rows($ChartClassQ);
    if ($NoRowClass > 0) {
      while ($row = mysql_fetch_array($ChartClassQ)) {
        $cid = $row{'mid'};
        $cname = $row['account_name'];
        $AccTClass = $cname;
        if(getTotalAmt($cid) != 0 && $EXZ == 1)
        {
            $EXPBAL += floatval(getTotalAmt($cid));
            //$RecChartMaster .= '<tr><td><a href="viewacct?TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. number_format(getTotalAmt($cid)).'</td></tr>';
        }
        else if ( $EXZ == 0)
         {
            $EXPBAL += floatval(getTotalAmt($cid));
            //$RecChartMaster .= '<tr><td><a href="viewacct?TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. number_format(getTotalAmt($cid)).'</td></tr>';
        }
       
       }
    
      }
   ////////////////////////////////////////////////////////////
   }

  }

//echo $EXPBAL; exit;
$NETINCOME = $INCOMEBAL - $EXPBAL;
//Let's Read ChartClass
$RecChartMaster = "";
//Let's get the Assest 

////////////////////NON CURRENT ASSSTE
    $RecChartMaster .= '<tr><td><b>ASSETS</b></td><td>-</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
    
    $T1 = 0.0;
/////////////////////// CURRENT ASSET
  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=1 ORDER BY name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   // $cid = $row{'id'};
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td> &nbsp; </td><td>&nbsp;</td></tr>';
   }

  }

  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=1 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    $DisAmt = getTotalAmt($cid);
    if($DisAmt != 0 && $EXZ == 1)
    {
        $T1 += floatval($DisAmt);
        
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. DisplayAmt($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
    else if ( $EXZ == 0)
     {
        
        $T1 += floatval($DisAmt);
        // if($DisAmt < 0) { $DisAmt = ($DisAmt * -1); }
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. DisplayAmt($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
   
   }

  }
  
  $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td></tr>';
 $RecChartMaster .= '<tr><td>Total Current Assets</td><td>&nbsp;</td><td>&nbsp;</td><td>'. DisplayAmt($T1).'</td></tr>';
 $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';

//////////////////////////////////////
$T9 = 0.0;
$ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=9 ORDER BY name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   // $cid = $row{'id'};
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
   }

  }

  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=9 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    $DisAmt = getTotalAmt($cid);
    //// 
    if($DisAmt != 0 && $EXZ == 1)
    {   
        $T9 += floatval($DisAmt);
        //if($DisAmt < 0) { $DisAmt = ($DisAmt * -1); }
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. DisplayAmt($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
    else if ( $EXZ == 0)
     {
        $T9 += floatval(getTotalAmt($cid));
        //if($DisAmt < 0) { $DisAmt = ($DisAmt * -1); }
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. DisplayAmt($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
    
   }

  }

 
 $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td></tr>';
  $RecChartMaster .= '<tr><td>Total Fixed Assets</td><td>&nbsp;</td><td>&nbsp;</td><td>'. DisplayAmt($T9).'</td></tr>';
 $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';

//////////////////////////////////////////
//////////////////////////////////////
$T2 = 0.0;
$ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=2 ORDER BY name");
$NoRowClass = mysql_num_rows($ChartClassQ);//
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   // $cid = $row{'id'};
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
   }

  }

  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=2 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    $DisAmt = getTotalAmt($cid);
    //// 
    if($DisAmt != 0 && $EXZ == 1)
    {   
        $T2 += floatval($DisAmt);
        //if($DisAmt < 0) { $DisAmt = ($DisAmt * -1); }
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. DisplayAmt($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
    else if ( $EXZ == 0)
     {
        $T2 += floatval($DisAmt);
        //if($DisAmt < 0) { $DisAmt = ($DisAmt * -1); }
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. DisplayAmt($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
    
   }

  }

 
  
 $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td></tr>';
 $RecChartMaster .= '<tr><td>Total Non-current Assets</td><td>&nbsp;</td><td>&nbsp;</td><td>'. DisplayAmt($T2).'</td></tr>';
 $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';

//////////////////////////////////////////
//////////////////////////////////////
$T12 = 0.0;
$ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=12 ORDER BY name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   // $cid = $row{'id'};
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
   }

  }

  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=12 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    $DisAmt = getTotalAmt($cid);
    //// 
    if($DisAmt != 0 && $EXZ == 1)
    {   
        $T12 += floatval($DisAmt);
        //if($DisAmt < 0) { $DisAmt = ($DisAmt * -1); }
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. DisplayAmt($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
    else if ( $EXZ == 0)
     {
        $T12 += floatval($DisAmt);
        //if($DisAmt < 0) { $DisAmt = ($DisAmt * -1); }
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. DisplayAmt($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
    
   }

  }

 
  
 $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td></tr>';
 $RecChartMaster .= '<tr><td>Total Other Assets</td><td>&nbsp;</td><td>&nbsp;</td><td>'. DisplayAmt($T12).'</td></tr>';
 $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
 //////////////////////////////////////////
$T11 = 0.0;
$ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=11 ORDER BY name");
$NoRowClass = mysql_num_rows($ChartClassQ);//
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   // $cid = $row{'id'};
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
   }

  }

  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=11 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    $DisAmt = getTotalAmt($cid);
    //// 
    if($DisAmt != 0 && $EXZ == 1)
    {   
        $T11 += floatval($DisAmt);
        //if($DisAmt < 0) { $DisAmt = ($DisAmt * -1); }
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. DisplayAmt($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
    else if ( $EXZ == 0)
     {
        $T11 += floatval($DisAmt);
        //if($DisAmt < 0) { $DisAmt = ($DisAmt * -1); }
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. DisplayAmt($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
    
   }

  }

 
 $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td></tr>';
  $RecChartMaster .= '<tr><td>Total Accumulated Depreciation</td><td>&nbsp;</td><td>&nbsp;</td><td>'. DisplayAmt($T11).'</td></tr>';
//$RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
//////////////////////////////////////////
  ///SUB TOTAL
$TOTALASSETS =  floatval($T1) + floatval($T9) + floatval($T12) + floatval($T2) + floatval($T11); //+ floatval($NETINCOME);
 
$RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="border-top: 2px solid #000">&nbsp;</td></tr>';
    $RecChartMaster .= '<tr style=""><td><b>TOTAL NET ASSETS</b></td><td>&nbsp;</td><td>&nbsp;</td><td style="border-bottom: 2px double #000"><b>'.DisplayAmt($TOTALASSETS).'</b></td></tr>';

 $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
 $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';


/////////////////////////////
    ////////////////////
    $RecChartMaster .= '<tr><td><b>EQUITIES AND LIABILITIES</b></td><td>-</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
$T10 = 0.0;
$ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=10 ORDER BY name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   // $cid = $row{'id'};
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
   }

  }

  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=10 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    $DisAmt = getTotalAmt($cid);
    //// 
   if($DisAmt != 0 && $EXZ == 1)
    {
        $T10 += floatval($DisAmt); 
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'.  ($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
    else if ( $EXZ == 0)
     {
        $T10 += floatval($DisAmt);
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. ($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
   
   }

  }
   
  ///SUB TOTAL
     $RecChartMaster .= '<tr><td>NET INCOME  </td><td>-</td><td style="border-bottom: 2px solid #000;">'. DisplayAmt($NETINCOME).'</td><td>&nbsp;</td></tr>';
      //$RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td> &nbsp; </td><td>&nbsp;</td></tr>';
    $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td></tr>';
 $RecChartMaster .= '<tr><td>Total Equity</td><td>&nbsp;</td><td>&nbsp;</td><td>'. DisplayAmt($T10 + $NETINCOME) .'</td></tr>';
   $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
 

/////////////////////// Non-current liability
$T4 = 0.0;
  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=4 ORDER BY name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   // $cid = $row{'id'};
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td> &nbsp; </td><td> &nbsp; </td></tr>';
   }

  }

$ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=4 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    $DisAmt = getTotalAmt($cid);
    if($DisAmt != 0 && $EXZ == 1)
    {
        $T4 += floatval($DisAmt);
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'.  rmvneg($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
    else if ( $EXZ == 0)
     {  $T4 += floatval($DisAmt);
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'.  rmvneg($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
   }

  }
 
 $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td></tr>';
  $RecChartMaster .= '<tr><td>Total Non-current Liabilities</td><td>&nbsp;</td><td>&nbsp;</td><td>'. number_format(($T4 * -1), 2) .'</td></tr>';
  $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
  /////////////////Current Liabilities

   $ChartClassQ = mysql_query("SELECT * FROM acc_chart_types Where id=3 ORDER BY name");
   $T3 = 0.0;
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
   // $cid = $row{'id'};
    $cname = $row['name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td> &nbsp; </td><td> &nbsp; </td></tr>';
   }

  }

  $ChartClassQ = mysql_query("SELECT * FROM acc_chart_master Where account_type=3 ORDER BY account_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'mid'};
    $cname = $row['account_name'];
    $AccTClass = $cname;
    $DisAmt = getTotalAmt($cid);
    if($DisAmt != 0 && $EXZ == 1)
    { 
        $T3 += floatval($DisAmt);
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'. rmvneg($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
    else if ( $EXZ == 0)
     {
         $T3 += floatval($DisAmt);
        $RecChartMaster .= '<tr><td><a href="tbviewacct?FromD='.$FromD.'&ToD='.$ToD.'&TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> <em>'.$AccTClass.'</em></td><td>-</td><td>'.  rmvneg($DisAmt).'</td><td>&nbsp;</td></tr>';
    }
   }

  }
    
   $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td style="border-top: 2px solid #000;">&nbsp;</td><td>&nbsp;</td></tr>';
 $RecChartMaster .= '<tr><td>Total Current Liabilities</td><td>&nbsp;</td><td>&nbsp;</td><td style="border-bottom: 2px solid #000;">'. DisplayAmt($T3).'</td></tr>';
 $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
 

$TOTALLIABILITY = floatval($T10) + floatval($T4) + floatval($T3) + floatval($NETINCOME);
  $RecChartMaster .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td> &nbsp; </td><td>&nbsp;</td></tr>';
    $RecChartMaster .= '<tr><td><b>TOTAL LIABILITIES & EQUITY</b></td><td>&nbsp;</td><td>&nbsp;</td><td style="border-bottom: 2px double #000;" ><b>'.DisplayAmt($TOTALLIABILITY).'</b></td></tr>';
    $RecChartMaster .= '<tr style="border-bottom: 2px solid #000"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';

$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];



?>
<?php
function getTotalAmt($MasterID)
{
    $MTOTAL = 0.0; $CRD = 0.0; $DRD = 0.0;
    $FromD = $GLOBALS['FromD']; 
   $ToD = $GLOBALS['ToD'];
  $resultChartMaster = mysql_query("SELECT *, acc_chart_class.cid AS ACLASS FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
               LEFT JOIN acc_chart_types ON acc_chart_master.account_type = acc_chart_types.id
             LEFT JOIN acc_chart_class ON acc_chart_types.class_id = acc_chart_class.cid
             WHERE postings.GLImpacted = $MasterID AND postings.isActive=1
             ");

            $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                $mid = $row['tncid'];
                $GLImpacted = $row['GLImpacted'];
                $acid = $row{'account_code'};
                $id2 = $row{'account_code2'};
                $name = $row['account_name'];
                $type_name = $row['name']; //ClassName
                $TT = $row['TransacType']; //ClassName
                $TD = $row['TransactionDate']; //ClassName
                $OPENBAL = $row['REQCODE'];
                $TD = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');

                $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
               
                $classID = $row['CID']; //ClassName
                $ACLASS = $row['ACLASS'];
                //if($OPENBAL == "OPEN BAL") 
                {
                        if($FromD == "")
                        {
                        if($TT =="CREDIT") { $CRD = $CRD + floatval($TAmount); } else {  }
                        if($TT =="DEBIT") { $DRD += floatval($TAmount); } else {  }
                        }
                        elseif ( $TD <= $ToD) //$FromD <= $TD &&
                        {
                         if($TT =="CREDIT") { $CRD = $CRD + floatval($TAmount); } else {  }
                         if($TT =="DEBIT") { $DRD += floatval($TAmount); } else {  }
                        }
                    
                
                }
                //$MTOTAL = $MTOTAL + floatval($TAmount);
              }

            }
            
           
              
              
             
                  //$MTOTAL = $DRD - $CRD;
                  
              if($ACLASS == 1 ||  $ACLASS == 4)
                {
                    //if($DRD != 0)
                    { $MTOTAL =  floatval($DRD) - floatval($CRD); }
                    //else { $MTOTAL = floatval($CRD);  }
                    
                }
                elseif ($ACLASS == 2 ||  $ACLASS == 5 ||  $ACLASS == 3)
                {
                   //if($CRD != 0) 
                   { $MTOTAL = floatval($CRD) - floatval($DRD); }
                  // else { $MTOTAL = floatval($DRD);  }
                }
             
                
                
          
            
            
        
  return $MTOTAL;
}

//exit;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Accounts - Balance Sheet</title>
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

 <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
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
            Accounts - Statement of Financial Position [Balance Sheet] Report
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Balance Sheet Report</li>
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
                  <h3 class="box-title">Balance Sheet Report</h3>
                  <div class="box-tools pull-right">
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      
                        <div class="col-md-6 col-md-offset-3" style="background-color: #FF6868; border-radius: 25px;">
                        <form role="form" action="balancesheet" method="POST" ><div class="form-group">
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
                     <input name="EXZ" type="checkbox" checked value="1"  /> Exclued Zero Balance Accounts </label> 
                     <?php } else { ?>
                     <input name="EXZ" type="checkbox" value="1"  /> Exclued Zero Balance Accounts </label>
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
                    <!-- <span class="btn btn-success pull-right" ><label> 
                     <?php if($EXZ == 1) { ?>
                     <input id="EXZ" type="checkbox" checked value="1" onclick="setZero(this)" /> Exclued Zero Balance Accounts </label> 
                     <?php } else { ?>
                     <input id="EXZ" type="checkbox" value="0" onclick="setZero(this)" /> Exclued Zero Balance Accounts </label>
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
                        <th colspan="4"><center style="font-size:1.5em">ELSHCON NIGERIA LIMITED</center></th>
                      </tr>
                      <tr>
                        <th colspan="4"><center style="font-size:1.5em">Balance Sheet</center></th>
                      </tr>
                      <tr>
                        <th colspan="4"><center style="font-size:1.2em">FROM: <?php echo $FromD; ?> &nbsp;  &nbsp;  &nbsp; TO: <?php echo $ToD; ?> </center></th>
                      </tr>
                       <tr>
                        <th>&nbsp;</th>
                        <th>Notes</th>
                        <th>NGN</th>
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
      <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js" type="text/javascript"></script>
   <!-- <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
     <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" type="text/javascript"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js" type="text/javascript"></script> -->
     <script src="../mBOOT/jquery-ui.js"></script>
    <script type="text/javascript">
     
    </script>

   <!--<script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>  -->
   <script src="../plugins/datatables/js.export2excel.js" type="text/javascript"></script> 
    
    <script type="text/javascript">
      $(function () {
        //$("#userTab").dataTable();
        /*$('#userTab').dataTable({
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": false,
          "bInfo": true,
          "bAutoWidth": true,
          dom: 'Bfrtip',
        buttons: [
            //'copy', 'csv', 'excel', 'pdf', 'print'
            'excel'
        ]
        });
        */
        
      });
    </script>
    <script type="text/javascript">
   
     function ExportToExcel()
      {
        var Dat = "Balance Sheet"; //+ new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "Balance Sheet",
              filename: "Balance Sheet",
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