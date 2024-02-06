<?php
session_start();
error_reporting(0);
include ('DBcon/db_configOOP.php');
//if ($_SESSION['Dept'] != "superadmin") 
//{ //$_SESSION['ErrMsg'] = "ACCESS DENIED"; 
//header('Location: users/logout'); exit; }

$rptMonth = strip_tags($_GET['mth']) ;
$nmeMonth = "";
if($rptMonth == "01") {$nmeMonth = "January";} if($rptMonth == "02") {$nmeMonth = "Febuary";} if($rptMonth == "03") {$nmeMonth = "March";}
if($rptMonth == "04") {$nmeMonth = "April";} if($rptMonth == "05") {$nmeMonth = "May";} if($rptMonth == "06") {$nmeMonth = "June";}
if($rptMonth == "07") {$nmeMonth = "July";} if($rptMonth == "08") {$nmeMonth = "August";} if($rptMonth == "09") {$nmeMonth = "September";}
if($rptMonth == "10") {$nmeMonth = "October";} if($rptMonth == "11") {$nmeMonth = "November";} if($rptMonth == "12") {$nmeMonth = "December";}
//Get Staff
$resultStaff = mysqli_query($dbhandle, "SELECT uid FROM users");
$NoRowStaff = mysqli_num_rows($resultStaff);

//Let's Read all SO
//$resultSO = mysql_query("SELECT * FROM so WHERE RIGHT(SODate,4) = '$BusinessYr'");
//$NoRowSO = mysql_num_rows($resultSO);
 /* while ($row = mysqli_fetch_array($queryUser, MYSQLI_ASSOC)) {
          $userID = $row['id'];
      $isActive = $row['isActive'];
      $UserFullName = $row['fullname'];
    }
  */

$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
$BusinessYr = $_SESSION['BusinessYear'];


$RFQJan = 0.0; $RFQFeb  = 0.0; $RFQMar = 0.0; $RFQApr = 0.0; $RFQMay = 0.0; 
$RFQJun = 0.0; $RFQJul = 0.0; $RFQAug = 0.0; $RFQSep = 0.0; $RFQOct = 0.0; $RFQNov = 0.0; $RFQDec = 0.0;

$POJan = 0.0; $POFeb  = 0.0; $POMar = 0.0; $POApr = 0.0; $POMay = 0.0; 
$POJun = 0.0; $POJul = 0.0; $POAug = 0.0; $POSep = 0.0; $POOct = 0.0; $PONov = 0.0; $PODec = 0.0;

//We need to pull RFQ from DB now
$resultRFQ = mysqli_query($dbhandle, "SELECT * FROM rfq WHERE LEFT(DateCreated,4) = '$BusinessYr' ");
//$NoRowRFQ = mysqli_num_rows($resultRFQ);
$NoRowRFQ = 0;
while ($row = mysqli_fetch_array($resultRFQ, MYSQLI_ASSOC)) {
        //Get Month
       $month = date("m",strtotime($row['DateCreated']));
        if ($month == $rptMonth)
        { 
            $NoRowRFQ = $NoRowRFQ + 1;
        }
      }

//We need to Get Sales Order
$resultSO = mysqli_query($dbhandle, "SELECT * FROM so WHERE RIGHT(SOdate,4) = '$BusinessYr'");
//$NoRowSO = mysqli_num_rows($resultSO);
$NoRowSO = 0;
$TotalRevenue = 0.0;
$mthsales = "";
while ($row = mysqli_fetch_array($resultSO, MYSQLI_ASSOC)) {
        //Get Month
        $month = date("m",strtotime($row['SOdate']));
        $sCus = $row['Customer'];
        $sTotal = round($row['SubTotal'], 2);
        $spoID = $row['poID'];
        $sDate = $row['SOdate'];

        
            

        

        if($month == '01'){ 
          $RFQJan = $RFQJan + $row['SubTotal']; 
          if($rptMonth == "01")
          {
                $mthsales .= "{
                y: ". $sTotal.",
                name: '".$sCus."',
                key: '".$spoID."'
            },";

            $NoRowSO = $NoRowSO + 1;
            $TotalRevenue = $TotalRevenue + $row['SubTotal'];
          }

        }
        if($month == '02'){ $RFQFeb = $RFQFeb + $row['SubTotal']; 
        if($rptMonth == "02")
          {
                $mthsales .= "{
                y: ".$sTotal.",
                name: '".$sCus."',
                key: '".$spoID."'
            },";

            $NoRowSO = $NoRowSO + 1;
            $TotalRevenue = $TotalRevenue + $row['SubTotal'];
          }
        }
        if($month == '03'){ $RFQMar = $RFQMar + $row['SubTotal']; 
        if($rptMonth == "03")
          {
                $mthsales .= "{
                y: ".$sTotal.",
                name: '".$sCus."',
                key: '".$spoID."'
            },";


            $NoRowSO = $NoRowSO + 1;
            $TotalRevenue = $TotalRevenue + $row['SubTotal'];
          }
        }
        if($month == '04'){ $RFQApr = $RFQApr + $row['SubTotal']; 
          if($rptMonth == "04")
          {
                $mthsales .= "{
                y: ".$sTotal.",
                name: '".$sCus."',
                key: '".$spoID."'
            },";

            $NoRowSO = $NoRowSO + 1;
            $TotalRevenue = $TotalRevenue + $row['SubTotal'];
          }
        }

        if($month == '05'){ $RFQMay = $RFQMay + $row['SubTotal']; 
          if($rptMonth == "05")
          {
                $mthsales .= "{
                y: ".$sTotal.",
                name: '".$sCus."',
                key: '".$spoID."'
            },";

            $NoRowSO = $NoRowSO + 1;
            $TotalRevenue = $TotalRevenue + $row['SubTotal'];
          }
        }

        if($month == '06'){ $RFQJun = $RFQJun + $row['SubTotal']; 
          if($rptMonth == "06")
          {
                $mthsales .= "{
                y: ".$sTotal.",
                name: '".$sCus."',
                key: '".$spoID."'
            },";

            $NoRowSO = $NoRowSO + 1;
            $TotalRevenue = $TotalRevenue + $row['SubTotal'];
          }
        }

        if($month == '07'){ $RFQJul = $RFQJul + $row['SubTotal']; 
          if($rptMonth == "07")
          {
                $mthsales .= "{
                y: ".$sTotal.",
                name: '".$sCus."',
                key: '".$spoID."'
            },";

            $NoRowSO = $NoRowSO + 1;
            $TotalRevenue = $TotalRevenue + $row['SubTotal'];
          }
        }

        if($month == '08'){ $RFQAug = $RFQAug + $row['SubTotal']; 
          if($rptMonth == "08")
          {
                $mthsales .= "{
                y: ".$sTotal.",
                name: '".$sCus."',
                key: '".$spoID."'
            },";

            $NoRowSO = $NoRowSO + 1;
            $TotalRevenue = $TotalRevenue + $row['SubTotal'];
          }
        }

        if($month == '09'){ $RFQSep = $RFQSep + $row['SubTotal']; 
          if($rptMonth == "09")
          {
                $mthsales .= "{
                y: ".$sTotal.",
                name: '".$sCus."',
                key: '".$spoID."'
            },";

            $NoRowSO = $NoRowSO + 1;
            $TotalRevenue = $TotalRevenue + $row['SubTotal'];
          }
        }

         if($month == '10'){ $RFQOct = $RFQOct + $row['SubTotal']; 
          if($rptMonth == "10")
          {
                $mthsales .= "{
                y: ".$sTotal.",
                name: '".$sCus."',
                key: '".$spoID."'
            },";

            $NoRowSO = $NoRowSO + 1;
            $TotalRevenue = $TotalRevenue + $row['SubTotal'];
          }
        }

        if($month == '11'){ $RFQNov = $RFQNov + $row['SubTotal']; 
          if($rptMonth == "11")
          {
                $mthsales .= "{
                y: ".$sTotal.",
                name: '".$sCus."',
                key: '".$spoID."'
            },";

            $NoRowSO = $NoRowSO + 1;
            $TotalRevenue = $TotalRevenue + $row['SubTotal'];
          }
        }

        if($month == '12'){ $RFQDec = $RFQDec + $row['SubTotal']; 
          if($rptMonth == "12")
          {
                $mthsales .= "{
                y: ".$sTotal.",
                name: '".$sCus."',
                key: '".$spoID."'
            },";

            $NoRowSO = $NoRowSO + 1;
            $TotalRevenue = $TotalRevenue + $row['SubTotal'];
          }
        }
        //if($month == '05'){ $RFQMay = $RFQMay + $row['SubTotal']; }
        
       




     
    }

//We need to Get Out Purchase Order
$resultPO = mysqli_query($dbhandle, "SELECT * FROM po WHERE RIGHT(POdate,4) = '$BusinessYr'");
//$NoRowPO = mysqli_num_rows($resultPO);
$NoRowPO = 0;
$TotalCost = 0.0;
$mthPO = "";

while ($row = mysqli_fetch_array($resultPO, MYSQLI_ASSOC)) {

        //Get Month
      $month = date("m",strtotime($row['POdate']));
        $sDate = $row['POdate'];
        $spoID = $row['poID'];
        $sSup = $row['Supplier'];
        

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
        $getCurrn = mysqli_fetch_assoc(mysqli_query($dbhandle, "SELECT Currency FROM purchaselineitems WHERE LitID = '".$LineITemID."'"));
        $CurrencyDetails = $getCurrn['Currency'];
        if($CurrencyDetails != "USD")
        {
        //We now need to Get the Conversion rate
        $getConvert = mysqli_fetch_assoc(mysqli_query($dbhandle, "SELECT ExRateToUSD FROM currencies WHERE Abbreviation = '".$CurrencyDetails."'"));
        $CurrConvRate = $getConvert['ExRateToUSD'];

        $sTotal = $row['Total'] * $CurrConvRate;
      //$PODetails .= "Ext Price :". $POItem[2]. "<br>";
        }
        else {

          //$convTotal = $row['Total'];
          $sTotal = round($row['Total'], 2);
        }
      } 
      

        if ($month == $rptMonth)
        {
            
           

        }


        if($month == '01'){ $POJan = $POJan + $sTotal; 

        if($rptMonth == "01")
          {
                $mthPO .= "{
                y: ".$sTotal.",
                name: '".$sSup."',
                key: '".$spoID."'
            },";
          }
        }
        if($month == '02'){ $POFeb = $POFeb + $sTotal; 
          if($rptMonth == "02")
          {
                $mthPO .= "{
                y: ".$sTotal.",
                name: '".$sSup."',
                key: '".$spoID."'
            },";
          }

      }
        if($month == '03'){ $POMar = $POMar + $sTotal; 
        if($rptMonth == "03")
          {
                $mthPO .= "{
                y: ".$sTotal.",
                name: '".$sSup."',
                key: '".$spoID."'
            },";
          }
      }
        if($month == '04'){ $POApr = $POApr + $sTotal; 
        if($rptMonth == "04")
          {
                $mthPO .= "{
                y: ".$sTotal.",
                name: '".$sSup."',
                key: '".$spoID."'
            },";
          }
      }
      
      if($month == '05'){ $POMay = $POMay + $sTotal; 

      if($rptMonth == "05")
          {
                $mthPO .= "{
                y: ".$sTotal.",
                name: '".$sSup." : ".$sDate."',
                key: '".$spoID."'
            },";
          }
        }

      if($month == '06'){ $POJun = $POJun + $sTotal; 

      if($rptMonth == "06")
          {
                $mthPO .= "{
                y: ".$sTotal.",
                name: '".$sSup." : ".$sDate."',
                key: '".$spoID."'
            },";
          }
        }

      if($month == '07'){ $POJul = $POJul + $sTotal; 

      if($rptMonth == "07")
          {
                $mthPO .= "{
                y: ".$sTotal.",
                name: '".$sSup." : ".$sDate."',
                key: '".$spoID."'
            },";
          }
        }

      if($month == '08'){ $POAug = $POAug + $sTotal; 

      if($rptMonth == "08")
          {
                $mthPO .= "{
                y: ".$sTotal.",
                name: '".$sSup." : ".$sDate."',
                key: '".$spoID."'
            },";
          }
        }

      if($month == '09'){ $POSep = $POSep + $sTotal; 

      if($rptMonth == "09")
          {
                $mthPO .= "{
                y: ".$sTotal.",
                name: '".$sSup." : ".$sDate."',
                key: '".$spoID."'
            },";
          }
        }

      if($month == '10'){ $POOct = $POOct + $sTotal; 

      if($rptMonth == "10")
          {
                $mthPO .= "{
                y: ".$sTotal.",
                name: '".$sSup." : ".$sDate."',
                key: '".$spoID."'
            },";
          }
        }

      if($month == '11'){ $PONov = $PONov + $sTotal; 

      if($rptMonth == "11")
          {
                $mthPO .= "{
                y: ".$sTotal.",
                name: '".$sSup." : ".$sDate."',
                key: '".$spoID."'
            },";
          }
        }

      if($month == '12'){ $PODec = $PODec + $sTotal; 

      if($rptMonth == "12")
          {
                $mthPO .= "{
                y: ".$sTotal.",
                name: '".$sSup." : ".$sDate."',
                key: '".$spoID."'
            },";
          }
        }
        
       /* if($month == '09'){ $POSep = $POSep + $row['Total']; }
        if($month == '10'){ $POOct = $POOct + $row['Total']; }
        if($month == '11'){ $PONov = $PONov + $row['Total']; }
        if($month == '12'){ $PODec = $PODec + $row['Total']; } */

            $NoRowPO = $NoRowPO + 1;
            $TotalCost = $TotalCost + $sTotal;
     
    }



//SELECT `Supplier`,COUNT(*), SUM(Total) As Total FROM po GROUP BY `Supplier`
  //<?php $salesspread = "['Chevron Nigeria Limited', 45.0], ['ZOBEC NIGERIA LIMITED', 26.8], ['DeltaAfrik Engineering Ltd', 8.5], ['Nigeria NLNG Limited', 6.2], ['DAEWOO E&C', 0.7]"; 
//We need to get SalesSpread now
   
$salesspread = "";
$resultSS = mysqli_query($dbhandle, "SELECT Customer,COUNT(*), SUM(Total) As Total FROM so WHERE RIGHT(SOdate,4) = '$BusinessYr' GROUP BY Customer ");
 $NoRowSSS = mysqli_num_rows($resultSS);

 while ($row = mysqli_fetch_array($resultSS, MYSQLI_ASSOC)) {
        //Get Month
      //$month = date("m",strtotime($row['SOdate']));
      $Customer = $row['Customer'];
      $Totalss = $row['Total'];
        //$TotalRevenue = $TotalRevenue + $row['Total'];
      $salesspread .= "['".$Customer ."', ".$Totalss."],";
      //, ['ZOBEC NIGERIA LIMITED', 26.8], ['DeltaAfrik Engineering Ltd', 8.5], ['Nigeria NLNG Limited', 6.2], ['DAEWOO E&C', 0.7]";
     
    }




?>
<!DOCTYPE html>
<html>
<!-- HEAD -->
<?php include ('header.php'); ?>
<!-- HEAD -->
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Top Menu -->
      <?php include ('topmenu.php'); ?>
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
          <?php include ('leftmenuCEO.php');  ?>
         </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Sales Performance 
            <small><?php echo $nmeMonth; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Sales Performance</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-filter"></i></span>
                <div class="info-box-content ">
                  <span class="info-box-text"> Total RFQ <strong>[<?php echo $_SESSION['BusinessYear']; ?>] </strong></span>
                  <span class="info-box-number"><?php echo $NoRowRFQ; ?></span>
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
                  <span class="info-box-text">OUT-Sales Order <strong>[<?php echo $_SESSION['BusinessYear']; ?>] </strong></span>
                  <span class="info-box-number"><?php echo $NoRowSO; ?> <small style="color:#009900">( $<?php echo number_format($TotalRevenue); ?> )</small></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="ion ion-ios-cart-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">OUT-Purchase Order <strong>[<?php echo $_SESSION['BusinessYear']; ?>] </strong></span>
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

          
          <div class="row" style="display:none">
            <div class="col-md-12">
              <div class="box collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">Sales Performance [Monthly]</h3>
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
                    <div class="col-md-8">
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
                            zoomType: 'xy'
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
                                format: 'USD {value}',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            },
                            title: {
                                text: 'Sold',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            }
                        }, { // Secondary yAxis
                            title: {
                                text: 'Purchased',
                                style: {
                                    color: Highcharts.getOptions().colors[2]
                                }
                            },
                            labels: {
                                format: 'USD {value}',
                                style: {
                                    color: Highcharts.getOptions().colors[0]
                                }
                            },
                            opposite: true
                        }],
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
                            name: 'Sold',
                            type: 'column',

                            yAxis: 1,
                            data: [RFQJan, RFQFeb, RFQMar, RFQApr, RFQMay, RFQJun, RFQJul, RFQAug, RFQSep, RFQOct, RFQNov, RFQDec],
                            
                            tooltip: {
                                valuePrefix: 'USD '
                            }

                        }, {
                            name: 'Purchased',
                            type: 'spline',
                            data: [POJan, POFeb, POMar, POApr, POMay, POJun, POJul, POAug, POSep, POOct, PONov, PODec],
                            tooltip: {
                                valuePrefix: 'USD '
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
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Sales Spread</strong>
                        <?php //$salesspread = "['Chevron Nigeria Limited', 45.0, '23343'], ['ZOBEC NIGERIA LIMITED', 26.8, '23343'], ['DeltaAfrik Engineering Ltd', 8.5, '23343'], ['Nigeria NLNG Limited', 6.2, '23343'], ['DAEWOO E&C', 0.7, '23343']"; ?>
                      </p>
                        <script type="text/javascript">
                $(function () {
                    Highcharts.chart('pie3d', {
                      colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
                        chart: {
                            type: 'pie',
                            /*options3d: {
                                enabled: true,
                                alpha: 45,
                                beta: 0
                            }*/
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

                    <div id="pie3d" style="width:100%"></div>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
                <div class="box-footer">
                  <div class="row">
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                        <h5 class="description-header"> $<?php echo number_format($TotalRevenue); ?></h5>
                        <span class="description-text">TOTAL REVENUE</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">$<?php echo number_format($TotalCost); ?></h5>
                        <span class="description-text">TOTAL COST</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">$<?php echo number_format($TotalRevenue - $TotalCost); ?></h5>
                        <span class="description-text">TOTAL PROFIT</span>
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

          <!-- Main row -->
          <div class="row">
            <div class="col-md-12">
              <div class="box"> 
               <div class="box-header with-border">
                  <h3 class="box-title">Sales Order from Customer [Drillable]</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   </div> 
                </div><!-- /.box-header -->
            <div class="box-body">
            <div class="col-md-12">
            <script type="text/javascript">
                  $(function () {

                  

                      var chart = Highcharts.chart('barchart', {
                      colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
                      //colors: ['#058DC7', '#058DC7', '#058DC7', '#058DC7', '#058DC7', '#058DC7', '#058DC7', '#058DC7', '#058DC7'],

                          title: {
                              text: 'Sales Order'
                          },

                          chart: {
                            zoomType: 'xy',
                            options3d: {
                                      enabled: true,
                                      alpha: 0,
                                      beta: 1,
                                      depth: 50,
                                      viewDistance: 25
                            }
                        },

                          subtitle: {
                              text: ''
                          },
                          credits: {
                                      enabled: false
                        },

                          xAxis: {
                              type: 'category',

                               stackLabels: {
                                  enabled: true,
                                  style: {
                                      fontWeight: 'bold',
                                      color:'gray'
                                  }
                               }
                          },

                           yAxis: [{ // Primary yAxis
                            labels: {
                                format: '$ {value}',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            },
                            title: {
                                text: 'Amount (USD)',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            }
                        }],

                          plotOptions: {

                           

                             column: {
                                  /*stacking: 'normal',
                                  dataLabels: {
                                      enabled: true,
                                      color: '#000' //(Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
                                  }*/
                              },

                            tooltip: {
                                 formatter: function() {
                                      var s = '<b>'+ this.x +'</b>',
                                      sum = 0;               
                                      $.each(this.points, function(i, point) {
                                          s += '<br/>'+ point.series.name +': '+
                                              point.y;
                                          sum += point.y;
                                      });                
                                      s += '<br/>Sum: '+ sum               
                                      return s;
                                  },
                                  shared: true
                              },
                            series: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                point: {
                                    events: {
                                        click: function () {
                                            //location.href = 'sperformance?' +
                                                //this.options.key;
                                                //this.point.name;
                                                //this.series.categories;
                                        }
                                    }
                                }
                            }
                        },

                          series: [{
                              type: 'column',
                              
                              name: 'Sales',
                              colorByPoint: true,
                              data: [ <?php echo $mthsales; ?> ],
                              //key: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                              tooltip: {
                                valuePrefix: '$ '
                            },
                              showInLegend: true

                          }

                          ]

                          
                      });


                      $('#plain').click(function () {
                          chart.update({
                              chart: {
                                  inverted: false,
                                  polar: false
                              },
                              subtitle: {
                                  text: 'Plain'
                              }
                          });
                      });

                      $('#inverted').click(function () {
                          chart.update({
                              chart: {
                                  inverted: true,
                                  polar: false
                              },
                              subtitle: {
                                  text: 'Inverted'
                              }
                          });
                      });

                      $('#line').click(function () {
                          chart.update({
                              chart: {
                                  inverted: false,
                                  polar: true
                              },
                              subtitle: {
                                  text: 'Polar'
                              }
                          });
                      });

                      $('#polar').click(function () {
                          chart.update({
                              chart: {
                                  inverted: false,
                                  polar: true
                              },
                              subtitle: {
                                  text: 'Polar'
                              }
                          });
                      });

                  });
    </script>
          <div>
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/highcharts-3d.js"></script>
            <script src="https://code.highcharts.com/highcharts-more.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>

              <div id="barchart"></div>
              <button id="plain" class="btn btn-primary btn-flat">Bar</button>
              <button id="inverted" class="btn btn-primary btn-flat">Inverted</button>
              <button id="polar" class="btn btn-primary btn-flat">Polar</button>

          </div>
           </div>
       
         </div>
       </div>
         </div>
        </div><!-- /.row -->

        <!-- Main row -->
          <div class="row">
            <div class="col-md-12">
              <div class="box"> 
               <div class="box-header with-border">
                  <h3 class="box-title">Purchase Order to OEM [Drillable]</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   </div> 
                </div><!-- /.box-header -->
            <div class="box-body">
            <div class="col-md-12">
            <script type="text/javascript">
                  $(function () {

                  

                      var chart = Highcharts.chart('barchartPO', {
                      colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
                      //colors: ['#058DC7', '#058DC7', '#058DC7', '#058DC7', '#058DC7', '#058DC7', '#058DC7', '#058DC7', '#058DC7'],

                          title: {
                              text: 'Sales'
                          },

                          chart: {
                          zoomType: 'xy'
                          },


                          subtitle: {
                              text: ''
                          },
                          credits: {
                                      enabled: false
                        },

                          xAxis: {
                              type: 'category'
                          },

                           yAxis: [{ // Primary yAxis
                            labels: {
                                format: 'USD {value}',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            },
                            title: {
                                text: 'Amount (USD)',
                                style: {
                                    color: Highcharts.getOptions().colors[1]
                                }
                            }
                        }],

                          plotOptions: {
                             column: {
                              /*
                                 dataLabels: {
                                      enabled: true,
                                      color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
                                  }
                                  */
                              },
                            series: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                point: {
                                    events: {
                                        click: function () {
                                            //location.href = 'sperformance?' +
                                                //this.options.key;
                                                //this.point.name;
                                                //this.series.categories;
                                        }
                                    }
                                }
                            }
                        },

                          series: [{
                              type: 'column',
                               
                              name: 'Sales',
                              colorByPoint: true,
                              data: [ <?php echo $mthPO; ?> ],
                              //key: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                              tooltip: {
                                valuePrefix: 'USD '
                            },
                              showInLegend: true

                          }
                         ]

                          
                      });


                      $('#plainPO').click(function () {
                          chart.update({
                              chart: {
                                  inverted: false,
                                  polar: false
                              },
                              subtitle: {
                                  text: 'Plain'
                              }
                          });
                      });

                      $('#invertedPO').click(function () {
                          chart.update({
                              chart: {
                                  inverted: true,
                                  polar: false
                              },
                              subtitle: {
                                  text: 'Inverted'
                              }
                          });
                      });

                      $('#linePO').click(function () {
                          chart.update({
                              chart: {
                                  inverted: false,
                                  polar: true
                              },
                              subtitle: {
                                  text: 'Polar'
                              }
                          });
                      });

                      $('#polarPO').click(function () {
                          chart.update({
                              chart: {
                                  inverted: false,
                                  polar: true
                              },
                              subtitle: {
                                  text: 'Polar'
                              }
                          });
                      });

                  });
    </script>
          <div>
           
              <div id="barchartPO"></div>
              <button id="plainPO" class="btn btn-primary btn-flat">Bar</button>
              <button id="invertedPO" class="btn btn-primary btn-flat">Inverted</button>
              <button id="polarPO" class="btn btn-primary btn-flat">Polar</button>

          </div>
           </div>
       
         </div>
       </div>
         </div>
        </div><!-- /.row -->

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