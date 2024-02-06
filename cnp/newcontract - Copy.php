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
//Read RFQCount
$RFQcount = mysql_query("SELECT * FROM sysvar WHERE variableName = 'RFQCount'");
while ($row = mysql_fetch_array($RFQcount)) {
              $nRFQCount = $row{'variableValue'};
             
              }
  
  
$resultRFQ = mysql_query("SELECT * FROM rfq WHERE LEFT(DateCreated,4) = '2017'");
//check if user exist
 $NoRowRFQ = mysql_num_rows($resultRFQ);



 $resultRFQ1 = mysql_query("SELECT * FROM rfq WHERE Status='OPEN'");
//check if user exist
 $NoRowRFQ1 = mysql_num_rows($resultRFQ1);
 
$resultCUS = mysql_query("SELECT * FROM customers Order By cussnme");
//check if user exist
 $NoRowCUS = mysql_num_rows($resultCUS);

 
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);

 if ($_GET['sRFQ'] == "")
 {}
 else
 {
 $resultLI = mysql_query("SELECT * FROM lineitems WHERE RFQCode='".$_GET['sRFQ']."'");
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
 }

//Let's get the Division
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
            New Contract
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../cnp"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">New Contract</li>
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
                  <h3 class="box-title">Receive request for quotation</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#00C6C6; border-radius: 15px; padding-top:22px;">
                    
                     <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="regRFQ" method="post">
          <div class="form-group has-feedback col-md-6" >
                <label>Choose Source:</label>
          		  <select class="form-control" id="RFQSource" name="RFQSource" required>
          			<option value=""> Choose Source</option>
          			<option value="Email"> Email</option>
          			<option value="Portal"> Portal</option>
          			<option value="Others"> Others</option>
          			</select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>
		  
		    <div class="form-group has-feedback col-md-6">
            <label>Scope Check:</label>
            <select class="form-control" id="RFQScope" name="RFQScope" required>
      			<option value=""> Scope Check</option>
      			<option value="Out"> Out of Scope</option>
      			<option value="Within"> Within Scope</option>
      			</select> 
            <span class="glyphicon glyphicon-download form-control-feedback"></span>
        </div>
         
		    <div class="form-group has-feedback col-md-6" >
          <label>Has rfq elapsed?:</label>
            <select class="form-control" id="RFQEllapes" name="RFQEllapes" required >
  					<option value="No"> No</option>
  					<option value="Yes">Yes</option>
  					</select> <span class="glyphicon glyphicon-dashboard form-control-feedback"></span>
        </div>
		  
		  <div class="form-group has-feedback col-md-6">
                 
                    <label>Date range:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="reservation" name="reservation" required />
                    </div><!-- /.input group -->
          </div>
<script>
function MakeRFQ()
    {
	
	var Customernme = document.getElementById('RFQCus').options[document.getElementById('RFQCus').selectedIndex].text;
	 document.getElementById('RFQCus1').value =  document.getElementById('RFQCus').options[document.getElementById('RFQCus').selectedIndex].text;
	var PEAStaffnme = '<?php echo $FullName; ?>';
	//var PEAStaffnme = document.getElementById('PEAss').options[document.getElementById('PEAss').selectedIndex].text;;
	var RFQYear = '<?php echo $BYr;?>';
	var snRFQ = <?php echo $nRFQCount; ?>;
	var RFQNo = document.getElementById('ReqNo').value;
	
	//Let's refine string for RFQ generation
	//var RFQcus = Customernme.substring(0,2); 
  var RFQcus = document.getElementById('RFQCus').options[document.getElementById('RFQCus').selectedIndex].value;
	var RFQstaff = PEAStaffnme.split(" ");
	var RFQstaff1 = RFQstaff[0];
	var RFQstaff2 = RFQstaff[1];
	RFQstaff = RFQstaff[0].substring(0,1) + RFQstaff[1].substring(0,1);
	//Final RFQ Number 
	var RFQNumber = "PE" + RFQstaff + snRFQ + "/" + RFQYear + "_" + RFQcus + "_" + RFQNo;
	//alert(RFQNumber);
	document.getElementById('RFQNo').value = RFQNumber; 
	
    }	

</script>	
<script>

</script>	
<script language="javascript">
        function open_container()
        {
            var size='standart';
            var content = '<form role="form" action="www.google.com"><div class="form-group">' +
			'<div class="form-group has-feedback" >' +
            '<select class="form-control" id="LICurr" name="LICurr" required>' +
			'<option value=""> Choose Supplier</option>' +
			'<option value="NGN"> NGN</option>' +
			'<option value="USD"> USD</option>' +
			'</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>' +
            '</div>' +
			'<div class="form-group has-feedback" >' +
            '<select class="form-control" id="LICurr" name="LICurr" required>' +
			'<option value=""> Choose Currency</option>' +
			'<option value="NGN"> NGN</option>' +
			'<option value="USD"> USD</option>' +
			'</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>' +
            '</div>' +
			'<input type="text" class="form-control" id="LIPrice" name="LIPrice" placeholder="Unit Price" onKeyPress="return isNumber(event)" required />' +
			'</div>'+
			'<div class="form-group"><input type="text" class="form-control" id="exampleInputPassword1" placeholder="Quotation Note"></div>' +
			
			'<button type="submit" class="btn btn-primary">Save changes</button></form>';
            var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
        }
        function setModalBox(title,content,footer,$size)
        {
            document.getElementById('modal-bodyku').innerHTML=content;
            document.getElementById('myModalLabel').innerHTML=title;
            document.getElementById('modal-footerq').innerHTML=footer;
           
            
                $('#myModal').attr('class', 'modal fade')
                             .attr('aria-labelledby','myModalLabel');
                $('.modal-dialog').attr('class','modal-dialog');
           
        }
        </script>	
	
          <div class="form-group has-feedback col-md-6">
            <label>Choose Division:</label>
            <select class="form-control" id="RFQDiv" name="RFQDiv" required >
            <option value=""> Choose Division</option>
            <?php echo $RecDiv; ?>
            </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>

		   <div class="form-group has-feedback col-md-6">
            <label>Choose Customer:</label>
    		    <select class="form-control srcselect"> <!-- id="RFQCus" name="RFQCus" onChange="MakeRFQ()"required -->
    			   <option value=""> Choose Customer</option>
    			   <?php echo $Custms; ?>
    			  </select>
        </div>
		  <input type="hidden" id="RFQCus1" name="RFQCus1" />
		  <!-- <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="PEAss" name="PEAss" onchange="MakeRFQ()" required >
			<option value=""> Assign PE staff</option>
			
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>-->
		   
		 <div class="form-group has-feedback col-md-12">
		   <textarea rows="4" cols="50" placeholder=" Enter comment here..." id="Comment" name="Comment" style="width:100%; display: inline-block;"></textarea>
		 </div>
   
		  
  </div><!-- /.col -->
                    
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Contract number</strong>
                      </p>
			<div class="form-group has-feedback">
            <input type="text" class="form-control" id="ReqNo" name="ReqNo" onInput="MakeRFQ()" placeholder="ENL/CUSN/C&P/CONTR/002"  required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
		  <p class="text-center">
                        <strong>RFQ number</strong>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="RFQNo" name="RFQNo" placeholder="RFQ Number" required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
<br>
			<p class="text-center">
                        <strong>Attach RFQ Document (Optional)</strong>
                      </p>
			<div class="form-group has-feedback">
            <input type="file" id="RFQFile" name="RFQFile" class="form-control" />
			
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>		

          <p class="text-center">
                        <strong>Inherit Existing RFQ</strong>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
          <center>  <input type="checkbox" title="Open for Project Control" id="chkmRFQNo" name="chkmRFQNo" onclick="chkIhRFQ(this);"></input> </center>
           
          </div>  
         
          <div id="mirrior" class="form-group has-feedback" style="width:100%; display: none;">
        <select class="form-control" id="mLIRFQ" name="mLIRFQ">
      <option value=""> Choose RFQ code to Inherit</option>
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
                  
      </select> 
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
     

      function chkIhRFQ (relm)
   {
    
    var ghid = $(relm).attr('id');
   
    if($('#'+ghid).is(":checked") == true)
    {
      //document.getElementById('mirrior').display="inline-block";
      $('#mirrior').show();
      //alert("God's Grace");
    }
    else 
    {
      //document.getElementById('mirrior').display="none";
       $('#mirrior').hide();
    }
  }
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
        //$('#reservation').daterangepicker();
        $('#reservation').daterangepicker({
   // "startDate": "11/29/2015",
   // "endDate": "12/05/2015",
    "minDate": new Date()
});
		// $("#endDate").datepicker("option", "minDate", testm);
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
				  //minDate: '2015-05-12',
                  endDate: moment()
                },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        
       

       
      });
    </script>

  <script type="text/javascript">      
        $('.srcselect').select2();
 </script>
	
  </body>
</html>