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

//////////// FRESH INVOICE WORKS NOW ///////////////
//Here we have to get all the Customers
$resultCustomers = mysql_query("SELECT * FROM customers ORDER BY CustormerNme");
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



?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> Invoice | Accounts</title>
  <link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
   <!-- daterange picker -->
    <link href="../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
   <link href="../mBOOT/jquery-ui.css" rel="stylesheet">

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
        <?php include('../header2.php') ?>
        <?php include('../topmenu2.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
       <?php include('leftmenu.php'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Bank Receipt
            <small id="SONUM"><?php echo $_GET['sPO']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../internalsales"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Bank Receipt</li>
          </ol>
        </section>
    
<div class="pad margin no-print">
          <div class="callout callout-info" style="margin-bottom: 0!important;">                        
            <h4><i class="fa fa-info"></i> Note:</h4>
            This page has been enhanced for printing. Click the print button at the bottom of the Invoice to print.
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
  $('#companynme1').html("KARI CARE LIMITED");
  $('#companynme2').html("KARI CARE LIMITED");
  $('#companynme3').html("KARI CARE LIMITED");
  $('#companynme5').html("KARI CARE LIMITED");
  $('#companynme6').html("KARI CARE LIMITED");
  $('#companynme4').html("KARI CARE LTD");
  $('#companyemail').html("");
  $('#cpEmail').html("");
  $('#companyurl').html(""); 
  $('#pelogo').hide();
   $('#companynme1').show();
  
  }
  
  if(document.getElementById('POComp').value == 1) {
  $('#companynme1').html("PE ENERGY LIMITED");
  $('#companynme1').hide();
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
  var Curr = document.getElementById('Currn').value;
  $('#inCurren').html(Curr);
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
    $Description = $row['Description'];
    $MartServNo = $row['MartServNo'];
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
    
    /*
 <th>Item</th>
                        <th>Material/Service</th>
                       <th>Description</th>
                        <th>Qty</th>
                        <th>UOM</th>
                        <th>Disc %</th>
                        <th>Unit Price</th>
                        <th>Amount</th>


    */
      
             // ((float)$SubTotal, 2, '.', '')

     }

   if ($Currency == "NGN")
   {$SCur = "NGN";}
}
else
{
$Record .= '<tr><td colspan="9">No Item</td> </tr>';
}
?>      
        <section class="invoice">
    <div class="row">
            <div class="col-md-12">
              <div class="box">
  
     
      <div class="form-group has-feedback col-md-8">
        <label>Select Customer</label>
          <select class="tokenize-demo form-control" id="InvoiceCusN" name="InvoiceCusN" required >
          <?php echo $OptCustomer; ?>
          </select>
      </div>
      <div class="form-group has-feedback col-md-1" title="Load All Invoice and Order No of the Customer">
       <label> &nbsp;</label>
       <button onClick="LoadCusOrderN();" class="form-control btn btn-success" type="button"><i class="fa fa-search"></i></button>
      </div>

      <div class="form-group has-feedback col-md-12">
       <table class="table table-striped" >
        <thead style="background:#009900; color:#FFF">
          <tr><th>Invoice Number </th><th>Invoice Number </th><th>Invoice Number </th><th>Invoice Number </th></tr>
        </thead>
        <tbody id="CusInvss">
        </tbody>
       </table>
      </div>
      
      
      <script type="text/javascript">

      function LoadCusOrderN()
      {
        var CusID = $('#InvoiceCusN').val();
        var formData = { CusID:CusID };
        $.ajax({
            type: "POST",
            url: "../utility/getCUSINVs",
            data: formData,
            cache: false,
            success: function(html)
            {
                  var obj = JSON.parse(html);
                  
                  $('#CusOrderNo').html(obj['OptOrdNo']);
                  //$('#InvoiceNum').html(obj['OptInvNo']);
                  $('#CusInvss').html(obj['InvTab']);
                  alert(obj['InvTab']);
                  $('#cusAdd').html(obj['CusAddress']); 
                  $('#cusEmail').html(obj['CusEmail']); 
                  $('#cusUrl').html(obj['CusURL']); 
            }
            
        });
      }

      

      function LoadFrmPEEELInvoice()
      {
        var IvnID = $('#InvoiceNum').val();
        //alert(IvnID);
        var formData = { IvnID:IvnID };
        $.ajax({
            type: "POST",
            url: "../utility/getPEELINV",
            data: formData,
            cache: false,
            success: function(html)
            {
                  var obj = JSON.parse(html);
                 $('#MainTab').html(obj['InvoiceItemTable']); 
                 $('#SubTab').html(obj['InvoiceCommissionTable']);
                 $('#CurrencyN').val(obj['Curr']); 
                 $('#NGNCRate').val(obj['NGNCRate']); 
                 
                 $('#currsymv').html(obj['Curr']);
                 $('#currsymv1').html(obj['Curr']);
                 $('#subTotalV').html(obj['SubTotal']);
                 $('#RealSubTotal').val((obj['SubTotal']).replace(',', ''));
                 $('#TTotalV').html(obj['TTotal']);
                 $('#realAmt').val((obj['TTotal']).replace(',', ''));
                 $('#ttw').html(capitalize(toWords(obj['TTotal'])));
                 $('#symnme').html($('#CurrencyN').find('option:selected').text()); //$('#yourdropdownid').find('option:selected').text();



                 $('#nVendorCode').val(obj['VendorCode']);
                 $('#VendorCodeV').html(obj['VendorCode']);

                 $('#PurchaseOrderV').html(obj['PurOrder']);
                 $('#InvoiceNumV').html(obj['InvNum']);


            }
            
        });
      }

      function LoadFrmCusOrderNum()
      {
        var CusOrdNum = $('#CusOrderNo').val();
        var formData = { CusOrdNum:CusOrdNum };
        $.ajax({
            type: "POST",
            url: "../utility/getINVCUSNUM",
            data: formData,
            cache: false,
            success: function(html)
            {
                 //alert(html)
                 //return false;
                  var obj = JSON.parse(html);
                 //alert(obj['CurOdrdItemNum']);
                
                 
                 $('#MainTab').html(obj['InvoiceItemTable']);
                 //if(obj['NewInvoice'] == "YES") { $('#MAKEINVOICE').show(); }
                 //else { $('#MAKEINVOICE').hide(); }
                 $('#PurchaseOrderV').html(obj['PurOrder']); //PurchaseOrderV
                 //$('#PurchaseOrderV').html(obj['InvNum']); //PurchaseOrderV
                $('#InvoiceNumV').html('');
                $('#nVendorCode').val('');
                $('#VendorCodeV').html('');
                 //$('#CurrencyN selected:option').val(obj['Curr']);
                 $('#CurrencyN').val(obj['Curr']);

                  $('#currsymv').html(obj['Curr']);
                  $('#currsymv1').html(obj['Curr']);
                  $('#NGNCRate').html(obj['NGNCRate']);
                 $('#symnme').html($('#CurrencyN').find('option:selected').text()); //$('#yourdropdownid').find('option:selected').text();
                 $('#subTotalV').html(obj['SubTotal']);
                 $('#RealSubTotal').val((obj['SubTotal']).replace(',', ''));
                 $('#TTotalV').html(obj['SubTotal']);
                 $('#realAmt').val((obj['SubTotal']).replace(',', ''));
                 $('#ttw').html(capitalize(toWords(obj['SubTotal'])));


                 //$('#MAKEINVOICE').show();
                 
            }
            
        });
      }
      </script>
    
      <div class="form-group has-feedback col-md-3">
        <label>Select Cus.Order.No.</label>
          <select class="tokenize-demo form-control" id="CusOrderNo" name="CusOrderNo" required >
          <!-- <?php echo $OptCusOrderNum; ?>  -->      
          </select>
      </div> 
      <div class="form-group has-feedback col-md-1"  title="Load Details of Order No">
       <label> &nbsp;</label>
       <button onClick="LoadFrmCusOrderNum();" class="form-control btn btn-success" type="button"><i class="fa fa-shopping-cart"></i> <i class="fa fa-download"></i></button>
      </div>
      
    <div id="GETINVOICE">
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
    </div>

     <div class="form-group has-feedback col-md-2">
      <label> Vendor Code </label>
       <input class="form-control" placeholder="Vendor Code" id="nVendorCode" name="nVendorCode" onInput="document.getElementById('VendorCodeV').innerHTML = this.value; document.getElementById('suprefnov').value = this.value;" value="<?php echo $SupplierRefNum; ?>"> </input>
     </div>
     <div class="form-group has-feedback col-md-2">
       <label>Select Currency</label>
        <select class="form-control" id="CurrencyN" name="CurrencyN" required >
         <option value=""> Choose Currency</option>
         <?php echo $RecordCurr; ?>
        </select>
     </div>
     <div class="form-group has-feedback col-md-2">
      <label> NGN C Rate</label>
      <input type="text" id="NGNCRate" name="NGNCRate" class="form-control" placeholder="0.00" onKeyPress="return isNumber(event)" />
     </div>
     <!--<div class="form-group has-feedback col-md-1">
      <label> &nbsp;</label>
      <button onClick="addLIT();" class="form-control btn btn-warning" type="button"><i class="fa fa-plus"></i> <i class="fa fa-shopping-cart"></i></button>
     </div>-->
    <div class="form-group has-feedback col-md-1">
      <label> &nbsp;</label>
      <button onClick="open_container();" class="form-control btn btn-warning" type="button"><i class="fa fa-plus"></i> <i class="fa fa-file"></i></button>
    </div>

     <div class="form-group has-feedback col-md-2">
      <label> &nbsp;</label>
      <button onClick="SaveInvoice();" class="form-control btn btn-info" type="button"><i class="fa fa-save"></i> Save </button>
    </div>
     <script type="text/javascript">
     function SaveInvoice()
     {

      var CusNAMEID = $('#InvoiceCusN').val();
      var CusOrderNo = $('#CusOrderNo').val();
      var InvoiceNum = $('#InvoiceNum').val();
      $('#InvoiceID').val(InvoiceNum);
      var nVendorCode = $('#nVendorCode').val();
      var CurrencyN = $('#CurrencyN').val();
      var NGNCRate = $('#NGNCRate').val();

      if(CusNAMEID == "") { alert('Kindly select Customer'); return false; }
      if(CusOrderNo == "") { alert('Kindly select Customer Order No'); return false; }
      if(InvoiceNum == "") { alert('Kindly select Invoice No'); return false; }
      if(nVendorCode == "") { alert('Kindly Type Vendor Code'); return false; }
      if(CurrencyN == "") { alert('Kindly select Currency'); return false; }

      //var InvoiceNumText = $('#InvoiceNum selected:option').text();
      

      //Now we have to assign CusONo to the InvoiceNo
      var formData = { CusNAMEID:CusNAMEID, CusOrderNo:CusOrderNo, 
                       InvoiceNum:InvoiceNum, nVendorCode:nVendorCode, 
                       CurrencyN:CurrencyN, NGNCRate:NGNCRate};

        $.ajax({ type: "POST", url: "../utility/assignInvoice", data: formData, cache: false,
            success: function(html) { 
              alert(html); 
              if(html == "Invoice Number Assigned Successfully!")
              {
                //MainTab
                $.ajax({
                    url: "../utility/assignInvoiceLI",
                    type: "POST",
                    data: $("#svState").serialize(),
                    cache: false,
                    processData:false,
                    success: function(html)
                    {
                       //alert(html);
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
        /**/

     }
     </script>
     <script>      
        $('.tokenize-demo').select2();
         //$('#CurrencyN').select2();
      </script>

    <script type="text/javascript">
      function CreateNewInv()
      {
        //var CusNAME = $('#InvoiceCusN').val();
        var CusNAME = $('#InvoiceCusN option:selected').text();
        var CusNAMEID = $('#InvoiceCusN').val();
          var size='standart';
            var content = '<form role="form">' +
   
      '<div class="form-group" style="width:100%; display: inline-block;"><label>Customer: </label> <span>'+CusNAME+'</span></div>' +
      '<input type="hidden" name="CusNAMEID" id="CusNAMEID" value="'+CusNAMEID+'" />'+
      '<div class="form-group" style="width:100%; display: inline-block;"><label>Invoice Number: </label>  <input type="text" class="form-control" id="invn" name="invn" placeholder="" required ></div>' +
      
      
      
      '<button type="button" onclick="addInvoice();" class="btn btn-primary">Create Invoice</button></form>';
            var title = 'New Invoice';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
      }

      function addInvoice()
      {
        var CusNAMEID = $('#CusNAMEID').val();
        var invnNUM = $('#invn').val();
        if(CusNAMEID < 1) {alert('Kindly select customer'); return false;}
        var formData = { invnNUM:invnNUM, CusNAMEID:CusNAMEID };
        $.ajax({
            type: "POST",
            url: "../utility/newInvoice",
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
  var LitID = $(elem).attr("LitID");
  var SNUM = $(elem).attr("SNUM");
  var MatSer = $(elem).attr("MatSer");
  var Description = $(elem).attr("Description");
  var Qty = $(elem).attr("Qty");
  var UOM = $(elem).attr("UOM");
  var DiscountAmt = $(elem).attr("DiscountAmt");
  var UnitCost = $(elem).attr("UnitCost");
  var ExtendedCost = $(elem).attr("ExtendedCost"); 

            var size='standart';
            var content = '<form><div class="form-group">' +
              '<input type="hidden" value="'+ LitID +'" id="LitIDmx" name="LitIDmx" />'+
              '<input type="hidden" value="'+ SNUM +'" id="SNUMm" name="SNUMm" />'+
              '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label><textarea class="form-control" id="EditDes" name="EditDes" placeholder="Description">'+Description+'</textarea></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Material/Service. No.: </label><input type="text" class="form-control" id="EditMatSer" name="EditMatSer" placeholder="Material/Service No." onInput="compute()" value="'+MatSer+'"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Quantity: </label><input type="text" class="form-control" id="EditQty" name="EditQty" placeholder="Quantity" onInput="compute()" value="'+Qty+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Unit Rate: </label><input type="text" class="form-control" id="EditUnitRate" name="EditUnitRate" placeholder="Unit Rate" onInput="compute()" value="'+UnitCost+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Discount %: </label><input type="text" class="form-control" id="EditDisc" name="EditDisc" placeholder="Discount" onInput="compute()" value="'+DiscountAmt+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Amount: </label><input type="text" class="form-control" id="EditAmt" name="EditAmt" placeholder="Amount" onInput="compute()" value="'+ExtendedCost+'" onKeyPress="return isNumber(event)" readonly ></div>' +
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

  var genTableRow = '<td><input type="hidden" name="POLineItem['+SN+'][LitID]" value="'+LitIDm+'" />'+LitIDm+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][MatSer]" value="'+EditMatSer+'" />'+EditMatSer+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][Description]" value="'+EditDes+'" />'+EditDes+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][Qty]" value="'+EditQty+'" />'+EditQty+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][UOM]" value="'+EditPer+'" />'+EditPer+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][DiscountAmt]" value="'+EditDisc+'" />'+EditDisc+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][UnitCost]" value="'+EditUnitRate+'" />'+EditUnitRate+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][ExtendedCost]" value="'+EditAmt+'" />'+EditAmt+'</td>'+
                      '<td class="no-print"><i class="fa fa-edit" LitID="'+LitIDm+'" MatSer="'+EditMatSer+
                      '" Description="'+EditDes+'" Qty="'+EditQty+
                      '" UOM="'+EditPer+'" DiscountAmt="'+EditDisc+
                      '" UnitCost="'+EditUnitRate+'" ExtendedCost="'+EditAmt+
                      '" SNUM="'+SN+
                      '" onclick="editLIT(this);"></i></td>';
                      
 //We have to replace now 
 $('#li'+LitIDm).html(genTableRow);


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
  var CT1 = $('#CommTitle').val();
  var CA1 = $('#CommAmt').val();
  var CP1 = $('#CommAmt').val();
  var CURRC = 'USD';
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

  
  var NewS = rowCount+1;

  var TabRow = '<tr id="'+rwID+'">'+
                      '<td colspan="6" align="right">'+
                      '<input type="hidden" name="CMK['+NewS+'][Description]" value="'+CT1+'" />'+
                      '<input type="hidden" name="CMK['+NewS+'][DiscountPer]" value="'+CP1+'" />'+
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
  

  //////////////////////////////////////////////////
  $('#myModal').modal('hide');
  var NewComm = CA1.toFixed(2);
  var RealAmt = $('#realAmt').val();
  var AfterAmt = Number(RealAmt) + Number(NewComm);
  AfterAmt = AfterAmt.toFixed(2);
  $('#realAmt').val(AfterAmt);
  //alert(AfterAmt);
  var clenval = formatn(AfterAmt);


  $('#TTotalV').html(clenval);
  var wordN = toWords(AfterAmt);
  $('#ttw').html(capitalize(wordN));

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
  $('#TTotalV').html(clenval);
  //$('#ttv1').html(clenval);
  var wordN = toWords(RealAmt);
  $('#ttw').html(capitalize(wordN));
  $('#'+RowtoRemove).remove();
}

  function open_container()
        {
            var size='standart';
            var content = '<form role="form"><div class="form-group">' +
   
     '<div class="form-group" style="width:100%; display: inline-block;"><label>Title: </label><input type="text" class="form-control" id="CommTitle" name="CommTitle" placeholder="Enter Title" required ></div>' +
      '<div class="form-group" style="width:100%; display: inline-block;"><center><label>Direct Amount <input type="radio" name="commtype" value="DA" checked /> </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label>Percentage <input type="radio" name="commtype" value="PG" /></label></center></div>' +
      '<div class="form-group" style="width:100%; display: inline-block;"><label>Amount: </label><input type="text" class="form-control" id="CommAmt" name="CommAmt" placeholder="Amount" onKeyPress="return isNumber(event)" required ></div>' +
      
      
      
      '<button type="button" onclick="addCommm();" class="btn btn-primary">Add</button></form>';
            var title = 'Add New Deduction/Commission';
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
         
<div id="PrintArea" >
          <div class="row" style="margin-left:23px; margin-right:23px;">
            <div class="col-xs-12">
              <h2 class="page-header">
              <input type="hidden" name="datastate" value="<?php echo $SaveM; ?>" />
        <!--<img id="pelogo" src="../mBOOT/plant.png" width="82px" height="80px" alt="PENL logo"/>-->
        <img id="pelogo" src="logo1.png" width="252px" height="80px" alt="PEEL logo"/>
                <span style="display:none;" id="companynme1">PE ENERGY LIMITED</span>
                <small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <div class="row" style="">
            <div class="col-xs-12">
          <div class="row invoice-info" style="margin-left:23px; margin-right:23px;">
            <div class="col-sm-4 invoice-col">
              <address>
                <strong id="companynme2">PE ENERGY LIMITED</strong><br>
                54 Emekuku Street, D-Line<br>
                Port Harcourt Rivers State, Nigeria<br>
                Phone: +234(84)360759 Ext. 105<br/>
                <span id="companyemail">Email: accounts@pengrg.com</span><br/>
                <span id="companyurl">URL: www.pengrg.com</span>
              </address>
               
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <h2 style="color:#008080; font-weight:800;">
                INVOICE <span id="inCurren"></span>
              </h2>
               
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <address>
                 Tel: +234(84)360759<br/>
                 Fax: (713) 640-7478
               <br />
              </address>
               
            </div><!-- /.col -->
          </div>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info" style="margin-left:23px; margin-right:23px;">
            <div class="col-sm-4 invoice-col">
              <address>
                <strong style="font-weight:700">To :</strong><br>
                <span id="cusAdd"></span><br/>
                <span id="cusEmail"></span><br/>
                <span id="cusUrl">URL: www.pengrg.com</span>
              </address>
            </div><!-- /.col -->
            <div class="col-sm-3 invoice-col">
             <span>&nbsp;&nbsp;&nbsp;</span>
               <br />
              
            </div><!-- /.col -->
            

            <div class="col-sm-4 invoice-col">
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
                  <td> <?php echo date("d/m/Y"); ?></td>
                </tr>
                <tr>
                  <td>   
                    <b>TIN NO. : </b>
                  </td> 
                  <td> 02859836-0001</td>
                </tr>
                <tr>
                  <td>   
                    <b>VENDOR CODE : </b>
                  </td> 
                  <td id="VendorCodeV"></td>
                </tr>
                <tr>
                  <td>   
                    <b>PURCHASE ORDER # : </b>
                  </td> 
                  <td id="PurchaseOrderV"></td>
                </tr>
              </table>
           
   
            </div><!-- /.col -->
          </div><!-- /.row -->

         <form id="svState" name="svState">    
          <!-- Table row -->
          <input type="hidden" name="InvoiceID" id="InvoiceID" />
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                 <thead>
                      <tr>
                        <th>Item</th>
                        <th>Material/Service</th>
                       <th>Description</th>
                        <th>Qty</th>
                        <th>UOM</th>
                        <th>Disc %</th>
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
                       <td>&nbsp;</td>
                       <td colspan="4" align="right"><b>Total</b>&nbsp;&nbsp;<b id="currsymv1"></b></td>
                       <td colspan="2"><b style="text-decoration: overline;" id="TTotalV">0.00000</b> <input type="hidden" id="realAmt" name="realAmt" value="" /> </td>
                     </tr>
                    </tfoot>
                 
              </table>
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
      
        <img src="../mBOOT/plant.png" width="30px" height="30px" alt="PENL logo"/>
                PE ENERGY LIMITED
                <small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
</div>

<!-- REMARK BASE -->
<div class="col-sm-4 invoice-col" >
 <b style="color:#008080"> Pay in favour of: </b> <br/>
 
<b>Account Name:</b> &nbsp;<b id="cpNmem"> PE Energy Limited </b><br />
<b>Account Number:</b> &nbsp;<b id="cpNmem"> 1771141988 </b><br />
<b>Bank Branch Sort Code:</b> &nbsp;<b id="cpNmem"> 076211357 </b><br />
<b>Bank Name:</b> &nbsp;<b id="cpNmem"> Skye Bank PLC </b><br />
<b>Address:</b> &nbsp;<b id="cpNmem"> No. 89 Garrison Branch,Aba Road, Port Harcourt. </b><br />
<!--<input type="hidden" name="cpNmev" id="cpNmev" value="Godsarm Onukwufor" />
<b> <span id="companynme4">PE ENERGY LTD</span> </b> <br />
-->

</div><!-- /.col -->


<!--- Summary Amount -->

<div class="col-sm-4 invoice-col" style="padding:12px; display:block; float:right; width:400px; border-radius: 25px; border: 2px solid #73AD21;">
 <b> for <span id="companynme5">PE ENERGY LIMITED</span> </b> <br/>
 <img src="../mBOOT/FinanceAccount.png" />

<br />
<br />

<a> Finance & Accounts </a>: &nbsp;

<a> Authorised Signatory </a>
</div><!-- /.col -->
<br />
<!--<div class="col-sm-4 invoice-col" style="padding:12px; display:block; float:right; width:400px; border-radius: 25px; border: 2px solid #73AD21;">
 <b> for <span id="companynme6">PE ENERGY LIMITED</span> </b> <br/>
 <img src="../mBOOT/ExecMgt.png" />

<br />
<br />

<a> Executive Mgt. </a>: &nbsp;

<a> Authorised Signatory </a>
</div>--><!-- /.col -->
<div class="col-sm-4 invoice-col" style="float:right; width:400px;">
  <b> Grand Total :</b> &nbsp; <b id="currsym2"></b>&nbsp;<b id="ttv"><?php echo number_format($SubTotal, 2); ?></b>
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