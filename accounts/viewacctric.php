<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');
$PageTitle = "Account Report";

$TID = $_GET['TID'];

 $ACCTID = $_GET['ACCTID']; 

  

$FromD = $_GET['FromD'];
$FromDnn = str_replace("/","-",$FromD);
if($FromD != "")
{
$FromD = DateTime::createFromFormat('Y/m/d', $FromD)->format('Y/m/d');

$ToD = $_GET['ToD'];
$ToD = DateTime::createFromFormat('Y/m/d', $ToD)->format('Y/m/d');
}


/*Get ATTNTION*/
$resultUser = mysql_query("SELECT * FROM users ORDER BY Firstname");
//check if user exist
 $NoRowUser = mysql_num_rows($resultUser);

 $OptStaff ='<option value=""> --- </option>';
 if ($NoRowUser > 0) {
  while ($row = mysql_fetch_array($resultUser)) 
  {
    $SUserID = $row['uid'];
    $StfName = $row['Firstname'] . " " . $row['Surname'];
    if($ENLATTN == $SUserID)
    {
    $OptStaff .= '<option selected value="'.$SUserID.'">'.$StfName.'</option>';
    }
    else
    {
    $OptStaff .= '<option value="'.$SUserID.'">'.$StfName.'</option>';
    }
  }
 }

 $resultUser = mysql_query("SELECT * FROM otherreceiver ORDER BY FullName");
//check if user exist
 $NoRowUser = mysql_num_rows($resultUser);

 
 if ($NoRowUser > 0) {
  while ($row = mysql_fetch_array($resultUser)) 
  {
    $SUserID = "OR". $row['uid'];
    $StfName = $row['FullName'];
   
    $OptStaff .= '<option value="'.$SUserID.'">'.$StfName.'</option>';
   
  }
 }

$GLOpt = '<option value="">---</option>';



$GLOptQ = mysql_query("SELECT * FROM acc_chart_master ORDER BY account_name");
$NoRowGQ = mysql_num_rows($GLOptQ);
if ($NoRowGQ > 0) {
    while ($row = mysql_fetch_array($GLOptQ)) {
        $GLID = $row['mid'];
        $AcctCode = $row['account_code'];
        $GLName = mysql_real_escape_string($row['account_name']);
        if($TID == $GLID){
            $GLOpt .= '<option selected value="'.$GLID.'" > ['.$AcctCode.'] '.$GLName.' </option>';
        }
        else
        {
            $GLOpt .= '<option value="'.$GLID.'" > ['.$AcctCode.'] '.$GLName.' </option>';
        }
        
    }
}

//echo $GLOptB; exit;
    
function getRVBY($RN)
{
 
      $RNm =  substr($RN,0,2);
     if($RNm == "OR") {
         
        $RNK = str_replace("OR","",$RN);
         $ORQQury = mysql_query("SELECT * FROM otherreceiver Where uid = '$RNK'");
         while ($row = mysql_fetch_array($ORQQury)) {
             return $row['FullName'];
         }
     }
     else
        {
            $ORQQury = mysql_query("SELECT * FROM users Where uid ='$RN'");
         while ($row = mysql_fetch_array($ORQQury)) {
             return $row['Firstname'] . " " .$row['Surname'];
         }
        }
     

}

//Let's Read ChartClass
$RecChartMaster = "";
$SuperCredit = 0.000;
$SuperDebit = 0.000;
$ChartClassQ = mysql_query("SELECT * FROM acc_chart_class Where isActive=1 ORDER BY class_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'cid'};
    $cname = $row['class_name'];
    $AccTClass = $cname;
   // $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
   // <td>-</td></tr>';
   //Let's Read ChartType
      $ChartTypeQ = mysql_query("SELECT * FROM acc_chart_types Where isActive=1 AND class_id=$cid ORDER BY name");
      $NoRowType = mysql_num_rows($ChartTypeQ);
      if ($NoRowType > 0) {
        while ($row = mysql_fetch_array($ChartTypeQ)) {
          $tid = $row{'id'};
          $tname = $row['name'];
          //$RecChartMaster .= '<tr><td>-</td><td><em><b>'.$tname.'</em></b></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
          //<td>-</td></tr>';

         
          //////////////////////////////////////////////////////////////////////////
        if($TID != ""){
          $resultChartMaster = mysql_query("SELECT *, postings.ChqNo As ChqNoM, postings.tncid As TNCID FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             LEFT JOIN cheuqes ON postings.ChqNo = cheuqes.chid
             WHERE acc_chart_master.account_type = $tid && postings.GLImpacted = $TID 
             ORDER BY acc_chart_master.mid, postings.TransactionDate");
        }
        //&& postings.isActive=1
        if($ACCTID != ""){
          $resultChartMaster = mysql_query("SELECT *, postings.ChqNo As ChqNoM, postings.tncid As TNCID, postings.isActive As PA  FROM postings
             LEFT JOIN acc_chart_master ON postings.GLImpacted = acc_chart_master.mid
             LEFT JOIN cheuqes ON postings.ChqNo = cheuqes.chid
             WHERE acc_chart_master.account_type = $tid  && (postings.tncid = '$ACCTID' OR postings.CounterTrans = '$ACCTID')
             ORDER BY acc_chart_master.mid, postings.TransactionDate");
        }
            $NoRowChartMaster = mysql_num_rows($resultChartMaster);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultChartMaster)) {
                $mid = $row['TNCID'];
                $TNCID = $row['TNCID'];
                $mid2 = $row['CounterTrans'];
                if($mid2 == 0) { $mid2 = $mid; }
                $mid3 = str_pad($mid2,6,"0",STR_PAD_LEFT);
                $cid = $row['GLImpacted'];
                $ChqNoM = $row['ChqNoM'];
                $ChqName = $row['cheuqeNME']; 
                $acid = $row{'account_code'};
                $ReceivedByM = getRVBY($row['ReceivedBy']);
                $id2 = $row{'account_code2'};
                $name = $row['account_name'];
                $type_name = $row['name']; //ClassName
                $TT = $row['TransacType']; //ClassName
                $TD = $row['TransactionDate'];
                $isAAA = $row['PA'];
                $TDnn = str_replace("/","-",$TD);
                $TD = DateTime::createFromFormat('Y/m/d', $TD)->format('Y/m/d');
                //DateTime::createFromFormat('Y/m/d', $FromD)->format('Y/m/d');

                $ChqNo = $row['cheuqeNME']; //ClassName
                $TDescr = $row['Remark']; //ClassName
                $TAmount = floatval($row['TransactionAmount']); //ClassName
                $class_name = $row['ClassName']; //ClassName
                $classID = $row['CID']; //ClassName
                
                $VendorID = $row['VendorID'];
                $VINVOICE = $row['VINVOICE'];
                
                $CusID = $row['CusID'];
                $ENLINVOICE = $row['ENLINVOICE'];
                
                $REG = getInvoiceLink($VendorID, $VINVOICE, $CusID, $ENLINVOICE); 
                
                if($REG != "")
                {
                  $GHT = '<a target="_blank" href="'.$REG.'"> <i class="fa fa-edit"></i> </a>';
                }
                else
                {
                    $GHT = '';
                }
                
                if($ACCTID > 0)
                {
               // $DelBtn = '<a href="delacct?p='.$TNCID.'"><span title="Delete Posting" class="btn btn-danger"><i class="fa fa-trash"></i></span></a>';
               // $UpdBtn = '<span onclick="updateVAL('.$TNCID.')" title="Update Posting" class="btn btn-primary"><i class="fa fa-edit"></i></span>';
               // $ReInBtn = '<span onclick="updateVAL('.$TNCID.')" title="Re-Instate Posting" class="btn btn-success"><i class="fa fa-undo"></i></span>';
                }
                if($ChqNoM != "")
                {
                $CHPK = ' :: ChequeNo :: <a href="cheuqes?chi='.$ChqNoM.'">'.$ChqName.'</a> '. $GHT;
                }
                else
                {
                $CHPK = '  :: '. $GHT;
                }
                
            if($FromD == "")
            {
                if($TT =="CREDIT") 
                { 
                  $CRD = floatval($TAmount);  
                  $SuperCredit += floatval($TAmount);
                } 
                else 
                { $CRD = ''; }

                if($TT =="DEBIT") 
                { 
                  $DRD = floatval($TAmount); 
                  $SuperDebit += floatval($TAmount);
                } 
                else 
                { $DRD = ''; }
                
                if($isAAA == 1){
                $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td><em><b>'.$tname.'</em></td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.' '.$CHPK.'</td><td>'.$TDescr.'</td><td>'.$ReceivedByM.'</td><td>'.number_format($DRD,4).'</td><td>'.number_format($CRD,4).'</td>
                <td>'.$DelBtn.' '.$UpdBtn.'</td></tr>';
                }
                else
                {
                    $RecChartMaster .= '<tr style="background:#F0D9D4"><td><b>'.$AccTClass.'</b></td><td><em><b>'.$tname.'</em></td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.' '.$CHPK.'</td><td>'.$TDescr.'</td><td>'.$ReceivedByM.'</td><td>'.number_format($DRD,4).'</td><td>'.number_format($CRD,4).'</td>
                <td>'.$ReInBtn.'</td></tr>';
                }
                
            }
            else
            {
                if(strtotime($TD) < strtotime($FromD) )
                {
                    ////////////////////////
                    if($TT =="CREDIT") 
                    { 
                      $CRDOB += floatval($TAmount);  
                      //$SuperCredit += floatval($TAmount);
                    } 
                   
                   
                    if($TT =="DEBIT") 
                    { 
                      $DRDOB += floatval($TAmount); 
                      //$SuperDebit += floatval($TAmount);
                    } 
                   
                    ////////////////////////////
                    
                }
                
                else if ($FromD <= $TD && $TD <= $ToD)
                {
                /////////////////////////////////////////
                    if($TT =="CREDIT") 
                    { 
                      $CRD = floatval($TAmount);  
                      $SuperCredit += floatval($TAmount);
                    } 
                    else 
                    { $CRD = 0; }
    
                    if($TT =="DEBIT") 
                    { 
                      $DRD = floatval($TAmount); 
                      $SuperDebit += floatval($TAmount);
                    } 
                    else 
                    { $DRD = 0; }
                    
                    
                   //$RecChartMasterPK .= '<tr><td><b>'.$AccTClass.'</b></td><td><em><b>'.$tname.'</em></td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.' '.$CHPK.'</td><td>'.$TDescr.'</td><td>'.$ReceivedByM.'</td><td>'.number_format($DRD,2).'</td><td>'.number_format($CRD,2).'</td>
                   // <td>'.$DelBtn.'</td></tr>';
                    if($isAAA == 1){
                    $RecChartMaster .= '<tr><td><b>'.$AccTClass.'</b></td><td><em><b>'.$tname.'</em></td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.' '.$CHPK.'</td><td>'.$TDescr.'</td><td>'.$ReceivedByM.'</td><td>'.number_format($DRD,4).'</td><td>'.number_format($CRD,4).'</td>
                    <td>'.$DelBtn.' '.$UpdBtn.'</td></tr>';
                    }
                    else
                    {
                        $RecChartMaster .= '<tr style="background:#F0D9D4"><td><b>'.$AccTClass.'</b></td><td><em><b>'.$tname.'</em></td><td>'.$acid.'</td><td><a href="viewacct?TID='.$cid.'"><i class="fa fa-eye"></i></a> '.$name.'</td><td>'.$TD.'</td><td><a href="viewacct?ACCTID='.$mid2.'"><i class="fa fa-eye text-green"></i></a> '.$mid3.' '.$CHPK.'</td><td>'.$TDescr.'</td><td>'.$ReceivedByM.'</td><td>'.number_format($DRD,4).'</td><td>'.number_format($CRD,4).'</td>
                    <td>'.$ReInBtn.'</td></tr>';
                    }
                 ///////////////////////////////////////////
                }
            }
               
                }

              }
          ////////////////////////////////////////////////////////////////////////////////

         }

        }

   }

  }
  
  
                    
  //$RecChartMaster .= $RecChartMasterOB;
  //$RecChartMaster .= $RecChartMasterPK;

  //$RecChartMaster .= '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>'.number_format($SuperDebit).'</td><td>'.number_format($SuperCredit).'</td>
               // <td>-</td></tr>';
               $RecChartMaster .= '<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>'.number_format($SuperDebit, 4).'</td><td>'.number_format($SuperCredit, 4).'</td>
                <td style="border-top: 3px double black;">'.number_format($SuperDebit-$SuperCredit, 4).'</td></tr>'; 


$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

function getInvoiceLink($VendorID, $VINVOICE, $CusID, $ENLINVOICE)
{
   if($VendorID > 0) { return 'viewinvoice?poid='. $VINVOICE; }
   if($CusID > 0) { return 'viewenlinvoice?poid='. $ENLINVOICE; }
}

//exit;

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
            Accounts - View Account
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">View Account Report</li>
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
                  <h3 class="box-title">--</h3>
                  <div class="box-tools pull-right">
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      
                        <div class="col-md-10 col-md-offset-1" style="background-color: #FF6868; border-radius: 25px;">
                        <form role="form" action="viewacct" method="GET" >
                            <div class="form-group"> <!-- action="viewacct" method="GET" -->
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
                            <select class="form-control" id="srcselect2" name="TID" required >
                                <?php echo $GLOpt; ?>
                            </select>
                          </div>
                           <script type="text/javascript">      
                                $('#srcselect2').select2();
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
                   <table id="userTab" class="table table-bordered table-striped">
                       <?php if($FromD != "" && $ToD != "") { ?>
                        <thead>
                            <tr>
                        <th colspan="11"><center style="font-size:1.5em">ELSHCON NIGERIA LIMITED</center></th>
                      </tr>
                      <tr>
                        <th colspan="11"><center style="font-size:1.5em">GL ACCOUNT HEAD REPORT</center></th>
                      </tr>
                      <tr>
                        <th colspan="11"><center style="font-size:1.2em">FROM: <?php echo $FromD; ?> &nbsp;  &nbsp;  &nbsp; TO: <?php echo $ToD; ?> </center></th>
                      </tr>
                    </thead>
                    <?php } ?>
                    <thead>
                      <tr>
                        <th>Account Class</th>
                        <th>Account Type</th>
                        <th>Account Code</th>
                        <th>Account Name</th>
                        <th>Date</th>
                        <th>RefNo.</th>
                        <th>Trans. Descr.</th>
                        <th>Received By</th>
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
     
    
     
     <script>
         function updateVAL(tnic)
         {
            var GLOpt = '<?php echo $GLOpt; ?>';
             
              $.ajax({
            url: 'getTNC',
            type: 'POST',
            data: { tnic:tnic },
            //cache: false,
            //processData:false,
            success: function(html)
            {
                     data1 = JSON.parse(html);
                     var GLDescription = data1[0].GLDescription;
                     var Remark= data1[0].Remark;
                     var TransactionAmount = data1[0].TransactionAmount;
                     var TransacType = data1[0].TransacType;
                     var TransactionDate = data1[0].TransactionDate;
                     var GLImpacted = data1[0].GLImpacted;
                     var RecdBy = data1[0].ReceivedBy;
                     
                     var OptStaff = '<?php echo $OptStaff; ?>';
                     
                     
                      var size='standart';
                  var content = '<div class="row" style="background:#EEE6E6; border-radius:5px;" > <div class="col-md-12"><form role="form" action="updatepost" method="post" ><div class="form-group">' +
                    '<input id="PID" name="PID" type="hidden" value="'+tnic+'" />'+
                   
                    '<div class="form-group col-md-12"><label>Received By: </label><select class="form-control"  name="ReceivedBy" id="ReceivedBy" >'+OptStaff+'</select></div>' +

                    '<div class="form-group col-md-12"><label>Select GL Account: </label><select class="form-control"  name="PostGL" id="PostGL" >'+GLOpt+'</select></div>' +

                   '<div class="form-group col-md-12"><label>Post Description: </label><textarea class="form-control"  name="PostRemark" id="PostRemark" required >'+Remark+'</textarea></div>' +

                    /*'<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit: </label><select class="form-control" id="CHSItemUnit"  name="ItemUnit"  >'+UOMOpt+'</select></div>' +
                    */
    
                   
                     '<div class="form-group col-md-6"><label>Posted Date: </label><input type="text" class="form-control" id="PostDate" value="'+TransactionDate+'"  name="PostDate" required readonly ></div>' +
                     
                     '<div class="form-group col-md-6"><label>Posted Amount: </label><input type="text"  onKeyPress="return isNumber(event)" class="form-control" id="PostAmt" value="'+TransactionAmount+'"  name="PostAmt" required ></div>' +

                     

                     //'<div class="form-group col-md-6"><label>Total Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="CHSTotalPrice"  name="TotalPrice" readonly ></div>' +
                   
                     
                   '<button type="sumbit"  class="btn btn-success pull-right">Update Post</button><br/></form></div></div>';
                  var title = 'Posting Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
                  $('#PostDate').datepicker({dateFormat : 'yy/mm/dd'});
                  $('#PostGL').val(GLImpacted);
                  $('#ReceivedBy').val(RecdBy);
                  
                  
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
              //alert(textStatus);
            }           
           });
        }
     </script>
      <script type="text/javascript">
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
    <script type="text/javascript">
     $("#userTab").dataTable(
            {
          "bPaginate": false,
          //"bLengthChange": true,
          "bFilter": true,
          "bSort": false,
          "bInfo": true
          //"bAutoWidth": true
        });
    </script>

    <script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>
    
    <script type="text/javascript">
     function ExportToExcel()
      {
        var Dat = "Account GL Report"; //+ new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "Account GL Report",
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