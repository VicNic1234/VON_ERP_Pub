<?php
session_start();
error_reporting(0);
mysql_set_charset("UTF8");
include('route.php');

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';

  
//Get RFQ Details  
$resultRFQ = mysql_query("SELECT * FROM rfq WHERE RFQNum='".$_GET['sRFQ']."'");
$NoRowRFQ = mysql_num_rows($resultRFQ);
if ($NoRowRFQ > 0) {
	 	while ($row = mysql_fetch_array($resultRFQ)) 
	  {
	 
	  $DateRange = $row{'DateRange'};
	  $Cus = $row['Customer'];
	  $Status = $row ['Status'];
	  $CusRef = $row ['CompanyRefNo'];
	  }
	  
    }
	  
//Get customers Info
 $resultSup1 = mysql_query("SELECT * FROM suppliers WHERE SupNme='".$_GET['sSup']."'");
 $NoRowSup1 = mysql_num_rows($resultSup1);
if ($NoRowSup1 > 0) {
	 	while ($row = mysql_fetch_array($resultSup1)) 
	  {
	 
	  $SupAddress = $row['SupAddress'];
	  $SupPhone1 = $row['SupPhone1'];
	  
	  }
	  
    }

 $resultRFQ1 = mysql_query("SELECT * FROM rfq WHERE Status='OPEN'");
//check if user exist
 $NoRowRFQ1 = mysql_num_rows($resultRFQ1);
 

$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);

 
 $resultLI = mysql_query("SELECT * FROM lineitems WHERE RFQCode='".$_GET['sRFQ']."' AND Status='QUOTED'");
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
 
$resultSup = mysql_query("SELECT * FROM suppliers");
//check if user exist
 $NoRowSup = mysql_num_rows($resultSup);
if ($NoRowSup > 0) 
	{
	 	while ($row = mysql_fetch_array($resultSup)) 
	  {
	   $SupNme = $row['SupNme'];
	   $SupAddress = $row['SupAddress'];
	   $SupCountry = $row['SupCountry'];
	   $SupPhone1 = $row['SupPhone1'];
	   $SupPhone2 = $row['SupPhone2'];
	   $SupEMail = $row['SupEMail'];
	   $SupURL = $row['SupURL'];
	   $HJ = '<address>
                <strong>'.$SupNme.'</strong><br>
                '.$SupAddress.', '.$SupCountry.'<br>
                Phone: '.$SupPhone1.', '.$SupPhone2.'<br>
                Email: '.$SupEMail.'<br>
                URL: '.$SupURL.'<br>
              </address>';
	   $RecordSup .='<option value="'.$HJ.'">'.$SupNme.'</option>';
	  }
	  
    }	

?>
<!DOCTYPE html>
<html>
<?php include('../header2.php') ?>

  
  <body class="skin-blue sidebar-mini">
    <script>
function ReadLineItem(elem)
    {
       var hhh = elem.value;
     if (hhh != "")
     {     
    window.location.href ="sndRFQ?sRFQ=" + hhh;
    //window.alert("JKJ");
     }
  
    } 
</script>
    <div class="wrapper">
       <?php include('../topmenu2.php') ?>
      <!-- Left side column. contains the logo and sidebar -->
           <?php include('leftmenu.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Send RFQ 
            <small><?php echo $_GET['sRFQ']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../internalsales"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Send RFQ</li>
          </ol>
        </section>
		
<div class="pad margin no-print">
          <div class="callout callout-info" style="margin-bottom: 0!important;">												
            <h4><i class="fa fa-info"></i> Note:</h4>
            This page has been enhanced for printing. Click the print button at the bottom of the Quotation to print.
          </div>
</div>
        <!-- Main content -->
        <section>
          
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
  
          
	
		
        </section><!-- /.content -->
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

    document.body.innerHTML = originalContents;
} 

function ReadSupRFQ()
{
	
	document.getElementById('supinfo').innerHTML = document.getElementById('CusRFQ').value;
}
</script>    
        <!-- Main content -->
<?php
//fetch tha data from the database
	 if ($NoRowLI > 0) {
	 $SN = 1;
	while ($row = mysql_fetch_array($resultLI)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	  $LitID = $row{'LitID'};
	  $MatSer = $row['MatSer'];
	  $Description = $row ['Description'];
	  $Qty = $row ['Qty'];
	  $UOM = $row ['UOM'];
	  $RFQn = $row ['RFQCode'];
	  $Price = $row ['UnitDDPrice'];
	  $Currency = $row ['Currency'];
	  $ExPrice = $Price * $Qty;
	  $RIDn = "'#".$LitID."'";
	  $RIDU = "'#".$LitID."U'";
		
	    $Record .='
					 <tr>
					    <td>'.$SN.'</td>
						<td>'.$MatSer.'</td>
						<td>'.$Description.'</td>
						<td>'.$Qty.'</td>
						<td>'.$UOM.'</td>
						<td>'.$LitID.'</td>
						<td>'.$Currency.'</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						
					 </tr>';
						$SN = $SN + 1;
						$SubTotal = $SubTotal + $ExPrice ;
     }
	 if ($Currency == "NGN")
	 {$SCur = "NGN";}
}
else
{
$Record .= '<tr><td colspan="9">Select RFQ Code to get list of Quoted Items</td> </tr>';
}
?>			
        <section class="invoice">
		<div class="row">
            <div class="col-md-12">
              <div class="box">
			   <form>
   <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="LIRFQ" name="LIRFQ" onChange="ReadLineItem(this)">
			<option value=""> Choose RFQ code</option>
			<?php if ($NoRowRFQ1 > 0) 
						{
							//fetch tha data from the database
							while ($row = mysql_fetch_array($resultRFQ1)) {
							
							?>
							<option value="<?php echo $row['RFQNum']; ?>"  <?php if ($_GET['sRFQ'] == $row['RFQNum']) { echo "selected";} ?>> <?php echo $row['RFQNum']; ?></option>
							<?php
							}
							
						}
																
			?>
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>
	 <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="CusRFQ" name="CusRFQ" onChange="ReadSupRFQ();">
			<option value=""> Choose Supplier</option>
			<?php echo $RecordSup; ?>
									
			</select>
			<span class="glyphicon glyphicon-download form-control-feedback"></span>
     </div>
     <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
      <label>Start Date</label>
        <input id="StartDate" onchange="loadDate()"> </input>
    </div>
     <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
      <label>End Date</label>
         <input id="EndDate" onchange="loadDate()"> </input>
    </div>
		
		  </form>
			  </div>
			</div>
		</div>
          <!-- title row -->
<div id="PrintArea">
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
			
			  <img src="../mBOOT/plant.png" width="30px" height="30px" alt="PENL logo"/>
                <?php echo $_SESSION['CompanyName'];  ?>
                <small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong><?php echo $_SESSION['CompanyName'];  ?></strong><br>
                54 Emekuku Street, D-Line<br>
                Port Harcourt Rivers State, Nigeria<br>
                Phone: +234(84)360759<br/>
                Email: sales@pengrg.com<br/>
                URL: www.pengrg.com
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              To
              <div id="supinfo"></div>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>RFQ No.: </b> <?php echo $_GET['sRFQ']; ?>
			  <br/>
              <b>Date: </b> <?php echo date("d/m/Y"); ?>
            </div><!-- /.col -->
          </div><!-- /.row -->
  <span style="float:left;">Your quote should state the following:
        <br/>
 
1) Exw Price in Dollar ($)<br/>
2) Weight and Dimension with units: Created weight (If not known) = Uncreated weight x 1.5<br/>
3) Delivery lead time per line items.<br/>
4) Validity of the quotation.<br/>
5) Freight cost to Port-Harcourt Nigeria preferably via air (optional).<br/>
6) Cost of Certificate of Conformity should be included in the Unit Cost of the items.<br/>
7)Technical documents such as MTC, Datasheets etc. required from OEM shall be provided.<br/>
8) A deviation sheet if there is any deviation from what is requested.<br/>
 <br/>
 <br/>
 </span>
 <span style="float:right; display:inline-block">
Please acknowledge receipt of this mail and treat <b style="color:red;">urgently</b>.
 <br/>
<b style="color:red;">START DATE:</b> <div id="stdate"></div><br/>
<b style="color:red;">CLOSE DATE:</b> <div id="endate"></div>
</span>
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                 <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Material/Service</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>UOM</th>
						<th>LiID</th>
                        <th>Currency</th>
                        <th>Unit Price</th>
                        <th>Extended Price</th>
                       
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
						<th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                       
                       
                      </tr>
                    </tfoot>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

       
           
            
            
             <!-- <div class="table-responsive">
                <table class="table">
                 <!-- <tr>
                    <th style="width:50%">Subtotal:</th>
                    <td><?php //echo $SCur .' '. $SubTotal; ?></td>
                  </tr> -->
                  <!--<tr>
                    <th>Tax (5%)</th>
                    <td><?php //echo $SCur .' '. $Tax = (($SubTotal * 5)/ 100); ?></td>
                  </tr>-->
                
                  <!--<tr>
                    <th>Total:</th>
                    <td><?php //echo $SCur .' '.($SubTotal + $Tax); ?></td>
                  </tr>
                </table>
              </div> -->
			  
          
         
</div>
          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <button  class="btn btn-default" onclick="printDiv('PrintArea')"><i class="fa fa-print"></i> Print</button>
            <!--  <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Note as Qutoted</button>
              <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Send Mail</button> -->
            </div>
          </div>
        </section><!-- /.content -->
        <div class="clearfix"></div>
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
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
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
<script>
function loadDate()
{
  document.getElementById('stdate').innerHTML = document.getElementById('StartDate').value;
  document.getElementById('endate').innerHTML = document.getElementById('EndDate').value;
}
</script>
   <script type="text/javascript">
   //Date Picker
      $(function () {
     //$('#DOB').datetimepicker();
     $( "#StartDate" ).datepicker({
  inline: true,
  minDate: new Date()
});
      $( "#EndDate" ).datepicker({
  inline: true,
  minDate: new Date()
});
       
      });
    </script>
	
  </body>
</html>