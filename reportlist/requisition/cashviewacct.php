<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include ('getApprovalsCASH.php');


$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
$Firstname = $_SESSION['Firstname'];
$SurName = $_SESSION['SurName'];
$Department = "";
$DeptIDn = $_SESSION['DeptID'];
$HODID = $_SESSION['uid'];
if($HODID < 1) {
     $_SESSION['ErrMsg'] = "Oops! Timed Out. Kindly Logout and Login Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}

////////////////////////////////////////////////////////////////
       function getUserinfo($uid)
     {
        $resultUserInfo = mysql_query("SELECT * FROM users WHERE uid ='$uid'");
        while ($row = mysql_fetch_array($resultUserInfo)) 
        {
             return $UserNNE = $row['Firstname'] . " " . $row['Surname'];
        }
     }

          function getRequesterinfo($ReqID)
     {
        $resultUserInfo = mysql_query("SELECT * FROM cashreq LEFT JOIN users ON cashreq.staffID = users.uid WHERE cashreq.RequestID ='$ReqID'");
        while ($row = mysql_fetch_array($resultUserInfo)) 
        {
             return $UserNNE = $row['Firstname'] . " " . $row['Surname'];
        }
     }

      function getRequestDescription($ReqID)
     {
        $resultUserInfo = mysql_query("SELECT * FROM cashreq LEFT JOIN users ON cashreq.staffID = users.uid WHERE cashreq.RequestID ='$ReqID'");
        while ($row = mysql_fetch_array($resultUserInfo)) 
        {
             return $ItemDes = substr($row['ItemDes'],0,12)." ...";
        }
     }
///////////////////////////////////////////////////////////////////
$sReqID = $_GET['rNo'];
$TY = $_GET['ty'];
if ($sReqID != "") 
{
  $result = mysql_query("SELECT * FROM cashreq
  
     WHERE RequestID='$sReqID' AND isActive=1");
  
  //Lets get GL for BANK
  $OptGLBank = '<option value="">--</option>';
  $resultGLBnk = mysql_query("SELECT * FROM bankaccount INNER JOIN acc_chart_master ON bankaccount.GLAcct =  acc_chart_master.mid ORDER BY account_name");
    //check if user exist
     $NoRowBnkSet = mysql_num_rows($resultGLBnk);
    if ($NoRowBnkSet > 0) 
      {
        while ($row = mysql_fetch_array($resultGLBnk)) 
        {
          $acctid = $row['baccid'];
          $acctbnkDesp = $row['description'];
          $acctvariable = $row['account_code'];
          $GLAcct = $row['GLAcct'];
          $acctval = $row['account_name'];
          $OptGLBank .='<option glacc="'.$GLAcct.'" value="'.$acctid.'">['.$acctvariable.'] '.$acctval.' :: '.$acctbnkDesp.'</option>';
        }
      }

} 
else 
{
 //$result = mysql_query("SELECT * FROM poreq WHERE Deparment= '".$DeptIDn."'");
}

$NoRow = mysql_num_rows($result);

$TAmt = 0;
if ($NoRow > 0) 
{
  //fetch tha data from the database
  while ($row = mysql_fetch_array($result)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     $reqid = $row['reqid'];
     $staffName = $row['staffName'];
     $staffID = $row['staffID'];
     $staffDeptID = $row['Deparment'];
     $ReqID = $row['RequestID'];
     $ReqDate = $row['RequestDate'];
     $ItemDes = $row['ItemDes'];
     $Purpose = $row['Purpose'];
     $Qty = $row['Qty'];
     $RelatedPDF = $row['RelatedPDF'];
     $attachment = $row['attachment'];
     $UserApp = getUserinfo($row['UserApp']);
     $UserAppDate = $row['UserAppDate'];
     $UserAppComment = $row['UserAppComment'];

     $SupervisorApp = getUserinfo($row['SupervisorApp']);
     $SupervisorAppDate = $row['SupervisorAppDate'];
     $SupervisorAppComment = $row['SupervisorComment'];

     $DeptHeadApp = getUserinfo($row['DeptHeadApp']);
     $DeptHeadAppDate = $row['DeptHeadAppDate'];
     $DeptHeadAppComment = $row['DeptHeadAppComment'];

     $DivHeadApp = getUserinfo($row['DivHeadApp']);
     $DivHeadAppDate = $row['DivHeadAppDate'];
     $DivHeadAppComment = $row['DivHeadAppComment'];

     $MgrApp = getUserinfo($row['MgrApp']);
     $MgrAppDate = $row['MgrAppDate'];
     $MgrAppComment = $row['MgrAppComment'];

     $DDApp = getUserinfo($row['DDApp']);
     $DDAppDate = $row['DDAppDate'];
     $DDAppComment = $row['DDAppComment'];

     $MDApp = getUserinfo($row['MDApp']);
     $MDAppDate = $row['MDAppDate'];
     $MDAppComment = $row['MDComment'];
     
     $attachment = $row['attachment'];
     if($attachment != "") { $attach = '<a href="'.$attachment.'"><i class="fa fa-link"></i></a>'; }
     
      if($attach != "")
      {
             $Files .= '<span id="fidold-'.$reqid.'" style="padding:12px; border-radius:25px; background:#00CCFF; color:#000"><a style="color:#000" href="'.$row['attachment'].'" target="_blank"><i class="fa fa-link"></i> attachment </a></span>';
      }
      
     

     $ApprovedBy = $row['ApprovedBy'];//
     $LastActor = $row['LastActor'];//
     $Status = $row['Status'];//
     $Amount = $row['Amount'];
     $Qnt = $row['Qty'];
     if($Qnt < 1)
      { $Qnt = 1; }

     $TAmt = floatval($TAmt) + (floatval($Amount) * $Qnt);
     $ApprovedChk = $row['Approved'];
     if($Status == "")
     {
       $Status = "Not Submitted";
     }
     else 
     {
      $Status = $Status . " by ". $LastActor;
     }
      
       $ApprovedN = getStatus($ApprovedChk);
if($attachment != "") { $attachmentm = '<td><a href="'.$attachment.'" target="_blank"><i class="fa fa-file"></i></a></td>'; }
else { $attachmentm = ''; }

      $Record .='
           <tr>
            <td>'.$ReqID.'</td>
            <td>'.$ReqDate.'</td>
            <td>'.$ItemDes.'</td>
            <td>'. number_format($Amount).'</td>
            <td>'.$Qnt.'</td>
            <td>'.$RelatedPDF.'</td>
            <td>'.$ApprovedBy.'</td>
            <td>'.$ApprovedN.'</td>
            '.$attachmentm.'
            

            
            
          
          
           </tr>
           
           
           ';
            
     }

    $sresultDept = mysql_query("SELECT * FROM department WHERE id ='$staffDeptID'"); 
 while ($row = mysql_fetch_array($sresultDept)) {
     //$reqid = $row['reqid'];
       $StaffDepartment = $row['DeptmentName'];
     }
}


//Let's Get All GL accounts
 $GLAccounts = mysql_query("SELECT * FROM acc_chart_master WHERE isActive =1 ORDER BY account_name"); 
 while ($row = mysql_fetch_array($GLAccounts)) {
     //$reqid = $row['reqid'];
     $acctvariable = $row['account_code'];
     $GLmid = $row['mid'];
      $GLAcct = $row['account_name'];
       $GLOpt .= '<option value="'.$GLmid.'">['. $acctvariable .'] ' .$GLAcct.'</option>'; // $row['DeptmentName'];
     }

//Let's Get All Currency
 $GLAccounts = mysql_query("SELECT * FROM currencies WHERE isActive =1 ORDER BY Abbreviation"); 
 while ($row = mysql_fetch_array($GLAccounts)) {
     //$reqid = $row['reqid'];
     $Abbreviation = $row['Abbreviation'];
      $curID = $row['curID'];
       $CurOpt .= '<option value="'.$curID.'">'. $Abbreviation .' </option>'; // $row['DeptmentName'];
     }

//Let's Get All BusinessUnits
 $GLAccounts = mysql_query("SELECT * FROM businessunit ORDER BY BussinessUnit"); 
 while ($row = mysql_fetch_array($GLAccounts)) {
     //$reqid = $row['reqid'];
     $BusID = $row['id'];
      $BussinessUnit = $row['BussinessUnit'];
       $BusOpt .= '<option value="'.$BusID.'">' .$BussinessUnit.'</option>'; // $row['DeptmentName'];
     }

//Let's Get All users
 $ReceivedByC = mysql_query("SELECT * FROM users WHERE isActive =1 ORDER BY Firstname"); 
 while ($row = mysql_fetch_array($ReceivedByC)) {
     //$reqid = $row['reqid'];
     $RecvID = $row['uid'];
      $RecNme = $row['Firstname']. " " .$row['Middlename'] ." " .$row['Surname'];
       $RECVOpt .= '<option value="'.$RecvID.'">'.$RecNme.'</option>'; // $row['DeptmentName'];
     }
     
     
      $buildlink = "";
$sql_file=mysql_query("SELECT * FROM filereq WHERE reqcode = '$ReqID' AND isActive=1");
while ($row = mysql_fetch_array($sql_file)) {
       $Files .= '<span  id="fid-'.$row['fid'].'" style="padding:12px; border-radius:25px; background:#00CCFF; color:#000"><a style="color:#000" href="'.$row['fpath'].'" target="_blank"><i class="fa fa-link"></i>'.$row['tile'].' </a></span>';
     }

$buildlink = $Files;

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Print PO Requisition</title>
	<link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	
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
    <!-- DatePicker -->
  
     <link href="../mBOOT/jquery-ui.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

     <script>
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
    }
    </script>
    <script type="text/javascript">


    function Approve(relm)
   {
      
   //alert('God is Greater than the Greatest');
    var dataString = 'litem='+ gh;
    
    
      $.ajax({
      type: "POST",
      url: "APOR1",
      data: dataString,
      cache: false,
      success: function(html)
      {
            
      }
      });
    
    }

    function Cancel(relm)
   {
      
   
    var dataString = 'litem='+ gh;
    
    
      $.ajax({
      type: "POST",
      url: "APOR0",
      data: dataString,
      cache: false,
      success: function(html)
      {
            
      }
      });
    
    }
    </script>


	
  </head>
  <body class="skin-blue sidebar-mini">
  
        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
         
<?php if ($G == "")
           {} else {
echo

'<br><br><div class="alert alert-danger alert-dismissable">' .
                                       '<i class="fa fa-ban"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                        '<b></b>  '.  $G.
                                    '</div>' ; 
									$_SESSION['ErrMsg'] = "";}
?>
<?php if ($B == "")
           {} else {
echo

'<br><br><div class="alert alert-info alert-dismissable">' .
                                       '<i class="fa fa-ban"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                        '<b></b>  '.  $B.
                                    '</div>' ; 
									$_SESSION['ErrMsgB'] = "";}
?>
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

    document.body.innerHTML = originalContents;
} 
</script> 

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  
				   
                  <div class="box-tools pull-right">
                  <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
				  <!--<a style="float:right" href="./"> X</a>-->
				  <form>
  
    <div class="form-group has-feedback">
      <?php if($TY == 2 )  { ?>
     <h3><a href="../accounts/propettycash"> Back To Petty Cash List (Payable) <i class="fa fa-menu"></i></a></h3>
     <?php } elseif($_GET['all'] == 1) { ?>
       <h3><a href="../accounts/pettycash"> Back To All Approved Cash List <i class="fa fa-menu"></i></a></h3>
     <?php } elseif($_GET['all'] != 1) { ?>
     <h3><a href="../accounts/pettycash"> Back To All Approved Cash List <i class="fa fa-menu"></i></a></h3>
     <?php } ?>
     <?php if($ApprovedChk == 11) { ?>
     <a href="acctapproved?cid=<?php echo $sReqID; ?>"><span style="float:right" class="btn btn-success">Approve For Payment</span></a>
   <?php } ?>
   <?php if($ApprovedChk == 16) { ?>
     <a onclick="POSTPETTY()" ><span style="float:right" class="btn btn-warning">Processing Payment</span></a>
   <?php } ?>

    </div>
   
<script>
function ReadLineItem(elem)
    {
       var hhh = elem.value;
     if (hhh != "")
     {     
    window.location.href ="cashdivppor?pdfid=" + hhh;
    //window.alert("JKJ");
     }
  
    } 
</script>
    <script>
function searchrfq(mou)
{
var searchid = $(mou).val();
var dataString = 'search='+ searchid;
if(searchid!='' && searchid.length >= 4)
{
  $.ajax({
  type: "POST",
  url: "searchRFQ.php",
  data: dataString,
  cache: false,
  success: function(html)
  {
  $("#resultRFQ").html(html).show();
  }
  });
}
if(searchid=='')
{
$("#resultRFQ").html('').hide();
//return false;
}
return false;  

}

function litemsch(rfqv)
{
var uval = $(rfqv).attr('r');
window.location.href = "printQ?sRFQ=" + uval;
}
</script>
      
   </form>
                </div><!-- /.box-header -->
                <div class="box-body">
                 
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        
<div id="PrintArea">
	<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                   <!-- Logo -->
        <a class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="../mBOOT/plant.png" width="50" height="50" /></span>
          <!-- logo for regular state and mobile devices
          <span class="logo-lg"> <img src="../mBOOT/plant.png" style ="width:40px; height:40px;"/></span>-->
        </a>
                  <h3 class="box-title"> <?php echo $_SESSION['CompanyAbbr']; ?>/ACCT/F01 - Cash Request Form </h3>
                   

                 
                
                </div><!-- /.box-header -->
				
            
              <div class="box">
               <div class="box-body">
				<!-- Form Info -->
			  <div class="col-xs-4">
              <table id="CommTab" class="table table-striped">
                
                <tbody>
                    <tr>
                        <td><b>Date:</b> </td>
                        <td><?php echo $ReqDate; ?></td>
                    </tr>
                    <tr>
                        <td><b>Requested by:</b> </td>
                        <td><?php echo $staffName; ?></td>
                    </tr>
					          <tr>
                        <td><b>Department:</b> </td>
                        <td style="text-transformation: uppercase;"><?php echo $StaffDepartment; ?></td>
                    </tr>
                     <tr>
                        <td><b>Status:</b> </td>
                        <td style="font-weight: 700; color:#CC6600"><?php echo $Status; ?></td>
                    </tr>
                    <tr>
                        <td><b>Total Amount:</b> </td>
                        <td style="font-weight: 700; color:#006600"> NGN <?php echo number_format($TAmt); ?></td>
                    </tr>
                    

                </tbody>

              </table>
			  </div>
			   <div class="col-md-6"><br/>
              <span id="bulidlinkn" style="margin-top: 3px; height: auto"><?php echo $buildlink; ?>

              </span>
              <br/>
        </div>
                <div class="table-responsive col-md-12">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
					             <th>Request ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Quantity</th>
                        <th>Related PDF</th>
                        <th>Last Treated By</th>
                        <th>Status</th>
                        <th>-</th>
             
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                   
                  </table>
              </div>

                   <div class="col-xs-6">
              <table id="CommTab1" class="table table-striped">
                <!-- Aproval Comments -->
                   

                    <?php echo setHistory($sReqID); ?>

              

              </table>
        </div>

                  <div style="display:none;float:left;">
                  
                  <br /> <b>Approved By  </b> <br /><br />
                  <b>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:_________________</b><br /><br />
                  <b>Signature :_________________ </b>
                  </div>
                  <div style="display:inline;float:right;">
                  <br /> <b>Printed By <?php echo $Firstname . " " . $SurName; ?></b> <br /><br />
                  <b>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo date("Y-M-d") ?></b><br /><br />
                  <b>Signature :_________________ </b>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- End Print -->
      <div class="row no-print">
            <div class="col-xs-12">
              <button  class="btn btn-default" onclick="printDiv('PrintArea')"><i class="fa fa-print"></i> Print</button>
            <!--  <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Note as Qutoted</button>
              <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Send Mail</button> -->
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

    

      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      
       <div class="row">

              <div class="box box-primary">
                
                
                <!-- Modal form-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog " style="overflow-y: scroll; max-height:80%; width: 80%;  margin-top: 60px; margin-bottom:30px;">
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
    
      <div class="row">

              <div class="box box-primary">
                
                
                <!-- Modal form-->
                <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                  <div class="modal-dialog " style="width:50%">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel1"></h4>
                      </div>
                      <div class="modal-body" id="modal-bodyku1">
                      </div>
                      <div class="modal-footer" id="modal-footerq1">
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
   
	<!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
	
    <script src="../mBOOT/jquery-ui.js"></script>
   <link href="../mBOOT/select2.css" rel="stylesheet">
    <script src="../mBOOT/select2.js"></script>
    <script type="text/javascript">
	 
      $(function () {
	   
        $(".selectn").select2();
        $('#userTab').dataTable({
          "bPaginate": false,
          "bLengthChange": true,
          "bFilter": false,
          "bSort": false,
          "bInfo": false,
          "bAutoWidth": false
        });
      });
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
        
        function setModalBox1(title,content,footer,$size)
        {
            document.getElementById('modal-bodyku1').innerHTML=content;
            document.getElementById('myModalLabel1').innerHTML=title;
            document.getElementById('modal-footerq1').innerHTML=footer;
           
            
                $('#myModal1').attr('class', 'modal fade')
                             .attr('aria-labelledby','myModalLabel1');
                $('.modal-dialog').attr('class','modal-dialog');
           
        }

    </script>
    <script type="text/javascript">
     

      function setMSG()
      {
        $('#ReqMSG').val($('#RecMSG').val());
        var ReqMSG = $('#ReqMSG').val();
        if(ReqMSG == "")
        {
          alert("Kindly fill reason for sending back in the Message Box. Thanks");
          return false;
        }
        $('#sendBKForm').submit();
      }

    </script>
    <script type="text/javascript">
    function POSTPETTY()
     {
        var sReqID = '<?php echo $sReqID ?>';
        var OptGLBank = '<?php echo $OptGLBank ?>'; 
        var GLOpt = '<?php echo $GLOpt ?>';  
        var CurOpt = '<?php echo $CurOpt ?>';  
        var BusOpt = '<?php echo $BusOpt ?>';  
        var RECVOpt = '<?php echo $RECVOpt ?>';  
        var TotalPayableVal = '<?php echo number_format($TAmt) ?>';
        var TotalPayable = '<?php echo $TAmt ?>';
        
          var size='standart';
                  var content = '<form role="form" id="postPetty" action="postPetty" method="POST" >'+
                  '<div class="row">'+
                  '<div class="col-md-12">'+
                     '<div class="form-group col-md-6">'+
                     '<label>Select Bank Account: </label>'+
                     '<select class="form-control" id="BANKGL" name="BANKGL" onChange="setDescription(); loadChk(this);" required >'+ 
                     OptGLBank +
                     '</select>'+
                     '</div>' +

                     '<div class="form-group col-md-6">'+
                     '<label>Cheque/Ref Number: </label>'+
                     //'<input class="form-control" id="ChqNo" name="ChqNo" required >'+ 
                     '<select class="form-control select2" id="ChqNo" >'+
                     '<option> -- </option>'+
                     
                     '</select>'+
                     '</div>' +

                     '<div class="form-group col-md-6">'+
                     '<label>Received By: </label>'+
                     '<select class="form-control" id="RECEIVER" name="RECEIVER" onChange="setDescription();" required >'+ 
                     RECVOpt +
                     '</select>'+
                     '</div>' +

                     '<div class="form-group col-md-6">'+
                     '<label>Total Amount:  </label>'+
                     '<input class="form-control" id="TAMT" name="TAMT" value="'+TotalPayableVal+'" required readonly >'+ 
                    
                     '</div>' +

                     '<div class="form-group col-md-4">'+
                     '<label>Currency: </label>'+
                     '<select class="form-control" id="TCurr" name="TCurr" required >'+ 
                     CurOpt +
                     '</select>'+
                     '</div>' +

                     '<div class="form-group col-md-4">'+
                     '<label>Revenue/Cost Center: </label>'+
                     '<select class="form-control" id="BusUnit" name="BusUnit" required >'+ 
                     BusOpt +
                     '</select>'+
                     '</div>' +

                     '<input type="hidden" id="payerDECV" name="payerDECV" />'+
                     '<input type="hidden" id="receiveDECV" name="receiveDECV" />'+
                     '<input type="hidden" name="TAmt" value="'+TotalPayable+'" />'+
                     '<input type="hidden" name="REQCODE" value="'+sReqID+'" />'+

                     '<div class="form-group col-md-4">'+
                     '<label>Transaction Date: </label>'+
                     '<input type="text" class="form-control datepicker" id="transactiondate" name="transactiondate" placeholder="Click to set date" readonly required  />'+ 
                     '</div>' +

                      '<div class="form-group col-md-12">'+
                     '<label>Remark: </label>'+
                     '<input type="text" class="form-control" id="remark" name="remark" placeholder="Enter remark here" required  />'+ 
                     '</div>' +

                     

                     '<div class="form-group col-md-12">'+
                     '<br/>'+
                     '<table id="EntryChart" class="table table-striped">'+
                     '<thead>'+
                     '<tr><th>Description</th><th>Debit <i onclick="ADDCGL()" class="fa fa-plus text-green"></i> </th><th>Credit</th></tr>'+ 
                     '</thead>'+

                     
                    

                    /*
                     '<tr>'+
                     '<td id="receiveDEC">Description</td>'+
                     
                     '<td id="pDDebit">'+TotalPayableVal+'</td>'+
                     '<td id="pDCredit">0.00</td>'+
                     '</tr>'+ 
                     */
                     
                      '<tbody>'+
                      '<tr>'+
                      '<td id="payerDEC">Description</td>'+
                      '<td id="rDDebit">0.00</td>'+
                      '<td id="rDCredit">'+TotalPayableVal+'</td>'+
                      '</tr>'+
                     
                     '<tr style="border-top: 1px solid #000; border-style: double; border-left: 0px solid; border-right: 0px solid;">'+
                          '<th> &nbsp; </th>'+ 
                          '<th><span id="DBBal">0.0</span></th>'+ 
                          '<th><span id="CRBal">'+TotalPayableVal+'</span></th>'+
                          '</tr>'
                      '</tbody>'+

                     '</table>'+
                    
                     '</div>' +
                  '</div>'+
                  '</div>'+
                                 
                   '</form>';

                  var title = 'Post Cash Request :: ' + sReqID;
                  var footer = '<button type="button" onclick="setToPost();" class="btn btn-success">POST</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
                   $('#transactiondate').datepicker({ dateFormat : 'yy/mm/dd'});
                   var staffID = '<?php echo $staffID ?>';
                   $('#RECEIVER').val(staffID);
                   setDescription();
     }

     function loadChk(elem)
     {
        var BNKID = $(elem).val();
        //alert(BNKID);
        var dataString = {BNKID:BNKID};
        $.ajax({
            type: "POST",
            url: "../accounts/setCHK",
            data: dataString,
            cache: false,
            success: function(html)
            {
                  $('#ChqNo').html(html);
            },
            error: function(a,b,c)
            {
              //alert(c);
            }
          });


     }

     function setToPost()
     {
       var FBAL = getBal();
       var BANKGL = $('#BANKGL').val(); 
       var ChqNo = $('#ChqNo').val(); 
       var RECEIVER = $('#RECEIVER').val(); 
       var BusUnit = $('#BusUnit').val(); 
       var transactiondate = $('#transactiondate').val(); 
       var TCurr = $('#TCurr').val(); 
       var remark = $('#remark').val(); 
       if(BANKGL == "") { alert("Oops! Kindly Select Bank Account"); return false; }
       if(ChqNo == "") { alert("Oops! Kindly Enter Cheque No./Ref No."); return false; }
       if(RECEIVER == "") { alert("Oops! Kindly Select the receiving personnel"); return false; }
       if(BusUnit == "") { alert("Oops! Kindly Select the Business Unit"); return false; }
       if(transactiondate == "") { alert("Oops! Kindly Select the Transaction Date"); return false; }
       if(TCurr == "") { alert("Oops! Kindly Select the Currency"); return false; }
       if(remark == "") { alert("Oops! Kindly enter your remark"); return false; }
       if(FBAL != 0) { alert("Oops! Your Table is not balanced"); return false; }
       $('#postPetty').submit();

     }

     function addCommas(nStr)
      {
          nStr += '';
          x = nStr.split('.');
          x1 = x[0];
          x2 = x.length > 1 ? '.' + x[1] : '';
          var rgx = /(\d+)(\d{3})/;
          while (rgx.test(x1)) {
              x1 = x1.replace(rgx, '$1' + ',' + '$2');
          }
          return x1 + x2;
      }

     function setDescription()
     {
        //var RECVGL = $('#RECVGL').find('option:selected').text() + ' :: ' + $('#RECEIVER').find('option:selected').text();
        var payerDEC = $('#BANKGL').find('option:selected').text();
        $('#payerDEC').html(payerDEC);
        $('#payerDECV').val(payerDEC);
        //$('#receiveDEC').html(RECVGL);
        //$('#receiveDECV').val(RECVGL);
     }
     
     
         function ADDCGL()
     {
        var sReqID = '<?php echo $sReqID ?>';
        var OptGLBank = '<?php echo $OptGLBank ?>'; 
        var GLOpt = '<?php echo $GLOpt ?>';  
        var CurOpt = '<?php echo $CurOpt ?>';  
        var BusOpt = '<?php echo $BusOpt ?>';  
        var RECVOpt = '<?php echo $RECVOpt ?>';  
        var TotalPayableVal = '<?php echo number_format($TAmt) ?>';
        var TotalPayable = '<?php echo $TAmt ?>';
        var GBaL = getBal();
        
          var size='standart';
                  var content = '<form role="form" >'+
                  '<div class="row">'+
                  '<div class="col-md-12">'+
                     '<div class="form-group col-md-6">'+
                     '<label>Debiting GL Account: </label>'+
                     '<select class="form-control" id="DBGL" required >'+ 
                     GLOpt +
                     '</select>'+
                     '</div>' +

                     '<div class="form-group col-md-6">'+
                     '<label>Amount to Debit: </label>'+
                     '<input class="form-control" id="DBNUM" onKeyPress="return isNumber(event)" name="DBNUM" value="'+GBaL+'" required >'+ 
                     '</div>' +

                    

                  

                      '<div class="form-group col-md-2 pull-right">'+
                    
                     '<button type="button" onclick="addBD()" class="btn btn-success form-control">Add</button>'+
                     '</div>' +


                     '<div class="form-group col-md-12">'+
                     '<br/>'+
                   
                    
                     '</div>' +
                  '</div>'+
                  '</div>'+
                                 
                   '</form>';

                  var title = 'Add GL to Debit on Cash Request :: ' + sReqID;
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox1(title,content,footer,size);
                  $('#myModal1').modal('show');
                 
                 
                   
     }
     
     function addBD()
     {

          event.preventDefault();
         var DBGL = $('#DBGL').val();
         var DBGLt = $('#DBGL :selected').text();
         var DBNUM = $('#DBNUM').val();
         //Here we have to chk how qualified the entry is
         var FBALDiff = getBal();
         if(Number(FBALDiff) < Number(DBNUM) )
          { alert('Debit Amount must balance on table'); $('#DBNUM').val(FBALDiff); return false; }

          if( 0 == Number(DBNUM) )
          { alert('Debit Amount must not be zero'); $('#DBNUM').val(FBALDiff); return false; }

          var TRow =   '<tr>'+
                     '<td class="receiveDEC">'+
                     '<input type="hidden" name="DrDesc[]" value="'+DBGLt+'@&@'+DBGL+'@&@'+DBNUM+'" />'+
                     DBGLt+
                     '</td>'+
                     
                     '<td class="pDDebit" amt="'+DBNUM+'">'+addCommas(DBNUM)+'</td>'+
                     '<td>0.00</td>'+
                     '<td><i onclick="$(this).closest(\'tr\').remove(); resetBal();" class="fa fa-trash text-red"></i></td>'+
             '</tr>';
              $('#myModal1').modal('hide');
             $('#EntryChart tbody').prepend(TRow);
             resetBal();

             
             
     }

     function resetBal()
     {
      var TB = 0.0;
       
       $('.pDDebit').each(function() {
            var amt = $(this).attr("amt");
            TB = TB + Number(amt);
            //alert(TB)
        });

       var finalFig = addCommas(TB);
       //alert("God is so Loving");
        $('#DBBal').html(finalFig);
     }

     function getBal()
     {
       var CRBal = Number($('#CRBal').html().replace(',', ''));
       var DBBal = Number($('#DBBal').html().replace(',', ''));

       return CRBal - DBBal;
     }
    </script>
	
  </body>
</html>