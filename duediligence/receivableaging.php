<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');


$EXZ = $_POST['EXZ'];

  

$FromD = $_POST['FromD'];
if($FromD != "")
{
$FromD = DateTime::createFromFormat('Y/m/d', $FromD)->format('Y/m/d');

$ToD = $_POST['ToD'];
$ToD = DateTime::createFromFormat('Y/m/d', $ToD)->format('Y/m/d');
}


//FIRST READ THROUGH POSTED INVOICES
/*$resultLI = mysql_query("SELECT *, 

 enlinvoices.IVNo AS IVNo FROM enlinvoices 
 LEFT JOIN customers ON enlinvoices.CusSource = customers.cusid
 LEFT JOIN users ON enlinvoices.RaisedBy = users.uid

  WHERE enlinvoices.isActive=1 AND PostID > 0 GROUP BY enlinvoices.CusSource  ORDER BY enlinvoices.cid
 "); *///
 
 $resultLI = mysql_query("SELECT * FROM customers  ORDER BY CustormerNme
 ");
 
$NoRowLI = mysql_num_rows($resultLI); 
$PostedAmt = 0.0; $D0T30 = 0.0; $D31T60= 0.0; $D61T90= 0.0; $D91UP = 0.0;
if ($NoRowLI > 0) {
  while ($row = mysql_fetch_array($resultLI)) 
  {
    $SN =  $SN  + 1;
    $cid = $row['cid'];
    $cusid = $row['cusid'];
    $CusName = $row['CustormerNme'];
    $AMTPOSTED = getTotalAmtPosted($cusid);
    if($AMTPOSTED[0] > 0)
    {
        $PostedAmt += $AMTPOSTED[0]; $D0T30 += $AMTPOSTED[1]; $D31T60 += $AMTPOSTED[2]; $D61T90 += $AMTPOSTED[3]; $D91UP += $AMTPOSTED[4];
    $AGETAB .= '<tr>
                        <td><a target="_blank" href="cusGLY?IJK='.$cusid.'">'.$CusName.'</a></td>
                        <td>'.number_format($AMTPOSTED[0], 2).'</td>
                        <td>'.number_format($AMTPOSTED[1], 2).'</td>
                        <td>'.number_format($AMTPOSTED[2], 2).'</td>
                        <td>'.number_format($AMTPOSTED[3], 2).'</td>
                        <td>'.number_format($AMTPOSTED[4], 2).'</td>
                      </tr>';
    }
  }
  
  $AGETAB .= '<tr>
                        <td>Total</td>
                        <th>'.number_format($PostedAmt, 2).'</th>
                        <th>'.number_format($D0T30, 2).'</th>
                        <th>'.number_format($D31T60, 2).'</th>
                        <th>'.number_format($D61T90, 2).'</th>
                        <th>'.number_format($D91UP, 2).'</th>
                      </tr>';
  
}

$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];



?>
<?php

function getTotalAmtPaid($enlinvoiceCode)
{
    ////////////////////////PAID ////////////////////////////////
 $PaidAmt = 0.0;
   $resultPAID = mysql_query("SELECT * FROM postings Where ENLINVOICE='$enlinvoiceCode' AND TransacType='CREDIT' AND GLImpacted='589' AND postings.isActive=1");
  // $resultPAID = mysql_query("SELECT * FROM postings Where CusID='$CusID' AND TransacType='CREDIT' AND GLImpacted='589'");
        $NoRowPAID = mysql_num_rows($resultPAID);
        if ($NoRowPAID > 0) {
          while ($row = mysql_fetch_array($resultPAID)) 
          {
            $pamtd = $row['TransactionAmount'];
            //ENLINVOICE
            $PaidAmt = $PaidAmt + floatval($pamtd);
           }
        }
        
        return $PaidAmt;
}

function getTotalAmtPosted($CusID)
{
    
   $TodayD = date("Y-m-d"); //
   
    $FromD = $GLOBALS['FromD']; 
   $ToD = $GLOBALS['ToD'];
   
   $PostedAmt = 0.0; $D0T30 = 0.0; $D31T60= 0.0; $D61T90= 0.0; $D91UP = 0.0;
   /*$resultPOSTING = mysql_query("SELECT * FROM postings 
   LEFT JOIN enlinvoices ON postings.ENLINVOICE = enlinvoices.cid
   Where ENLINVOICE='$enlinvoiceCode' AND TransacType='DEBIT' AND GLImpacted='589'");*/
   $resultPOSTING = mysql_query("SELECT * FROM postings 
   LEFT JOIN enlinvoices ON postings.ENLINVOICE = enlinvoices.cid
   Where postings.CusID='$CusID' AND postings.TransacType='DEBIT' AND postings.GLImpacted='589' AND postings.isActive=1");
$NoRowPOST = mysql_num_rows($resultPOSTING);
if ($NoRowPOST > 0) {
  while ($row = mysql_fetch_array($resultPOSTING)) 
  {
    $pamt = $row['TransactionAmount'];
    $IVDate = (str_replace("/", "-", $row['TransactionDate']));
    //$IVD = date_create($IVDate);
    $ENLINVOICE = $row['ENLINVOICE'];
    $PaidAmt = getTotalAmtPaid($ENLINVOICE);
    $PayBal = floatval($pamt)  - floatval($PaidAmt);
    if($PayBal > 0){
    
    $daysdiffernce = date_diff(date_create($IVDate),date_create($TodayD));
    $DateDiff = $daysdiffernce->format("%R%a");
    
    $TD = $row['TransactionDate'];
    $TDm = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');
    
    if($FromD == "")
        {
            if($DateDiff < 31) { $D0T30 += floatval($PayBal); }
            if($DateDiff > 30 && $DateDiff < 61) { $D31T60 += floatval($PayBal); }
            if($DateDiff > 60 && $DateDiff < 91) { $D61T90 += floatval($PayBal); }
            if($DateDiff > 90 ) { $D91UP += floatval($PayBal); }
            $PostedAmt = $PostedAmt + floatval($PayBal);
        }
        elseif ($TDm <= $ToD) //$FromD <= $TDm &&
                        {
                         if($DateDiff < 31) { $D0T30 += floatval($PayBal); }
                         if($DateDiff > 30 && $DateDiff < 61) { $D31T60 += floatval($PayBal); }
                         if($DateDiff > 60 && $DateDiff < 91) { $D61T90 += floatval($PayBal); }
                         if($DateDiff > 90 ) { $D91UP += floatval($PayBal); }
                         $PostedAmt = $PostedAmt + floatval($PayBal); 
                        }
    
    
    
    
    }
   }
}




  return array($PostedAmt, $D0T30, $D31T60, $D61T90, $D91UP);
  //return $DateDiff;//$PostedAmt - $PaidAmt;
}

//exit;

function getINVTotalSum($CONID)
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

return number_format($MainTotal);

}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Accounts</title>
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
     <link href="../plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
       <link href="../mBOOT/jquery-ui.css" rel="stylesheet" type="text/css">
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
<script type="text/javascript" src="../bootstrap/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	var preLoadTimer;
	var interchk = <?php echo $_SESSION['LockDownTime']; ?>;
	$(this).mousemove(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).keypress(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).scroll(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).mousedown(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	//checktime
	setInterval(function()
	{
	preLoadTimer++;
	if (preLoadTimer > 10)
	{
	window.location.href="../users/lockscreen";
	}
	}, interchk )//30 Secs

});


   function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    if (charCode == 189)
    {
      return true;
    }
    return true;
}
</script>


  </head>
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
            Accounts - Receivable Aging Report
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Receivable Aging Report</li>
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
          <!-- Info boxes -->
          <div class="row">
           <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Receivable Aging Report</h3>
                  <div class="box-tools pull-right">
                  </div>
                  <div class="row">
                   <div class="col-md-12">
                      
                        <div class="col-md-6 col-md-offset-3" style="background-color: #FF6868; border-radius: 25px;">
                        <form role="form" action="receivableaging" method="POST" ><div class="form-group">
              <div class="form-group col-md-6">
                <label>From: </label>
                <input type="text" class="form-control datep" id="FromD" name="FromD" placeholder="Click to set date" value="<?php echo $FromD; ?>" readonly required >
              </div>
              <div class="form-group col-md-6">
                <label>To: </label>
                <input type="text" class="form-control datep" id="ToD" name="ToD" placeholder="Click to set date" readonly value="<?php echo $ToD; ?>" required >
              </div>
              <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i></button><br/></form>
              </div>
                      
                    </div> 
                  </div>
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                 <!--<button class="btn btn-success pull-right" id="addAcct" onclick="addAcc(this)" > Add Account Master</button>-->
                 <button class="btn btn-success pull-left" onclick="ExportToExcel()" > Export To Excel</button>
                
                     <script>
                         function setZero(elem)
                         {
                             var EXZ = 0;
                             if($(elem).is(":checked"))
                             { EXZ = 1; } else { EXZ = 0; }
                             window.location = "?EXZ="+EXZ;
                         }
                     </script>
                </div><!-- /.box-header -->
                <div class="box-body">
                   <!--<table id="userTab" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th colspan="3"><center style="font-size:1.3em">ELSHCON NIGERIA LIMITED</center></th>
                            
                        
                        </tr>
                        <tr>
                            <th colspan="3"><center style="font-size:1.3em"> Receivable Aging as at <?php echo date("Y F"); ?> </center> </th>
                        </tr>
                      <tr>
                        <th>--</th>
                        <th>Notes</th>
                        <th>2018 NGN</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $RecChartMaster; ?>
                    </tbody>
                   
                  </table>-->
                  <table id="userTab" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                            <th colspan="6"><center style="font-size:1.3em">ELSHCON NIGERIA LIMITED</center></th>
                            
                        
                        </tr>
                        <tr>
                            <th colspan="6"><center style="font-size:1.3em"> Receivable Aging as at <?php if($ToD != "") { echo $ToD; } else { echo date("Y F"); } ?> </center> </th>
                        </tr>
                      <tr>
                        <th>Customer Name</th>
                        <th>Total A/R</th>
                        <th>0-30 Days</th>
                        <th>31-60 Days</th>
                        <th>61-90 Days</th>
                        <th>90+ Days</th>
                      </tr>
                      
                    </thead>
                    <tbody>
                        <?php echo $AGETAB; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
            
        </div><!-- /.row -->


          

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

       <?php include('../footer.php') ?>
      

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
    <!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
     <script src="../mBOOT/jquery-ui.js"></script>
    <script type="text/javascript">
     
    </script>

    <script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>
    
    <script type="text/javascript">
     function ExportToExcel()
      {
        var Dat = "A_R Aging"; //+ new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "A_R Aging",
              filename: Dat,
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true
            });
      }
     </script>

     <script type="text/javascript">
       $(".datep").datepicker({dateFormat : 'yy/mm/dd'});
     </script>


  </body>
</html>