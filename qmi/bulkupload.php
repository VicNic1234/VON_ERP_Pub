<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
//nclude ('../Classes/db_config.php');
/*if ($_SESSION['rptQMI'] != '1') {
$_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit;

}
*/

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
$Firstname = $_SESSION['Firstname'];
$SurName = $_SESSION['SurName'];
$staffName = $Firstname ." ". $SurName;
$BusinessYr = $_SESSION['BusinessYear'];
 

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Upload Line Items</title>
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
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

    document.body.innerHTML = originalContents;
} 
</script> 

        
<div id="PrintArea">
	<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                   <!-- Logo -->
        <a class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="../mBOOT/plant.png" width="50" height="50" /></span>
          <!-- logo for regular state and mobile devices
          <span class="logo-lg"> <img src="../mBOOT/plant.png" style ="width:40px; height:40px;"/></span>-->
        </a>
                  <h3 class="box-title"> <?php echo $_SESSION['CompanyAbbr']; ?>- - Bulk Line item Entry </h3>
                  
                </div><!-- /.box-header -->
				
            
              <div class="box">
               <div class="box-body">
				<!-- Form Info -->
			  <div class="col-xs-4">
              <table id="CommTab" class="table table-striped">
                
                <tbody>
                    <tr>
                        <td><b>Date:</b> </td>
                        <td><?php echo date("Y-M-d") ?></td>
                    </tr>
                    <tr>
                        <td><b>Reported by:</b> </td>
                        <td><?php echo $staffName; ?></td>
                    </tr>
					<tr>
                        <td><b>Department:</b> </td>
                        <td style="text-transformation: uppercase;"><?php echo $_SESSION['Dept']; ?></td>
                    </tr>
                    

                </tbody>

              </table>
			  </div>
                  

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">&nbsp;</h4>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
      <div class="row">
             
            <div class="col-md-8">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#31FB82;">
                <div class="box-header">
                  <h3 class="box-title">Example of Excel format </h3> &nbsp;<i class="fa fa-cogs"></i>
              </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label><a href="">Download Excel Sample Format</a></label>
                    </div>
                   <table class="table table-bordered table-striped" style="font-size:11px;">
                    <thead>
                      <tr>
                        <th>Item Number</th>
                        <th>Material Number</th>
                        <th>Description</th>
                        <th>QTY</th>
                        <th>UOM</th>
                        <th>OEM Price, Per UOM</th>
                        <th>Final Price, Per UOM</th>
                        <th>Customers PO</th>
                        <th>MANUFACTURER</th>
                      </tr>

                    </thead>
                  </table>
                    
                    
                  </div><!-- /.box-body -->
                </form>
              </div><!-- /.box -->
          
            </div>
            <div class="col-md-4">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#31FB82;">
                <div class="box-header">
                  <h3 class="box-title">Line Item Details in Excel</h3> &nbsp;<i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="itemstodb" id="formetd" enctype="multipart/form-data">
                  <div class="box-body">
                    <div class="form-group">
                      <label>Number of Rows to Import</label>
                      <input type="number" class="form-control col-md-3" name="RowNo" id="RowNo" />
                    </div>
                    <div class="form-group">
                      <label>Select Excel to Upload</label>
                      <input type="file" class="form-control" name="ExcelFile" id="ExcelFile" />
                    </div>
                                        
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="button" onclick="ImportExcel();" class="btn btn-primary pull-right">Upload</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
    
                </div><!-- ./box-body -->
               
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

          <script>
                  var _validFileExtensions = [".xlsx", ".xls"];    
                  function ImportExcel() {
                     // var arrInputs = oForm.getElementsByTagName("input");
                      //for (var i = 0; i < arrInputs.length; i++) {
                          //var oInput = arrInputs[i];
                          //if (oInput.type == "file") {
                              var sFileName = $('#ExcelFile').val();//oInput.value;
                              if (sFileName.length > 0) {
                                  var blnValid = false;
                                  for (var j = 0; j < _validFileExtensions.length; j++) {
                                      var sCurExtension = _validFileExtensions[j];
                                      if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                                          blnValid = true;
                                          break;
                                      }
                                  }
                                  var RNo = $('#RowNo').val();
                                  if (!blnValid && RNo > 2) {
                                      alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", ") + " an number of Row must be greater than 2");
                                      return false;
                                  }
                                  else{

                                      $('#formetd').submit();
                                  }
                              }
                          //}
                      //}
                    
                      return true;
                  }
          </script>
          
                 
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- End Print -->
  
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
          "bPaginate": false,
          "bLengthChange": true,
          "bFilter": false,
          "bSort": false,
          "bInfo": false,
          "bAutoWidth": false
        });
      });
    </script>
	
  </body>
</html>