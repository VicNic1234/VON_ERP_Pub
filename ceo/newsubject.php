<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$result = mysql_query("SELECT * FROM notification WHERE StaffID='".$_SESSION['uid']."'");
//check if user exist
$NoRowMsg = mysql_num_rows($result);
$FullName = $_SESSION['Firstname'] . " " .$_SESSION['SurName'];
$msg = "";
if ($NoRowMsg > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($result)) {
	$msg .= '<li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> '.$row{'Message'}.'
                        </a>
                      </li>';
	}
	
}

include('route.php');

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

//Business Year
$BYr = $_SESSION['BusinessYear'];


 


 //////////////////////////////////
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);



?>
<?php if ($NoRowCUS > 0) 
            {
              //fetch tha data from the database
              while ($row = mysql_fetch_array($resultCUS)) {
             
              $Custms .= '<option value="'.$row['cussnme'].'">'.$row['CustormerNme'].'</option>';
            
              }
              
            }
                                
      ?>
<!DOCTYPE html>
<html>
 <?php include('../header2.php'); ?>

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
            New Subject
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">New Subject</li>
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
  
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Subject Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#FFFF99; border-radius: 15px; padding-top:22px;">
                    
                     <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="regCONT" method="post">
          <div class="form-group has-feedback col-md-12" >
                <label>Choose Vendor:</label>
          		  <select class="form-control" id="VendSource" name="VendSource" required>
          			<option value=""> Choose Vendor</option>
          			<?php echo $SupOpt; ?>
          			</select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>
		  
		   
		  
		  <div class="form-group has-feedback col-md-6">
                    <label>Start Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" name="conSDate" required />
                    </div><!-- /.input group -->
          </div>

         <div class="form-group has-feedback col-md-6">
                 
                    <label>End Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" name="conEDate" />
                    </div><!-- /.input group -->
          </div>

          <div class="form-group has-feedback col-md-6">
            <label>Choose Division:</label>
            <select class="form-control" id="conDiv" name="conDiv" required >
            <option value=""> Choose Division</option>
            <?php echo $RecDiv; ?>
            </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-3">
            <label>Currency:</label>
           <select class="form-control" name="currency">
            <option value="">--</option>
            <?php echo $CurrOpt; ?>
           </select>
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-3">
            <label>Total Sum (optional):</label>
           <input type="text" class="form-control" name="totalSum" value="<?php echo $TotalSum; ?>" onKeyPress="return isNumber(event)" />
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>

		 
		 
		 <div class="form-group has-feedback col-md-12">
		   <textarea rows="4" cols="50" placeholder=" Enter comment here..." id="Comment" name="Comment" style="width:100%; display: inline-block;"></textarea>
		 </div>
   
		  
  </div><!-- /.col -->
                    
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Contract Number</strong>
                      </p>
			    <div class="form-group has-feedback">
            <input type="text" class="form-control" readonly value="ENL/CUSN/C&P/CONTR/<?php echo $CONTRNO; ?>" id="ContractNo" name="ContractNo" placeholder="ENL/CUSN/C&P/CONTR/002"  required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
          <br/>
             <p class="text-center">
                        <strong>PDF Number (Optional)</strong>
                      </p>
          <div class="form-group has-feedback">
           <select class="form-control" name="PDFNum">
            <option value="">--</option>
            <?php echo $ReQOpt; ?>
           </select>
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
<br/>
		 
			<p class="text-center">
                        <strong>Contract Document (Optional)</strong>
                      </p>
			<div class="form-group has-feedback">
            <input type="file" id="CONFile" name="CONFile" class="form-control" />
			
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>		

                      <p class="text-center">
                       <a href="../CONAttach/Sample.doc"><strong>Sample Contract</strong></a>
                      </p>

 
     

          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Create</button>
            </div><!-- /.col -->
          </div>
                      </form> 
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
	
	
		
		
		
		
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  

       <?php include('../footer.php') ?>

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
	 <!-- date-range-picker -->
    <script src="../mBOOT/moment.min.js" type="text/javascript"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
	 <!-- bootstrap time picker -->
    <script src="../plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <!-- InputMask -->
    <script src="../plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="../plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="../plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="../plugins/chartjs/Chart.min.js" type="text/javascript"></script>
	<!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
  <script src="../mBOOT/jquery-ui.js"></script>

    <script type="text/javascript">
      $(function () {
        $("#userTab").dataTable();
          $(".datep").datepicker();
      });
    </script>

  <script type="text/javascript">      
        $('.srcselect').select2();
 </script>
 <script>
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
    }
    </script>
	
  </body>
</html>