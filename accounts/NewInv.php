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

$OptAddDed = "";
$resultSet = mysql_query("SELECT * FROM acc_settings Where variable='Receivables'");
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
        <?php include('../header2.php') ?>

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
            Raise Invoice
            <small id="SONUM"><?php echo $_GET['sPO']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../accounts"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Raise Invoice</li>
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

</script>    
        <!-- Main content -->
<section class="invoice">
 
    <div class="row">
      <div class="col-md-12">
               <div class="box">
  
     
      <div class="form-group has-feedback col-md-6">
        <label>Select Customer</label>
          <select class="tokenize-demo form-control" id="InvoiceCusN" name="InvoiceCusN" required >
          <?php echo $OptCustomer; ?>
          </select>
      </div>
      <div class="form-group has-feedback col-md-1" title="Load All Invoice and Order No of the Customer">
       <label> &nbsp;</label>
       <button onClick="LoadCusOrderN();" class="form-control btn btn-success" type="button"><i class="fa fa-search"></i></button>
      </div>
      
      
    
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

     
     <div class="form-group has-feedback col-md-1" title="Load Invoice Details">
       <label> &nbsp;</label>
       <button onClick="LoadFrmPEEELInvoice();" class="form-control btn btn-success" type="button"><i class="fa fa-file"></i> <i class="fa fa-download"></i></button>
      </div>
    </div>
    <div class="form-group has-feedback col-md-1" title="New Invoice">
       <label> &nbsp;</label>
       <button onClick="CreateNewInv();" class="form-control btn btn-success" type="button"><i class="fa fa-file"></i> <i class="fa fa-plus"></i></button>
     </div>

  
     
    
     <div class="form-group has-feedback col-md-1">
      <label> &nbsp;</label>
      <button onClick="addLIT();" id="newLIbtn" title="New Line Item" class="form-control btn btn-warning" type="button" disabled ><i class="fa fa-plus"></i> <i class="fa fa-shopping-cart"></i></button>
     </div>

    <div class="form-group has-feedback col-md-1">
      <label> &nbsp;</label>
      <button onClick="open_container();" id="newADbtn" title="New Addition/Deduction" class="form-control btn btn-warning" type="button" disabled ><i class="fa fa-plus"></i> <i class="fa fa-file"></i></button>
    </div>


     <div class="form-group has-feedback col-md-2">
       <label> &nbsp;</label>
       <button id="postbtn" onClick="POSTNewInv();" title="Post Transaction" class="form-control btn btn-warning" type="button" disabled ><i class="fa fa-send"></i> Post </button>
     </div>

     
   
      <div class="form-group has-feedback col-md-6">
       <label> Customer's Invoice Address </label>
       <textarea id="cusaddt" title="You can edit" class="form-control" onInput="document.getElementById('cusAdd').innerHTML = this.value;"></textarea>
     </div>
      <div class="form-group has-feedback col-md-2">
      <label> Vendor Code </label>
       <input class="form-control" placeholder="Vendor Code" id="nVendorCode" name="nVendorCode" onInput="document.getElementById('VendorCodeV').innerHTML = this.value; document.getElementById('suprefnov').value = this.value;" value="<?php echo $SupplierRefNum; ?>"> </input>
     </div>

   
     
    <div class="col-md-12">
      <div class="form-group has-feedback col-md-3">
      <label> Bank Name </label>
       <input class="form-control" placeholder="Bank Name" id="BankName" name="BankName" onInput="document.getElementById('BankNameV').innerHTML = this.value; document.getElementById('BankNamen').value = this.value;" value="STANBIC IBTC BANK PLC"> </input>
     </div>
      <div class="form-group has-feedback col-md-3">
      <label> Account Name </label>
       <input class="form-control" placeholder="Account Name" id="AccountName" name="AccountName" onInput="document.getElementById('AccountNameV').innerHTML = this.value; document.getElementById('AccountNamen').value = this.value;" value="Elshcon Nigeria Limited"> </input>
     </div>
     <div class="form-group has-feedback col-md-3">
      <label> Account Number </label>
       <input class="form-control" placeholder="Account Number" id="AccountNumber" name="Account Number" onInput="document.getElementById('AccountNumberV').innerHTML = this.value; document.getElementById('AccountNumbern').value = this.value;" value="0020289484"> </input>
     </div>
     <div class="form-group has-feedback col-md-3">
      <label> Bank Sort Code </label>
       <input class="form-control" placeholder="Bank Sort Code" id="BankSortCode" name="BankSortCode" onInput="document.getElementById('BankSortCodeV').innerHTML = this.value; document.getElementById('BankSortCoden').value = this.value;" value="221218080"> </input>
     </div>
     <div class="form-group has-feedback col-md-3">
      <label> Bank Address </label>
       <input class="form-control" placeholder="Bank Address" id="BankAddress" name="BankAddress" onInput="document.getElementById('BankAddressV').innerHTML = this.value; document.getElementById('BankAddressn').value = this.value;" value="No. 7 Trans Amadi Industrial Layout, Port Harcourt."> </input>
     </div>
    
     <div class="form-group has-feedback col-md-2">
      <label> Invoice Date</label>
      <input type="text" class="form-control" id="invDate" readonly onChange="$('#InvDateV').html($(this).val()); compDueDate(); " />
    </div>
     <div class="form-group has-feedback col-md-3">
       <label> Terms (Days) </label>
       <input class="form-control" id="TermDay" name="TermDay" onChange="compDueDate();" onInput="compDueDate();" required >
     </div>
     <div class="form-group has-feedback col-md-2">
      <label> Due Date</label>
      <input type="text" class="form-control" id="dueDate" readonly />
    </div>
     <div class="form-group has-feedback col-md-2">
      <label> &nbsp;</label>
      <button onClick="SaveInvoice();" class="form-control btn btn-info" type="button"><i class="fa fa-save"></i> Save </button>
    </div>
    </div>
     
         
       <script>      
        $('.tokenize-demo').select2();
         //$('#CurrencyN').select2();

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
      

   
    
        </div>
      </div>
    </div>

    <div class="row">

              <div class="box box-primary">
                
                
                <!-- Modal form-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog" style="width:70%">
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
        <img id="pelogo" src="../mBOOT/elshcon.png" width="122px" height="80px" alt="ENL logo"/>
                <span style="display:none;" id="companynme1">Elshcon Nigeria LIMITED</span>
                <small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
          <div class="row" style="">
            <div class="col-xs-12">
          <div class="row invoice-info" style="margin-left:23px; margin-right:23px;">
            <div class="col-sm-4 invoice-col">
              <address>
                <strong id="companynme2">ELSHCON NIGERIA LIMITED</strong><br>
                <!--54 Emekuku Street, D-Line<br>
                Port Harcourt Rivers State, Nigeria<br>
                Phone: +234(84)360759 Ext. 105<br/>
                Fax: (713) 640-7478<br/>
                <span id="companyemail">Email: accounts@pengrg.com</span><br/>
                <span id="companyurl">URL: www.pengrg.com</span>-->
              </address>
               
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <h2 style="color:#008080; font-weight:800;">
                INVOICE <span id="inCurren"></span>
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
                <span id="cusAdd"></span><br/>
                <span id="cusEmail"></span><br/>
                <span id="cusUrl"></span>
              </address>
            </div><!-- /.col -->
            <div class="col-sm-3 invoice-col">
             <span>&nbsp;&nbsp;</span>
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
                  <td id="InvDateV"> <?php echo date("d/m/Y"); ?></td>
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
           <br/>
   
            </div><!-- /.col -->
          </div><!-- /.row -->

         <form id="svState" name="svState">    
          <!-- Table row -->
          <input type="hidden" name="InvoiceID" id="InvoiceID" />
          <input type="hidden" name="BankNamen" id="BankNamen" />
          <input type="hidden" name="AccountNamen" id="AccountNamen" />
          <input type="hidden" name="AccountNumbern" id="AccountNumbern" />
          <input type="hidden" name="BankSortCoden" id="BankSortCoden" />
          <input type="hidden" name="BankAddressn" id="BankAddressn" />
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


<div id="pbholder" style="display: none; page-break-before: always;">
 <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
      
        <img src="../mBOOT/elshcon.png" width="30px" height="30px" alt="PENL logo"/>
                ELSHCON NIGERIA LIMITED
                <small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>
</div>

<!-- REMARK BASE -->
<div class="col-sm-4 invoice-col" >
 <b style="color:#008080"> Pay in favour of: </b> <br/>
 
<b>Account Name:</b> &nbsp;<b id="AccountNameV"> ELSHCON NIGERIA LIMITED </b><br />
<b>Account Number:</b> &nbsp;<b id="AccountNumberV"> 0020289484 </b><br />
<b>Bank Branch Sort Code:</b> &nbsp;<b id="BankSortCodeV"> 221218080 </b><br />
<b>Bank Name:</b> &nbsp;<b id="BankNameV"> STANBIC IBTC BANK PLC </b><br />
<b>Address:</b> &nbsp;<b id="BankAddressV"> No. 7 Trans Amadi Industrial Layout, Port Harcourt. </b><br />
<!--<input type="hidden" name="cpNmev" id="cpNmev" value="Godsarm Onukwufor" />
<b> <span id="companynme4">PE ENERGY LTD</span> </b> <br />
-->

</div><!-- /.col -->


<!--- Summary Amount -->

<div class="col-sm-4 invoice-col" style="padding:12px; display:block; float:right; width:400px; border-radius: 25px; border: 2px solid #73AD21;">
 <b> for <span id="companynme5">ELSHCON NIGERIA LIMITED</span> </b> <br/>
 <!--<img src="../mBOOT/FinanceAccount.png" />-->
 <br/>
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
  <!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        $("#userTab").dataTable();

        $("#invDate").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd/mm/y",
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
            dateFormat: "dd/mm/y",
            onSelect: function(selectedDate) {
               // $("#cal3").datepicker( "option", "maxDate", selectedDate );
            }
        });

      });
    </script>
    <!-- DATA TABES SCRIPT -->
    <script src="../mBOOT/jquery-ui.js"></script>


      <script type="text/javascript">

      function LoadCusOrderN()
      {
        var CusID = $('#InvoiceCusN').val();
        var formData = { CusID:CusID };
        $.ajax({
            type: "POST",
            url: "../utility/getCUSINV",
            data: formData,
            cache: false,
            success: function(html)
            {
                  var obj = JSON.parse(html);
                  
                  $('#CusOrderNo').html(obj['OptOrdNo']);
                  $('#InvoiceNum').html(obj['OptInvNo']);
                  $('#cusAdd').html(obj['CusAddress']); 
                  $('#cusEmail').html(obj['CusEmail']); 
                  $('#cusUrl').html(obj['CusURL']);  
                  //$('#cusaddt').html(obj['cusAdd']);  
                  $('#cusaddt').val(obj['CusAddress']);  
                  $('#nVendorCode').val(obj['VendorCode']); 
                  $('#VendorCodeV').html(obj['VendorCode']);
            }
            
        });
      }

      

      function LoadFrmPEEELInvoice()
      {
        var IvnID = $('#InvoiceNum').val();
        //alert(IvnID);
        $('#postbtn').attr('disabled', true);
        $('#newADbtn').attr('disabled', true);
        $('#newLIbtn').attr('disabled', true);

        var formData = { IvnID:IvnID };
        $.ajax({
            type: "POST",
            url: "../utility/getPEELINV",
            data: formData,
            cache: false,
            success: function(html)
            {
                  var obj = JSON.parse(html);
                 // alert(html);
                 $('#MainTab').html(obj['InvoiceItemTable']); 
                 $('#SubTab').html(obj['InvoiceCommissionTable']);
                 $('#CurrencyN').val(obj['Curr']); 
                 $('#NGNCRate').val(obj['NGNCRate']); 
                 
                 $('#currsymv').html(obj['Curr']);
                 $('#currsymv1').html(obj['Curr']);
                 $('#subTotalV').html(obj['SubTotal']);
                 $('#RealSubTotal').val(obj['SubTotal']);
                 $('#TTotalV').html(obj['TTotal']);
                 $('#realAmt').val(obj['TTotal']);
                 $('#ttw').html(capitalize(toWords(obj['TTotal'])));
                 $('#symnme').html($('#CurrencyN').find('option:selected').text()); //$('#yourdropdownid').find('option:selected').text();
                 //if(obj['Curr'] != "" && obj['Curr'] != null)
                 /*if(obj['PurOrder'] != "" && obj['PurOrder'] != null)
                 {
                  
                 }*/
                 
                  $('#newADbtn').attr('disabled', false);
                  $('#newLIbtn').attr('disabled', false);
                  $('#postbtn').attr('disabled', false);

                 $('#nVendorCode').val(obj['VendorCode']);
                 $('#VendorCodeV').html(obj['VendorCode']);

                 $('#PurchaseOrderV').html(obj['PurOrder']);
                 $('#InvoiceNumV').html(obj['InvNum']);
                 $('#invDate').val(obj['InvoDate']);
                 $('#TermDay').val(obj['TermDay']);

                  $("#PrintArea").css("background-color", "#ECFFF1");

                 compDueDate();


            }
            
        });
      }

      function LoadFrmCusOrderNum()
      {
         $('#postbtn').attr('disabled', true);
         $('#postbtn').attr('disabled', true);
         $('#newADbtn').attr('disabled', true);
         $('#newLIbtn').attr('disabled', true);

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
                 $('#SubTab').html('');
                 $('#PurchaseOrderV').html(obj['PurOrder']); //PurchaseOrderV
                 //$('#PurchaseOrderV').html(obj['InvNum']); //PurchaseOrderV
                $('#InvoiceNumV').html('');
               // $('#nVendorCode').val('');
                
                 //$('#CurrencyN selected:option').val(obj['Curr']);
                 $('#CurrencyN').val(obj['Curr']);
                

                  $('#currsymv').html(obj['Curr']);
                  $('#currsymv1').html(obj['Curr']);
                  $('#NGNCRate').html(obj['NGNCRate']);
                 $('#symnme').html($('#CurrencyN').find('option:selected').text()); //$('#yourdropdownid').find('option:selected').text();
                 $('#subTotalV').html(obj['SubTotal']);
                 $('#RealSubTotal').val(obj['SubTotal']);
                 $('#TTotalV').html(obj['SubTotal']);
                 $('#realAmt').val(obj['SubTotal']);
                 $('#ttw').html(capitalize(toWords(obj['SubTotal'])));
                 $('#ttv').html(obj['SubTotal']);

                  //Set Source Indicator
                  $("#PrintArea").css("background-color", "#FFFFCC");
                 //$('#MAKEINVOICE').show();
                 
            }
            
        });
      }
      </script>
       <script type="text/javascript">
     
     function POSTNewInv()
     {
        var CusNAMEID = $('#InvoiceCusN').val();
        var CusOrderNo = $('#CusOrderNo').val();
        var InvoiceNum = $('#InvoiceNum').val();
        var CusNAME = $('#InvoiceCusN option:selected').text();
        var CurrencyN = $('#CurrencyN').val();

        var RevenueAccts = ''; var TradRvcAccts = ''; var ValueAdded = '';

        //Load RevenueAccts

        $.ajax({ type: "POST", url: "../utility/getGLacct", cache: false,
            success: function(html) {

              var obj = JSON.parse(html);

              var size='standart';
              var content = '<form role="form" method="post" id="postfrm">' +
            '<h4>SALES VALUE </h4>'+
            '<div class="form-group col-md-6"><label>Customer (Debit): </label> <span class="form-control">'+CusNAME+'</span></div>' +
            '<input type="hidden" name="CusNAMEID" id="CusNAMEID" value="'+CusNAMEID+'" />'+
            '<div class="form-group col-md-6"><label>Invoice Number: </label>  <input type="text" class="form-control" id="invn" name="invn" placeholder="" value="'+InvoiceNum+'" required readonly ></div>' +
            '<div class="form-group col-md-6"><label>Revenue Account (Credit): </label>  <select class="form-control" id="OptGLRevenue" name="OptGLRevenue" required >'+obj['OptGLRevenue']+'</select></div>' +
            '<div class="form-group col-md-6" style="display:none"><label>Trade Receivable (Debit): </label>  <select class="form-control" id="OptGLTradeRev" name="OptGLTradeRev" required readonly >'+obj['OptGLTradeRev']+'</select></div>' +
            '<div class="form-group col-md-6"><label>Value Added (Credit): </label>  <select class="form-control" id="OptGLValueAdd" name="OptGLValueAdd" required >'+obj['OptGLValueAdd']+'</select></div><br/><br/><br/><br/><br/><br/><br/><br/>' +
            
            '<div class="row col-md-12" style="display:none">'+
            '<h4>COST OF SALES </h4>'+
            '<div class="form-group col-md-6"><label>Debit Account: </label>  <select class="form-control" id="invn" name="invn" required >'+obj['OptGLExpense']+'</select></div>' +
            '<div class="form-group col-md-6"><label>Credit Account: </label>  <select class="form-control" id="invn" name="invn" required >'+obj['OptGLInventory']+'</select></div>' +
            '</div>'+
                '<div class="col-md-12"><br/><br/>'+
          '<table class="table table-striped" style="border: 2px;">'+
          '<tr>'+
          '<td> <label>Transaction Currency:</label> </td> <td> '+ CurrencyN +' </td> <td> NGN Exchange Rate :  </td> <td> <input type="text" id="ExchangeRate" name="ExchangeRate" class="form-control" value="1" onInput="ExchangeAmt()" onKeyPress="return isNumber(event)" /> </td>'+
          '</tr>'+
          '</table>'+
          '</div>'+  
          '<div class="col-md-12">'+
          '<table class="table table-striped">'+
          '<tr>'+
          '<td id="trAcc"> '+CusNAME+' </td>  <td> '+ CurrencyN +' <span id="trAccAmt"></span>  <td> <input type="text" id="trAcctVal" readonly class="form-control" /> </td>'+
          '</tr>'+
          '<tr>'+
          '<td id="drAcc">  </td> <td> '+ CurrencyN +' <span id="drAccAmt"></span> </td> <td> <input type="text" id="drAccVal" readonly class="form-control" /> </td>'+
          '</tr>'+
          '<tr>'+
          '<td id="vadddrAcc"> </td> <td> '+ CurrencyN +' <span id="vadddrAccAmt"></span> </td> <td> <input type="text" id="vadddrAccval" readonly class="form-control" /> </td>'+
          '</tr>'+
          '</table>'+
          '</div><br/>'+
          '<div class="row col-md-12">'+
            '<div class="form-group col-md-12"><label>Description: </label>  <textarea class="form-control" id="Descrp" name="Descrp" placeholder="Enter Summary or Remark here..."></textarea></div>' +
          '</div>'+ 
            '</form>';

            var title = 'POST RECEIVABLE TRANSACTION';
            var footer = '<button type="button" class="btn btn-warning" onclick="postnow();" ><i class="fa fa-send"></i></button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

            setPAY();
            ExchangeAmt();
            if(CurrencyN == "NGN") { $('#ExchangeRate').val(1);  ExchangeAmt(); }

              

          }
        });
        

        
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

       function setPAY()
           {
            //$("#trAcc").html($('#GLPayable option:selected').text());
            $("#drAcc").html($('#OptGLRevenue option:selected').text());
            $("#vadddrAcc").html($('#OptGLValueAdd option:selected').text());
            $("#trAccAmt").html($("#TTotalV").html());
            $("#drAccAmt").html($("#subTotalV").html());
            var ToVal = $("#TTotalV").html();
            var ToVal = ToVal.replace(",", "");
            var ToVal = ToVal.replace(",", "");
            var ToVal = ToVal.replace(",", "");

            var SubVal = $("#subTotalV").html();
            var SubVal = SubVal.replace(",", "");
            var SubVal = SubVal.replace(",", "");
            var SubVal = SubVal.replace(",", "");

            var VatFig = Number(ToVal) - Number(SubVal);

            $("#vadddrAccAmt").html(formatn(VatFig.toFixed(2)));
           }


           function postnow()
           {
              //postfrm

      var InvoiceNum = $('#invn').val(); 
      var OptGLRevenue = $('#OptGLRevenue').val();
      var OptGLValueAdd = $('#OptGLValueAdd').val(); 
      var OptGLTradeRev = $('#OptGLTradeRev').val(); 
      var ExchangeRate = $('#ExchangeRate').val();
      var trAcctVal = $('#trAcctVal').val();
      var drAccVal = $('#drAccVal').val(); 
      var vadddrAccval = $('#vadddrAccval').val(); 
      var Descrp = $('#Descrp').val();
      var CurrencyN = $('#CurrencyN').val();
      var InvDate = $('#invDate').val();
      $('#InvDateV').html(InvDate);
      var TermDay = $('#TermDay').val();
      //var NGNCRate = $('#NGNCRate').val();
      if(ExchangeRate == 0 ) { $('#ExchangeRate').val(1); ExchangeAmt(); }
      if(ExchangeRate < 1) { alert('Kindly set Exchange Rate'); return false; }
      if(InvDate == "") { alert('Kindly select Invoice Date'); return false; }
      if(TermDay == "") { alert('Kindly select Days for Payment Terms'); return false; }
       if(CurrencyN == "") { alert('Kindly select Currency'); return false; }
      
      //Now we have to assign CusONo to the InvoiceNo
      var formData = { InvoiceNum:InvoiceNum, OptGLRevenue:OptGLRevenue, 
                       OptGLValueAdd:OptGLValueAdd, ExchangeRate:ExchangeRate, 
                       trAcctVal:trAcctVal, drAccVal:drAccVal, Descrp:Descrp, 
                       CurrencyN:CurrencyN, InvDate:InvDate, TermDay:TermDay, vadddrAccval:vadddrAccval };

        $.ajax({ type: "POST", url: "../utility/postRECEIVABLE", data: formData, cache: false,
            success: function(html) { 
              alert(html); 
            }
           // error: function(html) { alert(html); }
        });
        /**/
           }

     function SaveInvoice()
     {

      var CusNAMEID = $('#InvoiceCusN').val();
      var CusOrderNo = $('#CusOrderNo').val();
      var CusAddress = $('#cusaddt').val(); //
      var InvoiceNum = $('#InvoiceNum').val(); 
      $('#InvoiceID').val(InvoiceNum);
      var nVendorCode = $('#nVendorCode').val();
      var CurrencyN = $('#CurrencyN').val();
      var CurrencyN = $('#CurrencyN').val();
      var InvDate = $('#invDate').val();
      $('#InvDateV').html(InvDate);
      var TermDay = $('#TermDay').val();
      //var NGNCRate = $('#NGNCRate').val();

      if(InvDate == "") { alert('Kindly select Invoice Date'); return false; }
      if(TermDay == "") { alert('Kindly select Days for Payment Terms'); return false; }
      if(CusNAMEID == "") { alert('Kindly select Customer'); return false; }
      if(CusOrderNo == "") { alert('Kindly select Customer Order No'); return false; }
      if(InvoiceNum == "") { alert('Kindly select Invoice No'); return false; }
      if(nVendorCode == "") { alert('Kindly Type Vendor Code'); return false; }
      if(CurrencyN == "") { alert('Kindly select Currency'); return false; }
      if(CusAddress == "") { alert('Kindly Set Customer\'s Invoice address'); return false; }

      //var InvoiceNumText = $('#InvoiceNum selected:option').text();
      

      //Now we have to assign CusONo to the InvoiceNo
      var formData = { CusNAMEID:CusNAMEID, CusOrderNo:CusOrderNo, 
                       InvoiceNum:InvoiceNum, nVendorCode:nVendorCode, 
                       CurrencyN:CurrencyN, CusAddress:CusAddress, InvDate:InvDate, TermDay:TermDay };

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
   
  var CURRC = $('#CurrencyN').val();
          var PURIN = $('#PurchaseOrderV').html();
  //if(CURRC == "") { alert('Kindly select Currency'); return false; }
           if(PURIN == "") { alert('Kindly load invoice details'); return false; }
            //////////////////////////////////////////////
            var size='standart';
            var content = '<form role="form"><div class="form-group">' +
             '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label><textarea class="form-control" id="iEditDes" name="EditDes" placeholder="Description"></textarea></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Material/Service. No.: </label><input type="text" class="form-control" id="iEditMatSer" name="EditMatSer" placeholder="Material/Service No." value=""  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Quantity: </label><input type="text" class="form-control" id="iEditQty" name="EditQty" placeholder="Quantity" onInput="computeALIT()" value="" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Unit Rate: </label><input type="text" class="form-control" id="iEditUnitRate" name="EditUnitRate" placeholder="Unit Rate" onInput="computeALIT()" value="" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Discount %: </label><input type="text" class="form-control" id="iEditDisc" name="EditDisc" placeholder="Discount" onInput="computeALIT()" value="" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Amount: </label><input type="text" class="form-control" id="iEditAmt" name="EditAmt" placeholder="Amount" onInput="computeALIT()" value="" onKeyPress="return isNumber(event)" readonly ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Per (UOM): </label><input type="text" class="form-control" id="iEditPer" name="EditPer" placeholder="Per" onInput="computeALIT()" value=""  ></div>' +
              '<button type="button" class="btn btn-primary" onclick="addNewLineItem();">Add Line Item</button></form>';
            var title = 'Add Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
            //$('#AddDueDate').datepicker();
    //return false;
  //alert(LinIT);
        
}

function addNewLineItem()
{
  var rowCount = $('#MainTab tr').length;
  //
  var SN = (rowCount+1);//$('#SNUMm').val(); //DEX
  //alert(SN); return false;
  var LitIDm = SN; //$('#LitIDmx').val();
  var EditMatSer = $('#iEditMatSer').val();
  var EditDes = $('#iEditDes').val();
  var EditQty = $('#iEditQty').val();
  var EditUnitRate = $('#iEditUnitRate').val();
  var EditDisc = $('#iEditDisc').val();
  var EditPer = $('#iEditPer').val(); 
  var EditAmt = $('#iEditAmt').val();
  var rowid="li"+LitIDm;
  var genTableRow = '<tr id="'+rowid+'"><td><input type="hidden" name="POLineItem['+SN+'][LitID]" value="0" />-</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][MatSer]" value="'+EditMatSer+'" />'+EditMatSer+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][Description]" value="'+EditDes+'" />'+EditDes+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][Qty]" value="'+EditQty+'" />'+EditQty+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][UOM]" value="'+EditPer+'" />'+EditPer+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][DiscountAmt]" value="'+EditDisc+'" />'+EditDisc+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][UnitCost]" value="'+EditUnitRate+'" />'+EditUnitRate+'</td>'+
                      '<td><input type="hidden" name="POLineItem['+SN+'][ExtendedCost]" value="'+EditAmt+'" />'+EditAmt+'</td>'+
                      '<td class="no-print"><i class="fa fa-edit" LitID="" MatSer="'+EditMatSer+
                      '" Description="'+EditDes+'" Qty="'+EditQty+
                      '" UOM="'+EditPer+'" DiscountAmt="'+EditDisc+
                      '" UnitCost="'+EditUnitRate+'" ExtendedCost="'+EditAmt+
                      '" SNUM="'+SN+
                      '" onclick="editLIT(this);"></i></td></tr>';
               
   //We have to replace now 
   //alert(genTableRow);
   $('#MainTab').append(genTableRow);
   $('#myModal').modal('hide');

}

function computeALIT()
{
  //alert('fdgfgdkj');
  var TotalAmt = parseFloat($('#iEditQty').val()) * parseFloat($('#iEditUnitRate').val());
                //$('EditAmt').val() 
                var ED = parseFloat($('#iEditDisc').val());
                if(ED > 0)
{
  $('#iEditAmt').val(TotalAmt - ((ED * TotalAmt)/100) );
}
else
{
  $('#iEditAmt').val(TotalAmt);
}
                
                
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
  $('#ttv').html(RealAmt);

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
              '<div class="form-group col-md-4"><label> Nature </label><span class="form-control"><label>Direct Amount <input type="radio" name="commtype" value="DA" /> </label> &nbsp;&nbsp;&nbsp; <label>Percentage <input type="radio" name="commtype" value="PG" checked /></label></span></div>' +
              '<div class="form-group col-md-4"><label> Type </label><span class="form-control"><label>Add <input type="radio" name="caltype" value="add" checked /> </label> &nbsp;&nbsp;&nbsp; <label>Deduct <input type="radio" name="caltype" value="subtract" /></label></span></div>' +
             // '<div class="form-group col-md-4"><label> Impact on Sub Total </label><span class="form-control"><label>Before <input type="radio" name="subttype" value="before" checked /> </label> &nbsp;&nbsp;&nbsp; <label>After <input type="radio" name="subttype" value="after" /></label></span></div>' +
              '</div>'+
              '</div>'+
              
              '</form>';
            var title = 'Add New Item';
            var footer = '<button type="button" onclick="addCommm();" class="btn btn-primary">Apply</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
        }

        function addCommm()
{

  var rowCount = $('#SubTab tr').length;
  var SN = (rowCount+1);
  var realSUBAMT = $('#RealSubTotal').val();
  realSUBAMT = realSUBAMT.replace(",", ""); 
  realSUBAMT = realSUBAMT.replace(",", "");
  realSUBAMT = realSUBAMT.replace(",", "");
  realSUBAMT = realSUBAMT.replace(",", "");
                 //$('#CurrencyN selected:option').val(obj['Curr']);
  var CT1 = $('#CommTitle option:selected').text(); 
  var CT1n = $('#CommTitle').val();

  var CA1 = $('#CommAmt').val();
  var CP1 = $('#CommAmt').val();
  var CURRC = $('#CurrencyN').val();
  if(CURRC == "") { alert('Kindly select Currency'); return false; }
  var rwID = "MK"+SN; //CT1.replace(',','').replace(' ','').replace('\'','');
  if (CT1 == "" && CA1 == "") 
  {
      alert('Enter complete Added Value Details details');  return false;
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

  //CalType
  var CalTypeSele = $("input[type='radio'][name='caltype']:checked");
  if (CalTypeSele.length > 0) { CalTypeSeleVal = CalTypeSele.val(); }
  if (CalTypeSeleVal == "add") { realSUBAMT = Number(realSUBAMT) +  CP1; }
  else if (CalTypeSeleVal == "subtract") { realSUBAMT = Number(realSUBAMT) -  CP1; }
  
  var NewS = (rowCount+1);

  var TabRow = '<tr id="'+rwID+'">'+
                      '<td colspan="6" align="right">'+
                      '<input type="hidden" name="CMK['+NewS+'][Description]" value="'+CT1+'" />'+
                      '<input type="hidden" name="CMK['+NewS+'][DiscountPer]" value="'+CP1+'" />'+
                      '<input type="hidden" name="CMK['+NewS+'][AddDedu]" value="'+CalTypeSeleVal+'" />'+
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

  //
  var NewComm = CA1;
    

  //var RealAmt = $('#realAmt').val();
  //var AfterAmt = Number(RealAmt) + Number(NewComm);
  AfterAmt = realSUBAMT.toFixed(2);
  $('#realAmt').val(AfterAmt);
  //alert(AfterAmt);
  var clenval = formatn(AfterAmt);


  $('#TTotalV').html(clenval);
  var wordN = toWords(AfterAmt);
  $('#ttw').html(capitalize(wordN));
  $('#ttv').html(AfterAmt);


  //$('#CommTitle').val('');
  $('#CommAmt').val('');
  ///////////////////////////////////////////////////////////


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


    
  </body>
</html>