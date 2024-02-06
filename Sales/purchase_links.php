<?php
session_start();
error_reporting(0);
//if ($_SESSION['Role'] == "ADMIN") 
//{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
//header('Location: ./'); exit; }
//$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>PLANT E.R.P | Dashboard</title>
	<link rel="icon" href="mBoot/plant.png" type="image/png" sizes="10x10">
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
	
  </head>
  <body class="skin-blue sidebar-mini">
  
        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
         
<?php if ($G == "")
           {} else {
echo

'<br><br><div class="alert alert-danger alert-dismissable">' .
                                       '<i class="fa fa-ban"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                        '<b></b>  '.  $G.
                                    '</div>' ; 
									$_SESSION['ErrMsg'] = "";}
?>
<?php if ($B == "")
           {} else {
echo

'<br><br><div class="alert alert-info alert-dismissable">' .
                                       '<i class="fa fa-ban"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                        '<b></b>  '.  $B.
                                    '</div>' ; 
									$_SESSION['ErrMsgB'] = "";}
?>
  
         

               <div class="row">
            <div class="col-md-4">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <i class="fa fa-exchange"></i>
                  <h3 class="box-title">Transactions</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul>
                    <li onclick="purchasepg()"> Purchase Order Entry</a></li>
                    <li><a href=""> Outstanding Purchase Orders Maintenance</a></li>
                    <li><a href=""> Direct GRN</a></li>
                    <li><a href=""> Direct Invoice</a></li>
					<br>
                    <li><a href=""> Payments to Suppliers</a></li>
                    <li><a href=""> Supplier Invoices</a></li>
					<br>
                    <li><a href=""> Supplier Credit Notes</a></li>
                    <li><a href=""> Allocate Supplier Payments or Credit Notes</a></li>
                  
                     
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- ./col -->
            <div class="col-md-4">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <i class="fa fa-reorder"></i>
                  <h3 class="box-title">Inquiries and Reports</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                 <li><a href=""> Purchase Orders Inquiry</a></li>
                    <li><a href=""> Supplier Transaction Inquiry</a></li>
                    <li><a href=""> Supplier Allocation Inquiry</a></li>
                   
					<br>
                    <li><a href=""> Supplier and Purchasing Reports</a></li>
                    
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- ./col -->
            <div class="col-md-4">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <i class="fa fa-cog"></i>
                  <h3 class="box-title">Maintenance</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <li><a href="">Add and Manage Suppliers</a></li>
                    
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- ./col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

    

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

  
	
  </body>
</html>