<?php
session_start();
//error_reporting(E_ALL); ini_set('display_errors', 1); 
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');



$IJK = $_GET['IJK'];
  

$FromD = $_POST['FromD'];
if($FromD != "")
{
$FromD = DateTime::createFromFormat('Y/m/d', $FromD)->format('Y/m/d');

$ToD = $_POST['ToD'];
$ToD = DateTime::createFromFormat('Y/m/d', $ToD)->format('Y/m/d');



}

$VendSource = $_POST['VendSource']; 

if($IJK != "")
{
  $VendSource =  $IJK;
}

function getTotalAmtPosted($VenID)
{
    
   $TodayD = date("Y/m/d"); //
   
    $FromD = $GLOBALS['FromD']; 
   $ToD = $GLOBALS['ToD'];
   $InvoiceUniqueArray = [];
   $PostedAmtMOK = 0.0; $D0T30 = 0.0; $D31T60= 0.0; $D61T90= 0.0; $D91UP = 0.0;
   /*$resultPOSTING = mysql_query("SELECT * FROM postings 
   LEFT JOIN enlinvoices ON postings.ENLINVOICE = enlinvoices.cid
   Where ENLINVOICE='$enlinvoiceCode' AND TransacType='DEBIT' AND GLImpacted='589'");*/
   //LEFT JOIN enlinvoices ON postings.ENLINVOICE = enlinvoices.cid
   //SUM(TransactionAmount) As TotalDebet //
   $resultPOSTING = mysql_query("SELECT * FROM postings Where postings.VendorID='$VenID' AND postings.TransacType='CREDIT' AND postings.GLImpacted='602' AND postings.isActive=1");
   
   $NoRowPOST = mysql_num_rows($resultPOSTING);
if ($NoRowPOST > 0) {
  while ($row = mysql_fetch_array($resultPOSTING)) 
  {
    $PayBal = $row['TransactionAmount'];
    $IVDate = (str_replace("/", "-", $row['TransactionDate']));
    //$IVD = date_create($IVDate);
    //$ENLINVOICE = $row['VINVOICE'];
   
      { 
     
  
   
            {
            
            $daysdiffernce = date_diff(date_create($IVDate),date_create($TodayD));
            $DateDiff = $daysdiffernce->format("%R%a");
            
            $TD = $row['TransactionDate'];
            $TDm = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');
            
            if($FromD == "")
                {
                    if($DateDiff < 31) { $D0T30 += floatval($PayBal); }
                    if($DateDiff > 30 && $DateDiff < 61) { $D31T60 += floatval($PayBal); }
                    if($DateDiff > 60 && $DateDiff < 91) { $D61T90 += floatval($PayBal); }
                    if($DateDiff > 90 ) { $D91UP += floatval($PayBal); }
                    $PostedAmtMOK += floatval($PayBal);
                }
                elseif ( $TDm <= $ToD) //$FromD <= $TDm &&
                                {
                                 if($DateDiff < 31) { $D0T30 += floatval($PayBal); }
                                 if($DateDiff > 30 && $DateDiff < 61) { $D31T60 += floatval($PayBal); }
                                 if($DateDiff > 60 && $DateDiff < 91) { $D61T90 += floatval($PayBal); }
                                 if($DateDiff > 90 ) { $D91UP += floatval($PayBal); }
                                 $PostedAmtMOK += floatval($PayBal); 
                                }
            
            
            
            
            }
       //////////////////////////////////////////////////
      } 
    
    
   }
}




  //return array($PostedAmtMOK, $D0T30, $D31T60, $D61T90, $D91UP);
  return $PostedAmtMOK;//$PostedAmt - $PaidAmt;
}


////////////////////////////////////////////////////
function getTotalAmtPaid($VenID)
{
    ////////////////////////PAID ////////////////////////////////
     $TodayD = date("Y/m/d");
     $FromD = $GLOBALS['FromD']; 
   $ToD = $GLOBALS['ToD'];
 $PaidAmt = 0.0; $PostedAmtMOK = 0.0; $D0T30 = 0.0; $D31T60= 0.0; $D61T90= 0.0; $D91UP = 0.0;
  
  // $resultPAID = mysql_query("SELECT * FROM postings Where ENLINVOICE='$enlinvoiceCode' AND TransacType='CREDIT' AND GLImpacted='589' AND postings.isActive=1");
  $resultPAID = mysql_query("SELECT * FROM postings Where VendorID='$VenID' AND TransacType='DEBIT' AND GLImpacted='602' AND postings.isActive=1");
        $NoRowPAID = mysql_num_rows($resultPAID);
        if ($NoRowPAID > 0) 
        {
          while ($row = mysql_fetch_array($resultPAID)) 
          {
              $PayBal = $row['TransactionAmount'];
              $IVDate = (str_replace("/", "-", $row['TransactionDate']));
   
            $pamtd = $row['TransactionAmount'];
            $TD = $row['TransactionDate'];
            $TDm = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');
            //ENLINVOICE
            /* if($FromD == "")
                {
                    $PaidAmt = $PaidAmt + floatval($pamtd);
                }
                elseif ($TDm <= $ToD)
                {
                    $PaidAmt = $PaidAmt + floatval($pamtd);
                }
                */
                $daysdiffernce = date_diff(date_create($IVDate),date_create($TodayD));
            $DateDiff = $daysdiffernce->format("%R%a");
            
            
            if($FromD == "")
                {
                    if($DateDiff < 31) { $D0T30 += floatval($PayBal); }
                    if($DateDiff > 30 && $DateDiff < 61) { $D31T60 += floatval($PayBal); }
                    if($DateDiff > 60 && $DateDiff < 91) { $D61T90 += floatval($PayBal); }
                    if($DateDiff > 90 ) { $D91UP += floatval($PayBal); }
                    $PostedAmtMOK += floatval($PayBal);
                }
                elseif ( $TDm <= $ToD) //$FromD <= $TDm &&
                                {
                                 if($DateDiff < 31) { $D0T30 += floatval($PayBal); }
                                 if($DateDiff > 30 && $DateDiff < 61) { $D31T60 += floatval($PayBal); }
                                 if($DateDiff > 60 && $DateDiff < 91) { $D61T90 += floatval($PayBal); }
                                 if($DateDiff > 90 ) { $D91UP += floatval($PayBal); }
                                 $PostedAmtMOK += floatval($PayBal); 
                                }
           }
        }
        
        return $PostedAmtMOK;
        //return array($PostedAmtMOK, $D0T30, $D31T60, $D61T90, $D91UP);
}
/////////////////////////////////////
//Let's Read ChartClass
$RecChartMaster = "";

///////////////////////////////////
/////////////////////////////////////
 $resultLI = mysql_query("SELECT * FROM suppliers  ORDER BY SupNme
 ");
 
$NoRowLI = mysql_num_rows($resultLI); 
$SETOVERPAYAMT = 0.0;
if ($NoRowLI > 0) 
{
  while ($row = mysql_fetch_array($resultLI)) 
  {
    $SN =  $SN  + 1;
   // $cid = $row['cid'];
    $supid = $row['supid'];
    
    $SupName = $row['SupNme'];
    //chk if we owe the customer
    $amtOweing = getTotalAmtPosted($supid) - getTotalAmtPaid($supid);
   if($amtOweing <> 0)
   {
       $TCRD = 0.0; $TDRD = 0.0; $CHKBAL = 0.0;
       $VendSource = $supid;
       ///************************************************************///////
        $resultChartMaster = mysql_query("SELECT *, postings.tncid As TNID FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             
             LEFT JOIN acct_vendorsinvoices ON postings.VINVOICE = acct_vendorsinvoices.cid
             LEFT JOIN cheuqes ON postings.ChqNo = cheuqes.chid
             
             WHERE 
             
             (postings.GLImpacted != '602' AND postings.TransacType = 'CREDIT' AND postings.VendorID = '$VendSource' AND postings.isActive=1 AND postings.TransactionAmount > 0  )   
            
             OR 
             
             (postings.GLImpacted = '602' AND postings.TransacType = 'CREDIT' AND postings.VendorID = '$VendSource' AND postings.isActive=1 AND postings.TransactionAmount > 0) 
            
             
             ORDER BY postings.TransactionDate");
             
             //Trade Payable

            $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                $mid = $row['tncid'];
                 $mid2 = $CuntAcct = $row['CounterTrans'];
                if($mid2 == 0 || $mid2 == "") { $mid2 = $mid; }
                $mid3 = str_pad($mid2,6,"0",STR_PAD_LEFT);
                $cid = $row['GLImpacted'];
                 
                $vendivNo = $row['IVNo'];
                $ChqNoM = $row['ChqNoM'];
                $CheuqeNME = $row['CHKNME'];
                $vendivid = $row['ivcid'];
                 if($vendivid < 1)
                 {
                    $vendivid = getCorrIVNO($mid)[0];
                    $vendivNo = getCorrIVNO($mid)[1];
                 }
                $VINVOICE = $row['VINVOICE'];
                $acid = $row{'account_code'};
                $id2 = $row{'account_code2'};
                $name = $row['account_name'];
                $type_name = $row['name']; //ClassName
                $TT = $row['TransacType']; //ClassName
                $GLDescription = $row['GLDescriptionPB'];
                if($GLDescription == "Trade Payable") { $TT = "DEBIT"; }
                $TD = $row['TransactionDate']; //ClassName
                if($TD != "")
                {
                $TD = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');
                }
                $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
                $class_name = $row['class_name']; //ClassName
                $classID = $row['CID']; //ClassName
                //$invoclinke = '<a href="postedINVOICE?poid='.$vendivid.'"><i class="fa fa-eye text-yellow"></i></a>'; //
                $invoclinke = '<span onClick="javascript:popUp(\'postedINVOICE?poid='.$vendivid.'\')"><i class="fa fa-eye text-yellow"></i></span>';
                 /* if($TT =="CREDIT" && $cid == 602)  { $DRD = $TAmount; $TDRD = $TDRD + $TAmount; $CHKBAL = $CHKBAL + $DRD; } //else { $DRD = ''; }
                  else if($TT =="CREDIT" && $cid != 602) { $CRD = $TAmount; $TCRD = $TCRD + $TAmount; $CHKBAL = $CHKBAL - $CRD; } */
                //$isActive = $row['MsIsActive'];
               if($FromD == "")
            {
                  if($TT =="CREDIT")  { $DRD = $TAmount; $TDRD = $TDRD + $TAmount; $CHKBAL = $CHKBAL + $DRD; } else { $DRD = ''; }
                if($TT =="DEBIT") { $CRD = $TAmount; $TCRD = $TCRD + $TAmount; $CHKBAL = $CHKBAL - $CRD; } else { $CRD = ''; } 
               
                $RecChartMaster .= '<tr><td>'.$SupName.'</td><td>'.$acid.'</td><td><span onClick="javascript:popUp(\'viewacct?TID='.$cid.'\')" ><i class="fa fa-eye"></i></span> '.$name.'</td><td>'.$TD.'</td><td>'.$invoclinke.' '.$vendivNo.'</td><td>'.$CheuqeNME.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD,2).'</td><td>'.number_format($CRD,2).'</td>
                <td>'.number_format($CHKBAL, 2).'</td></tr>';
            }
            elseif ($FromD <= $TD && $TD <= $ToD)
            {
                  if($TT =="CREDIT")  { $DRD = $TAmount; $TDRD = $TDRD + $TAmount; $CHKBAL = $CHKBAL + $DRD; } else { $DRD = ''; }
                if($TT =="DEBIT") { $CRD = $TAmount; $TCRD = $TCRD + $TAmount; $CHKBAL = $CHKBAL - $CRD; } else { $CRD = ''; } 
               
              $RecChartMaster .= '<tr><td>'.$SupName.'</td><td>'.$acid.'</td><td><span onClick="javascript:popUp(\'viewacct?TID='.$cid.'\')"><i class="fa fa-eye"></i></span> '.$name.'</td><td>'.$TD.'</td><td>'.$invoclinke.' '.$vendivNo.'</td><td>'.$CheuqeNME.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD,2).'</td><td>'.number_format($CRD,2).'</td>
                <td>'.number_format($CHKBAL, 2).'</td></tr>';
            }
            
            
            
               
                }

              }
              
              
              
              $RecChartMaster .= '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>'.number_format($TDRD, 2).'</td><td>'.number_format($TCRD, 2).'</td>
                <td style="border-top: 3px double black;">'.number_format($TDRD-$TCRD, 2).'</td></tr>'; 
       //////*************************************************************/////
       
              $RecChartMaster .= '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'; 
   }
    
  }
}
/////////////////////////////////////////////////////////////////////////////
$SupOpt = '<option value=""> --- </option>';

 /*Get Suppliers*/
$resultSUP = mysql_query("SELECT * FROM suppliers Order By SupNme");
$NoRowSUP = mysql_num_rows($resultSUP);
if ($NoRowSUP > 0) {
  while ($row = mysql_fetch_array($resultSUP)) 
  {
    $supid = $row['supid'];
    $SupNme = $row['SupNme'];
    if($VendSource == $supid){
     $SupOpt .= '<option selected value="'.$supid.'">'.$SupNme.'</option>';
     $VenNme = $SupNme;
    }
    else
    {
    $SupOpt .= '<option value="'.$supid.'">'.$SupNme.'</option>';
    }
  }
 }


// postings.VendorID = $VendSource AND postings.GLImpacted = 602
//(postings.GLImpacted <> 602 AND TransacType = 'CREDIT' AND postings.VendorID = $VendSource )   OR (GLDescription =  'Trade Payable' AND postings.VendorID = $VendSource)
             
   //Let's Read ChartType  OR (postings.GLImpacted = '602' AND TransacType = 'CREDIT' AND postings.VendorID = '$VendSource' AND postings.isActive=1 AND TransactionAmount > 0) 
   
     //(GLDescriptionPB =  'Trade Payable' AND postings.VendorID = '$VendSource' AND postings.isActive=1) 
          //////////////////////////////////////////////////////////////////////////
         
      
              
              
              
  function getCorrIVNO($mid)
  {
      $resultChartMaster = mysql_query("SELECT * FROM postings WHERE CounterTrans='$mid'");
      $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
               $IVNO = $row['VINVOICE'];
              }
            }
            
      $resultChartMaster = mysql_query("SELECT * FROM acct_vendorsinvoices WHERE cid='$IVNO'");
      $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
               $IVNo = $row['IVNo'];
              }
            }
      return array($IVNO, $IVNo);
  }
              
            
              
              
              




$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];


?>
<!DOCTYPE html>
<html>
 <?php include('../header2.php'); ?>
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
            Accounts - Vendor Ledger
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Vendor Ledger</li>
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

<script>
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=768,height=768');");
}
</script>


          <!-- Info boxes -->
          <div class="row">
           <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Vendor Ledger</h3>
                  <div class="box-tools pull-right">
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      
                        <div class="col-md-8 col-md-offset-2" style="background-color: #ccc; border-radius: 25px; padding:19px;">
                        <form role="form" action="venALL" method="POST" ><div class="form-group">
              <div class="form-group col-md-3">
                <label>From: </label>
                <input type="text" class="form-control datep" id="FromD" name="FromD" placeholder="Click to set date" value="<?php echo $FromD; ?>" readonly required >
              </div>
              <div class="form-group col-md-3">
                <label>To: </label>
                <input type="text" class="form-control datep" id="ToD" name="ToD" placeholder="Click to set date" readonly value="<?php echo $ToD; ?>" required >
              </div>
              <!-- <div class="form-group col-md-6">
                <label>Vendor: </label>
                <select class="form-control srcselect" id="VendSource" name="VendSource" required >
                    <?php echo $SupOpt; ?>
                </select>
              </div> -->
              <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i></button><br/></form>
              </div>
                   <script type="text/javascript">      
                            $('.srcselect').select2();
                     </script>   
                    </div>
                  </div>
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                 <!--<button class="btn btn-success pull-right" id="addAcct" onclick="addAcc(this)" > Add Account Master</button>-->
                 <button class="btn btn-success pull-left" onclick="ExportToExcel()" > Export To Excel</button>
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                   <table id="userTab" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                          <td colspan="11"><center style="font-weight:800; font-size:1.4em">ELSHCON NIGERIA LIMITED</center></td>
                          
                      </tr>
                       <tr>
                         
                          <td colspan="11"><center style="font-weight:800; font-size:1.2em">Vendor's Ledger</center></td>
                      </tr>
                       </thead>
                    <thead>
                      <tr>
                       
                        <th>Vendor</th>
                         <th>Account Code</th>
                        <th>Account Name</th>
                        <th>Date</th>
                         <th>Invoice</th>
                        <th>CheqNo./RefNo.</th>
                        <th>TransNo.</th>
                        <th>Trans. Descr.</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $RecChartMaster; ?>
                    </tbody>
                   
                  </table>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
            
        </div><!-- /.row -->


          

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

       <?php include('../footer.php') ?>
      

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

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='../plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="../plugins/chartjs/Chart.min.js" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard2.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
     <script src="../mBOOT/jquery-ui.js"></script>
    <script type="text/javascript">
     $("#userTab").dataTable(
            {
          "bPaginate": false,
          //"bLengthChange": true,
          "bFilter": false,
          "bSort": false,
          "bInfo": true
          //"bAutoWidth": true
        });
    </script>

    <script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>
    
    <script type="text/javascript">
     function ExportToExcel()
      {
        var Dat = "Vendor Ledger"; //+ new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "Vendor Ledger",
              filename: Dat,
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true
            });
      }
     </script>

     <script type="text/javascript">
       $(".datep").datepicker({dateFormat : 'yy/mm/dd', changeYear:true, changeMonth:true});
     </script>


  </body>
</html>