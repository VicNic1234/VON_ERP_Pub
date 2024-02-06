<?php
session_start();
error_reporting(0);

include('route.php');


$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

$ACTNOWID = $_SESSION['uid'];


require '../DBcon/db_config.php';
/*
$FromD = $_POST['FromD'];
if($FromD != "")
{
$FromD = DateTime::createFromFormat('Y/m/d', $FromD)->format('Y/m/d');

$ToD = $_POST['ToD'];
$ToD = DateTime::createFromFormat('Y/m/d', $ToD)->format('Y/m/d');
} */

?>
<!DOCTYPE html>
<html>
  <?php include('../header2.php') ?>
  
  <body class="skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper">
         <?php include('../topmenu2.php') ?>
          <!-- Left side column. contains the logo and sidebar -->
        <?php include('../leftmenu3.php') ?>
      
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            All Cash Request
           <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">All Cash Requests</li>
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

/*if($FromD == "" && $ToD == "")
             {
               
               
                
                
            }

else {
    

 
}      */       
                
$resultLI = mysql_query("SELECT * FROM cashreq 
 LEFT JOIN users ON cashreq.staffID = users.uid where cashreq.isActive=1");
 
 //$resultLI = mysql_query("SELECT * FROM cashreq 
 //LEFT JOIN users ON cashreq.staffID = users.uid where cashreq.isActive=1");


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
    $ReqCurr = $row['Curr'];
    $TD = $row['RequestDate']; //ClassName
              /*  if($TD != "")
                {
                $TD = DateTime::createFromFormat('Y-m-d', $TD)->format('Y/m/d');
                } */
    if($Qty > 1)
    {
       $TAmt = floatval($Qty) * floatval($Amount);
    }
    else
    {
         $Qty = 1;
        $TAmt = floatval($Amount);
    }
	  $Statun = $row['Status'];
    $RaisedBy = $row['Firstname'] . " " . $row['Surname'];//$row['RaisedBy'];
    $LastTreated = $row['LastActor'];
    $ApprovedBy = $row['ApprovedBy'];
	  $Approved = $row['Approved'];
    $FileLink = $row['attachment'];
   

    if($FileLink != ""){
    $FileLinkn = '<a target="_blank" title="Download document" href="'.$FileLink.'"><i class="fa fa-link"></i></a>';
    }
    else
    {
      $FileLinkn = '';
    }

    $ApprovedN = "-";
    if ($Approved == 0) 
            {
              $ApprovedN = "Raised";
            }
            else if ($Approved == 1)
            {
              $ApprovedN = "Pending with Supervisor of Department";
            }
            else if ($Approved == 2)
            {
              $ApprovedN = "Pending with Head of Department";
            }
            else if ($Approved == 3)
            {
              $ApprovedN = "Pending with Head of Divison";
            }
            else if ($Approved == 4) //Skip for Depts under coporate services
            {
              $ApprovedN = "Pending with your General Manager";
            }
             else if ($Approved == 5) //For only Material Request
            {
              $ApprovedN = "Pending with Contracts and Procurement";
            }

            else if ($Approved == 6) //For only Material Request
            {
              $ApprovedN = "Pending with GM Coporate Service";
            }

             else if ($Approved == 7)
            {
              $ApprovedN = "Pending with Due Diligence Officer";
            }

             else if ($Approved == 8)
            {
              $ApprovedN = "Pending with GM Due Diligence";
            }

             else if ($Approved == 9)
            {
              $ApprovedN = "Pending with MD";
            }
             else if ($Approved == 10) //Only for material request
            {
              $ApprovedN = "Pending with Due Diligence";
            }
            else if ($Approved == 11)
            {
              $ApprovedN = "Pending with Finance";
            }
            else if ($Approved == 12)
            {
              $ApprovedN = "Pending with Internal Audit";
            }
             else if ($Approved == 13)
            {
              $ApprovedN = "Approved";
            }
            else if ($Approved == 14)
            {
              $ApprovedN = "Keep In View";
            }
            else if ($Approved == 15)
            {
              $ApprovedN = "Cancelled";
            }
              else if ($Approved == 16)
            {
              $ApprovedN = "Processing Payment";
            }
             else if ($Approved == 17)
            {
              $ApprovedN = "Cash Released";
            }



    $ViewCash = '<a title="View full Request" href="cashview?rNo='.$RequestID.'&all=1"><i class="fa fa-eye"></i></a>';

if($Approved == 17)
{
  $Record .='
           <tr style="background:green; color:#FFF">
            <td>'.$SN.'</td>
            <td>'.$RequestID.'</td>
            <td>'.$ItemDes.'</td>
               <td>'.$ReqCurr.'</td>
            <td>'.$Amount.'</td>
            <td>'.$Qty.'</td>
            <td>'.$TAmt.'</td>
            <td>'.$RaisedBy.'</td>
            <td>'.$Statun.'</td>
            <td>'.$ApprovedBy.'</td>
            <td>'.$ApprovedN.'</td>
            <td>'.$FileLinkn.'</td>
            <td>'.$ViewCash.'</td>

            </tr>'
            ;
}
elseif($Approved == 16)
{
  $Record .='
           <tr style="background:orange; color:#FFF">
            <td>'.$SN.'</td>
            <td>'.$RequestID.'</td>
            <td>'.$ItemDes.'</td>
             <td>'.$ReqCurr.'</td>
            <td>'.$Amount.'</td>
            <td>'.$Qty.'</td>
            <td>'.$TAmt.'</td>
            <td>'.$RaisedBy.'</td>
            <td>'.$Statun.'</td>
            <td>'.$ApprovedBy.'</td>
            <td>'.$ApprovedN.'</td>
            <td>'.$FileLinkn.'</td>
            <td>'.$ViewCash.'</td>

            </tr>'
            ;
}
elseif($Approved == 11)
{
  $Record .='
           <tr style="background:yellow; color:#000">
            <td>'.$SN.'</td>
            <td>'.$RequestID.'</td>
            <td>'.$ItemDes.'</td>
             <td>'.$ReqCurr.'</td>
            <td>'.$Amount.'</td>
            <td>'.$Qty.'</td>
            <td>'.$TAmt.'</td>
            <td>'.$RaisedBy.'</td>
            <td>'.$Statun.'</td>
            <td>'.$ApprovedBy.'</td>
            <td>'.$ApprovedN.'</td>
            <td>'.$FileLinkn.'</td>
            <td>'.$ViewCash.'</td>

            </tr>'
            ;
}
else
{
  $Record .='
           <tr>
            <td>'.$SN.'</td>
            <td>'.$RequestID.'</td>
            <td>'.$ItemDes.'</td>
             <td>'.$ReqCurr.'</td>
            <td>'.$Amount.'</td>
            <td>'.$Qty.'</td>
            <td>'.$TAmt.'</td>
            <td>'.$RaisedBy.'</td>
            <td>'.$Statun.'</td>
            <td>'.$ApprovedBy.'</td>
            <td>'.$ApprovedN.'</td>
            <td>'.$FileLinkn.'</td>
            <td>'.$ViewCash.'</td>
           </tr>'
            ;
}

}
	    
					 
					 $SN = $SN + 1;
						
     


}
?>	

              <div class="box">
                <div class="box-header">
                
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        
                    </div>
                  <div class="table-responsive">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Request No.</th>
                        <th>Description</th>
                        <th>Currency</th>
                        <th>Unit Amount</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                        <th>Raised By</th>
                        <th>Status</th>
                        <th>Last Actor</th>
                        <th>Stage</th>
                        <th>File</th>
                        <th>View</th>
            					
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
                </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             
           </div><!-- /.col -->
            </div>
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
     <script type="text/javascript">
       $(".datep").datepicker({dateFormat : 'yy/mm/dd', changeYear: true, changeMonth: true });
     </script>
  
	
  </body>
</html>