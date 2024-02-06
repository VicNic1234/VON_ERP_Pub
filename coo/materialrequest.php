<?php
session_start();
error_reporting(0);

include('route.php');


$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';


?>
<!DOCTYPE html>
<html>
  <?php include('../header2.php') ?>
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
            <i class="fa fa-cubes text-green"></i> Material Request
           <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Material Request</li>
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
                  <h3 class="box-title">Filter Search</h3>
				 
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



  </script>
  <script language="javascript">
  						
        function open_container(LID, rfq, mst, qty, uom)
		
        {  
			var title = 'Edit Item ID no. is : '+LID + ' in RFQ No. : '+rfq;
			///We got get Description now
      var dataString = 'search='+ LID;
      var ItemD = '';
                  $.ajax({
                  type: "POST",
                  url: "searchLI.php",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     ItemD = html;
                     //alert(ItemD); 
                     document.getElementById('LIDes').value = ItemD;
                  }
                  });
              

            var size='standart';
            var content = '<form role="form" method="post" action="updateLineItem"><div class="form-group">' +
			'<label>Material/Service of Line Item: </label>' +
			'<div class="form-group"><input type="text" class="form-control" id="LIMS" name="LIMS" value="'+ mst +'" placeholder="Material/Service"></div>' +
			'<input type="hidden" name="LIID" value="'+ LID +'" ></input>' +
			'<input type="hidden" name="LIRFQ" value="'+ rfq +'" ></input>' +
			'<div class="form-group has-feedback" style="width:100%;">' +
		    '<label>Desciption of Line Item: </label>' +
            '<textarea class="form-control" id="LIDes" name="LIDes" placeholder="Description of Line Item" >'+ ItemD +'</textarea>' +
            '<span class="glyphicon glyphicon-align-justify form-control-feedback"></span>' +
			'</div>' +
			'<label>Quantity of Line Item: </label>' +
			'<input type="text" class="form-control" id="LIQty" name="LIQty" placeholder="Quantity" value="'+ qty +'" onKeyPress="return isNumber(event)" required />' +
			'</div>'+
			'<label>UOM of Line Item: </label>' +
			'<div class="form-group"><input type="text" class="form-control" id="LIUOM" name="LIUOM" value="'+ uom +'" placeholder="Enter UOM"></div>' +
			
			'<button type="submit" class="btn btn-primary">Save changes</button></form>';
           // var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
        }
		
		function Delete_LineItem(LID, rfq, mst, qty, uom)
		
        {  
			var title = 'Are You Sure you want to DELETE Item with ID no.: '+LID + ', in RFQ No.: '+rfq;
			///We got get Description now
      var dataString = 'search='+ LID;
                  $.ajax({
                  type: "POST",
                  url: "searchLI.php",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     $('#despd').html(html);
                  }
                  });

            var size='standart';
            var content = '<form role="form" method="post" action="rmvlineitem"><div class="form-group">' +
			'Line Item : <span id="despd">Loading...</span> <br/><br/>' +
			'<label>Note: After delete, you can never recover this item, thanks!  </label> <br/> Do you still want to delete? ' +
			'<input type="hidden" name="LIID" value="'+ LID +'" ></input>' +
			'<input type="hidden" name="LIRFQ" value="'+ rfq +'" ></input>' +
			
			'<button type="submit" class="btn btn-primary">Yes</button></form>';
           // var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
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



<?php

 $resultLI = mysql_query("SELECT * FROM poreq 
 LEFT JOIN users ON poreq.staffID = users.uid where poreq.isActive=1"); //WHERE isActive=1 ORDER BY cid WHERE poreq.Approved = 11
 //LEFT JOIN suppliers ON contracts.VendSource = suppliers.supid


 $NoRowLI = mysql_num_rows($resultLI);
//fetch tha data from the database
	 if ($NoRowLI > 0) 
   {
	 $SN = 1;
	while ($row = mysql_fetch_array($resultLI)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	   
	  $cid = $row['reqid'];
	  $RequestID = $row['RequestID'];
	  $ItemDes = $row['ItemDes'];
    $Purpose = $row['Purpose'];
    $Amount = $row['Amount'];
    $Qty = $row['Qty'];
	  $Statun = $row['Status'];
    $RaisedBy = $row['Firstname'] . " " . $row['Surname'];//$row['RaisedBy'];
    $LastTreated = $row['LastActor'];
	  $Approved = $row['Approved'];
   

    if($FileLink != ""){
    $FileLinkn = '<a target="_blank" title="Download contract document" href="'.$FileLink.'"><i class="fa fa-link"></i></a>';
    }
    else
    {
      $FileLinkn = '';
    }

    if ($Approved == 0) {
        //if($Status == "Sent Back")
          
        $ApprovedOpt = "Raised";
      }
      else if ($Approved == 1)
      {
        $ApprovedOpt = "Pending with Supervisor of Department";

      }
      else if ($Approved == 2)
      {
        $ApprovedOpt = "Pending with Head of Department";

      }
      else if ($Approved == 3)
      {
        $ApprovedOpt = "Pending with Head of Divison";

      }
      else if ($Approved == 4)
      {
        $ApprovedOpt = "Pending with Corporate Services Manager";

      }
       else if ($Approved == 5)
      {
        $ApprovedOpt = "Pending with Due Diligence";

      }
       else if ($Approved == 6)
      {

        $ApprovedOpt = "Pending with Contracts and Procurement";
      }
       else if ($Approved == 7)
      {
        $ApprovedOpt = "Pending with MD";

      }
       else if ($Approved == 8)
      {
        $ApprovedOpt = "Pending with Due Diligence";

      }
      else if ($Approved == 9)
      {
        $ApprovedOpt = "Pending with Finance";

      }
      else if ($Approved == 10)
      {
        $ApprovedOpt = "Pending with Internal Audit";

      }
       else if ($Approved == 11)
      {
        $ApprovedOpt = "Approved";
      }
      else if ($Approved == 12)
      {
        $ApprovedOpt = "Sent back";
      }
      else if ($Approved == 13)
      {
        $ApprovedOpt = "Cancelled";
      }


    $ViewCon = '<a title="View full contract" href="viewcon?cnid='.$cid.'"><i class="fa fa-eye"></i></a>';
if($Approved == 7)
{
  $Record .='
           <tr>
            <td>'.$SN.'</td>
            <td>'.$RequestID.'</td>
            <td>'.$ItemDes.'</td>
            <td>'.$Amount.'</td>
            <td>'.$RaisedBy.'</td>
            <td>'.$Statun.'</td>
            <td>'.$LastTreated.'</td>
            <td>'.$ApprovedOpt.'</td>
            <td><a target="_blank" href="../requisition/mdppor?pdfid='.$RequestID.'"><i class="fa fa-eye"></i></a></td>

           '
            ;
}
/*
else
{
  $Record .='
           <tr>
            <td>'.$SN.'</td>
            <td>'.$RequestID.'</td>
            <td>'.$ItemDes.'</td>
            <td>'.$Amount.'</td>
            <td>'.$RaisedBy.'</td>
            <td>'.$Statun.'</td>
            <td>'.$LastTreated.'</td>
            <td>'.$ApprovedOpt.'</td>
            <td><a target="_blank" href="../requisition/mdppor?pdfid='.$RequestID.'"><i class="fa fa-eye"></i></a></td>
           '
            ;
}
*/
	    
					 
					 $SN = $SN + 1;
						
     }
}
?>	

              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Request No.</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Raised By</th>
                        <th>Status</th>
                        <th>Last Actor</th>
                        <th>Stage</th>
                        <th>Treat</th>
            					
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
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