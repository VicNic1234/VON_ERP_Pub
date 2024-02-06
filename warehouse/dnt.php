<?php
session_start();
error_reporting(0);

include ('route.php');

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';

  

	  


 $resultRFQ1 = mysql_query("SELECT * FROM po WHERE Status='0'");
//check if user exist
 $NoRowRFQ1 = mysql_num_rows($resultRFQ1);
 



 
 //$resultLI = mysql_query("SELECT * FROM logistics WHERE POID='".$_GET['sRFQ']."' AND GoodsRv='1'");
 $resultLI = mysql_query("SELECT * FROM logistics WHERE POID='".$_GET['sRFQ']."' ORDER BY logID");
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
 
//let's get the customers now
 $resultSup = mysql_query("SELECT * FROM customers");
//check if user exist
 $NoRowSup = mysql_num_rows($resultSup);
if ($NoRowSup > 0) 
  {
    while ($row = mysql_fetch_array($resultSup)) 
    {
     $cusid = $row['cusid'];
     $SupNme = $row['CustormerNme'];
     $SupAddress = $row['CusAddress'];
     //$SupCountry = $row['SupCountry'];
     $SupPhone1 = $row['SupPhone1'];
     $SupPhone2 = $row['SupPhone2'];
     $SupEMail = $row['email'];
     $SupURL = $row['webaddress'];
     $HJ = '<address>
                <strong>'.$SupNme.'</strong><br>
              </address>';
     $RecordSup .='<option value="'.$cusid.'">'.$SupNme.'</option>';
    }
    
    } 

	

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Goods Received Note</title>
	<link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	 <!-- daterange picker -->
    <link href="../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
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
	<script>
function ReadLineItem(elem)
    {
       var hhh = elem.value;
	   if (hhh != "")
	   {	   
		window.location.href ="dnt?sRFQ=" + hhh;
		//window.alert("JKJ");
	   }
	
    }	
</script>
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

         <?php include ('../topmenu2.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include ('leftmenu.php'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Delivery Note
            <small><?php echo $_GET['sRFQ']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../internalsales"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Delivery Note</li>
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
function ReadDLoc(elem){
  ///We got get Description now
      //var dataString = 'searchc='+ LID;
      var CusID = $('#CusPO').val();
      var AddType = $(elem).val();
   
      var dataString = {CusID : CusID, AddType : AddType};
     
                  $.ajax({
                  type: "POST",
                  url: "searchCus.php",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     
                     $('#cusinfo').html(html);
                     //document.getElementById('LIDes').value = ItemD;
                  }
                  });

}
function ReadSupRFQ(elem)
{
  var CusNme = $("#CusPO :selected").text();
  $('#cusnme').html(CusNme);
  //document.getElementById('cusinfo').innerHTML = document.getElementById('CusPO').value;
}
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

    document.body.innerHTML = originalContents;
} 
</script>    
        <!-- Main content -->
<?php
//fetch tha data from the database
	 if ($NoRowLI > 0) {
	 $SN = 1;
	while ($row = mysql_fetch_array($resultLI)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	  $LitID = $row{'logID'};
	  $MatSer = $row['MartServNo'];
	  $Description = $row ['Description'];
	  $Qty = $row ['Qty'];
    $UOM = $row ['UOM'];
	  $GoodsRv = $row ['GoodsRv'];

	   if($GoodsRv == 1)
     {
       $Record .='
           <tr>
              <td>'.$SN.'</td>
            <td>'.$MatSer.'</td>
            <td>'.$Description.'</td>
            <td>'.$Qty.'</td>
            <td>'.$UOM.'</td>
            
            
           </tr>';
     }
	  
		
	   
						$SN = $SN + 1;
					
     }
	
}
else
{
$Record .= '<tr><td colspan="9">Select PO Code to get list of Items to deliver</td> </tr>';
}
?>			
        <section class="invoice">
		<div class="row">
            <div class="col-md-12">
              <div class="box">
			   <form>
   <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="LIRFQ" name="LIRFQ" onChange="ReadLineItem(this)">
			<option value=""> Choose PO code</option>
			<?php if ($NoRowRFQ1 > 0) 
						{
							//fetch tha data from the database
							while ($row = mysql_fetch_array($resultRFQ1)) {
							
							?>
							<option value="<?php echo $row['PONum']; ?>"  <?php if ($_GET['sRFQ'] == $row['PONum']) { echo "selected";} ?>> <?php echo $row['PONum']; ?></option>
							<?php
							}
							
						}
																
			?>
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>

       <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
        <select class="form-control" id="CusPO" name="CusPO" onChange="ReadSupRFQ(this);">
      <option value=""> Choose Customer</option>
      <?php echo $RecordSup; ?>
                  
      </select>
      <span class="glyphicon glyphicon-download form-control-feedback"></span>
     </div>
     <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
        <select class="form-control" id="DLoc" name="DLoc" onChange="ReadDLoc(this);">
      <option value=""> To Deliver @ </option>
      <option value="DDP Location">DDP Location</option>
      <option value="ExWorks">ExWorks</option>
                  
      </select>
      <span class="glyphicon glyphicon-download form-control-feedback"></span>
     </div>


     <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">
      
      <input type="text" class="form-control" id="dntc" name="dntc" placeholder="Delivery Note Code" onInput="document.getElementById('dntv').innerHTML = this.value;"  />
    </div>
   <!--  <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">
      
      <input type="text" class="form-control" id="tin" name="tin" placeholder="TIN No." onInput="document.getElementById('tinv').innerHTML = this.value;"  />
    </div>
-->
    <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;" >
      
      <input type="text" class="form-control" id="vnc" name="vnc" placeholder="Vendor Code" onInput="document.getElementById('vncv').innerHTML = this.value;"  />
    </div>
    <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;" />
      
      <input type="text" class="form-control" id="pcn" name="pcn" placeholder="Purchase Order No." onInput="document.getElementById('pcnv').innerHTML = this.value;" />
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
                <?php  echo $_SESSION['CompanyName']; ?>  
                <small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                 
                <strong><?php  echo $_SESSION['CompanyName']; ?> </strong><br>
                54 Emekuku Street, D-Line<br>
                Port Harcourt Rivers State, Nigeria<br>
                Phone: +234(84)360759<br/>
                Email: logistics@pengrg.com<br/>
                URL: www.pengrg.com
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              To
              <br/>
              <span id="cusnme" style="font-weight:70px;"></span>
              <br/>

              <address style="width:210px;" id="cusinfo">
               
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>DELIVERY NOTE:</b> <span id ="dntv"></span>
            </br>
              <b>DATE:</b> <?php echo date("d/m/Y");?>
            </br>
              <b>TIN NO:</b> <span id ="tinv">02859836-0001</span>
             </br>
              <b>VENDOR CODE:</b> <span id ="vncv"></span>
               </br>
              <b>PURCHASE ORDER #:</b> <span id ="pcnv"></span>
              
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                 <thead>
                      <tr>
                        <th>ITEM NO</th>
                        <th>Material/Service</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>UOM</th>
					
                       
                       
                        
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
					
                       
                       
                      </tr>
                    </tfoot>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->


 <div style="width:90%; padding-top: 0px;">
            <center><strong> Goods Delivered In Good Order By </strong></center>
   <b>Name:</b> </br>  </br>    
   <b>Signature:</b> </br> </br> 
   <b>Date:</b> </br>  </br>     
   </br>
    <center><strong> Goods Received In Good Order By </strong></center>
   <b>Name:</b> </br>  </br>    
   <b>Signature:</b> </br> </br> 
   <b>Date:</b> </br>  </br>             
  </div><!-- /.col -->
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