<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include ('getApprovals.php');


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
    exit;
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
        $resultUserInfo = mysql_query("SELECT * FROM poreq LEFT JOIN users ON poreq.staffID = users.uid WHERE cashreq.RequestID ='$ReqID'");
        while ($row = mysql_fetch_array($resultUserInfo)) 
        {
             return $UserNNE = $row['Firstname'] . " " . $row['Surname'];
        }
     }

      function getRequestDescription($ReqID)
     {
        $resultUserInfo = mysql_query("SELECT * FROM poreq LEFT JOIN users ON poreq.staffID = users.uid WHERE cashreq.RequestID ='$ReqID'");
        while ($row = mysql_fetch_array($resultUserInfo)) 
        {
             return $ItemDes = substr($row['ItemDes'],0,12)." ...";
        }
     }
///////////////////////////////////////////////////////////////////
$sReqID = $_GET['rNo'];
if ($sReqID != "") 
{
  $result = mysql_query("SELECT * FROM poreq
  
     WHERE RequestID='$sReqID' AND isActive=1");
  //LEFT JOIN divisions ON department.DivID = divisions.divid
} 
else 
{
 //$result = mysql_query("SELECT * FROM poreq WHERE Deparment= '".$DeptIDn."'");
}

$NoRow = mysql_num_rows($result);


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
     $attachment = $row['attachment'];
     $UserApp = getUserinfo($row['UserApp']);
     $UserAppDate = $row['UserAppDate'];
     $UserAppComment = $row['UserAppComment'];
        
        
          $Size = $row['Size'];
     $UOM = $row['UOM'];
     $Type = $row['Type'];
     
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

     $ApprovedBy = $row['ApprovedBy'];//
     $LastActor = $row['LastActor'];//
     $Status = $row['Status'];//
     $Amount = $row['Amount'];
     $Qnt = $row['Qty'];
     $ApprovedChk = $row['Approved'];
     if($Status == "")
     {
       $Status = "Not Submitted";
     }
     else 
     {
      $Status = $Status . " by ". $LastActor;
     }
      
       $ApprovedN = getStatus($Approved);
if($attachment != "") { $attachmentm = '<td><a href="'.$attachment.'" target="_blank"><i class="fa fa-file"></i></a></td>'; }
else { $attachmentm = ''; }

      $Record .='
           <tr>
            <td>'.$ReqID.'</td>
            <td>'.$ReqDate.'</td>
            <td>'.$ItemDes.'</td>
            <td>'.$Purpose.'</td>
            <td>'.$Size.'</td>
            <td>'.$UOM.'</td>
            <td>'.$Type.'</td>
            <td>'.$Qnt.'</td>
            <td>'.$ApprovedBy.'</td>
            <td>'.$Status.'</td>
            '.$attachmentm.'
            

            
            
          
          
           </tr>
           
           
           ';
            
     }

    $sresultDept = mysql_query("SELECT * FROM department WHERE id ='$staffDeptID'"); 
 while ($row = mysql_fetch_array($sresultDept)) {
     //$reqid = $row['reqid'];
       $StaffDepartment = $row['DeptmentName'];
     }

         $sresultDeptN = mysql_query("SELECT * FROM department Order By DeptmentName"); 
 while ($row = mysql_fetch_array($sresultDeptN)) {
     //$reqid = $row['reqid'];
      if($staffDeptID == $row['id']){
       $OptDept .= '<option value="'.$row['id'].'" selected >'.$row['DeptmentName'].'</option>';
      }
      else
      {
       $OptDept .= '<option value="'.$row['id'].'">'.$row['DeptmentName'].'</option>';
      }
     }


        $sresultUsers= mysql_query("SELECT * FROM users Order By Firstname"); 
 while ($row = mysql_fetch_array($sresultUsers)) {
     //$reqid = $row['reqid'];
     

       $OptUsers .= '<option value="'.$row['uid'].'">'.$row['Firstname'].' '.$row['Middlename'].' '.$row['Surname'].'</option>';
      
     }


     $ActorRole .='<option value="0"> Requester </option>';
     $ActorRole .='<option value="1"> Supervisor </option>';
     $ActorRole .='<option value="2"> Head of Department </option>';
     $ActorRole .='<option value="3"> Head of Division </option>';
     $ActorRole .='<option value="4"> GM of Division </option>';
     $ActorRole .='<option value="5"> Contracts & Procurements </option>';
     $ActorRole .='<option value="6"> GM Coporate Service </option>';
     $ActorRole .='<option value="7"> Officer of Due Dilligence </option>';
     $ActorRole .='<option value="8"> GM Due Dilligence </option>';
     $ActorRole .='<option value="9"> MD </option>';
     //$ActorRole .='<option value="11"> GM Finance </option>';

}


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
    <link href="../dist/css/dialog.css" rel="stylesheet" type="text/css" />
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
       <?php if($_GET['all'] == 1) { ?>
      <h3><a href="allmat">Back To All List <i class="fa fa-menu"></i></a></h3>
     <?php } elseif($_GET['all'] == 2) { ?>
      <h3><a href="javascript:window.open('','_self').close();">Close</a></h3>
     <?php } else { ?>
   
      <h3><a href="actedpdf">Back To My List <i class="fa fa-menu"></i></a></h3>
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
                  <h3 class="box-title"> <?php echo $_SESSION['CompanyAbbr']; ?>/ACCT/F01 - Material Request Form </h3>
                   

                 
                
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
                        <td style="text-transformation: uppercase;"><?php echo $StaffDepartment; ?>
                        <?php if($HODID == 1) { ?> 
                          <i class="fa fa-undo text-green" title="Change Department" onclick="changeDept()"></i>
                      <?php } ?>
                       </td>
                    </tr>
                     <tr>
                        <td>
                          <b>Status: &nbsp;
                          <?php if($HODID == 1) { ?> 
                            <i onclick="reroute()" class="fa fa-send text-blue"></i> 
                         <?php } ?>
                         </b>
                        </td>
                        <td style="font-weight: 700; color:#CC6600"><?php echo $Status; ?></td>
                    </tr>
                    

                </tbody>

              </table>
			  </div>
                <div class="table-responsive col-md-12">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
					             <th>Request ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Purpose</th>
                        <th>Size</th>
                        <th>UOM</th>
                        <th>Type</th>
                        <th>Quantity</th>
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

    </script>
    <script type="text/javascript">
      function reroute()
      {
        var sReqID = '<?php echo $sReqID ?>';
        var OptUsers = '<?php echo $OptUsers ?>';
        var ActorRole = '<?php echo $ActorRole ?>';
        var size='standart';
                  var content = '<form role="form" action="updateROUTE" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="'+sReqID+'" id="ReqCode" name="ReqCID"  />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Route To: </label>'+
                   '<select class="form-control"  name="ActorID"  required >'+
                   '<option value="" >--</option>'+
                   OptUsers+
                   '</select>'+
                   '</div>' +

                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>As (Role): </label>'+
                   '<select class="form-control"  name="ActorRole"  required >'+
                   '<option value="" >--</option>'+
                   ActorRole+
                   '</select>'+
                   '</div>' +
                   
                 

                   '<button type="submit" class="btn btn-success pull-right"> Route </button><br/>'+

                   '</form>'
                   ;
                  var title = 'Re-routing this request';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
      }

      function changeDept()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        var OptDept = '<?php echo $OptDept ?>';
        //alert(sReqID);
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="updateDEPT" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="'+sReqID+'" id="ReqCode" name="ReqCID"  />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Select New Department: </label>'+
                   '<select class="form-control"  name="DeptID"  required >'+
                   '<option value="" >--</option>'+
                   OptDept+
                   '</select>'+
                   '</div>' +
                   
                 

                   '<button type="submit" class="btn btn-success pull-right">Apply Change</button><br/>'+

                   '</form>'
                   ;
                  var title = 'Change Originating Department';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

                 //   $('#editClass').val(acctclass);
                   /*$('#editClass option').map(function () {
                      if ($(this).text() == acctclass) return this;
                  }).attr('selected', 'selected');
                  */
                  /* $('#editType option').map(function () {
                      if ($(this).text() == accttype) return this;
                  }).attr('selected', 'selected');*/
                 // $('#EditDueDate').datepicker();
              
      }

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
	
  </body>
</html>