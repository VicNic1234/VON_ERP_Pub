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

{
     if ($_POST['searchso'])
        {
          $fmfrmDate = mysql_real_escape_string(trim(strip_tags($_POST['frmDate'])));
          $fmYear = mysql_real_escape_string(trim(strip_tags($_POST['frmYear'])));
          //$fmtoDate = mysql_real_escape_string(trim(strip_tags($_POST['toDate'])));
          $fmCusSO = mysql_real_escape_string(trim(strip_tags($_POST['CusSO'])));
            
          if($fmCusSO == "All")
          {
            $resultRFQ= mysql_query("SELECT * FROM rfq LEFT JOIN users
            ON rfq.PEAID=users.uid WHERE LEFT(DateCreated,4) = '$fmYear' /*WHERE STR_TO_DATE(DateCreated, '%Y-%m-%d') between '$fmfrmDate' and '$fmtoDate'*/ Order By RFQid DESC");
          }
          else
          {
            $resultRFQ= mysql_query("SELECT * FROM rfq LEFT JOIN users
            ON rfq.PEAID=users.uid WHERE rfq.Customer='".$fmCusSO."' AND LEFT(DateCreated,4) = '".$fmYear."' Order By RFQid DESC");
            /*AND STR_TO_DATE(DateCreated, '%Y-%m-%d') between '$fmfrmDate' and '$fmtoDate'*/
          //echo $fmCusSO; exit; WHERE rfq.Customer='CN'
          }
//exit;
         
        }
    else
        {
         $resultRFQ= mysql_query("SELECT * FROM rfq INNER JOIN users
          ON rfq.PEAID=users.uid ORDER BY rfq.RFQid DESC");
 
         //exit;
        }
//check if user exist
 $NoRowRFQ = mysql_num_rows($resultRFQ);
 
 }


$resultCus = mysql_query("SELECT * FROM customers");
$NoRowCus = mysql_num_rows($resultCus);
     if ($NoRowCus > 0) {
  while ($row = mysql_fetch_array($resultCus)) 
  {
    $Customer1 = $row ['CustormerNme'];
    $cussnme = $row ['cussnme'];

    if($fmCusSO == $cussnme)
    {
      $CusR .= '<option value="'.$cussnme.'" selected >'.$Customer1.'</option>';
    }
    else
    {
      $CusR .= '<option value="'.$cussnme.'" >'.$Customer1.'</option>';
    }
  }
}
  
  

 
 {
    
   // $resultRFQ= mysql_query("SELECT * FROM rfq INNER JOIN users
   // ON rfq.PEAID=users.uid ORDER BY rfq.RFQid DESC");
//check if user exist WHERE Status='OPEN'
    //$NoRowRFQ = mysql_num_rows($resultRFQ);
 }

	

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | All RFQ</title>
	<link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- StyleSheet
    <link href="../plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"></script>
    <link href="../plugins/datatables/buttons.dataTables.min.css" rel="stylesheet" type="text/css"></script> -->
	 <!-- Font Awesome Icons -->
    <link href="../mBOOT/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../mBOOT/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
     <!-- DatePicker -->
    <link href="../mBOOT/jquery-ui.css" rel="stylesheet">
  
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
<style type="text/css" media="print">
      @page { size: landscape; }
       @media print{a[href]:after{content:none}}
    </style>
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
            All RFQ
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
	 if ($NoRowRFQ > 0) {
	while ($row = mysql_fetch_array($resultRFQ)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	  $RFQid = $row{'RFQid'};
	  $RFQNum = $row['RFQNum'];
	  $Customer = $row ['Customer'];
	  $Scope = $row ['Scope'];
	  $DateRange = $row ['DateRange'];
	  $Source = $row ['Source'];
    $Comment = $row ['Comment']; //$RFQUpD
	  $RFQUpD = $row ['RFQUpdate']; //$RFQUpD
	  $Ellapes = $row ['Ellapes'];
	  $DateCreated = $row ['DateCreated'];
	 //$Attachment = $row ['Attachment'];
	  $PEAssignee = $row ['Surname'] . " " . $row ['Firstname'];
    $Attachlnk = $row ['Attachment'];
    $OnTQ1 = $row ['OnTQ'];
    if ($OnTQ1 == 1){
     $OnTQ = '<input  type="checkbox" checked title="Remove from TQ" r="'.$RFQid.'" jm="hpc'.$RFQid.'" id="hplg'.$RFQid.'" onclick="setOnTQ(this);"></input>';
    }else{
     $OnTQ = '<input  type="checkbox" title="Set on TQ" r="'.$RFQid.'" jm="hpc'.$RFQid.'" id="hplg'.$RFQid.'" onclick="setOnTQ(this);"></input>';
	   }
      //$Al2 = '<a href="'.$Attachlnk.'" target="_blank"> <i class="fa fa-plus" r="'.$RFQid.'"></i> </a>';
	    $Record .='
					 <tr>
					    <td>'.$SN.'</td>
						<td>'.$RFQNum.'</td>
						<td>'.$Customer.'</td>
						<td>'.$Scope.'</td>
						<td>'.$PEAssignee.'</td>
						<td>'.$Source.'</td>
						<td>'.$DateRange.'</td>
						<td>'.$Comment.'</td>
            <td>'.$Ellapes.'</td>
						<td>'.$OnTQ.'</td>
						<td>'.$DateCreated.'</td>
          
            <td class="noExl"><a '.  'onclick="open_container('.$RFQid.',\''.$RFQNum.'\',\''.$Customer.'\',\''.$PEAssignee.'\',\''.$RFQid.'\',\''.$RFQid.'\',\''.$RFQid.'\',\''.$RFQid.'\',\''.$RFQid.'\',\''.$RFQid.'\',\''.$RFQid.'\',\''.$RFQid.'\',\''.$RFQid.'\',\''.$RFQid.'\',\''.$RFQid.'\',\''.$DateRange.'\',\''.$DateCreated.'\',\''.$RFQUpD.'\',\''.$Attachlnk.'\');">'. '<span class="fa fa-edit"></span> | <span class="fa fa-plus"></span></a></td>
            
						 </tr>';

             $SN = $SN + 1;
						
     }
}
?>	   
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
		
		    <div class="row">
            <!-- Left col -->
            <div class="col-md-12">
             

              <!-- TABLE: LATEST ORDERS -->
              <div class="box box-info" id="PrintAreaPMS">
                <div class="box-header with-border">
                  <h3 class="box-title">ALL RFQs</h3>
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <form action="" method="POST">
                  <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
                    <label>Choose Customer :</label>
                  <select onclick="chkCus(this);" name="CusSO" class="form-control" required >
                     <option value="All">All</option>
                     <?php echo $CusR; ?>
                    
                  </select>
                 </div>
                  <!--
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
                -->
                <div class="form-group has-feedback" style="width:150px; display: inline-block; margin:12px;">
                  <label>Year :</label>
                  <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                  <select class="form-control" id="frmYear" name="frmYear" required >
                    <option value="2016">2016</option>
                    <?php if($fmYear == '2017') { ?> 
                    <option value="2017" selected >2017</option>
                    <?php } else { ?>
                    <option value="2017">2017</option>
                      <?php } ?>

                    
                  </select>
                  
                  </div>
                
                  <div class="form-group has-feedback" style="width:150px; display: inline-block; margin:12px;">
                         <button type='submit' name='searchso' value="yes" id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                 </div>
                 <div class="form-group has-feedback" style="width:150px; display: inline-block; margin:12px;">
                         <button type='button' onclick="ExportToExcel()" name='expbnt' id='exp-btn' title="Export to Excel" class="btn btn-flat"><i class="fa fa-send"></i></button>
                 </div>
                 
                </form>
                     
                  </div>
                  <div class="table-responsive">
                     <table id="schdTab" data-tableName="RFQs" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th>S/N</th>
                        <th>RFQ No.</th>
                        <th>Customer</th>
                        <th>Scope</th>
                        <th>Staff Assigned</th>
                        <th>Source</th>
                        <th>Date Range</th>
                        <th>Comment</th>
                        <th>Elapsed</th>
                        <th>OnTQ</th>
                        <th>Date Created</th>
                        <th class="noExl">Update</th>
                       </tr>
                    </thead>
                    <tbody>
                       
                    <?php echo $Record; ?>
                    </tbody>
                   
                  </table>
                   
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                <!--<div class="box-footer clearfix no-print">
                  <a onclick="printDiv('PrintAreaPMS')" href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left"><i class="fa fa-print"></i> &nbsp; Print</a>
                  <a href="javascript::;" tabid="schdTabPMS" ptype="PMS" onclick="expExcel(this)" class="btn btn-sm btn-success btn-flat pull-right">Export to Excel</a>
                 
                </div>--><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->

          </div><!-- /.row -->
		
		
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <script type="text/javascript">
       function setOnTQ(relm)
   {
      
    var gh = $(relm).attr('r');
    var ghid = $(relm).attr('id');
    var URL = "";
    
    var dataString = 'rfq='+ gh;
    if($('#'+ghid).is(":checked") == true) {  URL = "setOnTQ1";  }
    else { URL = "setOnTQ0";  }
    
    $.ajax({
      type: "POST",
      url: URL,
      data: dataString,
      cache: false,
      success: function(html)
      {
            //$("#"+prind).prop('checked', false);
           // alert(html);
      }
      });
    
    
   }
      </script>
	  <script language="javascript">
         function MainComp()
     {
     var UnitCost = document.getElementById('LIUC').value;
     var ExCost = UnitCost * document.getElementById('LIQty').value;
     document.getElementById('ExCost').value = ExCost;
     //EEEEEEEE#####3333333
     var UnitWeight = document.getElementById('UnitWeight').value;
     var ExWeight = UnitWeight * document.getElementById('LIQty').value;
     document.getElementById('ExWeight').value = ExWeight;
     //TTTTTTT##### FOB HHHH
    var DiscoPer = document.getElementById('Disc').value;
    var ECost = document.getElementById('ExCost').value;
    var FOB1 = (DiscoPer * ECost)/ 100;
    var FOB = ECost - FOB1;
    document.getElementById('DiscC').value = FOB1;
    document.getElementById('FOB').value = FOB.toFixed(2);
    //KKKKKKKK PACKAGE ZZZZZZZZ
    var PackPer = document.getElementById('PackP').value;
    var FOBb = document.getElementById('FOB').value;
    var PackAmount = (PackPer * FOBb)/ 100;
    document.getElementById('PackA').value = PackAmount.toFixed(2);
    //KKKKK INSURANCE ZZZZZZ
    var InsurPer = document.getElementById('InsurP').value;
    var FOBb = document.getElementById('FOB').value;
    var InsurAmount = (InsurPer * FOBb)/ 100;
    document.getElementById('InsurA').value = InsurAmount.toFixed(2);
    document.getElementById('PreShip').value = InsurAmount.toFixed(2);
    
    //EEEEE FREIGHT HHHHHHHHHHH
    var FreightPer = document.getElementById('FreightP').value;
    var ExW = document.getElementById('ExWeight').value;
    var FreightAmount = FreightPer * ExW;
    document.getElementById('FreightA').value = FreightAmount.toFixed(2);
    // NNNN CIF, SUB TOTaL
    
    var CIF = (Number(FOB) + PackAmount + InsurAmount + FreightAmount);
    document.getElementById('CIF').value = CIF.toFixed(2);
    //HS Tariff Custom Duty
    var HS = document.getElementById('HSTariff').value
    
    var CusDuty = (CIF * HS)/100;
    var CusSub = (CusDuty * 7)/100;
    var ETLS = (CIF * 0.5)/100;
    var LocHand = (CIF * 5)/100;
    var markupCos = (CIF * document.getElementById('markupperc').value)/100;
    
    
    document.getElementById('CustomDuty').value = CusDuty.toFixed(2);
    document.getElementById('markupCos').value = markupCos.toFixed(2);
    document.getElementById('CusSub').value = CusSub.toFixed(2);
    document.getElementById('ETLS').value = ETLS.toFixed(2);
    document.getElementById('LocHand').value = LocHand.toFixed(2);
    
    //To get Local Cost
    var preship = Number(document.getElementById('PreShip').value);
    var cusdty = Number(document.getElementById('CustomDuty').value);
    var cussubch = Number(document.getElementById('CusSub').value);
    var etls = Number(document.getElementById('ETLS').value);
    var markpval = Number(document.getElementById('markupCos').value);
    var localhndle = Number(document.getElementById('LocHand').value);
    var LocCost = preship + cusdty + cussubch + etls + markpval + localhndle; 
    document.getElementById('LocCos').value = LocCost.toFixed(2);
    
    
    //To get DPP cost
    var DPPprice = LocCost + CIF;
    document.getElementById('DPPPrice').value = DPPprice.toFixed(2);
     }
     
    function CostComp()
    {
    var UnitCost = document.getElementById('LIUC').value;
    //alert(UnitCost);
    var ExCost = UnitCost * document.getElementById('LIQty').value;
     document.getElementById('ExCost').value = ExCost;
    }
    
    function WeightComp()
    {
    var UnitWeight = document.getElementById('UnitWeight').value;
    //alert(UnitCost);
    var ExWeight = UnitWeight * document.getElementById('LIQty').value;
     document.getElementById('ExWeight').value = ExWeight;
    }
    
    function FOBComp()
    {
    var DiscoPer = document.getElementById('Disc').value;
    var ECost = document.getElementById('ExCost').value;
    var FOB1 = (DiscoPer * ECost)/ 100;
    var FOB = ECost - FOB1;
    document.getElementById('DiscC').value = FOB1;
    document.getElementById('FOB').value = FOB;
    }
    
    function PackComp()
    {
    var PackPer = document.getElementById('PackP').value;
    var FOB = document.getElementById('FOB').value;
    var PackAmount = (PackPer * FOB)/ 100;
    document.getElementById('PackA').value = PackAmount.toFixed(2);
    
    }
    
    
    
        function open_container(rfqID, rfq, cus, staffa, qty, lides, uw, uc, ds, fp, hsc, hst, pp, ip, dw, dspan, dcrtd, preUpd, updt)
        {
      var title = 'RFQ NUMBER : '+rfq;
      //let's split hyperlink attachment
      var cleanlink = "";
      var attchs = updt.split("</br>");
      var i1;
       for (i1 = 1; i1 < attchs.length; i1++) {
          cleanlink += "<a title='"+attchs[i1]+"' href='"+attchs[i1]+"' target='_blank'> [Download Attach] </a>";
                                                                
      } 
            var size='large';
            var content = '<form enctype="multipart/form-data" role="form" method="post" action="addRFQUp"><div class="form-group">' +
            '<label>Previous Updates: '+preUpd+'</label> </br></br>'  +
     
      
      
      '<div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">' +
        '<label>Customer</label>' +
      '<input type="text" class="form-control" id="Cus" name="Cus" placeholder="Customer" value="'+ cus +'" readonly />' +
      '<input type="hidden" class="form-control" id="rfqID" name="rfqID" value="'+ rfqID +'"/>' +
      '<input type="hidden" class="form-control" id="rfqNUM" name="rfqMUN" value="'+ rfq +'"/>' +
      
      '</div>'+

      '<div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">' +
      '<label>RFQ Number</label>' +
      '<input type="text" class="form-control" id="rfqNUM" name="rfqNewMUN" value="'+ rfq +'"/>' +
      '</div>'+
      
       '<div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">' +
        '<label>Staff Assigned</label>' +
      '<input type="text" class="form-control" id="StaffA" name="StaffA" placeholder="Staff Assigned" value="'+ staffa +'" readonly />' +
      '</div>'+
      
      '<div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">' +
        '<label>Date Created</label>' +
      '<input type="text" class="form-control" id="dCrtd" name="dCrtd" placeholder="" value="'+ dcrtd +'" readonly />' +
      '</div>'+
       '<div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">' +
        '<label>RFQ Span</label>' +
      '<input type="text" class="form-control" id="StaffA" name="StaffA" placeholder="" value="'+ dspan +'" readonly />' +
      '</div>'+


      '<div class="form-group has-feedback" style="width:90%; display:inline-block; margin:12px;">'+
      '<label>Previous Attachs: '+ cleanlink +'</label> </br></br>'  +
      '<br/>' + 
      '</div>' + 

      '<div class="form-group has-feedback" style="width:90%; display:inline-block; margin:12px;">'+
      '<label>Attach Document (Optional) </label>' +
      '<input type="file" id="RFQFile" name="RFQFile" class="form-control" />'+
      '</div>' + 
      
      
      '<div class="form-group has-feedback" style="width:90%; display:inline-block; margin:12px;">'+
      '<label>Enter Comment: </label>' +
      '<textarea required class="form-control" id="RFQUpdate" name="RFQUpdate" placeholder="Enter recent RFQ Update" required ></textarea>' +
      '</div>' +
      
      
      '<button type="submit" style="margin:12px;" class="btn btn-primary">Update RFQ Status</button></form>';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
      MainComp();
        }
        function setModalBox(title,content,footer,$size)
        {
            document.getElementById('modal-bodyku').innerHTML=content;
            document.getElementById('myModalLabel').innerHTML=title;
            document.getElementById('modal-footerq').innerHTML=footer;
           
            if($size == 'large')
            {
                $('#myModal').attr('class', 'modal fade bs-example-modal-lg')
                             .attr('aria-labelledby','myLargeModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-lg');
            }
            if($size == 'standart')
            {
                $('#myModal').attr('class', 'modal fade')
                             .attr('aria-labelledby','myModalLabel');
                $('.modal-dialog').attr('class','modal-dialog');
            }
            if($size == 'small')
            {
                $('#myModal').attr('class', 'modal fade bs-example-modal-sm')
                             .attr('aria-labelledby','mySmallModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-sm');
            }
        }
        </script> 
      

      <?php include('../footer.php') ?>

      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>
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

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- FastClick -->
    <script src='../plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App 
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
	-->
	<!-- DATA TABES SCRIPT
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/jquery.dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/buttons.flash.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/jszip.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/pdfmake.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/vfs_fonts.js" type="text/javascript"></script>
    <script src="../plugins/datatables/buttons.html5.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/buttons.print.min.js" type="text/javascript"></script> -->

     <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>

   
    <!--
    //code.jquery.com/jquery-1.12.4.js
https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js
https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js
//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js
//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js
//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js
//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js
//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js
//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js

-->
    <!--<script src="../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>-->
    <script src="../mBOOT/jquery-ui.js"></script>

     
    <script type="text/javascript">
      /*
      $(function () {
        $("#schdTab").dataTable(
          
          {
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false,
          dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]

        });
       
      });
      */

      $(document).ready(function() {
            

             $('#schdTab').DataTable({
              "bPaginate": true,
              "bLengthChange": true,
              "bFilter": true,
              "bSort": true,
              "bInfo": true,
              "bAutoWidth": false
               });
      });

      function ExportToExcel()
      {
        var Dat = "RFQ Report " + new Date();
        $("#schdTab").table2excel({
              exclude: ".noExl",
              name: "RFQ Report",
              filename: Dat,
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true
            });
      }
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