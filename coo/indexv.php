<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
if ($_SESSION['Dept'] == "") 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

//Get Staff
$resultStaff = mysql_query("SELECT uid FROM users");
$NoRowStaff = mysql_num_rows($resultStaff);

$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

$BusinessYr = $_SESSION['BusinessYear'];


$RFQJan = 0.0; $RFQFeb  = 0.0; $RFQMar = 0.0; $RFQApr = 0.0; $RFQMay = 0.0; 
$RFQJun = 0.0; $RFQJul = 0.0; $RFQAug = 0.0; $RFQSep = 0.0; $RFQOct = 0.0; $RFQNov = 0.0; $RFQDec = 0.0;

$POJan = 0.0; $POFeb  = 0.0; $POMar = 0.0; $POApr = 0.0; $POMay = 0.0; 
$POJun = 0.0; $POJul = 0.0; $POAug = 0.0; $POSep = 0.0; $POOct = 0.0; $PONov = 0.0; $PODec = 0.0;

//We need to pull RFQ from DB now
$resultRFQ = mysql_query("SELECT * FROM rfq WHERE LEFT(DateCreated,4) = '$BusinessYr'");
$NoRowRFQ = mysql_num_rows($resultRFQ);

$GTLINoRowRFQ = 0.0; $GTLINoRowRFQQd = 0.0; $GTLINoRowRFQTQ = 0.0; $GTAmtRFQQd = 0.0;

//Let's Get total LineITems
  $TLineItemRFQ = mysql_query("SELECT * FROM polineitems WHERE LEFT(CreatedOn,4) = '$BusinessYr'");
  $TLINoRowRFQ = mysql_num_rows($TLineItemRFQ);
  $GTLINoRowRFQ = number_format($TLINoRowRFQ);

  //Let's Get Total LineItems Qouted
  $TLineItemRFQQd = mysql_query("SELECT * FROM polineitems WHERE LEFT(CreatedOn,4) = '$BusinessYr' AND Status='QUOTED'");
  $TLINoRowRFQQd = mysql_num_rows($TLineItemRFQQd);
  $GTLINoRowRFQQd = number_format($TLINoRowRFQQd);

  //Let's Get Total on TQ Qouted
  $TLineItemRFQTq = mysql_query("SELECT * FROM polineitems WHERE LEFT(CreatedOn,4) = '$BusinessYr' AND ProjectControl='1'");
  $TLINoRowRFQTq = mysql_num_rows($TLineItemRFQTq);
  $GTLINoRowRFQTQ = number_format($TLINoRowRFQTq);

/*while ($row = mysql_fetch_array($resultRFQ)) {
  $RFQ = $row['RFQNum'];
  

  //Let's Get Total Amount Quoted (LineItems)
  
  $TLITAmtRFQQd = mysql_query("SELECT DPPPrice, Currency FROM polineitems WHERE RFQCode ='$RFQ' AND Status='QUOTED'");
  while ($row = mysql_fetch_array($TLITAmtRFQQd, MYSQLI_ASSOC)) {
    $LIAmt = $row['DPPPrice'];
    $LICurr = $row['Currency'];
    //Let's convert all currencies to USD
        if($LICurr != "USD")
        {
        //We now need to Get the Conversion rate
        $getConvert = mysql_fetch_assoc(mysql_query($dbhandle, "SELECT ExRateToUSD FROM currencies WHERE Abbreviation = '".$LICurr."'"));
        $CurrConvRate = $getConvert['ExRateToUSD'];

        $LIAmt = $LIAmt * $CurrConvRate;
        }
        $GTAmtRFQQd = $GTAmtRFQQd + number_format($LIAmt, 2);
  }
  
  
   
} */

//We need to Get Sales Order
$resultSO = mysql_query("SELECT * FROM so WHERE RIGHT(SOdate,4) = '$BusinessYr'");
$NoRowSO = mysql_num_rows($resultSO);
$TotalRevenue = 0.0;
while ($row = mysql_fetch_array($resultSO)) {

        
        $ItemsDetails = $row ['ItemsDetails'];
        $ItemsN = $row ['ItemsN'];
        $ItemRaw = explode("<br>",$ItemsDetails);     
      for($i=1; $i < $ItemsN + 1; $i++)
      {
        $POItem = explode("@&@",$ItemRaw[$i]);
      //$PODetails .= "----------------------------------<br>";
      // $PODetails .= "Description :". $POItem[0]. "<br>";
      //$PODetails .= "LineItemID :". $POItem[1]. "<br>";
        $LineITemID =  $POItem[1];
        //Here we need to get the currency
        $getCurrn = mysqli_fetch_assoc(mysqli_query($dbhandle, "SELECT Currency FROM polineitems WHERE LitID = '".$LineITemID."'"));
        $CurrencyDetails = $getCurrn['Currency'];
        if($CurrencyDetails != "USD")
        {
        //We now need to Get the Conversion rate
        $getConvert = mysqli_fetch_assoc(mysqli_query($dbhandle, "SELECT ExRateToUSD FROM currencies WHERE Abbreviation = '".$CurrencyDetails."'"));
        $CurrConvRate = $getConvert['ExRateToUSD'];
         if($CurrConvRate == 0 ) { $CurrConvRate = 1; }
        $convTotal = $row['Total'] * $CurrConvRate;
      //$PODetails .= "Ext Price :". $POItem[2]. "<br>";
        }
        else {

          $convTotal = $row['Total'];
        }
      } 


      $convTotal = $row['SubTotal'];

        //Get Month
        $month = date("m",strtotime($row['SOdate']));
        //echo $row['SOdate'];
        if($month == '01'){ $RFQJan = $RFQJan + $convTotal; }
        if($month == '02'){ $RFQFeb = $RFQFeb + $convTotal; }
        if($month == '03'){ $RFQMar = $RFQMar + $convTotal; }
        if($month == '04'){ $RFQApr = $RFQApr + $convTotal; }
        if($month == '05'){ $RFQMay = $RFQMay + $convTotal; }
        if($month == '06'){ $RFQJun = $RFQJun + $convTotal; }
        if($month == '07'){ $RFQJul = $RFQJul + $convTotal; }
        if($month == '08'){ $RFQAug = $RFQAug + $convTotal; }
        if($month == '09'){ $RFQSep = $RFQSep + $convTotal; }
        if($month == '10'){ $RFQOct = $RFQOct + $convTotal; }
        if($month == '11'){ $RFQNov = $RFQNov + $convTotal; }
        if($month == '12'){ $RFQDec = $RFQDec + $convTotal; }

        $TotalRevenue = $TotalRevenue + $convTotal;
      
    } 

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
        if($CurrConvRate == 0 ) { $CurrConvRate = 1; }
        $convTotal = $row['Total'] * $CurrConvRate;
      //$PODetails .= "Ext Price :". $POItem[2]. "<br>";
        }
        else {

          $convTotal = $row['Total'];
        }
      } 
      
        
        //Get Month
     // $month = date("m",strtotime($row['POdate']));
      $month = substr($row['POdate'],0,2);
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


//SELECT `Supplier`,COUNT(*), SUM(Total) As Total FROM po GROUP BY `Supplier`
  //<?php $salesspread = "['Chevron Nigeria Limited', 45.0], ['ZOBEC NIGERIA LIMITED', 26.8], ['DeltaAfrik Engineering Ltd', 8.5], ['Nigeria NLNG Limited', 6.2], ['DAEWOO E&C', 0.7]"; 
//We need to get SalesSpread now
$salesspread = "";
  // $salesspread = "['Chevron Nigeria Limited', 45.0, 'CN'], ['ZOBEC NIGERIA LIMITED', 26.8], ['DeltaAfrik Engineering Ltd', 8.5], ['Nigeria NLNG Limited', 6.2], ['DAEWOO E&C', 0.7]"; 

$resultSS = mysql_query("SELECT so.Customer,COUNT(*), SUM(so.Total) As Total, so.SONum, purchaselineitems.currency, customers.cussnme AS ccusnme, 
customers.CustormerNme AS ccusNme FROM so LEFT JOIN purchaselineitems ON so.SONum = purchaselineitems.SOCode
 LEFT JOIN customers ON so.cusid = customers.cusid  WHERE RIGHT(so.SOdate,4) = '$BusinessYr' GROUP BY so.Customer ");
 $NoRowSSS = mysql_num_rows($resultSS);

 while ($row = mysql_fetch_array($resultSS)) {
        //Get Month
      //$month = date("m",strtotime($row['SOdate']));
      $Customer = $row['ccusNme'];
      $Cusnme = $row['ccusnme'];
      $Currency = $row['Currency'];
      //Let's compute Currencies now
      //if($row['Currency'] == )
      $Totalss = $row['Total'];
        //$TotalRevenue = $TotalRevenue + $row['Total'];
     // $salesspread .= "['".$Customer ."', ".$Totalss."],";
      $salesspread .= "{'name':'". $Cusnme ."', 'y':".$Totalss.", 'y_label': '".$Customer."'},";
      //'name': 'Real Estate', 'y': 12.55, 'y_label': 12.55
      //, ['ZOBEC NIGERIA LIMITED', 26.8], ['DeltaAfrik Engineering Ltd', 8.5], ['Nigeria NLNG Limited', 6.2], ['DAEWOO E&C', 0.7]";
     
    }
  


?>
<!DOCTYPE html>
<html>
<!-- HEAD -->
<?php include ('../header.php'); ?>
<!-- HEAD -->
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Top Menu -->
      <?php include ('../topmenu.php'); ?>
      <!-- Top Menu -->
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
             <?php echo '<img src="data:image/jpeg;base64,'. base64_encode($prasa). '" class="img-circle" alt="User Image">'; ?>
            </div>
            <div class="pull-left info">
              <p> <?php echo $_SESSION['SurName']. " ". $_SESSION['Firstname']; ?> </p>

                    
					 
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <?php include ('../leftmenuCEO.php');  ?>
         </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Executive Dashboard
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Executive Dashboard</li>
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
                  <span class="info-box-text"> Total RFQ</span>
                  <span class="info-box-number"><?php echo $NoRowRFQ; ?></span>
                 
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-filter"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"> Total Line Item</span>
                  <span class="info-box-number"><?php echo $GTLINoRowRFQ; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->

            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-filter"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"> Total (LI) Quoted</span>
                  <span class="info-box-number"><?php echo $GTLINoRowRFQQd; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-filter"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text"> Total (LI) on TQ</span>
                  <span class="info-box-number"><?php echo $GTLINoRowRFQTQ; ?> <small style="color:#009900">( $<?php echo number_format($GTAmtRFQQd, 2); ?> )</small></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <!-- <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Unattended RFQ</span>
                  <span class="info-box-number">41,410</span>
                </div><!-- /.info-box-content 
              </div><!-- /.info-box 
            </div> /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">OUT-Sales Order</span>
                  <span class="info-box-number"><?php echo $NoRowSO; ?> <small style="color:#009900">( $<?php echo number_format($TotalRevenue, 2); ?> )</small></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="ion ion-ios-cart-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">OUT-Purchase Order</span>
                  <span class="info-box-number"><?php echo $NoRowPO; ?> <small style="color:#009900">( $<?php echo number_format($TotalCost); ?> )</small></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->

            <div class="col-md-3 col-sm-6 col-xs-12">
      
       <div class="info-box" onclick="$('#regid').submit();" >
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                <div class="info-box-content">
                   <span class="info-box-text">staff on ERP</span>
                  <span class="info-box-number"><?php echo $NoRowStaff; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
      
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

          
             <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Sales Recap [Monthly]</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <!--<div class="btn-group">
                      <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                      </ul>
                    </div>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                     <p class="text-center">
                        <strong>Sales: 1 Jan, <?php echo $_SESSION['BusinessYear']; ?> - <?php echo date("F j, Y"); ?></strong>
                      </p>
                      <script type="text/javascript">
                $(function () {
                  var RFQJan = <?php echo $RFQJan; ?>;
                  var RFQFeb = <?php echo $RFQFeb; ?>;
                  var RFQMar = <?php echo $RFQMar; ?>;
                  var RFQApr = <?php echo $RFQApr; ?>;
                  var RFQMay = <?php echo $RFQMay; ?>;
                  var RFQJun = <?php echo $RFQJun; ?>;
                  var RFQJul = <?php echo $RFQJul; ?>;
                  var RFQAug = <?php echo $RFQAug; ?>;
                  var RFQSep = <?php echo $RFQSep; ?>;
                  var RFQOct = <?php echo $RFQOct; ?>;
                  var RFQNov = <?php echo $RFQNov; ?>;
                  var RFQDec = <?php echo $RFQDec; ?>;

                  var POJan = <?php echo $POJan; ?>;
                  var POFeb = <?php echo $POFeb; ?>;
                  var POMar = <?php echo $POMar; ?>;
                  var POApr = <?php echo $POApr; ?>;
                  var POMay = <?php echo $POMay; ?>;
                  var POJun = <?php echo $POJun; ?>;
                  var POJul = <?php echo $POJul; ?>;
                  var POAug = <?php echo $POAug; ?>;
                  var POSep = <?php echo $POSep; ?>;
                  var POOct = <?php echo $POOct; ?>;
                  var PONov = <?php echo $PONov; ?>;
                  var PODec = <?php echo $PODec; ?>;




                    Highcharts.chart('elchcombo', {
                      colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
                       
                        chart: {
                            zoomType: 'xy',
                            /*options3d: {
                                      enabled: true,
                                      alpha: 0,
                                      beta: 1,
                                      depth: 60,
                                      viewDistance: 12
                            }
                            */

                            
                        },
                        title: {
                            text: ''
                        },
                        subtitle: {
                            text: ''
                        },
                        credits: {
                                      enabled: false
                        },
                        xAxis: [{
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            crosshair: true
                        }],
                        yAxis: [{ // Primary yAxis
                            labels: {
                                format: '$ {value}',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            },
                            title: {
                                text: 'Customer\'s Sales Order',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            }
                        }, { // Secondary yAxis
                            title: {
                                text: 'PO to OEM',
                                style: {
                                    color: Highcharts.getOptions().colors[2]
                                }
                            },
                            labels: {
                                format: '$ {value}',
                                style: {
                                    color: Highcharts.getOptions().colors[0]
                                }
                            },
                            opposite: true
                        }],

                          plotOptions: {
                            
                            series: {

                                allowPointSelect: true,
                                cursor: 'pointer',
                                point: {
                                    events: {
                                        click: function () {
                                            location.href = 'sperformance?mth=' +
                                                this.options.key;
                                                //this.point.name;
                                                //this.series.categories;
                                        }
                                    }
                                }
                            }
                        },
                        tooltip: {
                            shared: true
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'left',
                            x: 120,
                            verticalAlign: 'top',
                            y: 100,
                            floating: true,
                            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                        },


                        series: [{
                            name: 'Sales Order',
                            type: 'column',

                            yAxis: 1,
                            data: [ {y:RFQJan, key:'01'}, {y:RFQFeb, key:'02'}, {y:RFQMar, key:'03'}, {y:RFQApr, key:'04'}, 
                              {y:RFQMay, key:'05'}, {y:RFQJun, key:'06'}, {y:RFQJul, key:'07'}, {y:RFQAug, key:'08'}, 
                              {y:RFQSep, key:'09'}, {y:RFQOct, key:'10'}, {y:RFQNov, key:'11'}, {y:RFQDec, key:'12'}],
                            
                            tooltip: {
                                valuePrefix: '$ '
                            }

                        }, {
                            name: 'Purchase Order',
                            type: 'spline',
                            data: [ {y:POJan, key:'01'}, {y:POFeb, key:'02'}, {y:POMar, key:'03'}, {y:POApr, key:'04'}, 
                              {y:POMay, key:'05'}, {y:POJun, key:'06'}, {y:POJul, key:'07'}, {y:POAug, key:'08'}, 
                              {y:POSep, key:'09'}, {y:POOct, key:'10'}, {y:PONov, key:'11'}, {y:PODec, key:'12'}],
                            tooltip: {
                                valuePrefix: '$ '
                            }
                        }]
                    });
                });
        </script>

                      <!--<div class="chart">-->
                        <!-- Sales Chart Canvas -->
                        <!--<canvas id="salesChart" height="180"></canvas>-->
                      <!--</div>--><!-- /.chart-responsive -->
                      <div id="elchcombo" style="width:100%">
                      </div>
                    </div><!-- /.col -->
 
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
                                <div class="box-footer">
                  <div class="row">
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                        <h5 class="description-header"> $<?php echo number_format($TotalRevenue); ?></h5>
                        <span class="description-text">TOTAL SO</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">$<?php echo number_format($TotalCost); ?></h5>
                        <span class="description-text">TOTAL PO</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> <?php echo number_format(($TotalCost/$TotalRevenue) * 100, 2); ?>%</span>
                        <h5 class="description-header">$<?php echo number_format($TotalRevenue - $TotalCost); ?></h5>
                        <span class="description-text">ESTIMATED PROFIT</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block">
                        <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                      </div><!-- /.description-block -->
                    </div>
                  </div><!-- /.row -->
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
         

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Sales Spread</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-center">
                        <strong>Sales: 1 Jan, <?php echo $_SESSION['BusinessYear']; ?> - <?php echo date("F j, Y"); ?></strong>
                      </p>
                    </div><!-- /.col -->
                    <div class="col-md-12">
                      <p class="text-center">
                        <strong>Sales Spread</strong>
                      </p>
                        <script type="text/javascript">
                $(function () {
                    Highcharts.chart('pie3d', {
                      colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
                        chart: {
                            type: 'pie',
                            options3d: {
                                    enabled: true,
                                    alpha: 45,
                                    beta: 0
                                }
                            },

                        title: {
                            text: ''
                        },
                        credits: {
                                      enabled: false
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                showInLegend: true,
                                depth: 35,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.name}'
                                }
                            }
                        },
                        legend: {
                            align: 'left',
                            layout: 'vertical',
                            verticalAlign: 'top',
                            x: 40,
                            y: 0,
                            labelFormatter: function() {
                                return this.name + ': ' + this.y_label;
                            },
                        },
                        series: [{
                            type: 'pie',
                            name: 'Sales Spread',
                            data: [

                                <?php echo $salesspread; ?>
                            ]
                        }]
                    });
                });
                  </script>

                    <div id="pie3d" style="width:95%"></div>
                    </div><!-- /.col -->
                   
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
                <div class="box-footer">
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        <div>
            <script src="mBOOT/highcharts.js"></script>
            <script src="mBOOT/highcharts-3d.js"></script>
            <script src="mBOOT/highcharts-more.js"></script>
            <script src="mBOOT/exporting.js"></script>
             
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- FOOTER -->
      <?php include ('footer.php'); ?>
      <!-- FOOTER -->
     
      <!-- Control Sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard2.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>
  </body>
</html>