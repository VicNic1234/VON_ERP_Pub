<?php
session_start();
error_reporting(0);

include('route.php');


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
//Get currency symbols
 $resultCurrency = mysql_query("SELECT * FROM currencies WHERE isActive =1");
 $NoRowCurrency = mysql_num_rows($resultCurrency);
if ($NoRowCurrency > 0) {
    while ($row = mysql_fetch_array($resultCurrency)) 
    {
   
    $Abbreviation = $row['Abbreviation'];
    $Symbol = $row['Symbol'];

    $CurOpt .= '<option value="'.$Symbol.'">'.$Abbreviation.'</option>';
   // $CusPhone = $row['CusPhone'];
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
//Get all customers
 $resultnCUS = mysql_query("SELECT * FROM customers");
 $NoRownCUS = mysql_num_rows($resultnCUS);
if ($NoRownCUS > 0) {
    while ($row = mysql_fetch_array($resultnCUS)) 
    {
   
    $CusNme = $row['CustormerNme'];
    $CusAddress = $row['CusAddress'];
    $CusPhone1 = $row['CusPhone1'];
    $CusPhone2 = $row['CusPhone2'];
    $CusEmail = $row['email'];
    $CusURL = $row['webaddress'];

    $csHJ = '<address>
                '.$CusAddress.',<br>
                Phone: '.$CusPhone1.', '.$CusPhone2.'<br>
                Email: '.$CusEmail.'<br>
                URL: '.$CusURL.'<br>
              </address>';
     $RecordCus .='<option value="'.$csHJ.'">'.$CusNme.'</option>';
    
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
<?php include('../header2.php') ?>
  <body class="skin-blue sidebar-mini">
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
    <div class="wrapper">

       <?php include('../topmenu2.php') ?>
      <!-- Left side column. contains the logo and sidebar -->
    <?php include('leftmenu.php') ?>
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
    $UnitPrice1 = number_format($ExPrice1r/$Qty, 2);
    $ExPrice2 = number_format($row ['EXPPrice'], 2);
    $ExPrice2r = $row ['EXPPrice'];
    $UnitPrice2 = number_format($ExPrice2r/$Qty, 2);
    $ExPrice3 = number_format($row ['CIFPPrice'], 2);
    $ExPrice3r = $row ['CIFPPrice'];
    $UnitPrice3 = number_format($ExPrice3r/$Qty, 2);
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
						<td class="unp1">'.$UnitPrice1.'</td>
            <td class="unp2" style="display:none">'.$UnitPrice2.'</td>
            <td class="unp3" style="display:none">'.$UnitPrice3.'</td>
						<td class="exp1">'.$ExPrice1.'</td>
            <td class="exp2" style="display:none">'.$ExPrice2.'</td>
            <td class="exp3" style="display:none">'.$ExPrice3.'</td>
						<td>'.$DeliveryToWrkLocation.'</td>
						<td class="exWkLoc">'.$WorkLocation.'</td>
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
      <div class="form-group has-feedback" style="width:195px; display: inline-block; margin:12px; ">
      <input type="text" id="AddrNme" oninput="document.getElementById('atn').innerHTML= document.getElementById('AddrNme').value;" placeholder="Addressee's Name" class="form-control">  </input>
    </div>
    <div class="form-group has-feedback" style="width:195px; display: inline-block; margin:12px; ">
     <!-- <input type="text" id="CurrSym" oninput="document.getElementById('currsym0').innerHTML= this.value; document.getElementById('currsym1').innerHTML= this.value; document.getElementById('currsym2').innerHTML= this.value;" placeholder="Currency Symbol">  </input>-->
    <select id="CurrSym" oninput="document.getElementById('currsym0').innerHTML= this.value; document.getElementById('currsym1').innerHTML= this.value; document.getElementById('currsym2').innerHTML= this.value; document.getElementById('currsym1mk').innerHTML= this.value" class="form-control">
      <option value="">Currency Symbol</option>
      <?php echo $CurOpt; ?>
    </select>
    </div>
    <br/>
		<div class="form-group has-feedback" style="width:125px; display: inline-block; margin:12px; ">
      <input type="button" onclick="rmvExw();" value="Hide Ex-Works" class="form-control btn-success">  </input>
    </div>
    <div class="form-group has-feedback" style="width:125px; display: inline-block; margin:12px; ">
      <input type="button" onclick="shwExw();" value="Show Ex-Works" class="form-control btn-success">  </input>
    </div>
     <div class="form-group has-feedback" style="width:195px; display: inline-block; margin:12px; ">
      <select onclick="chkterms(this);" class="form-control">
        <option>Choose Terms</option>
        <?php echo $RecTerms; ?>
      </select>
      
    </div>
     <div class="form-group has-feedback" style="width:75px; display: inline-block; margin:12px; ">
      <input type="button" onclick="open_container();" value="+ Terms" class="form-control btn-warning" />  
    </div>
    <div class="form-group has-feedback" style="width:215px; display: inline-block; margin:12px; ">
      <select onchange="Exwks();" id="incoterms" class="form-control">
        <option>Choose INCO Terms</option>
        <option value="DDP Price">DDP Price</option>
        <option value="Exworks Price">Exworks Price</option>
        <option value="CIF Price">CIF Price</option>
      </select>
     
    </div>
     <div class="form-group has-feedback" style="width:175px; display: inline-block; margin:12px; ">
      <label>  Subtract <input type="text" title="Discount on Subtotal" id="dismvkup" onInput="chkmvkup();" style="width:122px" class="form-control" /><input id="chkaDIS" type="checkbox" onClick="chkAddDiscount();" checked /> </label> <input type="text" placeholder="DISCOUNT%" onInput="cmpAddDis();" onChange="cmpAddDis();" onKeyPress="return isNumber(event)" id="addDis" style="display:block" class="form-control" />  
    </div>
     <div class="form-group has-feedback" style="width:175px; display: inline-block; margin:12px; ">
      <label>  Add <input type="text" title="MarkUp" id="mvkup" onInput="chkmvkup();" style="width:122px" class="form-control" /><input id="chkaMrk" type="checkbox" onClick="chkAddMrk();" checked /> </label> <input type="text" placeholder="MARKUP%" onInput="cmpAddMrk();" onChange="cmpAddMrk();" onKeyPress="return isNumber(event)" id="addMrk" style="display:block" class="form-control" />  
    </div>
    <div class="form-group has-feedback" style="width:175px; display: inline-block; margin:12px; ">
      <label>  Add <input type="text" title="Vat" id="mvup" onInput="chkmvup();" style="width:122px" class="form-control" /><input id="chkaVat" type="checkbox" onClick="chkAddVat();" checked /> </label> <input type="text" placeholder="VAT %" onInput="cmpAddVat();" onChange="cmpAddVat();" onKeyPress="return isNumber(event)" id="addVat" style="display:block" class="form-control" />  
    </div>
   
    <div class="form-group has-feedback" style="width:415px; display: inline-block; margin:12px; ">
      <select onchange="SetCustomer(this);" id="incoterms" class="form-control">
        <option value="">Choose Customer</option>
        <?php echo $RecordCus; ?>
      </select>
     
    </div>
    <br/>
    <div class="form-group has-feedback" style="width:100%; display: inline-block; margin:12px; ">
      <label>  Remark <input id="chkRemark" type="checkbox" onClick="chksetRemark();" checked /></label> <textarea placeholder="Remarks" onInput="setremark();" onChange="setremark();" id="snremark" style="display:block; width:100%" class="form-control"></textarea>  
    </div>
    <script type="text/javascript">

      function SetCustomer(elem){
       var SelCus = $(elem).find('option:selected').text();
       var SelCusV = $(elem).val();
       $('#rfqCus').html(SelCus); 
       $('#rfqCusAdd').html(SelCusV); 
      }

      function setremark(){
         var nRemark = $('#snremark').val();
        $('#remarkbox').html(nRemark);
      }

      function chksetRemark(){
        if($('#chkRemark').is(":checked") == true)
          {
            $('#remarkboxb').show();
          }
          else
          {
            $('#remarkboxb').hide();
          }
      }
    </script>
   
		  </form>
			  </div>
			</div>
		</div>
          <!-- title row -->
<div id="PrintArea">
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
			
			  <img src="../mBOOT/plant.png" width="70px" height="70px" alt="PENL logo"/>
                <?php echo $_SESSION['CompanyName']; ?>
                <small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong><?php echo $_SESSION['CompanyName']; ?></strong><br>
                54 Emekuku Street, D-Line<br>
                Port Harcourt Rivers State, Nigeria<br>
                Phone: +234(84)360759<br/>
                Email: sales@pengrg.com<br/>
                URL: www.pengrg.com
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              To
              <address>
                <strong id="rfqCus"><?php echo $CusNme; ?></strong><br>
                <span id="rfqCusAdd"><?php echo $CusAddress; ?></span><br>
                
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
                        <th id="ICNhead">Extended Price (DDP)</th>
                        
						 <th>Delivery Ex-works</th>
						<th class="exWkLoc">Ex-works Location</th>
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
                    
                      <tr id="dismrkrow">
                       
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        
                        <th id="dismrkuprow">Discount</th>
                        <th><span id="currsym1dis"></span>&nbsp;<span id="dismrkupvalue"></span></th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                       
                       
                      </tr>
                      <tr id="mrkrow">
                       
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        
                        <th id="mrkuprow">Markup</th>
                        <th><span id="currsym1mk"></span>&nbsp;<span id="mrkupvalue"></span></th>
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
var mrktp = Number(document.getElementById('addMrk').value);

var realSubTotal = Number(document.getElementById('rsubvalue').value);
//alert(vatp);
if (vatp == 0)
{
    document.getElementById('vatrow').innerHTML= document.getElementById('mvup').value;
    document.getElementById('vatvalue').innerHTML= '';
    if(mrktp == 0)
    {
     document.getElementById("totalvalue").innerHTML = formatn(realSubTotal.toFixed(2));
    }
    else
    {
        var mrkfig = (realSubTotal * mrktp) / 100;
        var NewTotal = mrkfig + realSubTotal;
         document.getElementById('mrkuprow').innerHTML= document.getElementById('mvkup').value + ' ' + mrktp + '%';
         document.getElementById('mrkupvalue').innerHTML= formatn(mrkfig.toFixed(2)); 
         document.getElementById("totalvalue").innerHTML = formatn(NewTotal.toFixed(2));
    }
}
else
{
    var mrkfig = (realSubTotal * mrktp) / 100;
    var NewTotal = mrkfig + realSubTotal;
     document.getElementById('mrkuprow').innerHTML= document.getElementById('mvkup').value + ' ' + mrktp + '%';
     document.getElementById('mrkupvalue').innerHTML= formatn(mrkfig.toFixed(2)); 
     document.getElementById("totalvalue").innerHTML = formatn(NewTotal.toFixed(2));

     var vatfig = (realSubTotal * vatp) / 100;
     var NewTotal1 = vatfig + realSubTotal + mrkfig;
     document.getElementById('vatrow').innerHTML= document.getElementById('mvup').value + ' ' + vatp + '%';
     document.getElementById('vatvalue').innerHTML= formatn(vatfig.toFixed(2)); 
     document.getElementById("totalvalue").innerHTML = formatn(NewTotal1.toFixed(2));

 
}


}

function cmpAddMrk()
{

var mrktp = Number(document.getElementById('addMrk').value);
var vatp = Number(document.getElementById('addVat').value);
var realSubTotal = Number(document.getElementById('rsubvalue').value);
//alert(vatp);
if (mrktp == 0)
{ 

    document.getElementById('mrkuprow').innerHTML= document.getElementById('mvkup').value;
    document.getElementById('mrkupvalue').innerHTML= '';
    if(vatp == 0)
    {
     document.getElementById("totalvalue").innerHTML = formatn(realSubTotal.toFixed(2));
    }
    else
    {
     var vatfig = (realSubTotal * vatp) / 100;
     var NewTotal = vatfig + realSubTotal;
     document.getElementById('vatrow').innerHTML= document.getElementById('mvup').value + ' ' + vatp + '%';
     document.getElementById('vatvalue').innerHTML= formatn(vatfig.toFixed(2)); 
     document.getElementById("totalvalue").innerHTML = formatn(NewTotal.toFixed(2));
    }
}
else
{
  if(vatp == 0)
  {
    var mrkfig = (realSubTotal * mrktp) / 100;
    var NewTotal = mrkfig + realSubTotal;
     document.getElementById('mrkuprow').innerHTML= document.getElementById('mvkup').value + ' ' + mrktp + '%';
     document.getElementById('mrkupvalue').innerHTML= formatn(mrkfig.toFixed(2)); 
     document.getElementById("totalvalue").innerHTML = formatn(NewTotal.toFixed(2));
  }
  else
  {
    var mrkfig = (realSubTotal * mrktp) / 100;
    var NewTotal = mrkfig + realSubTotal;
     document.getElementById('mrkuprow').innerHTML= document.getElementById('mvkup').value + ' ' + mrktp + '%';
     document.getElementById('mrkupvalue').innerHTML= formatn(mrkfig.toFixed(2)); 
     document.getElementById("totalvalue").innerHTML = formatn(NewTotal.toFixed(2));

     var vatfig = (realSubTotal * vatp) / 100;
     var NewTotal1 = vatfig + realSubTotal + mrkfig;
     document.getElementById('vatrow').innerHTML= document.getElementById('mvup').value + ' ' + vatp + '%';
     document.getElementById('vatvalue').innerHTML= formatn(vatfig.toFixed(2)); 
     document.getElementById("totalvalue").innerHTML = formatn(NewTotal1.toFixed(2));

  }
 
}


}

function cmpAddDis()
{

var distp = Number(document.getElementById('addDis').value);
var mrktp = Number(document.getElementById('addMrk').value);
var vatp = Number(document.getElementById('addVat').value);
var realSubTotal = Number(document.getElementById('rsubvalue').value);
//alert(vatp);
if (distp == 0)
{ 

    document.getElementById('dismrkuprow').innerHTML= document.getElementById('dismvkup').value;
    document.getElementById('dismrkupvalue').innerHTML= '';
    /*if(vatp == 0)
    {
     document.getElementById("totalvalue").innerHTML = formatn(realSubTotal.toFixed(2));
    }
    else
    {
     var vatfig = (realSubTotal * vatp) / 100;
     var NewTotal = vatfig + realSubTotal;
     document.getElementById('vatrow').innerHTML= document.getElementById('mvup').value + ' ' + vatp + '%';
     document.getElementById('vatvalue').innerHTML= formatn(vatfig.toFixed(2)); 
     document.getElementById("totalvalue").innerHTML = formatn(NewTotal.toFixed(2));
    }
    */
}
else
{
  /*if(vatp == 0)
  {
    var mrkfig = (realSubTotal * mrktp) / 100;
    var NewTotal = mrkfig + realSubTotal;
     document.getElementById('mrkuprow').innerHTML= document.getElementById('mvkup').value + ' ' + mrktp + '%';
     document.getElementById('mrkupvalue').innerHTML= formatn(mrkfig.toFixed(2)); 
     document.getElementById("totalvalue").innerHTML = formatn(NewTotal.toFixed(2));
  }
  else
  {
    var mrkfig = (realSubTotal * mrktp) / 100;
    var NewTotal = mrkfig + realSubTotal;
     document.getElementById('mrkuprow').innerHTML= document.getElementById('mvkup').value + ' ' + mrktp + '%';
     document.getElementById('mrkupvalue').innerHTML= formatn(mrkfig.toFixed(2)); 
     document.getElementById("totalvalue").innerHTML = formatn(NewTotal.toFixed(2));

     var vatfig = (realSubTotal * vatp) / 100;
     var NewTotal1 = vatfig + realSubTotal + mrkfig;
     document.getElementById('vatrow').innerHTML= document.getElementById('mvup').value + ' ' + vatp + '%';
     document.getElementById('vatvalue').innerHTML= formatn(vatfig.toFixed(2)); 
     document.getElementById("totalvalue").innerHTML = formatn(NewTotal1.toFixed(2));

  }
  */
 
}


}


function chkmvup()
{
  document.getElementById('vatrow').innerHTML= document.getElementById('mvup').value;
document.getElementById('vatvalue').innerHTML= '';
 document.getElementById("totalvalue").innerHTML = formatn(realSubTotal.toFixed(2)); //addVat
document.getElementById('addVat').value = 0;



}

function chkmvkup()
{
  document.getElementById('mrkuprow').innerHTML= document.getElementById('mvkup').value;
document.getElementById('mrkupvalue').innerHTML= '';
 document.getElementById("totalvalue").innerHTML = formatn(realSubTotal.toFixed(2)); //addVat
document.getElementById('addMrk').value = 0;


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

function chkAddMrk()
{
  if($('#chkaMrk').is(":checked") == true)
  {
     document.getElementById('addMrk').style.display = 'block';
     //document.getElementById('mrkrow').style.display = 'block';
     document.getElementById('mrkuprow').innerHTML= document.getElementById('mvkup').value;
      document.getElementById('currsym1mk').innerHTML= '';
      document.getElementById('mrkupvalue').innerHTML= '';

   
    // document.getElementById('vatboard').innerHTML= 'Vat';

  }
  else
  {
     document.getElementById('addMrk').style.display = 'none';
     document.getElementById('addMrk').value = '';
     //document.getElementById('mrkrow').style.display = 'none';
     document.getElementById('mrkuprow').innerHTML= '';
     document.getElementById('currsym1mk').innerHTML= '';
     document.getElementById('mrkupvalue').innerHTML= '';
     Exwks();
     document.getElementById('mrkuprow').innerHTML= '';
    // document.getElementById('vatboard').innerHTML= '';
  }
 
}


function chkAddDiscount()
{
  if($('#chkaDIS').is(":checked") == true)
  {
     document.getElementById('addDis').style.display = 'block';
     //document.getElementById('mrkrow').style.display = 'block';
     document.getElementById('dismrkuprow').innerHTML= document.getElementById('dismvkup').value;
      document.getElementById('currsym1dis').innerHTML= '';
      document.getElementById('dismrkupvalue').innerHTML= '';

   
    // document.getElementById('vatboard').innerHTML= 'Vat';

  }
  else
  {
     document.getElementById('addDis').style.display = 'none';
     document.getElementById('addDis').value = '';
     //document.getElementById('mrkrow').style.display = 'none';
     document.getElementById('dismrkuprow').innerHTML= '';
     document.getElementById('currsym1dis').innerHTML= '';
     document.getElementById('dismrkupvalue').innerHTML= '';
     Exwks();
     document.getElementById('dismrkuprow').innerHTML= '';
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
              <br /> <b>AUTHORIZED : For <?php echo $_SESSION['CompanyAbbr']; ?> </b> <br /><br />
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
<label>Terms</label>
<textarea id="qterms1" cols="135" height="auto" style="overflow: visible; border:none;" ></textarea>
<br/><br/>
<div id="remarkboxb">
<label>Remark</label>
<textarea id="remarkbox" cols="135" height="auto" readonly style="overflow: visible; border:none;" ></textarea>
</div>
            </div><!-- /.col -->
            <div class="col-xs-6">
             
            
            </div><!-- /.col -->
          </div><!-- /.row -->
</div>
          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <button  class="btn btn-default" onclick="printDiv('PrintArea')"><i class="fa fa-print"></i> Print</button>
              <form method="POST">
                <input type="hidden" />
             <button class="btn btn-success pull-right" title="this means you want to save this state"><i class="fa fa-save"></i> &nbsp; Save Quote State</button>
              </form>
              <!-- <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Send Mail</button> -->
            </div>
          </div>
        </section><!-- /.content -->
        <div class="clearfix"></div>
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
    <script type="text/javascript">
    function rmvExw() {
      $(".exWkLoc").hide();
    //$('td:nth-child(11),th:nth-child(11)').hide();
    //$('td:nth-child(10),th:nth-child(10)').hide();
    //$('td:nth-child(11),th:nth-child(11)').hide();
  }


  function shwExw() {
      $(".exWkLoc").show();
     //$('td:nth-child(11),th:nth-child(11)').show();
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
      //Class Hide
      $(".unp1").show(); $(".unp2").hide(); $(".unp3").hide();
      $(".exp1").show(); $(".exp2").hide(); $(".exp3").hide();
      $("#ICNhead").html("Extended Price (DDP)");
      var TotalV = '<?php echo $SubTotal1 ?>';
      /*$('tbody td:nth-child(8),thead th:nth-child(8)').show();
      $('tbody td:nth-child(9),thead th:nth-child(9)').hide();
      $('tbody td:nth-child(10),thead th:nth-child(10)').hide();*/
       document.getElementById("subvalue").innerHTML = '<?php echo $SubTotal1f; ?>';
        document.getElementById("rsubvalue").value = '<?php echo $SubTotal1; ?>';
       document.getElementById("totalvalue").innerHTML = '<?php echo $SubTotal1f; ?>';
       //document.getElementById("totalvalue").innerHTML = (Number(document.getElementById('chkaVat').value) * TotalV) / 100;
    }
    else if (yy == "Exworks Price")
    {
       $(".unp1").hide(); $(".unp2").show(); $(".unp3").hide();
       $(".exp1").hide(); $(".exp2").show(); $(".exp3").hide();
      $("#ICNhead").html("Extended Price (Exworks)");

     /* $('tbody td:nth-child(8),thead th:nth-child(8)').hide();
      $('tbody td:nth-child(9),thead th:nth-child(9)').show();
      $('tbody td:nth-child(10),thead th:nth-child(10)').hide();*/
       document.getElementById("subvalue").innerHTML = '<?php echo $SubTotal2f; ?>';
        document.getElementById("rsubvalue").value = '<?php echo $SubTotal2; ?>';
        document.getElementById("totalvalue").innerHTML = '<?php echo $SubTotal2f; ?>';
    }
    else if (yy == "CIF Price")
    {
       $(".unp1").hide(); $(".unp2").hide(); $(".unp3").show();
       $(".exp1").hide(); $(".exp2").hide(); $(".exp3").show();
      $("#ICNhead").html("Extended Price (CIF)");
       /*$('tbody td:nth-child(8),thead th:nth-child(8)').hide();
      $('tbody td:nth-child(9),thead th:nth-child(9)').hide();
      $('tbody td:nth-child(10),thead th:nth-child(10)').show();*/
      document.getElementById("subvalue").innerHTML = '<?php echo $SubTotal3f; ?>';
        document.getElementById("rsubvalue").value = '<?php echo $SubTotal3; ?>';
        document.getElementById("totalvalue").innerHTML = '<?php echo $SubTotal3f; ?>';
    }
    cmpAddVat();
    cmpAddMrk();
   
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