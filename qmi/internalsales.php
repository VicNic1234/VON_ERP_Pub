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
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Report QMI</title>
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
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Report Quick Market Intelligence</h3>
				   
                  <div class="box-tools pull-right">
                  <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
				  <!--<a style="float:right" href="./"> X</a>-->
				  <form>
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
    <label>Quarter</label>
        <input type="text" class="form-control" id="sQt" name="sQt" readonly required >
    </div>
   <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
    <label>First Day of Report Week</label>
        <input type="text" class="form-control" id="sDy" name="sDy" readonly required >
    </div>
    <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
    <label>Product to Report</label>
        <select class="form-control" id="sProduct" name="sProduct" required >
          <option value=""> Select Product </option>
          <?php echo $prodrec; ?>
        </select>
    </div>
    <a href="../utility/aProduct" target="_blank"><i title="Add New Product" style="font-size:22px; cursor:pointer; color:green" class="fa fa-plus"></i></a>

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

        
<div id="PrintArea">
	<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                   <!-- Logo -->
        <a class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="../mBOOT/plant.png" width="50" height="50" /></span>
          <!-- logo for regular state and mobile devices
          <span class="logo-lg"> <img src="../mBOOT/plant.png" style ="width:40px; height:40px;"/></span>-->
        </a>
                  <h3 class="box-title"> <?php echo $_SESSION['CompanyAbbr']; ?>- - Quick Market Intelligence </h3>
                  
                </div><!-- /.box-header -->
				
            
              <div class="box">
               <div class="box-body">
				<!-- Form Info -->
			  <div class="col-xs-4">
              <table id="CommTab" class="table table-striped">
                
                <tbody>
                    <tr>
                        <td><b>Date:</b> </td>
                        <td><?php echo date("Y-M-d") ?></td>
                    </tr>
                    <tr>
                        <td><b>Reported by:</b> </td>
                        <td><?php echo $staffName; ?></td>
                    </tr>
					<tr>
                        <td><b>Department:</b> </td>
                        <td style="text-transformation: uppercase;"><?php echo $_SESSION['Dept']; ?></td>
                    </tr>
                    

                </tbody>

              </table>
			  </div>
                  
          <div class="row">
            <div class="col-md-12">
              <div class="box collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">[Product Sales], [Key Opportunities for <b><?php echo $BusinessYr; ?></b> Estimate], [Breakdown in progressive sales walk]</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
      <div class="row">
             <div class="col-md-4">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#99CCFF;">
                <div class="box-header">
                  <h3 class="box-title">Product Sales </h3> &nbsp;<i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label>Opportunity Pipeline (USD)</label>
                      <input type="number" class="form-control" name="OP" id="OP" onKeyPress="return isNumber(event)" min="1" placeholder="USD" required >
                    </div>
                    <div class="form-group">
                      <label for="EAOP">EAOP</label>
                      <input type="number" class="form-control" name="EAOP" id="EAOP" onKeyPress="return isNumber(event)" min="1" placeholder="EAOP in USD" required >
                    </div>
                    <div class="form-group">
                      <label for="OB">Orders Booked (YTD)</label>
                      <input type="number" class="form-control" name="OB" id="OB" onKeyPress="return isNumber(event)" min="1" placeholder="Orders Booked (YTD) in USD" required >
                    </div>
                    <div class="form-group">
                      <label for="OBN">Orders Not Booked</label>
                      <input type="number" class="form-control" name="OBN" id="OBN" onKeyPress="return isNumber(event)" min="1" placeholder="Orders Not Booked in USD" required >
                    </div>

                    <script>
                    function reportMPS()
                    {
                      var ReportWeek = $('#sWk').val(); 
                      var ReportQtr = $('#sQt').val(); 
                      var FirstWeekDay = $('#sDy').val(); 
                      var DaysOfRtpWeek = $('#sDys').val(); 
                      if (ReportWeek < 1){ alert("Kindly select week"); return false;}
                      var sProduct = $('#sProduct').val(); 
                      if (sProduct < 1){ alert("Kindly select product you are reporting for. Thanks"); return false;}
                      

                      var sProduct = $('#sProduct').val(); 
                      if (sProduct < 1){ alert("Kindly select product you are reporting for. Thanks"); return false;}
                      //

                      var OP = $('#OP').val(); 
                      var EAOP = $('#EAOP').val(); 
                      var OB = $('#OB').val(); 
                      var OBN = $('#OBN').val(); 

                      if (OP == "" || EAOP == "" || OB == ""|| OBN == "") { alert("Kindly fill form completely"); return false;}
                      
                      var formData = { sProduct:sProduct, ReportWeek:ReportWeek, ReportQtr:ReportQtr, FirstWeekDay:FirstWeekDay, DaysOfRtpWeek:DaysOfRtpWeek, OP:OP, EAOP:EAOP, OB:OB, OBN:OBN };
                        $.ajax({
                            type:"POST",
                            url: "addmps",
                            data: formData,
                            //contentType: true,
                            //dataType: "json",
                            //cache: false,
                            //processData:false,
                            success: function (data) {
                               $('#OP').val(""); 
                               $('#EAOP').val(""); 
                               $('#OB').val(""); 
                               $('#OBN').val(""); 
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
                    <button type="button" onclick="reportMPS();" class="btn btn-primary pull-right">Report</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
            <div class="col-md-4">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#99CCFF;">
                <div class="box-header">
                  <h3 class="box-title">Key Opportunities for <b><?php echo $BusinessYr; ?></b> Estimate </h3> &nbsp;<i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    
                    <div class="form-group col-md-6">
                      <label>Customer/Project Name</label>
                      <input type="text" class="form-control" name="CusProj" id="CusProj" placeholder="Customer/Proj. Name">
                    </div>
                    <div class="form-group col-md-6">
                      <label><?php echo $_SESSION['CompanyAbbr']; ?>/Product Ref </label>
                      <input type="text" class="form-control" name="ProdRef" id="ProdRef" placeholder="<?php echo $_SESSION['CompanyAbbr']; ?>/Product Ref">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Product Line</label>
                      <input type="text" class="form-control" name="ProdLine" id="ProdLine" placeholder="Product Line">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Value (Est.)</label>
                      <input type="number" class="form-control" onKeyPress="return isNumber(event)" name="ValueEst" id="ValueEst" placeholder="Product Line">
                    </div>

                    <div class="form-group col-md-6" >
                      <label>Status</label>
                      <input type="text" class="form-control" name="KOStatus" id="KOStatus" placeholder="Status">
                    </div>

                    <div class="form-group col-md-6">
                      <label>To Close</label>
                      <select class="form-control" name="KOclose" id="KOclose">
                        <option value="Q1">Q1</option>
                        <option value="Q2">Q2</option>
                        <option value="Q3">Q3</option>
                        <option value="Q4">Q4</option>
                      </select>
                    </div>

                    
                  </div><!-- /.box-body -->
                    <script>
                    function reportKOP()
                    {
                      var ReportWeek = $('#sWk').val(); 
                      var ReportQtr = $('#sQt').val(); 
                      var FirstWeekDay = $('#sDy').val(); 
                      var DaysOfRtpWeek = $('#sDys').val(); 
                      if (ReportWeek < 1){ alert("Kindly select week"); return false;}
                      var sProduct = $('#sProduct').val(); 
                      if (sProduct < 1){ alert("Kindly select product you are reporting for. Thanks"); return false;}
                      

                      var CusProj = $('#CusProj').val(); 
                      var ProdRef = $('#ProdRef').val(); 
                      var ProdLine = $('#ProdLine').val(); 
                      var ValueEst = $('#ValueEst').val(); 
                      var KOStatus = $('#KOStatus').val(); 
                      var KOclose = $('#KOclose').val(); 

                      if (CusProj == "" || ProdRef == "" || ProdLine == "" || ValueEst == "" || KOStatus == "" || KOclose == "") { alert("Kindly fill form completely"); return false;}
                      
                      var formData = { sProduct:sProduct, ReportWeek:ReportWeek, ReportQtr:ReportQtr, FirstWeekDay:FirstWeekDay, DaysOfRtpWeek:DaysOfRtpWeek, CusProj:CusProj, ProdRef:ProdRef, ProdLine:ProdLine, ValueEst:ValueEst, KOStatus:KOStatus, KOclose:KOclose };
                        $.ajax({
                            type:"POST",
                            url: "addkop",
                            data: formData,
                            //contentType: true,
                            //dataType: "json",
                            //cache: false,
                            //processData:false,
                            success: function (data) {
                               $('#CusProj').val(""); 
                               $('#ProdRef').val(""); 
                               $('#ProdLine').val(""); 
                               $('#ValueEst').val(""); 
                               $('#KOStatus').val(""); 
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
                    <button type="button" onclick="reportKOP();" class="btn btn-primary pull-right">Report</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
            <div class="col-md-4">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#99CCFF;">
                <div class="box-header">
                  <h3 class="box-title">Breakdown in progressive sales walk </h3> &nbsp;<i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="form-group">
                      <label>Sourcing Stage</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="SSOP" id="SSOP" onKeyPress="return isNumber(event)" min="1" placeholder="No. of Oppourtunities">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="SSEstVal" id="SSEstVal" onKeyPress="return isNumber(event)" min="1" placeholder="Est. Value in USD">
                    </div>
                    <div class="form-group">
                      <label>Budgetary Offer</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="BOOP" id="BOOP" onKeyPress="return isNumber(event)" min="1" placeholder="No. of Oppourtunities">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="BOEstVal" id="BOEstVal" onKeyPress="return isNumber(event)" min="1" placeholder="Est. Value in USD">
                    </div>
                    <div class="form-group">
                      <label>Firm Offer</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="FOOP" id="FOOP" onKeyPress="return isNumber(event)" min="1" placeholder="No. of Oppourtunities">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="FOEstVal" id="FOEstVal" onKeyPress="return isNumber(event)" min="1" placeholder="Est. Value in USD">
                    </div>
                    <div class="form-group">
                      <label>Anticipating POs</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="APOP" id="APOP" onKeyPress="return isNumber(event)" min="1" placeholder="No. of Oppourtunities">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="APEstVal" id="APEstVal" onKeyPress="return isNumber(event)" min="1" placeholder="Est. Value in USD">
                    </div>
                    <div class="form-group">
                      <label>Received POs</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="RePO" id="RePO" onKeyPress="return isNumber(event)" min="1" placeholder="No. of Oppourtunities">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="ReEstVal" id="ReEstVal" onKeyPress="return isNumber(event)" min="1" placeholder="Est. Value in USD">
                    </div>
                    
                   

                    
                  </div><!-- /.box-body -->

                   <script>
                    function reportBKPSW()
                    {
                      var ReportWeek = $('#sWk').val(); 
                      var ReportQtr = $('#sQt').val(); 
                      var FirstWeekDay = $('#sDy').val(); 
                      var DaysOfRtpWeek = $('#sDys').val(); 
                      if (ReportWeek < 1){ alert("Kindly select week"); return false;}
                      var sProduct = $('#sProduct').val(); 
                      if (sProduct < 1){ alert("Kindly select product you are reporting for. Thanks"); return false;}
                      

                      var SSOP = $('#SSOP').val(); 
                      var BOOP = $('#BOOP').val(); 
                      var FOOP = $('#FOOP').val(); 
                      var APOP = $('#APOP').val(); 
                      var RePO = $('#RePO').val();

                      var SSEstVal = $('#SSEstVal').val(); 
                      var BOEstVal = $('#BOEstVal').val(); 
                      var FOEstVal = $('#FOEstVal').val(); 
                      var APEstVal = $('#APEstVal').val(); 
                      var ReEstVal = $('#ReEstVal').val(); 
                     

                      if (SSOP == "" || BOOP == "" || FOOP == "" || APOP == "" || RePO == "" ) { alert("Kindly fill form completely"); return false;}
                      if (SSEstVal == "" || BOEstVal == "" || FOEstVal == "" || APEstVal == "" || ReEstVal == "") { alert("Kindly fill form completely"); return false;}
                      
                      var formData = { sProduct:sProduct, ReportWeek:ReportWeek, ReportQtr:ReportQtr, FirstWeekDay:FirstWeekDay, DaysOfRtpWeek:DaysOfRtpWeek, 
                        SSOP:SSOP, BOOP:BOOP, FOOP:FOOP, APOP:APOP, RePO:RePO, 
                        SSEstVal:SSEstVal, BOEstVal:BOEstVal, FOEstVal:FOEstVal, APEstVal:APEstVal, ReEstVal:ReEstVal };
                        $.ajax({
                            type:"POST",
                            url: "addbkpsw",
                            data: formData,
                            //contentType: true,
                            //dataType: "json",
                            //cache: false,
                            //processData:false,
                            success: function (data) {
                            $('#SSOP').val(""); 
                            $('#BOOP').val(""); 
                            $('#FOOP').val(""); 
                            $('#APOP').val(""); 
                            $('#RePO').val("");

                            $('#SSEstVal').val(""); 
                            $('#BOEstVal').val(""); 
                            $('#FOEstVal').val(""); 
                            $('#APEstVal').val(""); 
                            $('#ReEstVal').val(""); 
                            
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
                    <button type="button" onclick="reportBKPSW();" class="btn btn-primary pull-right">Report</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
    </div>
                </div><!-- ./box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div class="row">
            <div class="col-md-12">
              <div class="box collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">[Risk in Q1-Q4 Estimate], [Gap-closing Opps./Upsides], [Synergy Oppourtunities]</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
      <div class="row">
             <div class="col-md-4">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#FFDED3;">
                <div class="box-header">
                  <h3 class="box-title">Risk in Q1-Q4 Estimate </h3> &nbsp;<i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="form-group col-md-6">
                      <label>Customer</label>
                    </div>
                    <div class="form-group col-md-6">
                      <select class="form-control" name="aCus" id="aCus">
                          <?php echo $cusrec; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Product Line</label>
                    </div>
                    <div class="form-group col-md-6"> 
                      <select class="form-control" name="aProd" id="aProd">
                          <?php echo $prodrec; ?>
                      </select>
                     </div>
                    <div class="form-group col-md-6">
                      <label>Value (USD)</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="aVal" id="aVal" onKeyPress="return isNumber(event)" placeholder="Value in $">
                    </div>
                     <div class="form-group col-md-6">
                      <label>Status</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" name="aStatus" id="aStatus" placeholder="Status">
                    </div>
                  </div><!-- /.box-body -->

                   <script>
                    function reportRiskIn()
                    {
                      var ReportWeek = $('#sWk').val(); 
                      var ReportQtr = $('#sQt').val(); 
                      var FirstWeekDay = $('#sDy').val(); 
                      var DaysOfRtpWeek = $('#sDys').val(); 
                      if (ReportWeek < 1){ alert("Kindly select week"); return false;}
                      var sProduct = $('#sProduct').val(); 
                      if (sProduct < 1){ alert("Kindly select product you are reporting for. Thanks"); return false;}
                      

                      var aCus = $('#aCus').val(); 
                      var aProd = $('#aProd').val(); 
                      var aVal = $('#aVal').val(); 
                      var aStatus = $('#aStatus').val(); 
                     

                      if (aCus == "" || aProd == "" || aVal == "" || aStatus == "") { alert("Kindly fill form completely"); return false;}
                      
                      var formData = { sProduct:sProduct, ReportWeek:ReportWeek, ReportQtr:ReportQtr, FirstWeekDay:FirstWeekDay, DaysOfRtpWeek:DaysOfRtpWeek, 
                        aCus:aCus, aProd:aProd, aVal:aVal, aStatus:aStatus};
                        $.ajax({
                            type:"POST",
                            url: "addrskinq1",
                            data: formData,
                            //contentType: true,
                            //dataType: "json",
                            //cache: false,
                            //processData:false,
                            success: function (data) {
                            $('#aCus').val(""); 
                            $('#aProd').val(""); 
                            $('#aVal').val(""); 
                            $('#aStatus').val(""); 
                             
                            
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
                    <button type="button" onclick="reportRiskIn();" class="btn btn-primary pull-right">Report</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
            <div class="col-md-4">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#FFDED3;">
                <div class="box-header">
                  <h3 class="box-title">Gap-closing Opps./Upsides – Opportunities not included in Q1 Estimate </h3> &nbsp;<i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="form-group col-md-6">
                      <label>Customer</label>
                    </div>
                   <div class="form-group col-md-6">
                      <select class="form-control" name="bCus" id="bCus">
                          <?php echo $cusrec; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Product Line</label>
                    </div>
                    <div class="form-group col-md-6"> 
                      <select class="form-control" name="bProd" id="bProd">
                          <?php echo $prodrec; ?>
                      </select>
                     </div>
                    <div class="form-group col-md-6">
                      <label>Value (USD)</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="bVal" id="bVal" onKeyPress="return isNumber(event)" placeholder="Value in $">
                    </div>
                     <div class="form-group col-md-6">
                      <label>Status</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" name="bStatus" id="bStatus" placeholder="Status">
                    </div>
                  </div><!-- /.box-body -->
                    <script>
                    function ReportGapCLose()
                    {
                      var ReportWeek = $('#sWk').val(); 
                      var ReportQtr = $('#sQt').val(); 
                      var FirstWeekDay = $('#sDy').val(); 
                      var DaysOfRtpWeek = $('#sDys').val(); 
                      if (ReportWeek < 1){ alert("Kindly select week"); return false;}
                      var sProduct = $('#sProduct').val(); 
                      if (sProduct < 1){ alert("Kindly select product you are reporting for. Thanks"); return false;}
                      

                      var bCus = $('#bCus').val(); 
                      var bProd = $('#bProd').val(); 
                      var bVal = $('#bVal').val(); 
                      var bStatus = $('#bStatus').val(); 
                     

                      if (bCus == "" || bProd == "" || bVal == "" || bStatus == "") { alert("Kindly fill form completely"); return false;}
                      
                      var formData = { sProduct:sProduct, ReportWeek:ReportWeek, ReportQtr:ReportQtr, FirstWeekDay:FirstWeekDay, DaysOfRtpWeek:DaysOfRtpWeek, 
                        bCus:bCus, bProd:bProd, bVal:bVal, bStatus:bStatus};
                        $.ajax({
                            type:"POST",
                            url: "addgapclose",
                            data: formData,
                            //contentType: true,
                            //dataType: "json",
                            //cache: false,
                            //processData:false,
                            success: function (data) {
                            $('#bCus').val(""); 
                            $('#bProd').val(""); 
                            $('#bVal').val(""); 
                            $('#bStatus').val(""); 
                             
                            
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
                    <button type="button" onclick="ReportGapCLose();" class="btn btn-primary pull-right">Report</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
            <div class="col-md-4">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#FFDED3;">
                <div class="box-header">
                  <h3 class="box-title">Synergy Oppourtunities </h3> &nbsp;<i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="form-group col-md-6">
                      <label>Customer</label>
                    </div>
                    <div class="form-group col-md-6">
                      <select class="form-control" name="cCus" id="cCus">
                          <?php echo $cusrec; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label>Product Line</label>
                    </div>
                    <div class="form-group col-md-6"> 
                      <select class="form-control" name="cProd" id="cProd">
                          <?php echo $prodrec; ?>
                      </select>
                     </div>
                    <div class="form-group col-md-6">
                      <label>Value (USD)</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="number" class="form-control" name="cVal" id="cVal" onKeyPress="return isNumber(event)" placeholder="Value in $">
                    </div>
                     <div class="form-group col-md-6">
                      <label>Status</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" name="cStatus" id="cStatus" placeholder="Status">
                    </div>
                  </div><!-- /.box-body -->
                  <script>
                    function ReportSynergyOP()
                    {
                      var ReportWeek = $('#sWk').val(); 
                      var ReportQtr = $('#sQt').val(); 
                      var FirstWeekDay = $('#sDy').val(); 
                      var DaysOfRtpWeek = $('#sDys').val(); 
                      if (ReportWeek < 1){ alert("Kindly select week"); return false;}
                      var sProduct = $('#sProduct').val(); 
                      if (sProduct < 1){ alert("Kindly select product you are reporting for. Thanks"); return false;}
                      

                      var cCus = $('#cCus').val(); 
                      var cProd = $('#cProd').val(); 
                      var cVal = $('#cVal').val(); 
                      var cStatus = $('#cStatus').val(); 
                     

                      if (cCus == "" || cProd == "" || cVal == "" || cStatus == "") { alert("Kindly fill form completely"); return false;}
                      
                      var formData = { sProduct:sProduct, ReportWeek:ReportWeek, ReportQtr:ReportQtr, FirstWeekDay:FirstWeekDay, DaysOfRtpWeek:DaysOfRtpWeek, 
                        cCus:cCus, cProd:cProd, cVal:cVal, cStatus:cStatus};
                        $.ajax({
                            type:"POST",
                            url: "addsynergyop",
                            data: formData,
                            //contentType: true,
                            //dataType: "json",
                            //cache: false,
                            //processData:false,
                            success: function (data) {
                            $('#cCus').val(""); 
                            $('#cProd').val(""); 
                            $('#cVal').val(""); 
                            $('#cStatus').val(""); 
                             
                            
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
                    <button type="button" onclick="ReportSynergyOP();" class="btn btn-primary pull-right">Report</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
    </div>

                </div><!-- ./box-body -->
               
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-md-12">
              <div class="box collapsed-box">
                <div class="box-header with-border">
                    <h4 class="box-title">[Actioned Items: Week of reporting], [Issues (Technical/Order submitted not showing)], [Action Items (Week in forecast)]</h4>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
      <div class="row">
             <div class="col-md-4">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#31FB82;">
                <div class="box-header">
                  <h3 class="box-title">Actioned Items: Week of reporting </h3> &nbsp;<i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label>Action</label>
                      <input type="text" class="form-control" name="aAction" id="aAction" placeholder="Report Action">
                    </div>
                                        
                  </div><!-- /.box-body -->
                    <script type="text/javascript">
                    function ReportAction()
                    {
                      var ReportWeek = $('#sWk').val(); 
                      var ReportQtr = $('#sQt').val(); 
                      var FirstWeekDay = $('#sDy').val(); 
                      var DaysOfRtpWeek = $('#sDys').val(); 
                      if (ReportWeek < 1){ alert("Kindly select week"); return false;}
                      var sProduct = $('#sProduct').val(); 
                      if (sProduct < 1){ alert("Kindly select product you are reporting for. Thanks"); return false;}
                      

                      var aAction = $('#aAction').val(); 
                      

                      if (aAction == "") { alert("Kindly fill form completely"); return false;}
                      
                      var formData = { sProduct:sProduct, ReportWeek:ReportWeek, ReportQtr:ReportQtr, FirstWeekDay:FirstWeekDay, DaysOfRtpWeek:DaysOfRtpWeek, 
                        aAction:aAction};
                        $.ajax({
                            type:"POST",
                            url: "addaction",
                            data: formData,
                            //contentType: true,
                            //dataType: "json",
                            //cache: false,
                            //processData:false,
                            success: function (data) {
                            $('#aAction').val(""); 
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
                    <button type="button" onclick="ReportAction();" class="btn btn-primary pull-right">Report</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
            <div class="col-md-4">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#31FB82;">
                <div class="box-header">
                  <h3 class="box-title">Issues (Technical/Order submitted not showing, booked not on hold, e.t.c) </h3> &nbsp;<i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label>Issue</label>
                      <input type="text" class="form-control" name="aIssues" id="aIssues" placeholder="Issues">
                    </div>
                    <div class="form-group">
                      <label>Party Action </label>
                      <input type="text" class="form-control" name="aParty" id="aParty" placeholder="">
                    </div>
                    <div class="form-group">
                      <label>Status</label>
                      <input type="text" class="form-control" name="iStatus" id="iStatus" placeholder="Issue Status">
                    </div>
                    
                    
                  </div><!-- /.box-body -->
                     <script>
                    function ReportIssues()
                    {
                      var ReportWeek = $('#sWk').val(); 
                      var ReportQtr = $('#sQt').val(); 
                      var FirstWeekDay = $('#sDy').val(); 
                      var DaysOfRtpWeek = $('#sDys').val(); 
                      if (ReportWeek < 1){ alert("Kindly select week"); return false;}
                      var sProduct = $('#sProduct').val(); 
                      if (sProduct < 1){ alert("Kindly select product you are reporting for. Thanks"); return false;}
                      

                      var aIssues = $('#aIssues').val(); 
                      var aParty = $('#aParty').val(); 
                      var iStatus = $('#iStatus').val(); 

                      if (aIssues == "" || aParty == "" || iStatus == "") { alert("Kindly fill form completely"); return false;}
                      
                      var formData = { sProduct:sProduct, ReportWeek:ReportWeek, ReportQtr:ReportQtr, FirstWeekDay:FirstWeekDay, DaysOfRtpWeek:DaysOfRtpWeek, 
                        aIssues:aIssues, aParty:aParty, iStatus:iStatus};
                        $.ajax({
                            type:"POST",
                            url: "addissues",
                            data: formData,
                            //contentType: true,
                            //dataType: "json",
                            //cache: false,
                            //processData:false,
                            success: function (data) {
                            $('#aIssues').val(""); 
                            $('#aParty').val(""); 
                            $('#iStatus').val(""); 
                             
                            
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
                    <button type="button" onclick="ReportIssues();" class="btn btn-primary pull-right">Report</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
            <div class="col-md-4">
              <!-- general form elements -->
              <div class="box box-primary" style="background:#31FB82;">
                <div class="box-header">
                  <h3 class="box-title">Action Items (Week in forecast) </h3> &nbsp;<i class="fa fa-cogs"></i>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="form-group col-md-6">
                      <label>Action Item</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" name="ActionItem" id="ActionItem" placeholder="Action Item">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Action Party</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" name="ActionParty" id="ActionParty" placeholder="Action Party">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Status</label>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" name="ActionStatus" id="ActionStatus" placeholder="Action Status">
                    </div>
                     <div class="form-group">
                      <label>Comments/Impact Expected</label>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="ActionComments" id="ActionComments" placeholder="Comments">
                    </div>
                  </div><!-- /.box-body -->
                    <script>
                    function ReportActionForcast()
                    {
                      var ReportWeek = $('#sWk').val(); 
                      var ReportQtr = $('#sQt').val(); 
                      var FirstWeekDay = $('#sDy').val(); 
                      var DaysOfRtpWeek = $('#sDys').val(); 
                      if (ReportWeek < 1){ alert("Kindly select week"); return false;}
                      var sProduct = $('#sProduct').val(); 
                      if (sProduct < 1){ alert("Kindly select product you are reporting for. Thanks"); return false;}
                      

                      var ActionI = $('#ActionItem').val(); 
                      var ActionP = $('#ActionParty').val(); 
                      var ActionS = $('#ActionStatus').val(); 
                      var ActionC = $('#ActionComments').val(); 

                      if (ActionI == "" || ActionP == "" || ActionS == "" || ActionC == "") { alert("Kindly fill form completely"); return false;}
                      
                      var formData = { ReportWeek:ReportWeek, ReportQtr:ReportQtr, FirstWeekDay:FirstWeekDay, DaysOfRtpWeek:DaysOfRtpWeek, 
                        ActionI:ActionI, ActionP:ActionP, ActionS:ActionS, ActionC:ActionC};
                        $.ajax({
                            type:"POST",
                            url: "addactionforcast",
                            data: formData,
                            //contentType: true,
                            //dataType: "json",
                            //cache: false,
                            //processData:false,
                            success: function (data) {
                            $('#ActionItem').val(""); 
                            $('#ActionParty').val(""); 
                            $('#ActionStatus').val(""); 
                            $('#ActionComments').val(""); 
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
                    <button type="button" onclick="ReportActionForcast();" class="btn btn-primary pull-right">Report</button>
                  </div>
                </form>
              </div><!-- /.box -->
            </div> <!-- left column -->
    </div>
    
                </div><!-- ./box-body -->
               
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          
                 
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
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