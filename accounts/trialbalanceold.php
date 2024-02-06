<?php
session_start();
error_reporting(0);
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/ 
include ('../DBcon/db_config.php');
include('route.php');

$EXZ = $_POST['EXZ'];

function GetEnlInvoice($IVNO)
{
     $resultCHAMT = mysql_query("SELECT * FROM enlinvoices WHERE cid = '$IVNO' AND isActive=1");
            //check if user exist
             $NoRowCHAMT = mysql_num_rows($resultCHAMT);
            if ($NoRowCHAMT > 0) 
              {
                while ($row = mysql_fetch_array($resultCHAMT)) 
                {
                  $IVNo = $row['IVNo'];
                  
                }
            }
            
            return $IVNo;
}
  

$FromD = $_POST['FromD'];
if($FromD != "")
{
$FromD = DateTime::createFromFormat('Y/m/d', $FromD)->format('Y/m/d');

$ToD = $_POST['ToD'];
$ToD = DateTime::createFromFormat('Y/m/d', $ToD)->format('Y/m/d');
}
//Let's Read ChartClass
$RecChartMaster = "";
$SuperCredit = 0.0;
$SuperDebit = 0.0;
$ChartClassQ = mysql_query("SELECT * FROM acc_chart_class Where isActive=1 ORDER BY class_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
$TOTALHEADBALT = 0.0;
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row['cid'];
    $cname = mysql_real_escape_string($row['class_name']);
    $AccTClass = $cname;
    if($AccTClass != "") {
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
    <td>-</td></tr>';
    }
   //Let's Read ChartType
      $ChartTypeQ = mysql_query("SELECT * FROM acc_chart_types Where isActive=1 AND class_id=$cid ORDER BY name");
      $NoRowType = mysql_num_rows($ChartTypeQ);
      while ($row = mysql_fetch_array($ChartTypeQ)) {
          $acctyp = $row['id'];
          $tname = mysql_real_escape_string($row['name']);
          $RecChartMaster .= '<tr><td>-</td><td><b><em>'.$tname.'</em></b></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
          <td>-</td></tr>';
      //Let's Read ChartMaster
      $ChartMstQ = mysql_query("SELECT * FROM acc_chart_master Where isActive=1 AND account_type=$acctyp ORDER BY mid");
      $NoRowMst = mysql_num_rows($ChartMstQ);
      
      if ($NoRowMst > 0) {
        while ($row = mysql_fetch_array($ChartMstQ)) {
          $GLIMPTY = $row['mid'];
         

          //////////////////////////////////////////////////////////////////////////
          $TOTALHEADBAL = 0.0; $TOTALHEADDR = 0.0; $TOTALHEADCR = 0.0;
          /*$resultChartMaster = mysql_query("SELECT *, postings.ChqNo As ChqNoM, acc_chart_class.cid AS ACLASS FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
            
             LEFT JOIN acc_chart_types ON acc_chart_master.account_type = acc_chart_types.id
             LEFT JOIN acc_chart_class ON acc_chart_types.class_id = acc_chart_class.cid
             LEFT JOIN cheuqes ON postings.ChqNo = cheuqes.chid
             WHERE acc_chart_master.account_type = $tid
             ORDER BY acc_chart_master.mid, postings.TransactionDate");*/
             
            /* $resultChartMaster = mysql_query("SELECT *, postings.ChqNo As ChqNoM, acc_chart_class.cid AS ACLASS, postings.GLImpacted AS ImPGL  FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             LEFT JOIN acc_chart_types ON acc_chart_master.account_type = acc_chart_types.id
             LEFT JOIN acc_chart_class ON acc_chart_types.class_id = acc_chart_class.cid
             LEFT JOIN cheuqes ON postings.ChqNo = cheuqes.chid
             WHERE ImPGL = $tid
             ORDER BY ImPGL, postings.TransactionDate");*/
             
             $resultChartMaster = mysql_query("SELECT *, postings.ChqNo As ChqNoM, acc_chart_class.cid AS ACLASS FROM postings 
              LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             LEFT JOIN acc_chart_types ON acc_chart_master.account_type = acc_chart_types.id
             LEFT JOIN acc_chart_class ON acc_chart_types.class_id = acc_chart_class.cid
             LEFT JOIN cheuqes ON postings.ChqNo = cheuqes.chid
             WHERE postings.GLImpacted = $GLIMPTY AND postings.isActive=1
             ORDER BY postings.GLImpacted, postings.TransactionDate");

            $NoRowChartMaster = mysql_num_rows($resultChartMaster); 
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                $mid = $row['tncid'];
                $mid2 = $row['CounterTrans'];
                if($mid2 == 0) { $mid2 = $mid; }
                $mid3 = str_pad($mid2,6,"0",STR_PAD_LEFT);
                $cidIM = $row['GLImpacted'];
                $acid = $row{'account_code'};
                $id2 = $row{'account_code2'};
                $name = mysql_real_escape_string($row['account_name']);
                $ACLASS = $row['ACLASS'];
                $ChqNoM = $row['ChqNoM'];
                $ENLINVOICE = $row['ENLINVOICE'];
               
                $type_name = mysql_real_escape_string($row['name']); //ClassName
                $TT = $row['TransacType']; //ClassName
                $TD = $row['TransactionDate']; //ClassName
                if($TD != "")
                {
                $TD = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');
                }
                
                $ChqNo = $row['cheuqeNME']; //ClassName
                //if($ChqNoM == "") { $ChqNo = GetEnlInvoice($ENLINVOICE); }
                $TDescr = mysql_real_escape_string($row['Remark']); //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
                $class_name = mysql_real_escape_string($row['class_name']); //ClassName
                $classID = $row['ACLASS']; //ClassName
                
               
               if($FromD == "")
            {
                if($TT =="CREDIT") 
                { 
                  $CRD = $TAmount;  
                  $SuperCredit += floatval($TAmount);
                  $TOTALHEADCR += floatval($TAmount);
                } 
                else 
                { $CRD = ''; }

                if($TT =="DEBIT") 
                { 
                  $DRD = $TAmount; 
                  $SuperDebit += floatval($TAmount);
                  $TOTALHEADDR += floatval($TAmount);
                } 
                else 
                { $DRD = ''; }
                
                if($EXZ != 1)
                {
                $RecChartMaster .= '<tr><td>-</td><td>-</td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cidIM.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD,2).'</td><td>'.number_format($CRD,2).'</td>
                <td>-</td></tr>';
                }
                
                
            }
            elseif ($FromD <= $TD && $TD <= $ToD)
            {
                if($TT =="CREDIT") 
                { 
                  $CRD = $TAmount;  
                  $SuperCredit += floatval($TAmount);
                   $TOTALHEADCR += floatval($TAmount);
                } 
                else 
                { $CRD = ''; }

                if($TT =="DEBIT") 
                { 
                  $DRD = $TAmount; 
                  $SuperDebit += floatval($TAmount);
                   $TOTALHEADDR += floatval($TAmount);
                } 
                else 
                { $DRD = ''; }
                
                if($EXZ != 1)
                { 
                 $RecChartMaster .= '<tr><td>-</td><td>-</td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cidIM.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'" ><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD,2).'</td><td>'.number_format($CRD,2).'</td>
                <td>-</td></tr>';
                }
                
            }
               
                }
                
                
                
                /////////////////////////////////
                if($ACLASS == 1 ||  $ACLASS == 4)
                {
                    if($TOTALHEADDR != 0) { $TOTALHEADBAL =  floatval($TOTALHEADDR) - floatval($TOTALHEADCR); }
                    else { $TOTALHEADBAL = floatval($TOTALHEADCR);  }
                    
                }
                else
                {
                   if($TOTALHEADCR != 0) { $TOTALHEADBAL = floatval($TOTALHEADCR) - floatval($TOTALHEADDR); }
                   else { $TOTALHEADBAL = floatval($TOTALHEADDR);  }
                }
                
                $TOTALHEADBALT += $TOTALHEADBAL;
                 if($EXZ != 1)
                { 
                    $RecChartMaster .= '<tr><td style="border-top: solid"></td><td style="border-top: solid"></td><td style="border-top: solid"></td><td style="border-top: solid"></td><td style="border-top: solid"></td><td style="border-top: solid"></td><td style="border-top: solid"></td><td style="border-top: solid"></td><td style="border-top: solid"></td><td style="border-top: double; ">'.number_format($TOTALHEADBAL,2).'</td></tr>';
                }
                else
                {
                     $RecChartMaster .= '<tr><td></td><td></td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cidIM.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td></td><td></td><td></td><td>'.number_format($TOTALHEADDR,2).'</td><td>'.number_format($TOTALHEADCR,2).'</td><td style="border-top: double;">'.number_format($TOTALHEADBAL,2). '</td></tr>';
                }
          //$RecChartMaster .= '<tr style="background:#777;"><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>'.$TOTALHEADBAL.'</td></tr>';
          //$RecChartMaster .= '<tr><td>ggggg</td><td>ggg-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>'.$TOTALHEADBAL.'</td></tr>';
                
                ///////////////////////////////////////

              }
          ////////////////////////////////////////////////////////////////////////////////

         }
         
         
        }
      }
   }

  }

   
  $RecChartMaster .= '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td style="border-top: double;  border-bottom: double ">'.number_format($SuperDebit,2).'</td><td style="border-top: double; border-bottom: double ">'.number_format($SuperCredit,2).'</td>
               <td style="font-weight:800;">-</td></tr>'; //'.number_format($TOTALHEADBALT,2).'

//exit;
$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];


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
            Accounts - Trial Balance Report
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Trial Balance Report</li>
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
                  <h3 class="box-title">Trial Balance Report</h3>
                  <div class="box-tools pull-right">
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      
                        <div class="col-md-6 col-md-offset-3" style="background-color: #FF6868; border-radius: 25px;">
                        <form role="form" action="trialbalance" method="POST" ><div class="form-group">
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
                     <input name="EXZ" type="checkbox" checked value="1"  /> Show Summation Balance Accounts </label> 
                     <?php } else { ?>
                     <input name="EXZ" type="checkbox" value="1"  /> Show Summation Balance Accounts </label>
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
                     <input id="EXZ" type="checkbox" checked value="1" onclick="setZero(this)" /> Show Summation Balance Accounts </label> 
                     <?php } else { ?>
                     <input id="EXZ" type="checkbox" value="0" onclick="setZero(this)" /> Show Summation Balance Accounts </label>
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
                <div class="table-responsive">
                   <table id="userTab" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                        <th colspan="10"><center style="font-size:1.5em">ELSHCON NIGERIA LIMITED</center></th>
                      </tr>
                      <tr>
                        <th colspan="10"><center style="font-size:1.5em">TRIAL BALANCE</center></th>
                      </tr>
                      <tr>
                        <th colspan="10"><center style="font-size:1.2em">FROM: <?php echo $FromD; ?> &nbsp;  &nbsp;  &nbsp; TO: <?php echo $ToD; ?> </center></th>
                      </tr>
                    </thead>
                    <thead>
                      <tr>
                        <th>Account Class</th>
                        <th>Account Type</th>
                        <th>Account Code</th>
                        <th>Account Name</th>
                        <th>Date</th>
                        <th>RefNo./ChequeNo.</th>
                        <th>Trans. Descr.</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $RecChartMaster; ?>
                    </tbody>
                   
                  </table>
                  </div>
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
     $("#userTab").dataTable(
            {
          "bPaginate": false,
          //"bLengthChange": true,
          "bFilter": true,
          "bSort": false,
          "bInfo": true
          //"bAutoWidth": true
        });
    </script>

    <script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>
    
    <script type="text/javascript">
     function ExportToExcel()
      {
        var Dat = "Trial Balance"; //+ new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "Trial Balance",
              filename: Dat,
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true
            });
      }
     </script>

     <script type="text/javascript">
       $(".datep").datepicker({dateFormat : 'yy/mm/dd', changeYear: true });
     </script>


  </body>
</html>