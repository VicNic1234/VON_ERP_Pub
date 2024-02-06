<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$ACTNOWID = $_SESSION['uid'];
if($ACTNOWID == "")
{
  header('location: ../');
  exit;
}

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

//$resultNumofRP = mysql_query("SELECT * FROM poreq ORDER BY reqid DESC");
$resultPDFCount = mysql_query("SELECT * FROM sysvar WHERE variableName='ICTCOUNT'");
while ($row = mysql_fetch_array($resultPDFCount)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
       $ICTCount = $row['variableValue'];
     }

$OptLocation = "";
$resultChartClass = mysql_query("SELECT * FROM wh_stations Where isActive=1");
$NoRowChartClass = mysql_num_rows($resultChartClass);
if ($NoRowChartClass > 0) {
  while ($row = mysql_fetch_array($resultChartClass)) {
    $cid = $row['cid'];
    $class_name = $row['station_name'];
    
    $OptLocation .= '<option value="'.$cid.'">'.$class_name.'</option>';

    }

  }

//Let's get the Business Unit
 $RecDiv = "";
 $resultDiv = mysql_query("SELECT * FROM businessunit ORDER BY BussinessUnit");
 $NoRowDiv= mysql_num_rows($resultDiv);
 if ($NoRowDiv > 0) {
  while ($row = mysql_fetch_array($resultDiv)) 
  {
    $DivID = $row['id'];
    $DivName = $row['BussinessUnit'];
    $RecDiv .= '<option value="'.$DivID.'">'.$DivName.'</option>';
  }
 }
//GET REQ ID BY YOU /////
$OptReqCat;
$resultChartClass = mysql_query("SELECT * FROM reqcategory");
$NoRowChartClass = mysql_num_rows($resultChartClass);
if ($NoRowChartClass > 0) {
  while ($row = mysql_fetch_array($resultChartClass)) {
    $cid = $row['id'];
    $class_name = $row['CategoryName'];
    $OptReqCat .= '<option value="'.$cid.'">'.$class_name.'</option>';
    }
  }

//////////////////////////////////

$resultLI = mysql_query("SELECT * FROM hir 
 LEFT JOIN divisions ON hir.PartyInv = divisions.divid
 LEFT JOIN wh_stations ON hir.rptLocation = wh_stations.cid
 LEFT JOIN users ON hir.raisedby = users.uid WHERE hir.raisedby = '$ACTNOWID' AND hir.isActive=1
 "); //WHERE isActive=1 ORDER BY cid

 $NoRowLI = mysql_num_rows($resultLI);
//fetch tha data from the database
   if ($NoRowLI > 0) 
   {
   $SN = 1;
  while ($row = mysql_fetch_array($resultLI)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     
    $hirid = $row['hirid'];
    $LocNme = $row['station_name'];
    $Description = $row['Description'];
    $Comment = $row['Comment'];
    $RAMRating = $row['RAMRating'];
    $HType = $row['HType'];
    $rptDate = $row['rptDate'];
    $VendSource = $row['SupNme'];
    $RaisedBy = $row['Firstname'] . " " . $row['Surname'];//$row['RaisedBy'];
    $TotalSum = number_format($row['TotalSum']);
    $FileLink = $row['FileLink'];
   

    if($FileLink != ""){
    $FileLinkn = '<a target="_blank" title="Download contract document" href="'.$FileLink.'"><i class="fa fa-link"></i></a>';
    }
    else
    {
      $FileLinkn = '';
    }


    $DelCon = '<a title="Delete HIR" href="deleteHIR?cnid='.$hirid.'"><i class="fa fa-trash text-red"></i></a>';

      $Record .='
           <tr>
            <td>'.$SN.'</td>
            <td>'.$rptDate.'</td>
            <td>'.$LocNme.'</td>
            <td>'.$Description.'</td>
            <td>'.$RAMRating.'</td>
            <td>'.$HType.'</td>
            <td>'.$RaisedBy.'</td>
            <td>'.$Comment.'</td>
            <td>'.$DelCon.'</td>'
            ;
           
           $SN = $SN + 1;
            
     }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | New HIR Request </title>
	<link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
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
              <div class="box collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">Hazard ID Report Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#FFE6E6; border-radius: 15px; padding-top:22px; border: 2px solid #888;">
                    
                     <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="regHIR" method="post">

          <div class="form-group has-feedback col-md-6" >
                <label>Choose Location:</label>
                <select class="form-control" id="rptLocation" name="rptLocation" required>
                <option value=""> Choose Location</option>
                <?php echo $OptLocation; ?>
                </select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-6">
                    <label>Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" name="rptDate" required readonly />
                    </div><!-- /.input group -->
          </div>

        

     <div class="form-group has-feedback col-md-12">
      <label>Description of observation</label>
       <textarea rows="4" cols="50" placeholder=" Enter Description here..." id="Desc" name="Desc" style="width:100%; display: inline-block;" required ></textarea>
     </div>

     <div class="form-group has-feedback col-md-12">
      <label>Immediate Action Taken</label>
       <textarea rows="4" cols="50" placeholder=" Enter Immediate Action here..." id="ImAct" name="ImAct" style="width:100%; display: inline-block;" required ></textarea>
     </div>

     <div class="form-group has-feedback col-md-12">
      <label>Futher Action to Prevent Occurance</label>
       <textarea rows="4" cols="50" placeholder=" Enter Futher Actions here..." id="FtAct" name="FtAct" style="width:100%; display: inline-block;"  ></textarea>
     </div>
   

    <div class="form-group has-feedback col-md-6">
            <label>Responsible Action Division:</label>
            <select class="form-control" id="conDiv" name="conDiv" required >
            <option value=""> Choose Division</option>
            <?php echo $RecDiv; ?>
            </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>


    <div class="form-group has-feedback col-md-6">
                 
                    <label>Target Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" name="conEDate" />
                    </div><!-- /.input group -->
          </div>

          
      
  </div><!-- /.col -->
                    
                    <div class="col-md-4" style="border: 2px solid #888; border-radius: 11px">
                      <p class="text-center">
                        <em style="color:red">Tick as appropriate: see details on handover </em>
                        
                      </p>
          <div class="form-group has-feedback" style="border: 2px solid #888; border-radius: 11px;padding:5px;">
             <p class="text-center">
                        <strong>Harzard Type:</strong>
                      </p>
            <label><input type="checkbox" name="htype[]" value="UA" /> UA </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="UC" /> UC </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="House keeping" /> House keeping </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="PPE" /> PPE </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Environmental" /> Environmental </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Material Handling" /> Material Handling </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Tools and Equipment" /> Tools and Equipment </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Procedures" /> Procedures </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Attitude" /> Attitude </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Height Related" /> Height Related </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Structural integrity" /> Structural integrity  </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Security" /> Security </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Health" /> Health </label> &nbsp; &nbsp;
            <label><input type="checkbox" name="htype[]" value="Signs" /> Signs </label> &nbsp; &nbsp;
          </div>

    
          <br/>
             
          <div class="form-group has-feedback" style="border: 2px solid #888; border-radius: 11px; padding:5px;">
            <p class="text-center">
                        <strong>RAM Rating:</strong>
                      </p>
             <label><input type="radio" name="RAMRating" value="High" /> High </label> &nbsp; &nbsp;
            <label><input type="radio" name="RAMRating" value="Medium" /> Medium </label> &nbsp; &nbsp;
            <label><input type="radio" name="RAMRating" value="Low" /> Low </label> &nbsp; &nbsp;
          
          </div>
<br/>
     
    

          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
            </div><!-- /.col -->
          </div>
          <br/><br/>
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
                  <h3 class="box-title">HIR Request by you on ERP</h3>
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
                        <th>S/N</th>
                        <th>Report Date</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>RAM Rating</th>
                        <th>Hazard Type</th>
                        <th>Raised By</th>
                        <th>Comment</th>
                        <th>-</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                          <th>S/N</th>
                          <th>Report Date</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>RAM Rating</th>
                        <th>Harzard Type</th>
                        <th>Raised By</th>
                        <th>Comment</th>
                        <th>-</th>
                       
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
      <div class="row">

              <div class="">
                
                
                <!-- Modal form-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog " style="width:70%">
                    <div class="modal-content">
                      <div class="modal-header">
                      
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
	   
        $("#userTab").dataTable();
      
      });
    </script>
     <script type="text/javascript">
      function deleteit(elem)
      {
        
        var rid = $(elem).attr('rid');
        var dataString = { rid: rid };
         $.ajax({
              type: "POST",
              url: "deleteICTR",
              data: dataString,
              cache: false,
              success: function(html)
              {
                    $("#rid-"+rid).hide();
              }
              });
      }

      function edit(elem)
      {
        var rid = $(elem).attr('rid');
        var dataString = { rid: rid };
         $.ajax({
              type: "POST",
              url: "getICTR",
              data: dataString,
              cache: false,
              success: function(html)
              {
                  setEDIT();
                    var obj = JSON.parse(html);
                    $('#EditDes').html(obj['ItemDes']); //
                    $('#EditCat').val(obj['Purpose']); //
                    $('#LitID').val(rid); //

              }
              });
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

      var OptReqCat = '<?php echo $OptReqCat; ?>';
      function setEDIT()
      {
       
                  var size='standart';
                  var content = '<form role="form" action="updateITR" method="POST" ><div class="form-group">' +
                   '<input type="hidden" value="" id="LitID" name="LitID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label><textarea class="form-control" id="EditDes" name="EditDes" placeholder="Description"></textarea></div>' +

                   '<div class="form-group" style="width:100%; display: inline-block;"><label>Category: </label><select class="form-control" id="EditCat" name="EditCat" >'+OptReqCat+'</select></div>' +
                   
                  
                    '<button type="submit" class="btn btn-primary">Update</button></form>';
                  var title = 'Edit Request';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                  

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
                  //$('#AddDueDate').datepicker();
          //return false;
        //alert(LinIT);
              
      }
    </script>
	
  </body>
</html>