<?php
session_start();
//error_reporting(0);
error_reporting(E_ALL);
include ('../DBcon/db_config.php');
include('route.php');
$BusinessYr = "2019";//$_SESSION['BusinessYear'];
//Let's Read all rfq

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


$RFQJan = 0.0; $RFQFeb  = 0.0; $RFQMar = 0.0; $RFQApr = 0.0; $RFQMay = 0.0; 
$RFQJun = 0.0; $RFQJul = 0.0; $RFQAug = 0.0; $RFQSep = 0.0; $RFQOct = 0.0; $RFQNov = 0.0; $RFQDec = 0.0;

$POJan = 0.0; $POFeb  = 0.0; $POMar = 0.0; $POApr = 0.0; $POMay = 0.0; 
$POJun = 0.0; $POJul = 0.0; $POAug = 0.0; $POSep = 0.0; $POOct = 0.0; $PONov = 0.0; $PODec = 0.0;
//StaffStrength
$resultStf = mysql_query("SELECT * FROM users WHERE isActive=1");
$NoRowStaff = mysql_num_rows($resultStf);
//We need to pull RFQ from DB now
$resultRFQ = mysql_query("SELECT * FROM dmrfq WHERE LEFT(DateCreated,4) = '$BusinessYr'");
$NoRowRFQ = mysql_num_rows($resultRFQ);

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
$resultSO = mysql_query("SELECT * FROM enlinvoices WHERE LEFT(IVDate,4) = '$BusinessYr'");
$NoRowSO = mysql_num_rows($resultSO);
$TotalRevenue = 0.0;
while ($row = mysql_fetch_array($resultSO)) {

        
      $nPOID = $row['cid'];
      
         
       $ItemQW =  mysql_query("SELECT * FROM acct_ivitems WHERE PONo = '".$nPOID."'");
       while ($rowd = mysql_fetch_array($ItemQW)) {
           
              $convTotal = $convTotal + ($rowd['unitprice'] * $rowd['qty']);
       }

      $getTotalSum =  getTotalSum($nPOID);
      $convTotal = $convTotal +  $getTotalSum;

        //Get Month
        //$month = date("m",strtotime($row['SOdate']));
        $month = substr($row['IVDate'],5,2);
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



//////////////////////////////////////////////////////////////////
function getTotalSum($CONID)
{
        /*Get Line Item */
$resultPOIt = mysql_query("SELECT * FROM enlivitems Where PONo='".$CONID."' AND isActive=1");
$NoRowPOIt = mysql_num_rows($resultPOIt);
 $SN = 0; $SubTotal = 0; $MainTotal = 0;
if ($NoRowPOIt > 0) {
  while ($row = mysql_fetch_array($resultPOIt)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $PDFNUM = $row['PDFNUM'];
    $PDFItemID = $row['PDFItemID'];
    $description = $row['description'];
    $units = $row['units'];
    $qty = $row['qty'];
    $unitprice = $row['unitprice'];
    $totalprice = floatval($unitprice) * floatval($qty);
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $delDoc = "";
    $SubTotal = $SubTotal + $totalprice;
    
    
   
  }
 } 





$MainTotal =  $SubTotal;
//PO Miscellaneous
           /*Get M Item */
$resultPOM = mysql_query("SELECT * FROM enlivmiscellaneous Where PONo='".$CONID."' AND isActive=1");
$NoRowPOM = mysql_num_rows($resultPOM);
 $SN = 0;
if ($NoRowPOM > 0) {
  while ($row = mysql_fetch_array($resultPOM)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $description = $row['description'];
    $mprice = $row['price'];
    $Impact = $row['Impact'];
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $AmtType = $row['AmtType'];
    $delDoc = "";
   

    if($Impact == "ADD") { 
      $Impact = "+"; 
      if($AmtType == "DIRECT")
      {
       $MainTotal = $MainTotal + $mprice;
      }
      else{ $MainTotal = $MainTotal + ($SubTotal * $mprice)/100; $PERT = "%"; }
    }
    else { 
      $Impact = "-"; 
      
      if($AmtType == "DIRECT")
      {
       $MainTotal = $MainTotal - $mprice;
      }
      else{ $MainTotal = $MainTotal - ($SubTotal * $mprice)/100; $PERT = "% of Sub Total"; }

    }
}
}

return ($MainTotal);

}
////////////////////////////////////////////////////////////////////////
//We need to Get Out Purchase Order
//$resultPO = mysql_query("SELECT * FROM purchaseorders WHERE RIGHT(POdate,4) = '$BusinessYr'");
$resultPO = mysql_query("SELECT * FROM acct_vendorsinvoices WHERE LEFT(IVDate,4) = '$BusinessYr'");
$NoRowPO = mysql_num_rows($resultPO); 
$TotalCost = 0.0;

while ($row = mysql_fetch_array($resultPO)) {

       $nPOID = $row['cid'];
      
         
       $ItemQW =  mysql_query("SELECT * FROM acct_ivitems WHERE PONo = '".$nPOID."'");
       while ($rowd = mysql_fetch_array($ItemQW)) {
           
              $convTotal = $convTotal + ($rowd['unitprice'] * $rowd['qty']);
       }
      
        
         
      
       
        //Get Month
     // $month = date("m",strtotime($row['POdate']));
      $month = substr($row['IVDate'],5,2);
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

//$resultSS = mysql_query("SELECT enlinvoices.CusSource,COUNT(*), customers.cussnme AS ccusnme, 
//customers.CustormerNme AS ccusNme FROM enlinvoices LEFT JOIN customers ON enlinvoices.CusSource = customers.cusid  WHERE LEFT(enlinvoices.IVDate,4) = '$BusinessYr' GROUP BY enlinvoices.Customer ");

$resultSS = mysql_query("SELECT *  FROM enlinvoices LEFT JOIN customers ON enlinvoices.CusSource = customers.cusid  WHERE LEFT(IVDate,4) = '$BusinessYr' GROUP BY CusSource ORDER BY CustormerNme");
  $NoRowSSS = mysql_num_rows($resultSS); 

 while ($row = mysql_fetch_array($resultSS)) {
        //Get Month
      //$month = date("m",strtotime($row['SOdate']));
     
      $CCID = $row['cid'];
      $CCIDT = getTotalSum($CCID);
      
    
      $Totalss = $CCIDT;
      
      $Customer = mysql_real_escape_string($row['CustormerNme']);
      $Cusnme = $row['cussnme'];
        //$TotalRevenue = $TotalRevenue + $row['Total'];
     // $salesspread .= "['".$Customer ."', ".$Totalss."],";
      $salesspread .= "{'name':'". $Cusnme ."', 'y':".$Totalss.", 'y_label': '".$Customer."'},";
      //'name': 'Real Estate', 'y': 12.55, 'y_label': 12.55
      //, ['ZOBEC NIGERIA LIMITED', 26.8], ['DeltaAfrik Engineering Ltd', 8.5], ['Nigeria NLNG Limited', 6.2], ['DAEWOO E&C', 0.7]";
     
    }

//exit;

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
            Executive Dashboard
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-body">
                    <div class="ballboard col-md-3" style="background:linear-gradient(to right, #006666 0%, #009999 100%);"><i class="fa fa-filter"></i> | Deck & Mech. CUS RFQ  <span class="pull-right" id="BusNOs"><?php echo $DMCR; ?></span></div>
                    <div class="ballboard col-md-3" style="background:linear-gradient(to right, #00A65A 0%, #009999 100%);"><i class="fa fa-filter"></i> | Deck & Mech. ENL RFQ   <span class="pull-right" id="BrnNOs"><?php echo $DMER; ?></span></div>
                    <div class="ballboard col-md-3" style="background:linear-gradient(to right, #006666 0%, #009999 100%);"><i class="ion ion-ios-cart-outline"></i> | Deck & Mech. CUS PO <span class="pull-right" id="TmNOs"><?php echo $DMCPO; ?></span></div>
                    <div class="ballboard col-md-3" style="background:linear-gradient(to right, #00A65A 0%, #009999 100%);"><i class="ion ion-ios-cart-outline"></i> | Deck & Mech. ENL PO <span class="pull-right" id="POVAL"><?php echo $DMCPO; ?></span></div>
                </div>
              </div>
            </div>
          </div>  

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-body">
                    <div class="ballboard col-md-3" style="background:linear-gradient(to right, #006666 0%, #009999 100%);"><i class="fa fa-filter"></i> | Bus. Dev. CUS RFQ  <span class="pull-right" id="BusNOs"><?php echo $BDCR; ?></span></div>
                    <div class="ballboard col-md-3" style="background:linear-gradient(to right, #00A65A 0%, #009999 100%);"><i class="fa fa-filter"></i> | Bus. Dev. ENL RFQ   <span class="pull-right" id="BrnNOs"><?php echo $BDER; ?></span></div>
                    <div class="ballboard col-md-3" style="background:linear-gradient(to right, #006666 0%, #009999 100%);"><i class="ion ion-ios-cart-outline"></i> |  Bus. Dev. CUS PO <span class="pull-right" id="TmNOs"><?php echo $BDCPO; ?></span></div>
                    <div class="ballboard col-md-3" style="background:linear-gradient(to right, #00A65A 0%, #009999 100%);"><i class="ion ion-ios-cart-outline"></i> |  Bus. Dev. ENL PO <span class="pull-right" id="POVAL"><?php echo $BDCPO; ?></span></div>
                </div>
              </div>
            </div>
          </div> 

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-body">
                    <div class="ballboard col-md-3" style="background:linear-gradient(to right, #006666 0%, #009999 100%);"><i class="fa fa-filter"></i> | Marine & Log. CUS RFQ  <span class="pull-right" id="BusNOs"><?php echo $MLCR; ?></span></div>
                    <div class="ballboard col-md-3" style="background:linear-gradient(to right, #00A65A 0%, #009999 100%);"><i class="fa fa-filter"></i> | Marine & Log. ENL RFQ   <span class="pull-right" id="BrnNOs"><?php echo $MLER; ?></span></div>
                    <div class="ballboard col-md-3" style="background:linear-gradient(to right, #006666 0%, #009999 100%);"><i class="ion ion-ios-cart-outline"></i> | Marine & Log. CUS PO <span class="pull-right" id="TmNOs"><?php echo $MLCPO; ?></span></div>
                    <div class="ballboard col-md-3" style="background:linear-gradient(to right, #00A65A 0%, #009999 100%);"><i class="ion ion-ios-cart-outline"></i> | Marine & Log. ENL PO <span class="pull-right" id="POVAL"><?php echo $MLCPO; ?></span></div>
                </div>
              </div>
            </div>
          </div> 
          <!-- Info boxes -->
       
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
                                format: '₦ {value}',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            },
                            title: {
                                text: 'ENL\'s Sales Order',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            }
                        }, { // Secondary yAxis
                            title: {
                                text: 'Vendor Invoice',
                                style: {
                                    color: Highcharts.getOptions().colors[2]
                                }
                            },
                            labels: {
                                format: '₦ {value}',
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
                                valuePrefix: '₦ '
                            }

                        }, {
                            name: 'Purchase Order',
                            type: 'spline',
                            data: [ {y:POJan, key:'01'}, {y:POFeb, key:'02'}, {y:POMar, key:'03'}, {y:POApr, key:'04'}, 
                              {y:POMay, key:'05'}, {y:POJun, key:'06'}, {y:POJul, key:'07'}, {y:POAug, key:'08'}, 
                              {y:POSep, key:'09'}, {y:POOct, key:'10'}, {y:PONov, key:'11'}, {y:PODec, key:'12'}],
                            tooltip: {
                                valuePrefix: '₦ '
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
                        <h5 class="description-header"> ₦<?php echo number_format($TotalRevenue); ?></h5>
                        <span class="description-text">TOTAL REVENUE</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">₦<?php echo number_format($TotalCost); ?></h5>
                        <span class="description-text">TOTAL COST OF S</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> <?php echo number_format(($TotalCost/$TotalRevenue) * 100, 2); ?>%</span>
                        <h5 class="description-header">₦<?php echo number_format($TotalRevenue - $TotalCost); ?></h5>
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
            <script src="../mBOOT/highcharts.js"></script>
            <script src="../mBOOT/highcharts-3d.js"></script>
            <script src="../mBOOT/highcharts-more.js"></script>
            <script src="../mBOOT/exporting.js"></script>
             
          </div>

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
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="../plugins/chartjs/Chart.min.js" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard2.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js" type="text/javascript"></script>
  </body>
</html>