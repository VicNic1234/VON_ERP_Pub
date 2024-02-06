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
              <div class="box box-info">
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
                   <a href="../"><i class="fa fa-home" style="font-size:50px; color:#336633;"></i></a>
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
    loadSCM();


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
         
            <div class="col-md-8">
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
                  
                  <table id="actionTab" class="display table table-bordered table-striped"  cellspacing="0" width="100%">
                    <thead>
                      <tr style="background:linear-gradient(to right, #006666 0%, #009999 100%); color:#FFF; font-size:9px;">
                        <th>Total RFQ Received for YTD </th>
                        <th>Total RFQ Quoted</th>
                        <th>Total Amount Quoted ($)</th>
                        <th>RFQ on TQ</th>
                        <th>HIT RATIO</th>
                        <th>Open RFQ</th>
                        <th>POs RECEIVED</th>
                        <th>POs Value ($)</th>
                        <th>POs Delivered</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td id="TRFQR"> - </td>
                        <td id="TRFQQ"> - </td>
                        <td id="TRFQQA"> - </td>
                        <td id="TRFQTQ"> - </td>
                        <td id="HITRT"> - </td>
                        <td id="TRFQOPN"> - </td>
                        <td id="POSRV"> - </td>
                        <td id="POSVAL"> - </td>
                        <td id="POSDELI"> - </td>

                      </tr>
                    
                    </tbody>
                  </table>
                  </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">

                  </div><!-- ./box-footer -->
               
              </div><!-- /.box -->
            </div> <!-- left column -->
            
            
            <div class="col-md-12" style="font-size:6px">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:13px; border-width:2px; border-style:solid; border-color:#388B66">
                <div class="box-header">
                  <h3 class="box-title">Breakdown </h3> &nbsp;<i class="fa fa-cubes"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                   
                   <!-- <table id="actionTab" class="display table table-bordered table-striped"  cellspacing="0" width="100%">
                    <thead>
                      <tr style="background:linear-gradient(to right, #006666 0%, #009999 100%); color:#FFF; font-size:9px;">
                        <th>Customer </th>
                        <th>Total RFQ Received for YTD </th>
                        <th>Total RFQ Quoted</th>
                        <th>Total Amount Quoted ($)</th>
                        <th>RFQ on TQ</th>
                        <th>HIT RATIO</th>
                        <th>Open RFQ</th>
                        <th>POs RECEIVED</th>
                        <th>POs Value ($)</th>
                      </tr>
                    </thead>
                    <tbody id="tabTAB">
                      
                    </tbody>
                  </table> -->
                  <div class="col-md-12 table-responsive" style="height:370px;">
                  <table  class="display table table-bordered table-striped"  cellspacing="0" width="100%">
                    <thead>
                      <tr style="background:linear-gradient(to right, #006666 0%, #009999 100%); color:#FFF; font-size:11px;">
                        <th>Customer </th>
                        <th>Order No. </th>
                        <th>MOSDate</th>
                       
                        <th>Items</th>
                        <th>Amt ($)</th>
                       
                      </tr>
                    </thead>
                    <tbody id="ProjSumm">
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
        
            <div class="col-md-4">
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
                    <div class="ballboard col-md-4" style="background:linear-gradient(to right, #006666 0%, #009999 100%);"><i class="fa fa-filter"></i> RQF RECEIVED  <span class="pull-right" id="TRFQRn">--</span></div>
                    <div class="ballboard col-md-4" style="background:linear-gradient(to right, #006633 0%, #003300 100%);"><i class="fa fa-edit"></i> RQF QUOTED <span class="pull-right" id="TRFQQn">--</span></div>
                    <div class="ballboard col-md-4" style="background:linear-gradient(to right, #CCCC00 0%, #CC9900 100%);"><i class="fa fa-usd"></i> AMT QUOTED <span class="pull-right" id="TRFQQAn">--</span></div>
                    <div class="ballboard col-md-4" style="background:linear-gradient(to right, #006666 0%, #009999 100%);"><i class="fa fa-filter"></i> RQF ON TQ  <span class="pull-right" id="TRFQTQn">--</span></div>
                    <div class="ballboard col-md-4" style="background:linear-gradient(to right, #006633 0%, #003300 100%);"><i class="fa fa-calculator"></i> HIT RATION <span class="pull-right" id="HITRTn">--</span></div>
                    <div class="ballboard col-md-4" style="background:linear-gradient(to right, #CCCC00 0%, #CC9900 100%);"><i class="fa fa-filter"></i> OPEN QUOTED <span class="pull-right" id="TRFQOPNn">--</span></div>
                    <div class="ballboard col-md-4" style="background:linear-gradient(to right, #660066 0%, #003366 100%);"><i class="fa fa-filter"></i> POs RECEIVED  <span class="pull-right" id="POSRVn">--</span></div>
                    <div class="col-md-4"> &nbsp; </div>
                    <div class="ballboard col-md-4" style="background:linear-gradient(to right, #660066 0%, #003366 100%);"><i class="fa fa-usd"></i> POs AMT <span class="pull-right" id="POSVALn">--</span></div>
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
                  <h3 class="box-title">Hit Ratio </h3> &nbsp; <i class="fa fa-cubes"></i>
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
          </div>
                </div><!-- ./box-body -->
              </div><!-- /.box -->

              <div class="col-md-12" style="font-size:6px">
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
            <div class="col-md-12" style="font-size:6px">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:13px; border-width:2px; border-style:solid; border-color:#388B66" >
                <div class="box-header">
                  <h3 class="box-title">Breakdown </h3> &nbsp; <i class="fa fa-cubes"></i>
                </div><!-- /.box-header -->
                  <div class="box-body">
                  <div class="col-md-3">
                     <div id="cTRFQRData" style="min-width: 210px; height: 170px; margin: 0 auto"></div>
                  </div>
                  <div class="col-md-3">
                     <div id="cTRFQQData" style="min-width: 210px; height: 170px; margin: 0 auto"></div>
                  </div>
                  <div class="col-md-3">
                     <div id="cTRFQTQData" style="min-width: 210px; height: 170px; margin: 0 auto"></div>
                  </div>
                   <div class="col-md-3">
                     <div id="cTRFQOPNData" style="min-width: 210px; height: 170px; margin: 0 auto"></div>
                  </div>
                                  
                  </div><!-- /.box-body -->
                  <div class="box-footer">

                  </div><!-- ./box-footer -->
               
              </div><!-- /.box -->
            </div> <!-- left column -->
            <div class="col-md-12" style="font-size:6px">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:13px; border-width:2px; border-style:solid; border-color:#388B66" >
                <div class="box-header">
                  <h3 class="box-title">Breakdown </h3> &nbsp; <i class="fa fa-cubes"></i>
                </div><!-- /.box-header -->
                  <div class="box-body">
                  <div class="col-md-12">
                     <div id="container" style="min-width: 210px; height: 170px; margin: 0 auto"></div>
                  </div>
                 
                  </div><!-- /.box-body -->
                  <div class="box-footer">

                  </div><!-- ./box-footer -->
               
              </div><!-- /.box -->
            </div> <!-- left column -->


            </div><!-- /.col -->
         


             <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> SCM Business development Report <b><?php echo $BusinessYr; ?></b> &nbsp; <i class="fa fa-cogs"></i></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
             <div class="col-md-12">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:12px; border-width:2px; border-style:solid; border-color:#388B66">
                <div class="box-header">
                  <h3 class="box-title">Action Items </h3> &nbsp;
                </div><!-- /.box-header -->
                  <div class="box-body">
                  <div class="col-md-12 table-responsive">
                  
                  <table id="actionTab" class="display table table-bordered table-striped"  cellspacing="0" width="100%">
                    <thead>
                      <tr style="background:#80CAA9;">
                        <th>S/N</th>
                        <th>Action Item</th>
                        <th>Action Party</th>
                        <th>Action Status</th>
                        <th>Comment/Impact Expected</th>
                        <th>Quarter</th>
                      </tr>
                    </thead>
                    <tbody id="ActionTab">
                   
                    </tbody>
                  </table>
                  </div>
                  </div><!-- /.box-body -->
               
              </div><!-- /.box -->
            </div> <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box" style="background:#FFF; font-size:12px; border-width:2px; border-style:solid; border-color:#388B66">
                <div class="box-header">
                  <h3 class="box-title">Look Ahead </h3> &nbsp;
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                   
                    <div class="col-md-12 table-responsive">
                  
                  <table id="LookATab" class="table table-bordered table-striped">
                    <thead>
                      <tr style="background:#80CAA9;">
                        <th>S/N</th>
                        <th>Look Ahead</th>
                        <th>Quarter</th>
                      </tr>
                    </thead>
                    <tbody id="LookAheadTab">
                   
                    </tbody>
                  </table>
                  </div>
                    
                  </div><!-- /.box-body -->

                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
  
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
          function loadChart (data, POdata, POBAR, cTRFQRData, cTRFQQData, cTRFQTQData, cTRFQOPNData) {
           Highcharts.chart('container', {
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
                categories: ['Chevron Nigeria Limited', 'Exxon Mobil', 'NLNG', 'Total E&P Nigeria', 'Oando Energy Services', 'Others']
            },
            yAxis: {
                title: {
                    text: 'Unit'
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
                    fillOpacity: 0.1
                }
            },
            series: data
        });

        Highcharts.chart('POcontainer', {
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
                categories: ['Chevron Nigeria Limited', 'Exxon Mobil', 'NLNG', 'Total E&P Nigeria', 'Oando Energy Services', 'Others']
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
            series: POdata
        });

                Highcharts.chart('POBAR', {
            colors: ['#FF6600', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            chart: {
                type: 'areaspline',
                options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
                          }
            },

            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['Chevron Nigeria Limited', 'Exxon Mobil', 'NLNG', 'Total E&P Nigeria', 'Oando Energy Services', 'Others']
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
               
                series: {
                    fillOpacity: 3
                }
            },
            legend: {
                          enabled: false  
                        },

            series: POBAR
        });

           Highcharts.chart('cTRFQRData', {
            colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            chart: {
                type: 'column',
              
            },

            title: {
                text: ''
            },
            subtitle: {
                text: 'Total RFQ Received'
            },
            xAxis: {
                categories: ['Chevron Nigeria Limited', 'Exxon Mobil', 'NLNG', 'Total E&P Nigeria', 'Oando Energy Services', 'Others']
            },
            yAxis: {
                title: {
                    text: 'No.'
                }
            },
            credits: {
                      enabled: false
                  },
            plotOptions: {
               
                series: {
                    fillOpacity: 3
                }
            },
            legend: {
                          enabled: false  
                        },

            series: cTRFQRData
        });

        Highcharts.chart('cTRFQQData', {
            colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            chart: {
                type: 'column',
               
            },

            title: {
                text: ''
            },
            subtitle: {
                text: 'Total RFQ Quoted'
            },
            xAxis: {
                categories: ['Chevron Nigeria Limited', 'Exxon Mobil', 'NLNG', 'Total E&P Nigeria', 'Oando Energy Services', 'Others']
            },
            yAxis: {
                title: {
                    text: 'No.'
                }
            },
            credits: {
                      enabled: false
                  },
            plotOptions: {
               
                series: {
                    fillOpacity: 3
                }
            },
            legend: {
                          enabled: false  
                        },

            series: cTRFQQData
        });

        Highcharts.chart('cTRFQTQData', {
            colors: ['#FF6600', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            chart: {
                type: 'column',
               
            },

            title: {
                text: ''
            },
            subtitle: {
                text: 'Total RFQ On TQ'
            },
            xAxis: {
                categories: ['Chevron Nigeria Limited', 'Exxon Mobil', 'NLNG', 'Total E&P Nigeria', 'Oando Energy Services', 'Others']
            },
            yAxis: {
                title: {
                    text: 'No.'
                }
            },
            credits: {
                      enabled: false
                  },
            plotOptions: {
               
                series: {
                    fillOpacity: 3
                }
            },
            legend: {
                          enabled: false  
                        },

            series: cTRFQTQData
        });

        Highcharts.chart('cTRFQOPNData', {
            colors: ['#009900', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            chart: {
                type: 'column',
               
            },

            title: {
                text: ''
            },
            subtitle: {
                text: 'Total PO Received'
            },
            xAxis: {
                categories: ['Chevron Nigeria Limited', 'Exxon Mobil', 'NLNG', 'Total E&P Nigeria', 'Oando Energy Services', 'Others']
            },
            yAxis: {
                title: {
                    text: 'No.'
                }
            },
            credits: {
                      enabled: false
                  },
            plotOptions: {
               
                series: {
                    fillOpacity: 3
                }
            },
            legend: {
                          enabled: false  
                        },

            series: cTRFQOPNData
        });


  }


          </script>

   
    <script type="text/javascript">
	   $(document).ready(function() {
      loadSummary(); loadSCM();
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
      $('#TRFQR').html(dVal); $('#TRFQQ').html(dVal); $('#TRFQQA').html(dVal); $('#TRFQTQ').html(dVal); 
      $('#TRFQRn').html(dVal1); $('#TRFQQn').html(dVal1); $('#TRFQQAn').html(dVal1); $('#TRFQTQn').html(dVal1); 
      $('#HITRT').html(dVal); $('#TRFQOPN').html(dVal); $('#POSRV').html(dVal); $('#POSVAL').html(dVal);
      $('#HITRTn').html(dVal1); $('#TRFQOPNn').html(dVal1); $('#POSRVn').html(dVal1); $('#POSDELI').html(dVal); 
      $('#ProjSumm').html(dVal);
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
                 
                  $('#TRFQR').html(obj['TRFQR']); $('#TRFQRn').html(obj['TRFQR']);
                  $('#TRFQQ').html(obj['TRFQQ']); $('#TRFQQn').html(obj['TRFQQ']);
                  $('#TRFQQA').html(obj['TRFQQA']); $('#TRFQQAn').html(obj['TRFQQA']);
                  $('#TRFQTQ').html(obj['TRFQTQ']); $('#TRFQTQn').html(obj['TRFQTQ']); 
                  $('#HITRT').html(obj['TRFQHitR']); $('#HITRTn').html(obj['TRFQHitR']); 
                  $('#TRFQOPN').html(obj['TRFQOPN']); $('#TRFQOPNn').html(obj['TRFQOPN']); 
                  $('#POSRV').html(obj['POSRV']); $('#POSRVn').html(obj['POSRV']); 
                  $('#POSVAL').html(obj['POSVAL']); $('#POSVALn').html(obj['POSVAL']); 
                  $('#POSDELI').html(obj['AmtPOd']); 
                  //$('#tabTAB').html(obj['tabTAB']);
                  $('#ProjSumm').html(obj['ProjectSummary']);
                  loadChart(obj['chartDATA'],obj['chartPODATA'], obj['chartPOBAR'], obj['TRFQRData'], obj['TRFQQData'], obj['TRFQTQData'], obj['TRFQOPNData']);
                  //alert(obj['chartDATA']);

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