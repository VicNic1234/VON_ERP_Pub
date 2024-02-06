<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');

$BusinessYr = $_SESSION['BusinessYear'];
//Let's Read all SO
$resultSO = mysql_query("SELECT * FROM so WHERE RIGHT(SODate,4) = '$BusinessYr'");
$NoRowSO = mysql_num_rows($resultSO);
//Compute with Convertion
$resultSUMSO = mysql_query("SELECT SUM(SubTotal) AS sum_v FROM so WHERE RIGHT(SODate,4) = '$BusinessYr'");
$rowSUMSO = mysql_fetch_assoc($resultSUMSO); 
$rowSUMSOR = "$". number_format($rowSUMSO['sum_v'],2);
//Let's Read all PO
$resultPO = mysql_query("SELECT * FROM po WHERE RIGHT(PODate,4) = '$BusinessYr'");
$NoRowPO = mysql_num_rows($resultPO);
//Compute without Convertion
//$resultSUMPO = mysql_query("SELECT SUM(Total) AS sum_v FROM po WHERE RIGHT(PODate,4) = '$BusinessYr'");
//$rowSUMPO = mysql_fetch_assoc($resultSUMPO); 
//$rowSUMPOR = "$". number_format($rowSUMPO['sum_v'],2);

//We need to Get Out Purchase Order
$resultPO = mysql_query("SELECT * FROM po WHERE RIGHT(POdate,4) = '$BusinessYr'");
$NoRowPO = mysql_num_rows($resultPO);
$TotalCost = 0.0;

while ($row = mysql_fetch_array($resultPO)) {

       
        $ItemsDetails = $row ['ItemsDetails'];
        $ItemsN = $row ['ItemsN'];
        $ItemRaw = explode("<br>",$ItemsDetails);     
      for($i=1; $i < $ItemsN + 1; $i++)
      {
        $POItem = explode("@&@",$ItemRaw[$i]);
      //$PODetails .= "----------------------------------<br>";
      //$PODetails .= "Description :". $POItem[0]. "<br>";
      //$PODetails .= "LineItemID :". $POItem[1]. "<br>";
        $LineITemID =  $POItem[1];
        //Here we need to get the currency
        $getCurrn = mysql_fetch_assoc(mysql_query("SELECT Currency FROM purchaselineitems WHERE LitID = '".$LineITemID."'"));
        $CurrencyDetails = $getCurrn['Currency'];
        if($CurrencyDetails != "USD")
        {
        //We now need to Get the Conversion rate
        $getConvert = mysql_fetch_assoc(mysql_query("SELECT ExRateToUSD FROM currencies WHERE Abbreviation = '".$CurrencyDetails."'"));
        $CurrConvRate = $getConvert['ExRateToUSD'];

        $convTotal = $row['Total'] * $CurrConvRate;
      //$PODetails .= "Ext Price :". $POItem[2]. "<br>";
        }
        else {

          $convTotal = $row['Total'];
        }
      } 
      
        
        //Get Month
      $month = date("m",strtotime($row['POdate']));
        //echo $row['SOdate'];
        if($month == '01'){ $POJan = $POJan + $convTotal; }
        if($month == '02'){ $POFeb = $POFeb + $convTotal; }
        if($month == '03'){ $POMar = $POMar + $convTotal; }
        if($month == '04'){ $POApr = $POApr + $convTotal; }
        if($month == '05'){ $POMay = $POMay + $convTotal; }
        if($month == '06'){ $POJun = $POJun + $convTotal; }
        if($month == '07'){ $POJul = $POJul + $convTotal; }
        if($month == '08'){ $POAug = $POAug + $convTotal; }
        if($month == '09'){ $POSep = $POSep + $convTotal; }
        if($month == '10'){ $POOct = $POOct + $convTotal; }
        if($month == '11'){ $PONov = $PONov + $convTotal; }
        if($month == '12'){ $PODec = $PODec + $convTotal; }

        $TotalCost = $TotalCost + $convTotal;
     
    }
$rowSUMPOR = "$ ".number_format($TotalCost,2);

//Unattended RFQ
$resultuSO = mysql_query("SELECT * FROM so WHERE Status='0'");
$NoRowuSO = mysql_num_rows($resultuSO);
//Get Customers
$resultcrfq = mysql_query("SELECT * FROM customers");
$NoRowcrfq = mysql_num_rows($resultcrfq);
//Get Currency No
$resultcurren = mysql_query("SELECT * FROM currencies");
$NoRowcurren = mysql_num_rows($resultcurren);
//Get Suppliers
$resultSup = mysql_query("SELECT * FROM suppliers");
$NoRowSup = mysql_num_rows($resultSup);


$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];


?>
<!DOCTYPE html>
<html>
  <?php include('../header2.php') ?>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
       <?php include('../topmenu2.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
       <?php include('leftmenu.php'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Project Controls Dashboard
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-filter"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Customer's PO</span>
                  <span class="info-box-number"><?php echo $NoRowSO; ?><small> for <?php echo $BusinessYr; ?></small><br/><b style="color:#009933; font-size:12px;"><?php echo $rowSUMSOR; ?></b></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"><?php echo $_SESSION['CompanyAbbr'] ;?>'s PO</span>
                  <span class="info-box-number"><?php echo $NoRowPO; ?><small> for <?php echo $BusinessYr; ?></small><br/><b style="color:#009933; font-size:12px;"><?php echo $rowSUMPOR; ?></b></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
             <a title="Add Supplier" href="../utility/aSup" target="_blank" >
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Suppliers</span>
                  <span class="info-box-number"><?php echo $NoRowSup; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
              </a>
            </div><!-- /.col -->
            
            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <a title="Add Currency" href="../utility/aCur" target="_blank">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Currency</span>
                  <span class="info-box-number"><?php echo $NoRowcurren; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
              </a>
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="Add New Customer" href="../utility/Cus" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Customers</span>
                  <span class="info-box-number"><?php echo $NoRowcrfq; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
      </a>
            </div><!-- /.col -->
             <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="Add Unit of Measure" href="../utility/aUOM" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-brown"><i class="fa fa-cog"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Add Unit Of Meas.</span>
                  <span class="info-box-number"><?php echo $NoRowUOM; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
      </a>
            </div><!-- /.col -->

             <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="PO Requistion" href="../utility/rpor" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-book"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">PO Requistion</span>
                  <span class="info-box-number"></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
      </a>
            </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="Print PO Requistion" href="../utility/ppor" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-print"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Print PO Requistion</span>
                  <span class="info-box-number"></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
      </a>
      </div><!-- /.col -->
       <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="My Leave" href="../users/myleave" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-brown"><i class="fa fa-plane"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Leave</span>
                  <span class="info-box-number"></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->

      </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="My Travel" href="../users/mytravel" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-brown"><i class="fa fa-bus"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Travel</span>
                  <span class="info-box-number"></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->

      </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="My Query" href="../users/myquery" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-brown"><i class="fa fa-question"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">My Query</span>
                  <span class="info-box-number"></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->

      </a>
      </div><!-- /.col -->
       <div class="col-md-3 col-sm-6 col-xs-12">
      <a title="E-memo" href="../users/memo" target="_blank">
       <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-comment"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">E-Memo</span>
                  <span class="info-box-number"></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->

      </a>
      </div><!-- /.col -->

          </div><!-- /.row -->
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

          

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

     <?php include('../footer.php') ?>

      <!-- Control Sidebar -->
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
    <!-- ChartJS 1.0.1 -->
    <script src="../plugins/chartjs/Chart.min.js" type="text/javascript"></script>
  <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard2.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js" type="text/javascript"></script>
  </body>
</html>