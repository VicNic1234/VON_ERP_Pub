<?php
session_start();
error_reporting(0);
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

include ('../DBcon/db_config.php');
include('route.php');

$PageTitle = "Non-Balance postings";

$FSCALYR = '2019'; 

$GLOpt = '<option value=""></option>';

$TIDn = $_POST['TID']; $SelectSRC = 0;

$TNCIDqueArray = [];

$resultChartMaster = mysql_query("SELECT *, postings.ChqNo As ChqNoM FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             WHERE postings.isActive=1 AND RptType <> 'Opening Balance'
             ORDER BY postings.TransactionDate");

            $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                  
                $cid = $row['GLImpacted'];
                //$tncid = $row['tncid'];
                $mid = $row['tncid'];
                 $mid2 = $row['CounterTrans'];
                 if($mid2 == 0 && $mid2 != "") { $mid2 = $mid; }
                 if (in_array($mid, $TNCIDqueArray)) 
                 {
                     
                 }
                 else
                 {
                     
                 array_push($TNCIDqueArray, $mid);
                
                
               // echo $mid2 . " :: " . ChkIfBal($mid2) . "" . "</br>";
                $mid3 = str_pad($mid2,6,"0",STR_PAD_LEFT);
                //Here we need to check if trans bal
                $TDRaw = $row['TransactionDate']; //ClassName
                $TD = DateTime::createFromFormat('Y/m/d', $TDRaw)->format('Y/m/d');

               $DiffBal = ChkIfBal($mid, $TDRaw);  //exit;
                if($DiffBal == "MM") {
               // $ChqNoM = $row['ChqNoM'];
                $acid = $row{'account_code'};
                $id2 = $row{'account_code2'};
                $name = $row['account_name'];
                $type_name = $row['name']; //ClassName
                $TT = $row['TransacType']; //ClassName
                
               // $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
                $class_name = $row['ClassName']; //ClassName
                $classID = $row['CID']; //ClassName
                if($TT =="CREDIT") { $CRD = $TAmount;  } else { $CRD = ''; }
                if($TT =="DEBIT") { $DRD = $TAmount; } else { $DRD = ''; }
                
                $RecChartMaster .= '<tr><td>-</td><td>-</td><td>'.$acid.'</td><td><a href="viewacctric?TID='.$cid.'" target="_blank"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacctric?ACCTID='.$mid2.'" target="_blank"><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD, 2).'</td><td>'.number_format($CRD, 2).'</td>
                <td>'.$DiffBal.'</td></tr>';
                }
                //$isActive = $row['MsIsActive'];
                
               }
       
   
                
              }
            }
//exit;
$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

function ChkIfBal($tncid, $TDRaw)
{
    $TCRD = 0.000; $TDRD = 0.000; $CHKBAL = 0.000;
    $resultChartMaster = mysql_query("SELECT TransactionAmount, TransacType, TransactionDate FROM postings  WHERE 
    (postings.tncid = '$tncid' OR CounterTrans = '$tncid')   
             AND postings.isActive=1");
           

            $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
               
                $TT = $row['TransacType']; //ClassName
                $TDateNow = $row['TransactionDate']; //ClassName
                if($TDRaw != $TDateNow)
                {
                    // return "Follow Date: ". $TDateNow ." Main Date : " .$TDRaw . " :::".$tncid;
                    return "MM";
                //$TAmount = floatval($row['TransactionAmount']); //ClassName
                
               // if($TT =="CREDIT")  { $TCRD = $TCRD + $TAmount; }
               // if($TT =="DEBIT") { $TDRD = $TDRD + $TAmount; }
                }
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
              
              return "";
            //return ($TCRD - $TDRD); 
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
            Accounts - Non-Balance postings 
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Postings with Date Difference</li>
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
                  <h3 class="box-title">Non-Balance postings</h3>
                  <div class="box-tools pull-right">
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      
                        <div class="col-md-9 col-md-offset-1" style="background-color: #FF6868; border-radius: 25px;">
                        <form role="form" action="nonbalpost1" method="POST" ><div class="form-group">
              <div class="form-group col-md-3">
                <label>From: </label>
                <input type="text" class="form-control datep" id="FromD" name="FromD" placeholder="Click to set date" value="<?php echo $FromD; ?>" readonly required >
              </div>
              <div class="form-group col-md-3">
                <label>To: </label>
                <input type="text" class="form-control datep" id="ToD" name="ToD" placeholder="Click to set date" readonly value="<?php echo $ToD; ?>" required >
              </div>
               <div class="form-group col-md-6">
                            <label>GL Acct: </label>
                            <select class="form-control" id="srcselect2" name="TID[]" multiple="multiple" >
                                <?php echo $GLOpt; ?>
                            </select>
                          </div>
                           <script type="text/javascript">      
                                $('#srcselect2').select2({
                                    multiple: true,
                                    //selectionTitleAttribute: false
                                });
                                
                                /*$('#srcselect2').on('change', function (evt) {
                                   $('#srcselect2').removeAttr('title');
                                  
                                });
                                
                                $('#srcselect2').hover(function () {
                                        $(this).removeAttr('title');
                                    });
                                */
                             </script>
              <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i></button><br/></form>
              </div>
                      
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
                        <th colspan="10"><center style="font-size:1.5em">ELSHCON NIGERIA LIMITED</center></th>
                      </tr>
                      <tr>
                        <th colspan="10"><center style="font-size:1.5em">GL Report - Non Balanced postings</center></th>
                      </tr>
                      <tr>
                        <th colspan="10"><center style="font-size:1.2em">FROM: <?php echo $FromD; ?> &nbsp;  &nbsp;  &nbsp; TO: <?php echo $ToD; ?> </center></th>
                      </tr>
                    </thead>
                    <thead>
                      <tr>
                        <th>Account Class</th>
                        <th>Account Type</th>
                        <th>Account Code</th>
                        <th>Account Name</th>
                        <th>Date</th>
                        <th>RefNo./ChequeNo.</th>
                        <th>Trans. Descr.</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance/Diff</th>
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
        var Dat = "GL Report"; //+ new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "GL Report",
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