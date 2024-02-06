<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');


$TID = $_GET['TID'];

 $ACCTID = $_GET['ACCTID']; 

  

$FromD = $_GET['FromD'];
if($FromD != "")
{
$FromD = DateTime::createFromFormat('Y/m/d', $FromD)->format('Y/m/d');

$ToD = $_GET['ToD'];
$ToD = DateTime::createFromFormat('Y/m/d', $ToD)->format('Y/m/d');
}

//GLOpt

$GLOpt = '<option value=""> -- </option>';
$GLOptQ = mysql_query("SELECT * FROM bankaccount LEFT JOIN ON acc_chart_master.mid = bankaccount.GLAcct Where isActive=1 ORDER BY account_name");
$NoRowGQ = mysql_num_rows($GLOptQ);
if ($NoRowGQ > 0) {
    while ($row = mysql_fetch_array($GLOptQ)) {
        $GLID = $row['mid'];
        $GLName = $row['account_name'];
        if($TID == $GLID){
            $GLOpt .= '<option value="'.$GLID.'" selected > '.$GLName.' </option>';
        }
        else
        {
            $GLOpt .= '<option value="'.$GLID.'"> '.$GLName.' </option>';
        }
    }
}
    
    

//Let's Read ChartClass
$RecChartMaster = "";
$SuperCredit = 0.0;
$SuperDebit = 0.0;
$ChartClassQ = mysql_query("SELECT * FROM acc_chart_class Where isActive=1 ORDER BY class_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'cid'};
    $cname = $row['class_name'];
    $AccTClass = $cname;
   // $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
   // <td>-</td></tr>';
   //Let's Read ChartType
      $ChartTypeQ = mysql_query("SELECT * FROM acc_chart_types Where isActive=1 AND class_id=$cid ORDER BY name");
      $NoRowType = mysql_num_rows($ChartTypeQ);
      if ($NoRowType > 0) {
        while ($row = mysql_fetch_array($ChartTypeQ)) {
          $tid = $row{'id'};
          $tname = $row['name'];
          //$RecChartMaster .= '<tr><td>-</td><td><em><b>'.$tname.'</em></b></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
          //<td>-</td></tr>';

         
          //////////////////////////////////////////////////////////////////////////
        if($TID != ""){
          $resultChartMaster = mysql_query("SELECT *, postings.ChqNo As ChqNoM, postings.tncid As TNCID FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             LEFT JOIN cheuqes ON postings.ChqNo = cheuqes.chid
             WHERE acc_chart_master.account_type = $tid && postings.GLImpacted = $TID AND postings.isActive=1
             ORDER BY acc_chart_master.mid, postings.TransactionDate");
        }
        
        if($ACCTID != ""){
          $resultChartMaster = mysql_query("SELECT *, postings.ChqNo As ChqNoM, postings.tncid As TNCID FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             LEFT JOIN cheuqes ON postings.ChqNo = cheuqes.chid
             WHERE acc_chart_master.account_type = $tid && (postings.tncid = '$ACCTID' OR postings.CounterTrans = '$ACCTID' AND postings.isActive=1)
             ORDER BY acc_chart_master.mid, postings.TransactionDate");
        }
            $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                $mid = $row['TNCID'];
                $TNCID = $row['TNCID'];
                $mid2 = $row['CounterTrans'];
                if($mid2 == 0) { $mid2 = $mid; }
                $mid3 = str_pad($mid2,6,"0",STR_PAD_LEFT);
                $cid = $row['GLImpacted'];
                $ChqNoM = $row['ChqNoM'];
                $ChqName = $row['cheuqeNME']; 
                $acid = $row{'account_code'};
                $id2 = $row{'account_code2'};
                $name = $row['account_name'];
                $type_name = $row['name']; //ClassName
                $TT = $row['TransacType']; //ClassName
                $TD = $row['TransactionDate']; //ClassName
                $TD = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');

                $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
                $class_name = $row['ClassName']; //ClassName
                $classID = $row['CID']; //ClassName
                
                $DelBtn = '<a href="delacct?p='.$TNCID.'"><span class="btn btn-danger"><i class="fa fa-trash"></i></span></a>';
                if($ChqNoM != "")
                {
                $CHPK = '<br/> ChequeNo :: <a href="cheuqes?chi='.$ChqNoM.'">'.$ChqName.'</a>';
                }
                else
                {
                $CHPK = '';
                }
                
               if($FromD == "")
            {
                if($TT =="CREDIT") 
                { 
                  $CRD = $TAmount;  
                  $SuperCredit += floatval($TAmount);
                } 
                else 
                { $CRD = ''; }

                if($TT =="DEBIT") 
                { 
                  $DRD = $TAmount; 
                  $SuperDebit += floatval($TAmount);
                } 
                else 
                { $DRD = ''; }
                
                $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td><em><b>'.$tname.'</em></td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.' '.$CHPK.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD).'</td><td>'.number_format($CRD).'</td>
                <td>'.$DelBtn.'</td></tr>';
                
            }
            elseif ($FromD <= $TD && $TD <= $ToD)
            {
                if($TT =="CREDIT") 
                { 
                  $CRD = $TAmount;  
                  $SuperCredit += floatval($TAmount);
                } 
                else 
                { $CRD = ''; }

                if($TT =="DEBIT") 
                { 
                  $DRD = $TAmount; 
                  $SuperDebit += floatval($TAmount);
                } 
                else 
                { $DRD = ''; }
                
              $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td><em><b>'.$tname.'</em></td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.' '.$CHPK.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD).'</td><td>'.number_format($CRD).'</td>
                <td>'.$DelBtn.'</td></tr>';
            }
               
                }

              }
          ////////////////////////////////////////////////////////////////////////////////

         }

        }

   }

  }

  //$RecChartMaster .= '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>'.number_format($SuperDebit).'</td><td>'.number_format($SuperCredit).'</td>
               // <td>-</td></tr>';
               $RecChartMaster .= '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>'.number_format($SuperDebit, 2).'</td><td>'.number_format($SuperCredit, 2).'</td>
                <td style="border-top: 3px double black;">'.number_format($SuperDebit-$SuperCredit, 2).'</td></tr>'; 


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
            Accounts - Bank Reconcilation
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">View Account Report</li>
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
                  <h3 class="box-title">--</h3>
                  <div class="box-tools pull-right">
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      
                        <div class="col-md-6 col-md-offset-3" style="background-color: #FF6868; border-radius: 25px;">
                        <form role="form" action="viewacct" method="GET" >
                            <div class="form-group"> <!-- action="viewacct" method="GET" -->
                          <div class="form-group col-md-3">
                            <label>From: </label>
                            <input type="text" class="form-control datep" id="FromD" name="FromD" placeholder="Click to set date" value="<?php echo $FromD; ?>" readonly required >
                          </div>
                          <div class="form-group col-md-3">
                            <label>To: </label>
                            <input type="text" class="form-control datep" id="ToD" name="ToD" placeholder="Click to set date" readonly value="<?php echo $ToD; ?>" required >
                          </div>
                          <div class="form-group col-md-6">
                            <label>GL Acct: </label>
                            <select class="form-control srcselect" name="TID" required >
                                <?php echo $GLOpt; ?>
                            </select>
                          </div>
                          <script type="text/javascript">      
                            $('.srcselect').select2();
                     </script> 
                          <!--<div class="form-group col-md-6">
                            <span class="btn btn-success pull-right" ><label> 
                                 
                                 <?php if($EXZ == 1) { ?>
                                 <input name="EXZ" type="checkbox" checked value="1"  /> Exclued Zero Balance Accounts </label> 
                                 <?php } else { ?>
                                 <input name="EXZ" type="checkbox" value="1"  /> Exclued Zero Balance Accounts </label>
                                 <?php } ?>
                                
                                 </span>
                          </div>-->
                          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i></button><br/></form>
                          </div>
                          
                        </div> 
                  </div>
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                 <!--<button class="btn btn-success pull-right" id="addAcct" onclick="addAcc(this)" > Add Account Master</button>-->
                 <button class="btn btn-success pull-left" onclick="ExportToExcel()" > Export To Excel</button>
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                   <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Account Class</th>
                        <th>Account Type</th>
                        <th>Account Code</th>
                        <th>Account Name</th>
                        <th>Date</th>
                        <th>RefNo.</th>
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
       $(".datep").datepicker({dateFormat : 'yy/mm/dd'});
     </script>


  </body>
</html>