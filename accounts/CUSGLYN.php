<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');//
include('route.php');

$PageTitle = "Customer Ledger";
$IJK = $_GET['IJK'];

  

$FromD = $_POST['FromD'];
if($FromD != "")
{
$FromD = DateTime::createFromFormat('Y/m/d', $FromD)->format('Y/m/d');

$ToD = $_POST['ToD'];
$ToD = DateTime::createFromFormat('Y/m/d', $ToD)->format('Y/m/d');



}

$CusID = $_POST['CusID'];
if($IJK != "")
{
    $CusID = $IJK;
}
$paramsm = 'scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=600,height=300,left=100,top=100';

 /*Get Customers*/
$resultSUP = mysql_query("SELECT * FROM customers Order By CustormerNme");
$NoRowSUP = mysql_num_rows($resultSUP);

$SupOpt = '<option value="">---</option>';
if ($NoRowSUP > 0) {
  while ($row = mysql_fetch_array($resultSUP)) 
  {
    $supid = $row['cusid'];
    $SupNme = $row['CustormerNme'];
    if($CusID == $supid){
     $SupOpt .= '<option selected value="'.$supid.'">'.$SupNme.'</option>';
     $CusNme = $SupNme;
    }
    else
    {
    $SupOpt .= '<option value="'.$supid.'">'.$SupNme.'</option>';
    }
  }
 }//
 
 
 
 //
//AND postings.GLImpacted = 589
//AND (postings.GLImpacted = 589 OR TransacType = 'DEBIT') //
//Let's Read ChartClass
//postings.CusID = $CusID AND
//OR (TransacType = 'DEBIT' AND postings.CusID = $CusID)
//(tncid =  217 OR CounterTrans = 217 AND postings.GLImpacted <> 589)
//OR (GLDescription like '%Customer Debit Bal%' AND postings.CusID = $CusID)
$RecChartMaster = "";
$TCRD = 0.0; $TDRD = 0.0; $CHKBAL = 0.0;
    $resultChartMaster = mysql_query("SELECT *, postings.tncid As TNID, enlinvoices.cid As ivcid, reciepts.CheuqeNME As CHKNME  FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             LEFT JOIN enlinvoices ON postings.ENLINVOICE = enlinvoices.cid
             LEFT JOIN reciepts ON postings.ChqNo = reciepts.chid
             WHERE (postings.GLImpacted <> 589 AND TransacType = 'DEBIT' AND postings.CusID = $CusID AND postings.isActive=1 AND postings.TransactionAmount > 0 )   
             OR (GLDescriptionPB =  'Trade Receivable' AND postings.CusID = $CusID AND postings.isActive=1) 
             
             
             ORDER BY postings.TransactionDate");
           

            $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                $mid = $row['tncid'];
                 $mid2 = $CuntAcct = $row['CounterTrans'];
                if($mid2 == 0) { $mid2 = $mid; }
                $mid3 = str_pad($mid2,6,"0",STR_PAD_LEFT);
                $cid = $row['GLImpacted'];
                $enlivid = $row['ivcid'];
                $enlivNo = $row['IVNo'];
                if($enlivNo == "") { $enlivNo = $row['REQCODE']; } 
                $ChqNoM = $row['ChqNoM'];
                $CheuqeNME = $row['CHKNME'];
                $acid = $row{'account_code'};
                $id2 = $row{'account_code2'};
                $name = $row['account_name'];
                $type_name = $row['name']; //ClassName
                $TT = $row['TransacType']; //ClassName
                $GLDescription = $row['GLDescription'];
                $GLDescriptionPB = $row['GLDescriptionPB'];
                if($GLDescription == "Trade Receivable") { $TT = "CREDIT"; }
                //if($acid == 589) { $TT = "CREDIT"; }
                $TD = $row['TransactionDate']; //ClassName
                $TD = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');

                $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
                $class_name = $row['ClassName']; //ClassName
                $classID = $row['CID']; //ClassName
                $invoclinke = '<a href="postedENLINV?poid='.$enlivid.'"><i class="fa fa-eye text-yellow"></i></a>';
                //$invoclinke = '<a onclick="lpage(postedENLINV?poid='.$enlivid.', \'Hey\','.$paramsm.' )><i class="fa fa-eye text-yellow"></i></a>';
                
                if($TT =="CREDIT")  { $DRD = $TAmount; $TDRD = $TDRD + $TAmount; $CHKBAL = $CHKBAL + $DRD; } else { $DRD = ''; }
                if($TT =="DEBIT") { $CRD = $TAmount; $TCRD = $TCRD + $TAmount; $CHKBAL = $CHKBAL - $CRD; } else { $CRD = ''; }
                //$isActive = $row['MsIsActive'];
               if($FromD == "")
            {
                $RecChartMaster .= '<tr><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td>'.$invoclinke.' '.$enlivNo.'</td><td>'.$CheuqeNME.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD, 2).'</td><td>'.number_format($CRD, 2).'</td>
                <td>'.number_format($CHKBAL, 2).'</td></tr>';
            }
            elseif ($FromD <= $TD && $TD <= $ToD)
            {
              $RecChartMaster .= '<tr><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td>'.$invoclinke.' '.$enlivNo.'</td><td>'.$CheuqeNME.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD, 2).'</td><td>'.number_format($CRD, 2).'</td>
                <td>'.number_format($CHKBAL, 2).'</td></tr>';
            }
            
            
            
               
                }

              }
              
             $RecChartMaster .= '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>'.number_format($TDRD, 2).'</td><td>'.number_format($TCRD, 2).'</td>
                <td style="border-top: 3px double black;">'.number_format($TDRD-$TCRD, 2).'</td></tr>'; 
      


$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

function getRECIPT($rID)
{
    $ReciptChk = mysql_query("SELECT * FROM reciepts WHERE chid='$rID'");
}


function ChkIfOwening($CusID)
{
    $TCRD = 0.0; $TDRD = 0.0; $CHKBAL = 0.0;
    $resultChartMaster = mysql_query("SELECT *, postings.tncid As TNID, enlinvoices.cid As ivcid, reciepts.CheuqeNME As CHKNME  FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             LEFT JOIN enlinvoices ON postings.ENLINVOICE = enlinvoices.cid
             LEFT JOIN reciepts ON postings.ChqNo = reciepts.chid
             WHERE (postings.GLImpacted <> 589 AND TransacType = 'DEBIT' AND postings.CusID = $CusID AND postings.isActive=1 AND postings.TransactionAmount > 0 )   
             OR (GLDescriptionPB =  'Trade Receivable' AND postings.CusID = $CusID AND postings.isActive=1) 
             
             
             ORDER BY postings.TransactionDate");
           

            $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                $mid = $row['tncid'];
                 $mid2 = $CuntAcct = $row['CounterTrans'];
                if($mid2 == 0) { $mid2 = $mid; }
                $mid3 = str_pad($mid2,6,"0",STR_PAD_LEFT);
                $cid = $row['GLImpacted'];
                $enlivid = $row['ivcid'];
                $enlivNo = $row['IVNo'];
                if($enlivNo == "") { $enlivNo = $row['REQCODE']; } 
                $ChqNoM = $row['ChqNoM'];
                $CheuqeNME = $row['CHKNME'];
                $acid = $row{'account_code'};
                $id2 = $row{'account_code2'};
                $name = $row['account_name'];
                $type_name = $row['name']; //ClassName
                $TT = $row['TransacType']; //ClassName
                $GLDescription = $row['GLDescription'];
                $GLDescriptionPB = $row['GLDescriptionPB'];
                if($GLDescription == "Trade Receivable") { $TT = "CREDIT"; }
                //if($acid == 589) { $TT = "CREDIT"; }
                $TD = $row['TransactionDate']; //ClassName
                $TD = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');

                $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
                $class_name = $row['ClassName']; //ClassName
                $classID = $row['CID']; //ClassName
                //$invoclinke = '<a href="postedENLINV?poid='.$enlivid.'"><i class="fa fa-eye text-yellow"></i></a>';
                //$invoclinke = '<a onclick="lpage(postedENLINV?poid='.$enlivid.', \'Hey\','.$paramsm.' )><i class="fa fa-eye text-yellow"></i></a>';
                
                if($TT =="CREDIT")  { $DRD = $TAmount; $TDRD = $TDRD + $TAmount; $CHKBAL = $CHKBAL + $DRD; } else { $DRD = ''; }
                if($TT =="DEBIT") { $CRD = $TAmount; $TCRD = $TCRD + $TAmount; $CHKBAL = $CHKBAL - $CRD; } else { $CRD = ''; }
                //$isActive = $row['MsIsActive'];
            /*   if($FromD == "")
            {
                $RecChartMaster .= '<tr><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td>'.$invoclinke.' '.$enlivNo.'</td><td>'.$CheuqeNME.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD, 2).'</td><td>'.number_format($CRD, 2).'</td>
                <td>'.number_format($CHKBAL, 2).'</td></tr>';
            }
            elseif ($FromD <= $TD && $TD <= $ToD)
            {
              $RecChartMaster .= '<tr><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td>'.$invoclinke.' '.$enlivNo.'</td><td>'.$CheuqeNME.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD, 2).'</td><td>'.number_format($CRD, 2).'</td>
                <td>'.number_format($CHKBAL, 2).'</td></tr>';
            }*/
            
            
            
               
                }

              }
              
            return $TDRD - $TCRD; 
}
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
            Accounts - Customer Ledger
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Customer Ledger</li>
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
          <!-- Info boxes -->
          <div class="row">
           <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Customer Ledger</h3>
                  <div class="box-tools pull-right">
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      
                        <div class="col-md-8 col-md-offset-2" style="background-color:#E4E4E4; border-radius: 25px; padding:19px;">
                        <form role="form" action="cusGLYN" method="POST" ><div class="form-group">
              <div class="form-group col-md-3">
                <label>From: </label>
                <input type="text" class="form-control datep" id="FromD" name="FromD" placeholder="Click to set date" value="<?php echo $FromD; ?>" readonly required >
              </div>
              <div class="form-group col-md-3">
                <label>To: </label>
                <input type="text" class="form-control datep" id="ToD" name="ToD" placeholder="Click to set date" readonly value="<?php echo $ToD; ?>" required >
              </div>
              <div class="form-group col-md-6">
                <label>Customer: </label>
                <select class="form-control srcselect" id="CusID" name="CusID" required >
                    <?php echo $SupOpt; ?>
                </select>
              </div>
              <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i></button><br/></form>
              </div>
               <script type="text/javascript">      
                            $('.srcselect').select2();
                     </script>   
                  <script>
                  function lpage(url,title, params)
                  {
                     window.open('/', title, params);
                  }
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
                   <table id="userTab" class="table table-bordered table-striped">
                       <thead>
                           <tr>
                          <td colspan="10"><center style="font-weight:800; font-size:1.4em">ELSHCON NIGERIA LIMITED</center></td>
                          
                      </tr>
                       <tr>
                         
                          <td colspan="10"><center style="font-weight:800; font-size:1.2em">Customer - <?php echo $CusNme; ?>'s Ledger</center></td>
                      </tr>
                       </thead>
                    <thead>
                      <tr>
                       
                        <th>Account Code</th>
                        <th>Account Name</th>
                        <th>Date</th>
                        <th>Invoice</th>
                        <th>RefNo./Receipt</th>
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
        var Dat = "Customer Ledger Account"; //+ new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "Customer Ledger Account",
              filename: Dat,
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true
            });
      }
     </script>

     <script type="text/javascript">
       $(".datep").datepicker({dateFormat : 'yy/mm/dd'});
     </script>


  </body>
</html>