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


$CRFC2018 = getTotalAmt(589, 2018, 'DEBIT');
$CRFC2019 = getTotalAmt(589, 2019, 'DEBIT');

$CPTE2018 = getTotalAmt(715, 2018, 'DEBIT');
$CPTE2019 = getTotalAmt(715, 2019, 'DEBIT');

$CPTV2018 = getTotalAmt(602, 2018, 'DEBIT');
$CPTV2019 = getTotalAmt(602, 2019, 'DEBIT');

?>
<?php
function getTotalAmt($MasterID, $YR , $TTYpe)
{
    
    $MTOTAL = 0.0; $CRD = 0.0; $DRD = 0.0;
   // $FromD = $GLOBALS['FromD']; 
   //$ToD = $GLOBALS['ToD'];
  $resultChartMaster = mysql_query("SELECT *, acc_chart_class.cid AS ACLASS FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
               LEFT JOIN acc_chart_types ON acc_chart_master.account_type = acc_chart_types.id
             LEFT JOIN acc_chart_class ON acc_chart_types.class_id = acc_chart_class.cid
             WHERE postings.GLImpacted = $MasterID AND postings.TransacType = '$TTYpe'
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
               // $TD = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');
                $CompareDate = substr($TD,0,4);
                $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
               
                $classID = $row['CID']; //ClassName
                $ACLASS = $row['ACLASS'];
                 if($CompareDate == $YR)   
                {
                        if($FromD == "")
                        {
                        if($TT =="CREDIT") { $CRD = $CRD + floatval($TAmount); } else {  }
                        if($TT =="DEBIT") { $DRD += floatval($TAmount); } else {  }
                        }
                        elseif ($FromD <= $TD && $TD <= $ToD)
                        {
                         if($TT =="CREDIT") { $CRD = $CRD + floatval($TAmount); } else {  }
                         if($TT =="DEBIT") { $DRD += floatval($TAmount); } else {  }
                        }
                        
                   
                    
                
                }
                //$MTOTAL = $MTOTAL + floatval($TAmount);
              }

            }
            
           
              
              
             
                  //$MTOTAL = $DRD - $CRD;
            /*if($CompareDate == $YR)   
            {
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
            }*/
             
                
                
          
            if($TTYpe == "DEBIT") { return $DRD; }
            
            if($TTYpe == "CREDIT") { return $CRD; }
            
        
}

//exit;
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
            Accounts - Cash Flow Report
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Cash Flow Report</li>
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
                  <h3 class="box-title">Cash Flow Report</h3>
                  <div class="box-tools pull-right">
                  </div>
                  <div class="row">
                   <!-- <div class="col-md-12">
                      
                        <div class="col-md-6 col-md-offset-3" style="background-color: #888868; border-radius: 25px;">
                        <form role="form" action="cashflow" method="POST" ><div class="form-group">
              <div class="form-group col-md-6">
                <label>From: </label>
                <input type="text" class="form-control datep" id="FromD" name="FromD" placeholder="Click to set date" value="<?php echo $FromD; ?>" readonly required >
              </div>
              <div class="form-group col-md-6">
                <label>To: </label>
                <input type="text" class="form-control datep" id="ToD" name="ToD" placeholder="Click to set date" readonly value="<?php echo $ToD; ?>" required >
              </div>
           
              <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i></button><br/></form>
              </div>
                      
                    </div> 
                  </div>-->
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
                        <th colspan="3"><center style="font-size:1.5em">ELSHCON NIGERIA LIMITED</center></th>
                      </tr>
                      <tr>
                        <th colspan="3"><center style="font-size:1.5em">Cash Flow</center></th>
                      </tr>
                      <tr>
                        <th colspan="3"><center style="font-size:1.2em">FROM: 2018 <?php echo $FromD; ?> &nbsp;  &nbsp;  &nbsp; TO: 2019<?php echo $ToD; ?> </center></th>
                      </tr>
                    </thead>
                    <thead>
                      <tr>
                        <th> &nbsp; </th>
                       
                        <th>2018 NGN</th>
                        <th>2019 NGN</th>
                      </tr>
                      
                    </thead>
                    <tbody>
                        <tr>
                        <th>CASH FLOW FROM OPERATING ACTIVITIES</th>
                       
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                       </tr>
                      <tr>
                        <th>Cash receipts from customers</th>
                        <th><?php echo $CRFC2018; ?></th>
                        <th><?php echo $CRFC2019; ?></th>
                      </tr>
                      <tr>
                        <th>Cash paid to employees</th>
                        <th><?php echo $CPTE2018; ?></th>
                        <th><?php echo $CPTE2019; ?></th>
                      </tr>
                       <tr>
                        <th>Cash paid to vendors</th>
                        <th><?php echo $CPTV2018; ?></th>
                        <th><?php echo $CPTV2019; ?></th>
                      </tr>
                      <tr>
                        <th>Cash generated from operations</th>
                        <th style="border-top:double">&nbsp;</th>
                        <th style="border-top:double">&nbsp;</th>
                      </tr>
                      <tr><td colspan="3"> &nbsp; </td></tr>
                       <tr>
                        <th>Dividends received</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Interest received</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Interest paid</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                       <tr>
                        <th>Tax paid</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Net cash flow from operating activities</th>
                        <th style="border-top:double">&nbsp;</th>
                        <th style="border-top:double">&nbsp;</th>
                      </tr>
                       <tr><td colspan="3"> &nbsp; </td></tr>
                      <tr>
                        <th>CASH FLOW FROM INVESTING ACTIVITIES</th>
                       
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Addictions to equipment</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Replacement of equipment</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Proceed from sale of equipment</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Net cash flow from investing activities</th>
                        <th style="border-top:double">&nbsp;</th>
                        <th style="border-top:double">&nbsp;</th>
                      </tr>
                        <tr><td colspan="3"> &nbsp; </td></tr>
                      <tr>
                        <th>CASH FLOW FROM FINANCING ACTIVITIES</th>
                       
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Proceeds from capital contributed</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Proceeds from loan</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Payment of loan</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Net cash flow from financing activities</th>
                        <th style="border-top:double">&nbsp;</th>
                        <th style="border-top:double">&nbsp;</th>
                      </tr>
                      
                        <tr><td colspan="3"> &nbsp; </td></tr>
                       <tr>
                        <th>NET INCREASE/DECREASE IN CASH</th>
                       
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Cash at the beginning of the period</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                      </tr>
                      <tr>
                        <th>Cash at the end of the period</th>
                        <th>&nbsp;</th>
                        <th style="border-bottom:double">&nbsp;</th>
                      </tr>
                     
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
        var Dat = "Cash Flow"; //+ new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "Cash Flow",
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