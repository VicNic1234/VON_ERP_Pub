<?php
session_start();
error_reporting(0);

if ($_SESSION['Dept'] == "superadmin" || $_SESSION['Dept'] == "internalsales" )
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';

  
//Get RFQ Details  
$resultRFQ = mysql_query("SELECT * FROM rfq WHERE RFQNum='".$_GET['sRFQ']."'");
$NoRowRFQ = mysql_num_rows($resultRFQ);
if ($NoRowRFQ > 0) {
	 	while ($row = mysql_fetch_array($resultRFQ)) 
	  {
	 
	  $DateRange = $row{'DateRange'};
	  $Cus = $row['Customer'];
	  $Status = $row ['Status'];
	  $CusRef = $row ['CompanyRefNo'];
	  }
	  
    }
	  
//Get customers Info
 $resultCUS = mysql_query("SELECT * FROM customers WHERE cussnme ='".$Cus."'");
 $NoRowCUS = mysql_num_rows($resultCUS);
if ($NoRowCUS > 0) {
	 	while ($row = mysql_fetch_array($resultCUS)) 
	  {
	 
	  $CusNme = $row['CustormerNme'];
	  $CusAddress = $row['CusAddress'];
	  $CusPhone = $row['CusPhone'];
	  
	  }
	  
    }

 $resultRFQ1 = mysql_query("SELECT * FROM rfq WHERE Status='OPEN'");
//check if user exist
 $NoRowRFQ1 = mysql_num_rows($resultRFQ1);
 

$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);

 $resultTerms = mysql_query("SELECT * FROM terms");
//check if user exist
 $NoRowTerms = mysql_num_rows($resultTerms);

$RecTerms = "";
 if ($NoRowTerms > 0)
 {
 while ($row = mysql_fetch_array($resultTerms)) 
 {
  $termsID = $row['termsID'];
  $termsT = $row['Title'];

  $RecTerms .= '<option value="'.$termsID.'">'.$termsT.'</option>';
 }

 }

 
 $resultLI = mysql_query("SELECT * FROM lineitems WHERE RFQCode='".$_GET['sRFQ']."' AND Status='QUOTED'");
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
 

	

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>PLANT E.R.P | Quotation</title>
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
    <link href="../mBOOT/searchstyle.css" rel="stylesheet" type="text/css" />



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script>
function ReadLineItem(elem)
    {
       var hhh = elem.value;
	   if (hhh != "")
	   {	   
		window.location.href ="printQ?sRFQ=" + hhh;
		//window.alert("JKJ");
	   }
	
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
            <li >
              <a href="../internalsales">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
			
			<li class="treeview">
              <a href="aRFQ">
                   <i class="fa fa-cog"></i><span>All RFQ</span></i>
              </a>
            </li>
			
			<li class="treeview">
              <a href="RFQ">
                   <i class="fa fa-download"></i><span>Receive RFQ</span></i>
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
			
			<li class="active">
              <a href="printQ">
                  <i class="fa fa-print"></i> <span>Print Quotation</span></i>
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
            Quotation 
            <small><?php echo $_GET['sRFQ']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../internalsales"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Quotation</li>
          </ol>
        </section>
		
<div class="pad margin no-print">
          <div class="callout callout-info" style="margin-bottom: 0!important;">												
            <h4><i class="fa fa-info"></i> Note:</h4>
            This page has been enhanced for printing. Click the print button at the bottom of the Quotation to print.
          </div>
</div>
        <!-- Main content -->
        <section>
          
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
  
          
	
		
        </section><!-- /.content -->
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

    document.body.innerHTML = originalContents;
} 
</script>    
        <!-- Main content -->
<?php
//fetch tha data from the database
	 if ($NoRowLI > 0) {
	 $SN = 1;
	while ($row = mysql_fetch_array($resultLI)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	  $LitID = $row{'LitID'};
	  $MatSer = $row['MatSer'];
	  $Description = $row ['Description'];
	  $Qty = $row ['Qty'];
	  $UOM = $row ['UOM'];
	  $RFQn = $row ['RFQCode'];
	  $Price = $row ['UnitCost'];
    $Price1 = number_format($row ['UnitCost'], 2);
	  $Currency = $row ['Currency'];
	  $ExPrice = $Price * $Qty;
    $ExPrice1 = number_format($row ['DPPPrice'], 2);
    $ExPrice1r = $row ['DPPPrice'];
    $ExPrice2 = number_format($row ['EXPPrice'], 2);
    $ExPrice2r = $row ['EXPPrice'];
    $ExPrice3 = number_format($row ['CIFPPrice'], 2);
    $ExPrice3r = $row ['CIFPPrice'];
	  $DeliveryToWrkLocation = $row ['DeliveryToWrkLocation'];
	  $DELIVERY = $row ['DELIVERY'];
	  $WorkLocation = $row ['WorkLocation'];
		
	    $Record .='
					 <tr>
					    <td>'.$SN.'</td>
						<td>'.$MatSer.'</td>
						<td>'.$Description.'</td>
						<td>'.$Qty.'</td>
						<td>'.$UOM.'</td>
						<td>'.$Currency.'</td>
						<td>'.$Price1.'</td>
						<td>'.$ExPrice1.'</td>
            <td>'.$ExPrice2.'</td>
            <td>'.$ExPrice3.'</td>
						<td>'.$DeliveryToWrkLocation.'</td>
						<td>'.$WorkLocation.'</td>
						<td>'.$DELIVERY.'</td>
						
					 </tr>';
						$SN = $SN + 1;
						$SubTotal1 = $SubTotal1 + $ExPrice1r;
            $SubTotal2 = $SubTotal2 + $ExPrice2r;
            $SubTotal3 = $SubTotal3 + $ExPrice3r;
            $SubTotal1f = number_format($SubTotal1, 2);
            $SubTotal2f = number_format($SubTotal2, 2);
            $SubTotal3f = number_format($SubTotal3, 2);
     }
	 if ($Currency == "NGN")
	 {$SCur = "NGN";}
}
else
{
$Record .= '<tr><td colspan="9">Select RFQ Code to get list of Quoted Items</td> </tr>';
}
?>			
        <section class="invoice">
		<div class="row">
            <div class="col-md-12">
              <div class="box">
			   <form>
   <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="LIRFQ" name="LIRFQ" onChange="ReadLineItem(this)">
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
   <div class="form-group has-feedback" style="width:18%; display: inline-block; margin:12px;">
            <span class="search">
            <input style="width:100%" type="text" class="form-control1  " id="RFQ" name="RFQ" placeholder="RFQ Code Search..." onInput="searchrfq(this)" />
      
       <ul class="results" id="resultRFQ" >
        
       </ul>
    </span> 
    </div>
    <script>
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

function litemsch(rfqv)
{
var uval = $(rfqv).attr('r');
window.location.href = "printQ?sRFQ=" + uval;
}
</script>
      <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
      <input type="text" id="AddrNme" oninput="document.getElementById('atn').innerHTML= document.getElementById('AddrNme').value;" placeholder="Addressee's Name">  </input>
    </div>
    <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
      <input type="text" id="CurrSym" oninput="document.getElementById('currsym0').innerHTML= this.value; document.getElementById('currsym1').innerHTML= this.value; document.getElementById('currsym2').innerHTML= this.value;" placeholder="Currency Symbol">  </input>
    </div>
		<div class="form-group has-feedback" style="width:10%; display: inline-block; margin:12px; ">
      <input type="button" onclick="rmvExw();" value="Hide Ex-Works">  </input>
    </div>
    <div class="form-group has-feedback" style="width:10%; display: inline-block; margin:12px; ">
      <input type="button" onclick="shwExw();" value="Show Ex-Works">  </input>
    </div>
     <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
      <select onclick="chkterms(this);">
        <option>Choose Terms</option>
        <?php echo $RecTerms; ?>
      </select>
      <input type="button" onclick="open_container();" value="+ Terms" />  
    </div>
    <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
      <select onchange="Exwks();" id="incoterms">
        <option>Choose INCO Terms</option>
        <option value="DDP Price">DDP Price</option>
        <option value="Exworks Price">Exworks Price</option>
        <option value="CIF Price">CIF Price</option>
      </select>
     
    </div>
     <div class="form-group has-feedback" style="width:30%; display: inline-block; margin:12px; ">
      <label>  Add <input type="text" title="MarkUp/Vat" id="mvup" onInput="chkmvup();" style="width:92px"/><input id="chkaVat" type="checkbox" onClick="chkAddVat();" checked /> </label> <input type="text" placeholder="MARKUP/VAT %" onInput="cmpAddVat();" onChange="cmpAddVat();" onKeyPress="return isNumber(event)" id="addVat" style="display:block"/>  
    </div>
    
		  </form>
			  </div>
			</div>
		</div>
          <!-- title row -->
<div id="PrintArea">
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
			
			  <img src="../mBOOT/plant.png" width="30px" height="30px" alt="PENL logo"/>
                PLANT ENGINEERING NIGERIA LIMITED
                <small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong>PLANT ENGINEERING NIGERIA LIMITED</strong><br>
                54 Emekuku Street, D-Line<br>
                Port Harcourt Rivers State, Nigeria<br>
                Phone: +234(84)360759<br/>
                Email: sales@pengrg.com<br/>
                URL: www.plantengrg.com
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              To
              <address>
                <strong><?php echo $CusNme; ?></strong><br>
                <?php echo $CusAddress; ?><br>
                
              </address>
              <b>Attention : </b><span id="atn"></span>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>Quotation No.: <?php echo $_GET['sRFQ']; ?> </b><br/>
              <br/>
              
              <b>Customer RFQ:</b> <?php echo $CusRef; ?><br/>
              <b>Date:</b> <?php echo date("d/m/Y");?>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                 <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Material/Service</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>UOM</th>
						
                        <th>Currency</th>
                        <th>Unit Price</th>
                        <th>Extended Price (DDP)</th>
                        <th>Extended Price (ExWks)</th>
                        <th>Extended Price (CIF)</th>
						 <th>Delivery Ex-works</th>
						<th>Ex-works Location</th>
						<th>Delivery Customers Location</th>
                       
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                   
                    </tbody>
                    <tfoot>
                      <tr>
                       
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        
                        <th>SUB TOTAL</th>
                        <th><span id="currsym0"></span>&nbsp;<span id="subvalue"></span><input id="rsubvalue" type="hidden" /></th>
						            <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                       
                       
                      </tr>
                      <tr >
                       
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        
                        <th id="vatrow">VAT</th>
                        <th><span id="currsym1"></span>&nbsp;<span id="vatvalue"></span></th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                       
                       
                      </tr>
                      
                       <tr>
                       
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                       
                        <th>TOTAL</th>
                        <th><span id="currsym2"></span>&nbsp;<span id="totalvalue"><?php echo number_format(($SubTotal + (($SubTotal * 5)/100)), 2); ?></span></th>
            <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                       <th>&nbsp;</th>
                        <th>&nbsp;</th>
                       
                      </tr>
                    </tfoot>
              </table>

            </div><!-- /.col -->
          </div><!-- /.row -->
             <!-- <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th style="width:50%">Subtotal:</th>
                    <td><?php //echo $SCur .' '. $SubTotal; ?></td>
                  </tr> -->
                  <!--<tr>
                    <th>Tax (5%)</th>
                    <td><?php //echo $SCur .' '. $Tax = (($SubTotal * 5)/ 100); ?></td>
                  </tr>
                
                  <tr>
                    <th>Total:</th>
                    <td><?php echo $SCur .' '.($SubTotal + $Tax); ?></td>
                  </tr>
                </table>
              </div> -->

              <script language="javascript">
        function open_container()
        {
            var size='standart';
            var content = '<form role="form" action="adTerms" method="POST"><div class="form-group">' +
   
     '<div class="form-group" style="width:100%; display: inline-block;"><label>Title: </label><input type="text" class="form-control" id="TermTitle" name="TermTitle" placeholder="Enter Title" required ></div>' +
      
      '<div>' +
      '<textarea rows="4" cols="50" placeholder=" Enter the Terms here..." id="nk" name="nk" style="width:100%; display: inline-block;" reqiured></textarea>' +
      '</div>'+
      
      '<button type="submit" class="btn btn-primary">Add</button></form>';
            var title = 'Add New Terms';
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
          <script type="text/javascript" >
  
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function cmpAddVat()
{

var vatp = Number(document.getElementById('addVat').value);
var realSubTotal = Number(document.getElementById('rsubvalue').value);
//alert(vatp);
if (vatp == 0)
{
document.getElementById('vatrow').innerHTML= document.getElementById('mvup').value;
document.getElementById('vatvalue').innerHTML= '';
 document.getElementById("totalvalue").innerHTML = formatn(realSubTotal.toFixed(2));
}
else
{
 var vatfig = (realSubTotal * vatp) / 100;
 var NewTotal = vatfig + realSubTotal
 document.getElementById('vatrow').innerHTML= document.getElementById('mvup').value + ' ' + vatp + '%';
 document.getElementById('vatvalue').innerHTML= formatn(vatfig.toFixed(2)); 
 document.getElementById("totalvalue").innerHTML = formatn(NewTotal.toFixed(2));
}


}

function chkmvup()
{
  document.getElementById('vatrow').innerHTML= document.getElementById('mvup').value;
document.getElementById('vatvalue').innerHTML= '';
 document.getElementById("totalvalue").innerHTML = formatn(realSubTotal.toFixed(2)); //addVat
document.getElementById('addVat').value = 0;

}

function chkAddVat()
{
  if($('#chkaVat').is(":checked") == true)
  {
     document.getElementById('addVat').style.display = 'block';

     document.getElementById('vatrow').innerHTML= document.getElementById('mvup').value;
      document.getElementById('currsym1').innerHTML= '';
      document.getElementById('vatvalue').innerHTML= '';
   
    // document.getElementById('vatboard').innerHTML= 'Vat';

  }
  else
  {
     document.getElementById('addVat').style.display = 'none';
     document.getElementById('addVat').value = '';
     document.getElementById('vatrow').innerHTML= '';
     document.getElementById('currsym1').innerHTML= '';
     document.getElementById('vatvalue').innerHTML= '';
     Exwks();
     document.getElementById('vatrow').innerHTML= '';
    // document.getElementById('vatboard').innerHTML= '';
  }
 
}


  </script>
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
            <!-- accepted payments column -->
            <div class="col-xs-6">
             </br>
			 </br>
		<!--	<b> Signed by : </b><?php echo  $_SESSION['SurName']. " ". $_SESSION['Firstname'] ;?></br> -->
      <script type="text/javascript">
function chkterms(mou)
{
var searchid = $(mou).val();
var dataString = 'search='+ searchid;
if(searchid!='')
{
  $.ajax({
  type: "POST",
  url: "searchTerms.php",
  data: dataString,
  cache: false,
  success: function(html)
  {
  //$("#qterms").html(html).show();
  //$('#qterms1').elastic();
  //o.style.height = "1px";
  //  o.style.height = (25+o.scrollHeight)+"px";
  $("#qterms1").text(html);
  //getElementById("qterms1").style.height = "1px";
  //getElementById("qterms1").style.height = (25+o.scrollHeight)+"px";
  autosize($('#qterms1s'));
  //$('#qterms1').elastic();

  }
  });
}
if(searchid=='')
{
//$("#result").html('').hide();
//return false;
$("#qterms1").text('');
}
return false;  

}
</script>
			
              <img src="../mBOOT/PlantSig.jpg" alt="PENL Signature"/>
              <br /> <b>AUTHORIZED : For PENL </b> <br /><br />
         <!--     <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;" id="qterms">
                QUOTATION TERMS.  </br>

Currency: All Prices Quoted are in USD </br>

Incoterms: The incoterms used in the offer is DDP </br>

Place of Delivery: TOTAL, ONNE BASE, Rivers State. Nigeria. </br>

Taxes: All Prices are EXCLUSIVE  of all local taxes. </br>

Quote Validity: The validity of this offer is 30 days from the date of the quotation. </br>

Delivery Lead-time: 3 weeks after receipt of an official purchase Order. Quoted lead-times are based on current OEM stocking level and subject to change. </br>

Payment Terms: Customer's Payment Terms </br>

Partial order: Prices are based on complete order only, in case of a partial offer, a review will be done and a revised offer sent </br>

Minimum order Value: Our minimum order Value is USD 300 or it's equivalent. </p> -->
<textarea id="qterms1" cols="135" height="auto" readonly style="overflow: visible; border:none;" ></textarea>
            </div><!-- /.col -->
            <div class="col-xs-6">
             
            
            </div><!-- /.col -->
          </div><!-- /.row -->
</div>
          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <button  class="btn btn-default" onclick="printDiv('PrintArea')"><i class="fa fa-print"></i> Print</button>
            <!--  <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Note as Qutoted</button>
              <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Send Mail</button> -->
            </div>
          </div>
        </section><!-- /.content -->
        <div class="clearfix"></div>
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
    function rmvExw() {
    $('td:nth-child(11),th:nth-child(11)').hide();
    //$('td:nth-child(10),th:nth-child(10)').hide();
    //$('td:nth-child(11),th:nth-child(11)').hide();
  }


  function shwExw() {
     $('td:nth-child(11),th:nth-child(11)').show();
    //$('td:nth-child(10),th:nth-child(10)').show();
   // $('td:nth-child(11),th:nth-child(11)').show();

  }
  function formatn(num){
    var n = num.toString(), p = n.indexOf('.');
    return n.replace(/\d(?=(?:\d{3})+(?:\.|$))/g, function($0, i){
        return p<0 || i<p ? ($0+',') : $0;
    });
}
  function Exwks() {
    var yy = $( "#incoterms option:selected" ).text();
    if (yy == "DDP Price")
    {
      var TotalV = '<?php echo $SubTotal1 ?>';
      $('tbody td:nth-child(8),thead th:nth-child(8)').show();
      $('tbody td:nth-child(9),thead th:nth-child(9)').hide();
      $('tbody td:nth-child(10),thead th:nth-child(10)').hide();
       document.getElementById("subvalue").innerHTML = '<?php echo $SubTotal1f; ?>';
        document.getElementById("rsubvalue").value = '<?php echo $SubTotal1; ?>';
       document.getElementById("totalvalue").innerHTML = '<?php echo $SubTotal1f; ?>';
       //document.getElementById("totalvalue").innerHTML = (Number(document.getElementById('chkaVat').value) * TotalV) / 100;
    }
    else if (yy == "Exworks Price")
    {
      $('tbody td:nth-child(8),thead th:nth-child(8)').hide();
      $('tbody td:nth-child(9),thead th:nth-child(9)').show();
      $('tbody td:nth-child(10),thead th:nth-child(10)').hide();
       document.getElementById("subvalue").innerHTML = '<?php echo $SubTotal2f; ?>';
        document.getElementById("rsubvalue").value = '<?php echo $SubTotal2; ?>';
        document.getElementById("totalvalue").innerHTML = '<?php echo $SubTotal2f; ?>';
    }
    else if (yy == "CIF Price")
    {
       $('tbody td:nth-child(8),thead th:nth-child(8)').hide();
      $('tbody td:nth-child(9),thead th:nth-child(9)').hide();
      $('tbody td:nth-child(10),thead th:nth-child(10)').show();
      document.getElementById("subvalue").innerHTML = '<?php echo $SubTotal3f; ?>';
        document.getElementById("rsubvalue").value = '<?php echo $SubTotal3; ?>';
        document.getElementById("totalvalue").innerHTML = '<?php echo $SubTotal3f; ?>';
    }
    cmpAddVat();
   
  }
    </script>
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
        $('#reservation').daterangepicker();
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