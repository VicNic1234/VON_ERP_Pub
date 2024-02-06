<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
if ($_SESSION['rptQMI'] != '1' || $_SESSION['viewQMI'] != '1') {
$_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit;

}

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
$Firstname = $_SESSION['Firstname'];
$SurName = $_SESSION['SurName'];
$staffName = $Firstname ." ". $SurName;
$BusinessYr = $_SESSION['BusinessYear'];
/*
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
$QMIInt = "";
$resultQMIIn = mysql_query("SELECT * FROM qmi_internalsales Where isActive=1 Order By id DESC");
$resultQMIInNo = mysql_num_rows($resultQMIIn);
while ($row = mysql_fetch_array($resultQMIIn)) {
                           $id = $row['id'];
                           $ActionItem = $row['ActionItem'];
                           $ActionParty = $row['ActionParty'];
                           $ActionStatus = $row['ActionStatus'];
                           $ActionComment = $row['ActionComment'];
                           $Qtr = $row['Qtr'];
                         $QMIInt .=  '<tr><td>'.$id.'</td><td>'.$ActionItem.'</td><td>'.$ActionParty.'</td><td>'.$ActionStatus.'</td><td>'.$ActionComment.'</td><td>'.$Qtr.'</td></tr>';
                            }

 
//////////////////////////////////////////////////////////////////////////////
$QMILookAhead = "";
$resultLookAh = mysql_query("SELECT * FROM qmi_internalsales_lookahead Where isActive=1 Order By id DESC");
$resultLookAhNo = mysql_num_rows($resultLookAh);
while ($row = mysql_fetch_array($resultLookAh)) {
                           $id = $row['id'];
                           $Comment = $row['Comment'];
                           $Qtr = $row['Qtr'];
                         $QMILookAhead .=  '<tr><td>'.$id.'</td><td>'.$Comment.'</td><td>'.$Qtr.'</td></tr>';
                            }
*/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Report QMI Internal Sales </title>
	<link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	
    <!-- Font Awesome Icons -->
    <link href="../mBOOT/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../mBOOT/ionicons.min.css" rel="stylesheet" type="text/css" />
   <!--DataTable -->
    <link rel="stylesheet" href="../plugins/datatables/jquery.dataTables.min.css" type="text/css" />
     <link rel="stylesheet" href="../plugins/datatables/buttons.dataTables.min.css" type="text/css" />

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
    <style type="text/css">
    .highcharts-yaxis-grid .highcharts-grid-line {
  display: none;
}
  .ballboard { -webkit-border-radius: 99px 99px 26px 99px;-moz-border-radius: 99px 99px 26px 99px;border-radius: 99px 99px 26px 99px;border:3px solid #62BF95; font-size:12px; font-weight:700; color:#FFF; padding:10px;}
    .controls { overflow: hidden;
    position: fixed; /* Set the navbar to fixed position */
    top: 0; /* Position the navbar at the top of the page */
    width: 100%; z-index:1000; }
    </style>

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

          <div class="row controls">
            <div class="col-md-12">
              <div class="box box-info" style="background:#DDDDDD;">
                <div class="box-header with-border">
                            <!-- Logo -->
        <a class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="../mBOOT/plant.png" width="50" height="50" /></span>
          <!-- logo for regular state and mobile devices
          <span class="logo-lg"> <img src="../mBOOT/plant.png" style ="width:40px; height:40px;"/></span>-->
        </a>
                  <h3 class="box-title"> [Projects Controls] Quick Market Intelligence Report </h3>
                  
                  <div class="box-tools pull-right">
                   <a href="../CEOD"><i class="fa fa-home" style="font-size:50px; color:#FF6600;"></i></a>
                  </div>
				  <!--<a style="float:right" href="./"> X</a>-->


   
                </div><!-- /.box-header -->
                <div class="box-body">
                 <div class="row">
                  <div class="col-md-12" style="font-size:12px;">
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
      </select> 
    </div>
  <div class="form-group has-feedback col-md-2">
    <label>Quarter</label>
        <input type="text" class="form-control" id="sQt" name="sQt" readonly required >
    </div>
   <div class="form-group has-feedback col-md-2">
    <label>First Day of Report Week</label>
        <input type="text" class="form-control" id="sDy" name="sDy" readonly required >
    </div>
    
    <div class="form-group has-feedback col-md-5">
    <label>Days in Report Week</label>
        <input type="text" class="form-control" id="sDys" name="sDys" readonly required >
    </div>
     <!--<div class="form-group has-feedback col-md-1">
     <label>&nbsp;</label>
     <button type="button" onclick="searchReport();" class="btn btn-primary pull-right form-control"><i class="fa fa-search"></i></button>
    </div>-->
<script>
function getDateOfISOWeek(elem) {
    $('#sDy').val('');
    $('#sDys').val('');
    $('#sQt').val('');
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
     if($('#sWk').val() == "") { $('#sQt').val(''); $('#sDys').val(''); $('#sDy').val(''); }
    loadSummary();
    


}
</script>

      
   </form>

                  </div>
                 </div>
                 
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        
  <div id="PrintArea" class="row" style="margin-top: 170px">
       <div class="col-md-12">

          <!--- REPORT PROPER -->
         
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> QMI Report <b><?php echo $BusinessYr; ?></b> &nbsp; <i class="fa fa-bar-chart"></i> </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                <div class="row">
             <div class="col-md-12" style="font-size:6px">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:13px; border-width:2px; border-style:solid; border-color:#388B66">
                <div class="box-header">
                  <h3 class="box-title">Summary </h3> &nbsp;
                </div><!-- /.box-header -->
                  <div class="box-body">
                  <div class="col-md-12 table-responsive">
                  
                  <table id="" class="display table table-bordered table-striped"  cellspacing="0" width="100%">
                    <thead>
                      <tr style="background:linear-gradient(to right, #006666 0%, #FF6600 100%); color:#FFF; font-size:9px;">
                        <th>GROWTH ENIGNE </th>
                        <th>NO of POs</th>
                        <th>MARK UP</th>
                        <th>PO VALUE</th>
                     
                      </tr>
                    </thead>
                    <tbody id="growthE" style="font-size:11px">
                                          
                    </tbody>
                  </table>
                  </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">

                  </div><!-- ./box-footer -->
               
              </div><!-- /.box -->
            </div> <!-- left column -->
             <div class="col-md-12">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:13px; border-width:2px; border-style:solid; border-color:#388B66">
                <div class="box-header">
                  <h3 class="box-title">OEM </h3> &nbsp;<i class="fa fa-cubes"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                   
                  <div class="col-md-12 table-responsive" style="height:270px;">
                   <table id="" class="display table table-bordered table-striped"  cellspacing="0" width="100%">
                    <thead>
                      <tr style="background:linear-gradient(to right, #006666 0%, #FF6600 100%); color:#FFF; font-size:9px;">
                        <th>OEM </th>
                        <th>NO of POs</th>
                        <th>MARK UP</th>
                        <th>PO VALUE</th>

                     
                      </tr>
                    </thead>
                    <tbody id="growthOEM" style="font-size:11px">
                                          
                    </tbody>
                  </table>
                </div>
                    
                  </div><!-- /.box-body -->

                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
            
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:13px; border-width:2px; border-style:solid; border-color:#388B66">
                <div class="box-header">
                  <h3 class="box-title">Customer </h3> &nbsp;<i class="fa fa-cubes"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                   
                  <div class="col-md-12 table-responsive" style="height:270px;">
                   <table id="" class="display table table-bordered table-striped"  cellspacing="0" width="100%">
                    <thead>
                      <tr style="background:linear-gradient(to right, #006666 0%, #FF6600 100%); color:#FFF; font-size:9px;">
                        <th>CUSTOMER </th>
                        <th>NO of POs</th>
                        <th>MARK UP</th>
                        <th>PO VALUE</th>

                     
                      </tr>
                    </thead>
                    <tbody id="growthCUS" style="font-size:11px">
                                          
                    </tbody>
                  </table>
                </div>
                    
                  </div><!-- /.box-body -->

                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
          </div>
                </div><!-- ./box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
        
             <!--- CHART PROPER -->
        
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> QMI Report <b><?php echo $BusinessYr; ?></b> &nbsp; <i class="fa fa-bar-chart"></i> </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                <div class="row">
             <div class="col-md-12" style="font-size:6px">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:13px; border-width:2px; border-style:solid; border-color:#388B66" >
                <div class="box-header">
                  <h3 class="box-title">Summary </h3> &nbsp;
                </div><!-- /.box-header -->
                  <div class="box-body">
                  <div class="col-md-12">
                    <div class="ballboard col-md-4" style="background:linear-gradient(to right, #006666 0%, #009999 100%);"><i class="fa fa-edit"></i> POs No.  <span class="pull-right" id="PONOs">--</span></div>
                    <div class="ballboard col-md-4" style="background:linear-gradient(to right, #006633 0%, #003300 100%);"><i class="fa fa-edit"></i> PO Value <span class="pull-right" id="POVAL">--</span></div>
                    <div class="ballboard col-md-4" style="background:linear-gradient(to right, #CCCC00 0%, #CC9900 100%);"><i class="fa fa-usd"></i> Mark-Up <span class="pull-right" id="POMRK">--</span></div>
                  </div>
                 
                  </div><!-- /.box-body -->
                  <div class="box-footer">

                  </div><!-- ./box-footer -->
               
              </div><!-- /.box -->
            </div> <!-- left column -->
          </div>
            
            
           <div class="row">
             <div class="col-md-12" style="font-size:6px">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:13px; border-width:2px; border-style:solid; border-color:#388B66" >
                <div class="box-header">
                  <h3 class="box-title">PER GROWTH ENGINE </h3> &nbsp; <i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                  <div class="box-body">
                  <div class="col-md-12">
                    <div id="POBAR" style="min-width: 310px; height: 220px; margin: 0 auto"></div>
                  </div>
                 
                  </div><!-- /.box-body -->
                  <div class="box-footer">

                  </div><!-- ./box-footer -->
               
              </div><!-- /.box -->
            </div> <!-- left column -->
          </div>
           <div class="row">
             <div class="col-md-12" style="font-size:6px">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:13px; border-width:2px; border-style:solid; border-color:#388B66" >
                <div class="box-header">
                  <h3 class="box-title">PER OEM </h3> &nbsp; <i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                  <div class="box-body">
                  <div class="col-md-12">
                    <div id="OEMBAR" style="min-width: 310px; height: 220px; margin: 0 auto"></div>
                  </div>
                 
                  </div><!-- /.box-body -->
                  <div class="box-footer">

                  </div><!-- ./box-footer -->
               
              </div><!-- /.box -->
            </div> <!-- left column -->
          </div>
              <div class="row">
             <div class="col-md-12" style="font-size:6px">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:13px; border-width:2px; border-style:solid; border-color:#388B66" >
                <div class="box-header">
                  <h3 class="box-title">PER COMPANY </h3> &nbsp; <i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                  <div class="box-body">
                  <div class="col-md-12">
                    <div id="COMPBAR" style="min-width: 310px; height: 220px; margin: 0 auto"></div>
                  </div>
                 
                  </div><!-- /.box-body -->
                  <div class="box-footer">

                  </div><!-- ./box-footer -->
               
              </div><!-- /.box -->
            </div> <!-- left column -->
          </div>
          </div>
                </div><!-- ./box-body -->
              </div><!-- /.box -->

              <div class="col-md-12" style="font-size:6px; display:none;">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:13px; border-width:2px; border-style:solid; border-color:#388B66" >
                <div class="box-header">
                  <h3 class="box-title">Amount of RFQs Received (USD) -- Amount of POs Received (USD) </h3> &nbsp; <i class="fa fa-cubes"></i>
                </div><!-- /.box-header -->
                  <div class="box-body">
                  <div class="col-md-12">
                    <div id="POcontainer" style="min-width: 310px; height: 170px; margin: 0 auto"></div>
                  </div>
                 
                  </div><!-- /.box-body -->
                  <div class="box-footer">

                  </div><!-- ./box-footer -->
               
              </div><!-- /.box -->
            </div> <!-- left column -->
            
            </div><!-- /.col -->
         
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
  
	<!-- DATA TABES SCRIPT-->
    
   <!--  <script src="//code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script> 
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script> 
    <script src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js" type="text/javascript"></script> 
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script> 
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js" type="text/javascript"></script> 
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js" type="text/javascript"></script> 
    <script src="//cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js" type="text/javascript"></script> 
   <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>-->
   <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
   <script src="../plugins/datatables/dataTables.buttons.min.js" type="text/javascript"></script>
   <script src="../plugins/datatables/jszip.min.js" type="text/javascript"></script>
   <script src="../plugins/datatables/pdfmake.min.js" type="text/javascript"></script>
   <script src="../plugins/datatables/vfs_fonts.js" type="text/javascript"></script>
   <script src="../plugins/datatables/buttons.html5.min.js" type="text/javascript"></script>
   <script src="../mBOOT/highcharts.js"></script>
            <script src="../mBOOT/highcharts-3d.js"></script>
            <script src="../mBOOT/highcharts-more.js"></script>
            <script src="../mBOOT/exporting.js"></script>

          <script type="text/javascript">
          function loadChart (GWTHCHART, BUSUNIT, OEMCHART, OEMs, COMPCHART, COMPs) {
            Highcharts.chart('OEMBAR', {
            colors: ['#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            chart: {
                type: 'areaspline'
            },

            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: OEMs
            },
            yAxis: {
                title: {
                    text: 'USD'
                }
            },
            credits: {
                      enabled: false
                  },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                },
                series: {
                    fillOpacity: 3
                }
            },
            series: OEMCHART
        });

                
        Highcharts.chart('POBAR', {
            colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            chart: {
                type: 'areaspline'
            },

            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: BUSUNIT
            },
            yAxis: {
                title: {
                    text: 'USD'
                }
            },
            credits: {
                      enabled: false
                  },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                },
                series: {
                    fillOpacity: 3
                }
            },
            series: GWTHCHART
        }); 

         Highcharts.chart('COMPBAR', {
            colors: ['#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            chart: {
                type: 'column'
            },

            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: COMPs
            },
            yAxis: {
                title: {
                    text: 'USD'
                }
            },
            credits: {
                      enabled: false
                  },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                },
                series: {
                    fillOpacity: 3
                }
            },
            series: COMPCHART
        });

  }


          </script>

   
    <script type="text/javascript">
	   $(document).ready(function() {
      loadSummary();
    /*
    $('#actionTab').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            //'copyHtml5',
            'excelHtml5',
            //'csvHtml5',
            'pdfHtml5'
        ]
          } );
    $('#LookATab').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            //'copyHtml5',
            'excelHtml5',
            //'csvHtml5',
            'pdfHtml5'
        ],
        "bSort": true,
          } );
    */
      } );
    </script>

    <script type="text/javascript">
    //we need to Load the Summary Report Now
  
    function loadSummary() {
      var WkNo = $('#sWk').val(); 
      var sDys = $('#sDys').val();
      var ArrayDy = sDys.split(",");
      var FirstDay =  ArrayDy[0]; var LastDay = ArrayDy[ArrayDy.length - 1];

      var dVal = 'loading..'; var dVal1 = '...';
    
      $('#growthE').html(dVal);
      //Ajax to Get All Messages now
      //var dataString = 'WkNo='+ WkNo;
      var formData = { WkNo:WkNo, FirstDay:FirstDay, LastDay:LastDay };

      
      $.ajax({
            type: "POST",
            url: "../utility/getPROJCRPT",
            data: formData,
            cache: false,
            success: function(html)
            {
                 //alert(html)
                 //return false;
                  var obj = JSON.parse(html);
                 
                 
                  //loadChart(obj['chartDATA'],obj['chartPODATA'], obj['chartPOBAR'], obj['TRFQRData'], obj['TRFQQData'], obj['TRFQTQData'], obj['TRFQOPNData']);

                 //alert(obj['OEMCHART']);
                  $('#growthE').html(obj['GrowthEngine']);
                  $('#growthCUS').html(obj['PERCUS']);
                  $('#growthOEM').html(obj['PEROEM']); 
                  $('#PONOs').html(obj['NOPO']);
                  $('#POVAL').html(obj['NOVAL']); 
                  $('#POMRK').html(obj['NOMRK']); 
                  loadChart(obj['GWTHCHART'],obj['BUSUNIT'],obj['OEMCHART'],obj['OEMs'],obj['COMPCHART'],obj['COMPs']); 

            }
            
        });
      // body...
    }


     function loadSCM() {
      var WkNo = $('#sWk').val();
      var sQt = $('#sQt').val();  

      var dVal = 'loading..';
      $('#ActionTab').html(dVal);
      $('#LookAheadTab').html(dVal);
      //Ajax to Get All Messages now
      //var dataString = 'WkNo='+ WkNo;
      var formData = { WkNo:WkNo, sQt:sQt  };

      
      $.ajax({
            type: "POST",
            url: "../utility/getRPTSCM",
            data: formData,
            cache: false,
            success: function(html)
            {
                 //alert(html);
                 //return false;
                 var obj = JSON.parse(html);
                 //alert(obj['ActionTab'])
                 $('#ActionTab').html(obj['ActionTab']);
                 $('#LookAheadTab').html(obj['LookAheadTab']);
                 //return false;
                

            }
            
        });
      // body...
    }
    </script>
	
  </body>
</html>