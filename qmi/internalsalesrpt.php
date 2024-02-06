<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
if ($_SESSION['rptQMI'] != '1') {
$_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit;

}

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
$Firstname = $_SESSION['Firstname'];
$SurName = $_SESSION['SurName'];
$staffName = $Firstname ." ". $SurName;
$BusinessYr = $_SESSION['BusinessYear'];
$resultRFQ1 = mysql_query("SELECT DISTINCT RequestID FROM poreq");
$NoRowRFQ1 = mysql_num_rows($resultRFQ1);

$resultCUS = mysql_query("SELECT * FROM customers Order By CustormerNme");
$NoRowCUS = mysql_num_rows($resultCUS);
while ($row = mysql_fetch_array($resultCUS)) {
                           $cuid = $row['cusid'];
                           $cusnme = $row['CustormerNme'];
                          $cusrec .=  '<option value="'.$cuid.'">'.$cusnme.'</option>';
                          
                            }
$resultPROD = mysql_query("SELECT * FROM product Order By productname");
$NoRowPROD = mysql_num_rows($resultPROD);
while ($row = mysql_fetch_array($resultPROD)) {
                           $pid = $row['pid'];
                           $pnme = $row['productname'];
                          $prodrec .=  '<option value="'.$pid.'">'.$pnme.'</option>';
                          
                            }

 

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Report QMI Internal Sales </title>
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

          <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-header with-border">
                            <!-- Logo -->
        <a class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="../mBOOT/plant.png" width="50" height="50" /></span>
          <!-- logo for regular state and mobile devices
          <span class="logo-lg"> <img src="../mBOOT/plant.png" style ="width:40px; height:40px;"/></span>-->
        </a>
                  <h3 class="box-title"> [Internal Sales] Quick Market Intelligence </h3>
                  
                  <div class="box-tools pull-right">
                  <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
				  <!--<a style="float:right" href="./"> X</a>-->


   
                </div><!-- /.box-header -->
                <div class="box-body">
                 <div class="row">
                  <div class="col-md-12">
                              <form>
   <div class="form-group has-feedback col-md-2">
    <label>Report Week</label>
        <select class="form-control" id="sWk" name="sWk" onChange="getDateOfISOWeek(this)" required >
      <option value=""> Choose Report Week</option>
      
      <?php 

      $x = 1; 
      while($x <= 52) 
      {
      echo '<option value="'.$x.'">'.$x.'</option>';
      $x++;
      } 

      ?>

      </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
    </div>
  <div class="form-group has-feedback col-md-2">
    <label>Quarter</label>
        <input type="text" class="form-control" id="sQt" name="sQt" readonly required >
    </div>
   <div class="form-group has-feedback col-md-2">
    <label>First Day of Report Week</label>
        <input type="text" class="form-control" id="sDy" name="sDy" readonly required >
    </div>
    
    <div class="form-group has-feedback col-md-6">
    <label>Days in Report Week</label>
        <input type="text" class="form-control" id="sDys" name="sDys" readonly required >
    </div>
<script>
function getDateOfISOWeek(elem) {
    var w = $(elem).val();
    var y = '<?php echo $BusinessYr ?>';
    var simple = new Date(y, 0, 1 + (w - 1) * 7);
    var dow = simple.getDay();
    var ISOweekStart = simple;
    if (dow <= 4)
        ISOweekStart.setDate(simple.getDate() - simple.getDay() + 1);
    else
        ISOweekStart.setDate(simple.getDate() + 8 - simple.getDay());
    //return ISOweekStart;
    //alert(ISOweekStart);
    
    var date = new Date(ISOweekStart);
    //var day2 = date.setDate(date.getDate() + 1);
    var Mnth = date.getMonth() + 1;
    var Qu = "Q" + Math.ceil(Mnth / 3);

    $('#sQt').val(Qu);
    var rptdate = (date.getDate() + '/' + Mnth + '/' +  date.getFullYear());

    $('#sDy').val(rptdate);

    var rptdates = rptdate;

    for (var i = 1; i < 7; i++) {
    var next = new Date(date);
    next.setDate(date.getDate() + i);
    //alert(next.toString());
    var rptdate1 = (next.getDate() + '/' + (next.getMonth() + 1) + '/' +  next.getFullYear());
    rptdates = rptdates + "," + rptdate1;
    }

    $('#sDys').val(rptdates);


}
</script>

      
   </form>

                  </div>
                 </div>
                 
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        
  <div id="PrintArea">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> SCM Business development <b><?php echo $BusinessYr; ?></b></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                <div class="row">
             <div class="col-md-9">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#99CCFF;">
                <div class="box-header">
                  <h3 class="box-title">Action Items </h3> &nbsp;<i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    
                    <div class="form-group col-md-3">
                      <label>Action Item</label>
                      <input type="text" class="form-control" name="actItem" id="actItem" placeholder="Action Item" required >
                    </div>
                    <div class="form-group col-md-3">
                      <label>Action Party</label>
                      <input type="text" class="form-control" name="actParty" id="actParty" placeholder="Action Party" required >
                    </div>
                    <div class="form-group col-md-3">
                      <label>Status</label>
                      <input type="text" class="form-control" name="Status" id="Status" placeholder="Status" required >
                    </div>
                    <div class="form-group col-md-3">
                      <label>Comments/Impact Expected</label>
                      <input type="text" class="form-control" name="Comment" id="Comment" placeholder="Comments/Impact Expected" required >
                    </div>

                    <script>
                    function reportActionItem()
                    {
                      var ReportWeek = $('#sWk').val(); 
                      var ReportQtr = $('#sQt').val(); 
                      var FirstWeekDay = $('#sDy').val(); 
                      var DaysOfRtpWeek = $('#sDys').val(); 
                      if (ReportWeek < 1){ alert("Kindly select week"); return false;}
                     
                      var actItem = $('#actItem').val(); 
                      var actParty = $('#actParty').val(); 
                      var Status = $('#Status').val(); 
                      var Comment = $('#Comment').val(); 

                      if (actItem == "" || actParty == "" || Status == ""|| Comment == "") { alert("Kindly fill form completely"); return false;}
                      
                      var formData = { ReportWeek:ReportWeek, ReportQtr:ReportQtr, FirstWeekDay:FirstWeekDay, DaysOfRtpWeek:DaysOfRtpWeek, actItem:actItem, actParty:actParty, Status:Status, Comment:Comment };
                        $.ajax({
                            type:"POST",
                            url: "addinternalaction",
                            data: formData,
                            //contentType: true,
                            //dataType: "json",
                            //cache: false,
                            //processData:false,
                            success: function (data) {
                               $('#actItem').val(""); 
                               $('#Comment').val(""); 
                               $('#actParty').val(""); 
                               $('#Status').val(""); 
                               alert(data);
                               
                               
                               
                            },
                            fail: function (data) {
                               alert(data);
                               
                            }
                          
                        });
                        ev.preventDefault();
                    }
                    </script>

                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="button" onclick="reportActionItem();" class="btn btn-primary pull-right">Report</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
            <div class="col-md-3">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#99CCFF;">
                <div class="box-header">
                  <h3 class="box-title">Look Ahead </h3> &nbsp;<i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="form-group col-md-12">
                       <label>Comment</label>
                      <input type="text" class="form-control" name="LookAhead" id="LookAhead" placeholder="Comment">
                    </div>
                   
                  
                    
                   

                    
                  </div><!-- /.box-body -->

                   <script>
                    function reportLookHead()
                    {
                      var ReportWeek = $('#sWk').val(); 
                      var ReportQtr = $('#sQt').val(); 
                      var FirstWeekDay = $('#sDy').val(); 
                      var DaysOfRtpWeek = $('#sDys').val(); 
                      if (ReportWeek < 1){ alert("Kindly select week"); return false;}
                      
                      var LookAhead = $('#LookAhead').val(); 
                     

                      if (LookAhead == "") { alert("Kindly fill form completely"); return false;}
                      
                      var formData = { LookAhead:LookAhead, ReportWeek:ReportWeek, ReportQtr:ReportQtr, FirstWeekDay:FirstWeekDay, DaysOfRtpWeek:DaysOfRtpWeek };
                        $.ajax({
                            type:"POST",
                            url: "addinternallookahead",
                            data: formData,
                            //contentType: true,
                            //dataType: "json",
                            //cache: false,
                            //processData:false,
                            success: function (data) {
                            $('#LookAhead').val(""); 
                            
                            alert(data);
                               
                               
                               
                            },
                            fail: function (data) {
                               alert(data);
                               
                            }
                          
                        });
                        ev.preventDefault();
                    }
                    </script>


                  <div class="box-footer">
                    <button type="button" onclick="reportLookHead();" class="btn btn-primary pull-right">Report</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
    </div>
                </div><!-- ./box-body -->
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