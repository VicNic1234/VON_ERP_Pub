<?php
session_start();
error_reporting(0);

include('route.php');

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';

//Let's get the Customers
$Cusresult = mysql_query("SELECT * FROM customers ORDER BY CustormerNme");
$CusOption = "";
 $CusNoRow = mysql_num_rows($Cusresult);

		if ($CusNoRow > 0) 
		{
			while ($row = mysql_fetch_array($Cusresult)) {
			   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
			  $cussnme1 = $row{'cussnme'};
			  $CustormerNme1 = $row['CustormerNme'];
			  if($CustormerNme1 != "" && $CustormerNme1 != " "){
			  	if($_GET['sCus'] == $cussnme1) {
				  $CusOption .= '<option value="'.$cussnme1.'" selected >'.$CustormerNme1 .'</option>';
				} 
				else
				{
				  $CusOption .= '<option value="'.$cussnme1.'">'.$CustormerNme1 .'</option>';
				}
			  }
			}
		}
 
 //$resultRFQ1 = mysql_query("SELECT * FROM po WHERE Status='0'");
 //$NoRowRFQ1 = mysql_num_rows($resultRFQ1);

$resultRFQ1 = mysql_query("SELECT DISTINCT POID FROM logistics WHERE PreAcc = 0 AND GoodsDisp = 1");
 $NoRowRFQ1 = mysql_num_rows($resultRFQ1);

 //$resultCus1 = mysql_query("SELECT DISTINCT Customer FROM logistics LEFT JOIN purchaselineitems ON logistics.LineItID=purchaselineitems.LitID WHERE sOpen = 1 ORDER BY Customer");
 //$NoRowCus1 = mysql_num_rows($resultCus1);
 


 if ($_GET['sRFQ'] == "")
 {
 $resultLI = mysql_query("SELECT * FROM logistics LEFT JOIN purchaselineitems ON logistics.LineItID=purchaselineitems.LitID Where PreAcc = '0' AND GoodsDisp = 1 ORDER BY logID DESC LIMIT 20 ");
 $NoRowLI = mysql_num_rows($resultLI);
 }
 else if ($_GET['sRFQ'] == "ALL")
 {
 $resultLI = mysql_query("SELECT * FROM logistics LEFT JOIN purchaselineitems ON logistics.LineItID=purchaselineitems.LitID Where PreAcc = '0' AND GoodsDisp = 1 ORDER BY logID DESC");
 $NoRowLI = mysql_num_rows($resultLI);
 }
  else
 {
 $resultLI = mysql_query("SELECT * FROM logistics LEFT JOIN purchaselineitems ON logistics.LineItID=purchaselineitems.LitID WHERE PreAcc = '0' AND GoodsDisp = 1 AND POID='".$_GET['sRFQ']."' ORDER BY logID DESC");
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
 }

 if ($_GET['sCus'] != "" && $_GET['sCus'] != "ALL")
 {
 $resultLI = mysql_query("SELECT * FROM logistics LEFT JOIN purchaselineitems ON logistics.LineItID=purchaselineitems.LitID Where PreAcc = '0' AND GoodsDisp = 1 AND purchaselineitems.Customer = '".$_GET['sCus']."'  ORDER BY logID DESC LIMIT 20 ");
 $NoRowLI = mysql_num_rows($resultLI);
 }
 

	

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr'] ?> ERP | Prepare Invoice </title>
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

     <?php include('../topmenu2.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
       <?php include('leftmenu.php'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            List of Goods Dispatched
            <small>Version <?php echo $_SESSION['version'] ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../logistics"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Transactions</li>
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
							<option value="<?php echo $row['POID']; ?>"  <?php if ($_GET['sRFQ'] == $row['POID']) { echo "selected";} ?>> <?php echo $row['POID']; ?></option>
							<?php
							}
							
						}
																
			?>
									
			</select> 
          </div>
    <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="CusRFQ" name="CusRFQ" onChange="ReadCus(this)">
			<option value=""> Choose Customer</option>
			<option value="ALL"> ALL</option>
			<?php echo $CusOption; ?>
									
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
function ReadCus(elem)
    {
       var hhh = elem.value;
	   if (hhh != "")
	   {	   
		window.location.href ="Qchk?sCus=" + hhh;
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
		
		
		
        function open_container(LID, rfq, mst, qty, uom, uw, uc, ds, fp, hsc, hst, pp, ip, dw, wl, dly, mkper, updt)
        {
			var title = 'OEM Update for line item : '+LID;
			//alert(rfq);
			//let's split hyperlink attachment
      var cleanlink = "";
      var attchs = updt.split("<br/>");
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

      var i1;
       for (i1 = 1; i1 < attchs.length; i1++) {
          cleanlink += "<a title='"+attchs[i1]+"' href='"+attchs[i1]+"'> [Download Attach] </a>";
                                                                
      } 
            var size='large';
            var content = '<form enctype="multipart/form-data" role="form" method="post" action="addOEMUp"><div class="form-group">' +
            '<label>Previous Updates: </label> <span style="color:#003366">'+mkper+'</span><br/><br/>'  +
      
			'<label>Line Item\'s Description: </label>' +
            '<textarea required class="form-control" id="ItDes" name="ItDes" placeholder="loading..." readonly ></textarea>' +
            '<span class="glyphicon glyphicon-align-justify form-control-feedback"></span>' +
			'</div>' +
			
			
			'<div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">' +
		    '<label>Quantity of Item </label>' +
			'<input type="text" class="form-control" id="LIQty" name="LIQty" placeholder="Quantity" value="'+ qty +'" onInput="MainComp()" onKeyPress="return isNumber(event)" readonly />' +
			'</div>'+

			
			
			'<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Unit of Meas.: </label><input type="text" class="form-control" id="UOM" name="UOM" value="'+uom+'" readonly ></div>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;" ><label>Unit Weight (Kg): </label><input type="text" class="form-control" id="UnitWeight" name="UnitWeight" value="'+uw+'" onKeyPress="return isNumber(event)" onInput="MainComp()" readonly ></div>' +
			
			'<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Extended Weight (Kg): </label><input type="text" class="form-control" id="ExWeight" name="ExWeight" onKeyPress="return isNumber(event)" readonly  ></div>' +
			
      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Quoted Freight: </label><input type="text" class="form-control" id="FrAmt" name="FrAmt" value="'+ dw+'" readonly  ></div>' +
      
			'<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Actual Freight: </label><input type="text" class="form-control" id="FrAmt" name="FrAmt" value="'+ dw+'"  ></div>' +
      
       '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Quoted LocalHandling: </label><input type="text" class="form-control" id="FrAmt" name="FrAmt" value="'+ dw+'" readonly  ></div>' +
      
      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Actual LocalHandling: </label><input type="text" class="form-control" id="FrAmt" name="FrAmt" value="'+ dw+'"  ></div>' +
      
			'<input type="hidden" name="LIID" value="'+ LID +'" ></input>' +
			'<input type="hidden" name="LIRFQ" value="'+ rfq +'" ></input>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>HS CODE: </label><input type="text" class="form-control" id="HSCODE" name="HSCODE" value="'+hsc+'" placeholder="HS CODE" readonly ></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Custom Duty: </label><input type="text" class="form-control" id="CustomDuty" name="CustomDuty" placeholder="Custom Duty" readonly ></div>' +
			
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Delivery Ex-Works: </label><input type="text" class="form-control" id="DEX" name="DEX" value="'+dw+'" placeholder="Delivery Ex-works" readonly ></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Ex-Works Location: </label><input type="text" class="form-control" id="DEXL" name="DEXL" value="'+wl+'" placeholder="Delivery Ex-works Location" readonly ></div>' +
			'<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Delivery Cus. Location: </label><input type="text" class="form-control" id="DCUSL" name="DCUSL" value="'+dly+'" placeholder="Delivery Customers Location" readonly ></div>' +
			
      
      '<div class="form-group has-feedback" style="width:40%; display:inline-block; margin:12px;">'+
      '<label>Attach Document (Optional) </label>' +
            '<input type="file" id="LOFile" name="LOFile" class="form-control" />'+
      
          
      '</div><br/>' + 
      '<label>Previous Attachments: '+ cleanlink +'</label> </br></br>'  +
      '<br/>' +
      '<label>Enter Comment: <span style="color:#00CC00">Allow Bulk Update</span>  <input type="checkbox" name="bulkupdate" id="bulkupdate" /> </label>' +
            '<textarea class="form-control" id="OEMUpdate" name="OEMUpdate" placeholder="Enter recent OEM Update" required ></textarea>' +
           
      '</div>' +
			
			
			'<button type="submit" style="margin:12px;" class="btn btn-primary">Update Status</button></form>';
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
	  $RFQn = $row ['POID'];
	  $UnitWeight = $row ['UnitWeight'];
	  $HScode = $row ['HScode'];
	  $DueDate = $row ['DueDate'];
	  $Cus = $row ['Customer'];
	  //$DueDate = DateTime::createFromFormat('Y/m/d', $DueDate)->format('Y/m/d');
	  $date=date_create($DueDate);
      $DueDate = date_format($date,"Y/m/d");
	  $ToDay = date("Y/m/d");
	  if($DueDate > $ToDay) {$DueDate = "<b style='color:green'>". $DueDate ."</b>"; }
	  	else {$DueDate = "<b style='color:red'>". $DueDate ."</b>";}
	  $OEMUpdate = $row ['OEMUpdate'];
	  $OEMUpdate = str_replace(array("\r\n", "\r", "\n"), "<br />", $OEMUpdate);//nl2br($OEMUpdate);
	  
	  $DeliveryToWrkLocation = $row ['DeliveryToWrkLocation'];
	  //$FOBExWorks = $row ['FOBExWorks'];
	  $DELIVERY = $row ['DELIVERY'];
	  $WorkLocation = $row ['WorkLocation'];
	  $Statu = $row ['Status'];
	  $RVFm = $row ['RVFm'];
	  $RWBill = $row ['RWBill'];
    $OPWh = $row ['OPWh'];
	  $CreatedOPWhByOn = $row ['CreatedOPWhByOn'];
    $CreatedRVFmByOn = $row ['CreatedRVFmByOn'];
    $CreatedRWBillByOn = $row ['CreatedRWBillByOn'];
    $pAttach = $row ['AttachmentUpdate'];
    $PO = $row ['SetForIn'];
    

	  
	
	   if ($PO != '1') 
	   {
	  // $PCStatus = '<i class="fa fa-cog" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc1(this);"></i>';
	  $PO = '<input type="checkbox" title="Set for Invoicing" id="setin'.$LitID.'" value="'.$LitID.'" OnClick="CPEXPerf(this)" ></input>';
	   
	   }
	   if ($PO == '1') 
	   {
	   //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
	   $PO = '<input type="checkbox" title="Unset for Invoicing" id="setin'.$LitID.'" value="'.$LitID.'" OnClick="CPEXPerf(this)" checked ></input>';
	   
	   }
	   


	  
	    $Record .='
					 <tr>
					    <td>'.$SN.'</td>
					    <td>'.$RFQn.'</td>
						<td>'.$MatSer.'</td>
						<td>'.$Description.'</td>
						<td>'.$Qty.'</td>
						<td>'.$UOM.'</td>
						
						<td>'.$LitID.'</td>
						<td>'.$OEM.'</td>
						<td>'.$DueDate.'</td>
						<td>'.$Cus.'</td>
						<td>'.$CreatedRVFmByOn.'</td>
            			<td>'.$CreatedRWBillByOn.'</td>
            			<td>'.$PO.'</td>
																																						
					 </tr>';
						$SN = $SN + 1;
     }
}
?>	

              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>PO Num</th>
                        <th>Material/Service</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>UOM</th>
						
                        <th>LiID</th>
                        <th>OEM</th>
                        <th>MOS Date</th>
                        <th>Customer</th>
                        
                        
                       
                        <th>Form M Date</th>
                       
                        <th>Air/Way Bill Date</th>
                      
                       	<th>Set for Invoice</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    
                  </table>
                 </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
	 <script type="text/javascript">
	 function CPEXPerf(relm)
	 {
	    //alert("Grace");
		var gh = $(relm).val();
		var ghid = $(relm).attr('id');
		//var prind = $(relm).attr('jm');
		//alert(ghid);
		var dataString = 'litem='+ gh;
		if($(relm).is(":checked") == true)
		{
		
			$.ajax({
			type: "POST",
			url: "Set4In",
			data: dataString,
			cache: false,
			success: function(html)
			{
					//alert(html);//$("#"+prind).prop('checked', true);
			}
			});
		
		}
		else
		{
		$.ajax({
			type: "POST",
			url: "UnSet4In",
			data: dataString,
			cache: false,
			success: function(html)
			{
						//$("#OPWh"+ghid).prop('checked', false);
			}
			});
		}
		
	 }

   function RWBill(relm)
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
      url: "RWBill1",
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
      url: "RWBill0",
      data: dataString,
      cache: false,
      success: function(html)
      {
            $("#OPWh"+gh).prop('checked', false);
      }
      });
    }
    
   }

   function OPWh(relm)
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
      url: "OPWh1",
      data: dataString,
      cache: false,
      success: function(html)
      {
            $("#RVFm"+gh).prop('checked', true);
            $("#RWBill"+gh).prop('checked', true);
      }
      });
    
    }
    else
    {
    $.ajax({
      type: "POST",
      url: "OPWh0",
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
	  

      <?php include('../footer.php'); ?>

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