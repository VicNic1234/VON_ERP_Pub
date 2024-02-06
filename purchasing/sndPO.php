<?php
session_start();
error_reporting(0);



function convert_number_to_words($number) {
    
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return $string;
}

include ('route.php');


$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';
$SaveM = 0;
//Now we need to get PRevious Details if Saved before,
    $resultPvInfo = mysql_query("SELECT * FROM poinfo WHERE PONum='".$_GET['sPO']."'");
    $NoRowPvInfo = mysql_num_rows($resultPvInfo);
  if ($NoRowPvInfo > 0) 
  {
    while ($row = mysql_fetch_array($resultPvInfo)) 
    {
      $SaveM = 1;
     $Terms = $row['Terms'];
     $SpecialNote = $row['SpecialNote'];
     $SvSupplier = $row['Supplier'];
     $SvCurrency = $row['Currency'];
     $SvCurrencySymb = $row['CurrencySymb'];
     $SupplierRefNum = $row['SupplierRefNum'];
     $OtherRefNum = $row['OtherRefNum'];
     $DespatchThrough = $row['DespatchThrough'];
     $Destination = $row['Destination'];
     $ConNme = $row['ConNme'];
     $ConEmail = $row['ConEmail'];
     $ConPhone = $row['ConPhone'];
     $PODate = $row['PODate'];
     $SvSubTotal = $row['SubTotal'];
     $SvTotal = $row['Total'];
     
    }
    
  }

  //here we need to get all Terms/Commissions from IncoTerms
  $resultCmInfo = mysql_query("SELECT * FROM poinfocomm WHERE PONum='".$_GET['sPO']."'");
    $NoRowCmInfo = mysql_num_rows($resultCmInfo);
     if ($NoRowCmInfo > 0) {
    $TSubTotal = 0;
  while ($row = mysql_fetch_array($resultCmInfo)) {
    $cmSN = $row ['sn'];
    $cmAmount = $row ['Amount'];
    $cmTitle = $row ['Title'];
      $cmRecord .='
           <tr>
              
            <td>&nbsp;</td>
            <td><input type="hidden" name="CommT['.$cmSN.'][Title]" value="'.$cmTitle.'" />'.$cmTitle.'</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp; <input type="hidden" name="CommT['.$cmSN.'][Amount]" value="'.number_format($cmAmount, 2).'" /></td>
            <td>'.number_format($cmAmount, 2).'</td>
            <td class="no-print"><i class="fa fa-edit"></i></td>
           </tr>';
            $SN = $SN + 1;
            //$SubTotal =  $SubTotal + $DPOAmt;
           $TSubTotal = $TSubTotal + $cmAmount;

             // ((float)$SubTotal, 2, '.', '')

     }

   if ($Currency == "NGN")
   {$SCur = "NGN";}
}

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

 //Get UOM
 $resultuom = mysql_query("SELECT * FROM uom");
$NoRowuom = mysql_num_rows($resultuom);
if ($NoRowuom > 1)
{
while ($row = mysql_fetch_array($resultuom )) {
$uom = $row{'UOMAbbr'};


$uom1 .= '<option value="'.$uom.'">'.$uom.'</option>';
}
}
 
//Get RFQ Details  
$resultRFQ = mysql_query("SELECT * FROM po WHERE PONum='".$_GET['sPO']."'");
$NoRowRFQ = mysql_num_rows($resultRFQ);
if ($NoRowRFQ > 0) {
	 	while ($row = mysql_fetch_array($resultRFQ)) 
	  {
	 
	  $POdate = $row['POdate'];
    $POAmtA = $row['Total'];
	 
	  }
	  
    }
	  
//Get customers Info
 $resultSup1 = mysql_query("SELECT * FROM suppliers WHERE SupNme='".$_GET['sSup']."'");
 $NoRowSup1 = mysql_num_rows($resultSup1);
if ($NoRowSup1 > 0) {
	 	while ($row = mysql_fetch_array($resultSup1)) 
	  {
	 
	  $SupAddress = $row['SupAddress'];
	  $SupPhone1 = $row['SupPhone1'];
	  
	  }
	  
    }

 $resultRFQ1 = mysql_query("SELECT * FROM po WHERE Status='0'");
//check if user exist
 $NoRowRFQ1 = mysql_num_rows($resultRFQ1);
 

$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);
$nsPO = $_GET['sPO'];
 
 $resultLI = mysql_query("SELECT * FROM logistics WHERE POID='".$nsPO."' Order By lineItID");
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
 
$resultSup = mysql_query("SELECT * FROM suppliers");
//check if user exist
 $NoRowSup = mysql_num_rows($resultSup);
if ($NoRowSup > 0) 
	{
	 	while ($row = mysql_fetch_array($resultSup)) 
	  {
	   $SupNme = $row['SupNme'];
	   $SupAddress = $row['SupAddress'];
	   $SupCountry = $row['SupCountry'];
	   $SupPhone1 = $row['SupPhone1'];
	   $SupPhone2 = $row['SupPhone2'];
	   $SupEMail = $row['SupEMail'];
	   $SupURL = $row['SupURL'];
	   $HJ = '<address>
                <strong>'.$SupNme.'</strong><br>
                '.$SupAddress.', '.$SupCountry.'<br>
                Phone: '.$SupPhone1.', '.$SupPhone2.'<br>
                Email: '.$SupEMail.'<br>
                URL: '.$SupURL.'<br>
              </address>';
              if ($SvSupplier == $SupNme){
                $RecordSup .='<option value="'.$HJ.'" selected >'.$SupNme.'</option>';
                $vwSupName = $SupNme; $vwSupAddress = $HJ;
              }
              else{
                $RecordSup .='<option value="'.$HJ.'">'.$SupNme.'</option>';
              }
	  }
	  
    }	

$resultCurr = mysql_query("SELECT * FROM currencies");
//check if user exist
 $NoRowCurr = mysql_num_rows($resultCurr);
if ($NoRowCurr > 0) 
  {
    while ($row = mysql_fetch_array($resultCurr)) 
    {
     $Abbreviation = $row['Abbreviation'];
     $Symbol = $row['Symbol'];
     $CurrencyName = $row['CurrencyName'];
     $HunderthName = $row['HunderthName'];
     
     if($SvCurrency == $CurrencyName || $SvCurrencySymb == $Symbol)
     {
        $RecordCurr .='<option value="'.$Abbreviation.'" selected >'.$CurrencyName.'</option>';
     }
     else
     {
        $RecordCurr .='<option value="'.$Abbreviation.'">'.$CurrencyName.'</option>';
     }
    }
    
    }
  

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
    window.location.href ="sndPO?sPO=" + hhh;
    //window.alert("JKJ");
     }
  
    }

function submitform()
{
 
 var formObj = $("#svState");
    var formURL = formObj.attr("action");
    var PO = "Hey YOU";
    var em = "Hey YOU";
    var dataString = 'PONumv='+ PO + '&termsv='+ em;
    //if(window.FormData !== undefined)  // for HTML5 browsers
    {
        //event.preventDefault();
        //var formData = new FormData(this);
        $.ajax({
            url: formURL,
            type: 'POST',
            data: $("#svState").serialize(),
            //data:  arttitle : "Joseph",
            //mimeType:"multipart/form-data",
            //contentType: false,
            cache: false,
            processData:false,
            success: function(html)
            {
                
               
                //$("#sucmsg").html(html);
               alert(html);
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
              // $("#errmsg").html(textStatus);
              alert(textStatus);
            }           
       });
        //e.preventDefault();
        //e.unbind();
   }
 /* else  //for olden browsers
    {
       
    $("#errmsg").html("Please upgrade your web browser, so that you can use this feature");
 
    }*/
}
</script>
    <div class="wrapper">

        <?php include('../topmenu2.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
       <?php include('leftmenu.php'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Send PO
            <small><?php echo $nsPO; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../internalsales"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Send PO</li>
          </ol>
        </section>
		
<div class="pad margin no-print">
          <div class="callout callout-info" style="margin-bottom: 0!important;">												
            <h4><i class="fa fa-info"></i> Note:</h4>
            This page has been enhanced for printing. Click the print button at the bottom of the Purchase Order to print.
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
                                         '<center id="sucmsg">'.  $G. '</center> '.
                                    '</div>' ; 
									$_SESSION['ErrMsg'] = "";}

 if ($B == "")
           {} else {
echo

'<div class="alert alert-info alert-dismissable">' .
                                       '<i class="fa fa-info-circle"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                        '<center id="errmsg">'.  $B. '</center> '.
                                    '</div>' ; 
									$_SESSION['ErrMsgB'] = "";}
?>
  
          
	
		
        </section><!-- /.content -->
<script>
function printDiv(divName) {
  
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     var divheight = $(document).height();
  if (divheight > 1513) {
    document.getElementById("pbholder").style.display = 'block';
  }
  else
  {
	  document.getElementById("pbholder").style.display = 'none';
  }
     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
 /*var newWindow = window.open();
    newWindow.document.write(printContents);
    newWindow.print();*/
   // 
  /* var prtContent = document.getElementById(divName);
var WinPrint = window.open('', '', 'left=0,top=0,width=100%,height=900,toolbar=0,scrollbars=0,status=0');
WinPrint.document.write(prtContent.innerHTML);
WinPrint.document.close();
WinPrint.focus();
WinPrint.print();
WinPrint.close();*/

} 

function ReadSupRFQ()
{
	
	document.getElementById('supinfo').innerHTML = document.getElementById('CusRFQ').value;
  //document.getElementById('svsupinfo').value = document.getElementById('CusRFQ').value;
  //alert(document.getElementById('CusRFQ').options[document.getElementById('CusRFQ').selectedIndex].text);
  document.getElementById('svsupinfo').value = document.getElementById('CusRFQ').options[document.getElementById('CusRFQ').selectedIndex].text;
}
function ReadCompany(elem)
{
	
	if(document.getElementById('POComp').value == 2) {
	$('#companynme1').html("KARI CARE TECHNOLOGY LIMITED");
	$('#companynme2').html("KARI CARE TECHNOLOGY LIMITED");
	$('#companynme3').html("KARI CARE TECHNOLOGY LIMITED");
	$('#companynme5').html("KARI CARE TECHNOLOGY LIMITED");
	$('#companynme6').html("KARI CARE TECHNOLOGY LIMITED");
	$('#companynme4').html("KARI CARE TECH. LTD.");
	$('#companyemail').html("");
	$('#cpEmail').html("");
	$('#companyurl').html(""); 
	$('#pelogo').hide();
	
	}
	
	if(document.getElementById('POComp').value == 1) {
	$('#companynme1').html("PE ENERGY LIMITED");
	$('#companynme2').html("PE ENERGY LIMITED");
	$('#companynme3').html("PE ENERGY LIMITED");
	$('#companynme5').html("PE ENERGY LIMITED");
	$('#companynme6').html("PE ENERGY LIMITED");
	$('#companynme4').html("PE ENERGY LTD");
	
	$('#companyemail').html("Email: commops@pengrg.com");
	$('#cpEmail').html("g.onukwufor@pengrg.com");
	$('#companyurl').html("URL: www.pengrg.com");
	$('#pelogo').show(); 
	}
}
function ReadCurrSym()
{
  //$('#yourdropdownid').find('option:selected').text();
  document.getElementById('currsym0').innerHTML = document.getElementById('Currn').value;
  document.getElementById('currsym1').innerHTML = document.getElementById('Currn').value;
  document.getElementById('currsym2').innerHTML = document.getElementById('Currn').value;
  document.getElementById('symnme').innerHTML = $('#Currn').find('option:selected').text();
  document.getElementById('currsymbv').value = document.getElementById('Currn').value;
  document.getElementById('currrealv').value = $('#Currn').find('option:selected').text();
}
</script>    
        <!-- Main content -->
<?php
//fetch tha data from the database
	 if ($NoRowLI > 0) {
	 $SN = 1; $SubTotal = 0;
	while ($row = mysql_fetch_array($resultLI)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
    $LitIDn = $row{'logID'};
	  $smPOID = $row{'POID'};
	  //$MatSer = $row['MatSer'];
	  $Description = $row ['Description'];
	  $Qty = $row ['Qty'];
	  $UOM = $row ['UOM'];
	  $DPOAmt = $POAmt = $row ['POAmt'];
     $DDate = $row ['DueDate'];
	  $PODiscount = $row ['PODiscount'];


     //$DPOAmt = $POAmt - (($PODiscount * $POAmt)/100);
    $Rate = $row ['UnitRate'];
	  $Currency = $row ['Currency'];
    if(number_format($PODiscount) == 0)
    {
      $DPOAmt = $Rate * $Qty;
    }
	  //$ExPrice = $Price * $Qty;
	  //$RIDn = "'#".$LitID."'";
	  //$RIDU = "'#".$LitID."U'";
    if ($DDate == "")
    {
      $DDate = $POdate;
    }
		
	    $Record .='
					 <tr>
					    <td><input type="hidden" name="POLineItem['.$SN.'][SNv]" value="'.$SN.'" />'.$SN.'</td>
						
						<td><input type="hidden" name="POLineItem['.$SN.'][Descriptionv]" value="" />'.$Description.'</td>
						<td><input type="hidden" name="POLineItem['.$SN.'][DDatev]" value="'.$DDate.'" />'.$DDate.'</td>
						<td><input type="hidden" name="POLineItem['.$SN.'][Quantityv]" value="'.$Qty. ' ' .$UOM.'" />'.$Qty. ' ' .$UOM. '</td>
						<td><input type="hidden" name="POLineItem['.$SN.'][Ratev]" value="'.number_format($Rate, 2).'" />'.number_format($Rate, 2).'</td>
						<td><input type="hidden" name="POLineItem['.$SN.'][UOMv]" value="'.$UOM.'" />'.$UOM.'</td>
            <td><input type="hidden" name="POLineItem['.$SN.'][PODiscountv]" value="'.$PODiscount.'" />'.$PODiscount.'</td>
						<td><input type="hidden" name="POLineItem['.$SN.'][DPOAmtv]" value="'.number_format($DPOAmt, 2).'" />'.number_format($DPOAmt, 2).'</td>
            <td class="no-print">&nbsp; &nbsp;<i class="fa fa-edit" disct="'.$PODiscount.'" ddate="'.$DDate.'" descr="'.$Description.'" qty="'.$Qty.'" urate="'.$Rate.'" poamt="'.$DPOAmt.'" uom="'.$UOM.'" smpo="'.$smPOID.'" litid="'.$LitIDn.'" onclick="editLIT(this);"></i></td>
						
					 </tr>';
						$SN = $SN + 1;
						$SubTotal =  $SubTotal + $DPOAmt;
             // ((float)$SubTotal, 2, '.', '')

     }

	 if ($Currency == "NGN")
	 {$SCur = "NGN";}
}
else
{
$Record .= '<tr><td colspan="9">Select PO Code to get list of PO Items</td> </tr>';
}
?>			
        <section class="invoice">
		<div class="row">
            <div class="col-md-12">
              <div class="box">
	<form>
   <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="LIRFQ" name="LIRFQ" onChange="ReadLineItem(this)">
			<option value=""> Choose PO code</option>
			<?php if ($NoRowRFQ1 > 0) 
						{
							//fetch tha data from the database
							while ($row = mysql_fetch_array($resultRFQ1)) {
							
							?>
							<option value="<?php echo $row['PONum']; ?>"  <?php if ($_GET['sPO'] == $row['PONum']) { echo "selected";} ?>> <?php echo $row['PONum']; ?></option>
							<?php
							}
							
						}
																
			?>
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>
           <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="POComp" name="POComp" onChange="ReadCompany(this);">
			<option value=""> Choose Company</option>
			<option value="1"> PE ENERGY LIMITED</option>
			<option value="2"> KARI CARE</option>
			
									
			</select>
		
     </div>
	 <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="CusRFQ" name="CusRFQ" onChange="ReadSupRFQ();">
			<option value=""> Choose Supplier</option>
			<?php echo $RecordSup; ?>
									
			</select>
		
     </div>

     <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
        <select class="form-control" id="Currn" name="Currn" onChange="ReadCurrSym();">
      <option value=""> Choose Currency</option>
      <?php echo $RecordCurr; ?>
                  
      </select>
    
     </div>

		

     <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
       <input class="form-control" placeholder="Supplier's Ref No." onInput="document.getElementById('suprefno').innerHTML = this.value; document.getElementById('suprefnov').value = this.value;" value="<?php echo $SupplierRefNum; ?>"> </input>
    
     </div>

     <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
       <input class="form-control" placeholder="Other Ref No." onInput="document.getElementById('orefno').innerHTML = this.value; document.getElementById('orefnov').value = this.value;" value="<?php echo $OtherRefNum; ?>"> </input>
    
     </div>

     <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
       <input class="form-control" placeholder="Despatch through" onInput="document.getElementById('desthrough').innerHTML = this.value; document.getElementById('desthroughv').value = this.value;" value="<?php echo $DespatchThrough; ?>"> </input>
    
     </div>

     <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
       <input class="form-control" placeholder="Destination" onInput="document.getElementById('des').innerHTML = this.value; document.getElementById('desv').value = this.value;" value="<?php echo $Destination; ?>"></input>
    
     </div>
     <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
       <input class="form-control" placeholder="Contact Name" onInput="document.getElementById('cpNme').innerHTML = this.value; document.getElementById('cpNmev').value = this.value;" value="<?php echo $ConNme; ?>"> </input>
    
     </div>
      <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
       <input class="form-control" placeholder="Contact Email" onInput="document.getElementById('cpEmail').innerHTML = this.value; document.getElementById('cpEmailv').value = this.value;" value="<?php echo $ConEmail; ?>" > </input>
    
     </div>
      <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
       <input class="form-control" placeholder="Contact Phone" onInput="document.getElementById('cpPhone').innerHTML = this.value; document.getElementById('cpPhonev').value = this.value;" value="<?php echo $ConPhone; ?>"> </input>
      <input type="hidden" name="commseries" id="commseries" value="0" />
    
     </div>

     <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
     <!-- <select onclick="chkterms(this);">
        <option>Choose Terms</option>
        <?php echo $RecTerms; ?>
      </select> -->
      <input type="button" onclick="open_container();" value="+ Commission">  </input>
      <input type="button" onclick="addLIT();" value="+ Line Item">  </input>
    </div>

    </form>

    <div class="form-group has-feedback" style="width:88%; display: inline-block; margin:12px; ">
       <textarea class="form-control" placeholder="Terms" onInput="$('#termsv').text(this.value);"><?php echo $Terms; ?></textarea>
    
     </div>
     <div class="form-group has-feedback" style="width:88%; display: inline-block; margin:12px; ">
       <textarea class="form-control" style="min-width:674px; min-height:124px;" placeholder="Special Note" onInput="$('#specialnote').text(this.value);"><?php echo $SpecialNote; ?></textarea>
    
     </div>
			  </div>
			</div>
		</div>
<script language="javascript">

    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    if (charCode == 189)
    {
      return true;
    }
    return true;
}

function addLIT(sPO)
{
  var uoms = '<?php echo $uom1; ?>';
  var sPO = '<?php echo $nsPO; ?>'; 
 //alert(sPO);
            var size='standart';
            var PONum = "<?php echo $_GET['sPO']; ?>";
            var content = '<form role="form" action="addPO" method="POST" ><div class="form-group">' +
             '<input type="hidden" value="" id="LitIDm" name="LitIDm" />'+
             '<input type="hidden" value="'+sPO+'" id="smPO" name="smPO" />'+
             '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label><textarea class="form-control" id="EditDes" name="EditDes" placeholder="Description"></textarea></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Due Date: </label><input type="text" class="form-control" style="z-index: 100000;" id="AddDueDate" name="AddDueDate" onInput="compute()" placeholder="Due Date" value="" readonly ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Quantity: </label><input type="text" class="form-control" id="EditQty" name="EditQty" placeholder="Quantity" onInput="compute()" value="" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Unit Rate: </label><input type="text" class="form-control" id="EditUnitRate" name="EditUnitRate" placeholder="Unit Rate" onInput="compute()" value="" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Discount %: </label><input type="text" class="form-control" id="EditDisc" name="EditDisc" placeholder="Discount" onInput="compute()" value="" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Amount: </label><input type="text" class="form-control" id="EditAmt" name="EditAmt" placeholder="Amount" onInput="compute()" value="" onKeyPress="return isNumber(event)" readonly ></div>' +
              //'<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Per (UOM): </label><input type="text" class="form-control" id="EditPer" name="EditPer" placeholder="Per" onInput="compute()" value=""  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Per (UOM): </label><select class="form-control" id="EditPer" name="EditPer" onInput="compute()">'+uoms+'</select></div>' +
              '<button type="submit" class="btn btn-primary">Update</button></form>';

            var title = 'Add Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
            $('#AddDueDate').datepicker();
    //return false;
  //alert(LinIT);
        
}




function editLIT(elem)
{
  //alert("Loving God so much");
  var LinIT = $(elem).attr("litid");
 
  var smPO = $(elem).attr("smpo");
  var DDate = $(elem).attr("ddate");
  var Qty = $(elem).attr("qty");
  var UnitCost = $(elem).attr("urate");
  var Descr = $(elem).attr("descr");
  var POAmt = $(elem).attr("poamt");
  var UOM = $(elem).attr("uom");
  var Discount = $(elem).attr("disct");

 // var Curren = '<?php echo $Curreny1; ?>';
  var uoms = '<?php echo $uom1; ?>';
 // var dataString = 'litem='+ LinIT;

   var size='standart';
            var content = '<form role="form" action="updatePO" method="POST" ><div class="form-group">' +
             '<input type="hidden" value="'+ LinIT +'" id="LitIDm" name="LitIDm" />'+
             '<input type="hidden" value="'+ smPO +'" id="smPO" name="smPO" />'+
             '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label><textarea class="form-control" id="EditDes" name="EditDes" placeholder="Description">'+Descr+'</textarea></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Due Date: </label><input type="text" class="form-control" style="z-index: 100000;" id="EditDueDate" name="EditDueDate" onInput="compute()" placeholder="Due Date" value="'+DDate+'" readonly ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Quantity: </label><input type="text" class="form-control" id="EditQty" name="EditQty" placeholder="Quantity" onInput="compute()" value="'+Qty+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Unit Rate: </label><input type="text" class="form-control" id="EditUnitRate" name="EditUnitRate" placeholder="Unit Rate" onInput="compute()" value="'+UnitCost+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Discount %: </label><input type="text" class="form-control" id="EditDisc" name="EditDisc" placeholder="Discount" onInput="compute()" value="'+Discount+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Amount: </label><input type="text" class="form-control" id="EditAmt" name="EditAmt" placeholder="Amount" onInput="compute()" value="'+POAmt+'" onKeyPress="return isNumber(event)" readonly ></div>' +
              //'<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Per (UOM): </label><input type="text" class="form-control" id="EditPer" name="EditPer" placeholder="Per" onInput="compute()" value="'+UOM+'"  ></div>' +
             
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Per (UOM): </label><select class="form-control" id="EditPer" name="EditPer" onInput="compute()">'+uoms+'</select></div>' +
              '<br/><button type="submit" class="btn btn-primary">Update</button></form>'+
              '<form role="form" action="removePOLi" method="POST"><input type="hidden" value="'+ LinIT +'" id="LitIDm" name="LitIDm" /> <button type="submit" class="btn btn-danger pull-right">Delete</button></form>';
             
            var title = 'Edit Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
            $('#EditDueDate').datepicker();
            $("#EditPer").val(UOM).change();
            
   /* $.ajax({
          type: "POST",
          url: "getLogID",
          data: dataString,
          cache: false,
          success: function(html)
          {
                //$("#"+prind).prop('checked', true);
                //alert(html);
                var obj = JSON.parse(html);
                //alert(obj[0].Description);
                //var TotalAmt = obj[0].UnitRate * obj[0].Qty;
                //var TotalAmt1 = TotalAmt - obj[0].PODiscount;


          }
          
      });
*/
    //return false;
  //alert(LinIT);
        
}

function compute()
{
  //alert('fdgfgdkj');
  var TotalAmt = parseFloat($('#EditQty').val()) * parseFloat($('#EditUnitRate').val());
                //$('EditAmt').val() 
                var ED = parseFloat($('#EditDisc').val());
                if(ED > 0)
{
  $('#EditAmt').val(TotalAmt - ((ED * TotalAmt)/100) );
}
else
{
  $('#EditAmt').val(TotalAmt);
}
                
                
}


function formatn(num){
    var n = num.toString(), p = n.indexOf('.');
    return n.replace(/\d(?=(?:\d{3})+(?:\.|$))/g, function($0, i){
        return p<0 || i<p ? ($0+',') : $0;
    });
}


function convertn(number) {

    if (number < 0) {

        console.log("Number Must be greater than zero = " + number);
        return "";
    }
    if (number > 100000000000000000000) {
        console.log("Number is out of range = " + number);
        return "";
    }
    if (!is_numeric(number)) {
        console.log("Not a number = " + number);
        return "";
    }

    var quintillion = Math.floor(number / 1000000000000000000); /* quintillion */
    number -= quintillion * 1000000000000000000;
    var quar = Math.floor(number / 1000000000000000); /* quadrillion */
    number -= quar * 1000000000000000;
    var trin = Math.floor(number / 1000000000000); /* trillion */
    number -= trin * 1000000000000;
    var Gn = Math.floor(number / 1000000000); /* billion */
    number -= Gn * 1000000000;
    var million = Math.floor(number / 1000000); /* million */
    number -= million * 1000000;
    var Hn = Math.floor(number / 1000); /* thousand */
    number -= Hn * 1000;
    var Dn = Math.floor(number / 100); /* Tens (deca) */
    number = number % 100; /* Ones */
    var tn = Math.floor(number / 10);
    var one = Math.floor(number % 10);
    var res = "";

    if (quintillion > 0) {
        res += (convert_number(quintillion) + " quintillion");
    }
    if (quar > 0) {
        res += (convert_number(quar) + " quadrillion");
    }
    if (trin > 0) {
        res += (convert_number(trin) + " trillion");
    }
    if (Gn > 0) {
        res += (convert_number(Gn) + " billion");
    }
    if (million > 0) {
        res += (((res == "") ? "" : " ") + convert_number(million) + " million");
    }
    if (Hn > 0) {
        res += (((res == "") ? "" : " ") + convert_number(Hn) + " Thousand");
    }

    if (Dn) {
        res += (((res == "") ? "" : " ") + convert_number(Dn) + " hundred");
    }


    var ones = Array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
    var tens = Array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");

    if (tn > 0 || one > 0) {
        if (!(res == "")) {
            res += " and ";
        }
        if (tn < 2) {
            res += ones[tn * 10 + one];
        } else {

            res += tens[tn];
            if (one > 0) {
                res += ("-" + ones[one]);
            }
        }
    }

    if (res == "") {
        console.log("Empty = " + number);
        res = "";
    }
    return res;
}

function is_numeric(mixed_var) {
    return (typeof mixed_var === 'number' || typeof mixed_var === 'string') && mixed_var !== '' && !isNaN(mixed_var);
}

var th = ['','thousand','million', 'billion','trillion'];
var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine']; var tn = ['ten','eleven','twelve','thirteen', 'fourteen','fifteen','sixteen', 'seventeen','eighteen','nineteen']; var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety']; function toWords(s){s = s.toString(); s = s.replace(/[\, ]/g,''); if (s != parseFloat(s)) return 'not a number'; var x = s.indexOf('.'); if (x == -1) x = s.length; if (x > 15) return 'too big'; var n = s.split(''); var str = ''; var sk = 0; for (var i=0; i < x; i++) {if ((x-i)%3==2) {if (n[i] == '1') {str += tn[Number(n[i+1])] + ' '; i++; sk=1;} else if (n[i]!=0) {str += tw[n[i]-2] + ' ';sk=1;}} else if (n[i]!=0) {str += dg[n[i]] +' '; if ((x-i)%3==0) str += 'hundred ';sk=1;} if ((x-i)%3==1) {if (sk) str += th[(x-i-1)/3] + ' ';sk=0;}} if (x != s.length) {var y = s.length; str += 'point '; for (var i=x+1; i<y; i++) str += dg[n[i]] +' ';} return str.replace(/\s+/g,' ');}


function capitalize(s) {
    // returns the first letter capitalized + the string from index 1 and out aka. the rest of the string
    return s[0].toUpperCase() + s.substr(1);
}

function addComm()
{
//$('#CommTab > tbody:last-child').append('<tr><td>'+ $('#CommTitle').val() + '</td><td>' + $('#CommAmt').val() + '</td>');
//Check if form is duly filled

var CT1 = $('#CommTitle').val();
var CA1 = $('#CommAmt').val();
if (CT1 != "" && CA1 != "") {
}
else
{
  if(confirm('Are you sure you want to add this Commission without Amount or Title?'))
      {} 
    else{return;}
}

var selectedVal = "";
var CommSeries = Number($('#commseries').val());
var NewS = CommSeries + 1;
$('#commseries').val(NewS);
var selected = $("input[type='radio'][name='commtype']:checked");
if (selected.length > 0) {
    selectedVal = selected.val();
    //alert( selectedVal);
}
//alert(NewS);
if (selectedVal == "DA")
{
 $('#MainTab > tbody:last-child').append('<tr><td>&nbsp;<input type="hidden" name="CommT['+ NewS +'][Title]" value="'+ $('#CommTitle').val() +'"/></td><td>'+ $('#CommTitle').val() + '</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;<input type="hidden" name="CommT['+ NewS +'][Amount]" value="'+ formatn($('#CommAmt').val()) +'"/></td><td>' + formatn($('#CommAmt').val()) + '</td></tr>');
 
}
else if (selectedVal == "PG")
{
  //Let's get the actual Amount now
  var realComm =  (CA1 * Number(document.getElementById("RealSubTotal").value))/100;

  $('#MainTab > tbody:last-child').append('<tr><td>&nbsp;<input type="hidden" name="CommT['+ NewS +'][Title]" value="'+ $('#CommTitle').val() +'"/></td><td>'+ $('#CommTitle').val() + '  <b>(' + $('#CommAmt').val() + '% )</b> </td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;<input type="hidden" name="CommT['+ NewS +'][Amount]" value="'+ realComm +'"/></td><td>' + realComm + ' </td></tr>');
   $('#CommAmt').val(realComm);
}


$('#myModal').modal('hide');
var NewComm = $('#CommAmt').val();
var RealAmt = $('#realAmt').val();
var AfterAmt = Number(RealAmt) + Number(NewComm);
$('#realAmt').val(AfterAmt);
//alert(AfterAmt);
var clenval = formatn(AfterAmt);


$('#ttv').html(clenval);
$('#ttv1').html(clenval);
var wordN = toWords(AfterAmt);
$('#ttw').html(capitalize(wordN));

$('#CommTitle').val('');
$('#CommAmt').val('');
}

        function open_container()
        {
            var size='standart';
            var content = '<form role="form"><div class="form-group">' +
   
     '<div class="form-group" style="width:100%; display: inline-block;"><label>Title: </label><input type="text" class="form-control" id="CommTitle" name="CommTitle" placeholder="Enter Title" required ></div>' +
      '<div class="form-group" style="width:100%; display: inline-block;"><center><label>Direct Amount <input type="radio" name="commtype" value="DA" checked /> </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label>Percentage <input type="radio" name="commtype" value="PG" /></label></center></div>' +
      '<div class="form-group" style="width:100%; display: inline-block;"><label>Amount: </label><input type="text" class="form-control" id="CommAmt" name="CommAmt" placeholder="Amount" onKeyPress="return isNumber(event)" required ></div>' +
      
      
      
      '<button type="button" onclick="addComm();" class="btn btn-primary">Add</button></form>';
            var title = 'Add New Commission';
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
    </div>
          <!-- title row -->
          <form id="svState" name="svState" action="addPOState" method="POST">
<div id="PrintArea" >
          <div class="row" style="margin-left:23px; margin-right:23px;">
            <div class="col-xs-12">
              <h2 class="page-header">
			        <input type="hidden" name="datastate" value="<?php echo $SaveM; ?>" />
			  <img id="pelogo" src="../mBOOT/plant.png" width="82px" height="80px" alt="PENL logo"/>
                <span id="companynme1">PE ENERGY LIMITED</span>
                <small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info" style="margin-left:23px; margin-right:23px;">
            <div class="col-sm-4 invoice-col">
              Invoice To
              <address>
                <strong id="companynme2">PE ENERGY LIMITED</strong><br>
                54 Emekuku Street, D-Line<br>
                Port Harcourt Rivers State, Nigeria<br>
                Phone: +234(84)360759 Ext. 105<br/>
                <span id="companyemail">Email: commops@pengrg.com</span><br/>
                <span id="companyurl">URL: www.pengrg.com</span>
              </address>
               <b>Terms of Delivery: </b>
                <br/>
                <textarea id="termsv" name="termsv" style="border: none" readonly><?php echo $Terms; ?> </textarea>
                <input type="hidden"  name="formtype" value="p"/>
                <br/>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
            Supplier
              <div id="supinfo"> <?php echo $vwSupAddress; ?> </div>
              <input type="hidden" name="svsupinfo" id="svsupinfo" />
              <br />
              
            </div><!-- /.col -->

            <div class="col-sm-4 invoice-col">
              <b>Purchase Order No.: </b> <?php echo $_GET['sPO']; ?>
              <input type="hidden" name="PONumv" id="PONumv" value="<?php echo $_GET['sPO']; ?>" />
			  <br/>
             <b>Supplier's Ref No.: </b> <span id ="suprefno"><?php echo $SupplierRefNum; ?></span>
             <input type="hidden" name="suprefnov" id="suprefnov" value="<?php echo $SupplierRefNum; ?>" />
        <br/>
           <b>Other Ref No.: </b> <span id ="orefno"><?php echo $OtherRefNum; ?></span>
            <input type="hidden" name="orefnov" id="orefnov" value="<?php echo $OtherRefNum; ?>" />
        <br/>
        <b>Despatch through: </b> <span id ="desthrough"><?php echo $DespatchThrough; ?></span>
          <input type="hidden" name="desthroughv" id="desthroughv" value="<?php echo $DespatchThrough; ?>" />
        <br/>
        <b>Destination: </b> <span id ="des"><?php echo $Destination; ?></span>
          <input type="hidden" name="desv" id="desv" value="<?php echo $Destination; ?>" />
        <br/>
          <br/>
       
        
       

              <b>Date: </b> <?php echo date("d/m/Y"); ?>
               <input type="hidden" name="poDatev" id="poDatev" value="<?php echo date("d/m/Y"); ?>" />
               <br/>
                <br/>
            </div><!-- /.col -->
          </div><!-- /.row -->

             
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table id="MainTab" class="table table-striped">
                 <thead>
                      <tr>
                        <th>S/N</th>
                       <th>Description</th>
                        <th>Due On</th>
                        <th>Quantity</th>
						            <th>Rate</th>
                        <th>Per</th>
                        <th>Disc %</th>
                        <th>Amount</th>
                        <th>&nbsp;</th>
                      
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><b>Sub Total</b></td>
                    <td><b id="currsym0"><?php echo $SvCurrencySymb; ?></b>&nbsp;<b style="text-decoration: overline;"><?php echo number_format($SubTotal, 2); ?></b><input type="hidden" id="RealSubTotal" name="RealSubTotal" value="<?php echo $SubTotal; ?>" /></td>
                    <td>&nbsp;</td>
                    </tr>
                    <?php echo $cmRecord; ?>
                    </tbody>
                 
              </table>
               <div style="float:right;">
              <table id="MoneySum" class="table table-striped">
               
                <tbody>
                 <tr>
                     <td>&nbsp;</td>
                    <td>&nbsp;</td>
                     <td>&nbsp;</td>
                        <td><b>Total</b></td>
                        <?php if ($TSubTotal > 0){ $SubTotal = $TSubTotal + $SubTotal; ?>
                        <td><b id="currsym1"><?php echo $SvCurrencySymb; ?></b>&nbsp;<b id="ttv1"><?php echo number_format($SubTotal, 2); ?></b> <input type="hidden" id="realAmt" name="realAmt" value="<?php echo $SubTotal; ?>"></input> </td>
                        <?php }
                        else
                          { ?> 
                        <td><b id="currsym1"><?php echo $SvCurrencySymb; ?></b>&nbsp;<b id="ttv1"><?php echo number_format($SubTotal, 2); ?></b> <input type="hidden" id="realAmt" name="realAmt" value="<?php echo $SubTotal; ?>"></input> </td>
                        <?php }
                        ?>
                       
                       
                      </tr>
                </tbody>

              </table>
            </div>
            </div><!-- /.col -->
          </div><!-- /.row -->

         <div class="row">
            <div class="col-xs-6 table-responsive">
              <table id="CommTab" class="table table-striped">
                 <thead>
                      <tr>
                        <th>&nbsp;</th>
                       <th>&nbsp;</th>
                     </tr>
                </thead>
                <tbody>
                 <!-- <tr>
                    <td></td>
                    <tr>
                        <th><b>Amount in word:</b> </th>
                        <th><b id="ttw"><?php echo ucwords(convert_number_to_words($POAmtA)); ?></b> </th>
                      </tr>
                    <td></td>
                  </tr> -->

                </tbody>

              </table>
            </div>
          </div>

<div id="pbholder" style="display: none; page-break-before: always;">
 <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
      
        <img src="../mBOOT/plant.png" width="30px" height="30px" alt="PENL logo"/>
                PE ENERGY LIMITED
                <small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
</div>

<!-- REMARK BASE -->
<div class="col-sm-4 invoice-col" >
 <b> Remarks: </b> <br/>
<b>For questions , please contact:</b><br/>

<b>Name:</b> &nbsp;<b id="cpNme"> Grace Adekola </b><br />
<input type="hidden" name="cpNmev" id="cpNmev" value="Grace Adekola" />
<b> <span id="companynme4">PE ENERGY LTD</span> </b> <br />

<b> No 54 Emekuku street, D/Line, Port Harcourt.</b><br/>

<b>Tel: </b> &nbsp;<b id="cpPhone">084-360759 EXT 105</b><br/>
<input type="hidden" name="cpPhonev" id="cpPhonev" value="084-360759 EXT 105" />

<b>Email:</b>&nbsp;<b id="cpEmail"> g.adekola@pengrg.com </b>
<input type="hidden" name="cpEmailv" id="cpEmailv" value="g.adekola@pengrg.com" />
</div><!-- /.col -->

<!-- SPECIAL NOTE -->
<div class="col-sm-4 invoice-col" >
 <b> Special Note: </b> <br/>
<textarea id="specialnote" name="specialnote" style="border: none; height: 20px; width: 50px;" readonly><?php echo $SpecialNote; ?> </textarea>

</div><!-- /.col -->


<!--- Summary Amount -->
<div class="col-sm-4 invoice-col" style="padding:12px; display:block; float:right; width:400px; border-radius: 25px; border: 2px solid #73AD21;">
 <b> for <span id="companynme3">PE ENERGY LIMITED</span> </b> <br/>
 <img src="../mBOOT/Procurement.png" />
<br />
<br />

<a> Procurement </a>: &nbsp;

<a> Authorised Signatory </a>
</div><!-- /.col -->
<br />
<div class="col-sm-4 invoice-col" style="padding:12px; display:block; float:right; width:400px; border-radius: 25px; border: 2px solid #73AD21;">
 <b> for <span id="companynme5">PE ENERGY LIMITED</span> </b> <br/>
 <img src="../mBOOT/FinanceAccount.png" />

<br />
<br />

<a> Finance & Accounts </a>: &nbsp;

<a> Authorised Signatory </a>
</div><!-- /.col -->
<br />
<div class="col-sm-4 invoice-col" style="padding:12px; display:block; float:right; width:400px; border-radius: 25px; border: 2px solid #73AD21;">
 <b> for <span id="companynme6">PE ENERGY LIMITED</span> </b> <br/>
 <img src="../mBOOT/ExecMgt.png" />

<br />
<br />

<a> Executive Mgt. </a>: &nbsp;

<a> Authorised Signatory </a>
</div><!-- /.col -->
<div class="col-sm-4 invoice-col" style="float:right; width:400px;">
  <b> Grand Total :</b> &nbsp; <b id="currsym2"></b>&nbsp;<b id="ttv"><?php echo number_format($SubTotal, 2); ?></b>
  <input type="hidden" id="currsymbv" name="currsymbv" />
  <br />
 <a> Amount chargeable (in words): </a> <br />
 <b id="ttw"><?php echo ucwords(convert_number_to_words($SubTotal)); ?></b> &nbsp; <b id="symnme"></b>
 <input type="hidden" id="currrealv" name="currrealv" />
</div> 
<br />
<br />
<br />
<br />
<br />



			  
          
         
</div>
<div class="row no-print">
            <div class="col-xs-12">
              <?php if($SaveM != 1) { ?>
            <label id="sumb" onclick="submitform();"class="btn btn-success pull-right"><i class="fa fa-save"></i> Save</label>
             <?php } else { ?>
            <label id="sumb" onclick="submitform();"class="btn btn-success pull-right"><i class="fa fa-undo"></i> Over write</label>
             <?php } ?>
             <!--   <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Note as Qutoted</button>
              <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Send Mail</button> -->
             
            </div>
          </div>
</form>
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
      });
    </script>
    <!-- DATA TABES SCRIPT -->
    <script src="../mBOOT/jquery-ui.js"></script>
    
  </body>
</html>