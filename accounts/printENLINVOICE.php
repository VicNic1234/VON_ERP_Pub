<?php
session_start();
error_reporting(0);
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

include('route.php');
include('N2WFallBack.php');
//include('NumberToWords.php');

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';

$CONID = $_POST['poid'];
 $resultLI = mysql_query("SELECT * FROM enlinvoices 
 LEFT JOIN customers ON enlinvoices.CusSource = customers.cusid
 LEFT JOIN users ON enlinvoices.ENLATTN = users.uid
 WHERE cid='".$CONID."'
 "); //WHERE isActive=1 ORDER BY cid

$NoRowLI = mysql_num_rows($resultLI); 
//fetch tha data from the database
   if ($NoRowLI > 0) 
   {
   $SN = 1;
  while ($row = mysql_fetch_array($resultLI)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     
    $cid = $row['cid'];
    $PONUM = $row['PONUM'];
    $IVNo = $row['IVNo'];
    $Comment = $row['Comment'];
    $PostID = $row['PostID'];
    $PaidAmt = chkPaid($cid);
    $TotalMain = getTotalSum($cid);
    $BAL = $TotalMain - $PaidAmt;
    $conDiv = $row['conDiv'];
    $IVDate = $row['IVDate'];
    $ENLATTN = $row['ENLATTN'];
    $VENATTN = $row['CUSATTN'];
    $Currency = $row['Currency'];
    $PDFNUM = $row['PDFNUM'];
    $ATTNME = $row['Firstname'] . " " . $row['Surname'];
    $ATTPHONE = $row['Phone'];
    $ATTEMAIL = $row['Email'];
    $Currency = $row['Currency'];
    $PDFNUM = $row['PDFNUM'];
    $SupNme = $row['CustormerNme'];
    $SupAddress = $row['CusAddress'];
    $SupCountry = $row['SupCountry'];
    $SupPhone1 = $row['CusPhone'];
    $VendSource = $row['CusSource'];
    $ContNum = $row['ContNum'];
    $ServicENum = $row['ServicENum'];
    $VenCode = $row['VenCode'];
    $BnkID = $row['BnkID'];
    $DDOfficerComment = $row['DDOfficerComment'];
    $DDOfficerOn = $row['DDOfficerOn'];
    $DDOfficer = getUserInfo($row['DDOfficer']);
    //$RaisedBy = //$row['RaisedBy'];

    }
  }
  else
  {
    $_SESSION['ErrMsg'] = "Oops! an error occured, try again";
    header('Location: enlinvoices');
    exit;
  }
  
  
  if($PostID == 0) { $RStatus = '<span class="stamp is-nope">Not Acknowledged</span>'; }
    else{ 
        if($BAL == 0)
        {
            $RStatus = '<span class="stamp is-approved">FULL PAYMENT</span>';
        }
        elseif ($BAL == $TotalMain)
        {
            $RStatus = '<span class="stamp is-approved">Acknowledged</span>';
        }
        else{
            $RStatus = '<span class="stamp is-nope">PART PAYMENT</span>';
        }
        
    }
    
    
    function chkPaid($invoiceCode)
{
     ////////////////////////PAID ////////////////////////////////
 $PaidAmt = 0.0;
   $resultPAID = mysql_query("SELECT * FROM postings Where VINVOICE='$invoiceCode' AND TransacType='DEBIT' AND GLImpacted='602'");
 
        $NoRowPAID = mysql_num_rows($resultPAID);
        if ($NoRowPAID > 0) {
          while ($row = mysql_fetch_array($resultPAID)) 
          {
            $pamtd = $row['TransactionAmount'];
            //ENLINVOICE
            $PaidAmt = $PaidAmt + floatval($pamtd);
           }
        }
        
        return $PaidAmt;
}


function getTotalSum($CONID)
{
        /*Get Line Item */
$resultPOIt = mysql_query("SELECT * FROM acct_ivitems Where PONo='".$CONID."' AND isActive=1");
$NoRowPOIt = mysql_num_rows($resultPOIt);
 $SN = 0; $SubTotal = 0; $MainTotal = 0;
if ($NoRowPOIt > 0) {
  while ($row = mysql_fetch_array($resultPOIt)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $PDFNUM = $row['PDFNUM'];
    $PDFItemID = $row['PDFItemID'];
    $description = $row['description'];
    $units = $row['units'];
    $qty = $row['qty'];
    $unitprice = $row['unitprice'];
    $totalprice = floatval($unitprice) * floatval($qty);
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $delDoc = "";
    $SubTotal = $SubTotal + $totalprice;
    
    
   
  }
 } 





$MainTotal =  $SubTotal;
//PO Miscellaneous
           /*Get M Item */
$resultPOM = mysql_query("SELECT * FROM acct_ivmiscellaneous Where PONo='".$CONID."' AND isActive=1");
$NoRowPOM = mysql_num_rows($resultPOM);
 $SN = 0;
if ($NoRowPOM > 0) {
  while ($row = mysql_fetch_array($resultPOM)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $description = $row['description'];
    $mprice = $row['price'];
    $Impact = $row['Impact'];
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $AmtType = $row['AmtType'];
    $delDoc = "";
   

    if($Impact == "ADD") { 
      $Impact = "+"; 
      if($AmtType == "DIRECT")
      {
       $MainTotal = $MainTotal + $mprice;
      }
      else{ $MainTotal = $MainTotal + ($SubTotal * $mprice)/100; $PERT = "%"; }
    }
    else { 
      $Impact = "-"; 
      
      if($AmtType == "DIRECT")
      {
       $MainTotal = $MainTotal - $mprice;
      }
      else{ $MainTotal = $MainTotal - ($SubTotal * $mprice)/100; $PERT = "% of Sub Total"; }

    }
}
}

return ($MainTotal);

}


    /*Get BANK*/
$resultBNK = mysql_query("SELECT * FROM bankaccount Where baccid='$BnkID'");
$NoRowBNK = mysql_num_rows($resultBNK);
if ($NoRowBNK > 0) {
  while ($row = mysql_fetch_array($resultBNK)) 
  {
    $bnkdesp = $row['description'];
    $bnkid = $row['baccid'];
    $accnum = $row['acctnum'];
    $accnme = $row['acctnme'];
    
     $sortcode = $row['sortcode'];
      $bnkaddress = $row['bnkaddress'];
       //$accnme = $row['accnme'];
    
  
   
  }
}
$resultCurr = mysql_query("SELECT * FROM currencies WHERE Abbreviation='$Currency'");

         while ($row = mysql_fetch_array($resultCurr)) {
         $CurrNme =  $row['CurrencyName'];
    }

$PageTitle = "ENL Invoice : ".$IVNo;
	//Let's Get HOD CnP Signature
	 $resultUINFO= mysql_query("SELECT * FROM department LEFT JOIN users ON department.hod = users.uid WHERE department.id='2'");

         while ($row = mysql_fetch_array($resultUINFO)) {
         //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
         $ACCTHODNme =  $row['Firstname'] . " " . $row['Surname'];
          $ACCTHODSign =  $row['Signature'];
    }

    $resultUGM= mysql_query("SELECT * FROM divisions LEFT JOIN users ON divisions.GM = users.uid WHERE divisions.divid='2'");

         while ($row = mysql_fetch_array($resultUGM)) {
         //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
         $ACCTGMNme =  $row['Firstname'] . " " . $row['Surname'];
          $ACCTGMSign =  $row['Signature'];
    }
    
    function getUserInfo($uid)
    {
        //$dbhandle = $GLOBALS['dbhandle'];
        $resultUINFO= mysql_query("SELECT * FROM users WHERE uid='".$uid."'");

         while ($row = mysql_fetch_array($resultUINFO)) {
         //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
         return $row['Firstname'] . " " . $row['Surname'];
    }
      return "-";
    }


    /*Get Line Item */
$resultPOIt = mysql_query("SELECT * FROM enlivitems Where PONo='".$CONID."' AND isActive=1");
$NoRowPOIt = mysql_num_rows($resultPOIt);
 $SN = 0; $SubTotal = 0; $MainTotal = 0;
if ($NoRowPOIt > 0) {
  while ($row = mysql_fetch_array($resultPOIt)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $PDFNUM = $row['PDFNUM'];
    $PDFItemID = $row['PDFItemID'];
    $description = $row['description'];
    $units = $row['units'];
    $qty = $row['qty'];
    $unitprice = $row['unitprice'];
    $totalprice = floatval($unitprice) * floatval($qty);
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $delDoc = "";
    $SubTotal = $SubTotal + $totalprice;
      $delDoc = '<a href="deldoc?id='.$sdid.'"><i class="fa fa-trash"></i></a>';
    
    $LineItems .= '<tr style="border: 2px solid black;">
                      <td style="border: 1px solid black;">'.$SN.'</td>
                    <td style="border: 1px solid black;">'.$description.'</td>

                      <td style="border: 1px solid black;">'.$units.'</td>
                    <td style="border: 1px solid black;">'.$qty.'</td>
                    <td style="border: 1px solid black;">'.$Currency . " ".number_format($unitprice).'</td>
                    <td style="border: 1px solid black;">'.$Currency . " ".number_format($totalprice).'</td>
                    </tr>';
  }
 }  

$MainTotal =  $SubTotal;
//PO Miscellaneous
           /*Get M Item */
$resultPOM = mysql_query("SELECT * FROM enlivmiscellaneous Where PONo='".$CONID."' AND isActive=1");
$NoRowPOM = mysql_num_rows($resultPOM);
 $SN = 0;
if ($NoRowPOM > 0) {
  while ($row = mysql_fetch_array($resultPOM)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $description = $row['description'];
    $mprice = floatval($row['price']);
    $Impact = $row['Impact'];
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $AmtType = $row['AmtType'];
    $delDoc = "";
   

    if($Impact == "ADD") { 
      $Impact = "+"; 
      if($AmtType == "DIRECT")
      {
       $MainTotal = floatval($MainTotal) + $mprice; $BAM = number_format($mprice, 2);
      }
      else{ $MainTotal = floatval($MainTotal) + (floatval($SubTotal) * $mprice)/100; $BAM = number_format(($SubTotal * $mprice)/100, 2); $PERT = "% of Sub Total"; }
      //else{ $MainTotal = floatval($MainTotal) + ((floatval($SubTotal) * $mprice)/100); $PERT = "% of Sub Total"; }
      //else{ $MainTotal = ($SubTotal * $mprice)/100; $PERT = "% of Sub Total"; }
    }
    else { 
      $Impact = "-"; 
      
      if($AmtType == "DIRECT")
      {
       $MainTotal = $MainTotal - $mprice; $BAM = "(".number_format($mprice, 2).")";
      }
      else{ $MainTotal = $MainTotal - ($SubTotal * $mprice)/100; $BAM = "(".number_format(($SubTotal * $mprice)/100, 2 ).")"; $PERT = "% of Sub Total"; }

    }
      $delDoc = '<a href="delItem?id='.$sdid.'"><i class="fa fa-trash"></i></a>';
    
    
    
    
    $MItems .= '<tr>
                     
                    <td colspan="3"> &nbsp; </td>
                    <td colspan="2">'.$description.'</td>
                    <td>'. $Currency . ' ' . $BAM . ' </td>
                    </tr>';
  }
 }  

   /*Get Supporting Docs*/
$resultSDoc = mysql_query("SELECT * FROM supportingdoc Where docid='".$CONID."' AND module='ENLINV' AND isActive=1 Order By sdid");
$NoRowSDoc = mysql_num_rows($resultSDoc);
 $SN = 0;
if ($NoRowSDoc > 0) {
  while ($row = mysql_fetch_array($resultSDoc)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['sdid'];
    $link = $row['link'];
    $addedby = $row['addedby'];
    $linkn = '<a target="_blank" href="'.$link.'"><i class="fa fa-link"></i></a>';
    $description = $row['description'];
    $title = $row['title'];
    $delDoc = "";
    if($addedby == $MYID)
    {
      $delDoc = '<a href="deldoc?id='.$sdid.'"><i class="fa fa-trash"></i></a>';
    }
    $SupDocs .= '<tr>
                    <td>'.$SN.'</td>
                    <td>'.$title.'</td>
                    <td>'.$description.'</td>
                    <td>'.$linkn.'</td>
                </tr>';
  }
 }  


 ////////////////////////////////////////////////////////////////
 function number_to_word( $num = '' )
{
    $num    = ( string ) ( ( int ) $num );
   
    if( ( int ) ( $num ) && ctype_digit( $num ) )
    {
        $words  = array( );
       
        $num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );
       
        $list1  = array('','one','two','three','four','five','six','seven',
            'eight','nine','ten','eleven','twelve','thirteen','fourteen',
            'fifteen','sixteen','seventeen','eighteen','nineteen');
       
        $list2  = array('','ten','twenty','thirty','forty','fifty','sixty',
            'seventy','eighty','ninety','hundred');
       
        $list3  = array('','thousand','million','billion','trillion',
            'quadrillion','quintillion','sextillion','septillion',
            'octillion','nonillion','decillion','undecillion',
            'duodecillion','tredecillion','quattuordecillion',
            'quindecillion','sexdecillion','septendecillion',
            'octodecillion','novemdecillion','vigintillion');
       
        $num_length = strlen( $num );
        $levels = ( int ) ( ( $num_length + 2 ) / 3 );
        $max_length = $levels * 3;
        $num    = substr( '00'.$num , -$max_length );
        $num_levels = str_split( $num , 3 );
       
        foreach( $num_levels as $num_part )
        {
            $levels--;
            $hundreds   = ( int ) ( $num_part / 100 );
            $hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );
            $tens       = ( int ) ( $num_part % 100 );
            $singles    = '';
           
            if( $tens < 20 )
            {
                $tens   = ( $tens ? ' ' . $list1[$tens] . ' ' : '' );
            }
            else
            {
                $tens   = ( int ) ( $tens / 10 );
                $tens   = ' ' . $list2[$tens] . ' ';
                $singles    = ( int ) ( $num_part % 10 );
                $singles    = ' ' . $list1[$singles] . ' ';
            }
            $words[]    = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        }
       
        $commas = count( $words );
       
        if( $commas > 1 )
        {
            $commas = $commas - 1;
        }
       
        $words  = implode( ', ' , $words );
       
        //Some Finishing Touch
        //Replacing multiples of spaces with one space
        $words  = trim( str_replace( ' ,' , ',' , trim_all( ucwords( $words ) ) ) , ', ' );
        if( $commas )
        {
            $words  = str_replace_last( ',' , ' and' , $words );
        }
       
        return $words;
    }
    else if( ! ( ( int ) $num ) )
    {
        return 'Zero';
    }
    return '';
}


function trim_all( $str , $what = NULL , $with = ' ' )
{
    if( $what === NULL )
    {
        //  Character      Decimal      Use
        //  "\0"            0           Null Character
        //  "\t"            9           Tab
        //  "\n"           10           New line
        //  "\x0B"         11           Vertical Tab
        //  "\r"           13           New Line in Mac
        //  " "            32           Space
       
        $what   = "\\x00-\\x20";    //all white-spaces and control chars
    }
   
    return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
}

function str_replace_last( $search , $replace , $str ) {
    if( ( $pos = strrpos( $str , $search ) ) !== false ) {
        $search_length  = strlen( $search );
        $str    = substr_replace( $str , $replace , $pos , $search_length );
    }
    return $str;
}
 ///////////////////////////////////////////////////////////////////

?>
<!DOCTYPE html>
<html>
<?php include('../header2.php') ?>
<style>
  @media print{
    @page {size: portrait }
   .no-print{
       display:none;
   }
   
   div {
    break-inside: avoid;
  }

   body {
  -webkit-print-color-adjust: exact !important;
  }

   
}
</style>
  <body class="skin-blue sidebar-mini">
  
    <div class="wrapper">

       <?php include('../topmenu2.php') ?>
      <!-- Left side column. contains the logo and sidebar -->
    <?php include('leftmenu.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo "ENL's Invoice : "; ?>
            <small><?php echo $IVNo; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Invoice</li>
          </ol>
        </section>
		
<div class="pad margin no-print">
          <div class="callout callout-info" style="margin-bottom: 0!important;">												
            <h4><i class="fa fa-info"></i> Note:</h4>
            This page has been enhanced for printing. Click the print button at the bottom of the ENL's invoice to print.
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
     /*var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;*/

     window.print();

    //document.body.innerHTML = originalContents;
} 
</script>    
        <!-- Main content -->
			
        <section class="invoice">
		      <!-- title row -->
<div id="PrintArea">
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
			
			  <img src="../mBOOT/plant.png" width="50px" height="50px" alt="ENL logo"/>
                <?php echo $_SESSION['CompanyName']; ?>
                <small class="pull-right">Date: <?php echo date("d/m/Y"); ?></small>
              </h2>
            </div>
          </div>
          <!-- info row -->
                
          <!--<center><b><h2><?php echo "ENL's Invoice : ". $IVNo; ?></h2></b></center>-->
         <!-- <small class="pull-right"><?php echo $IVNo; ?></small>-->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              <strong>CLIENT</strong>
              <address>
                <b style="color:#888888"><?php echo $SupNme; ?></b><br>
                <?php echo $SupAddress; ?><br>
                <?php echo $SupCountry; ?><br>
                <?php echo $SupPhone1; ?><br>
               
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col" style="font-size:0.8em">
             <strong> BUYER</strong>
             <address>
                <b style="color:#888888"><?php echo $_SESSION['CompanyName']; ?></b><br>
                Port Harcourt, Rivers State, Nigeria<br>
                Contact: <?php echo $ATTNME; ?><br/>
                Phone: <?php echo $ATTPHONE; ?><br/>
                Email: <?php echo $ATTEMAIL; ?><br/>
                URL: www.elshcon.com
              </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col" style="font-size:0.8em">
              <b>Invoice Date:</b> <?php echo $IVDate;?><br/>
              <b>Vendor Code: </b> <?php echo $VenCode; ?><br/>
              <b>Service Entry No.:</b> <?php echo $ServicENum;?><br/>
              <b>Invoice No.:</b> <?php echo $IVNo;?><br/>
              <b>VAT No.:</b> PHV. 05002158837<br/>
              <b>TIN:</b> 00482825-0001<br/>
              <br/>
             
            </div><!-- /.col -->
          </div><!-- /.row -->

         <!-- <div class="row">
         <center>
           <div style="width:56%">
            <table class="table table-striped" style="border: 2px solid black; text-align: center;">
                 <tbody>
                  <tr style="border: 2px solid black; text-align: center;">
                        <td>&nbsp;</td>
                  </tr>
                  <tr style="border: 2px solid black; text-align: center; font-size:12px">
                        <td><?php echo strtoupper($ScopeOfSW); ?></td>
                  </tr>
                 </tbody>
            </table>
           </div>
         </center>
          </div>-->
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped" style="border: 2px solid black; font-size:0.8em">
                 <tbody>
                      <tr>
                        <th style="border: 1px solid black;">S/No</th>
                        <th style="border: 1px solid black;">DESCRIPTION</th>
                        <th style="border: 1px solid black;">UNIT</th>
                        <th style="border: 1px solid black;">QTY</th>
                        <th style="border: 1px solid black;">UNIT PRICE</th>
                        <th style="border: 1px solid black;">TOTAL PRICE</th>
                      </tr>
                    </tbody>
                    <tbody>
                    <?php echo $LineItems; ?>
                    <tr style="border: 2px solid black;">
                      <td colspan="4"> &nbsp; </td>
                      <td><b>SUB TOTAL</b></td>
                      <td><b><?php echo $Currency . " " . number_format($SubTotal); ?></b></td>
                    </tr>
                    <?php echo $MItems; ?>
                    <tr style="border: 2px solid black;">
                      <td colspan="4"> &nbsp; </td>
                      <td><b>TOTAL</b></td>
                      <td><b><?php echo $Currency . " " . number_format($MainTotal); ?></b></td>
                    </tr>
                   
                    </tbody>
              </table>

            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
              <?php
              $TotalAmtObj    = new toWords($MainTotal, $CurrNme, "");
              //echo $obj->words;
              ?>
            <!--<div class="col-md-12"><b>AMOUNT IN WORDS : </b> <em><?php echo strtoupper(number_to_word($MainTotal)). " ".strtoupper($CurrNme); ?></em></div> -->
            <div class="col-md-12"><b>AMOUNT IN WORDS : </b> <em><?php echo strtoupper($TotalAmtObj->words); ?></em></div> 
            
          </div>
        
          <table style="width:100%; margin-top:5px">
             
              <tr>
                  <td>
                      <address style="font-size:0.9em;">
                         <b>Please make payment in favour of: </b> <br/>
                          <b>BENEFICIARY CUSTOMER DETAILS:</b>
                          <p><b>ACCT NAME:</b><?php echo $accnme; ?></p>
                          <p><b>BANK:</b>  <?php echo $bnkdesp; ?></p>
                          <p><b>BRANCH:</b> <?php echo $bnkaddress; ?></p>
                          <p><b>ACCOUNT NO.:</b>  <?php echo $accnum; ?></p>
                          <p><b>SORT CODE:</b> <?php echo $sortcode; ?></p>
            
                          </div>
                      </address> 
                  </td>
                  <td>
                      <address style="font-size:0.7em;">
                    
                        <br/>
                             <?php echo '<img src="data:image/jpeg;base64,'. base64_encode($ACCTHODSign). '" style="width:170px; height:70px;">'; ?>
                        <br/>
                        <!--<b><?php echo $ACCTHODNme; ?></b><br/>-->
                        <b>YAKUBU MOMODU</b><br/>
                        <b style="color:#888888 !important">FINANCE & ACCOUNTS MANAGER </b><br>
                      </address>
                  </td>
                  <td>
                       <address style="font-size:0.7em;">
                          
                            <br/>
                                 <?php echo '<img src="data:image/jpeg;base64,'. base64_encode($ACCTGMSign). '" style="width:170px; height:70px;">'; ?>
                            <br/>
                             <?php
                           $date_now = new DateTime($IVDate);
                            $date2 = new DateTime("2022/01/01");
                            if ($date_now > $date2) { ?>
                            <b>JULIET ASIKA, ACA, ACTI</b><br/>
                            <b style="color:#888888 !important">GM, FINANCE & ACCOUNTS</b><br>
                           <?php }else{ ?>
                           <b><?php echo $ACCTGMNme; ?></b><br/>
                           <b style="color:#888888">GGM/FINANCE & ACCOUNTS</b><br>
                           <?php }
                           ?>
                            
                            <!-- <b><?php echo $ACCTGMNme; ?></b><br/>-->
                          <!--  <b style="color:#888888">GGM/FINANCE & ACCOUNTS</b><br> -->
                             
                          </address>
                  </td>
              </tr>
          </table>
         
          <div>
          <table style="width:97%; font-size:0.7em; border: 2px solid #FF9900; border-radius: 15px; padding-top: 5px; margin: 5px; margin-top:5px; border-spacing: 5px; border-collapse: separate;">
              <tr>
                  <td>
                     <address style="color:#FF9900">
                        www.elshcon.com<br>
                        info@elshcon.com<br>
                        enlmarine1@yahoo.co.uk<br>
                     </address> 
                  </td>
                  <td>
                      <b>CORPORATE OFFICE</b><br/>
                      <address>
                        Deborah Lawson House <br/>
                        Plot F6 Abacha Road, GRA, Phase III <br/>
                        Port Harcourt Rivers State, Nigeria <br/>
                      </address>
                  </td>
                  <td>
                      <b>LAGOS OFFICE</b><br/>
                      <address>
                        33 Kofo Abayomi Street <br/>
                        Victoria Island, Lagos State, Nigeria<br/>
                      </address>
                  </td>
                  <td>
                      <b>FABRICATION YARDS/JETTIES</b><br/>
                      <address>
                        Base 1 - #11, Trans-Woji Road. <br/>
                        Base 2 - #7 Elshcon Close, off 3 Trans-Woji Road. <br/>
                        Trans-Amadi Industrial Layout.  <br/>
                        Port Harcourt. Rivers State, Nigeria<br/>
                      </address>
                  </td>
              </tr>
              
              <tr>
                  
                 
                  <td>
                      <b>TELEPHONE</b><br/>
                      <address>
                        +2348033061804 <br/>
                        +2347029242162 <br/>
                        +2348033107554 <br/>
                      </address>
                  </td>
                   <td>
                      
                  </td>
                   <td>
                      
                  </td>
                   <td>
                      
                  </td>
              </tr>
          </table>
           
           </div> 
          
</div>
          <!-- this row will not appear when printing -->
          <br/>
          <br/>
          <div class="row no-print">
            <div class="col-xs-12">
              <button  class="btn btn-default" onclick="printDiv('PrintArea')"><i class="fa fa-print"></i> Print</button>
             
             <!--<button class="btn btn-success pull-right" title="this means you want to save this state"><i class="fa fa-save"></i> &nbsp; Save Quote State</button>
              </form>
               <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Send Mail</button> -->
            </div>
            <br/><br/>

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

    </script>
 
<?php

function numberTowords($num)
{ 
$ones = array( 
1 => "one", 
2 => "two", 
3 => "three", 
4 => "four", 
5 => "five", 
6 => "six", 
7 => "seven", 
8 => "eight", 
9 => "nine", 
10 => "ten", 
11 => "eleven", 
12 => "twelve", 
13 => "thirteen", 
14 => "fourteen", 
15 => "fifteen", 
16 => "sixteen", 
17 => "seventeen", 
18 => "eighteen", 
19 => "nineteen" 
); 
$tens = array( 
1 => "ten",
2 => "twenty", 
3 => "thirty", 
4 => "forty", 
5 => "fifty", 
6 => "sixty", 
7 => "seventy", 
8 => "eighty", 
9 => "ninety" 
); 
$hundreds = array( 
"hundred", 
"thousand", 
"million", 
"billion", 
"trillion", 
"quadrillion" 
); //limit t quadrillion 
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){ 
if($i < 20){ 
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
$rettxt .= $tens[substr($i,0,1)]; 
$rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
$rettxt .= " ".$tens[substr($i,1,1)]; 
$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
} 
} 
if($decnum > 0){ 
$rettxt .= " and "; 
if($decnum < 20){ 
$rettxt .= $ones[$decnum]; 
}elseif($decnum < 100){ 
$rettxt .= $tens[substr($decnum,0,1)]; 
$rettxt .= " ".$ones[substr($decnum,1,1)]; 
} 
} 
return $rettxt; 
} 

?>

  
	
  </body>
</html>