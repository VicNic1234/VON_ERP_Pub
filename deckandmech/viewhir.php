<?php
session_start();
error_reporting(0);
include('route.php');

include ('../DBcon/db_config.php');

$result = mysql_query("SELECT * FROM notification WHERE StaffID='".$_SESSION['uid']."'");
//check if user exist
$NoRowMsg = mysql_num_rows($result);
$FullName = $_SESSION['Firstname'] . " " .$_SESSION['SurName'];
if($_SESSION['uid'] == "") { header('location:../users/logout'); }
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

$HIRID = $_GET['cnid'];

 $resultLI = mysql_query("SELECT * FROM hir 
 LEFT JOIN divisions ON hir.PartyInv = divisions.divid
 LEFT JOIN wh_stations ON hir.rptLocation = wh_stations.cid
 LEFT JOIN users ON hir.raisedby = users.uid WHERE hir.hirid = '$HIRID'
 "); //WHERE isActive=1 ORDER BY cid

$NoRowLI = mysql_num_rows($resultLI); 
//fetch tha data from the database
   if ($NoRowLI > 0) 
   {
   $SN = 1;
  while ($row = mysql_fetch_array($resultLI)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     
    $hirid = $row['hirid'];
    $LocNme = $row['station_name'];
    $LocID = $row['cid'];
    $Description = $row['Description'];
    $ImAct = $row['ImAct'];
    $FtAct = $row['FtAct'];
    $PrtyInvID = $row['PartyInv']; 
    $Comment = $row['Comment'];
    $RAMRating = $row['RAMRating'];
    $HType = $row['HType'];
    $rptDate = $row['rptDate'];
    $TargetDate = $row['TargetDate'];
    $RaisedBy = $row['Firstname'] . " " . $row['Surname'];//$row['RaisedBy'];
    $TotalSum = number_format($row['TotalSum']);
    $FileLink = $row['FileLink'];

    $RAMRatingN = '<label><input type="radio" name="RAMRating" value="High" /> High </label> &nbsp; &nbsp;
            <label><input type="radio" name="RAMRating" value="Medium" /> Medium </label> &nbsp; &nbsp;
            <label><input type="radio" name="RAMRating" value="Low" /> Low </label> &nbsp; &nbsp;';

    $arrRoles = array("Account", "Asset Management", "Bus Dev", 
  "Contracts/Procurement",
  "Warehouse","Raise Contract","Treat Procurement","Process PO",
  "Corporate/Communication", 
  "Document Control", "Due Diligence", "HSE", 
  "HR/Administration", "ICT", "Deck Mach", 
  "Internal Audit", "Legal", "Maintenance", "Warehouse", 
  "Marine/Logistics", "Projects", "QA/QC", 
  "Security", "Strategy/Innovation", "ERP Admin", "BI" );

    foreach ($arrRoles as &$value) {
    //$value = $value * 2;
    if (strpos($Role, $value) !== false) { $option .= '<label><input type="checkbox" name="role_cap[]" value="'.$value.'" checked /> '.$value.'</label> &nbsp; &nbsp;' ; }
    else { $option .= '&nbsp; <label><input type="checkbox" name="role_cap[]" value="'.$value.'"> '.$value.'</label> &nbsp; &nbsp;' ; }

}


  }
}
else
{
  header('location:hirs');
}

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
    if($LocID == $cid)
    {
     $OptLocation .= '<option value="'.$cid.'" selected >'.$class_name.'</option>';
    }
    else
    {
     $OptLocation .= '<option value="'.$cid.'">'.$class_name.'</option>';
    }

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
    if($DivID == $PrtyInvID)
    {
      $RecDiv .= '<option value="'.$DivID.'" selected >'.$DivName.'</option>';
    }
    else
    {
      $RecDiv .= '<option value="'.$DivID.'">'.$DivName.'</option>';
    }
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
                    
                     <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" method="post">

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
                      <input type="text" class="form-control datep" name="rptDate" value="<?php echo $rptDate; ?>" required readonly="" />
                    </div><!-- /.input group -->
          </div>

        

		 <div class="form-group has-feedback col-md-12">
      <label>Description of observation</label>
		   <textarea rows="4" cols="50" placeholder=" Enter Description here..." id="Desc" name="Desc" style="width:100%; display: inline-block;" required ><?php echo $Description; ?></textarea>
		 </div>

     <div class="form-group has-feedback col-md-12">
      <label>Immediate Action Taken</label>
       <textarea rows="4" cols="50" placeholder=" Enter Immediate Action here..." id="ImAct" name="ImAct" style="width:100%; display: inline-block;" required ><?php echo $ImAct; ?></textarea>
     </div>

     <div class="form-group has-feedback col-md-12">
      <label>Futher Action to Prevent Occurance</label>
       <textarea rows="4" cols="50" placeholder=" Enter Futher Actions here..." id="FtAct" name="FtAct" style="width:100%; display: inline-block;"  ><?php echo $FtAct; ?></textarea>
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
                      <input type="text" class="form-control datep" readonly="" value="<?php echo $TargetDate; ?>" name="conEDate" />
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
                      <?php echo $HType; ?>
                     </div>

    
          <br/>
             
          <div class="form-group has-feedback" style="border: 2px solid #888; border-radius: 11px; padding:5px;">
            <p class="text-center">
                        <strong>RAM Rating:</strong>
                      </p>
             <?php echo $RAMRating; ?>
          
          </div>
<br/>
		 
		

         
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