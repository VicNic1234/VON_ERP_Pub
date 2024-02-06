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
            Meetings
           <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Meetings</li>
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
                  <h3 class="box-title"></h3>
				          <button class="btn btn-primary pull-right" onclick="addmeeting()">Add New Meeting</button>
                </div><!-- /.box-header -->

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

 $resultLI = mysql_query("SELECT * FROM legalmeetings 
 LEFT JOIN users ON legalmeetings.addedby = users.uid WHERE legalmeetings.isActive = 1 
 "); //WHERE isActive=1 ORDER BY cid

 $NoRowLI = mysql_num_rows($resultLI);
//fetch tha data from the database
	 if ($NoRowLI > 0) 
   {
	 $SN = 1;
	while ($row = mysql_fetch_array($resultLI)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	   
	  $sdid = $row['sdid'];
	  $description = $row['description'];
    $title = $row['title'];
    $venue = $row['venue'];
    $mdate = $row['mdate'];
	  $link = $row['link'];
    $addedby = $row['addedby'];
	  $addedon = $row['addedon'];
    $RaisedBy = $row['Firstname'] . " " . $row['Surname'];//$row['RaisedBy'];
    $nlink = "";
   if($link != "")
   {
    $nlink = '<a title="View Document" target="_blank" href="'.$link.'"><i class="fa fa-eye"></i></a>';
   }

   $delm = '<a title="Delete Meeting" href="delmeeting?id='.$sdid.'"><i class="fa fa-trash text-red"></i></a>';
    

	    $Record .='
					 <tr>
					  <td>'.$SN.'</td>
						<td>'.$title.'</td>
            <td>'.$mdate.'</td>
            <td>'.$venue.'</td>
						<td>'.$description.'</td>
						<td>'.$RaisedBy.'</td>
            <td>'.$addedon.'</td>
            <td>'.$nlink.'</td>
						<td>'.$delm.'</td>';
            
					 
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
                        <th>Title</th>
                        <th>Date</th>
                        <th>Venue</th>
                        <th>Description</th>
                        <th>Created By</th>
                        <th>Created On</th>
                        <th>Doc</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>S/N</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Venue</th>
                        <th>Description</th>
                        <th>Created By</th>
                        <th>Created On</th>
                        <th>Doc</th>
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
         $(".datep").datepicker();
      });
    </script>

        <script type="text/javascript">
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

       <script type="text/javascript">
      function addmeeting()
      {
      
        //var CONID = '<?php echo $CONID ?>';
        //alert(CONID);
        
          var size='standart';
                  var content = '<form role="form" action="addMeeting" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                  // '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Title: </label><input type="text" class="form-control"  name="MeetingTitle" required ></div>' +

                     '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Venue: </label><input type="text" class="form-control"  name="MeetingVenue" required ></div>' +

                     '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Date: </label><input type="text" readonly class="form-control datep"  name="MeetingDate" required ></div>' +


                      '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Description: </label><textarea class="form-control"  name="MeetingDescr" required ></textarea></div>' +

                     '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Link: </label><input type="text" class="form-control"  name="DocLink" ></div> <center> <b>--OR--</b> </center>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Upload Document: </label><input type="file" class="form-control"  name="DocFile" ></div>' +

                   

                    
                   

                   '<button type="submit" class="btn btn-success pull-right">Add Meeting</button><br/></form>';
                  var title = 'New Meeting';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
                  $(".datep").datepicker();

              
      }
    </script>

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

	
  </body>
</html>