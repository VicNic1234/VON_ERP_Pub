<?php
session_start();
error_reporting(0);

include ('route.php');

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';


 
 $resultRFQ1 = mysql_query("SELECT * FROM po WHERE Status='0'");
//check if user exist
 $NoRowRFQ1 = mysql_num_rows($resultRFQ1);
 

//check if user exist
 

 if ($_GET['sRFQ'] == "" OR $_GET['sRFQ'] == "ALL")
 {
 $resultLI = mysql_query("SELECT * FROM logistics WHERE OPWh='1' AND GoodsRv='1' AND GoodsDisp='1'");
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
 }
 else
 {
 $resultLI = mysql_query("SELECT * FROM logistics WHERE POID='".$_GET['sRFQ']."' AND OPWh='1' AND GoodsRv='1' AND GoodsDisp='1'");
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
 }

	

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Goods Dispatched Note</title>
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
	
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <?php include ('../topmenu2.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include ('leftmenu.php'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Goods Dispatched Note
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../warehousing"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Goods Dispatched Note</li>
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
			<option value=""> Choose PO code</option>
			<option value="ALL"> ALL</option>
			<?php if ($NoRowRFQ1 > 0) 
						{
							//fetch tha data from the database
							while ($row = mysql_fetch_array($resultRFQ1)) {
							
							?>
							<option value="<?php echo $row['PONum']; ?>"  <?php if ($_GET['sRFQ'] == $row['PONum']) { echo "selected";} ?>> <?php echo $row['PONum']; ?></option>
							<?php
							}
							
						}
																
			?>
									
			</select> 
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
		
		
		
        function open_container(LID, rfq, mst, qty, uom, lides, uw, uc, ds, fp, hsc, hst, pp, ip, dw, wl, dly, mkper, invc, shipn)
        {
			var title = 'View line item : '+LID;
			
            var size='large';
            var content = '<form role="form" method="post" action=""><div class="form-group">' +
            '<label>Previous Updates: '+mkper+'</label> </br></br>'  +
      
			'<label>Line Item\'s Description: </label>' +
            '<textarea required class="form-control" id="ItDes" name="ItDes" placeholder="" readonly >'+ lides + '</textarea>' +
            '<span class="glyphicon glyphicon-align-justify form-control-feedback"></span>' +
			'</div>' +
			
			
			'<div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">' +
		    '<label>Quantity of Item </label>' +
			'<input type="text" class="form-control" id="LIQty" name="LIQty" placeholder="Quantity" value="'+ qty +'" onInput="MainComp()" onKeyPress="return isNumber(event)" readonly />' +
			'</div>'+

			
			
			'<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Unit of Meas.: </label><input type="text" class="form-control" id="UOM" name="UOM" value="'+uom+'" readonly ></div>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;" ><label>Unit Weight (Kg): </label><input type="text" class="form-control" id="UnitWeight" name="UnitWeight" value="'+uw+'" onKeyPress="return isNumber(event)" onInput="MainComp()" readonly ></div>' +
			
			'<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Extended Weight (Kg): </label><input type="text" class="form-control" id="ExWeight" name="ExWeight" onKeyPress="return isNumber(event)" readonly  ></div>' +
			
			
			'<input type="hidden" name="LIID" value="'+ LID +'" ></input>' +
			'<input type="hidden" name="LIRFQ" value="'+ rfq +'" ></input>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>HS CODE: </label><input type="text" class="form-control" id="HSCODE" name="HSCODE" value="'+hsc+'" placeholder="HS CODE" readonly ></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Custom Duty: </label><input type="text" class="form-control" id="CustomDuty" name="CustomDuty" placeholder="Custom Duty" readonly ></div>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Delivery Ex-Works: </label><input type="text" class="form-control" id="DEX" name="DEX" value="'+dw+'" placeholder="Delivery Ex-works" readonly ></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Ex-Works Location: </label><input type="text" class="form-control" id="DEXL" name="DEXL" value="'+wl+'" placeholder="Delivery Ex-works Location" readonly ></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Delivery Cus. Location: </label><input type="text" class="form-control" id="DCUSL" name="DCUSL" value="'+dly+'" placeholder="Delivery Customers Location" readonly ></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Invoice No.: </label><input type="text" class="form-control" id="InvoiceN" name="InvoiceN" value="'+invc+'" placeholder="Invoice No." readonly></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Shipment No.: </label><input type="text" class="form-control" id="ShipmentN" name="ShipmentN" value="'+shipn+'" placeholder="Shipment No." readonly ></div>' +
      
      '<br/>';
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
	  $LitID = $row{'logID'};
	  $MatSer = $row['MartServNo'];
	  $Description = $row ['Description'];
	  $Qty = $row ['Qty'];
	  $UOM = $row ['UOM'];
    $OEM = $row ['OEM'];
	  $RFQn = $row ['RFQCode'];
	  $UnitWeight = $row ['UnitWeight'];
	  $HScode = $row ['HScode'];
	  $OEMUpdate = $row ['DeliveryUpdate'];
	  $DeliveryToWrkLocation = $row ['DeliveryToWrkLocation'];
    $POID = $row ['POID']; 
    $InvoiceN = $row ['InvoiceN']; 
    $ShipmentN = $row ['ShipmentN']; 
    $DeliveryRN = $row ['DeliveryRN']; 
    $GRSlipN = $row ['GRSlipN']; 
    $GRSlipDate = $row ['GRSlipDate']; 
	  $GRNDate = $row ['CreatedGoodsRvByOn']; 
    $GrnD = explode("On", $GRNDate);
    $GRNDate = $GrnD[1];
	  $DELIVERY = $row ['DELIVERY'];
	  $WorkLocation = $row ['WorkLocation'];
	  $Statu = $row ['Status'];
	  $GoodsRv = $row ['GoodsRv'];
	  $GoodsDisp = $row ['GoodsDisp'];
    $PartialDeli = $row ['PartialDeli'];
	  $FullDeli = $row ['FullDeli'];
	  
	
	  /* if ($CreateSO != '1') 
	   {
	  // $PCStatus = '<i class="fa fa-cog" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc1(this);"></i>';
	   $PCStatus = '<input type="checkbox" title="Open for Project Control" r="'.$LitID.'" ct="hpt'.$LitID.'", cm="hpm'.$LitID.'", cc="hpcm'.$LitID.'" jm="hj'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></input>';
	   }
	   if ($CreateSO == '1') 
	   {
	   //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
	   $PCStatus = '<input  type="checkbox" checked title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></input>';
	   }
	   */
	   if ($GoodsRv != '1') 
	   {
	  // $PCStatus = '<i class="fa fa-cog" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc1(this);"></i>';
	   $GoodsRvTech = '<input type="checkbox" title="Form M fulfilled" r="'.$LitID.'" jm="hpc'.$LitID.'" id="GoodsRv'.$LitID.'" onclick="GoodsRv(this);"></input>';
	   }
	   if ($GoodsRv == '1') 
	   {
	   //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
	   $GoodsRvTech = '<input  type="checkbox" checked title="Form M not fulfilled" r="'.$LitID.'" jm="hpc'.$LitID.'" id="GoodsRv'.$LitID.'" onclick="GoodsRv(this);"></input>';
	   }
	   if ($GoodsDisp != '1') 
	   {
	  // $PCStatus = '<i class="fa fa-cog" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc1(this);"></i>';
	   $GoodsDispTech = '<input type="checkbox" title="Air/Way Bill fulfilled" r="'.$LitID.'" jm="hpc'.$LitID.'" id="GoodsDisp'.$LitID.'" onclick="GoodsDisp(this);"></input>';
	   }
	   if ($GoodsDisp == '1') 
	   {
	   //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
	   $GoodsDispTech = '<input  type="checkbox" checked title="Air/Way not Bill fulfilled" r="'.$LitID.'" jm="hpc'.$LitID.'" id="GoodsDisp'.$LitID.'" onclick="GoodsDisp(this);"></input>';
	   }
	   
	   if ($PartialDeli  != '1') 
	   {
	  // $PCStatus = '<i class="fa fa-cog" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc1(this);"></i>';
	   $PartialDeliTech = '<input type="checkbox" title="Open for Warehouse" r="'.$LitID.'" jm="hpc'.$LitID.'" id="PartialDeli'.$LitID.'" onclick="PartialDeli(this);"></input>';
	   }
	   if ($PartialDeli == '1') 
	   {
	   //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
	   $PartialDeliTech = '<input  type="checkbox" checked title="Close from Warehouse" cm="CreateComm" r="'.$LitID.'" jm="hpc'.$LitID.'" id="PartialDeli'.$LitID.'" onclick="PartialDeli(this);"></input>';
	   }

     if ($FullDeli  != '1') 
     {
    // $PCStatus = '<i class="fa fa-cog" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc1(this);"></i>';
     $FullDeliTech = '<input type="checkbox" title="Open for Warehouse" r="'.$LitID.'" jm="hpc'.$LitID.'" id="FullDeli'.$LitID.'" onclick="FullDeli(this);"></input>';
     }
     if ($FullDeli == '1') 
     {
     //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
     $FullDeliTech = '<input  type="checkbox" checked title="Close from Warehouse" cm="CreateComm" r="'.$LitID.'" jm="hpc'.$LitID.'" id="FullDeli'.$LitID.'" onclick="FullDeli(this);"></input>';
     }
	  
	    $Record .='
					 <tr>
					  <td>'.$SN.'</td>
            <td>'.$GRNDate.'</td>
            <td>'.$POID.'</td>
            <td>'.$MatSer.'</td>
						<td>'.$Description.'</td>
						<td>'.$Qty.'</td>
            <td>'.$DeliveryRN.'</td>
					  <td>'.$GRSlipN.'</td>
            <td>'.$GRSlipDate.'</td>
						<td>'.$LitID.'</td>
						<td>'.$OEM.'</td>
           
						
	
						<td><a '.  'onclick="open_container('.$LitID.',\''.$RFQn.'\',\''.$MatSer.'\',\''.$Qty.'\',\''.$UOM.'\',\''.$Description.'\',\''.$UnitWeight.'\',\''.$UnitCost.'\',\''.$Discount.'\',\''.$FreightPercent.'\',\''.$HScode.'\',\''.$HsTarrif.'\',\''.$PackingPercent.'\',\''.$InsurePercent.'\',\''.$DeliveryToWrkLocation.'\',\''.$WorkLocation.'\',\''.$DELIVERY.'\',\''.$OEMUpdate.'\',\''.$InvoiceN.'\',\''.$ShipmentN.'\');">'. '<span class="fa fa-eye"></span></a></td>
						
						<td>'.$GoodsDispTech.'</td>
					
					
																																						
					 </tr>';
						$SN = $SN + 1;
     }
}
?>	

              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Date Received</th>
                        <th>PO Number</th>
                        <th>Material/Service</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Delivery Requisition No</th>
                        <th>G. R. Slip No</th>
                        <th>G. R. Slip Date</th>
						
                        <th>LiID</th>
                        <th>OEM</th>
                        
                        <th>View</th>
                        <th>Goods Disp.</th>
                      
                        
                       
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
	 <script type="text/javascript">
	 function GoodsRv(relm)
	 {
	   // alert("Grace");
		var gh = $(relm).attr('r');
		var ghid = $(relm).attr('id');
		//var prind = $(relm).attr('jm');
		//alert(ghid);
		var dataString = 'litem='+ gh;
		if($('#'+ghid).is(":checked") == true)
		{
		
			$.ajax({
			type: "POST",
			url: "GoodsRv1",
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
			url: "GoodsRv0",
			data: dataString,
			cache: false,
			success: function(html)
			{
						$("#FullDeli"+gh).prop('checked', false);
			}
			});
		}
		
	 }

   function GoodsDisp(relm)
   {
      //alert("Grace");
    var gh = $(relm).attr('r');
    var ghid = $(relm).attr('id');
   // var prind = $(relm).attr('jm');
    //alert(ghid);
    var dataString = 'litem='+ gh;
    if($('#'+ghid).is(":checked") == true)
    {
    
      $.ajax({
      type: "POST",
      url: "GoodsDisp1",
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
      url: "GoodsDisp0",
      data: dataString,
      cache: false,
      success: function(html)
      {
            $("#FullDeli"+gh).prop('checked', false);
      }
      });
    }
    
   }

   function PartialDeli(relm)
   {
      //alert("Grace");
    var gh = $(relm).attr('r');
    var ghid = $(relm).attr('id');
   // var prind = $(relm).attr('jm');
    //alert(ghid);
    var dataString = 'litem='+ gh;
    if($('#'+ghid).is(":checked") == true)
    {
    
      $.ajax({
      type: "POST",
      url: "PartialDeli1",
      data: dataString,
      cache: false,
      success: function(html)
      {
           
      }
      });
    
    }
    else
    {
    $.ajax({
      type: "POST",
      url: "PartialDeli0",
      data: dataString,
      cache: false,
      success: function(html)
      {
          $("#FullDeli"+gh).prop('checked', false);
      }
      });
    }
    
   }

   function FullDeli(relm)
   {
      //alert("Grace");
    var gh = $(relm).attr('r');
    var ghid = $(relm).attr('id');
   // var prind = $(relm).attr('jm');
    //alert(ghid);
    var dataString = 'litem='+ gh;
    if($('#'+ghid).is(":checked") == true)
    {
    
      $.ajax({
      type: "POST",
      url: "FullDeli1",
      data: dataString,
      cache: false,
      success: function(html)
      {
           $("#GoodsRv"+gh).prop('checked', true);
           $("#GoodsDisp"+gh).prop('checked', true);
           $("#PartialDeli"+gh).prop('checked', true);
          
      }
      });
    
    }
    else
    {
    $.ajax({
      type: "POST",
      url: "FullDeli0",
      data: dataString,
      cache: false,
      success: function(html)
      {
          //$("#OPWh"+gh).prop('checked', false);
      }
      });
    }
    
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
	 
	 
	 
	  
    </script>	
		
		
		
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  

         <?php include ('../footer.php'); ?>
      

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