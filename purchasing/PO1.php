<?php
session_start();
error_reporting(0);
if ($_SESSION['Dept'] == "superadmin" || $_SESSION['Dept'] == "purchasing" )
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';

  


 $resultLI = mysql_query("SELECT * FROM purchaselineitems"); //WHERE Status='OPEN'
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);

 $resultPOREQ = mysql_query("SELECT * FROM poreq WHERE Approved='1' AND Status = '0'");
//check if user exist
 $NoRowPOREQ = mysql_num_rows($resultPOREQ);
 

 $resultSUP1 = mysql_query("SELECT * FROM suppliers");
 $NoRowSUP1 = mysql_num_rows($resultSUP1);
 //////////////////////////////////////////////////////////
$SupRecord = "";
  if ($NoRowSUP1 > 0) {
	while ($row = mysql_fetch_array($resultSUP1)) {
	  $SupRNme = $row['SupNme'];
	  $SupID = $row['supid'];
	  $SupRecord .='<option value="'.$SupRNme.'">'.$SupRNme.'</option>';
						
     }
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
	 
	<!-- Font Awesome Icons -->
    <link href="../mBOOT/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../mBOOT/ionicons.min.css" rel="stylesheet" type="text/css" />
	 <!-- DatePicker -->
	<link href="../mBOOT/jquery-ui.css" rel="stylesheet">
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
                  <span class="label label-success">4</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 4 messages</li>
                  
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger">9</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 9 tasks</li>
                  
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
                      
                      <small>Registered on <?php echo $_SESSION['DateReg']; ?></small>
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
                      <a href="#">Co-worker</a>
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
              </li> -->
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
              <a href="./">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
			
			
			<li class="treeview">
              <a href="aRFQ">
                   <i class="fa fa-cog"></i><span>All RFQ</span></i>
              </a>
            </li>
			
			<li class="treeview">
              <a href="aPO">
                   <i class="fa fa-cog"></i><span>All PO</span></i>
              </a>
            </li>
			<li class="treeview">
              <a href="Qchk">
                   <i class="fa fa-download"></i><span>Prepare PO</span></i>
              </a>
            </li>

			<li class="active">
              <a href="PO">
                   <i class="fa fa-download"></i><span>Raise PO</span></i>
              </a>
            </li>
			
			<li class="treeview">
              <a href="PODetails">
                   <i class="fa fa-upload"></i><span>PO Details</span></i>
              </a>
            </li>
			
			<li class="treeview">
              <a href="sndPO">
                   <i class="fa fa-upload"></i><span>Send PO</span></i>
              </a>
            </li>
			
			<li class="treeview">
              <a href="">
                   <i class="fa fa-edit"></i> <span>Track PO</span></i>
              </a>
            </li>
			
			
           
                              
            <li class="header">USER</li>
            <li><a href="logout"></i><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
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
            Raise PO
            <small>Version 2.0</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Raise PO</li>
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
                  <h3 class="box-title">Raise Purchase Order</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#FFFFCC; margin: 12px; width:60%;">
                      <p class="text-center">
                        <strong></strong>
                      </p>
                     <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="regPO" method="POST">
           <div class="form-group has-feedback" style="width:40%; display: inline-block;">
		    <label>Supplier :</label>
		    <select class="form-control" id="POSup" name="POSup" onChange="MakePO(this)"required >
			<option value=""> Choose Supplier</option>
			<?php
			echo $SupRecord;
			?>
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>
		 
		 
		  <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
		  <label>Order Date :</label>
		  <span class="glyphicon glyphicon-calender form-control-feedback"></span>
             <input type="text" class="form-control" id="PODate" name="PODate" onChange="AddReq(this)" onClick="AddReq(this)" />
			
          </div>
		  
		
		  
		
<script>
/*function MakePO(elem)
    {
       var hhh = elem.value;
	var hhhy = hhh.substring(0,2); 
     var oldRFQ =  document.fRFQ.PONo.value;
	 if (oldRFQ.indexOf("_") > -1)
	// {  var n = oldRFQ.length - 4;
	 {  var n = oldRFQ.indexOf("_");
		var oldRFQ1 = oldRFQ.substring(0,n);
		document.fRFQ.PONo.value = oldRFQ1 + "_" + hhhy + "_" + document.fRFQ.PODate.value;
	 }
	 else
	 {document.fRFQ.PONo.value = oldRFQ + "_" + hhhy + "_" + document.fRFQ.PODate.value;}
	 
    }	

function AddReq(elem)
    {
       var hhh = elem.value;
	//var hhhy = hhh.substring(0,2); 
     var oldRFQ =  document.fRFQ.PONo.value;
	 if (oldRFQ.indexOf("_") > -1)
	// {  var n = oldRFQ.length - 4;
	 {  
	    var S = oldRFQ.split(/_/);
		var PEN = S[0];
		document.fRFQ.PONo.value = PEN + "_" + S[1] + "_" + document.fRFQ.PODate.value.trim();
	 }
	 else
	 {//DO NOTHING
	 }
	 
    }	*/
</script>	

		 
		  
		 
		   
		 <div class="form-group has-feedback" style="width:83%; display: inline-block; ">
		  <p class="text-center">
		  <br/>
		  <br/>
		  
                        <strong>Delivery Location :</strong>
                      </p>
		   <textarea rows="4" cols="50" placeholder="Delivery Location" id="DeliLoc" name="DeliLoc" style="width:100%;"> </textarea>
		 </div>
		            </div><!-- /.col -->
                    <div class="col-md-4">
                      
			
		  <p class="text-center">
                        <strong>Purchase Order No.:</strong>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="PONo" name="PONo" placeholder="PO Number" value="PO<?php $NoRowPO = $NoRowPO + 1; 
			echo substr($_SESSION['SurName'],0,1).substr($_SESSION['Firstname'],0,1).$NoRowPO."/". date("y")	; ?>" required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
 <p class="text-center">
                        <strong>Discount Amt: <i onclick="document.fRFQ.SubTotal.value = (document.fRFQ.SubTotal.value - document.fRFQ.DisAmt.value); document.fRFQ.sTotal.value = (Number(document.fRFQ.SubTotal.value) + Number(document.fRFQ.sTax.value)); document.fRFQ.rTotal.value = (Number(document.fRFQ.SubTotal.value) + Number(document.fRFQ.sTax.value)); document.getElementById('DisAmt').setAttribute('readOnly','true');" class="fa fa-plus" title = "Add Discount"></i></strong>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="DisAmt" name="DisAmt" placeholder="Discount Amount" onKeyPress="return isNumber(event)" value="" />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
<br>
 <p class="text-center">
                        <strong>Sub Total:</strong>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="SubTotal" name="SubTotal"  value="" ReadOnly />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
		  <br/>
<p class="text-center">
                        <strong>Tax:</strong>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="pTax" name="pTax"  onInput="document.fRFQ.sTax.value = ((document.fRFQ.SubTotal.value * document.fRFQ.pTax.value)/100);" onKeyPress="return isNumber(event)" Placeholder ="Tax Percentage"  />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
</div>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="sTax" name="sTax"  Value="" ReadOnly  />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
</div>
		  <br/>
		  
		 <p class="text-center">
                        <strong>Total:</strong>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="sTotal" name="sTotal" value="" ReadOnly />
            <input type="hidden" class="form-control" id="rTotal" name="rTotal" value="" ReadOnly />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
		  <br/>
			
					  
          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Create Purchase Order</button>
              </div><!-- /.col -->
          </div>
                     
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
                  <h3 class="box-title">Add Line Item to PO</h3>
				 
				  
    

                  <div class="box-tools pull-right">
                   <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
		
   <script type="text/javascript" >
	/*
	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function isEnterKey(evt) {
    $("#LIDes").click(function(event) {
  event.preventDefault();
//Do your logic here
});
}


function ReadLineItem(elem)
    {
       var hhh = elem.value;
	   if (hhh != "")
	   {	   
		window.location.href ="RFQ?sRFQ=" + hhh;
		//window.alert("JKJ");
	   }
	
    }	*/
</script>

<?php
//fetch tha data from the database
 $SN = 1;
	 if ($NoRowLI > 0) {
	while ($row = mysql_fetch_array($resultLI)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	  $LitID = $row ['LitID'];
	  $MatSer = $row ['MatSer'];
	  $Description = $row ['Description'];
	  $Qty = $row ['Qty'];
	  $UOM = $row ['UOM'];
	  $Price = $row ['ExtendedCost'];
	  $Currency = $row ['Currency'];
	  $RFQn = $row ['RFQCode'];
	  $POa = '<input type="checkbox" name="poli_cap[]" value="'.$Description. '@&@'. $LitID.'@&@'.$Price.'@&@'.$Qty.'@&@'.$UOM.'@&@'.$MatSer.'" OnClick="CPEXPerf(this);"></input>';
	    $Record .='
					 <tr>
					    <td>'.$SN.'</td>
					    <td>'.$LitID.'</td>
						<td>'.$MatSer.'</td>
						<td>'.$Description.'</td>
						<td>'.$Qty.'</td>
						<td>'.number_format($Price).'</td>
						<td>'.$POa.'</td>
						 </tr>';
		$SN = $SN + 1;				
     }
}

/*if ($NoRowPOREQ > 0)
{
  while ($row2 = mysql_fetch_array($resultPOREQ)) 
  {
    $LitID = $row2 ['LitID'];
    $MatSer = $row2 ['MatSer'];
    $Description = $row2 ['ItemDes'];
     $Qty = 1;//$row2 ['Qty'];
    $Price = $row2 ['Amount'];
    
    $POa = '<input type="checkbox" name="AddRan[]" value="'.$Description. '@&@'. $LitID.'@&@'.$Price.'@&@'.$Qty.'@&@'.$UOM.'@&@'.$MatSer.'" OnClick="CPEXPerf(this)"></input>';
      $Record .='
           <tr>
              <td>'.$SN.'</td>
              <td>'.$LitID.'</td>
            <td>'.$MatSer.'</td>
            <td>'.$Description.'</td>
            <td>'.$Qty.'</td>
            <td>'.number_format($Price).'</td>
            <td>'.$POa.'</td>
             </tr>';
    $SN = $SN + 1;        
    
  }
}*/
?>	

              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Item ID</th>
                        <th>Mat</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>ExCost</th>
                        <th>&nbsp;</th>
                       </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>S/N</th>
                        <th>Item ID</th>
                        <th>Mat</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>ExCost</th>
                        <th>&nbsp;</th>
						            
                       
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
		
		
		 </form> 
		
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
	<script src="../mBOOT/jquery-ui.js"></script>
	 <script type="text/javascript">
	 //Date Picker
      $(function () {
	   //$('#DOB').datetimepicker();
	   $("#PODate").datepicker({
	inline: true,
	minDate: new Date()
});
       
      });
    </script>
  
    <script type="text/javascript">
      $(function () {
       // $("#userTab").dataTable();
        $('#userTab').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
	

	/*  function CPEXPerf(evt) 
    {
var roughval = evt.value.split("@&@");
var intAmount = roughval[2];

 
      {
        var v1=document.getElementById("pTax");
        v1.setAttribute("readOnly","true");
      }

//var intAmount = evt.value;
var oldAmount = document.fRFQ.SubTotal.value;
 if (evt.checked == true)
{

//document.getElementById('').innerHTML = Number(oldAmount) + Number(intAmount);
document.fRFQ.SubTotal.value = Number(oldAmount) + Number(intAmount);
document.fRFQ.sTax.value = ((document.fRFQ.SubTotal.value * document.fRFQ.pTax.value)/100).toLocaleString('en');
document.fRFQ.sTotal.value = (Number(document.fRFQ.SubTotal.value) + Number(document.fRFQ.sTax.value)).toLocaleString('en');
document.fRFQ.rTotal.value = (Number(document.fRFQ.SubTotal.value) + Number(document.fRFQ.sTax.value));
//document.fRFQ.total1.value = Number(oldAmount) + Number(intAmount);
//document.fRFQ.tp.value = Number(oldAmount) + Number(intAmount);
}
if (evt.checked == false)
{
document.fRFQ.SubTotal.value = Number(oldAmount) - Number(intAmount);
document.fRFQ.sTax.value = ((document.fRFQ.SubTotal.value * document.fRFQ.pTax.value)/100).toLocaleString('en');
document.fRFQ.sTotal.value = (Number(document.fRFQ.SubTotal.value) + Number(document.fRFQ.sTax.value)).toLocaleString('en');
document.fRFQ.rTotal.value = (Number(document.fRFQ.SubTotal.value) + Number(document.fRFQ.sTax.value));
//document.fRFQ.total1.value = Number(oldAmount) - Number(intAmount);
//document.fRFQ.tp.value = Number(oldAmount) - Number(intAmount);
 var CAPEXsum = document.getElementById("sTotal").value;
      if (CAPEXsum == "0" || CAPEXsum == "NaN")
      {
     // document.fRFQ.SubTotal.value = "0";
  
      //var v1=document.getElementById("pTax");
     $("#pTax").removeAttr("readonly");

      }
      else
      {
        var v1=document.getElementById("pTax");
        v1.setAttribute("readOnly","true");
      }
}
   	var CAPEXsum = document.fRFQ.SubTotal.value;
	if (CAPEXsum == "0" || CAPEXsum == "NaN")
	{
	document.fRFQ.SubTotal.value = "0";
 
	
	}
  else
  {

    //document.fRFQ.SubTotal.value = Number(document.fRFQ.SubTotal.value) - Number(document.fRFQ.DisAmt.value);
  }
}	*/
    </script>
	
	
  </body>
</html>