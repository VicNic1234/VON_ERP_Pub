<?php
session_start();
error_reporting(0);
include ('DBcon/db_configOOP.php');
if ($_SESSION['Dept'] == "") 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: users/logout'); exit; }

$resultStaff = mysqli_query($dbhandle, "SELECT * FROM users ORDER BY DoB"); 


$NoRowStaff = $resultStaff->num_rows;
$SN = 0;
 if ($resultStaff->num_rows > 0) {
     while($row = $resultStaff->fetch_assoc()) {
        $DeptID = $row['DeptID']; 
        $Supervisor = $row['Supervisor']; 
        $HDept = $row['HDept']; 
        $HDiv = $row['HDiv']; 
        $Mgr = $row['Mgr']; 
        $CEO = $row['CEO']; 
        $CEO = $row['CEO']; 
        //$DBMth = substr($row['DoB'], 0, 5);
        $date = DateTime::createFromFormat('m/d/Y', $row['DoB']);
        $DBMth = $date->format('M-d');
$SN = $SN + 1;

        $Record .= '<tr>
                    <td>'.$SN.'</td>
                    <td>'.$row['Firstname'].' ' .$row['Middlename']. ' '. $row['Surname'] .'</td>
                    <td>'.$DBMth.'</td>
        </tr>';
       
        }
      }

  


?>
<!DOCTYPE html>
<html>
<!-- HEAD -->
<?php include ('header.php'); ?>
<!-- HEAD -->
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Top Menu -->
      <?php include ('topmenu.php'); ?>
      <!-- Top Menu -->
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
             <?php echo '<img src="data:image/jpeg;base64,'. base64_encode($prasa). '" class="img-circle" alt="User Image">'; ?>
            </div>
            <div class="pull-left info">
              <p> <?php echo $_SESSION['SurName']. " ". $_SESSION['Firstname']; ?> </p>

                    
					 
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <?php include ('leftmenu.php');  ?>
         </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <i class="fa fa-birthday-cake"></i> Birthday Dashboard
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Birthday Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
           <!-- Info boxes -->
       
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
                  <h3 class="box-title"></h3>
                  <div class="box-tools pull-right">
                   
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                   <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Staff Name</th>
                        <th>Birthday</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
                </div><!-- ./box-body -->
                <div class="box-footer">
    
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
         
        <div>
           <!-- <script src="mBOOT/highcharts.js"></script>
            <script src="mBOOT/highcharts-3d.js"></script>
            <script src="mBOOT/highcharts-more.js"></script>
            <script src="mBOOT/exporting.js"></script>-->
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- FOOTER -->
      <?php include ('footer.php'); ?>
      <!-- FOOTER -->
     
      <!-- Control Sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js" type="text/javascript"></script>

    <!-- DATA TABES SCRIPT -->
    <script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>
     <script type="text/javascript">
   
      $(function () {
     
        $("#userTab").dataTable({
          "bSort": true,
          "bPaginate": false
        });
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
  </body>
</html>