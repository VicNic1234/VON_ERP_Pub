<?php
session_start();
error_reporting(0);

include('route.php');


$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';

$CONID = $_POST['poid'];
$resultLI = mysql_query("SELECT *, rfq.Comment AS RFQComment FROM rfq 
 LEFT JOIN customers ON rfq.cusid = customers.cusid
 LEFT JOIN users ON rfq.PEAID = users.uid
 LEFT JOIN businessunit ON rfq.RFQBusUnit = businessunit.id
 WHERE RFQid='".$CONID."'
 "); //WHERE isActive=1 ORDER BY cid

 $NoRowLI = mysql_num_rows($resultLI);
//fetch tha data from the database
   if ($NoRowLI > 0) 
   {
   $SN = 1;
  while ($row = mysql_fetch_array($resultLI)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     
    $cid = $row['RFQid'];
    $RFQNo = $row['RFQNum'];
    $CustormerNme = $row['CustormerNme'];
    $ClientAddress = $row['CusAddress'];
    //$ClientCountry = $row['CusAddress'];
    $ClientPhone1 = $row['CusPhone'];
    $Comment = $row['RFQComment'];
    $BusUNit = $row['BussinessUnit'];
    $BusUNitID = $row['RFQBusUnit'];
    $DateStart = $row['DateStart']; 
    $DateEnd = $row['DateEnd'];
    $Attention = $row['Attention'];
    $RFQCurrency = $row['Currency'];
    //$RaisedBy = $row['Firstname'] . " " . $row['Surname'];//$row['RaisedBy'];
    $FileLink = $row['Attachment'];
   
    }
  }
  else
  {
    $_SESSION['ErrMsg'] = "Oops! an error occured, try again";
    header('Location: rfqs');
    exit;
  }

if($RFQCurrency == "NGN")
{
$CurrNme = "Naira";
}
$PageTitle = "Quotation : ".$RFQNo;
	
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
$resultPOIt = mysql_query("SELECT * FROM lineitems Where RFQCode='".$CONID."'");
$NoRowPOIt = mysql_num_rows($resultPOIt);
 $SN = 0; $SubTotal = 0; $MainTotal = 0;
if ($NoRowPOIt > 0) {
  while ($row = mysql_fetch_array($resultPOIt)) 
  {
    $sdid = $row['LitID'];
    $description = $row['Description'];
    $UOM = $row['UOM'];
    $Qty = $row['Qty']." (".$UOM.")";
    $Qtyn = $row['Qty'];
    $UnitCost = $row['UnitCost'];
    $ExtendedCost = $row['ExtendedCost'];
    $SubTotal = $SubTotal + $ExtendedCost;
      //$delDoc = '<a href="deldoc?id='.$sdid.'"><i class="fa fa-trash"></i></a>';
    $SN = $SN + 1;
    $LineItems .= '<tr style="border: 2px solid black;">
                    <td style="border: 1px solid black;">'.$SN.'</td>
                    <td style="border: 1px solid black;">'.$UOM.'</td>
                    <td style="border: 1px solid black;">'.$description.'</td>
                    <td style="border: 1px solid black;">'.$Qtyn.'</td>
            <td style="border: 1px solid black;">'.$RFQCurrency . " ".number_format($UnitCost).'</td>
            <td style="border: 1px solid black;">'.$RFQCurrency . " ".number_format($ExtendedCost).'</td>
                    </tr>';
  }
 }  

         /*Get Terms*/
$resultTerm = mysql_query("SELECT * FROM terms Where TransID='".$CONID."' AND module='RFQ' AND isActive=1 Order By termsID");
$NoRowTerm = mysql_num_rows($resultTerm);
 $SN = 0;
if ($NoRowTerm > 0) {
  while ($row = mysql_fetch_array($resultTerm)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['termsID'];
    $Term = $row['Terms'];
    $addedby = $row['CreatedBy'];
   
    $delDoc = "";
    if($addedby == $MYID)
    {
      $delDoc = '<a href="delterm?id='.$sdid.'"><i class="fa fa-trash"></i></a>';
    }
    $Terms .= '<p>
                      '.$SN.'.) '.$Term.'
                      </p>';
  }
 }   

   /*Get Supporting Docs*/
$resultSDoc = mysql_query("SELECT * FROM supportingdoc Where docid='".$CONID."' AND module='CNP' Order By sdid");
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
            Quotation
            <small><?php echo $RFQNo; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../"><i class="fa fa-dashboard"></i> Home</a></li>
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
			
        <section class="invoice">
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
                
          <!--<center><b><h2>PURCHASE ORDER</h2></b></center>
          <small class="pull-right">ENL/C&P/F03</small>-->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              Ref:<strong> <?php echo $RFQNo; ?></strong>
              <br/>
              <br/>
              <address>
                <b style="color:#888888"><?php echo $CustormerNme; ?></b><br>
                <?php echo $ClientAddress; ?><br>
                <?php echo $ClientPhone1; ?><br>
                <br>
                Attn:<strong> <?php echo $Attention; ?></strong>
                <br/> <br/>
                Dear Sir,
                <br/> <br/>
                <strong>RE: REQUEST FOR QUOTATION: <?php echo $ProjectTitle; ?></strong>
              </address>
            </div><!-- /.col -->
            <!--<div class="col-sm-4 invoice-col">
             <strong> BUYER</strong>
             <address>
                <b style="color:#888888"><?php echo $_SESSION['CompanyName']; ?></b><br>
                Port Harcourt, Rivers State, Nigeria<br>
                Contact: <?php echo $ATTNME; ?><br/>
                Phone: <?php echo $ATTPHONE; ?><br/>
                Email: <?php echo $ATTEMAIL; ?><br/>
                URL: www.elshcon.com
              </address><br/>
            </div>--><!-- /.col -->
            <!--<div class="col-sm-4 invoice-col">
              <b>Purchase Order No.: </b><br/>
              <?php echo $PONo; ?><br/>
              <br/>
              <b>PO Date:</b><br/> <?php echo $PODate;?>
            </div>--><!-- /.col -->
          </div><!-- /.row -->

          <div class="row">
          <div class="col-md-12">
            <p>We thank you for your interest in our <?php echo $BusUNit; ?>. As per your request, please find listed below for your perusal our pricing, terms and conditions.
            </p>
            <p>If you require clarification on any part of our submission, please don’t hesitate to contact the undersigned on telephone numbers 08033107554, 08062500044 email: bd@elshcon.com</p>
            <p>We look forward to hearing from you.</p>
            <br/><br/><br/>
          </div>
          </div>

           <div class="row invoice-info" style="page-break-after:auto">
            <div class="col-sm-4 invoice-col">
              <em>For:</em><strong> ELSHCON NIGERIA LIMITED</strong>
              <br/>
              <br/>
              <br/>
              <address>
                <b style="color:#888888">Business Development Manager </b><br>
              </address>
            </div><!-- /.col -->
            
          </div><!-- /.row -->
          <br/><br/>
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped" style="border: 2px solid black;">
                 <tbody>
                      <tr>
                        <th style="border: 1px solid black;">S/N</th>
                        <th style="border: 1px solid black;">UNIT</th>
                        <th style="border: 1px solid black;">DESCRIPTION</th>
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
                      <td><b><?php echo $RFQCurrency . " " . number_format($SubTotal); ?></b></td>
                    </tr>
                    <?php echo $MItems; ?>
                    <tr style="border: 2px solid black;">
                      <td colspan="4"> &nbsp; </td>
                      <td><b>TOTAL</b></td>
                      <td><b><?php echo $RFQCurrency . " " . number_format($SubTotal); ?></b></td>
                    </tr>
                   
                    </tbody>
              </table>

            </div><!-- /.col -->
          </div><!-- /.row --><br/>
          <div class="row">
            <div class="col-md-12"><b>AMOUNT IN WORDS : </b> <em><?php echo strtoupper(number_to_word($SubTotal)). " ".strtoupper($CurrNme); ?></em></div>
          </div>
          <br/><br/>
         
          <strong><u>Notes to Pricing:</u></strong>
          <br/><br/>
          <?php echo $Terms; ?>
          <br/><br/>
          <br/><br/>
          <div class="row invoice-info" style="font-size:11px; border: 2px solid #FF9900; border-radius: 15px; padding-top: 5px; margin: 5px">
            <div class="col-sm-2 invoice-col">
              <address style="color:#FF9900">
                www.elshcon.com<br>
                info@elshcon.com<br>
                enlmarine1@yahoo.co.uk<br>
              </address>
            </div><!-- /.col -->
           
            <div class="col-sm-2 invoice-col">
              <b>CORPORATE OFFICE</b><br/>
              <address>
                Deborah Lawson House <br/>
                Plot F6 Abacha Road, GRA, Phase III <br/>
                Port Harcourt Rivers State, Nigeria <br/>
              </address>
            </div><!-- /.col -->

            <div class="col-sm-2 invoice-col">
              <b>LAGOS OFFICE</b><br/>
              <address>
                169A Moshood Olugbani Street <br/>
                Off Ligali Ayorinde Street, <br/>
                Victoria Island, Lagos State, Nigeria<br/>
              </address>
            </div><!-- /.col -->

             <div class="col-sm-2 invoice-col">
              <b>FABRICATION YARDS/JETTIES</b><br/>
              <address>
                3&11 Trans Woji Road, <br/>
                (By Zoo-Woji Bridge)Trans Amadi, <br/>
                Industrial Layout, Port Harcourt. Rivers State, Nigeria<br/>
              </address>
            </div><!-- /.col -->

            <div class="col-sm-2 invoice-col">
              <b>TELEPHONE</b><br/>
              <address>
                +2348033061804 <br/>
                +2347029242162 <br/>
                +2348033107554 <br/>
              </address>
            </div><!-- /.col -->
          </div><!-- /.row -->
          
</div>
          <!-- this row will not appear when printing -->
          <br/>
          <br/>
          <div class="row no-print">
            <div class="col-xs-12">
              <button  class="btn btn-default" onclick="printDiv('PrintArea')"><i class="fa fa-print"></i> Print</button>
             
             <a href="viewrfq?cnid=<?php echo $CONID; ?>"><button class="btn btn-warning pull-right" title="Click to Edit Quotation"><i class="fa fa-edit"></i> &nbsp; Edit Quotation</button></a>
             <!-- </form>
               <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Send Mail</button> -->
            </div>
            <br/><br/>
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
 


  
	
  </body>
</html>