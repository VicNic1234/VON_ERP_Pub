<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');



if ($_SESSION['AccessModule'] != "")
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

//AND (Customer='$fmCusSO')

 
 {
     if ($_POST['searchso'])
        {
          $fmfrmDate = mysql_real_escape_string(trim(strip_tags($_POST['frmDate'])));
          $fmtoDate = mysql_real_escape_string(trim(strip_tags($_POST['toDate'])));
          $fmCusSO = mysql_real_escape_string(trim(strip_tags($_POST['CusSO'])));

          if($fmCusSO == "All")
          {
            $resultRFQ= mysql_query("SELECT * FROM so LEFT JOIN users 
            ON so.SOAssignStaff=users.uid WHERE STR_TO_DATE(SOdate, '%m/%d/%Y') between '$fmfrmDate' and '$fmtoDate' Order By poID DESC");
          }
          else
          {
            $resultRFQ= mysql_query("SELECT * FROM so LEFT JOIN users 
            ON so.SOAssignStaff=users.uid WHERE Customer='$fmCusSO' AND STR_TO_DATE(SOdate, '%m/%d/%Y') between '$fmfrmDate' and '$fmtoDate' Order By poID DESC");
          }
//exit;
         
        }
    else
        {
         $resultRFQ= mysql_query("SELECT * FROM so LEFT JOIN users 
         ON so.SOAssignStaff=users.uid WHERE Status='0' Order By poID DESC");
        }
//check if user exist
 $NoRowRFQ = mysql_num_rows($resultRFQ);
 }


$resultCus = mysql_query("SELECT * FROM customers Order By CustormerNme");
$NoRowCus = mysql_num_rows($resultCus);
     if ($NoRowCus > 0) {
  while ($row = mysql_fetch_array($resultCus)) 
  {
    $Customer1 = $row ['CustormerNme'];
    if($fmCusSO == $Customer1)
    {
      $CusR .= '<option value="'.$Customer1.'" selected >'.$Customer1.'</option>';
    }
    else
    {
      $CusR .= '<option value="'.$Customer1.'" >'.$Customer1.'</option>';
    }
  }
}	

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Dashboard</title>
	<link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
     <!-- DatePicker -->
  
   <link href="../mBOOT/jquery-ui.css" rel="stylesheet">
	 <!-- daterange picker -->
    <link href="../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
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
<style>
/* * Copyright (c) 2012 Thibaut Courouble
 * Licensed under the MIT License
   ================================================== */



a {
    color: #1e7ad3;
    text-decoration: none;
}

a:hover { text-decoration: underline }

.container, .main2 {
    width: 40%;
    margin-left: auto;
    margin-right: auto;
    height: auto;
	padding-top:2px;
}

.main { margin-top: 50px }

textarea {
    font-family: 'HelveticaNeue', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 13px;
    color: #555860;
}

.search {
    position: relative;
    margin: 0 auto;
    width: 300px;
}

.search textarea {
    height: 80px;
    width: 100%;
    padding: 0 12px 0 25px;
    background: white url("http://cssdeck.com/uploads/media/items/5/5JuDgOa.png") 8px 6px no-repeat;
    border-width: 1px;
    border-style: solid;
    border-color: #a8acbc #babdcc #c0c3d2;
    border-radius: 13px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -o-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
    -moz-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
    -ms-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
    -o-box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
    box-shadow: inset 0 1px #e5e7ed, 0 1px 0 #fcfcfc;
}

.search textarea:focus {
    outline: none;
    border-color: #66b1ee;
    -webkit-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
    -moz-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
    -ms-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
    -o-box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
    box-shadow: 0 0 2px rgba(85, 168, 236, 0.9);
}

.search textarea:focus + .results { display: block }

.search .results {
    display: none;
    position: absolute;
    top: 35px;
    left: 0;
    right: 0;
    z-index: 10;
    padding: 0;
    margin: 0;
    border-width: 1px;
    border-style: solid;
    border-color: #cbcfe2 #c8cee7 #c4c7d7;
    border-radius: 3px;
    background-color: #fdfdfd;
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fdfdfd), color-stop(100%, #eceef4));
    background-image: -webkit-linear-gradient(top, #fdfdfd, #eceef4);
    background-image: -moz-linear-gradient(top, #fdfdfd, #eceef4);
    background-image: -ms-linear-gradient(top, #fdfdfd, #eceef4);
    background-image: -o-linear-gradient(top, #fdfdfd, #eceef4);
    background-image: linear-gradient(top, #fdfdfd, #eceef4);
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    -ms-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    -o-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.search .results li { display: block }

.search .results li:first-child { margin-top: -1px }

.search .results li:first-child:before, .search .results li:first-child:after {
    display: block;
    content: '';
    width: 0;
    height: 0;
    position: absolute;
    left: 50%;
    margin-left: -5px;
    border: 5px outset transparent;
}

.search .results li:first-child:before {
    border-bottom: 5px solid #c4c7d7;
    top: -11px;
}

.search .results li:first-child:after {
    border-bottom: 5px solid #fdfdfd;
    top: -10px;
}

.search .results li:first-child:hover:before, .search .results li:first-child:hover:after { display: none }

.search .results li:last-child { margin-bottom: -1px }

.search .results a {
    display: block;
    position: relative;
    margin: 0 -1px;
    padding: 6px 40px 6px 10px;
    color: #808394;
    font-weight: 500;
    text-shadow: 0 1px #fff;
    border: 1px solid transparent;
    border-radius: 3px;
}

.search .results a span { font-weight: 200 }

.search .results a:before {
    content: '';
    width: 18px;
    height: 18px;
    position: absolute;
    top: 50%;
    right: 10px;
    margin-top: -9px;
    background: url("http://cssdeck.com/uploads/media/items/7/7BNkBjd.png") 0 0 no-repeat;
}

.search .results a:hover {
    text-decoration: none;
    color: #fff;
    text-shadow: 0 -1px rgba(0, 0, 0, 0.3);
    border-color: #2380dd #2179d5 #1a60aa;
    background-color: #338cdf;
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #59aaf4), color-stop(100%, #338cdf));
    background-image: -webkit-linear-gradient(top, #59aaf4, #338cdf);
    background-image: -moz-linear-gradient(top, #59aaf4, #338cdf);
    background-image: -ms-linear-gradient(top, #59aaf4, #338cdf);
    background-image: -o-linear-gradient(top, #59aaf4, #338cdf);
    background-image: linear-gradient(top, #59aaf4, #338cdf);
    -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
    -moz-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
    -ms-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
    -o-box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
    box-shadow: inset 0 1px rgba(255, 255, 255, 0.2), 0 1px rgba(0, 0, 0, 0.08);
}

:-moz-placeholder {
    color: #a7aabc;
    font-weight: 200;
}

::-webkit-textarea-placeholder {
    color: #a7aabc;
    font-weight: 200;
}

.lt-ie9 .search textarea { line-height: 26px }
</style>

<script type="text/javascript">
function openso(elem)
{
  var OSID = $(elem).attr('r');
  //alert(OSID);
  $("#frm"+OSID).submit();
  //var dataString = 'OSID='+ OSID;
  /*   $.ajax({
  type: "POST",
  url: "EditSO.php",
  data: dataString,
  cache: false,
  success: function(html)
  {
   
  }
  }); */
}
</script>
<script type="text/javascript">
function searchit(mou)
{
var searchid = $(mou).val();
var dataString = 'search='+ searchid;
if(searchid!='' && searchid.length >= 3)
{
	$.ajax({
	type: "POST",
	url: "searchMS.php",
	data: dataString,
	cache: false,
	success: function(html)
	{
	$("#result").html(html).show();
	}
	});
}
if(searchid=='')
{
$("#result").html('').hide();
//return false;
}
return false;  

}

function searchDes(mou)
{
var searchid = $(mou).val();
var dataString = 'search='+ searchid;
if(searchid!='' && searchid.length >= 5)
{
	$.ajax({
	type: "POST",
	url: "searchDes.php",
	data: dataString,
	cache: false,
	success: function(html)
	{
	$("#result").html(html).show();
	}
	});
}
if(searchid=='')
{
$("#result").html('').hide();
//return false;
}
return false;  

}
function searchrfq(mou)
{
var searchid = $(mou).val();
var dataString = 'search='+ searchid;
if(searchid!='' && searchid.length >= 4)
{
	$.ajax({
	type: "POST",
	url: "searchRFQ.php",
	data: dataString,
	cache: false,
	success: function(html)
	{
	$("#resultRFQ").html(html).show();
	}
	});
}
if(searchid=='')
{
$("#resultRFQ").html('').hide();
//return false;
}
return false;  

}

function mcinfo(remit)
{
//alert($(remit).val());
var gh = $(remit).attr('r');
var gh2 = $(remit).attr('ms1');
$("#LIDes").val(gh);
$("#LIMS").val(gh2);
$("#result").html('').hide();
}
function litemsch(rfqv)
{
var uval = $(rfqv).attr('r');
window.location.href = "RFQ?sRFQ=" + uval;
}

</script>
  </head>
  <body class="skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper">

      <!-- Left side column. contains the logo and sidebar -->
      

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            All SO
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
         
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
  
          <div class="row">
            <div class="col-md-12">
              <div class="box">
               
                <div class="box-body">
                  <div class="row">
                    
          </div><!-- /.row -->
	
	
	<div class="row">
            <div class="col-md-12">
              <div class="box">
              
		
   <script type="text/javascript" >
	
	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function isEnterKey(evt) {
   // $("#LIDes").click(function(event) {
 // event.preventDefault();
//Do your logic here
});
}



  </script>
              <div class="box" style="display:block" id="ELineIt">
			 
			  </div>
		
<script>
function setdate()
{
  $("#toDate").datepicker("option", "minDate", $("#frmDate").val());
}

function chkfrm()
{
  if ($("#frmDate").val() == "") 
  {
    alert("Select from date first");
   // $("#frmDate").focus();
    //$("#frmDate").datepicker().show();
    $("#toDate").val("");
  }
}

function ReadLineItem(elem)
    {
       var hhh = elem.value;
       if (hhh != "")
       {       
        window.location.href ="RFQ?sRFQ=" + hhh;
        //window.alert("JKJ");
       }
    
    }   
</script>

<?php
//fetch tha data from the database
$SN = 1;
$TmAmt = 0.0;
	 if ($NoRowRFQ > 0) {
	while ($row = mysql_fetch_array($resultRFQ)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	  $poID = $row{'poID'};
	  $RFQNum = $row['SONum'];
	  $Customer = $row ['Customer'];
	  $CusONo = $row ['CusONo'];
    $ItN = $row ['ItemsN'];
    $Amt = $row ['Total'];
    $Amt1 = str_replace(',', '', $Amt);
	 
	 
	  //$DateCreated = $row ['DateCreated'];

    //At this point we need to pull out the currency
    ////////////////////////////////////////////////////////////
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
        $getCurrn = mysql_fetch_assoc(mysql_query("SELECT Currency FROM lineitems WHERE LitID = '".$LineITemID."'"));
        $CurrencyDetails = $getCurrn['Currency'];
        if($CurrencyDetails == "") { $CurrencyDetails = "USD"; }
        if($CurrencyDetails != "USD")
        {
        //We now need to Get the Conversion rate
        $getConvert = mysql_fetch_assoc(mysql_query("SELECT ExRateToUSD FROM currencies WHERE Abbreviation = '".$CurrencyDetails."'"));
        $CurrConvRate = $getConvert['ExRateToUSD'];

        $convTotal = $Amt1 * $CurrConvRate;
        //$convDiscount = $DTotal * $CurrConvRate;
      //$PODetails .= "Ext Price :". $POItem[2]. "<br>";
        }
        else {

          $convTotal = $Amt1;
          //$convDiscount = $DTotal;
        }
      }
    ////////////////////////////////////////////////////
      //Let's get Total

       $TmAmt = $TmAmt + $convTotal;
	 $Attachment = $row ['Attachment'];
	 $PEAssignee = $row ['Surname'] . " " . $row ['Firstname'];
	 $Attaclnk = '<a href="'.$Attachment.'" <i class="fa fa-eye" ></i> View Attachment </a>';
	
	    $Record .='
					 <tr>
					  <td>'.$SN.'</td>
						<td>'.$RFQNum.'</td>
						<td>'.$Customer.'</td>
						<td>'.$CusONo.'</td>
						<td>'.$PEAssignee.'</td>
            <td>'.$ItN.'</td>
            <td>'.$CurrencyDetails.'</td>
            <td>'. $Amt.'</td>
						<td>'. number_format($convTotal, 2).'</td>
						<td class="noExl">'.$Attaclnk.'</td> 
						
            <td class="noExl"><i class="fa fa-eye" r="'.$poID.'" onclick="openso(this);"></i><form id="frm'.$poID.'" method="GET" action="EditSO"><input type="hidden" name="SOID" value="'.$RFQNum.'" /></form></td>
						<td class="noExl"><i class="fa fa-check" r="'.$RFQid.'" onclick="crfq(this);"></i></td>
						 </tr>';

             $SN = $SN + 1;
						
     }
}
?>	

        <div class="box">
            <div class="box-header">
                <form action="" method="POST">
                  <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
                    <label>Choose Customer :</label>
                  <select onclick="chkCus(this);" name="CusSO" class="form-control" required >
                     <option value="All">All</option>
                     <?php echo $CusR; ?>
                    
                  </select>
                 </div>
                  
                  <div class="form-group has-feedback" style="width:150px; display: inline-block; margin:12px;">
                  <label>From :</label>
                  <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                         <input type="text" class="form-control" id="frmDate" value="<?php echo $fmfrmDate; ?>" name="frmDate" onchange="setdate();" required />
                  
                  </div>


                  <div class="form-group has-feedback" style="width:150px; display: inline-block; margin:12px;">
                  <label>To :</label>
                  <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                         <input type="text" class="form-control" id="toDate" name="toDate" value="<?php echo $fmtoDate; ?>" onchange="chkfrm();" required />
                  
                  </div>
                  <div class="form-group has-feedback" style="width:150px; display: inline-block; margin:12px;">
                         <button type='submit' name='searchso' value="yes" id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                 </div>
                 <div class="form-group has-feedback" style="width:150px; display: inline-block; margin:12px;">
                         <button type='button' onclick="ExportToExcel()" name='expbnt' id='exp-btn' title="Export to Excel" class="btn btn-flat"><i class="fa fa-send"></i></button>
                 </div>
                </form>
            </div><!-- /.box-header -->
                
                <div class="box-body">

                      <!-- Info boxes -->
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-ash"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Sales Order </span>
                  <span class="info-box-number"><?php echo $NoRowRFQ; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Amount</span>
                  <span class="info-box-number">$<small><?php echo number_format($TmAmt, 2); ?></small> </span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            
            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            
     

          </div><!-- /.row -->
                    <br/>
                  <div class="table-responsive">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>SO Code</th>
                        <th>Customer</th>
                        <th>Cus. O No.</th>
                        <th>Staff Assigned</th>
                        <th>No of Item</th>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>Amount ($)</th>
                        <th>Attachment</th>
            <th class="noExl">View</th>

                        
						<th>Close</th>
                       </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                       <th>S/N</th>
                        <th>RFQ No.</th>
                        <th>Customer</th>
                        <th>Cus. O No.</th>
                        <th>Staff Assigned</th>
                        <th>No of Item</th>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>Amount ($)</th>
                        <th class="noExl">Attachment</th>
                      
            <th class="noExl">View</th>
						<th class="noExl">Close</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
		
		
		
		
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
	 <!-- date-range-picker -->
    <script src="../mBOOT/moment.min.js" type="text/javascript"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
	 <!-- bootstrap time picker -->
    <script src="../plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <!-- InputMask -->
    <script src="../plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="../plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="../plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="../plugins/chartjs/Chart.min.js" type="text/javascript"></script>
	<!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>

    <script src="../mBOOT/jquery-ui.js"></script>
    <script type="text/javascript">
    function ExportToExcel()
      {
        var Dat = "SO Report " + new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "SO Report",
              filename: Dat,
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true
            });
      }
    </script>
    <script type="text/javascript">
      $(function () {
        $("#userTab").dataTable();
      });
    </script>

    <script type="text/javascript">
   //Date Picker
      $(function () {
         //$('#DOB').datetimepicker();
         $("#frmDate").datepicker({
         inline: true,
         dateFormat: 'yy-mm-dd'
         //minDate: new Date()
         });
      });

      //Date Picker
      $(function () {
         //$('#DOB').datetimepicker();
         $("#toDate").datepicker({
         inline: true,
         minDate: new Date(),
         dateFormat: 'yy-mm-dd'

         });
      });
    </script>
  
	
  </body>
</html>