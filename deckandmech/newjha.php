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
//Read CONcount
$CONcount = mysql_query("SELECT * FROM sysvar WHERE variableName = 'CONTRACTCOUNT'");
while ($row = mysql_fetch_array($CONcount)) {
              $nCONcount = $row{'variableValue'};
              }
  $CONTRNO = str_pad($nCONcount,3,"0",STR_PAD_LEFT);


   /*Get CURRENCY*/
$resultCurr = mysql_query("SELECT * FROM currencies Order By Abbreviation");
$NoRowCurr = mysql_num_rows($resultCurr);
if ($NoRowCurr > 0) {
  while ($row = mysql_fetch_array($resultCurr)) 
  {
    $cAB = $row['Abbreviation'];
    
    
     $CurrOpt .= '<option selected value="'.$cAB.'">'.$cAB.'</option>';
  
   
  }
 }

    /*Get PDF*/
$resultREQ = mysql_query("SELECT DISTINCT RequestID FROM poreq ");
$NoRowREQ = mysql_num_rows($resultREQ);
if ($NoRowREQ > 0) {
  while ($row = mysql_fetch_array($resultREQ)) 
  {
    $RequestID = $row['RequestID'];
    
     $ReQOpt .= '<option value="'.$RequestID.'">'.$RequestID.'</option>';
  
   
  }
 }

 /*Get Suppliers*/
$resultSUP = mysql_query("SELECT * FROM suppliers Order By SupNme");
$NoRowSUP = mysql_num_rows($resultSUP);
if ($NoRowSUP > 0) {
  while ($row = mysql_fetch_array($resultSUP)) 
  {
    $supid = $row['supid'];
    $SupNme = $row['SupNme'];
    $SupOpt .= '<option value="'.$supid.'">'.$SupNme.'</option>';
  }
 }


$OptLocation = "";
$resultChartClass = mysql_query("SELECT * FROM wh_stations Where isActive=1");
$NoRowChartClass = mysql_num_rows($resultChartClass);
if ($NoRowChartClass > 0) {
  while ($row = mysql_fetch_array($resultChartClass)) {
    $cid = $row['cid'];
    $class_name = $row['station_name'];
    
    $OptLocation .= '<option value="'.$cid.'">'.$class_name.'</option>';

    }

  }
 //////////////////////////////////
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);



//Let's get the Business Unit
 $RecDiv = "";
 $resultDiv = mysql_query("SELECT * FROM businessunit ORDER BY BussinessUnit");
 $NoRowDiv= mysql_num_rows($resultDiv);
 if ($NoRowDiv > 0) {
  while ($row = mysql_fetch_array($resultDiv)) 
  {
    $DivID = $row['id'];
    $DivName = $row['BussinessUnit'];
    $RecDiv .= '<option value="'.$DivID.'">'.$DivName.'</option>';
  }
 }

	

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
            New Job Harzard Analysis Report 
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">New Job Harzard Analysis Report</li>
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
                  <h3 class="box-title">Job Hazard Analysis Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12" style="background-color:#C1E0FF; border-radius: 15px; padding-top:22px; border: 2px solid #888;">
                    
                     <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="regJHA" method="post">
          
          <div class="form-group has-feedback col-md-4" >
                <label>Project Title:</label>
                <input type="text" class="form-control" id="ProjTitle" name="ProjTitle" required />
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-4" >
                <label>Client:</label>
                <input type="text" class="form-control" id="CLient" name="CLient" required />
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-4" >
                <label>Location:</label>
                <input type="text" class="form-control" id="Location" name="Location" required />
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>

        
          <div class="form-group has-feedback col-md-4">
                    <label>Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" name="rptDate" required readonly />
                    </div><!-- /.input group -->
          </div>

        

		 <div class="form-group has-feedback col-md-8">
      <label>JHA Review Team Composition</label>
		   <textarea rows="4" cols="50" placeholder=" Type here..." id="Desc" name="ReviewTeam" style="width:100%; display: inline-block;" required ></textarea>
		 </div>

     <div class="form-group has-feedback col-md-4 pull-right">
                  <button class="btn btn-success">Submit</button>
          </div>

   

     
   

    


   

          
		  
  </div><!-- /.col -->
                    
   
                      </form> 
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