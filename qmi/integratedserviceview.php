<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
if ( $_SESSION['viewQMI'] != '1') {
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


 
/////////////////////////////////////////////////////////////// Let's Report all the QMIs ////////
  //Product Sales
          //qmi_mkvps
    $ProdSales = mysql_query("SELECT * FROM qmi_mkvps WHERE arm='integratedservice' Order By Wk");
    $OppPpe = 0.0; $TEAOP = 0.0; $OBYTD = 0.0; $ONB = 0.0; 
$NoRowProdSales = mysql_num_rows($ProdSales);
if($NoRowProdSales > 0)
{
        while ($row = mysql_fetch_array($ProdSales)) {
                           $pid = $row['mpsid'];
                           $OppPipeLine = $row['OpportunityPipeline'];
                           $EAOP = $row['EAOP'];
                           $OrdersBookedYTD = $row['OrdersBookedYTD'];
                           $OrdersNotBooked = $row['OrdersNotBooked'];
                           $ProductID = $row['ProductID'];
                           $Wk = $row['Wk'];
                           $Qtr = $row['Qtr'];
                           $productname = $row['productname'];
                           //$prodrec .=  '<option value="'.$pid.'">'.$pnme.'</option>';
                           $OppPpe = $OppPpe + $OppPipeLine;
                           $TEAOP = $TEAOP + $EAOP;
                           $OBYTD = $OBYTD + $OrdersBookedYTD; $ONB = $ONB + $OrdersNotBooked; 
                           $ProdSalseRec .= '<tr><td>'.$OppPipeLine.'</td><td>'.$EAOP.'</td><td>'.$OrdersBookedYTD.'</td><td>'.$OrdersNotBooked.'</td><td>'.$Wk.'</td><td>'.$Qtr.'</td></tr>';
                            }    
}


                            //////////////////////////////////////////////////////////////////
//Key Opp
//qmi_kops
$Kops = mysql_query("SELECT * FROM qmi_kops WHERE arm='integratedservice' Order By Wk");
$NoRowKops = mysql_num_rows($Kops);
$SN = 0;
if($NoRowKops > 0)
{
        while ($row = mysql_fetch_array($Kops)) {

                           $kopsid = $row['kopsid'];
                           $CusProj = $row['CusProj'];
                           $ProdRef = $row['ProdRef'];
                           $ProdLine = $row['ProdLine'];
                           $ValueEst = $row['ValueEst'];
                           $KOStatus = $row['KOStatus'];
                           $KOclose = $row['KOclose'];
                           $ProductID = $row['ProductID'];
                           $productname = $row['productname'];
                           $Wk = $row['Wk'];
                           $Qtr = $row['Qtr'];
                           $SN = $SN + 1;
                           //$prodrec .=  '<option value="'.$pid.'">'.$pnme.'</option>';
                           $KopsRec .= '<tr><td>'.$SN.'</td><td>'.$CusProj.'</td><td>'.$ProdRef.'</td><td>'.$ProdLine.'</td><td>'.$ValueEst.'</td><td>'.$KOStatus.'</td><td>'.$KOclose.'</td><td>'.$Wk.'</td><td>'.$Qtr.'</td></tr>';
                            
                            }    
}

                            //////////////////////////////////////////////////////////////////
//Key Opp
//qmi_kops
$BDiS = mysql_query("SELECT * FROM qmi_breakdowninsales WHERE arm='integratedservice' Order By Wk");
$NoRowBDiS = mysql_num_rows($BDiS);
$SN = 0;
if($NoRowBDiS > 0)
{
        while ($row = mysql_fetch_array($BDiS)) {

                           $kopsid = $row['bdpsid'];
                           $SStageNOP = $row['SourcingStageNOP'];
                           $SStageEst = $row['SourcingStageEstValue'];
                           $BOfferNOP = $row['BudgetaryOfferNOP'];
                           $BOfferEst = $row['BudgetaryOfferEstValue'];
                           $FOfferNOP = $row['FirmOfferNOP'];
                           $FOfferEst = $row['FirmOfferEstValue'];
                           $APOsNOP = $row['AnticipatingPOsNOP'];
                           $APOsEst = $row['AnticipatingPOsEstValue'];
                           $RPOsNOP = $row['ReceivedPOsNOP'];
                           $RPOsEst = $row['ReceivedPOsEstValue'];
                           $ProductID = $row['ProductID'];
                           $productname = $row['productname'];
                           $Wk = $row['Wk'];
                           $Qtr = $row['Qtr'];
                           $SN = $SN + 1;
                           //$prodrec .=  '<option value="'.$pid.'">'.$pnme.'</option>';
                           //$BDiS .= '<tr><td>'.$SN.'</td><td>'.$CusProj.'</td><td>'.$ProdRef.'</td><td>'.$ProdLine.'</td><td>'.$ValueEst.'</td><td>'.$KOStatus.'</td><td>'.$KOclose.'</td><td>'.$Wk.'</td><td>'.$Qtr.'</td></tr>';
                            
                           $BDiS .= '<tr>
                          <td style="background:#06BCC6">No. of Opportunities </td>
                          <td> '.$SStageNOP.' </td><td> '.$BOfferNOP.' </td><td> '.$FOfferNOP.' </td><td> '.$APOsNOP.' </td><td> '.$RPOsNOP.' </td><td> '.$Wk.' </td><td> '.$Qtr.' </td>
                        </tr>
                        <tr>
                          <td style="background:#00CCCC">Estimated Value ($) </td>
                          <td> '.$SStageEst.' </td><td> '.$BOfferEst.' </td><td> '.$FOfferEst.' </td><td> '.$APOsEst.' </td><td> '.$RPOsEst.' </td><td> '.$Wk.' </td><td> '.$Qtr.' </td>
                         
                        </tr>';

                            
                            }    
}
////////////////////////////////////////////////////////////////////////////////////////////////
//qmi_riskinq1q4

$riskinq1q4 = mysql_query("SELECT * FROM qmi_riskinq1q4 
  LEFT JOIN customers ON qmi_riskinq1q4.Customer = customers.cusid
  LEFT JOIN product ON qmi_riskinq1q4.product = product.pid WHERE arm='integratedservice'  Order By Wk");
$NoRowriskinq1q4 = mysql_num_rows($riskinq1q4);
$SN = 0;
if($NoRowriskinq1q4 > 0)
{
        while ($row = mysql_fetch_array($riskinq1q4)) {

                           $rid = $row['rid'];
                           $Product = $row['Product'];
                           $Customer = $row['CustormerNme'];
                           $rValue = $row['rValue'];
                           $Status = $row['Status'];
                           $FOfferNOP = $row['FirmOfferNOP'];
                           $FOfferEst = $row['FirmOfferEstValue'];
                           $productname = $row['productname'];
                           $Wk = $row['Wk'];
                           $Qtr = $row['Qtr'];
                           $SN = $SN + 1;
                           //$prodrec .=  '<option value="'.$pid.'">'.$pnme.'</option>';
                           $riskinqRec .= '<tr><td>'.$SN.'</td><td>'.$Customer.'</td><td>'.$productname.'</td><td>'.$rValue.'</td><td>'.$Status.'</td><td>'.$Wk.'</td><td>'.$Qtr.'</td></tr>';
                            
                          

                            
                            }    
}
//////////////////////////////////////////////////////////////////////////////////////////////////
//qmi_gapclose

$gapclose = mysql_query("SELECT * FROM qmi_gapclose 
  LEFT JOIN customers ON qmi_gapclose.Customer = customers.cusid
  LEFT JOIN product ON qmi_gapclose.product = product.pid WHERE arm='integratedservice'  Order By Wk");
$NoRowgapclose = mysql_num_rows($gapclose);
$SN = 0;
if($NoRowgapclose > 0)
{
        while ($row = mysql_fetch_array($gapclose)) {

                           $rid = $row['rid'];
                           $Product = $row['Product'];
                           $Customer = $row['CustormerNme'];
                           $rValue = $row['rValue'];
                           $Status = $row['Status'];
                           $FOfferNOP = $row['FirmOfferNOP'];
                           $FOfferEst = $row['FirmOfferEstValue'];
                           $productname = $row['productname'];
                           $Wk = $row['Wk'];
                           $Qtr = $row['Qtr'];
                           $SN = $SN + 1;
                           //$prodrec .=  '<option value="'.$pid.'">'.$pnme.'</option>';
                           $gapcloseRec .= '<tr><td>'.$SN.'</td><td>'.$Customer.'</td><td>'.$productname.'</td><td>'.$rValue.'</td><td>'.$Status.'</td><td>'.$Wk.'</td><td>'.$Qtr.'</td></tr>';
                            
                          

                            
                            }    
}
//////////////////////////////////////////////////////////////////////////////////////////////////


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Accounts Weekly</title>
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
    <script type="text/javascript" src="../bootstrap/js/jquery-1.10.2.min.js"></script>

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
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Account Weekly Report</h3>
           
                  <div class="box-tools pull-right">
                  <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
          <!--<a style="float:right" href="./"> X</a>-->
          <form method="POST">
   <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
    <label>Week</label>
        <select class="form-control" id="sWk" name="sWk" onChange="getDateOfISOWeek(this)" required >
      <option value=""> Choose Week To Report For</option>
      
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
    <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
    <label>Product</label>
        <select class="form-control" id="sProduct" name="sProduct" >
          <option value="0">All</option>
          <?php echo $prodrec; ?>
        </select>
    </div>
  <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
    <label>Quarter</label>
        <input type="text" class="form-control" id="sQt" name="sQt" readonly required >
    </div>
   <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
    <label>First Day of Report Week</label>
        <input type="text" class="form-control" id="sDy" name="sDy" readonly required >
    </div>
    <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
    <label>&nbsp;</label>
        <button class="btn btn-info"><i class="fa fa-search"></i> Search</button>
    </div>
    <div class="form-group has-feedback" style="width:100%; display: inline-block; margin:12px; ">
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
   
                </div><!-- /.box-header -->
                <div class="box-body">
                 
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->


          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Product Sales </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                      <center><h3>Summary</h3><center>
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <h5 class="description-header"> $<?php echo number_format($OppPpe); ?></h5>
                        <span class="description-text">Opportunity Pipeline</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($TEAOP); ?></h5>
                        <span class="description-text">EAOP</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">$<?php echo number_format($OBYTD); ?></h5>
                        <span class="description-text">Orders Booked (YTD)</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block">
                        <h5 class="description-header">$<?php echo number_format($ONB); ?></h5>
                        <span class="description-text" style="color:red">Orders Not Booked</span>
                      </div><!-- /.description-block -->
                    </div>
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
                <div class="box-footer">

                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped">
                        <tr style="background:#FFB66C"><th><?php echo $BusinessYr; ?> Opportunity Pipeline ($)</th>
                          <th><?php echo $_SESSION['CompanyAbbr']; ?> EAOP ($)</th>
                          <th>Orders Booked (YTD) ($)</th>
                          <th>Orders Not Booked ($)</th>
                          <th>Week</th>
                          <th>Quarter</th>
                        </tr>
                        <?php echo $ProdSalseRec; ?>

                      </table>
                    </div><!-- /.col -->
 
                  </div><!-- /.row -->
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Key Oppourtunities for <?php echo $BusinessYr; ?> Estimate </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped">
                        <tr style="background:#FFB66C"><th>S/N</th>
                          <th>Customer/Project Name </th>
                          <th><?php echo $_SESSION['CompanyAbbr']; ?>/Product Ref Code</th>
                          <th>Product Line(s)</th>
                          <th>Value (Est.)</th>
                          <th>Status</th>
                          <th>To Close</th>
                          <th>Week</th>
                          <th>Quarter</th>
                        </tr>
                        <?php echo $KopsRec; ?>
                      </table>
                    </div><!-- /.col -->
 
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
                <div class="box-footer">

                
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Breakdown in Progressive Sales Week </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped">
                        <tr><th style="background:#FF8C1A">Sales Stage</th>
                          <th style="background:#FFB66C">Sourcing Stage </th>
                          <th style="background:#FFB66C">Budgetary Offer</th>
                          <th style="background:#FFB66C">Firm Offer</th>
                          <th style="background:#FFB66C">Anticipating POs</th>
                          <th style="background:#FFB66C">Received POs</th>
                          <th style="background:#FFB66C">Week</th>
                          <th style="background:#FFB66C">Quarter</th>
                          <!--<th style="background:#FFB66C">To Close</th>-->
                        </tr>
                        <?php echo $BDiS; ?>
                      </table>
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
                  <h3 class="box-title">Risk in Q1-Q4 Estimate </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped">
                        <tr style="background:#FFB66C"><th>S/N</th>
                          <th>Customer</th>
                          <th>Product Line(s)</th>
                          <th>Value ($)</th>
                          <th>Status</th>
                          <th>Week</th>
                          <th>Quarter</th>
                        </tr>
                        <?php echo $riskinqRec; ?>
                      </table>
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
                  <h3 class="box-title">Gap-closing Opportunities/Upsides (not in Q1 Estimate) </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped">
                        <tr style="background:#FFB66C"><th>S/N</th>
                          <th>Customer</th>
                          <th>Product Line(s)</th>
                          <th>Value ($)</th>
                          <th>Status</th>
                          <th>Week</th>
                          <th>Quarter</th>
                        </tr>
                        <?php echo $gapcloseRec; ?>
                      </table>
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
                  <h3 class="box-title">Synergy Opportunity </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped">
                        <tr style="background:#FFB66C"><th>S/N</th>
                          <th>Customer</th>
                          <th>Product Line(s)</th>
                          <th>Value ($)</th>
                          <th>Status</th>
                        </tr>
                      </table>
                    </div><!-- /.col -->
 
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
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