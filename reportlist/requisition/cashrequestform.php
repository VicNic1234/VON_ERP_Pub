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
$MyID = $_SESSION['uid']; 
if($MyID < 1) {
     $_SESSION['ErrMsg'] = "Oops! Timed Out. Kindly Logout and Login Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}
if($MyID == "" || $DeptIDn == "" || $_SESSION['uid'] == "")
{
  header('location: ../');
  exit;
}

////////////////
////////////////////////////////////////////////////////////////////
$resultRFQ1 = mysql_query("SELECT DISTINCT RequestID, Approved FROM cashreq Where staffID='$MyID'");
$NoRowRFQ1 = mysql_num_rows($resultRFQ1);
$sReqID = mysql_real_escape_string(trim(strip_tags($_GET['sReqID'])));
 ///// StaffID = '".$_SESSION['uid']."' AND
if ($sReqID != "") 
{
$result = mysql_query("SELECT * FROM cashreq WHERE RequestID= '".$sReqID."' AND isActive=1");
} 
else 
{
$result = mysql_query("SELECT * FROM cashreq WHERE RequestID= '".$sReqID."' AND isActive=1");
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
     $ReqID = $row['RequestID'];
     $ReqDate = $row['RequestDate'];
    $ReqDept = $row['Deparment']; 
     $ItemDes = $row['ItemDes'];
     $Purpose = $row['Purpose'];
     $relatedPDF = $row['relatedPDF'];
     $attachment = $row['attachment'];
     if($attachment != "") { $attach = '<a href="'.$attachment.'"><i class="fa fa-link"></i></a>'; }

     if($attach != "")
      {
             $Files .= '<span id="fidold-'.$reqid.'" style="padding:12px; border-radius:25px; background:#00CCFF; color:#000"><a style="color:#000" href="'.$row['attachment'].'" target="_blank"><i class="fa fa-link"></i> attachment </a><i fid="'.$reqid.'" ty="old" onclick="rmFile(this);" class="fa fa-trash text-red" title="Click to remove file"></i></span>';
      }
     
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

     $ApprovedBy = $row['ApprovedBy'];//
     $LastActor = $row['LastActor'];//
     $Status = $row['Status'];//
     $Amount = $row['Amount'];
     $Qnt = $row['Qty'];
      if($Qnt < 1)
      { $Qnt = 1; }

     $TAmt = floatval($TAmt) + (floatval($Amount) * $Qnt);
     $Approved = $row['Approved'];
     $ApprovedCHK = $row['Approved'];
     if($Status == "")
     {
       $Status = "Not Submitted";
     }
     else 
     {
      $Status = $Status . " by ". $LastActor;
     }
     $ApprovedN = getStatus($Approved);


    
      $Record .='
           <tr>
            <td>'.$ReqID.'</td>
            <td>'.$ReqDate.'</td>
            <td>'.$ItemDes.'</td>
            <td>'.number_format($Amount).'</td>
            <td>'.$Qnt.'</td>
            <td><a href="mview?rNo='.$relatedPDF.'&all=2" target="_blank">'.$relatedPDF.'</a></td>
            <td>'.$ApprovedBy.'</td>
            <td>'.$ApprovedN.'</td>
            <td>'.$attach.'</td>

            
            
          
          
           </tr>
           
           
           ';
            
     }
}
//////////////////////////////////////

$resultDept = mysql_query("SELECT * FROM department WHERE id ='$ReqDept'");
 while ($row = mysql_fetch_array($resultDept)) {
     //$reqid = $row['reqid'];
       $Department = $row['DeptmentName'];
       $myhod = $row['hod'];
       $HODNME = getUserinfo($myhod);
       $mysupervisor = $row['supervisor'];
       $SupervisorNME = getUserinfo($mysupervisor);

       $myDIVID = $row['DivID'];

     }

$resultDIV = mysql_query("SELECT * FROM divisions WHERE divid ='$myDIVID'");
 while ($row = mysql_fetch_array($resultDIV)) {
     //$reqid = $row['reqid'];
       $DivisonNME = $row['DivisionName'];
       $myGM = $row['GM'];
       $GMNME = getUserinfo($myGM);
       $myHDiv = $row['DH'];
       $HDivNME = getUserinfo($myHDiv); 
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

     function getDeptApprovals($DeptIDn)
     {
        $supervisors = array(); $HDept = array(); $HDiv = array();
       //array_push($a,"blue","yellow");
        $resultUserInfo = mysql_query("SELECT * FROM department WHERE id='$DeptIDn'");
        while ($row = mysql_fetch_array($resultUserInfo)) 
        {
            // return $UserNNE = $row['Firstname'] . " " . $row['Surname'];
       
          if($row['hod'] > 0) { array_push($supervisors, $row['hod']); }
          if($row['supervisor'] > 0) { array_push($HDept, $row['supervisor']); }
          //$UserDiv = 
          //if($row['HDiv'] == 1) { array_push($HDiv, $row['uid']); }
        }

        $Result['Supervisor'] = $supervisors;
        $Result['HDept'] = $HDept;
        $Result['HDiv'] = $HDiv;

        return $Result;
     }

$buildlink = "";
$sql_file=mysql_query("SELECT * FROM filereq WHERE reqcode = '$ReqID' AND isActive=1");
while ($row = mysql_fetch_array($sql_file)) {
       $Files .= '<span  id="fid-'.$row['fid'].'" style="padding:12px; border-radius:25px; background:#00CCFF; color:#000"><a style="color:#000" href="'.$row['fpath'].'" target="_blank"><i class="fa fa-link"></i>'.$row['tile'].' </a><i fid="'.$row['fid'].'" ty="new" onclick="rmFile(this);" class="fa fa-trash text-red" title="Click to remove file"></i></span>';
     }

$buildlink = $Files;

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Print Cash Requisition</title>
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
              <div class="box" style="background: #FFFFCA">
                <div class="box-header with-border">
                  <h3 class="box-title">View Cash Requests</h3>
				   
                  <div class="box-tools pull-right">
                  <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
				  <!--<a style="float:right" href="./"> X</a>-->
				  <form>
   <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px; ">
		    <select class="form-control" id="LIRFQ" name="LIRFQ" onChange="ReadLineItem(this)">
			<option value=""> Choose Cash Request Code</option>
			<?php if ($NoRowRFQ1 > 0) 
						{
							//fetch tha data from the database
							while ($row = mysql_fetch_array($resultRFQ1)) {
            			
                  $ApprovedOpt = $row['Approved'];
                    $ApprovedOpt = getStatus($ApprovedOpt);
							?>
							<option value="<?php echo $row['RequestID']; ?>"  <?php if ($sReqID == $row['RequestID']) { echo "selected";} ?>> <?php echo $row['RequestID']; ?>  [<?php echo $ApprovedOpt; ?>]</option>
							<?php
							}
							
						}
																
			?>
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <div>
       <?php 

        //$Apprs = getDeptApprovals($DeptIDn); 

        if($sReqID != "" AND $ApprovedCHK == 0) 
        { 
          
          //echo($Apprs['Supervisor'][0]); 
          //echo count($Apprs['Supervisor']);
         //echo $MyID ." ".$myGM;
          if($DeptIDn == 11)
          { ?>
               <button class="btn btn-warning pull-right" onclick="sendTOOfficierDD()" type="button"> Send to Officer of Due Dilligence | <i class="fa fa-send"></i></button>
         <?php }
          elseif($DeptIDn == 10)
          { ?>
               <button class="btn btn-warning pull-right" onclick="sendTOOfficierDD()" type="button"> Send to Officer of Due Dilligence | <i class="fa fa-send"></i></button>
         <?php }
          elseif($mysupervisor > 0 && $MyID != $mysupervisor && $MyID != $myhod && $MyID != $myHDiv && $MyID != $myGM ) {
          ?> 
          <button class="btn btn-warning pull-right" onclick="sendTOSupervisor()" type="button"> Send to Supervisor | <i class="fa fa-send"></i></button>
          <?php  } elseif ($myhod > 0 && $MyID != $myhod && $MyID != $myHDiv &&  $MyID != $myGM) { ?>
             <button class="btn btn-warning pull-right" onclick="sendTOHOD()" type="button"> Send to Head of Department | <i class="fa fa-send"></i></button>
         <?php }
         elseif ($myHDiv > 0 && $MyID != $myHDiv && $MyID != $myGM) { ?>
             <button class="btn btn-warning pull-right" onclick="sendTOHDiv()" type="button"> Send to Head of Division | <i class="fa fa-send"></i></button>
          <?php }
           elseif ($myGM > 0 && $MyID == $myGM) { ?>
             <button class="btn btn-warning pull-right" onclick="sendTODD()" type="button"> Send to Head of Due Diligence | <i class="fa fa-send"></i></button>
          <?php }
          elseif ($MyID != $myHDiv) { ?>
            <button class="btn btn-warning pull-right" onclick="sendTOHDiv()" type="button"> Send to Head of Division | <i class="fa fa-send"></i></button>
          <?php  }   

          elseif ($myGM > 0) { ?>
            <button class="btn btn-warning pull-right" onclick="sendTOGM()" type="button"> Send to GM of Division | <i class="fa fa-send"></i></button>
          <?php  }   
        } 
        ?>
      </div>
    </div>
  
<script>
function ReadLineItem(elem)
    {
       var hhh = elem.value;
     if (hhh != "")
     {     
    window.location.href ="cashrequestform?sReqID=" + hhh;
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
                   

                  <a href="cashrequest"><button class="btn btn-success pull-right" type="button"><i class="fa fa-edit"></i> | <i class="fa fa-add"></i> Edit/Add Item to Request</button></a>

                
                </div><!-- /.box-header -->
				
            
              <div class="box">
               <div class="box-body">
				<!-- Form Info -->
			  <div class="col-xs-4">
              <table id="CommTab" class="table table-striped">
                
                <tbody>
                    
                    <tr>
                        <td><b>Requested by:</b> </td>
                        <td><?php echo $staffName; ?></td>
                    </tr>
					          <tr>
                        <td><b>Department:</b> </td>
                        <td><?php echo $Department; ?></td>
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
         <div class="col-xs-4"><br/>
              <span id="buildlink" style="margin-top: 3px;"><?php echo $buildlink; ?>

              </span>
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
                     <?php echo setHistory($ReqID); ?>
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
	
    <script type="text/javascript">
	 
      $(function () {
	   
        //$("#userTab").dataTable();
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

      function sendTOOfficierDD()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
      
        
          var size='standart';
                  var content = '<form role="form" action="cashsendTOOfficierDD" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Cash Request Code: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="RecMSG" name="hodMSG" placeholder=""  value="" required ></div><br/>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/>';

                  var title = 'Send To Officer of Due Dilligence';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
      }

     

      function sendTOSupervisor()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        var SupervisorNME = '<?php echo $SupervisorNME ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="cashsendTOSupervisor" method="POST" ><div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Cash Request Code: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +

                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Your Supervisor: </label><input type="text" class="form-control"   value="'+ SupervisorNME +'"  readonly ></div>' +
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to Supervisor: </label><input type="text" class="form-control" id="eaccCode" name="hodMSG" placeholder=""  value="Kindly help expedite. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/></form>';
                  var title = 'Send To Supervisor';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

               
              
      }
    </script>
    <script type="text/javascript">
      function sendTOHOD()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        var HODNME = '<?php echo $HODNME ?>';
        var ReqDept = '<?php echo $ReqDept ?>';
        
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="cashsendTOHOD" method="POST" ><div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+ 
                   '<input type="hidden" value="" id="ReqDept" name="ReqDept" value="'+ReqDept+'" />'+ 
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Cash Request Code: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Your HOD: </label><input type="text" class="form-control"   value="'+ HODNME +'"  readonly ></div>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to Head of Department: </label><input type="text" class="form-control" id="eaccCode" name="hodMSG" placeholder=""  value="Kindly help expedite. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/></form>';
                  var title = 'Send To Head of Department';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script>
    <script type="text/javascript">
       function sendTODD()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        var GMDD = '<?php echo $GMDD ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="cashsendTODD" method="POST" ><div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Cash Request Code: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Your GM Due Diligence: </label><input type="text" class="form-control"   value="'+ GMDD +'"  readonly ></div>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to GM Due Diligence: </label><input type="text" class="form-control" id="eaccCode" name="hodMSG" placeholder=""  value="Kindly help expedite. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/></form>';
                  var title = 'Send To GM Due Diligence';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }

/*
$myGM = $row['GM'];
       $GMNME = getUserinfo($myGM);
       $myHDiv = $row['DH'];
       $HDivNME = getUserinfo($myHDiv);
*/

function sendTOHDiv()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        var myHDiv = '<?php echo $myHDiv ?>';
        var HDivNME = '<?php echo $HDivNME ?>';
         var ReqDept = '<?php echo $ReqDept ?>';
         
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        //alert(HDivNME);
          var size='standart';
                  var content = '<form role="form" action="cashsendTODivHead" method="POST" ><div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                    '<input type="hidden" value="" id="ReqDept" name="ReqDept" value="'+ReqDept+'" />'+ 
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Cash Request Code: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Your Head of Division: </label><input type="text" class="form-control"   value="'+ HDivNME +'"  readonly ></div>' +


                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to Head of Division: </label><input type="text" class="form-control" id="eaccCode" name="hodMSG" placeholder=""  value="Kindly help expedite. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/></form>';
                  var title = 'Send To Head of Division';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }

      function sendTOGM()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        var myGM = '<?php echo $GMNME ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="cashsendTOGM" method="POST" ><div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Cash Request Code: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Your Head of Division: </label><input type="text" class="form-control"   value="'+ myGM +'"  readonly ></div>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to Head of Division: </label><input type="text" class="form-control" id="eaccCode" name="hodMSG" placeholder=""  value="Kindly help expedite. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/></form>';
                  var title = 'Send To GM of Division';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script>

        <script type="text/javascript">
      function rmFile(elem)
      {
        var fid = $(elem).attr("fid");
        var ty = $(elem).attr("ty");

        var dataString = { fid: fid, ty:ty };
        $.ajax({
              type: "POST",
              url: "deleteFILEC",
              data: dataString,
              cache: false,
              success: function(html)
              {
                //alert(html);
                if(html == "OKNEW")
                {
                    $("#fid-"+fid).hide();
                }

                if(html == "OKOLD")
                {
                    $("#fidold-"+fid).hide();
                }
              }
              });
        
      }
    </script>
  </body>
</html>