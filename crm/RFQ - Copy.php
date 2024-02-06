<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$result = mysql_query("SELECT * FROM notification WHERE StaffID='".$_SESSION['uid']."'");
//check if user exist
$NoRowMsg = mysql_num_rows($result);
$FullName = $_SESSION['Firstname'] . " " .$_SESSION['SurName'];
$msg = "";
if ($NoRowMsg > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($result)) {
	$msg .= '<li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> '.$row{'Message'}.'
                        </a>
                      </li>';
	}
	
}

if ($_SESSION['Dept'] == "superadmin" || $_SESSION['Dept'] == "internalsales" )
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];



  
  
$resultRFQ = mysql_query("SELECT * FROM rfq");
//check if user exist
 $NoRowRFQ = mysql_num_rows($resultRFQ);

 $resultRFQ1 = mysql_query("SELECT * FROM rfq WHERE Status='OPEN'");
//check if user exist
 $NoRowRFQ1 = mysql_num_rows($resultRFQ1);
 
$resultCUS = mysql_query("SELECT * FROM customers");
//check if user exist
 $NoRowCUS = mysql_num_rows($resultCUS);
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);

 if ($_GET['sRFQ'] == "")
 {}
 else
 {
 $resultLI = mysql_query("SELECT * FROM lineitems WHERE RFQCode='".$_GET['sRFQ']."'");
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
 }

	

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>PLANT E.R.P | Dashboard</title>
	<link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="./" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="../mBOOT/plant.png" width="50" height="50" /></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"> <img src="../mBOOT/plant.png" style ="width:40px; height:40px;"/></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">0</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 0 messages</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                  
                    </ul>
                  </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning"><?php echo $NoRowMsg; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have <?php echo $NoRowMsg; ?> notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                     <?php echo $msg; ?>
                     
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger">0</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 0 tasks</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                    
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">View all tasks</a>
                  </li>
                </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 <?php echo '<img src="data:image/jpeg;base64,'. base64_encode($prasa). '" class="user-image" alt="User Image">'; ?>
                  <span class="hidden-xs"><?php echo $_SESSION['SurName']. " ". $_SESSION['Firstname']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <?php echo '<img src="data:image/jpeg;base64,'. base64_encode($prasa). '" class="img-circle" alt="User Image">'; ?>
                    <p>
					  <?php echo $_SESSION['SurName']. " ". $_SESSION['Firstname']." - ". $_SESSION['Dept']; ?>
                      
                      <small>Registered since <?php echo $_SESSION['DateReg']; ?></small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Colleague</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Co Worker</a>
                    </div>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="../users/lockscreen" class="btn btn-default btn-flat">Lock screen</a>
                    </div>
                    <div class="pull-right">
                      <a href="../users/logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>-->
            </ul>
          </div>

        </nav>
      </header>
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
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
              <a href="../internalsales">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
			<li class="treeview">
              <a href="aRFQ">
                   <i class="fa fa-cog"></i><span>All RFQ</span></i>
              </a>
            </li>
			
			<li class="active">
              <a href="RFQ">
                   <i class="fa fa-download"></i><span>Receive RFQ</span></i>
              </a>
            </li>
			
			<li class="treeview">
              <a href="addLi">
                   <i class="fa fa-plus"></i><span>Add Line Item</span></i>
              </a>
            </li>
			
			<li class="treeview">
              <a href="sndRFQ">
                   <i class="fa fa-upload"></i><span>Send RFQ</span></i>
              </a>
            </li>
			
			<li class="treeview">
              <a href="LineItems">
                   <i class="fa fa-edit"></i> <span>Unattended Line Items</span></i>
              </a>
            </li>
			<li class="treeview">
              <a href="Q">
                   <i class="fa fa-bolt"></i> <span>Quote Item(s)</span></i>
              </a>
            </li>
			
			<li class="treeview">
              <a href="printQ">
                  <i class="fa fa-print"></i> <span>Print Quotation</span></i>
              </a>
			 
            </li>
			
                     
            <li class="header">USER</li>
            <li><a href="../users/logout"></i><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
            <li><a><i class="fa ion-edit"></i> <span>Change Password</span></a></li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Receive RFQ
            <small>Version 2.0</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../internalsales"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Receive RFQ</li>
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
  
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Receive request for quotation</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#00C6C6;">
                      <p class="text-center">
                        <strong></strong>
                      </p>
                     <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="regRFQ" method="post">
          <div class="form-group has-feedback" style="width:40%; display: inline-block;">
		  <select class="form-control" id="RFQSource" name="RFQSource" required>
			<option value=""> Choose Source</option>
			<option value="Email"> Email</option>
			<option value="Portal"> Portal</option>
			<option value="Others"> Others</option>
			
			</select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>
		  
		   <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
		    <select class="form-control" id="RFQScope" name="RFQScope" required>
			<option value=""> Scope Check</option>
			<option value="Out"> Out of Scope</option>
			<option value="Within"> Within Scope</option>
			
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>
         
		  <div class="form-group has-feedback" style="width:40%; display: inline-block;">
           
			 <!-- Date range -->
                  <div class="form-group">
                    <label>Date for quote ellapsed?:</label>
					<div class="input-group" style="width:100%;">
                    <select class="form-control" id="RFQEllapes" name="RFQEllapes" required >
					<option value="No"> No</option>
					<option value="Yes">Yes</option>
					</select> <span class="glyphicon glyphicon-dashboard form-control-feedback"></span>
					 </div><!-- /.input group -->
				 </div><!-- /.form group -->
          </div>
		  
		  <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
            <span class="glyphicon glyphicon-calender form-control-feedback"></span>
			 <!-- Date range -->
                  <div class="form-group">
                    <label>Date range:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="reservation" name="reservation" required />
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
          </div>
<script>
function MakeRFQ()
    {
	
	var Customernme = document.getElementById('RFQCus').options[document.getElementById('RFQCus').selectedIndex].text;
	
	var PEAStaffnme = '<?php echo $FullName; ?>';
	//var PEAStaffnme = document.getElementById('PEAss').options[document.getElementById('PEAss').selectedIndex].text;;
	var RFQYear = 15;//<?php echo date('year');?>;
	var snRFQ = <?php echo $NoRowRFQ; ?>;
	var RFQNo = document.getElementById('ReqNo').value;
	
	//Let's refine string for RFQ generation
	var RFQcus = Customernme.substring(0,2); 
	var RFQstaff = PEAStaffnme.split(" ");
	var RFQstaff1 = RFQstaff[0];
	var RFQstaff2 = RFQstaff[1];
	RFQstaff = RFQstaff[0].substring(0,1) + RFQstaff[1].substring(0,1);
	//Final RFQ Number 
	var RFQNumber = "PE" + RFQstaff +  RFQYear + "/" + snRFQ + "_" + RFQcus + "_" + RFQNo;
	//alert(RFQNumber);
	document.getElementById('RFQNo').value = RFQNumber; 
	
    }	

</script>	
<script>

</script>	
<script language="javascript">
        function open_container()
        {
            var size='standart';
            var content = '<form role="form" action="www.google.com"><div class="form-group">' +
			'<div class="form-group has-feedback" >' +
            '<select class="form-control" id="LICurr" name="LICurr" required>' +
			'<option value=""> Choose Supplier</option>' +
			'<option value="NGN"> NGN</option>' +
			'<option value="USD"> USD</option>' +
			'</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>' +
            '</div>' +
			'<div class="form-group has-feedback" >' +
            '<select class="form-control" id="LICurr" name="LICurr" required>' +
			'<option value=""> Choose Currency</option>' +
			'<option value="NGN"> NGN</option>' +
			'<option value="USD"> USD</option>' +
			'</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>' +
            '</div>' +
			'<input type="text" class="form-control" id="LIPrice" name="LIPrice" placeholder="Unit Price" onKeyPress="return isNumber(event)" required />' +
			'</div>'+
			'<div class="form-group"><input type="text" class="form-control" id="exampleInputPassword1" placeholder="Quotation Note"></div>' +
			
			'<button type="submit" class="btn btn-primary">Save changes</button></form>';
            var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
        }
        function setModalBox(title,content,footer,$size)
        {
            document.getElementById('modal-bodyku').innerHTML=content;
            document.getElementById('myModalLabel').innerHTML=title;
            document.getElementById('modal-footerq').innerHTML=footer;
           
            
                $('#myModal').attr('class', 'modal fade')
                             .attr('aria-labelledby','myModalLabel');
                $('.modal-dialog').attr('class','modal-dialog');
           
        }
        </script>	
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

		   <div class="form-group has-feedback" style="width:82%; display: inline-block;">
		    <select class="form-control" id="RFQCus" name="RFQCus" onChange="MakeRFQ()"required >
			<option value=""> Choose Customer</option>
			<?php if ($NoRowCUS > 0) 
						{
							//fetch tha data from the database
							while ($row = mysql_fetch_array($resultCUS)) {
							?>
							<option value="<?php echo $row['CustormerNme']; ?>"> <?php echo $row['CustormerNme']; ?></option>
							<?php
							}
							
						}
																
			?>
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>
		  
		  <!-- <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="PEAss" name="PEAss" onchange="MakeRFQ()" required >
			<option value=""> Assign PE staff</option>
			
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>-->
		   
		 <div class="form-group has-feedback" style="width:83%; display: inline-block; ">
		   <textarea rows="4" cols="50" placeholder=" Enter comment here..." id="Comment" name="Comment" style="width:100%; display: inline-block;"></textarea>
		 </div>
		  
                    </div><!-- /.col -->
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>RFQ Requisition number</strong>
                      </p>
			<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="ReqNo" name="ReqNo" onInput="MakeRFQ()" placeholder="Requisition number"  required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
		  <p class="text-center">
                        <strong>RFQ number</strong>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="RFQNo" name="RFQNo" placeholder="RFQ Number" ReadOnly required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
<br>
			<p class="text-center">
                        <strong>Attach RFQ Document (Optional)</strong>
                      </p>
			<div class="form-group has-feedback">
            <input type="file" id="RFQFile" name="RFQFile" class="form-control" />
			
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>		  
          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div><!-- /.col -->
          </div>
                      </form> 
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
                  <h3 class="box-title">Add Line Item to RFQ</h3>
				 
				  
    

                  <div class="box-tools pull-right">
                   <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
		
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
			 <form method="POST" action="reglineitem">
   <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="LIRFQ" name="LIRFQ" onChange="ReadLineItem(this)" required >
			<option value=""> Choose RFQ code</option>
			<?php if ($NoRowRFQ1 > 0) 
						{
							//fetch tha data from the database
							while ($row = mysql_fetch_array($resultRFQ1)) {
							
							?>
							<option value="<?php echo $row['RFQNum']; ?>"  <?php if ($_GET['sRFQ'] == $row['RFQNum']) { echo "selected";} ?>> <?php echo $row['RFQNum']; ?></option>
							<?php
							}
							
						}
																
			?>
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>
		
		<!--<section class="main2">
		<span class="search">
		 <input type="text" name="q" placeholder="Search..." />
		 <ul class="results" id="result" >
			
		 </ul>
		</span>
		</section>-->
		
		<div class="form-group has-feedback" style="width:18%; display: inline-block; margin:12px;">
            <span class="search">
            <input style="width:100%" type="text" class="form-control1  " id="RFQ" name="RFQ" placeholder="RFQ Code Search..." onInput="searchrfq(this)" />
			
			 <ul class="results" id="resultRFQ" >
				
			 </ul>
		</span>	
		</div>
		<div class="form-group has-feedback" style="width:18%; display: inline-block; margin:12px;">
            <input type="text" class="form-control" id="LIMS" name="LIMS" placeholder="Material/Services" onInput="searchit(this)" required />
			
            <span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
        </div>
		<div class="form-group has-feedback" style="width:18%; display: inline-block; margin:12px;">
            <input type="text" class="form-control" id="LIQty" name="LIQty" placeholder="Quantity" onKeyPress="return isNumber(event)" required />
            <span class="glyphicon glyphicon-sort-by-order-alt form-control-feedback"></span>
          </div>
		<div class="form-group has-feedback" style="width:18%; display: inline-block; margin:12px;">
            <input type="text" class="form-control" id="LIUOM" name="LIUOM" placeholder="UOM" required />
            <span class="glyphicon glyphicon-resize-small form-control-feedback"></span>
        </div>
		
		
		  
		<div id="DyForm" class="form-group has-feedback" style="width:90%; display:block; margin:12px;">
		    <label>Desciption of Line Item: </label>
		<span class="search">
            <textarea id="LIDes" name="LIDes" onkeypress="searchDes(this)" placeholder="Description of Line Item" required ></textarea>
		
		 <ul class="results" id="result" >
			
		 </ul>
		</span>		

        </div>
		<div class="form-group has-feedback" style="width:10%; display:inline-block; margin:12px;">
		    <button type="submit" class="btn btn-primary btn-block btn-flat">Add Line Item</button>
           </div>
		
		  </form>
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
	 if ($NoRowLI > 0) {
	while ($row = mysql_fetch_array($resultLI)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	  $LitID = $row{'LitID'};
	  $MatSer = $row['MatSer'];
	  $Description = $row ['Description'];
	  $Qty = $row ['Qty'];
	  $UOM = $row ['UOM'];
	  $Price = $row ['Price'];
	  $Currency = $row ['Currency'];
	  $RFQn = $row ['RFQCode'];
	  
	  $RIDn = "'#".$LitID."'";
	  $RIDU = "'#".$LitID."U'";
		
	    $Record .='
					 <tr>
					    <td>'.$LitID.'</td>
						<td>'.$MatSer.'</td>
						<td>'.$Description.'</td>
						<td>'.$Qty.'</td>
						<td>'.$UOM.'</td>
						 </tr>';
						
     }
}
?>	

              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Material/Service</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>UOM</th>
                       
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>S/N</th>
                        <th>Material/Service</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>UOM</th>
						
                       
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
		
		
		
		
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; 2014-2015 <a href="http://elchabod.com">Elchabod IT World</a>.</strong> All rights reserved.
      </footer>

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
    <script type="text/javascript">
      $(function () {
        $("#userTab").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
	<script type="text/javascript">
      $(function () {
        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        //$('#reservation').daterangepicker();
        $('#reservation').daterangepicker({
   // "startDate": "11/29/2015",
   // "endDate": "12/05/2015",
    "minDate": new Date()
});
		// $("#endDate").datepicker("option", "minDate", testm);
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
                {
                  ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                  },
                  startDate: moment().subtract('days', 29),
				  //minDate: '2015-05-12',
                  endDate: moment()
                },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        
       

       
      });
    </script>

  
	
  </body>
</html>