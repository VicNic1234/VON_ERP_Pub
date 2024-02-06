<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');

$PageTitle = "All Open Balances";

$FSCALYR = '2019';

$GLOpt = '<option value=""></option>';

$TIDn = $_POST['TID']; $SelectSRC = 0;

$GLOptQ = mysql_query("SELECT * FROM acc_chart_master ORDER BY account_name");
$NoRowGQ = mysql_num_rows($GLOptQ);
if ($NoRowGQ > 0) {
    while ($row = mysql_fetch_array($GLOptQ)) {
        $GLID = $row['mid'];
        $AcctCode = $row['account_code'];
        $GLName = mysql_real_escape_string($row['account_name']);
        if(in_array($GLID, $TIDn, true)){
            $GLOpt .= '<option selected value="'.$GLID.'" title="" > ['.$AcctCode.'] '.$GLName.' </option>';
        }
        else
        {
            $GLOpt .= '<option value="'.$GLID.'" title="" > ['.$AcctCode.'] '.$GLName.' </option>';
        }
        
    }
} 



if(count($TIDn) > 0 && $TIDn[0] != "")
{
   $SelectSRC = 1; 
}

$FromD = $_POST['FromD'];
if($FromD != "")
{
$FromD = DateTime::createFromFormat('Y/m/d', $FromD)->format('Y/m/d');

$ToD = $_POST['ToD'];
$ToD = DateTime::createFromFormat('Y/m/d', $ToD)->format('Y/m/d');
}
//Let's Read ChartClass
$RecChartMaster = "";
if($ToD != "")
{
$ChartClassQ = mysql_query("SELECT * FROM acc_chart_class Where isActive=1 ORDER BY class_name");
}
else
{
    $ChartClassQ = "";
}

$TTDR = 0.0; $TTCR = 0.0;
$NoRowClass = mysql_num_rows($ChartClassQ);
/*if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'cid'};
    $cname = $row['class_name'];
    $AccTClass = $cname;
    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
    <td>-</td></tr>';
   //Let's Read ChartType
      $ChartTypeQ = mysql_query("SELECT * FROM acc_chart_types Where isActive=1 AND class_id=$cid ORDER BY name");
      $NoRowType = mysql_num_rows($ChartTypeQ);
      if ($NoRowType > 0) {
        while ($row = mysql_fetch_array($ChartTypeQ)) {
          $tid = $row{'id'};
          $tname = $row['name'];
          $RecChartMaster .= '<tr><td>-</td><td><em><b>'.$tname.'</em></b></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
          <td>-</td></tr>';
*/
          //////////////////////////////////////////////////////////////////////////
          $resultChartMaster = mysql_query("SELECT *, postings.ChqNo As ChqNoM FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             LEFT JOIN cheuqes ON postings.ChqNo = cheuqes.chid
             WHERE
             (RptType='Opening Balance' OR REQCODE='OPEN BAL' OR CounterTrans like '%OB%') AND postings.isActive=1
             ORDER BY acc_chart_master.mid, postings.TransactionDate");

            $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                  
                $cid = $row['GLImpacted'];
                
                $mid = $row['tncid'];
                 $mid2 = $row['CounterTrans'];
                if($mid2 == 0) { $mid2 = $mid; }
                $mid3 = str_pad($mid2,6,"0",STR_PAD_LEFT);
                
                $ChqNoM = $row['ChqNoM'];
                $acid = $row{'account_code'};
                $id2 = $row{'account_code2'};
                $name = $row['account_name'];
                $type_name = $row['name']; //ClassName
                $TT = $row['TransacType']; //ClassName
                $TD = $row['TransactionDate']; //ClassName
                $TD = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');

                $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = $row['TransactionAmount']; //ClassName
                $class_name = $row['ClassName']; //ClassName
                $classID = $row['CID']; //ClassName
                if($TT =="CREDIT") { $CRD = $TAmount;  } else { $CRD = ''; }
                if($TT =="DEBIT") { $DRD = $TAmount; } else { $DRD = ''; }
                //$isActive = $row['MsIsActive'];
                
        if($SelectSRC == 1 && in_array($cid, $TIDn, true))
          {
                
               
            if($FromD == "")
            {
                 if($TT =="CREDIT") { $TTCR += $TAmount; } 
                if($TT =="DEBIT") { $TTDR += $TAmount; } 
                
                $RecChartMaster .= '<tr><td>-</td><td>-</td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD, 2).'</td><td>'.number_format($CRD, 2).'</td>
                <td>-</td></tr>';
            }
            else
            {
               
                 
                 if ($FromD <= $TD && $TD <= $ToD)
                 {
                     
                      if($TT =="CREDIT") { $TTCR += $TAmount; } 
                      if($TT =="DEBIT") { $TTDR += $TAmount; } 
                  $RecChartMaster .= '<tr><td>-</td><td>-</td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD, 2).'</td><td>'.number_format($CRD, 2).'</td>
                    <td>-</td></tr>';
                 }
            }
          }
        else if($SelectSRC == 0 )
        {
            if($FromD == "")
            {
                 if($TT =="CREDIT") { $TTCR += $TAmount; } 
                if($TT =="DEBIT") { $TTDR += $TAmount; } 
                $RecChartMaster .= '<tr><td>-</td><td>-</td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD, 2).'</td><td>'.number_format($CRD, 2).'</td>
                <td>-</td></tr>';
            }
            else
            {
               
                 
                 if ($FromD <= $TD && $TD <= $ToD)
                 {
                      if($TT =="CREDIT") { $TTCR += $TAmount; } 
                if($TT =="DEBIT") { $TTDR += $TAmount; } 
                  $RecChartMaster .= '<tr><td>-</td><td>-</td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.'</td><td>'.$TDescr.'</td><td>'.number_format($DRD, 2).'</td><td>'.number_format($CRD, 2).'</td>
                    <td>-</td></tr>';
                 }
            }
        }
               
    }
                
               

}

   
              
              
              //////////
                //$RecChartMaster .= $RecChartMasterOB;
                //$RecChartMaster .= $RecChartMasterBK;
                ///////////////////
          ////////////////////////////////////////////////////////////////////////////////

        /* }

        } 

   }

  }*/

 $RecChartMaster .= '<tr><td><b>TOTALS</b></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td style="border-top: double;">'.number_format($TTDR, 2).'</td><td style="border-top: double;">'.number_format($TTCR, 2).'</td>
                <td>-</td></tr>'; 
           


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
            Accounts - All Posted Open Balances 
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">All Posted Open Balances</li>
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
                  <h3 class="box-title">All Posted Open Balances</h3>
                  <div class="box-tools pull-right">
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      
                        <div class="col-md-9 col-md-offset-1" style="background-color: #FF6868; border-radius: 25px;">
                        <form role="form" action="allopenbal" method="POST" ><div class="form-group">
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
                        <th colspan="10"><center style="font-size:1.5em">GL Report - All Opening Balances</center></th>
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