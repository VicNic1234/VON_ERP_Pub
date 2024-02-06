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

//////////// FRESH VENDOR'S INVOICE WORKS NOW ///////////////
//Here we have to get all the Customers
/*$resultCustomers = mysql_query("SELECT * FROM customers ORDER BY CustormerNme");
    $NoRowCust = mysql_num_rows($resultCustomers);
    $OptCustomer = '<option value=""> Choose Company</option>';
  if ($NoRowCust > 0) 
  {
    while ($row = mysql_fetch_array($resultCustomers)) 
    {
      $Cusi = $row['cusid'];
      $CusNme = $row['CustormerNme'];
      $OptCustomer .= '<option value="'.$Cusi.'">'.$CusNme.'</option>';
     
    }
  }
*/

//Here we have to get all the Customers
    $resultVendors = mysql_query("SELECT * FROM suppliers ORDER BY SupNme");
    $NoRowVen = mysql_num_rows($resultVendors);
    $OptSupplier = '<option value=""> Choose Company</option>';

  if ($NoRowVen > 0) 
  {
    while ($row = mysql_fetch_array($resultVendors)) 
    {
      $ssi = $row['supid'];
      $SupNme = $row['SupNme'];
      $OptSupplier .= '<option value="'.$ssi.'">'.$SupNme.'</option>';
     
    }
  }

/////////////////////////////////////////////////////
/////////////// SELECT CURRENCY /////////////////////
$resultCurr = mysql_query("SELECT * FROM currencies");
//check if user exist
 $NoRowCurr = mysql_num_rows($resultCurr);
if ($NoRowCurr > 0) 
  {
    while ($row = mysql_fetch_array($resultCurr)) 
    {
     $Abbreviation = trim($row['Abbreviation']);
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
///////// Here we need to Get ALl Cus PONumber//////////////////////
$resultCusOrderNum = mysql_query("SELECT * FROM so");
    $NoRowCusOrdNum = mysql_num_rows($resultCusOrderNum);
    $OptCusOrderNum = '<option value=""> Select Customer PO</option>';
  if ($NoRowCusOrdNum > 0) 
  {
    while ($row = mysql_fetch_array($resultCusOrderNum)) 
    {
      $poID = $row['poID'];
      $CusONo = $row['CusONo'];
      $OptCusOrderNum .= '<option value="'.$poID.'">'.$CusONo.'</option>';
     
    }
  }
/////////////////////////////////////////////////////


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
            <td class="no-print"><i  class="fa fa-edit"></i></td>
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

 
 $resultLI = mysql_query("SELECT * FROM accountinvoice WHERE POID='".$_GET['sPO']."' AND SetForIn='1' Order By logID");
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

$OptAddDed = "";
$resultSet = mysql_query("SELECT * FROM acc_settings Where variable='Payables' AND isActive=1");
//check if user exist
 $NoRowSet = mysql_num_rows($resultSet);
if ($NoRowSet > 0) 
  {
    while ($row = mysql_fetch_array($resultSet)) 
    {
      $varid = $row['id'];
      $variable = $row['variable'];
      $varval = $row['value'];
      $OptAddDed .='<option value="'.$varid.'">'.$varval.'</option>';
    }
  }

?>
<!DOCTYPE html>
<html>
        <?php include('../header2.php'); ?>

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
            Capture Vendor's Invoice
            <small id="SONUM"><?php echo $_GET['sPO']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../accounts"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Vendor's Invoice</li>
          </ol>
        </section>
    

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

</script>    

<section class="invoice">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      <div class="form-group has-feedback col-md-6">
        <label>Select Vendor</label>
          <select class="tokenize-demo form-control" id="VendorID" name="VendorID" required >
          <?php echo $OptSupplier; ?>
          </select>
      </div>
      <div class="form-group has-feedback col-md-1" title="Load All Invoice and POs of the Vendor">
       <label> &nbsp;</label>
       <button onClick="LoadVenPON();" class="form-control btn btn-success" type="button"><i class="fa fa-search"></i></button>
      <input id="SupGLV" type="hidden"  />
      </div>
      
      
      <script type="text/javascript">

      function LoadVenPON()
      {
        var VenID = $('#VendorID').val();
        $('#TINNoNum').val('');
        $('#TINNOV').html('');
        $('#VendorCodeNum').val('');
        $('#VendorCodeV').html('');

        var formData = { VenID:VenID };
        $.ajax({
            type: "POST",
            url: "../utility/getVenINV",
            data: formData,
            cache: false,
            success: function(html)
            {
                  var obj = JSON.parse(html);
                  $('#VendorPONo').html(obj['OptOrdNo']);
                  $('#InvoiceNum').html(obj['OptInvNo']);
                  $('#supNme').html(obj['SupNme']); 
                  $('#supAdd').html(obj['SupAddress']); 
                  $('#supEmail').html(obj['SupEmail']); 
                  $('#supPhone').html(obj['SupPhone']); 
                  $('#supUrl').html(obj['SupURL']);
                  $('#VendorCodeV').html(obj['SupRefNo']);
                  $('#VendorCodeNum').val(obj['SupRefNo']);
                  $('#TINNoNum').val(obj['TINNOV']);
                  $('#TINNOV').html(obj['TINNOV']);
                  $('#SupGLV').val(obj['SupGL']);
                   $('#PurchaseOrderV').html(''); 
                  $('#CusOrderV').html('');
                 $('#PESONumV').html(''); 
            }
            
        });
      }

      

      function LoadFrmPEEELInvoice()
      {
         $('#postbtn').attr('disabled', true);
        var IvnID = $('#InvoiceNum').val();
        //alert(IvnID);
        var formData = { IvnID:IvnID };
        $.ajax({
            type: "POST",
            url: "../utility/getSVDVENINV",
            data: formData,
            cache: false,
            success: function(html)
            {
                  var obj = JSON.parse(html);
                 $('#MainTab').html(obj['InvoiceItemTable']); 
                 $('#SubTab').html(obj['InvoiceCommissionTable']);
                 $('#CurrencyN').val(obj['Curr']); 
                 $('#PESONumV').html(obj['PurOrder']); 
                 $('#currsymv').html(obj['Curr']);
                 $('#currsymv1').html(obj['Curr']);
                 $('#subTotalV').html(obj['SubTotal']);
                 $('#RealSubTotal').val((obj['SubTotal']));
                 $('#TTotalVn').html(obj['TTotal']);
                 $('#realAmt').val((obj['TTotal']));
                 $('#TComm').val((obj['TComm']));
                 
                 $('#ttw').html(capitalize(toWords(obj['TTotal'])));
                 $('#ttv').html(obj['TTotal']);
                 $('#symnme').html($('#CurrencyN').find('option:selected').text()); //$('#yourdropdownid').find('option:selected').text();

                 $('#InvoiceNumV').html(obj['InvNum']);
                 $('#PurchaseOrderV').html(obj['PurOrder']); 
                 $('#CusOrderV').html(obj['CusONo']);  
                 $('#InvDateV').html(obj['InvDate']); 
                 $('#invDate').val(obj['InvDate']); 
                 $('#TermDay').val(obj['TermDay']); 
                 $('#PESONumV').html(obj['so']); 
                  if(obj['InvDate'] != "" && obj['InvDate'] != null)
                 {
                  $('#postbtn').attr('disabled', false);
                  
                 }

                  var date = $("#invDate").datepicker("getDate"); //Get the Date object with actual date
                  var TermsD = $("#TermDay").val();
                  if(TermsD < 1) { $("#TermDay").val(0);  date.setDate(date.getDate()); } //Set date object adding 3 days.
                  else { date.setDate(date.getDate() + Number(TermsD)); } //Set date object adding 3 days.
                 
                  $("#dueDate").datepicker("setDate", date); //Set the date of the datepicker with our date object
                  $("#dueDate").datepicker( "option", "minDate", date );
                  $("#dueDate").datepicker( "option", "maxDate", date );



            }
            
        });
      }

      function LoadFrmVenOrderNum()
      {
        $('#postbtn').attr('disabled', true);
        var VendorPONo = $('#VendorPONo').val();
        var formData = { VendorPONo:VendorPONo };
        $.ajax({
            type: "POST",
            url: "../utility/getINVVENNUM",
            data: formData,
            cache: false,
            success: function(html)
            {
                 //alert(html)
                 //return false;
                  var obj = JSON.parse(html);
                 //alert(obj['CurOdrdItemNum']);
                 //alert(obj['PESONum']);
                 
                 $('#MainTab').html(obj['InvoiceItemTable']);
                 $('#SubTab').html('');
                 $('#PurchaseOrderV').html(obj['PurOrder']); //PurchaseOrderV
                 //$('#PurchaseOrderV').html(obj['InvNum']); //PurchaseOrderV
                $('#InvoiceNumV').html('');
                //$('#nVendorCode').val('');
                //$('#VendorCodeV').html('');
                 //$('#CurrencyN selected:option').val(obj['Curr']);
                 $('#CurrencyN').val(obj['Curr']);

                  $('#currsymv').html(obj['Curr']);
                  $('#currsymv1').html(obj['Curr']);
                  $('#NGNCRate').html(obj['NGNCRate']);
                 $('#symnme').html($('#CurrencyN').find('option:selected').text()); //$('#yourdropdownid').find('option:selected').text();
                 $('#subTotalV').html(obj['SubTotal']);
                 $('#TTotalVn').html(obj['SubTotal']);
                 $('#RealSubTotal').val((obj['SubTotal']));
                 $('#realAmt').val((obj['SubTotal']));
                 $('#ttw').html(capitalize(toWords(obj['SubTotal'])));
                 $('#ttv').html(obj['SubTotal']);
                  $('#PurchaseOrderV').html(obj['PurchaseOrderV']); 
                  $('#CusOrderV').html(obj['CusOrder']);  
                  $('#PESONumV').html(obj['PESONum']);





                 //$('#MAKEINVOICE').show();
                 
            }
            
        });
      }
      </script>
    
      <div class="form-group has-feedback col-md-3">
        <label>Select PO for Vendor</label>
          <select class="tokenize-demo form-control" id="VendorPONo" name="VendorPONo" required >
          <!-- <?php echo $OptCusOrderNum; ?>  -->      
          </select>
      </div> 
      <div class="form-group has-feedback col-md-1"  title="Load Details of Order No">
       <label> &nbsp;</label>
       <button onClick="LoadFrmVenOrderNum();" class="form-control btn btn-success" type="button"><i class="fa fa-shopping-cart"></i> <i class="fa fa-download"></i></button>
      </div>
      
    <div id="GETINVOICE">
      <div class="form-group has-feedback col-md-2">
       <label>Select Currency</label>
        <select class="form-control" id="CurrencyN" name="CurrencyN" required >
         <option value=""> Choose Currency</option>
         <?php echo $RecordCurr; ?>
        </select>
     </div>
     <div class="form-group has-feedback col-md-3">
       <label> Invoice No. </label>
      
       <select class="tokenize-demo form-control" id="InvoiceNum" name="InvoiceNum" required >
        
       </select>
     </div>
      <div class="form-group has-feedback col-md-1" title="New Invoice">
       <label> &nbsp;</label>
       <button onClick="CreateNewInv();" class="form-control btn btn-success" type="button"><i class="fa fa-file"></i> <i class="fa fa-plus"></i></button>
     </div>
     <div class="form-group has-feedback col-md-1" title="Load Invoice Details">
       <label> &nbsp;</label>
       <button onClick="LoadFrmPEEELInvoice();" class="form-control btn btn-success" type="button"><i class="fa fa-file"></i> <i class="fa fa-download"></i></button>
      </div>
     <div class="form-group has-feedback col-md-2">
       <label> TINNo. </label>  
       <input class="form-control" id="TINNoNum" name="TINNoNum" onInput="$('#TINNOV').html($(this).val());" required >
     </div>
     <div class="form-group has-feedback col-md-3">
       <label> Vendor Code. </label>
       <input class="form-control" id="VendorCodeNum" name="VendorCodeNum" onInput="$('#VendorCodeV').html($(this).val());" required >
     </div>
    
    </div>
    <div class="form-group has-feedback col-md-2">
      <label> Invoice Date</label>
      <input type="text" class="form-control" id="invDate" readonly onChange="$('#InvDateV').html($(this).val());" />
    </div>
     <div class="form-group has-feedback col-md-2">
       <label> Terms (Days) </label>
       <input class="form-control" id="TermDay" name="TermDay" onInput="compDueDate();" required >
     </div>
     <div class="form-group has-feedback col-md-2">
      <label> Due Date</label>
      <input type="text" class="form-control" id="dueDate" readonly />
    </div>
    <div class="form-group has-feedback col-md-1">
      <label> &nbsp;</label>
      <button onClick="open_container();" id="commbtn" title="New Addition/Deduction" class="form-control btn btn-warning" type="button" ><i class="fa fa-plus"></i> <i class="fa fa-file"></i></button>
    </div>
    <script>

    function pad (str, max) {
      str = str.toString();
      return str.length < max ? pad("0" + str, max) : str;
    }

    function compDueDate()
    {
      var date = $("#invDate").datepicker("getDate"); //Get the Date object with actual date
            var TermsD = $("#TermDay").val();
            if(TermsD < 1) { $("#TermDay").val(0);  date.setDate(date.getDate()); } //Set date object adding 3 days.
            else { date.setDate(date.getDate() + Number(TermsD)); } //Set date object adding 3 days.
           
            $("#dueDate").datepicker("setDate", date); //Set the date of the datepicker with our date object
            $("#dueDate").datepicker( "option", "minDate", date );
            $("#dueDate").datepicker( "option", "maxDate", date ); 
    }
    </script>
    

     <div class="form-group has-feedback col-md-2">
      <label> &nbsp;</label>
      <button onClick="CaptureInvoice();" class="form-control btn btn-info" type="button"><i class="fa fa-save"></i> Save </button>
    </div>
      <div class="form-group has-feedback col-md-2">
       <label> &nbsp;</label>
       <button id="postbtn" onClick="POSTVenIN();" title="Post Transaction" class="form-control btn btn-warning" type="button" disabled ><i class="fa fa-send"></i> Post </button>
     </div>
    <script type="text/javascript">
    function POSTVenIN()
     {
        var POPEEL = $('#PurchaseOrderV').html();
        var InvDateV = $('#invDate').val();

        if(POPEEL == "") { alert("Kindly Load Invoice Details"); return false; }
          var VenID = $('#VendorID').val();
          var PEPO = $('#VendorPONo').val();
          var InvoiceNum = $('#InvoiceNum').val();
          var VendorCode = $('#VendorCodeNum').val();
          var CurrencyN = $('#CurrencyN').val();
          var TINNoNum = $('#TINNoNum').val();
          var PESONumV = $('#PESONumV').html();
          var SupGLV = $('#SupGLV').val();
          var GrwthEgn = "Values and Control";

        var VenNAME = $('#VendorID option:selected').text();

 if(VenID == "") { alert('Kindly select Vendor'); return false; }
      if(PEPO == "") { alert('Kindly select PO for Vendor'); return false; }
      if(InvoiceNum == "") { alert('Kindly select Invoice No'); return false; }
      if(TINNoNum == "") { alert('Kindly Type Vendor TIN.'); return false; }
      if(CurrencyN == "") { alert('Kindly select Currency'); return false; }
      if(InvDateV == "") { alert('Kindly select Invoice Date'); return false; }

        
        $.ajax({ type: "POST", url: "../utility/getGLacct", cache: false,
            success: function(html) {
              var obj = JSON.parse(html);
          var size='standart';
            var content = '<form role="form">' +
              
      '<div style="width:45%; margin-left:12px; display: inline-block;"> <label>Division Affected: </label> <span id="InDivision">'+GrwthEgn+'</span> </div><br/><br/>' +
      '<input type="hidden" name="VenNAMEID" id="VenNAMEID" value="'+VenID+'" />'+
        '<div class="form-group col-md-6"><label>Vendor: </label>  <input type="text" class="form-control" id="Vnn" name="Vnn" placeholder="" value="'+VenNAME+'" required readonly ></div>' +
        '<div class="form-group col-md-6"><label>Invoice Number: </label>  <input type="text" class="form-control" id="invnNo" name="invn" placeholder="" value="'+InvoiceNum+'" required readonly ></div>' +
            '<div class="form-group col-md-6"><label>Debit Account (Debit): </label>  <select class="form-control" id="GLInvent" onChange="setPAY()" name="GLInvent" required >'+obj['OptGLInventory']+'</select></div>' +
            '<div class="form-group col-md-6" style="display:none"><label>Trade Payables (Credit): </label>  <select class="form-control" id="GLPayable" onChange="setPAY()" name="GLPayable" required readonly >'+obj['OptGLPayable']+'</select></div>' +
            '<div class="form-group col-md-6"><label>Value Added (Debit): </label>  <select class="form-control" id="GLVadd" onChange="setPAY()" name="GLVadd" required >'+obj['OptGLValueAddOP']+'</select></div><br/><br/><br/><br/><br/><br/><br/><br/>' +
          
          '<div class="row"><hr><h4 style="margin-left:25px; font-weight:800"> Conversion </h4><br/>'+
         
          '<div class="col-md-10">'+
          '<table class="table table-striped" style="border: 2px;">'+
          '<tr>'+
          '<td> <label>Transaction Currency:</label> </td> <td> '+ CurrencyN +' </td> <td> NGN Exchange Rate :  </td> <td> <input type="text" id="ExchangeRate" class="form-control" onInput="ExchangeAmt()" onKeyPress="return isNumber(event)" /> </td>'+
          '</tr>'+
          '</table>'+
          '</div>'+  
          '<div class="col-md-10">'+
          '<table class="table table-striped">'+
          '<tr>'+
          '<td id="trAcc"> '+VenNAME+' </td>  <td> '+ CurrencyN +' <span id="trAccAmt"></span>  <td> <input type="text" id="trAcctVal" readonly class="form-control" /> </td>'+
          '</tr>'+
          '<tr>'+
          '<td id="drAcc">  </td> <td> '+ CurrencyN +' <span id="drAccAmt"></span> </td> <td> <input type="text" id="drAccVal" readonly class="form-control" /> </td>'+
          '</tr>'+
          '<tr>'+
          '<td id="vadddrAcc"> </td> <td> '+ CurrencyN +' <span id="vadddrAccAmt"></span> </td> <td> <input type="text" id="vadddrAccval" readonly class="form-control" /> </td>'+
          '</tr>'+
          '</table>'+
          '</div><br/>'+
          '<div class="row col-md-10">'+
            '<div class="form-group col-md-12"><label>Description: </label>  <textarea class="form-control" id="Descrp" name="Descrp" placeholder="Enter Summary or Remark here..."></textarea></div>' +
          '</div>'+  
          '<div class="row col-md-10">'+
          '<button type="button" onclick="postGL();" class="btn btn-warning pull-right"><i class="fa fa-send"></i> Post</button>'+
          '</div>'+
      
      
      '<br/><br/></form>';
            var title = 'POST PAYABLE TRANSACTION';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
            if(SupGLV > 0)
              { $('#GLInvent').val(SupGLV); }
            setPAY();
            ExchangeAmt();

            if(CurrencyN == "NGN") { $('#ExchangeRate').val(1);  ExchangeAmt(); }

              
            }

          });

      

     }

     function setPAY()
     {
      //$("#trAcc").html($('#GLPayable option:selected').text());
      $("#drAcc").html($('#GLInvent option:selected').text());
      $("#vadddrAcc").html($('#GLVadd option:selected').text());
      $("#trAccAmt").html($("#TTotalVn").html());
      $("#drAccAmt").html($("#subTotalV").html());
      $("#vadddrAccAmt").html($("#TComm").val());
     }

     function ExchangeAmt()
     {
        var ExRate = $('#ExchangeRate').val();
        ExRate = Number(ExRate);

        var trAccVal = $('#trAccAmt').html();
        trAccVal = trAccVal.replace(',','').replace(',','');
        trAccVal = Number(trAccVal) * ExRate;
        trAccVal = formatn(trAccVal.toFixed(2));
        $('#trAcctVal').val(trAccVal);

        var drAccVal = $('#drAccAmt').html();
        drAccVal = drAccVal.replace(',','').replace(',','');
        drAccVal = Number(drAccVal) * ExRate;
        drAccVal = formatn(drAccVal.toFixed(2));
        $('#drAccVal').val(drAccVal);

        var vadddrAccVal = $('#vadddrAccAmt').html();
        vadddrAccVal = vadddrAccVal.replace(',','').replace(',','');
        vadddrAccVal = Number(vadddrAccVal) * ExRate;
        vadddrAccVal = formatn(vadddrAccVal.toFixed(2));
        $('#vadddrAccval').val(vadddrAccVal);
     }


     function postGL()
     {
       var InvNo = $('#invnNo').val();
       var ExRateNGN = $('#ExchangeRate').val(); 
       var GLTPayable = 516;
       var GLDebit = $('#GLInvent').val();
       var GLVadd = $('#GLVadd').val();
       var Descrp = $('#Descrp').val();
       var InDivision = $('#InDivision').val();
       if(Number(ExRateNGN) == 0) { alert("Kindly set Exchange Rate"); return false;}
       ////////////////
       var vadddrAccVal = $('#vadddrAccval').val();
       var drAccVal = $('#drAccVal').val();
       var trAccVal = $('#trAcctVal').val();
       /////////////////

       var formData = {InvNo:InvNo, ExRateNGN:ExRateNGN, GLTPayable:GLTPayable, GLDebit:GLDebit, GLVadd:GLVadd, Descrp:Descrp, InDivision:InDivision,
         vadddrAccVal:vadddrAccVal, drAccVal:drAccVal, trAccVal:trAccVal };

       $.ajax({ type: "POST", url: "../utility/postPayable", data: formData, cache: false,
            success: function(html) { alert(html); }
          });

     }


    </script>

    <script type="text/javascript">

    function CaptureInvoice()
    {

        var POPEEL = $('#PurchaseOrderV').html();
        var InvDateV = $('#invDate').val(); 
        if(InvDateV == "" || InvDateV == null) { alert("Kindly select Date"); return false; }
        if(POPEEL == "") { alert("Kindly Load Invoice Details"); return false; }
        var VenID = $('#VendorID').val();
        var PEPO = $('#VendorPONo').val();
        var InvoiceNum = $('#InvoiceNum').val();
        var VendorCode = $('#VendorCodeNum').val();
        var CurrencyN = $('#CurrencyN').val();
        var TINNoNum = $('#TINNoNum').val();
        var PESONumV = $('#PESONumV').html(); 
        var CusOrderV = $('#CusOrderV').html(); 
        var VenNAME = $('#VendorID option:selected').text();
        $('#InvoiceID').val(InvoiceNum);
        $('#PEPONUM').val(POPEEL);
        //var InvDateV = $('#InvDateV').html();

            var TermsD = $("#TermDay").val();

      if(TermsD == "") { alert('Kindly select Number of Days in terms'); return false; }
      if(VenID == "") { alert('Kindly select Vendor'); return false; }
      if(PEPO == "") { alert('Kindly select PO for Vendor'); return false; }
      if(InvoiceNum == "") { alert('Kindly select Invoice No'); return false; }
      if(TINNoNum == "") { alert('Kindly Type Vendor TIN.'); return false; }
      if(CurrencyN == "") { alert('Kindly select Currency'); return false; }

       //Now we have to assign CusONo to the InvoiceNo
      var formData = { VenID:VenID, PEPO:PEPO, InvoiceNum:InvoiceNum, VendorCode:VendorCode, 
                       TINNoNum:TINNoNum, PESONumV:PESONumV, CusOrderV:CusOrderV, VenNAME:VenNAME, InvDateV:InvDateV,
                       CurrencyN:CurrencyN, TermsD:TermsD};

        $.ajax({ type: "POST", url: "../utility/captureInvoice", data: formData, cache: false,
            success: function(html) { 
              alert(html); 
              if(html == "Invoice Number Assigned Successfully!")
              {
                //MainTab
                $.ajax({
                    url: "../utility/captureInvoiceLI",
                    type: "POST",
                    data: $("#svState").serialize(),
                    cache: false,
                    processData:false,
                    success: function(html)
                    {
                      // alert(html);
                       $('#InvoiceNumV').html(html);
                    },
                    error: function(jqXHR, textStatus, errorThrown) 
                    {
                      alert(textStatus);
                    }           
               });

              }
              //else{ alert(html); }
            }
           // error: function(html) { alert(html); }
        });

    

           
      }
    </script>

     <script type="text/javascript">      
        $('.tokenize-demo').select2();
      </script>

    <script type="text/javascript">
      function CreateNewInv()
      {
        //var CusNAME = $('#InvoiceCusN').val();
       
         var VenID = $('#VendorID').val();
        var VenNAME = $('#VendorID option:selected').text();
          var size='standart';
            var content = '<form role="form">' +
   
      '<div class="form-group" style="width:100%; display: inline-block;"><label>Vendor: </label> <span>'+VenNAME+'</span></div>' +
      '<input type="hidden" name="VenNAMEID" id="VenNAMEID" value="'+VenID+'" />'+
      '<div class="form-group" style="width:100%; display: inline-block;"><label>Invoice Number: </label>  <input type="text" class="form-control" id="invn" name="invn" placeholder="" required ></div>' +
      
      
      
      '<button type="button" onclick="addInvoice();" class="btn btn-primary">Create Invoice</button></form>';
            var title = 'New Invoice';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
      }

      function addInvoice()
      {
        var VenNAMEID = $('#VenNAMEID').val();
        var invnNUM = $('#invn').val();
        if(VenNAMEID < 1) {alert('Kindly select Vendor'); return false;}
        var formData = { invnNUM:invnNUM, VenNAMEID:VenNAMEID };
        $.ajax({
            type: "POST",
            url: "../utility/newVenInvoice",
            data: formData,
            cache: false,
            success: function(html)
            {
                  var obj = JSON.parse(html);
                 
                 $('#InvoiceNum').html(obj['OptInvNo']);
                 $('#invn').val('');
                 $('#myModal').modal('hide');
                 alert(obj['Msg']);
                 
                 
            }
            
        });
      }
    </script>   


     

   

   
    
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

function addLIT()
{
 
            var size='standart';
            var content = '<form role="form" action="addPO" method="POST" ><div class="form-group">' +
             '<input type="hidden" value="" id="LitIDmn" name="LitIDmn" />'+
             '<input type="hidden" value="" id="smPO" name="smPO" />'+
             '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label><textarea class="form-control" id="EditDes" name="EditDes" placeholder="Description"></textarea></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Due Date: </label><input type="text" class="form-control" style="z-index: 100000;" id="AddDueDate" name="AddDueDate" onInput="compute()" placeholder="Due Date" value="" readonly ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Quantity: </label><input type="text" class="form-control" id="EditQty" name="EditQty" placeholder="Quantity" onInput="compute()" value="" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Unit Rate: </label><input type="text" class="form-control" id="EditUnitRate" name="EditUnitRate" placeholder="Unit Rate" onInput="compute()" value="" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Discount %: </label><input type="text" class="form-control" id="EditDisc" name="EditDisc" placeholder="Discount" onInput="compute()" value="" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Amount: </label><input type="text" class="form-control" id="EditAmt" name="EditAmt" placeholder="Amount" onInput="compute()" value="" onKeyPress="return isNumber(event)" readonly ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Per (UOM): </label><input type="text" class="form-control" id="EditPer" name="EditPer" placeholder="Per" onInput="compute()" value=""  ></div>' +
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
  /* 
LitID="'.$row['LitID'].'" MatSer="'.$row['MatSer'].
          '" Description="'.$row['Description'].'" Qty="'.$row['Qty'].
          '" UOM="'.$row['UOM'].'" DiscountAmt="'.$row['DiscountAmt'].
          '" UnitCost="'.$row['UnitCost'].'" ExtendedCost="'.$row['ExtendedCost'].
  */
  $('#postbtn').attr('disabled', true);
  var LitID = $(elem).attr("logID");
  var SNUM = $(elem).attr("SNUM");
  var MatSer = $(elem).attr("MatSer");
  var Description = $(elem).attr("Description");
  var Qty = $(elem).attr("Qty");
  var UOM = $(elem).attr("UOM");
  var UnitRate = $(elem).attr("UnitRate");
  var PODiscount = $(elem).attr("PODiscount"); 
  var POAmt = $(elem).attr("POAmt"); 

            var size='standart';
            var content = '<form><div class="form-group">' +
              '<input type="hidden" value="'+ LitID +'" id="LitIDmx" name="LitIDmx" />'+
              '<input type="hidden" value="'+ SNUM +'" id="SNUMm" name="SNUMm" />'+
              '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label><textarea class="form-control" id="EditDes" name="EditDes" placeholder="Description">'+Description+'</textarea></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Material/Service. No.: </label><input type="text" class="form-control" id="EditMatSer" name="EditMatSer" placeholder="Material/Service No." onInput="compute()" value="'+MatSer+'"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Quantity: </label><input type="text" class="form-control" id="EditQty" name="EditQty" placeholder="Quantity" onInput="compute()" value="'+Qty+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Unit Rate: </label><input type="text" class="form-control" id="EditUnitRate" name="EditUnitRate" placeholder="Unit Rate" onInput="compute()" value="'+UnitRate+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Discount %: </label><input type="text" class="form-control" id="EditDisc" name="EditDisc" placeholder="Discount" onInput="compute()" value="'+PODiscount+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Amount: </label><input type="text" class="form-control" id="EditAmt" name="EditAmt" placeholder="Amount" onInput="compute()" value="'+POAmt+'" onKeyPress="return isNumber(event)" readonly ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Per (UOM): </label><input type="text" class="form-control" id="EditPer" name="EditPer" placeholder="Per" onInput="compute()" value="'+UOM+'"  ></div>' +
              '<button onclick="updateLineItem()" type="button" class="btn btn-primary">Update</button></form>';
            var title = 'Edit Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
           // $('#EditDueDate').datepicker();
     
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

function updateLineItem(){
  var LitIDm = $('#LitIDmx').val();
  var SN = $('#SNUMm').val(); 
  var EditMatSer = $('#EditMatSer').val();
  var EditDes = $('#EditDes').html();
  var EditQty = $('#EditQty').val();
  var EditUnitRate = $('#EditUnitRate').val();
  var EditDisc = $('#EditDisc').val();
  var EditPer = $('#EditPer').val(); 
  var EditAmt = $('#EditAmt').val();

  var genTableRow = '<td><input type="hidden" name="POLineItem['+SN+'][logID]" value="'+LitIDm+'" />'+LitIDm+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][MatSer]" value="'+EditMatSer+'" />'+EditMatSer+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][Description]" value="'+EditDes+'" />'+EditDes+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][Qty]" value="'+EditQty+'" />'+EditQty+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][UOM]" value="'+EditPer+'" />'+EditPer+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][PODiscount]" value="'+EditDisc+'" />'+EditDisc+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][UnitRate]" value="'+EditUnitRate+'" />'+EditUnitRate+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][POAmt]" value="'+EditAmt+'" />'+EditAmt+'</td>'+
                      '<td class="no-print"><i class="fa fa-edit" LitID="'+LitIDm+'" MatSer="'+EditMatSer+
                      '" Description="'+EditDes+'" Qty="'+EditQty+
                      '" UOM="'+EditPer+'" PODiscount="'+EditDisc+
                      '" UnitRate="'+EditUnitRate+'" POAmt="'+EditAmt+
                      '" SNUM="'+SN+
                      '" onclick="editLIT(this);"></i></td>';
                      
 //We have to replace now 
 $('#li'+SN).html(genTableRow);
   $('#myModal').modal('hide');


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

function addCommm()
{
  var rowCount = $('#SubTab tr').length;
  var realSUBAMT = $('#RealSubTotal').val();
  var CT1 = $('#CommTitle option:selected').text();
  var nCT1 = $('#CommTitle').val();
  var CA1 = $('#CommAmt').val();
  var CP1 = $('#CommAmt').val();
  var CURRC = $('#CurrencyN').val();
  if(CURRC == "") { alert('Kindly select Currency'); return false; }

  var rwID = "MK"+rowCount; //CT1.replace(',','').replace(' ','').replace('\'','');
  if (CT1 == "" && CA1 == "") 
  {
    //if(confirm('Are you sure you want to add this Commission/Deduction without Amount or Title?'))
        //{} 
      //else{return;}
      alert('Enter complete Commission/Deduction details')
  }

  var selected = $("input[type='radio'][name='commtype']:checked");
  if (selected.length > 0) {
      selectedVal = selected.val();
  }
  if (selectedVal == "DA")
  {
    //Calculate Direct Values now
     CP1 = Number(((CA1 * 100)/realSUBAMT).toFixed(2));
   
  }
  else if (selectedVal == "PG")
  {
     //Calculate Percentage Values now
     CA1 = Number(((CP1 * realSUBAMT)/100).toFixed(2));
  }

  //////////////////////////////////////////////////
  //Comm nature 
  
  var selectedN = $("input[type='radio'][name='caltype']:checked");
  if (selectedN.length > 0) {
      selectedNVal = selectedN.val();
  }
  if (selectedNVal == "add")
  {
    var NewComm = CA1;
    var RealAmt = $('#realAmt').val();
    var AfterAmt = Number(RealAmt) + Number(NewComm);
    AfterAmt = AfterAmt.toFixed(2);
   
  }
  else if (selectedNVal == "subtract")
  {
    var NewComm = CA1;
    var RealAmt = $('#realAmt').val();
    var AfterAmt = Number(RealAmt) - Number(NewComm);
    AfterAmt = AfterAmt.toFixed(2);
  }
 // alert(AfterAmt);
 $('#postbtn').attr('disabled', true);
  ////////////////////////////////////////////////////////////////
  var NewS = rowCount+1;

  var TabRow = '<tr id="'+rwID+'">'+
                      '<td colspan="6" align="right">'+
                      '<input type="hidden" name="CMK['+NewS+'][Description]" value="'+CT1+'" />'+
                      '<input type="hidden" name="CMK['+NewS+'][DiscountPer]" value="'+CP1+'" />'+
                      '<input type="hidden" name="CMK['+NewS+'][CommID]" value="'+nCT1+'" />'+
                      '<input type="hidden" name="CMK['+NewS+'][Nature]" value="'+selectedNVal+'" />'+
                      '<b>'+CT1+' ('+CP1+'%)</b>'+
                      '</td>'+

                      '<td align="right"> <b>'+CURRC+'</b> </td>'+
                      '<td>'+CA1+'</td>'+
                      '<td class="no-print"><i class="text-red fa fa-trash"'+
                      '" Description="'+CT1+
                      '" rwID="'+rwID+
                      '" DiscountPer="'+CP1+
                      '" CMN="'+NewS+
                      '" onclick="removeCOM(this);"></i></td>'+
                      '</tr>';

  $('#SubTab').append(TabRow);
  

  
  $('#myModal').modal('hide');
  
  $('#realAmt').val(AfterAmt);
  var clenval = formatn(AfterAmt);
  
  $('#TTotalVn').html(clenval);
  var wordN = toWords(AfterAmt);
  $('#ttw').html(capitalize(wordN));
  $('#ttv').html(clenval);

  $('#CommTitle').val('');
  $('#CommAmt').val('');
  ///////////////////////////////////////////////////////////


}

function removeCOM(elem)
{
  var RowtoRemove = $(elem).attr('rwID');
  var RealSubAmt = $('#RealSubTotal').val();
  var RealAMT = $('#realAmt').val();
  var RowtoRemovePer = $(elem).attr('DiscountPer');
 
  var RowtoRemoveAmt = (Number(RowtoRemovePer) * Number(RealSubAmt))/100;
  //alert(RealSubAmt);
  //alert(RowtoRemoveAmt);
  
  var RealAmt = RealAMT - RowtoRemoveAmt; RealAmt = RealAmt.toFixed(2); $('#realAmt').val(RealAmt);
  //alert(RealAmt);
  var clenval = formatn(RealAmt);
  $('#TTotalVn').html(clenval);
  $('#ttv').html(clenval);
  var wordN = toWords(RealAmt);
  $('#ttw').html(capitalize(wordN));
  $('#'+RowtoRemove).remove();
}

  function open_container()
        {
          var CURRC = $('#CurrencyN').val();
          var PURIN = $('#PurchaseOrderV').html();
  //if(CURRC == "") { alert('Kindly select Currency'); return false; }
           if(PURIN == "") { alert('Kindly load invoice details'); return false; }
           var OptAddDed = '<?php echo $OptAddDed; ?>';
            var size='standart';
            var content = '<form>' +
              '<div class="row">'+
              '<div class="col-md-12">'+

              '<div class="form-group col-md-6"><label>Title: </label><select class="form-control" id="CommTitle" name="CommTitle" required >'+ OptAddDed +'</select></div>' +
              '<div class="form-group col-md-6"><label>Amount: </label><input type="text" class="form-control" id="CommAmt" name="CommAmt" placeholder="Amount" onKeyPress="return isNumber(event)" required /></div>' +
              '<div class="form-group col-md-4"><label> Nature </label><span class="form-control"><label>Direct Amount <input type="radio" name="commtype" value="DA"  /> </label> &nbsp;&nbsp;&nbsp; <label>Percentage <input type="radio" name="commtype" value="PG" checked /></label></span></div>' +
              //'<div class="form-group col-md-4"><label> Type </label><span class="form-control">&nbsp;&nbsp; <label>Deduct <input type="radio" name="caltype" value="subtract" checked /></label></span></div>' +
              '<div class="form-group col-md-4"><label> Type </label><span class="form-control"><label>Add <input type="radio" name="caltype" value="add" checked /> </label> &nbsp;&nbsp;&nbsp;</span></div>' +
              //'<div class="form-group col-md-4"><label> Type </label><span class="form-control"><label>Add <input type="radio" name="caltype" value="add" /> </label> &nbsp;&nbsp;&nbsp; <label>Deduct <input type="radio" name="caltype" value="subtract" checked /></label></span></div>' +
             // '<div class="form-group col-md-4"><label> Impact on Sub Total </label><span class="form-control"><label>Before <input type="radio" name="subttype" value="before" checked /> </label> &nbsp;&nbsp;&nbsp; <label>After <input type="radio" name="subttype" value="after" /></label></span></div>' +
              '</div>'+
              '</div>'+
              
              '</form>';
            var title = 'Add New Addition/Deduction';
            var footer = '<button type="button" onclick="addCommm();" class="btn btn-primary">Apply</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
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
                  <div class="modal-dialog " style="width:70%">
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
         
<div id="PrintArea" >
          <div class="row" style="margin-left:23px; margin-right:23px;">
            <div class="col-xs-12">
              <h2 class="page-header">
              <input type="hidden" name="datastate" value="<?php echo $SaveM; ?>" />
        <!--<img id="pelogo" src="../mBOOT/plant.png" width="82px" height="80px" alt="PENL logo"/>-->
        <img id="pelogo" src="../mBOOT/elshcon.png" width="82px" height="80px" alt="ENL logo"/>
                <span style="display:none;" id="companynme1">ELSHCON NIGERIA LIMITED</span>
                <small style="display:none;" class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <div class="row" style="">
            <div class="col-xs-12">
          <div class="row invoice-info" style="margin-left:23px; margin-right:23px;">
            <div class="col-sm-4 invoice-col">
              
               <address>
                <strong style="font-weight:700">From :</strong><br>
                <label id="supNme"></label><br/>
                <span id="supAdd"></span><br/>
                <span id="supPhone"></span><br/>
                <span id="supEmail"></span><br/>
                <span id="supUrl"></span>
              </address>
               
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <h2 style="color:#008080; font-size:20px; font-weight:400;">
                VENDOR'S INVOICE DETAILS <span id="inCurren"></span>
              </h2>
               
            </div><!-- /.col -->
            
          </div>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info" style="margin-left:23px; margin-right:23px;">
            <div class="col-sm-4 invoice-col">
             <address>
                <strong style="font-weight:700">To :</strong><br>
                <strong id="companynme2">ELSHCON NIGERIA LIMITED</strong><br>
              </address>
            </div><!-- /.col -->
            <div class="col-sm-2 invoice-col">
             <span>&nbsp;&nbsp;&nbsp;</span>
               <br />
              
            </div><!-- /.col -->
            

            <div class="col-sm-6 invoice-col">
              <table>
                <tr>
                  <td>  <input type="hidden" name="PONumv" id="PONumv" value="<?php echo $_GET['sPO']; ?>" />
                    <b>INVOICE NO. : </b>
                  </td> 
                  <td id="InvoiceNumV">  </td>
                </tr>
                <tr>
                  <td>   <input type="hidden" name="poDatev" id="poDatev" value="<?php echo date("d/m/Y"); ?>" />
                    <b>INVOICE DATE : </b>
                  </td> 
                  <td id="InvDateV"> </td>
                </tr>
                 <tr>
                  <td>
                    <b>DUE DATE : </b>
                  </td> 
                  <td id="DueDateV"> </td>
                </tr>
                
                <tr>
                  <td>   
                    <b>TIN NO. : </b>
                  </td> 
                  <td id="TINNOV"> </td>
                </tr>
                <tr>
                  <td>   
                    <b>VENDOR CODE : </b>
                  </td> 
                  <td id="VendorCodeV"></td>
                </tr>
                <tr style="color:green">
                  <td>   
                    <b>PURCHASE ORDER # : </b>
                  </td> 
                  <td id="PurchaseOrderV"></td>
                </tr>
                <tr style="color:green">
                  <td>   
                    <b>CUS ORDER # : </b>
                  </td> 
                  <td id="CusOrderV"></td>
                </tr>
                <tr style="color:green">
                  <td>   
                    <b>ENL SO # : </b>
                  </td> 
                  <td id="PESONumV"></td>
                </tr>
              </table>
           
   
            </div><!-- /.col -->
          </div><!-- /.row -->

         <form id="svState" name="svState">    
          <!-- Table row -->
          <input type="hidden" name="InvoiceID" id="InvoiceID" /> 
          <input type="hidden" name="PEPONUM" id="PEPONUM" />
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                 <thead>
                      <tr>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>UOM</th>
                        <th>Unit Price</th>
                        <th>Extended Price</th>
                        <th>&nbsp;</th>
                      
                        
                      </tr>
                    </thead>
                    <tbody id="MainTab"></tbody>
                    <tbody id="STotalTab">
                    <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="4" align="right"><b>Sub Total</b>&nbsp;&nbsp;<b id="currsymv"></b></td>
                    <td colspan="2"><b style="text-decoration: overline;" id="subTotalV">0.00000</b><input type="hidden" id="RealSubTotal" name="RealSubTotal" value="0.00000" /></td>
                    </tr>
                    </tbody>
                    <tbody id="SubTab"></tbody>
                    
                    <tfoot id="TotalTab">
                     <tr>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                       <td colspan="4" align="right"><b>Total</b>&nbsp;&nbsp;<b id="currsymv1"></b></td>
                       <td colspan="2"><b style="text-decoration: overline;" id="TTotalVn">0.00000</b> <input type="hidden" id="realAmt" name="realAmt" value="" /> </td>
                     </tr>
                    </tfoot>
                 
              </table>
              <input type="hidden" id="TComm" value="">
               <div style="float:right;">
               
              <table id="MoneySum" class="table table-striped">
               
                <tbody>
                
                </tbody>

              </table>
               <table>
                  <tr><td colspan="9">
                      <b> Amount in words: </b> &nbsp; <b id="ttw"> </b> &nbsp;<b id="symnme"></b>
                    </td></tr>

                </table>
            </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
      </form>

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
      
        <img src="../mBOOT/elshcon.png" width="30px" height="30px" alt="ENL logo"/>
                ELSHCON NIGERIA LIMITED
                <small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
</div>

<!-- REMARK BASE -->
<!--<div class="col-sm-4 invoice-col" >
 <b style="color:#008080"> Vendor Bank Account Details: </b> <br/>
 
<b>Account Name:</b> &nbsp;<b id="cpNmem">  </b><br />
<b>Account Number:</b> &nbsp;<b id="cpNmem">  </b><br />
<b>Bank Branch Sort Code:</b> &nbsp;<b id="cpNmem">  </b><br />
<b>Bank Name:</b> &nbsp;<b id="cpNmem">  </b><br />
<b>Address:</b> &nbsp;<b id="cpNmem">  </b><br />-->
<!--<input type="hidden" name="cpNmev" id="cpNmev" value="Godsarm Onukwufor" />
<b> <span id="companynme4">PE ENERGY LTD</span> </b> <br />
-->

</div><!-- /.col -->


<!--- Summary Amount -->
<!--
<div class="col-sm-4 invoice-col" style="padding:12px; display:block; float:right; width:400px; border-radius: 25px; border: 2px solid #73AD21;">
 <b> for <span id="companynme5">PE ENERGY LIMITED</span> </b> <br/>
 <img src="../mBOOT/FinanceAccount.png" />

<br />
<br />

<a> Finance & Accounts </a>: &nbsp;

<a> Authorised Signatory </a>
</div><!-- /.col -->

<!--<div class="col-sm-4 invoice-col" style="padding:12px; display:block; float:right; width:400px; border-radius: 25px; border: 2px solid #73AD21;">
 <b> for <span id="companynme6">PE ENERGY LIMITED</span> </b> <br/>
 <img src="../mBOOT/ExecMgt.png" />

<br />
<br />

<a> Executive Mgt. </a>: &nbsp;

<a> Authorised Signatory </a>
</div>--><!-- /.col -->
<div class="col-sm-4 invoice-col" style="float:right; width:400px;">
  <b> Grand Total :</b> &nbsp; <b id="currsym2"></b>&nbsp;<b id="ttv"></b>
  <input type="hidden" id="currsymbv" name="currsymbv" />
  <br />
 <!--<a> Amount chargeable (in words): </a> <br />
 <b id="ttw"><?php echo ucwords(convert_number_to_words($SubTotal)); ?></b> &nbsp; <b id="symnme"></b>
 <input type="hidden" id="currrealv" name="currrealv" />-->
</div> 
<br />
<br />
<br />
<br />
<br />



        
          
         
</div>
<div class="row no-print">
            <div class="col-xs-12">
            
             <!--   <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Note as Qutoted</button>
              <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Send Mail</button> -->
             
            </div>
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
    <link href="../mBOOT/select2.css" rel="stylesheet">
    <script src="../mBOOT/select2.js"></script>

  <!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        $("#userTab").dataTable();

       /* $("#invDate").datepicker({
            dateFormat: 'dd/mm/yy'
          });

        $("#dueDate").datepicker({
            dateFormat: 'dd/mm/yy'
          });
*/

       $("#invDate").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd/mm/yy",
        onSelect: function(selectedDate) {
            //$("#cal4").datepicker("setDate", selectedDate);
            var date = $(this).datepicker("getDate"); //Get the Date object with actual date
            var TermsD = $("#TermDay").val();
            if(TermsD < 1) { $("#TermDay").val(0);  date.setDate(date.getDate()); } //Set date object adding 3 days.
            else { date.setDate(date.getDate() + Number(TermsD)); } //Set date object adding 3 days.
           
            $("#dueDate").datepicker("setDate", date); //Set the date of the datepicker with our date object
            $("#dueDate").datepicker( "option", "minDate", date );
            $("#dueDate").datepicker( "option", "maxDate", date );
        }
    });
        $("#dueDate").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: "dd/mm/yy",
            onSelect: function(selectedDate) {
               // $("#cal3").datepicker( "option", "maxDate", selectedDate );
            }
        });

        
      });
    </script>
    <!-- DATA TABES SCRIPT -->
    <script src="../mBOOT/jquery-ui.js"></script>
    
  </body>
</html>