<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');


$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

$StaffID = $_SESSION['uid'];

if($StaffID == "")
{
  exit;
}

if($_POST['travelapply'])
{
    $sid = mysql_real_escape_string(trim(strip_tags($_POST['travelapply'])));
    $TravelPurpose = mysql_real_escape_string(trim(strip_tags($_POST['TravelPurpose'])));
    $TravelType = mysql_real_escape_string(trim(strip_tags($_POST['TravelType'])));
    $TravelDays = mysql_real_escape_string(trim(strip_tags($_POST['TravelDays'])));
    $TravelDestination = mysql_real_escape_string(trim(strip_tags($_POST['TravelDestination'])));

    if($TravelPurpose == "" || $TravelType == "" || $TravelDays == "" || $TravelDestination == "")
    {
        $G = "Form must be completely filled. Thanks!";
    }
    else
    {
        $queryNewTravel = "INSERT INTO emptravel (uid, travelType, travelDaysApplied, travelDaysApproved, Note, Destination, isActive) 
        VALUES ('$sid','$TravelType','$TravelDays','$TravelDays','$TravelPurpose','$TravelDestination','1');";
        $regr = mysql_query($queryNewTravel);
        $B = "Your Request have been sent!";
    }
}

$result = mysql_query("SELECT * FROM emptravel WHERE uid = '".$StaffID."' AND isActive='1'");
//check if user exist
$NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($result)) {
     $reqid = $row['id'];
	   $travelType = $row['travelType'];
     $travelDaysApplied = $row['travelDaysApplied'];
     $travelDaysApproved = $row['travelDaysApproved'];
     $NoOfDays = explode(",",$travelDaysApproved);
     $Note = $row['Note'];
     $Destination = $row['Destination'];
     $CreatedOn = $row['CreatedOn'];
     $ApprovedBy = $row['UHApprovedBy'];
     $ApprovedOn = $row['UHApprovedOn'];
     $Approved = $row['Status'];
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
            <td>'.$CreatedOn.'</td>
					  <td>'.$travelType.'</td>
            <td>'.$Note.'</td>
						<td>'.$Destination.'</td>
						<td>'.$travelDaysApplied.'</td>
            <td>'.count($NoOfDays).'</td>
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
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | My Travel Mgt.</title>
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
              <div class="box collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">My Travels &nbsp;&nbsp; <i class="fa fa-bus"></i></h3>
                  <div class="box-tools pull-right">
                    <!-- <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                     <a onclick="window.close();"><button class="btn btn-box-tool"  ><i class="fa fa-times"></i></button></a>-->
                  </div>
                </div><!-- /.box-header -->
            
               
                <div class="box-body">
                  <!--<div class="col-md-12" id="AllDays"></div>-->
                </div><!-- /.box-body -->
             
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Travel Request</h3>
                  <div class="box-tools pull-right">
                    <!-- <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                     <a href="./"><button class="btn btn-box-tool"  ><i class="fa fa-times"></i></button></a>-->
                  </div>
                </div><!-- /.box-header -->
            
               
                <div class="box-body">
                  <div class="col-md-12">
                    <form enctype="multipart/form-data" action="" method="post" style="font-size:13px;">
                   
                      <div class="form-group has-feedback col-md-2">
                      <label>Travel Type <span style="color:red">*<span></label>
                      <select class="form-control" id="TravelType" name="TravelType" required >
                        <option value=""> -- </option>
                        <option value="Inter-city">Inter-city</option>
                        <option value="Interstate">Interstate</option>
                        <option value="International">International</option>

                      </select>
                      </div>

                      <div class="form-group has-feedback col-md-3">
                      <label>Travel Days <span style="color:red">*<span></label>
                      <!--<button type="button" class="form-control" id="LeaveDays" class="btn btn-primary">Select Leave Days</button>-->
                      <input type="text" class="form-control" id="TravelDays" name="TravelDays" readonly required />
                      </div>

                      <div class="form-group col-md-3">
                      <label>Travel Destination</label>
                      <input type="text" class="form-control" id="TravelDestination" name="TravelDestination" placeholder="Destination" required />
                      </div>

                      <div class="form-group col-md-6">
                      <label>Detailed Purpose</label>
                      <input type="text" class="form-control" id="TravelPurpose" name="TravelPurpose" placeholder="Reason for travelling" required />
                      </div>

                      

                      <div class="form-group col-md-3 pull-right" style="padding-top:20px;">
                      <button type="submit" name="travelapply" value="<?php echo $StaffID; ?>" class="btn btn-primary">Apply</button>
                      </div>
                     </form>
                  </div>
                </div><!-- /.box-body -->
             
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
	
	<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">My travel requests on ERP</h3>
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
                        <th>Applied on</th>
                        <th>Travel Type</th>
                        <th>Purpose</th>
                        <th>Destination</th>
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

         //TravelDays
         $('#TravelDays').multiDatesPicker({
        inline: true,
        //altField: '#LeaveDays1',
        //showOn: 'button',
        //beforeShowDay: $.datepicker.noWeekends,
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