<?php
session_start();
error_reporting(0);
require '../DBcon/db_config.php';

include ('route.php');

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];



  
$resultPO = mysql_query("SELECT * FROM po");
//check if user exist
 $NoRowPO = mysql_num_rows($resultPO);

 $resultPO1 = mysql_query("SELECT * FROM po WHERE Status='0'");
//check if user exist
 $NoRowPO1 = mysql_num_rows($resultPO1);
 
$resultCUS = mysql_query("SELECT * FROM customers");
//check if user exist
 $NoRowCUS = mysql_num_rows($resultCUS);
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);

 if ($_GET['sPO'] == "")
 {}
 else
 {
 $resultLI = mysql_query("SELECT * FROM po INNER JOIN users
ON po.POAssignStaff=users.uid WHERE PONum='".$_GET['sPO']."'");
//Load OP Details in the form
 $NoRowLI = mysql_num_rows($resultLI);
  if ($NoRowLI > 0) {
	while ($row = mysql_fetch_array($resultLI)) {
	   
	  $poID = $row{'poID'};
	  $PONum = $row{'PONum'};
	  $poSupplier = $row['Supplier'];
	  $ItemsDetails = $row ['ItemsDetails'];
	  $ItemsN = $row ['ItemsN'];
	  $SubTotal = $row ['SubTotal'];
	  $Tax = $row ['Tax'];
	  $Total = $row ['Total'];
	  $POLocation = $row ['POLocation'];
	  //$POAssignStaff = $row ['POAssignStaff'];
	  $POAssignStaff = $row ['Firstname']. " ". $row ['Surname'];
	  $POdate = $row ['POdate'];
	  			
     }
}
 
 } 

	

?>
<!DOCTYPE html>
<html>
 <?php include('../header2.php') ?>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include('../topmenu2.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
       <?php include('leftmenu.php'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            PO Details
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">PO Details</li>
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
               
                <div class="box-body">
                 
	
	<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">SELECT PO TO BE TREATED</h3>
				 
				  
    

                  <div class="box-tools pull-right">
                   <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
		
   <script type="text/javascript" >
	
	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function isEnterKey(evt) {
    $("#LIDes").click(function(event) {
  event.preventDefault();
//Do your logic here
});
}



  </script>
              <div class="box" style="display:block" id="ELineIt">
			 <form >
   <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="LIPO" name="LIPO" onChange="ReadPO(this)" required >
			<option value=""> Choose PO code</option>
			<?php if ($NoRowPO1 > 0) 
						{
							//fetch tha data from the database
							while ($row = mysql_fetch_array($resultPO1)) {
							
							?>
							<option value="<?php echo $row['PONum']; ?>"  <?php if ($_GET['sPO'] == $row['PONum']) { echo "selected";} ?>> <?php echo $row['PONum']; ?></option>
							<?php
							}
							
						}
																
			?>
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>
		  
		  <!-- 
		   $poID = $row{'poID'};
	  $poSupplier = $row['Supplier'];
	  $ItemsDetails = $row ['ItemsDetails'];
	  $ItemsN = $row ['ItemsN'];
	  $SubTotal = $row ['SubTotal'];
	  $Tax = $row ['Tax'];
	  $Total = $row ['Total'];
	  $POLocation = $row ['POLocation'];
	  $POAssignStaff = $row ['POAssignStaff'];
	  $POAssignStaff = $row ['POAssignStaff'];
		  -->
		<div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">
		<label>Supplier</label>
            <input type="text" class="form-control" id="poSup" name="poSup" placeholder="Supllier" value="<?php echo $poSupplier ;?>" disabled required />
            <span class="glyphicon glyphicon-sort-by-order-alt form-control-feedback"></span>
          </div>
		  
		<div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">
		<label>PO Date</label>
            <input type="text" class="form-control" id="poDate" name="poDate" placeholder="Supllier" value="<?php echo $POdate; ?>" disabled required />
            <span class="glyphicon glyphicon-sort-by-order-alt form-control-feedback"></span>
          </div>
		  
		<div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">
		<label>No. of Items</label>
            <input type="text" class="form-control" id="poQty" name="poQty" placeholder="No. of Line Items" value="<?php echo $ItemsN; ?>" disabled required />
            <span class="glyphicon glyphicon-sort-by-order-alt form-control-feedback"></span>
          </div>
		<div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">
		<label>Sub Total</label>
            <input type="text" class="form-control" id="poSubTo" name="poSubTo" placeholder="Sub Total" value="<?php echo $SubTotal; ?>" disabled required />
            <span class="glyphicon glyphicon-resize-small form-control-feedback"></span>
        </div>
		
		<div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">
		<label>Tax</label>
            <input type="text" class="form-control" id="poTax" name="poTax" placeholder="Tax" value="<?php echo $Tax; ?>" disabled required />
            <span class="glyphicon glyphicon-resize-small form-control-feedback"></span>
        </div>
		
		<div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">
		<label>Total</label>
            <input type="text" class="form-control" id="poTotal" name="poTotal" placeholder="Total" value="<?php echo $Total; ?>" disabled required />
            <span class="glyphicon glyphicon-resize-small form-control-feedback"></span>
        </div>
		
		
		  
		<div id="DyForm" class="form-group has-feedback" style="width:90%; display:block; margin:12px; background-color: #CCCCCC;">
		    <label style="padding-left:12px">Desciption of Line Items: </label>
            
			<br>
			<label style="padding-left:12px"><?php 
			
			$ItemRaw = explode("<br>",$ItemsDetails);			
			for($i=1; $i <= $ItemsN; $i++)
			{
			$POItem	= explode("@&@",$ItemRaw[$i]);
			echo "----------------------------------<br>";
			echo "Description :". $POItem[0]. "<br>";
			echo "Quantity :". $POItem[1]. "<br>";
			echo "Ext Price :". $POItem[2]. "<br>";
			}	
			
			?> </label>
        </div>
		<div id="DyForm" class="form-group has-feedback" style="width:90%; display:block; margin:12px; background-color: #6699CC;">
		    <span style="padding-left:12px">
        <label>Delivary Location: </label>
            
			<br>
			<label style="padding-left:12px"><?php 
			
			echo $POLocation;
			
			?> </label>
    </span>
    </div>
		<div class="form-group has-feedback" style="width:90%; display:block; margin:12px; background-color: #CCCCCC;">
		    <label style="padding-left:12px">Staff Assigned: </label>
           
			<br>
			<label style="padding-left:12px"><?php 
			
			echo $POAssignStaff;
			
			?> </label>
        </div>
	<!--	<div class="form-group has-feedback" style="width:170px; display:inline-block; margin:12px;">
		    <button type="button" class="btn btn-primary btn-block btn-flat" onclick="TreatPO()">Receive Item on PO</button>
           </div> -->
		
		  </form>
			  </div>

<script>
function ReadPO(elem)
    {
       var hhh = elem.value;
	   if (hhh != "")
	   {	   
		window.location.href ="PODetails?sPO=" + hhh;
		//window.alert("JKJ");
	   }
	
    }	
</script>



              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
               
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
		<script>
		function TreatPO()
        {   
		var opid = "<?php echo $PONum; ?>";
            var title = 'TREAT PURCHASE ORDER : ' + opid;
			var size='small';
			var GLList = "<?php echo $CNRecord; ?>";
			
            var content = '<form role="form" method="post" action=""><div class="form-group">' +
			
			
			'<div class="form-group" style="width:100%;"><label>Payable Account : </label>' +
			 '<select class="form-control" id="PayAccount" name="PayAccount" required>'+
			
			GLList +
			
			'</select>'+
			'</div>' +
			
			'<div class="form-group" style="width:100%;"><label>Sales Account : </label>' +
			 '<select class="form-control" id="SalesAcc" name="SalesAcc" required>'+
			
			GLList +
			
			'</select>'+
			'</div>' +
			
			'<div class="form-group" style="width:100%;"><label>Purchase Discount Account : </label>'+
			 '<select class="form-control" id="PurAccD" name="PurAccD" required>'+
			
			GLList +
			
			'</select>'+
			
			
			'</div>'+
			
			'<div class="form-group" style="width:100%;"><label>GRN Clearing Account : </label>'+
			 '<select class="form-control" id="GRCA" name="GRCA" required>'+
			
			GLList +
			
			'</select>'+
			
			
			'</div>' +
			
			'<div class="form-group" style="width:100%;"><label>Inventory Account : </label>'+
			 '<select class="form-control" id="INVAcct" name="INVAcct" required>'+
			
			GLList +
			
			'</select>'+
			
			
			'</div>';
			
            var footer = '<button type="submit" class="btn btn-primary">Save</button></form><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
			
			//document.getElementById("ShippingC").options[e.selectedIndex].value = 4430;
			
			var select = document.getElementById("PayAccount");
			var c = 2100;
			for(var i = 0;i < select.options.length;i++){
				if(select.options[i].value == c ){
					select.options[i].selected = true;
				}
			}
			
			var select = document.getElementById("PurAccD");
			var d = 5060;
			for(var i = 0;i < select.options.length;i++){
				if(select.options[i].value == d ){
					select.options[i].selected = true;
				}
			}
			
			var select = document.getElementById("GRCA");
			var d = 1550;
			for(var i = 0;i < select.options.length;i++){
				if(select.options[i].value == d ){
					select.options[i].selected = true;
				}
			}
			
			var select = document.getElementById("INVAcct");
			var d = 1510;
			for(var i = 0;i < select.options.length;i++){
				if(select.options[i].value == d ){
					select.options[i].selected = true;
				}
			}

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
		
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  

        <?php include('../footer.php'); ?>
     

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