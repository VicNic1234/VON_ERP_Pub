<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
//include ('getApprovalsCASH.php');


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
         $sresultUsers= mysql_query("SELECT * FROM users Order By Firstname"); 
 while ($row = mysql_fetch_array($sresultUsers)) {
     //$reqid = $row['reqid'];
     

       $OptUsers .= '<option value="'.$row['uid'].'">'.$row['Firstname'].' '.$row['Middlename'].' '.$row['Surname'].'</option>';
      
     }
     
     $ActorRole .='<option value="0"> Requester </option>';
     $ActorRole .='<option value="1"> Head of Department </option>';
     $ActorRole .='<option value="2"> Head of Division </option>';
     $ActorRole .='<option value="3"> GM of Division </option>';
     $ActorRole .='<option value="4"> GM Coporate Service </option>';
     $ActorRole .='<option value="5"> Human Resources Mgr </option>';
     $ActorRole .='<option value="9"> COO </option>';
      $ActorRole .='<option value="6"> MD </option>';
    
///////////////////////////////////////////////////////////////////
$sReqID = $_GET['rNo'];
if ($sReqID != "") 
{
  $result = mysql_query("SELECT * FROM empleave
    LEFT JOIN users ON empleave.uid = users.uid
    LEFT JOIN department ON empleave.Dept = department.id
     WHERE empleave.id='$sReqID' AND users.isActive=1");
  //LEFT JOIN divisions ON department.DivID = divisions.divid
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
     $reqid = $row['id'];
     $staffName = $row['Firstname'] . " " . $row['Middlename'] . " " . $row['Surname'];//$row['staffName'];
     $staffID = $row['staffID'];
     $StaffDepartment = $row['DeptmentName'];
     $leaveType = $row['leaveType'];
     $ReqDate = $row['CreatedOn'];
      $StartDay = $row['StartDate'];
     $EndDay = $row['EndDate'];
     $NoOfDays = $row['NumberofDays'];
     $Note = $row['Note'];
     
    $leaveType = $row['leaveType'];
    $leaveDaysApproved = $row['leaveDaysApproved'];
    $NumberofDays = $row['NumberofDays'];
    
    
     $UserApp = getUserinfo($row['UserApp']);
     $UserAppDate = $row['UserAppDate'];
     $UserAppComment = $row['UserAppComment'];

     $SupervisorApp = getUserinfo($row['SupervisorApp']);
     $SupervisorAppDate = $row['SupervisorAppDate'];
     $SupervisorAppComment = $row['SupervisorComment'];

     $DeptHeadApp = getUserinfo($row['HODApp']);
     $DeptHeadAppDate = $row['HODAppDate'];
     $DeptHeadAppComment = $row['HODAppComment'];

     $DivHeadApp = getUserinfo($row['DivHApp']);
     $DivHeadAppDate = $row['DivHAppDate'];
     $DivHeadAppComment = $row['DivHAppComment'];

     $MgrApp = getUserinfo($row['GMApp']);
     $MgrAppDate = $row['GMAppDate'];
     $MgrAppComment = $row['GMAppComment'];

     $GMCSApp = getUserinfo($row['GMCSApp']);
     $GMCSAppDate = $row['GMCSAppDate'];
     $GMCSAppComment = $row['GMCSAppComment'];
     
     $HRApp = getUserinfo($row['HRApp']);
     $HRAppDate = $row['HRAppDate'];
     $HRAppComment = $row['HRAppComment'];

     $MDApp = getUserinfo($row['MDApp']);
     $MDAppDate = $row['MDAppDate'];
     $MDAppComment = $row['MDComment'];

     $ApprovedBy = $row['ApprovedBy'];//
     $LastActor = $row['LastActor'];//
     $Approved = $row['Status'];//
     if ($Approved == 0) { 
         $Approved = "Not Submitted Yet";
     }
         else if ($Approved == 1)
      {
        $Approved = "Pending with Head of Dept";
      }
      else if ($Approved == 2)
      {
        $Approved = "Pending with Head of Division";
      }
      else if ($Approved == 3)
      {
        $Approved = "Pending with GM of Division";
      }
      else if ($Approved == 4)
      {
        $Approved = "Pending with GM of CS";
      }
      else if ($Approved == 5)
      {
        $Approved = "Pending with HR";
      }
      else if ($Approved == 6)
      {
        $Approved = "Pending in MD's Office";
      }
      else if($Approved == 7)
      {
        $Approved = "Approved";
      }
      else if($Approved == 8)
      {
        $Approved = "Cancelled";
      }
      

   $Record .='
					 <tr>
            <td>'.$ReqDate.'</td>
					  <td>'.$leaveType.'</td>
						<td>'.$Note.'</td>
            <td>'.$StartDay.'</td>
						<td>'.$EndDay.'</td>
            <td>'.$NoOfDays.'</td>
            <td>'.$Approved.'</td>
           
					 </tr>
					 
					 
					 ';
            
     }

   
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
     .rcorners1 {
    border-radius: 25px;
    background: #73AD21;
    padding: 20px; 
    width: 90%;
    height: auto; 
    } 
    </style>
 
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
      
     <h3><a href="javascript:window.open('','_self').close();">Close</a></h3>
    
    </div>
   

   
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
                  <h3 class="box-title"> <?php echo $_SESSION['CompanyAbbr']; ?>/HR/F01 - Leave Request Form </h3>
                   

                 
                
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
                        <td><b>Status:</b> &nbsp;
                          <?php if($HODID == 1) { ?> 
                            <i onclick="reroute()" class="fa fa-send text-blue"></i> 
                         <?php } ?> </td>
                        <td style="font-weight: 700; color:#CC6600"><?php echo $Approved; ?></td>
                    </tr>
                    

                </tbody>

              </table>
			  </div>
                <div class="table-responsive col-md-12">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Applied on</th>
                        <th>Leave Type</th>
                        <th>Purpose</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>No. of Days</th>
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
                   <!-- 
                   $UserApp = getUserinfo($row['UserApp']);
     $UserAppDate = $row['UserAppDate'];
     $UserAppComment = $row['UserAppComment'];

     $SupervisorApp = getUserinfo($row['SupervisorApp']);
     $SupervisorAppDate = $row['SupervisorAppDate'];
     $SupervisorAppComment = $row['SupervisorComment'];

     $DeptHeadApp = getUserinfo($row['HODApp']);
     $DeptHeadAppDate = $row['HODAppDate'];
     $DeptHeadAppComment = $row['HODAppComment'];

     $DivHeadApp = getUserinfo($row['DivHApp']);
     $DivHeadAppDate = $row['DivHAppDate'];
     $DivHeadAppComment = $row['DivHAppComment'];

     $MgrApp = getUserinfo($row['GMApp']);
     $MgrAppDate = $row['GMAppDate'];
     $MgrAppComment = $row['GMAppComment'];

     $GMCSApp = getUserinfo($row['GMCSApp']);
     $GMCSAppDate = $row['GMCSAppDate'];
     $GMCSAppComment = $row['GMCSAppComment'];
     
     $HRApp = getUserinfo($row['HRApp']);
     $HRAppDate = $row['HRAppDate'];
     $HRAppComment = $row['HRAppComment'];

     $MDApp = getUserinfo($row['MDApp']);
     $MDAppDate = $row['MDAppDate'];
     $MDAppComment = $row['MDComment'];
     -->

                    <?php 
                    
                    $reqHistory .=	'<tbody>';

                   if($UserApp != "") { 
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>Requested by:</b> </td>
                        <td>'.$UserApp.'</td>
                    </tr>
                    <tr>
                        <td><b>Submitted On:</b> </td>
                        <td>'.$UserAppDate.'</td>
                    </tr>
                     <tr>
                        <td><b>Requester\'s Comment:</b> </td>
                        <td>'.$UserAppComment.'</td>
                    </tr>';
                   }
                 
                   if($SupervisorApp != "") { 
                    $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>Supervisor of Department:</b> </td>
                        <td>'.$SupervisorApp.'</td>
                    </tr>
                     <tr>
                        <td><b>Supervisor of Department Acted On:</b> </td>
                        <td>'.$SupervisorAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Supervisor of Department\'s Comment:</b> </td>
                        <td>'.$SupervisorAppComment.'</td>
                    </tr>';
                }
                  
                  if($DeptHeadApp != "") { 
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>Head of Department:</b> </td>
                        <td>'.$DeptHeadApp.'</td>
                    </tr>
                     <tr>
                        <td><b>Head of Department Acted On:</b> </td>
                        <td>'.$DeptHeadAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Head of Department\'s Comment:</b> </td>
                        <td>'.$DeptHeadAppComment.'</td>
                    </tr>';
                 }
                 if($DivHeadApp != "") {  
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>Head of Division:</b> </td>
                        <td>'.$DivHeadApp.'</td>
                    </tr>
                     <tr>
                        <td><b>Head of Division Acted On:</b> </td>
                        <td>'.$DivHeadAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Head of Division\'s Comment:</b> </td>
                        <td>'.$DivHeadAppComment.'</td>
                    </tr> ';
                 
                }

                   if($CPApp != "") {  
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>Contracts & Procurement:</b> </td>
                        <td>'.$CPApp.'</td>
                    </tr>
                     <tr>
                        <td><b>Contracts & Procurement Acted On:</b> </td>
                        <td>'.$CPAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Contracts & Procurement\'s Comment:</b> </td>
                        <td>'.$CPAppComment.'</td>
                    </tr>';
                }

                if($CSApp != "") {  
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>GM Coporate Services:</b> </td>
                        <td>'.$CSApp.'</td>
                    </tr>
                     <tr>
                        <td><b>GM Coporate Services Acted On:</b> </td>
                        <td>'.$CSAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>GM Coporate Services\'s Comment:</b> </td>
                        <td>'.$CSAppComment.'</td>
                    </tr>';
                }
                 
                 if($MgrApp != "") { 
                    $reqHistory .='<tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>GM of Division:</b> </td>
                        <td>'.$MgrApp.'</td>
                    </tr>
                     <tr>
                        <td><b>GM of Division Acted On:</b> </td>
                        <td>'.$MgrAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>GM of Division\'s Comment:</b> </td>
                        <td>'.$MgrAppComment.'</td>
                    </tr>';
                }
                	if($DDOfficerApp != "") { 
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>Due Dilligence Officer:</b> </td>
                        <td>'.$DDOfficerApp.'</td>
                    </tr>
                     <tr>
                        <td><b>Due Dilligence Officer Acted On:</b> </td>
                        <td>'.$DDOfficerAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Due Dilligence Officer\'s Comment:</b> </td>
                        <td>'.$DDOfficerAppComment.'</td>
                    </tr>';
                }
                
                	if($HRApp != "") { 
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>HR:</b> </td>
                        <td>'.$HRApp.'</td>
                    </tr>
                     <tr>
                        <td><b>HR Acted On:</b> </td>
                        <td>'.$HRAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>HR\'s Comment:</b> </td>
                        <td>'.$HRAppComment.'</td>
                    </tr>';
                }
                
                
                	if($GMCSApp != "") { 
                  /* $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>GM CS:</b> </td>
                        <td>'.$GMCSApp.'</td>
                    </tr>
                     <tr>
                        <td><b>GM CS Acted On:</b> </td>
                        <td>'.$GMCSAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>GM CS\'s Comment:</b> </td>
                        <td>'.$GMCSAppComment.'</td>
                    </tr>';*/
                     $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>COO:</b> </td>
                        <td>'.$GMCSApp.'</td>
                    </tr>
                     <tr>
                        <td><b>COO Acted On:</b> </td>
                        <td>'.$GMCSAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>COO\'s Comment:</b> </td>
                        <td>'.$GMCSAppComment.'</td>
                    </tr>';
                }
                
                

                   if($DDApp != "") { 
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>GM of Due Dilligence:</b> </td>
                        <td>'.$DDApp.'</td>
                    </tr>
                     <tr>
                        <td><b>GM of Due Dilligence Acted On:</b> </td>
                        <td>'.$DDAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>GM of Due Dilligence\'s Comment:</b> </td>
                        <td>'.$DDAppComment.'</td>
                    </tr>';
                }

                    if($MDApp != "") { 
                    $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>
                    <tr>
                        <td><b>MD:</b> </td>
                        <td>'.$MDApp.'</td>
                    </tr>
                     <tr>
                        <td><b>MD Acted On:</b> </td>
                        <td>'.$MDAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>MD\'s Comment:</b> </td>
                        <td>'.$MDAppComment.'</td>
                    </tr>';
                }

                   

                $reqHistory .= '</tbody>';

                echo $reqHistory;
                    
                    ?>

              

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
    <script>
        function reroute()
      {
        var sReqID = '<?php echo $sReqID ?>';
        var OptUsers = '<?php echo $OptUsers ?>';
        var ActorRole = '<?php echo $ActorRole ?>';
        var size='standart';
                  var content = '<form role="form" action="updateROUTE" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="'+sReqID+'" id="ReqCode" name="ReqCID"  />'+
                   /*'<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Route To: </label>'+
                   '<select class="form-control"  name="ActorID"  required >'+
                   '<option value="" >--</option>'+
                   OptUsers+
                   '</select>'+
                   '</div>' +*/

                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>To (Role): </label>'+
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
    </script>
    <script type="text/javascript">
      function sendTODivHead()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        var HODID = '<?php echo $HODID ?>';
        var HODNme = '<?php echo $Firstname . " " . $SurName ?>';
        var ReqID = '<?php echo $staffID ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOGM" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Cash Request Code: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="RecMSG" name="hodMSG" placeholder=""  value="" required ></div><br/>' +

                   '<button type="submit" class="btn btn-success pull-right">Send To GM OPTS Head</button><br/>'+

                   '</form>' +
                   '<form id="sendBKForm" role="form" action="cashsendTOBHOD" method="POST" >'+
                   '<input type="hidden" id="ReqMSG" name="ReqMSG" value="" required >'+
                   '<input type="hidden"  name="HODID" value="'+HODID+'" >'+
                   '<input type="hidden"  name="ReqID" value="'+ReqID+'" >'+
                   '<input type="hidden"  name="HODNme" value="'+HODNme+'" >'+
                   '<input type="hidden" class="form-control"  name="ReqCode" value="'+ sReqID +'">'+
                   '<button type="button" onclick="setMSG()" class="btn btn-warning pull-left">Send Back To Head of Department </button><br/>'+
                   '</form>';
                  var title = 'Act As Head of Division';
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