<?php
session_start();
error_reporting(0);
//if ($_SESSION['Role'] == "ADMIN") 
//{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
//header('Location: ./'); exit; }
$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=11"; charset="utf-8" />
    <title>PLANT E.R.P | Setup</title>
	<link rel="icon" href="mBoot/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	 <!-- daterange picker -->
    <link href="../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <link href="../mBOOT/jqueryCalendar.css" rel="stylesheet" type="text/css" />
    <script src="../mBOOT/jquery-1.6.2.min.js"></script> 
	<script src="../mBOOT/jquery-ui-1.8.15.custom.min.js"></script>

	<script type="text/javascript" src="../html5shiv.js"></script>
 <script type="text/javascript" src="../html5shiv-printshiv.js"></script>
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
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">GLOBAL SETUP</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="remove" onclick="PurchaseLinkd()"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8">
                      <p class="text-center">
					  
                        <strong>Staff's Details</strong>
                      </p>
                     <form enctype="multipart/form-data" action="RegNew" method="post">
          <div class="form-group has-feedback" style="width:40%; display: inline-block;">
		   <input type="text" class="form-control" id="Surname" name="Surname" placeholder="Surname"required />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
			
          </div>
		   <div class="form-group has-feedback" style="width:40%; display: inline-block;">
		 
  <input type="date" class="form-control" name="bday" min="2000-01-02"></input>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
			
          </div>
		  
		   <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
		   <input type="text" class="form-control" id="Fname" name="Fname" placeholder="First name"required />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
         
		  <div class="form-group has-feedback" style="width:40%; display: inline-block;">
            
			<select class="form-control" id="Gender" name="Gender"placeholder="Gender" required>
			<option value=""> Choose Gender</option>
			<option value="Male"> Male</option>
			<option value="Female"> Female</option>
			
			</select>
            <span class="glyphicon glyphicon-gender form-control-feedback"></span>
          </div>
		  
		   <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
            <input type="Date" class="form-control" id="DOB" name="DOB" placeholder="Date of Birth" required />
            <span class="glyphicon glyphicon-calender form-control-feedback"></span>
          </div>
		  
		   <div class="form-group has-feedback" style="width:40%; display: inline-block;">
            <input type="text" class="form-control" id="staffid" name="staffid" placeholder="Staff ID" required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
		   <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
            <input type="text" class="form-control" id="staffphn" name="staffphn" placeholder="Staff Phone" required />
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
		   <div class="form-group has-feedback" style="width:40%; display: inline-block;">
            <input type="email" class="form-control" id="staffmail" name="staffmail" placeholder="Email" required />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
		   <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
            <span class="glyphicon glyphicon-calender form-control-feedback"></span>
			 <!-- Date range -->
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="reservation" name="reservation" required />
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
          </div>
		  <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
            
			<select class="form-control" id="dept" name="dept" required>
			<option value=""> Choose Department</option>
			<option value="External Sales"> External Sales</option>
			<option value="Internal Sales"> Internal Sales</option>
			<option value="Project Control"> Project Control</option>
			<option value="Purchasing"> Purchasing</option>
			<option value="Logisitics"> Logisitics</option>
			<option value="Warehousing"> Warehousing</option>
			<option value="Accounts"> Accounts</option>
			<option value="Field Services"> Field Services</option>
			<option value="Human Resources"> Human Resources</option>
			<option value="Information Technology"> Information Technology</option>
			<option value="admin"> ADMIN</option>
			
			</select>
            <span class="glyphicon glyphicon-gender form-control-feedback"></span>
          </div>
		  
		   <div class="form-group has-feedback" style="width:40%; display: inline-block;">
            
			<select class="form-control" id="staffrole" name="staffrole" required>
			<option value=""> Role</option>
			<option value="user"> user</option>
			<option value="admin"> admin</option>
			
			</select>
            <span class="glyphicon glyphicon-gender form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
            <input type="password" class="form-control" id="fpwsd" name="fpwsd" placeholder="First Login Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          
         
              
                    </div><!-- /.col -->
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Staff Image</strong>
                      </p>
			<center><img id="uploadPreview" class="img-circle" style="width: 200px; height: 200px;" /></center>

<script type="text/javascript">

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("StaffPhoto").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

</script>
<br>
			<div class="form-group has-feedback">
            <input type="file" id="StaffPhoto" name="StaffPhoto" accept="image/jpg" class="form-control" onchange="PreviewImage();" placeholder="Passport" Required/>
			
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>		  
          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div><!-- /.col -->
          </div>
                      </form> 
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
          

            <div class="col-md-4">
              
            </div><!-- /.col -->
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
	 <!-- date-range-picker -->
    <script src="../mBOOT/moment.min.js" type="text/javascript"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
	 <!-- bootstrap time picker -->
    <script src="../plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <!-- InputMask -->
    <script src="../plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="../plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="../plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    
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
    <script type="text/javascript">
      $(function () {
        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
                {
                  ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                  },
                  startDate: moment().subtract('days', 29),
                  endDate: moment()
                },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        
       

       
      });
    </script>
  
	
  </body>
</html>