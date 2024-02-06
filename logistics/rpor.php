<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');


$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

$resultNumofRP = mysql_query("SELECT * FROM poreq");
//check number of Purchase Requisition
 $NoRowNumofRP = mysql_num_rows($resultNumofRP);

$result = mysql_query("SELECT * FROM poreq WHERE StaffID = '".$_SESSION['uid']."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($result)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     $reqid = $row['reqid'];
	   $staffName = $row['staffName'];
     $staffID = $row['staffID'];
     $ReqID = $row['RequestID'];
     $ReqDate = $row['RequestDate'];
     $ItemDes = $row['ItemDes'];
     $Purpose = $row['Purpose'];
     $Amount = $row['Amount'];
     $Qnt = $row['Qty'];
     $Approved = $row['Approved'];
      if ($Approved == 0) {
        $Approved = "No";
      }
      else if ($Approved == 1)
      {
        $Approved = "Yes";
      }
      else
      {
        $Approved = "Cancelled";
      }

	  
	    $Record .='
					 <tr>
            <td>'.$ReqID.'</td>
            <td>'.$ReqDate.'</td>
					  <td>'.$ItemDes.'</td>
						<td>'.$Purpose.'</td>
						<td>'.$Amount.'</td>
            <td>'.$Qnt.'</td>
            <td>'.$Approved.'</td>
						
						
					
					
					 </tr>
					 
					 
					 ';
						
     }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>PLANT E.R.P | Register New UOM</title>
	<link rel="icon" href="../mBoot/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	
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
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
    </script>
	
  </head>
  <body class="skin-blue sidebar-mini">
  
        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
         
<?php if ($G == "")
           {} else {
echo

'<br><br><div class="alert alert-danger alert-dismissable">' .
                                       '<i class="fa fa-ban"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                        '<b></b>  '.  $G.
                                    '</div>' ; 
									$_SESSION['ErrMsg'] = "";}
?>
<?php if ($B == "")
           {} else {
echo

'<br><br><div class="alert alert-info alert-dismissable">' .
                                       '<i class="fa fa-ban"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                        '<b></b>  '.  $B.
                                    '</div>' ; 
									$_SESSION['ErrMsgB'] = "";}
?>

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Raise Purchase Order Requisition</h3>
				   
                  <div class="box-tools pull-right">
                  <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
				  <a style="float:right" href="./"> X</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8">
                      <p class="text-center">
					  
                        <strong>POR Details</strong>
                      </p>
                     <form enctype="multipart/form-data" action="addpor" method="post">
      <div class="form-group has-feedback" style="width:40%; display: inline-block;">
		   <textarea type="text" class="form-control" id="desp" name="desp" placeholder="Item(s) Description" required ><?php echo  $UOMNme1; ?></textarea>

		  </div>
		   <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
		   <textarea type="text" class="form-control" id="ppor" name="ppor" placeholder="Purpose of POR" required ></textarea>
      </div>

      <div class="form-group has-feedback" style="width:40%; display: inline-block;">
       <input type="text" class="form-control" id="amt" name="amt" placeholder="Amount Per Item" value="" required />
      </div>

      <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
       <input type="text" class="form-control" id="qnt" name="qnt" placeholder="Quantity" onKeyPress="return isNumber(event)" value="" required />
      </div>
      <input type="hidden" name="ssv" value="<?php echo  $UOMid1; ?>" />
       
		  
		
         
              
                    </div><!-- /.col -->
                    <div class="col-md-4">
                     


<br>
				  
          <div class="row">
      <div class="form-group has-feedback col-xs-12" style="width:90%; display: inline-block; margin:12px;">
        <label>Request ID</label>
       <input type="text" class="form-control" id="rqid" name="rqid" placeholder="Request ID" value="PENL-<?php echo $NoRowNumofRP; ?>B" required />
      </div>
            <div class="col-xs-12">
				<?php if (trim(strip_tags($_GET['uomid'])) != "") { ?>
              <button type="submit" class="btn btn-primary btn-block btn-flat">Update UOM</button>
			  <?php } else { ?>
			   <button type="submit" class="btn btn-primary btn-block btn-flat">Raise POR</button>
			   <?php } ?>
            </div><!-- /.col -->
          </div>
            </form> 
			<br/>
		
			<br/>
			<br/>
			<form>
			 <div class="col-xs-12">
				<?php if (trim(strip_tags($_GET['uomid'])) != "") { ?>
              <button type="submit" class="btn btn-primary btn-block btn-flat">Cancel</button>
			    <?php } else { ?>
			  
			   <?php } ?>
            </div><!-- /.col -->
			</form>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        
	
	<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">POR by you on ERP</h3>
                  <div class="box-tools pull-right">
                   <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
					              <th>Request ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Purpose</th>
                        <th>Amount</th>
                        <th>Quantity</th>
                        <th>Approved</th>
                        
						
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Request ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Purpose</th>
                        <th>Amount</th>
                        <th>Quantity</th>
                        <th>Approved</th>
                        
          
                       
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
     
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

    

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
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
   
	<!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
	
    <script type="text/javascript">
	 
      $(function () {
	   
        //$("#userTab").dataTable();
        $('#userTab').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
	
  </body>
</html>