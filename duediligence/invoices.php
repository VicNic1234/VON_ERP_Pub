<?php
session_start();
error_reporting(0);

include('route.php');


$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
$UID = $_SESSION['uid'];

if($UID < 1)
{
     header('Location: ../users/logout');
    exit;
}

require '../DBcon/db_config.php';

  $PageTitle = "Vendor Invoice Lists";
  
 
$resultCUS = mysql_query("SELECT * FROM customers");
//check if user exist
 $NoRowCUS = mysql_num_rows($resultCUS);
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);



	

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
            Process Vendor Invoice
           <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Vendor Invoices</li>
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
                  <h3 class="box-title">Vendor Invoice List</h3>
				 
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
/*
LEFT JOIN ivitems ON vendorsinvoices.cid = ivitems.PONo
 LEFT JOIN ivmiscellaneous ON vendorsinvoices.cid = ivmiscellaneous.PONo
*/
 /*$resultLI = mysql_query("SELECT *, 

 vendorsinvoices.PONUM AS PONUM FROM vendorsinvoices 
 LEFT JOIN suppliers ON vendorsinvoices.VendSource = suppliers.supid
 LEFT JOIN users ON vendorsinvoices.RaisedBy = users.uid
 
  WHERE vendorsinvoices.cid>0 GROUP BY PONUM ORDER BY vendorsinvoices.cid
 ");*/ //WHERE isActive=1 ORDER BY cid

$resultLI = mysql_query("SELECT *, 

 vendorsinvoices.PONUM AS PONUM, vendorsinvoices.Status As IVStatus FROM vendorsinvoices 
 LEFT JOIN suppliers ON vendorsinvoices.VendSource = suppliers.supid
 LEFT JOIN users ON vendorsinvoices.RaisedBy = users.uid
 
  WHERE vendorsinvoices.Status = 2 AND vendorsinvoices.isactive= 1 ORDER BY vendorsinvoices.cid
 ");
 $NoRowLI = mysql_num_rows($resultLI);  //vendorsinvoices.GMCSAppDate<>''
//fetch tha data from the database
	 if ($NoRowLI > 0) 
   {
	 $SN = 1;
	while ($row = mysql_fetch_array($resultLI)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	   
	  $cid = $row['cid'];
    $PONo = $row['PONUM'];
	  $IVNo = $row['IVNo'];
    $Comment = $row['Comment'];
	  $ItemNum = $row['ItemNum'];
    $Curr = $row['Currency'];
	  $conDiv = $row['conDiv'];
	  $InvDate = $row['IVDate'];
    $VendSource = $row['SupNme'];
    $RaisedBy = $row['Firstname'] . " " . $row['Surname'];//$row['RaisedBy'];
    $TotalSum = number_format($row['TotalMain']);
	  $FileLink = $row['FileLink'];
	  
	   $DDAOfficer = $row['DDAOfficer']; $DDAOfficerComment = $row['DDAOfficerComment']; 
    $DDAOfficerOn = $row['DDAOfficerOn'];
    
    $DDOfficer = $row['DDOfficer']; $DDOfficerComment = $row['DDOfficerComment']; 
    $DDOfficerOn = $row['DDOfficerOn'];
    
    $DDState = ""; $GMCSState = "";

       $GMCSAppComment = $row['GMCSAppComment']; 
    $GMCSAppDate = $row['GMCSAppDate'];
    
      $IVSTATUS = $row['IVStatus'];
      

    if($DDOfficerOn != "") { $DDState = '<i class="fa fa-legal text-green"></i>';  }
    elseif ($DDOfficerComment != "") { $DDState = '<i class="fa fa-comment text-green"></i>';  }
    else { $DDState = '<i class="fa fa-edit text-red"></i>'; }


    if($GMCSAppDate != "") { $GMCSState = '<i class="fa fa-legal text-green"></i>';  }
    elseif ($GMCSAppComment != "") { $GMCSState = '<i class="fa fa-comment text-green"></i>';  }
    else { $GMCSState = '<i class="fa fa-edit text-red"></i>'; }
    
      if($DDAOfficerOn != "") { $DDAState = '<i class="fa fa-legal text-green"></i>';  }
    elseif ($DDAOfficerComment != "") { $DDAState = '<i class="fa fa-comment text-green"></i>';  }
    else { $DDAState = '<i class="fa fa-edit text-red"></i>'; }
    
    
    if($FileLink != ""){
    $FileLinkn = '<a target="_blank" title="Download PO document" href="'.$FileLink.'"><i class="fa fa-link"></i></a>';
    }
    else
    {
      $FileLinkn = '';
    }
    
    $invStatus = "";

if($IVSTATUS == 0)  { $invStatus = '<button class="btn btn-warning btn-sm">Pending with C&P </button>'; } 
if($IVSTATUS == 1)  { $invStatus = '<button class="btn btn-info btn-sm">Pending with CS </button>'; } 
if($IVSTATUS == 2)  { $invStatus = '<button class="btn btn-primary btn-sm">Pending with Internal Control </button>'; } 
if($IVSTATUS == 3)  { $invStatus = "Pending with MD"; }
if($IVSTATUS == 4)  { $invStatus = '<button class="btn btn-danger btn-sm">Approved By MD </button>'; }
if($IVSTATUS == 5)  { $invStatus = '<button class="btn btn-success btn-sm">Paid </button>'; }
// <td>'.$AccessState.'</td>

    $ViewCon = '<a title="View full Vendor\'s Invoice" href="viewinvoice?poid='.$cid.'"><i class="fa fa-edit"></i></a>';
    if($IVSTATUS != 0)
    {
        $ViewCon = "-";
    }
    $PrintPO = '<form action="printINVOICE" method="POST">
                  <input type="hidden" name="poid" value="'.$cid.'">
                  <button class="btn btn-info pull-right"> <i class="fa fa-print"></i> </button>

                </form>';
	    $Record .='
					 <tr>
					  <td>'.$SN.'</td>
						<td>'.$IVNo.'</td>
						<td>'.$VendSource.'</td>
            <td>'.$InvDate.'</td> 
						<td>'.$Curr.'</td> 
						<td>'.getTotalSum($cid).'</td>
            <td>'.$RaisedBy.'</td>
            <td>'.$invStatus.'</td>
            <td>'.$FileLinkn.'</td>
						<td>'.$PrintPO.'</td>
            '
						;
					 
					 $SN = $SN + 1;
						
     }
}


function getTotalSum($CONID)
{
        /*Get Line Item */
$resultPOIt = mysql_query("SELECT * FROM ivitems Where PONo='".$CONID."' AND isActive=1");
$NoRowPOIt = mysql_num_rows($resultPOIt);
 $SN = 0; $SubTotal = 0; $MainTotal = 0;
if ($NoRowPOIt > 0) {
  while ($row = mysql_fetch_array($resultPOIt)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $PDFNUM = $row['PDFNUM'];
    $PDFItemID = $row['PDFItemID'];
    $description = $row['description'];
    $units = $row['units'];
    $qty = $row['qty'];
    $unitprice = $row['unitprice'];
    $totalprice = floatval($unitprice) * floatval($qty);
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $delDoc = "";
    $SubTotal = $SubTotal + $totalprice;
    
    
   
  }
 } 





$MainTotal =  $SubTotal;
//PO Miscellaneous
           /*Get M Item */
$resultPOM = mysql_query("SELECT * FROM ivmiscellaneous Where PONo='".$CONID."' AND isActive=1");
$NoRowPOM = mysql_num_rows($resultPOM);
 $SN = 0;
if ($NoRowPOM > 0) {
  while ($row = mysql_fetch_array($resultPOM)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $description = $row['description'];
    $mprice = $row['price'];
    $Impact = $row['Impact'];
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $AmtType = $row['AmtType'];
    $delDoc = "";
   

    if($Impact == "ADD") { 
      $Impact = "+"; 
      if($AmtType == "DIRECT")
      {
       $MainTotal = $MainTotal + $mprice;
      }
      else{ $MainTotal = $MainTotal + ($SubTotal * $mprice)/100; $PERT = "%"; }
    }
    else { 
      $Impact = "-"; 
      
      if($AmtType == "DIRECT")
      {
       $MainTotal = $MainTotal - $mprice;
      }
      else{ $MainTotal = $MainTotal - ($SubTotal * $mprice)/100; $PERT = "% of Sub Total"; }

    }
}
}

return number_format($MainTotal);

}
?>	

              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                 <div class="table-responsive">
                  <table id="userTab" class="table table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Invoice No.</th>
                        <th>Vendor</th>
                        <th>Invoice Date</th>
                        <th>Currency</th>
                        <th>Total Sum</th>
                        <th>Raised By</th>
                       <th>Status</th>
                       
                        
            			<th>Doc</th>
            		
            						<th>-</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>S/N</th>
                        <th>Invoice No.</th>
                        <th>Vendor</th>
                        <th>Invoice Date</th>
                        <th>Currency</th>
                        <th>Total Sum</th>
                        <th>Raised By</th>
                       <th>Status</th>
                       
                        
            			<th>Doc</th>
            		
                        <th>-</th>
                       
                      </tr>
                    </tfoot>
                  </table>
                 </div>
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
        //$("#userTab").dataTable();
        $('#userTab').dataTable({
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": false,
          "bInfo": true,
          "bAutoWidth": true
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