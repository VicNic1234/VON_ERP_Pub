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

include ('route.php');


$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];



  
  
$resultRFQ = mysql_query("SELECT * FROM rfq WHERE LEFT(DateCreated,4) = '2017'");
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
    <title>PENL ERP | Employees</title>
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
     <!-- DatePicker -->
  
  <link href="../mBOOT/jquery-ui.css" rel="stylesheet">

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
   
      <?php include('../topmenu2.php'); ?>
     <?php include('./leftmenu.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Employees
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../humanresources"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Employess</li>
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
              <div class="box collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">New Employee Official Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                   
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8">
                      <p class="text-center">
                        <strong>Staff's Details</strong>
                      </p>
                     <form enctype="multipart/form-data" action="regnew" method="post">
          <div class="form-group has-feedback" style="width:40%; display: inline-block;">
       <input type="text" class="form-control" id="Surname" name="Surname" placeholder="Surname"required />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
      
          </div>
       <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
       <input type="text" class="form-control" id="Fname" name="Fname" placeholder="First name"required />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
         
      <div class="form-group has-feedback" style="width:40%; display: inline-block;">
            
      <select class="form-control" id="Gender" name="Gender"placeholder="Gender" required>
      <option value=""> Choose Gender</option>
      <option value="Male"> Male</option>
      <option value="Female"> Female</option>
      
      </select>
            <span class="glyphicon glyphicon-gender form-control-feedback"></span>
          </div>
      
       <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
            <input type="text" class="form-control" id="DOB" name="DOB" placeholder="Date of Birth" required />
            <span class="glyphicon glyphicon-calender form-control-feedback"></span>
          </div>
      
       <div class="form-group has-feedback" style="width:40%; display: inline-block;">
            <input type="text" class="form-control" id="staffid" name="staffid" placeholder="Staff ID" required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
       <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
            <input type="text" class="form-control" id="staffphn" name="staffphn" placeholder="Staff Phone" required />
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
       <div class="form-group has-feedback" style="width:40%; display: inline-block;">
            <input type="email" class="form-control" id="staffmail" name="staffmail" placeholder="Email" required />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
      
      <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
            
      <select class="form-control" id="dept" name="dept" required>
      <option value=""> Choose Department</option>
      <option value="externalsales"> External Sales</option>
      <option value="internalsales"> Internal Sales</option>
      <option value="projectcontrols"> Project Controls</option>
      <option value="purchasing"> Purchasing</option>
      <option value="logistics"> Logistics</option>
      <option value="warehousing"> Warehousing</option>
      <option value="accounts"> Accounts</option>
      <option value="fieldservices"> Field Services</option>
      <option value="humanresources"> Human Resources</option>
      <option value="informationtechnology"> Information Technology</option>
      <option value="admin"> ADMIN</option>
      
      </select>
            <span class="glyphicon glyphicon-gender form-control-feedback"></span>
          </div>
      
       <div class="form-group has-feedback" style="width:40%; display: inline-block;">
            
      <select class="form-control" id="staffrole" name="staffrole" required>
      <option value=""> Role</option>
      <option value="user"> user</option>
      <option value="admin"> admin</option>
      
      </select>
            <span class="glyphicon glyphicon-gender form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
            <input type="password" class="form-control" id="fpwsd" name="fpwsd" placeholder="First Login Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          
         
              
                    </div><!-- /.col -->
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Staff Image</strong>
                      </p>
      <center><img id="uploadPreview" class="img-circle" style="width: 200px; height: 200px;" /></center>

<script type="text/javascript">

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("StaffPhoto").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

</script>
<br>
      <div class="form-group has-feedback">
            <input type="file" id="StaffPhoto" name="StaffPhoto" accept="image/jpg" class="form-control" onchange="PreviewImage();" placeholder="Passport" Required/>
      
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>      
          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-success btn-block btn-flat">Add Employee</button>
            </div><!-- /.col -->
          </div>
                      </form> 
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
    <script language="javascript">
              
        function open_container(uid, surnme, firstnme, gender, emai, phnn, staffid)
    
        {  
      var title = 'Edit '+surnme + ' ' +  firstnme +'\'s Info.';
      
            var size='standart';
            
            var content = '<form role="form" method="post" action="upduser" enctype="multipart/form-data" ><div class="form-group">' +
      '<div class="form-group has-feedback" style="width:100%;">' +
        '<label>First name: </label>' +
            '<input type="text" class="form-control" id="firstnme" name="firstnme" placeholder="Description of Line Item" value="'+ firstnme +'" ></input>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
      '</div>' +'<input type="hidden" name="uID" value="'+ uid +'" ></input>' +
      
      '<div class="form-group has-feedback" style="width:100%;">' +
        '<label>Surname: </label>' +
            '<input type="text" class="form-control" id="surnme" name="surnme" placeholder="Description of Line Item" value="'+ surnme +'" ></input>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
      '</div>' +
      '<label>Gender: </label>' +
      '<select class="form-control" id="Gender" name="Gender" placeholder="Gender" required>' +
      '<option value="'+gender+'" selected > '+gender+'</option>' +
      '<option value="Male"> Male</option>' +
      '<option value="Female"> Female</option>' +
      
      '</select>' +
      '<div class="form-group has-feedback" style="width:40%; display: inline-block;">' +
            'Staff ID: <input type="text" class="form-control" id="staffid" name="staffid" placeholder="Staff ID" value="'+staffid+'" required />' +
            
            '</div>' +
        '<div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">' +
            'Phone: <input type="text" class="form-control" id="staffphn" name="staffphn" placeholder="Staff Phone" value="'+phnn+'" required />' +
           
            '</div>' +
      '</div>'+
      '<label>Email </label>' +
      '<div class="form-group"><input type="text" class="form-control" id="LIemai" name="LIemai" value="'+ emai +'" placeholder="Enter email"></div>' +
      '<label>Photo </label>' +
      '<div class="form-group"><input type="file" class="form-control" id="StaffPhoto" name="StaffPhoto" placeholder="Staff Photo"></div>' +
      
      '<button type="submit" class="btn btn-primary">Save changes</button></form>';
           // var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
        }
    
    function Delete_LineItem(uid, surnme, firstnme, gender, emai, phn)
    
        {  
      var title = 'Are You Sure you want to DELETE user with ID no.: '+uid + ', in surnme No.: '+surnme;
      
            var size='standart';
            var content = '<form role="form" method="post" action="ruser"><div class="form-group">' +
      'Phone Number : <label>'+ phn  +'</label> </br>' +
      '<label>Note: After delete, you can never recover this user, thanks!  </label> </br>' +
      '<input type="hidden" name="uid" value="'+ uid +'" ></input>' +
      '<input type="hidden" name="LIsurnme" value="'+ surnme +'" ></input>' +
      
      '<button type="submit" class="btn btn-primary">Yes</button></form>';
           // var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
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

	
	       
          <div class="row">
            <!-- Left col -->
            <div class="col-md-12">
             

              <!-- TABLE: LATEST ORDERS -->
              <div class="box box-info" id="PrintAreaLPG">
                <div class="box-header with-border">
                  <h3 class="box-title">All Employees</h3>
                  <div class="box-tools pull-right no-print">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                     <table id="schdTabLPG" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th class="no-print">S/N</th>
                          <th class="no-print noExl">Action </th>
                          <th>First Name</th>
                          <th>Last Name</th>
                           <th>Email</th>
                          <th>Employee ID</th>
                          <th>Business Unit</th>
                          <th>Department</th>
                          <th>Status</th>
                          <th>Work Phone</th>
                          <th>Job Title</th>
                          <th>Reporting Manager</th>
                          <th>Contact Number </th>
                          <th>Employment Status </th>
                          <th>Role </th>
                         
                          
                        </tr>
                    </thead>
                    <tbody>
                       
                    <?php echo $SchdRecLPG; ?>
                    </tbody>
                   
                  </table>
                   
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                <div class="box-footer clearfix no-print">
                  <a onclick="printDiv('PrintAreaLPG')" href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left"><i class="fa fa-print"></i> &nbsp; Print</a>
                  <!--<a onclick="printAll()" href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left"><i class="fa fa-print"></i> &nbsp; Print All</a>-->
                  <a href="javascript::;" tabid="schdTabLPG" ptype="LPG" onclick="expExcel(this)" class="btn btn-sm btn-success btn-flat pull-right">Export to Excel</a>
                 
                </div><!-- /.box-footer -->
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
    <script src="../mBOOT/jquery-ui.js"></script>
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
   //Date Picker
      $(function () {
     //$('#DOB').datetimepicker();
     $( "#DOB" ).datepicker({
  inline: true,
  changeMonth: true,
    changeYear: true,
    yearRange: "1950:2014"

});
       
      });
    </script>

     <script type="text/javascript">
     

      function chkIhRFQ (relm)
   {
    
    var ghid = $(relm).attr('id');
   
    if($('#'+ghid).is(":checked") == true)
    {
      //document.getElementById('mirrior').display="inline-block";
      $('#mirrior').show();
      //alert("God's Grace");
    }
    else 
    {
      //document.getElementById('mirrior').display="none";
       $('#mirrior').hide();
    }
  }
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