<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include ('route.php');

$DepartArry = array();
//$Depts = "'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'";
//$DeptsEmp = "29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4";
$Depts = ""; $DeptsEmp = "";
//Let's Read all rfq
$resultDept = mysql_query("SELECT * FROM department Order By DeptmentName");
$NoRowDept = mysql_num_rows($resultDept);
if ($NoRowDept > 0) { 
      while ($row = mysql_fetch_array($resultDept)) 
      {
          $Dpcn = $row{'id'};
          //populate Array
         array_push($DepartArry, $Dpcn);

      }
    }

//We would need to loop through the populated Dept Array

    foreach ($DepartArry as $DeptCode) {
      //Let go through Users Table

    $resultUDept = mysql_query("SELECT * FROM users WHERE DeptID='$DeptCode' AND isActive=1 ");
    $NoRowUDept = mysql_num_rows($resultUDept);
    ///////////////// \\\\\\\\\\\\\\\\\\\\\\\\\\
    $resultDeptm = mysql_query("SELECT DeptmentName FROM department WHERE id='".$DeptCode."'");
      while ($rowm = mysql_fetch_array($resultDeptm)) {
        $DeptNamem = $rowm['DeptmentName'];
      }

    //We may need to creat psedu list of Chart
    $Depts .=  "'".$DeptNamem ."',";
    $DeptsEmp .= $NoRowUDept . ",";

    
}
//exit;
//echo $Depts;
//echo "<br/>";
//echo $DeptsEmp;
//exit;
//Business Unit
$ResultBU = mysql_query("SELECT * FROM businessunit");
$NoRowBU = mysql_num_rows($ResultBU);
//Get Customers
$resultcrfq = mysql_query("SELECT * FROM customers");
$NoRowcrfq = mysql_num_rows($resultcrfq);
//Get Currency No
$resultcurren = mysql_query("SELECT * FROM currencies");
$NoRowcurren = mysql_num_rows($resultcurren);
//Get Suppliers
$resultEmp = mysql_query("SELECT * FROM users WHERE isActive=1");
$NoRowEmp = mysql_num_rows($resultEmp);




$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | HRMS </title>
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
</script>
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

     <?php include('../topmenu2.php'); ?>
     <?php include('./leftmenu.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Human Resources Dashboard
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a title="Add Department" href="aDept" >
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">No. of Department</span>
                  <span class="info-box-number"><?php echo $NoRowDept; ?><small></small></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </a>
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
			<a title="Add Employee" href="../users/register" >
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                 <span class="info-box-text">No. of Employee</span>
                  <span class="info-box-number"><?php echo $NoRowEmp; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
			</a>
            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
			<a title="No. of Trainings" href="#">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">No. of Trainings</span>
                  <span class="info-box-number">0 in <b>[<?php echo date("Y"); ?>]</b></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
			</a>
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
			<a title="No. of Hire" href="#">
			 <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">No of Hire </span>
                  <span class="info-box-number">0 in <b>[<?php echo date("Y"); ?>]</b></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
			</a>
            </div><!-- /.col -->
             <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="No. of Business Units" href="aBus">
       <div class="info-box">
                <span class="info-box-icon bg-brown"><i class="fa fa-cog fa-spin fa-1x fa-fw"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">No. of Business Units</span>
                  <span class="info-box-number"><?php echo $NoRowBU; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
      </a>
            </div><!-- /.col -->
        
             <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="Raise (PDF) Requistion" href="../requisition/rpor" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-book"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Raise (PDF) </span>
                  <span class="info-box-number"><small>New Requistions</small></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
      </a>
            </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="View Requistion" href="../requisition/ppor" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-print"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">View (PDF)</span>
                  <span class="info-box-number"><small>Old Requistions</small></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
      </a>
      </div><!-- /.col -->
       <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="My Leave" href="../users/myleave" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-brown"><i class="fa fa-plane"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Leave</span>
                  <span class="info-box-number"></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->

      </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="My Travel" href="../users/mytravel" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-brown"><i class="fa fa-bus"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Travel</span>
                  <span class="info-box-number"></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->

      </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="My Query" href="../users/myquery" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-brown"><i class="fa fa-question"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Query</span>
                  <span class="info-box-number"></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->

      </a>
      </div><!-- /.col -->
       <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="E-memo" href="../users/memo" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-comment"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">E-Memo</span>
                  <span class="info-box-number"></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->

      </a>
      </div><!-- /.col -->


            
      
          </div><!-- /.row -->
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

          
        
          <!-- Main row -->
          <div class="row">
            <div class="col-md-12">
              <div class="box"> 
               <div class="box-header with-border">
                  <h3 class="box-title">Work Force Spread [By Department]</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   </div> 
                </div><!-- /.box-header -->
            <div class="box-body">
            <div class="col-md-12">
            <script type="text/javascript">
                  $(function () {
                      var chart = Highcharts.chart('barchart', {
                      colors: ['#24CBE5', '#24CBE5', '#24CBE5', '#24CBE5', '#24CBE5', '#24CBE5', '#24CBE5', '#24CBE5', '#24CBE5'],

                          title: {
                              text: ''
                          },

                          subtitle: {
                              text: ''
                          },
                          credits: {
                                      enabled: false
                        },

                          xAxis: {
                              name: 'Departments',
                              categories: [<?php echo $Depts; ?>]
                          },

                          yAxis: {
                              name: 'Staff',
                              title: 'Staff',
                              //categories: [<?php echo $Depts; ?>]
                          },

                          series: [{
                              name: 'Staff Head Count',
                              type: 'column',
                              colorByPoint: true,
                              data: [<?php echo $DeptsEmp; ?>],
                              showInLegend: true
                          },
                          {
                              name: 'Total Staff By Departments',
                              type: 'line',
                              colorByPoint: false,
                              data: [<?php echo $DeptsEmp; ?>],
                              showInLegend: true
                          }

                          ]

                      });


                      $('#plain').click(function () {
                          chart.update({
                              chart: {
                                  inverted: false,
                                  polar: false
                              },
                              subtitle: {
                                  text: 'Bar'
                              }
                          });
                      });

                      $('#inverted').click(function () {
                          chart.update({
                              chart: {
                                  inverted: true,
                                  polar: false
                              },
                              subtitle: {
                                  text: 'Inverted'
                              }
                          });
                      });

                      $('#polar').click(function () {
                          chart.update({
                              chart: {
                                  inverted: false,
                                  polar: true
                              },
                              subtitle: {
                                  text: 'Polar'
                              }
                          });
                      });

                  });
    </script>
          <div>
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/highcharts-3d.js"></script>
            <script src="https://code.highcharts.com/highcharts-more.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>

              <div id="barchart"></div>
              <button id="plain" class="btn btn-primary btn-flat">Bar</button>
              <button id="inverted" class="btn btn-primary btn-flat">Inverted</button>
              <button id="polar" class="btn btn-primary btn-flat">Polar</button>

          </div>
           </div>
       
         </div>
       </div>
         </div>
        </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

     <?php include('../footer.php') ?>
 <!-- Control Sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>

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
  </body>
</html>