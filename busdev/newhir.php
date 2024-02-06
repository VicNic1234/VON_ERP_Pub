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
            New Hazard ID Report (Unsafe Acts/Conditions/Near Miss)
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../cnp"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">New Hazard ID Report</li>
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
                  <h3 class="box-title">Hazard ID Report Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#FFE6E6; border-radius: 15px; padding-top:22px; border: 2px solid #888;">
                    
                     <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="regHIR" method="post">

          <div class="form-group has-feedback col-md-6" >
                <label>Choose Location:</label>
                <select class="form-control" id="rptLocation" name="rptLocation" required>
                <option value=""> Choose Location</option>
                <?php echo $OptLocation; ?>
                </select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-6">
                    <label>Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" name="rptDate" required readonly />
                    </div><!-- /.input group -->
          </div>

        

		 <div class="form-group has-feedback col-md-12">
      <label>Description of observation</label>
		   <textarea rows="4" cols="50" placeholder=" Enter Description here..." id="Desc" name="Desc" style="width:100%; display: inline-block;" required ></textarea>
		 </div>

     <div class="form-group has-feedback col-md-12">
      <label>Immediate Action Taken</label>
       <textarea rows="4" cols="50" placeholder=" Enter Immediate Action here..." id="ImAct" name="ImAct" style="width:100%; display: inline-block;" required ></textarea>
     </div>

     <div class="form-group has-feedback col-md-12">
      <label>Futher Action to Prevent Occurance</label>
       <textarea rows="4" cols="50" placeholder=" Enter Futher Actions here..." id="FtAct" name="FtAct" style="width:100%; display: inline-block;"  ></textarea>
     </div>
   

    <div class="form-group has-feedback col-md-6">
            <label>Responsible Action Division:</label>
            <select class="form-control" id="conDiv" name="conDiv" required >
            <option value=""> Choose Division</option>
            <?php echo $RecDiv; ?>
            </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>


    <div class="form-group has-feedback col-md-6">
                 
                    <label>Target Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" name="conEDate" />
                    </div><!-- /.input group -->
          </div>

          
		  
  </div><!-- /.col -->
                    
                    <div class="col-md-4" style="border: 2px solid #888; border-radius: 11px">
                      <p class="text-center">
                        <em style="color:red">Tick as appropriate: see details on handover </em>
                        
                      </p>
			    <div class="form-group has-feedback" style="border: 2px solid #888; border-radius: 11px;padding:5px;">
             <p class="text-center">
                        <strong>Harzard Type:</strong>
                      </p>
            <label><input type="checkbox" name="htype[]" value="UA" /> UA </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="UC" /> UC </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="House keeping" /> House keeping </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="PPE" /> PPE </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Environmental" /> Environmental </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Material Handling" /> Material Handling </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Tools and Equipment" /> Tools and Equipment </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Procedures" /> Procedures </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Attitude" /> Attitude </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Height Related" /> Height Related </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Structural integrity" /> Structural integrity  </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Security" /> Security </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Health" /> Health </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Signs" /> Signs </label> &nbsp; &nbsp;
          </div>

    
          <br/>
             
          <div class="form-group has-feedback" style="border: 2px solid #888; border-radius: 11px; padding:5px;">
            <p class="text-center">
                        <strong>RAM Rating:</strong>
                      </p>
             <label><input type="radio" name="RAMRating" value="High" /> High </label> &nbsp; &nbsp;
            <label><input type="radio" name="RAMRating" value="Medium" /> Medium </label> &nbsp; &nbsp;
            <label><input type="radio" name="RAMRating" value="Low" /> Low </label> &nbsp; &nbsp;
          
          </div>
<br/>
		 
		

          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
            </div><!-- /.col -->
          </div>
          <br/><br/>
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