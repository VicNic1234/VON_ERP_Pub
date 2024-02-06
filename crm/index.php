<?php
session_start();
error_reporting(0);

include('route.php');

$prasa = $_SESSION['Picture'];


$_SESSION['sCus'] = $_SESSION['CustomerID'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';

$GetCustomer = mysql_query("SELECT * FROM customers WHERE cusid = '".$_SESSION['sCus']."'");
$NoOfCus = mysql_num_rows($GetCustomer);

 if ($NoOfCus > 0) 
    {
	 
	while ($row = mysql_fetch_array($GetCustomer)) 
	    {
	    	$_SESSION['CusNme'] = $row['CustormerNme'];
		}


	}

$resultRFQ1 = mysql_query("SELECT DISTINCT so.CusONo AS POID FROM logistics LEFT JOIN purchaselineitems ON logistics.lineItID=purchaselineitems.LitID
 LEFT JOIN so ON purchaselineitems.SOCode=so.SONum 
 WHERE sOpen = 1 AND purchaselineitems.cusid = '".$_SESSION['sCus']."'");
 $NoRowRFQ1 = mysql_num_rows($resultRFQ1);

 if($_GET['sPO'] == "")
 {
	 $resultLI = mysql_query("SELECT * FROM logistics LEFT JOIN purchaselineitems ON logistics.lineItID=purchaselineitems.LitID 
	  	LEFT JOIN so ON purchaselineitems.SOCode=so.SONum
	 	Where logistics.sOpen = '1' AND purchaselineitems.cusid = '".$_SESSION['sCus']."'  ORDER BY logID");
	 $NoRowLI = mysql_num_rows($resultLI);
 }
 else
 {
 	$resultLI = mysql_query("SELECT * FROM logistics LEFT JOIN purchaselineitems ON logistics.lineItID=purchaselineitems.LitID 
	  	LEFT JOIN so ON purchaselineitems.SOCode=so.SONum
	 	Where logistics.sOpen = '1' AND purchaselineitems.cusid = '".$_SESSION['sCus']."' 
	 	AND so.CusONo = '".$_GET['sPO']."'  ORDER BY logID");
	 $NoRowLI = mysql_num_rows($resultLI);

 }
 
?>
<!DOCTYPE html>
<html>
   <?php include('../CRMheader.php') ?>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

     <?php include('../CRMtopmenu.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
       <?php include('leftmenu.php'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Track Order
            <small>Version <?php echo $_SESSION['version'] ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../logistics"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Track order</li>
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
  
          
	<div class="alert alert-success alert-dismissable">
                                       <i class="fa fa-info-circle"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                         <center>Kindly click on the <i class="fa fa-eye"></i> icon by the extrem right of the table to see feedback and give feedback</center>
                                    </div>
	
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
		    <select class="form-control tokenize" id="LIRFQ" name="LIRFQ" onChange="ReadLineItem(this)">
			<option value=""> Choose PO code</option>
			<?php if ($NoRowRFQ1 > 0) 
						{
							//fetch tha data from the database
							while ($row = mysql_fetch_array($resultRFQ1)) {
							
							?>
							<option value="<?php echo $row['POID']; ?>"  <?php if ($_GET['sPO'] == $row['POID']) { echo "selected";} ?>> <?php echo $row['POID']; ?></option>
							<?php
							}
							
						}
			?>
			</select> 
			 <script>      
		        $('.tokenize').select2();
		         //$('#CurrencyN').select2();
		      </script>
        </div>

        <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
              <button type="button" onClick="bulkUpDate();" class="btn btn-success btn-block btn-flat"><i class="fa fa-search"></i> Search</button>
	    </div>

	    	
		  </form>

	</div>
	<script type="text/javascript">
		function bulkUpDate()
		{
			var updateTEXT = $('#updateTEXT').val(); 
			var updateITEM = $('#updateITEM').val(); 

			if(updateTEXT == ""){ alert('No information to update'); return false; }
			if(updateITEM == ""){ alert('Kindly select item(s) to update. Thanks.'); return false; }

			$('#updateFORM').submit(); 

		}

		function setbulkUpDate(elem)
		{
			//We have to get the
			var ITID = $(elem).attr('rid');
			var ITIDDeco = "'"+ITID+"'";
			//alert(ITID);
			var updateITEM = $('#updateITEM').val(); 
			var chk = updateITEM.indexOf(ITIDDeco);
			

			if($(elem).is(':checked'))
	        {
		          if (chk > -1) {    } 
				else { updateITEM = updateITEM + ITIDDeco + ","; $('#updateITEM').val(updateITEM);  }
	        }
	        else
	        {
		         if (chk > -1) { updateITEM = updateITEM.replace(ITIDDeco + ",", ""); $('#updateITEM').val(updateITEM);  } 
				else {  }
	        }

	        //var updateITEMn = $('#updateITEM').val();

	        //alert(updateITEMn);

		}
	</script>

<script>
function ReadLineItem(elem)
    {
       var hhh = elem.value;
	   if (hhh != "")
	   {	   
		window.location.href ="?sPO=" + hhh;
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
		
		
		
        function open_container(LID, LIDpuc, rfq, mst, convtRPn, currn, qty, uom, cusd, uw, uc, ds, fp, afp, lh, alh, hsc, hst, pp, ip, dw, wl, dly, mkper, updt)
        {
			var title = '<center> Track line item </center>';
			var Extwgt = qty * uw;
			//alert(Extwgt);
			//let's split hyperlink attachment
      var cleanlink = "";
     // var attchs = updt.split("<br/>");

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
                     //document.getElementById('ItDes').innerHTML = ItemD;
                     document.getElementById('ItFedBack').innerHTML = ItemD;

                  }
                  });

      /*var i1;
       for (i1 = 1; i1 < attchs.length; i1++) {
          cleanlink += "<a title='"+attchs[i1]+"' href='"+attchs[i1]+"'> [Download Attach] </a>";
                                                                
      } */
            var size='large';
            var content = '<form enctype="multipart/form-data" role="form" method="post" action="addFeedBack"><div class="form-group">' +
      		 '<br/>' +
			'<center color:#003300><label>Feedback Table</label></center><br />' +
			'<table class="table table-bordered table-striped table-responsive">'+
			'<thead><tr><th>MsgCode</th><th>Feedback</th><th><i class="fa fa-link"></i></th></tr></thead>'+
			'<tbody id="ItFedBack"></tbody>'+
			'</table>'+
            '<span id="ItDes" name="ItDes" placeholder="loading..." readonly ></span>' +
            '<span class="glyphicon glyphicon-align-justify form-control-feedback"></span>' +
			'</div><br/>' +
			'<input type="hidden" name="LineID" id="LineID"value="'+LID+'" />'+
        	'<label>Enter Feedback:</label>' +
            '<textarea class="form-control" id="OEMUpdate" name="OEMUpdate" placeholder="Enter recent Feedback" required ></textarea>' +
           	'<br />'+
      '</div>' +
			
			
			'<button type="submit" class="btn btn-success pull-right"><i class="fa fa-send"></i> Send</button><br /></form>';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
			//MainComp();
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
	<div class="box box-primary" style="border-radius:25px;">
                
                
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
	  $LitID = $row['logID'];
	  $LitIDpurch = $row['lineItID'];
	  $MatSer = $row['MartServNo'];
	  $Description = $row ['Description'];
	  $Qty = $row ['Qty'];
	  $UOM = $row ['UOM'];
      $OEM = $row ['OEM'];
	  $RFQn = $row ['POID'];
	  $UnitWeight = $row ['UnitWeight'];
	  $HScode = $row ['HScode'];
	  $DueDate = $row ['DueDate'];
	  $MOSDate = $row ['SODate'];

	  $Currency = $row ['Currency']; 
	  $Cus = $row ['Customer'];
	  //aLocalHandling
	  //$DueDate = DateTime::createFromFormat('Y/m/d', $DueDate)->format('Y/m/d');
	  $date=date_create($DueDate);
      $DueDate = date_format($date,"Y/m/d");
	  $ToDay = date("Y/m/d");
	  if($DueDate > $ToDay) {$DueDate = "<b style='color:green'>". $DueDate ."</b>"; }
	  	else {$DueDate = "<b style='color:red'>". $DueDate ."</b>";}
	  ///////////////////////////////////////////////////////////////////
	  $date1=date_create($MOSDate);
     $MOSDate = date_format($date1,"Y/m/d");
	  
	  if($MOSDate > $ToDay) {$MOSDate = "<b style='color:green'>". $MOSDate ."</b>"; }
	  	else {$MOSDate = "<b style='color:red'>". $MOSDate ."</b>";}


	  	/////////////////////////////////////////////////////////
	  //$OEMUpdate = $row ['OEMUpdate'];
	  //$OEMUpdate = str_replace(array("\r\n", "\r", "\n"), "<br />", $OEMUpdate);//nl2br($OEMUpdate);
	  $Freight = $row ['Freight'];
	  $aFreight = $row ['aFreight'];
	  $LocalHandling = $row ['LocalHandling']; 
	  $aLocalHandling = $row ['aLocalHandling']; 
	  $CustomDuty = $row ['CustomDuty']; 
	  $ConvtRPerN = $row ['ConvertRatePerN']; 
	  $DeliveryToWrkLocation = $row ['DeliveryToWrkLocation'];
	  //$FOBExWorks = $row ['FOBExWorks'];
	  $DELIVERY = $row ['DELIVERY'];
	  $WorkLocation = $row ['WorkLocation'];
	  $Statu = $row ['Status'];
	  $RVFm = $row ['RVFm'];
	  $DDPDATE = $row ['DDPDATE'];
	  $RWBill = $row ['RWBill'];
    $OPWh = $row ['OPWh'];
	  $CreatedOPWhByOn = $row ['CreatedOPWhByOn'];
    $CreatedRVFmByOn = $row ['CreatedRVFmByOn'];
    $CreatedRWBillByOn = $row ['CreatedRWBillByOn'];
    $pAttach = $row ['AttachmentUpdate'];
    
	    $Record .=' 
					 <tr>
					    <td>'.$SN.'</td>
						<td>'.$MatSer.'</td>
						<td>'.$Description.'</td>
						<td>'.$Qty.'</td>
						<td>'.$UOM.'</td>
						
						<td>'.$OEM.'</td>
						<td>'.$DueDate.'</td>
						<td>'.$MOSDate.'</td>
						<td><a '.  'onclick="open_container('.$LitID.',\''.$LitIDpurch.'\',\''.$RFQn.'\',\''.$MatSer.'\',\''.$ConvtRPerN.'\',\''.$Currency.'\',\''.$Qty.'\',\''.$UOM.'\',\''.$CustomDuty.'\',\''.$UnitWeight.'\',\''.$UnitCost.'\',\''.$Discount.'\',\''.$Freight.'\',\''.$aFreight.'\',\''.$LocalHandling.'\',\''.$aLocalHandling.'\',\''.$HScode.'\',\''.$HsTarrif.'\',\''.$PackingPercent.'\',\''.$InsurePercent.'\',\''.$DeliveryToWrkLocation.'\',\''.$WorkLocation.'\',\''.$DELIVERY.'\',\''.$OEMUpdate.'\',\''.$pAttach.'\');">'. '<span class="text-green fa fa-eye" title="Click to see and add feedback"></span></a></td>
																																						
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
                        <th>Material/Service</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>UOM</th>
                        <th>OEM</th>
                        <th>Ex-work Date</th>
                        <th>MOS Date</th>
                       
                        <th>Track</th>
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
	 function RVFm(relm)
	 {
	    //alert("Grace");
		var gh = $(relm).attr('r');
		var ghid = $(relm).attr('id');
		//var prind = $(relm).attr('jm');
		//alert(ghid);
		var dataString = 'litem='+ gh;
		if($('#'+ghid).is(":checked") == true)
		{
		
			$.ajax({
			type: "POST",
			url: "RVFm1",
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
			url: "RVFm0",
			data: dataString,
			cache: false,
			success: function(html)
			{
						$("#OPWh"+gh).prop('checked', false);
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
        $("#userTab").dataTable({
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