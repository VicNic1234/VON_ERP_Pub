<?php
session_start();
error_reporting(0);

Include('route.php');
$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';

$resultcurren = mysql_query("SELECT * FROM currencies");
$NoRowcurren = mysql_num_rows($resultcurren);
if ($NoRowcurren > 1)
{
while ($row = mysql_fetch_array($resultcurren )) {
$CurrencyName = $row{'CurrencyName'};
$Abbreviation = $row{'Abbreviation'};

$Curreny1 .= '<option value="'.$Abbreviation.'">'.$Abbreviation.'</option>';
}
}

$resultuom = mysql_query("SELECT * FROM uom");
$NoRowuom = mysql_num_rows($resultuom);
if ($NoRowuom > 1)
{
while ($row = mysql_fetch_array($resultuom )) {
$uom = $row{'UOMAbbr'};


$uom1 .= '<option value="'.$uom.'">'.$uom.'</option>';
}
}
  
$resultRFQ = mysql_query("SELECT * FROM rfq");
//check if user exist
 $NoRowRFQ = mysql_num_rows($resultRFQ);
//Load Suppliers
 $resultSUP = mysql_query("SELECT * FROM suppliers");
 $NoRowSUP = mysql_num_rows($resultSUP);


 $resultRFQ1 = mysql_query("SELECT * FROM rfq WHERE Status='OPEN'");
//check if user exist
 $NoRowRFQ1 = mysql_num_rows($resultRFQ1);
 
$resultCUS = mysql_query("SELECT * FROM customers");
//check if user exist
 $NoRowCUS = mysql_num_rows($resultCUS);
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);

 if ($_GET['sRFQ'] == "" OR $_GET['sRFQ'] == "ALL")
 {
 $resultLI = mysql_query("SELECT * FROM polineitems WHERE ProjectControl='1'");
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
 }
 else
 {
 $resultLI = mysql_query("SELECT * FROM polineitems WHERE RFQCode='".$_GET['sRFQ']."' AND ProjectControl='1'");
//check poitem user exist
 $NoRowLI = mysql_num_rows($resultLI);
 //Let's get the Attachemtn here
 $resultatt = mysql_query("SELECT * FROM rfq WHERE RFQNum='".$_GET['sRFQ']."'");
 $NoRowatt= mysql_num_rows($resultatt);
 if ($NoRowatt > 0) {
  while ($row = mysql_fetch_array($resultatt)) 
  {
    $Attachlnk = $row ['Attachment'];
  }
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
              <a href="../projectcontrols">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
			
			<li class="treeview">
              <a href="aRFQ">
                   <i class="fa fa-cog"></i><span>All RFQ</span></i>
              </a>
            </li>

      
      <li class="treeview">
              <a href="aSO">
                   <i class="fa fa-cog"></i><span>All SO</span></i>
              </a>
            </li>
			
			<li class="active">
              <a href="Qchk">
                   <i class="fa fa-cog"></i><span>Prepare Sales Order</span></i>
              </a>
            </li>


      <li class="treeview" title="Raise Sales Order">
              <a href="RaiseQchk">
                   <i class="fa fa-cog"></i><span>Raise Sales Order</span></i>
              </a>
            </li>
			
		<!--	<li class="treeview">
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
              <a href="printQ">
                  <i class="fa fa-print"></i> <span>Print Quotation</span></i>
              </a>
			 
            </li> -->
			
           
                              
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
            Prepare Sales Order
            <small>Version 2.0</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../internalsales"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Prepare sales order</li>
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
                  <h3 class="box-title">Filter Search</h3>
				 
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



  </script>
              <div class="box" style="display:block" id="ELineIt">
			 <form>
   <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="LIRFQ" name="LIRFQ" onChange="ReadLineItem(this)">
			<option value=""> Choose RFQ code</option>
			<option value="ALL"> ALL Unattended Items</option>
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
window.location.href = "Qchk?sRFQ=" + uval;
}
</script>

    <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
                  
                  <a href="<?php echo $Attachlnk; ?>" <i class="fa fa-eye" ></i> View Attachment </a>
   
    </div>
		
		  </form>
			  </div>

<script>
function ReadLineItem(elem)
    {
       var hhh = elem.value;
	   if (hhh != "")
	   {	   
		window.location.href ="Qchk?sRFQ=" + hhh;
		//window.alert("JKJ");
	   }
	
    }	
</script>
<script language="javascript">
  function chngmkup()
     {
            if($('#markupchk').is(":checked") == true)
          {
            document.getElementById('markupCos').value = "";
            //document.getElementById('markupperc').value = "";
             //$('#markupperc').attr('readonly', true);
            document.getElementById("markupperc").readOnly=false;
            document.getElementById("markupCos").readOnly=true;
          }
          else
          {
            document.getElementById('markupperc').value = "";
           // document.getElementById('markupCos').value = "";
            document.getElementById("markupperc").readOnly=true;
            document.getElementById("markupCos").readOnly=false;
          }
     }

    function chngfpkg()
     {
      if($('#freightperchk').is(":checked") == true)
    {
      document.getElementById('FreightA').value = "";
      //document.getElementById('FreightP').value = "";
       //$('#markupperc').attr('readonly', true);
      document.getElementById("FreightP").readOnly=false;
      document.getElementById("FreightA").readOnly=true;
    }
    else
    {
      document.getElementById('FreightP').value = "";
      //document.getElementById('FreightP').value = "";
      document.getElementById("FreightP").readOnly=true;
      document.getElementById("FreightA").readOnly=false;
    }
     }



         function MainComp()
		 {

      var RmCurrency = document.getElementById('mCurrency').value;
      if (RmCurrency != "")
      {
        
        //Get select object
        var objSelect = document.getElementById("Cur");

        //Set selected
        setSelectedValue(objSelect, RmCurrency);

        function setSelectedValue(selectObj, valueToSet) 
        {
            for (var i = 0; i < selectObj.options.length; i++) 
            {
                if (selectObj.options[i].text == valueToSet) 
                {
                    selectObj.options[i].selected = true;
                    return;
                }
            }
         }
         document.getElementById('mCurrency').value = "";
      }
     

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
		document.getElementById('PreShip').value = ((1 * FOBb)/ 100).toFixed(2);
		
		//EEEEE FREIGHT HHHHHHHHHHH
		var FreightPer = document.getElementById('FreightP').value;
		var ExW = document.getElementById('ExWeight').value;
		var FreightAmount = FreightPer * ExW;
		if($('#freightperchk').is(":checked") == true)
    {
      
      document.getElementById('FreightA').value = FreightAmount.toFixed(2);

    }

    else
    {
      document.getElementById("FreightP").readOnly=true;
      document.getElementById("FreightA").readOnly=false;
      FreightAmount = Number(document.getElementById('FreightA').value);
    }
		// NNNN CIF, SUB TOTaL
		
		var CIF = (Number(FOB) + PackAmount + InsurAmount + FreightAmount);
		document.getElementById('CIF').value = CIF.toFixed(2);
		//HS Tariff Custom Duty
		var HS = document.getElementById('HSTariff').value
		
		var CusDuty = (CIF * HS)/100;
		var CusSub = (CusDuty * 7)/100;
		var ETLS = (CIF * 0.5)/100;
    var CusVat = ((CIF + ((1 * FOBb)/ 100) + CusDuty + CusSub + ETLS) * 5)/100;
		var LocHand = (CIF * document.getElementById('pLocHand').value)/100;
    if($('#markupchk').is(":checked") == true)
    {
      var markupCos = (CIF * document.getElementById('markupperc').value)/100; 
      document.getElementById('markupCos').value = markupCos.toFixed(2);
    }

    else
    {
       document.getElementById("markupperc").readOnly=true;
      document.getElementById("markupCos").readOnly=false;
    }
		
		
		
		document.getElementById('CustomDuty').value = CusDuty.toFixed(2);
		//document.getElementById('markupCos').value = markupCos.toFixed(2);
		document.getElementById('CusSub').value = CusSub.toFixed(2);
    
		document.getElementById('ETLS').value = ETLS.toFixed(2);
		document.getElementById('LocHand').value = LocHand.toFixed(2);
		
		//To get Local Cost
    //To get Local Cost
    var nCusVat = 0;
    if($('#CusVat').is(":checked") == true)
    {
    document.getElementById('CustomVat').value = CusVat.toFixed(2);
     nCusVat = Number(document.getElementById('CustomVat').value);
      document.getElementById("CustomVat").readOnly=true;
       
    }

    else
    {
      //document.getElementById('CustomVat').value = 0;
       document.getElementById("CustomVat").readOnly=false;
      nCusVat = Number(document.getElementById('CustomVat').value);
    }
		var preship = Number(document.getElementById('PreShip').value);
		var cusdty = Number(document.getElementById('CustomDuty').value);
		var cussubch = Number(document.getElementById('CusSub').value);
		var etls = Number(document.getElementById('ETLS').value);
		var markpval = Number(document.getElementById('markupCos').value);
		var localhndle = Number(document.getElementById('LocHand').value);
		var LocCost = preship + cusdty + cussubch + etls + markpval + localhndle + nCusVat; 
		document.getElementById('LocCos').value = LocCost.toFixed(2);
		
		
		//To get DPP cost
		//To get DPP cost
   var DPPprice = LocCost + CIF;
    if($('#NCDchk').is(":checked") == true)
    {

       var nDPPprice = ( 1 * DPPprice)/100; 
       document.getElementById('DPPPrice').value = Number(nDPPprice.toFixed(2)) + Number(DPPprice.toFixed(2));
    }
    else
    {
       document.getElementById('DPPPrice').value = DPPprice.toFixed(2);

    }

    var EXPPrice = ExCost + PackAmount + markpval;
    var CIFPPrice = CIF + markpval;
    //document.getElementById('DPPPrice').value = DPPprice.toFixed(2);
    document.getElementById('EXPPrice').value = EXPPrice.toFixed(2);
    document.getElementById('CIFPPrice').value = CIFPPrice.toFixed(2);
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
		
		
		
        function open_container(LID, rfq, mst, qty, uom, uw, uc, ds, fp, hsc, hst, pp, ip, dw, wl, dly, mkper, ploch, mkdirect, frdirect, framt, mkamt, currency)
        {
			var title = 'Raise SO for line item : '+LID + ' in RFQ No. : '+rfq;
			var Curren = '<?php echo $Curreny1; ?>';
      var uoms = '<?php echo $uom1; ?>';
      ///We got get Description now
      var dataString = 'search='+ LID;
      var ItemD = '';
                  $.ajax({
                  type: "POST",
                  url: "searchLI.php",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     ItemD = html;
                     //alert(ItemD); 
                     document.getElementById('ItDes').innerHTML = ItemD;
                  }
                  });
            var size='large';
            var content = '<form role="form" method="post" action="QpoLineItem"><div class="form-group">' +
			'<label>Line Item\'s Description: </label>' +
            '<textarea required class="form-control" id="ItDes" name="ItDes" placeholder="" ></textarea>' +
            '<span class="glyphicon glyphicon-align-justify form-control-feedback"></span>' +
			'</div>' +
			
			'<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Currency: </label>'+
			'<select class="form-control" id="Cur" name="Cur">' + Curren + '</select>' +
			'<input type="hidden" id="mCurrency" value="' + currency + '" />'+
			
			'</div>' +
			
			'<div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">' +
		    '<label>Quantity of Item </label>' +
			'<input type="text" class="form-control" id="LIQty" name="LIQty" placeholder="Quantity" value="'+ qty +'" onInput="MainComp()" onKeyPress="return isNumber(event)"  />' +
			'</div>'+

			'<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Unit of Meas.: </label>'+
      '<select class="form-control" id="UOM" name="UOM">' + uoms + '</select>' +
      
      
      '</div>' +
			
			'<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Material No.: </label><input type="text" class="form-control" id="mart" name="mart" value="'+mst+'" ></div>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;" ><label>Unit Weight (Kg): </label><input type="text" class="form-control" id="UnitWeight" name="UnitWeight" value="'+uw+'" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
			
			'<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Extended Weight (Kg): </label><input type="text" class="form-control" id="ExWeight" name="ExWeight" onKeyPress="return isNumber(event)" readonly  ></div>' +
			
			'<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Unit Cost: </label><input type="text" class="form-control" id="LIUC" name="LIUC" placeholder="Unit Cost" value="'+uc+'" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
			
			'<input type="hidden" name="LIID" value="'+ LID +'" ></input>' +
			'<input type="hidden" name="LIRFQ" value="'+ rfq +'" ></input>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Extended Cost: </label><input type="text" class="form-control" id="ExCost" name="ExCost" placeholder="Extended Cost" readonly ></div>' +
			
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Discount(%): </label><input type="text" class="form-control" value="'+ds+'" id="Disc" name="Disc" placeholder="Discount" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Discount Amt: </label><input type="text" class="form-control" id="DiscC" name="DiscC" placeholder="Disc. Amount" onKeyPress="return isNumber(event)" readonly></div>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>FOB: </label><input type="text" class="form-control" id="FOB" name="FOB" placeholder="ExPrice-Discount"  readonly ></div>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Packaging(% of FOB): </label><input type="text" class="form-control" id="PackP" value="'+pp+'" name="PackP" placeholder="Pkg %" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Packaging Amt: </label><input type="text" class="form-control" id="PackA" name="PackA" placeholder="Package Amount" onKeyPress="return isNumber(event)" readonly></div>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Insurance(% of FOB): </label><input type="text" class="form-control" id="InsurP" name="InsurP" value="'+ip+'" placeholder="Insurance %" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Insurance Amt: </label><input type="text" class="form-control" id="InsurA" name="InsurA" placeholder="Insurance Amount" onKeyPress="return isNumber(event)" readonly></div>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Freight Per Kg: <input type="checkbox" id="freightperchk" name="freightperchk" onclick="chngfpkg();" '+frdirect+' /></label><input type="text" title="Freight * ExWeight" class="form-control" id="FreightP" name="FreightP" value="'+fp+'" placeholder="Freight" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Freight Amt: </label><input type="text" class="form-control" id="FreightA" name="FreightA" placeholder="Freight Amount" value="'+framt+'" onInput="MainComp()" onKeyPress="return isNumber(event)" readonly></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>SubTotal, CIF: </label><input type="text" class="form-control" id="CIF" name="CIF" placeholder="SubTotal, CIF"  readonly></div>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>HS CODE: </label><input type="text" class="form-control" id="HSCODE" name="HSCODE" value="'+hsc+'" placeholder="HS CODE"></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>HS Tariff %: </label><input type="text" class="form-control" id="HSTariff" value="'+hst+'" name="HSTariff" placeholder="HS Tariff %" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>CISS(1% FOB): </label><input type="text" class="form-control" id="PreShip" name="PreShip" placeholder="Custom Duty" readonly ></div>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Custom Duty: </label><input type="text" class="form-control" id="CustomDuty" name="CustomDuty" placeholder="Custom Duty" readonly ></div>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Custom Surcharge ( 7% of custom duty ): </label><input type="text" class="form-control" id="CusSub" name="CusSub" placeholder="Custom Surcharge" readonly></div>' +
			 '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Custom Vat: <input type="checkbox" name="CusVat" id="CusVat" checked  onclick="MainComp()" /> </label><input type="text" title="5% of (CIF + Duty + Subcharge + CISS + ETLS)" class="form-control" id="CustomVat" name="CustomVat" onInput="MainComp()" placeholder="Custom Vat" onKeyPress="return isNumber(event)" readonly></div>' +
      

      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>ETLS Charge ( 0.5% of CIF ): </label><input type="text" class="form-control" id="ETLS" name="ETLS" placeholder="ETLS Charge" onKeyPress="return isNumber(event)" readonly></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Local Handling (% of CIF ): </label><input type="text" class="form-control" id="pLocHand" name="pLocHand" placeholder="Local Handling %" value = "'+ploch+'" onInput="MainComp()" onKeyPress="return isNumber(event)"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Local Handling Amt: </label><input type="text" class="form-control" id="LocHand" name="LocHand" placeholder="Local Handling" readonly ></div>' +
      
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Mark up (% of CIF): <input type="checkbox" id="markupchk" name="markupchk" onclick="chngmkup();" '+mkdirect+' /></label><input type="text" class="form-control" id="markupperc" name="markupperc" value="'+ mkper +'" placeholder="Mark up %" onInput="MainComp()" onKeyPress="return isNumber(event)"></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Mark up Amt: </label><input type="text" class="form-control" id="markupCos" name="markupCos" placeholder="Mark up" value="'+mkamt+'" readonly onInput="MainComp()" onKeyPress="return isNumber(event)"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Local Cost: </label><input type="text" class="form-control" id="LocCos" name="LocCos" placeholder="Local Cost" readonly ></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Delivery Ex-Works: </label><input type="text" class="form-control" id="DEX" name="DEX" value="'+dw+'" placeholder="Delivery Ex-works" ></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Ex-Works Location: </label><input type="text" class="form-control" id="DEXL" name="DEXL" value="'+wl+'" placeholder="Delivery Ex-works Location" ></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Delivery Cus. Location: </label><input type="text" class="form-control" id="DCUSL" name="DCUSL" value="'+dly+'" placeholder="Delivery Customers Location" ></div>' +
			'<br />'+
		'<div class="form-group" style="width:43%; display:inline-block; margin:12px;"><label>DDP Price (CIF + Local Cost): </label><input type="text" class="form-control" id="DPPPrice" name="DPPPrice" placeholder="DDP Price" readonly ><input type="radio" name="qstate" value="1" checked></input> <br /> <label> Include NCD: <input type="checkbox" id="NCDchk" name="NCDchk" onclick="MainComp();" /></label></div>' +
      
      '<div class="form-group" style="width:63%; display:inline-block; margin:12px;"><label>Exworks Price (ExUnit Cost + Packaging + Markup): </label><input type="text" class="form-control" id="EXPPrice" name="EXPPrice" placeholder="Exworks Price" readonly ><input type="radio" name="qstate" value="2"></input></div>' +
      
      '<div class="form-group" style="width:63%; display:inline-block; margin:12px;"><label>CIF Price (CIF + Markup): </label><input type="text" class="form-control" id="CIFPPrice" name="CIFPPrice" placeholder="CIF Price" readonly ><input type="radio" name="qstate" value="3"></input></div>' +
      
			
			'<button type="submit" style="margin:12px;" class="btn btn-primary">Prepared Sales Order</button></form>';
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
	  $Price = $row ['UnitDDPrice'];
	  $Currency = $row ['Currency'];
	  $UnitWeight = $row ['UnitWeight'];
	  $UnitCost = $row ['UnitCost'];
    $UnitCost = $UnitCost;
	  $Discount = $row ['Discount'];
	  $FreightPercent = $row ['FreightPercent'];
	  $HScode = $row ['HScode'];
	  $HsTarrif = $row ['HsTarrif'];
	  $PackingPercent = $row ['PackingPercent'];
	  $InsurePercent = $row ['InsurePercent'];
	  $DeliveryToWrkLocation = $row ['DeliveryToWrkLocation'];
     $pLocalHandling = $row ['pLocalHandling'];
     $ExCost = $row ['ExtendedCost'];
     $ExCost = number_format($ExCost);
	  //$FOBExWorks = $row ['FOBExWorks'];
	  $DELIVERY = $row ['DELIVERY'];
	  $WorkLocation = $row ['WorkLocation'];
	  $ExPrice = $Price * $Qty;
    $ExPrice = $ExPrice;
	  $Statu = $row ['Status'];
	  $CreateSO = $row ['CreateSO'];
	  $markupperc = $row ['markupperc'];

	  $Tech = $row ['Tech'];
    $MarkUpDirect = $row ['MarkUpDirect'];
    $MarkUpAmt = $row ['MarkUp'];
    $FreightDirect = $row ['FreightDirect'];
    $FreightAmt = $row ['Freight'];
	  $MOS = $row ['MOS'];
	  $Comm = $row ['Comm'];
	  $PCStatu = $row ['ProjectControl'];
	
	   if ($CreateSO != '1') 
	   {
	  // $PCStatus = '<i class="fa fa-cog" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc1(this);"></i>';
	   $PCStatus = '<input type="checkbox" title="Open for Project Control" r="'.$LitID.'" ct="hpt'.$LitID.'", cm="hpm'.$LitID.'", cc="hpcm'.$LitID.'" jm="hj'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></input>';
	   }
	   if ($CreateSO == '1') 
	   {
	   //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
	   $PCStatus = '<input  type="checkbox" checked title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></input>';
	   }
	   
	   if ($Tech != '1') 
	   {
	  // $PCStatus = '<i class="fa fa-cog" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc1(this);"></i>';
	   $PCTech = '<input type="checkbox" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpt'.$LitID.'" onclick="cpcTech(this);"></input>';
	   }
	   if ($Tech == '1') 
	   {
	   //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
	   $PCTech = '<input  type="checkbox" checked title="Close from Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpt'.$LitID.'" onclick="cpcTech(this);"></input>';
	   }
	   if ($MOS != '1') 
	   {
	  // $PCStatus = '<i class="fa fa-cog" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc1(this);"></i>';
	   $PCMOS = '<input type="checkbox" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpm'.$LitID.'" onclick="cpcMOS(this);"></input>';
	   }
	   if ($MOS == '1') 
	   {
	   //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
	   $PCMOS = '<input  type="checkbox" checked title="Close from Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpm'.$LitID.'" onclick="cpcMOS(this);"></input>';
	   }
	   
	   if ($Comm  != '1') 
	   {
	  // $PCStatus = '<i class="fa fa-cog" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc1(this);"></i>';
	   $PCComm = '<input type="checkbox" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpcm'.$LitID.'" onclick="cpcComm(this);"></input>';
	   }
	   if ($Comm == '1') 
	   {
	   //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
	   $PCComm = '<input  type="checkbox" checked title="Close from Project Control" cm="CreateComm" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpcm'.$LitID.'" onclick="cpcComm(this);"></input>';
	   }
	  
	    $Record .='
					 <tr>
					    <td>'.$SN.'</td>
						<td>'.$MatSer.'</td>
						<td>'.$Description.'</td>
						<td>'.$Qty.'</td>
						<td>'.$UOM.'</td>
						
						<td>'.$LitID.'</td>
						<td>'.$Currency.'</td>
						<td>'.$UnitCost.'</td>
						<td>'.$ExCost.'</td>
						
	
						<td><a '.  'onclick="open_container('.$LitID.',\''.$RFQn.'\',\''.$MatSer.'\',\''.$Qty.'\',\''.$UOM.'\',\''.$UnitWeight.'\',\''.$UnitCost.'\',\''.$Discount.'\',\''.$FreightPercent.'\',\''.$HScode.'\',\''.$HsTarrif.'\',\''.$PackingPercent.'\',\''.$InsurePercent.'\',\''.$DeliveryToWrkLocation.'\',\''.$WorkLocation.'\',\''.$DELIVERY.'\',\''.$markupperc.'\',\''.$pLocalHandling.'\',\''.$MarkUpDirect.'\',\''.$FreightDirect.'\',\''.$FreightAmt.'\',\''.$MarkUpAmt.'\',\''.$Currency.'\' );">'. '<span class="fa fa-eye"></span></a></td>
						


						<td>'.$PCTech.'</td>
						<td>'.$PCMOS.'</td>
						<td>'.$PCComm .'</td>
						<td>'.$PCStatus.'</td>
																																						
					 </tr>';
						$SN = $SN + 1;
     }
}
?>	

              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="col-xs-12 table-responsive">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Material/Service</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>UOM</th>
						
                        <th>LiID</th>
                        <th>Currency</th>
                        <th>Unit Price</th>
                        <th>Extended Price</th>
                        <th>Prepare SO</th>
                        <th>Check Tech</th>
                        <th>Check MOS</th>
                        <th>Check Comm.</th>
						<th>Set for SO</th>
                        
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
                        <th>LiID</th>
						<th>Currency</th>
                        <th>Unit Price</th>
                        <th>Extended Price</th>
						 <th>Prepare SO</th>
						<th>Check Tech</th>
                        <th>Check MOS</th>
                        <th>Check Comm.</th>
						 <th>Set for SO</th>
                       
                      </tr>
                    </tfoot>
                  </table>
                </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
	 <script type="text/javascript">
	 function cpcTech(relm)
	 {
	    //alert("Grace");
		var gh = $(relm).attr('r');
		var ghid = $(relm).attr('id');
		var prind = $(relm).attr('jm');
		//alert(ghid);
		var dataString = 'litem='+ gh;
		if($('#'+ghid).is(":checked") == true)
		{
		
			$.ajax({
			type: "POST",
			url: "acpcTech1",
			data: dataString,
			cache: false,
			success: function(html)
			{
						//$("#"+prind).prop('checked', true);
			}
			});
		
		}
		else
		{
		$.ajax({
			type: "POST",
			url: "acpcTech0",
			data: dataString,
			cache: false,
			success: function(html)
			{
						$("#"+prind).prop('checked', false);
			}
			});
		}
		
	 }

   function cpcMOS(relm)
   {
      //alert("Grace");
    var gh = $(relm).attr('r');
    var ghid = $(relm).attr('id');
    var prind = $(relm).attr('jm');
    //alert(ghid);
    var dataString = 'litem='+ gh;
    if($('#'+ghid).is(":checked") == true)
    {
    
      $.ajax({
      type: "POST",
      url: "acpcMOS1",
      data: dataString,
      cache: false,
      success: function(html)
      {
            //$("#"+prind).prop('checked', true);
      }
      });
    
    }
    else
    {
    $.ajax({
      type: "POST",
      url: "acpcMOS0",
      data: dataString,
      cache: false,
      success: function(html)
      {
            $("#"+prind).prop('checked', false);
      }
      });
    }
    
   }

   function cpcComm(relm)
   {
      //alert("Grace");
    var gh = $(relm).attr('r');
    var ghid = $(relm).attr('id');
    var prind = $(relm).attr('jm');
    //alert(ghid);
    var dataString = 'litem='+ gh;
    if($('#'+ghid).is(":checked") == true)
    {
    
      $.ajax({
      type: "POST",
      url: "acpcComm1",
      data: dataString,
      cache: false,
      success: function(html)
      {
            //$("#"+prind).prop('checked', true);
      }
      });
    
    }
    else
    {
    $.ajax({
      type: "POST",
      url: "acpcComm0",
      data: dataString,
      cache: false,
      success: function(html)
      {
            $("#"+prind).prop('checked', false);
      }
      });
    }
    
   }
   
	 
	 function cpc(relm)
	 {
	    //alert("Grace");
		var gh = $(relm).attr('r');
    var MOSid = $(relm).attr('cm');
    var Techid = $(relm).attr('ct');
    var Commid = $(relm).attr('cc');
		var ghid = $(relm).attr('id');
		var prind = $(relm).attr('jm');
		var dataString = 'litem='+ gh;
		if($('#'+ghid).is(":checked") == true)
		{
		
			$.ajax({
			type: "POST",
			url: "acpc",
			data: dataString,
			cache: false,
			success: function(html)
			{
						$("#"+MOSid).prop('checked', true);
            $("#"+Techid).prop('checked', true);
            $("#"+Commid).prop('checked', true);
			}
			});
		
		}
		else
		{
		
			$.ajax({
			type: "POST",
			url: "acpc1",
			data: dataString,
			cache: false,
			success: function(html)
			{
						//$("#"+prind).prop('checked', true);
			}
			});
		
		}
		/*$.ajax({
		type: "POST",
		url: "acpc",
		data: dataString,
		cache: false,
		success: function(html)
		{
		
		
		$( "#"+ghid ).removeClass( 'fa fa-check' );
		$( "#"+ghid ).addClass( 'fa fa-cog' );
		
		}
		});*/
	 
	 }
	 
	 function cpc1(relm)
	 {
	    //alert("Grace");
		var gh = $(relm).attr('r');
		var ghid = $(relm).attr('id');
		//alert(ghid);
		var prind = $(relm).attr('jm');
		var dataString = 'litem='+ gh;
		
		//var gh2 = $(remit).attr('ms1');
		//$("#LIDes").val(gh);
		//$("#LIMS").val(gh2);
		//$("#result").html('').hide(); litem
		$.ajax({
		type: "POST",
		url: "acpc1",
		data: dataString,
		cache: false,
		success: function(html)
		{
		
		$( "#"+ghid ).removeClass( 'fa fa-cog' );
		$( "#"+ghid ).addClass( 'fa fa-check' );
		
		$( "#"+prind ).removeClass( 'fa fa-cog' );
		$( "#"+prind ).addClass( 'fa fa-check' );
		}
		});/**/
	 
	 }
	 
	 function orfq(relm)
	 {
	    //alert("Grace");
		var gh = $(relm).attr('r');
		var ghid = $(relm).attr('id');
		//alert(ghid);
		//var prind = $(relm).attr('jm');
		var dataString = 'olitem='+ gh;
		
		$.ajax({
		type: "POST",
		url: "otggLi",
		data: dataString,
		cache: false,
		success: function(html)
		{
		$( "#"+ghid ).removeClass( 'fa fa-cog' );
		$( "#"+ghid ).addClass( 'fa fa-check' );
		//$( "#"+prind ).show();
		}
		});/**/
	 
	 }
    
    </script>	
		
		
		
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