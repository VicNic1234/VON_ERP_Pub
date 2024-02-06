<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$result = mysql_query("SELECT * FROM notification WHERE StaffID='".$_SESSION['uid']."'");
//check if user exist
$NoRowMsg = mysql_num_rows($result);
$FullName = $_SESSION['Firstname'] . " " .$_SESSION['SurName'];
$msg = "";
if ($NoRowMsg > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($result)) {
	$msg .= '<li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> '.$row{'Message'}.'
                        </a>
                      </li>';
	}
	
}

 /*Get EquipLocation*/
$resultSUP = mysql_query("SELECT * FROM equip_stations Order By station_name");
$NoRowSUP = mysql_num_rows($resultSUP);
if ($NoRowSUP > 0) {
  while ($row = mysql_fetch_array($resultSUP)) 
  {
    $supid = $row['cid'];
    $SupNme = $row['station_name'];
    $LocOpt .= '<option value="'.$supid.'">'.$SupNme.'</option>';
  }
 }

$ManOpt = '';
/*Get EquipManufacturer*/
$resultMAN = mysql_query("SELECT * FROM equip_manufacturers Order By station_name");
$NoRowMAN = mysql_num_rows($resultMAN);
if ($NoRowMAN > 0) {
  while ($row = mysql_fetch_array($resultMAN)) 
  {
    $supid = $row['cid'];
    $MAnNme = $row['station_name'];
    $ManOpt .= '<option value="'.$supid.'">'.$MAnNme.'</option>';
  }
 }
 //////////////////////////////////

include('route.php');

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
$MYID = $_SESSION['uid'];
//Business Year
$BYr = $_SESSION['BusinessYear'];
$CONID = $_GET['cnid']; //exit;
 $resultLI = mysql_query("SELECT *, equip_stations.station_name AS EquipLocNme
 , equip_manufacturers.station_name AS EquipManNme, equipments.cid AS Ecid  FROM equipments 
 LEFT JOIN equip_manufacturers ON equipments.EquipMan = equip_manufacturers.cid
 LEFT JOIN equip_stations ON equipments.EquipLoc = equip_stations.cid
 LEFT JOIN users ON equipments.RaisedBy = users.uid
 WHERE equipments.cid='".$CONID."'
 "); //WHERE isActive=1 ORDER BY cid

 $NoRowLI = mysql_num_rows($resultLI);
//fetch tha data from the database
   if ($NoRowLI > 0) 
   {
   $SN = 1;
  while ($row = mysql_fetch_array($resultLI)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     
     $EquipID = $row['Ecid'];
    $EquipNo = $row['EquipNo'];
    $EquipNme = $row['EquipNme'];
    $EquipCode = $row['EquipCode'];
    $EquipLoc = $row['EquipLoc'];
    $EquipMan = $row['EquipMan'];
    $EquipYrMake = $row['EquipYrMake'];
    $EquipFNo = $row['EquipFNo'];
    $Comment = $row['Comment'];
    $RaisedBy = $row['Firstname'] . " " . $row['Surname'];
    }
  }
  else
  {
    $_SESSION['ErrMsg'] = "Oops! an error occured, try again";
    header('Location: equipments');
    exit;
  }

 /*Get CURRENCY*/
$resultCurr = mysql_query("SELECT * FROM currencies Order By Abbreviation");
$NoRowCurr = mysql_num_rows($resultCurr);
if ($NoRowCurr > 0) {
  while ($row = mysql_fetch_array($resultCurr)) 
  {
    $cAB = $row['Abbreviation'];
    
    if($Currency == $cAB)
    {
     $CurrOpt .= '<option selected value="'.$cAB.'">'.$cAB.'</option>';
    }
    else
    {
      $CurrOpt .= '<option value="'.$cAB.'">'.$cAB.'</option>';
    }
   
  }
 }

     /*Get PDF*/
$resultREQ = mysql_query("SELECT DISTINCT RequestID FROM poreq ");
$NoRowREQ = mysql_num_rows($resultREQ);
if ($NoRowREQ > 0) {
  while ($row = mysql_fetch_array($resultREQ)) 
  {
    $RequestID = $row['RequestID'];
    if($PDFNUM == $RequestID)
    {
     $ReQOpt .= '<option selected value="'.$RequestID.'">'.$RequestID.'</option>';
    }
    else
    {
     $ReQOpt .= '<option value="'.$RequestID.'">'.$RequestID.'</option>';
    }
  
   
  }
 }

 /*Get Suppliers*/
$resultSUP = mysql_query("SELECT * FROM suppliers Order By SupNme");
$NoRowSUP = mysql_num_rows($resultSUP);
if ($NoRowSUP > 0) {
  while ($row = mysql_fetch_array($resultSUP)) 
  {
    $supid = $row['supid'];
    $SupNme = $row['SupNme'];
    if($VendSource == $supid){
     $SupOpt .= '<option selected value="'.$supid.'">'.$SupNme.'</option>';
    }
    else
    {
    $SupOpt .= '<option value="'.$supid.'">'.$SupNme.'</option>';
    }
  }
 }

 //////////////////////////////////
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);



//Let's get the Business Unit
 $RecDiv = "";
 $resultDiv = mysql_query("SELECT * FROM businessunit ORDER BY BussinessUnit");
 $NoRowDiv= mysql_num_rows($resultDiv);
 if ($NoRowDiv > 0) {
  while ($row = mysql_fetch_array($resultDiv)) 
  {
    $DivID = $row['id'];
    $DivName = $row['BussinessUnit'];
    if($conDiv == $DivID)
    {
    $RecDiv .= '<option selected value="'.$DivID.'">'.$DivName.'</option>';

    }
    else
    {
    $RecDiv .= '<option value="'.$DivID.'">'.$DivName.'</option>';

    }
  }
 }

	

?>
<?php if ($NoRowCUS > 0) 
            {
              //fetch tha data from the database
              while ($row = mysql_fetch_array($resultCUS)) {
             
              $Custms .= '<option value="'.$row['cussnme'].'">'.$row['CustormerNme'].'</option>';
            
              }
              
            }
        

         /*Get Supporting Docs*/
$resultSDoc = mysql_query("SELECT * FROM supportingdoc Where docid='".$CONID."' AND module='MAINTENANCE' And isActive=1 Order By sdid");
$NoRowSDoc = mysql_num_rows($resultSDoc);
 $SN = 0;
if ($NoRowSDoc > 0) {
  while ($row = mysql_fetch_array($resultSDoc)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['sdid'];
    $link = $row['link'];
    $addedby = $row['addedby'];
    $linkn = '';

    if($link != "")
    {
      $linkn = '<a target="_blank" href="'.$link.'"><i class="fa fa-link"></i></a>';
    }
    
    $description = $row['description'];
    $title = $row['title'];
    $delDoc = "";
    if($addedby == $MYID)
    {
      $delDoc = '<a href="deldoc?id='.$sdid.'&cnid='.$CONID.'"><i class="fa fa-trash"></i></a>';
    }
    $SupDocs .= '<tr>
                      <td>'.$SN.'</td>
                      <td>'.$title.'</td>
                    <td>'.$description.'</td>
                    <td>'.$linkn.'</td>
                    </tr>';

  }
 }

 /*GET MAINTENANCE ACTIVITIES*/
        /*Get Supporting Docs*/
$resultMAct = mysql_query("SELECT * FROM maintain_activities
 LEFT JOIN users ON maintain_activities.raisedby = users.uid
 Where equipid='".$CONID."' AND maintain_activities.isActive=1");
$NoRowMAct = mysql_num_rows($resultMAct);
 $SN = 0;
if ($NoRowMAct > 0) {
  while ($row = mysql_fetch_array($resultMAct)) 
  {
    $SN =  $SN  + 1;
    $maid = $row['maid'];
    $action = $row['action'];
    $remark = $row['remark'];
    $partereplaced = $row['partereplaced'];
    $raisedby = $row['raisedby'];
    $raisedNME = $row['Firstname']. " ". $row['Surname'];
    $raisedon = $row['raisedon'];
    $duedate = $row['duedate'];
    $done = $row['done'];
  
    
    $description = $row['description'];
    $title = $row['title'];
    $delDoc = "";
    if($raisedby == $MYID)
    {
      $delActivity = '<a href="delactivity?id='.$maid.'&cnid='.$CONID.'"><i class="fa fa-trash"></i></a>';
    }

    $MActivites .= '<tr>
                      <td>'.$SN.'</td>
                      <td>'.$raisedon.'</td>
                      <td>'.$action.'</td>
                      <td>'.$partereplaced.'</td>
                      <td>'.$duedate.'</td>
                      <td>'.$remark.'</td>
                      <td>'.$raisedNME.'</td>
                      </tr>';

                     /*
                     <th>S/N</th>
                        <th>Date</th>
                        <th>Activity </th>
                        <th>Parts Replacement</th>
                        <th>Due Date</th>
                        <th>Remarks</th>
                        <th>Signature</th>
                    */
  }
 }  
  

      ?>



<!DOCTYPE html>
<html>
 <?php include('../header2.php'); ?>

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
             Equipment : <?php echo $EquipNo; ?>
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $EquipNo; ?></li>
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
                  <h3 class="box-title">Equipment Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                                        <div class="col-md-12" style="background-color:#DBB895; border-radius: 15px; padding-top:22px;">
                    
                     <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="" method="post">

           <div class="form-group has-feedback col-md-4" >
                <label>Equipment Name:</label>
                <input type="text"  class="form-control" id="EquipNme" name="EquipNme" value="<?php echo $EquipNme; ?>" readonly required>
                <input type="hidden" name="EquipID" value="<?php echo $EquipID; ?>">
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback col-md-4" >
                <label>Equipment Code:</label>
                <input type="text"  class="form-control" id="EquipCode" name="EquipCode" value="<?php echo $EquipCode; ?>" readonly required>
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-4" >
                <label>Equipment Location:</label>
                <select class="form-control" id="EquipLoc" name="EquipLoc"  required>
                <option value=""> Choose Location</option>
                <?php echo $LocOpt; ?>
                </select>
            <span class="glyphicon glyphicon-location form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-4" >
                <label>Equipment Manufacturer:</label>
                <select class="form-control" id="EquipMan" name="EquipMan" required>
                <option value=""> Choose Manufacturer</option>
                <?php echo $ManOpt; ?>
                </select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>
      
       
      
          <div class="form-group has-feedback col-md-4">
                    <label>Year of Make:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control" name="EquipYrMake" value="<?php echo $EquipYrMake; ?>" readonly="" required />
                    </div><!-- /.input group -->
          </div>

           <div class="form-group has-feedback col-md-4" >
                <label>File No.:</label>
                <input type="text"  class="form-control" id="EquipFNo" name="EquipFNo" value="<?php echo $EquipCode; ?>" readonly required>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>

         
     
     
     <div class="form-group has-feedback col-md-12">
       <textarea rows="4" cols="50" placeholder=" Enter comment here..." id="Comment" name="Comment" style="width:100%; display: inline-block;" readonly=""><?php echo $Comment; ?></textarea>
     </div>
   
       <div class="row">
           
            <div class="col-xs-4 pull-right">
              <!--<button type="submit" class="btn btn-success btn-block btn-flat">Update Equipment</button>-->
            </div><!-- /.col -->
          </div>
  </div><!-- /.col -->
                    

                      </form> 
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
              <div class="col-md-12">
              <div class="col-md-6">
              <div class="box box-info">
                <div class="box-header">
                 Supporting Documents
                 <!--<button class="btn btn-primary pull-right" onclick="adddoc()"> Add Document</button>-->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>File Title</th>
                        <th>Description</th>
                        <th>Link</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $SupDocs; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>

              <div class="col-md-12">
                 <div class="box box-success">
                <div class="box-header">
                 MAINTENANCE RECORD
                 <!--<button class="btn btn-success pull-right" onclick="addactivity()"> Add Activity</button>-->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Date Registered</th>
                        <th>Activity </th>
                        <th>Parts Replacement</th>
                        <th>Due Date</th>
                        <th>Remarks</th>
                        <th>Signature</th>
                      </tr>
                    </thead>
                   <tbody>
                    <?php echo $MActivites; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
	
	
		
		
		
		
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  

       <?php include('../footer.php') ?>

      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
       <div class="row">

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
    </div>

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
          $(".datep").datepicker({

          });
          var EquipLoc = '<?php echo $EquipLoc; ?>';
          $("#EquipLoc").val(EquipLoc);

           var EquipMan = '<?php echo $EquipMan; ?>';
          $("#EquipMan").val(EquipMan);
          
      });
    </script>

  <script type="text/javascript">      
        $('.srcselect').select2();
 </script>
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
      function adddoc()
      {
      
        var CONID = '<?php echo $CONID ?>';
        //alert(CONID);
        
          var size='standart';
                  var content = '<form role="form" action="addDoc" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Title: </label><input type="text" class="form-control"  name="DocTitle" ></div>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Description: </label><input type="text" class="form-control"  name="DocDescr" ></div>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Link: </label><input type="text" class="form-control"  name="DocLink" ></div> <center> <b>--OR--</b> </center>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Upload Document: </label><input type="file" class="form-control"  name="DocFile" ></div>' +
                   

                   '<button type="submit" class="btn btn-success pull-right">Add Document</button><br/></form>';
                  var title = 'New Document Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script>

       <script type="text/javascript">
      function addactivity()
      {
      
        var CONID = '<?php echo $CONID ?>';
        //alert(CONID);
        
          var size='standart';
                  var content = '<form role="form" action="addActivity" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Activity: </label><input type="text" class="form-control"  name="Activity" required ></div>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Parts Replacement: </label><textarea class="form-control"  name="PartsReplaces" required ></textarea></div>' +

                     '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Remarks: </label><textarea class="form-control"  name="Remarks" required ></textarea></div>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Due Date: </label><input type="text" class="form-control"  name="DueDate" id="DueDate" readonly required ></div>' +
                   

                   '<button type="submit" class="btn btn-success pull-right">Add Activity</button><br/></form>';
                  var title = 'New Maintenance Record';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
                   $("#DueDate").datepicker({
                    dateFormat: 'yy/mm/dd'
                   });

              
      }
    </script>
	
  </body>
</html>