<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include ('route.php');

$BusinessYr = $_SESSION['BusinessYear'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

$StaffID = $_SESSION['uid'];

if($StaffID == "")
{
  exit;
}




   

/*

$LeaveTypeQ = mysql_query("SELECT * FROM leavemgt WHERE BusYear = '$BusinessYr'");
//check if user exist
 $NoRowLeaveTypeQ = mysql_num_rows($LeaveTypeQ);

$LeaveOpt = "";
if ($NoRowLeaveTypeQ > 0) 
{
  //fetch tha data from the database
  while ($row = mysql_fetch_array($LeaveTypeQ)) {
     $leaveQid = $row['id'];
     $leaveDeptmentID = $row['DeptmentID'];
     $NWkDays = $row['NWkDays'];
     $LeaveTitle = $row['LeaveTitle'];
     $LeaveOpt .= '<option value="'.$LeaveTitle.'">'.$LeaveTitle.'</option>';
  }
}
*/
/*
$StaffQ = mysql_query("SELECT * FROM users Order By Firstname");
//check if user exist
 $NoRowStaffQ = mysql_num_rows($StaffQ);

$Staffss = "";
if ($NoRowStaffQ > 0) 
{
  //fetch tha data from the database
  while ($row = mysql_fetch_array($StaffQ)) {
     $uhid = $row['uid'];
     $SName = $row['Firstname'] ." ". $row['Surname'];
    
     $Staffss .= '<option value="'.$uhid.'">'.$SName.'</option>';
  }
}
*/

$resultLeave = mysql_query("SELECT * FROM empleave INNER JOIN users ON empleave.uid=users.uid WHERE empleave.isActive='1'");
//check if user exist
 $NoRow = mysql_num_rows($resultLeave);


if ($NoRow > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($resultLeave)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     $reqid = $row['id'];
	   $leaveType = $row['leaveType'];
     $leaveDaysApplied = $row['leaveDaysApplied'];
     $leaveDaysApproved = $row['leaveDaysApproved'];
     $NoOfDays = $row['NumberofDays'];
     $Note = $row['Note'];
     $AppliedBy = $row['Firstname'] . " ". $row['Surname'];
     $CreatedOn = $row['CreatedOn'];
     $ApprovedBy = $row['UHApprovedBy'];
     $ApprovedOn = $row['UHApprovedOn'];
     $Approved = $row['Status'];
     if ($Approved == 0) {
        $Approved = 'Not Submitted';
      }
      else if ($Approved == 1)
      {
         $Approved = 'Pending with Head of Department';
      }
      else if ($Approved == 2)
      {
        $Approved = "Pending with Head of Division";
        
      }
      else if ($Approved == 3)
      {
        //$Approved = "Pending with GM of Division";
        $Approved = '<a onclick="BackToHDiv(\'GM\', \''.$reqid.'\')"><button title="By Clicking, you send back to Head of Division" class="btn btn-warning"><i class="fa fa-undo"></i> Send To Head of Division</button></a> &nbsp; <a onclick="SendToHR(\'GM\', \''.$reqid.'\')"><button title="By Clicking, you send to HR" class="btn btn-success"><i class="fa fa-send"></i> Send to HR</button></a>';
      }
      else if ($Approved == 4)
      {
        $Approved = "Pending with COO";
      }
      else if ($Approved == 5)
      {
        $Approved = "Pending with HR";
      }
      
      else if ($Approved == 6)
      {
        $Approved = "Pending in MD's Office";
      }
      else if($Approved == 7)
      {
        $Approved = "Approved";
      }
      else if($Approved == 8)
      {
        $Approved = "Cancelled";
      }

 
	  
	    $Record .='
					 <tr>
            <td>'.$AppliedBy.'</td>
            <td>'.$CreatedOn.'</td>
					  <td>'.$leaveType.'</td>
						<td>'.$Note.'</td>
						<td>'.$leaveDaysApplied.'</td>
            <td>'.$NoOfDays.'</td>
            <td>'.$Approved.'</td>
            <td><a target="_blank" href="../leave/leaveview?rNo='.$reqid.'" ><i class="fa fa-eye"></i></a></td>
           
					 </tr>
					 
					 
					 ';
						
     }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Leave Mgt.</title>
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
    <!-- DatePicker -->
  
     <link href="../mBOOT/jquery-ui.css" rel="stylesheet">

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
                  <h3 class="box-title">All leave requests on ERP</h3>
                  <div class="box-tools pull-right">
                  </div>
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Applied by</th>
                        <th>Applied on</th>
                        <th>Leave Type</th>
                        <th>Purpose</th>
                        <th>Days</th>
                        <th>No. of Days</th>
                        <th>Approved</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                   
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

    <script src="../mBOOT/jquery-ui.js"></script>
    <script src="../mBOOT/jquery-ui.multidatespicker.js"></script>
	
    <script type="text/javascript">
	 
      $(function () {
	         
         $('#AllDays').multiDatesPicker({
        //disabled: true,
        beforeShowDay: $.datepicker.noWeekends,
        addDates: ['03/14/2017', '03/19/2017', '03/14/2017', '03/16/2017'],
        //addDisabledDates: ['10/14/2017', '02/19/2017', '01/14/2017', '11/16/2017'],
        numberOfMonths: [2,6],
        defaultDate: '1/1/2017'
      });

         //LeaveDays
         $('#LeaveDays').multiDatesPicker({
        inline: true,
        //altField: '#LeaveDays1',
        //showOn: 'button',
        beforeShowDay: $.datepicker.noWeekends,
        //addDates: ['10/14/2017', '02/19/2017', '01/14/2017', '11/16/2017'],
        //addDisabledDates: ['03/14/2017', '03/19/2017', '03/14/2017', '03/16/2017'],
        numberOfMonths: [2,6],
        //defaultDate: '1/1/2017'
      });
        //$("#userTab").dataTable();
        //$('#userTab').dataTable({
          /*"bPaginate": true,
          "bLengthChange": false,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false*/
        //});
      });
    </script>

  </body>
</html>