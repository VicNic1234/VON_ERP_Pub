<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
$Firstname = $_SESSION['Firstname'];
$SurName = $_SESSION['SurName'];
$Department = "";
$DeptIDn = $_SESSION['DeptID'];
$HODID = $_SESSION['uid'];

/////////////////////////////// 
$resultStaff = mysql_query("SELECT * FROM users where uid='".$HODID."'"); 
/*
$NoRowStaff = mysql_num_rows($resultStaff);;

 if ($NoRowStaff > 0) {
     while($row = mysql_fetch_array($resultStaff)) {
        $DeptID = $row['DeptID']; 
        $HDept = $row['HDept']; 
        $HDiv = $row['HDiv']; 
        $Mgr = $row['Mgr']; 
        $CEO = $row['CEO']; 
       
        }
      }
if($HDept != 1)
{
  echo "Un-authorized access";
  exit;
}*/
//////////////////////////////////////////////////////////////////
$resultDept = mysql_query("SELECT * FROM department WHERE id ='3'"); //$DeptIDn
 while ($row = mysql_fetch_array($resultDept)) {
       //$reqid = $row['reqid'];
       $Department = $row['DeptmentName'];
       $DIVID = $row['DivID'];
       $hodID = $row['hod'];
     }
if($HODID != $hodID)
{
  echo "Un-authorized access";
  exit;
}
     $HeadOfDiv = "";
//////////////////////////////////////////////////////
 /*$resultDept = mysql_query("SELECT * FROM divisions LEFT JOIN users ON divisions.GM = users.uid WHERE divid ='$DIVID'");
 while ($row = mysql_fetch_array($resultDept)) {
       //$reqid = $row['reqid'];
       $DivisonName = $row['DivisionName'];
       $HeadOfDiv = $row['Firstname']. " " .$row['Surname'];
     }
  */  
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
        $resultUserInfo = mysql_query("SELECT * FROM poreq LEFT JOIN users ON poreq.staffID = users.uid WHERE poreq.RequestID ='$ReqID'");
        while ($row = mysql_fetch_array($resultUserInfo)) 
        {
             return $UserNNE = $row['Firstname'] . " " . $row['Surname'];
        }
     }

      function getRequestDescription($ReqID)
     {
        $resultUserInfo = mysql_query("SELECT * FROM poreq LEFT JOIN users ON poreq.staffID = users.uid WHERE poreq.RequestID ='$ReqID'");
        while ($row = mysql_fetch_array($resultUserInfo)) 
        {
             return $ItemDes = substr($row['ItemDes'],0,12)." ...";
        }
     }
///////////////////////////////////////////////////////////////////

$resultRFQ1 = mysql_query("SELECT DISTINCT RequestID, Approved , Deparment FROM poreq WHERE Approved=5 AND isActive=1");
$NoRowRFQ1 = mysql_num_rows($resultRFQ1);
$sReqID = mysql_real_escape_string(trim(strip_tags($_GET['pdfid'])));
 ///// StaffID = '".$_SESSION['uid']."' AND
if ($sReqID != "") 
{
  $result = mysql_query("SELECT * FROM poreq WHERE RequestID='$sReqID' AND isActive=1");
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
     if($attachment != "") { $attach = '<a href="'.$attachment.'"><i class="fa fa-link"></i></a>'; }


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

     $CPApp = getUserinfo($row['CPApp']);
     $CPAppDate = $row['CPAppDate'];
     $CPAppComment = $row['CPAppComment'];

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
           if ($Approved == 0) 
            {
              $ApprovedN = "Raised";
            }
            else if ($Approved == 1)
            {
              $ApprovedN = "Pending with Supervisor of Department";
            }
            else if ($Approved == 2)
            {
              $ApprovedN = "Pending with Head of Department";
            }
            else if ($Approved == 3)
            {
              $ApprovedN = "Pending with Head of Divison";
            }
            else if ($Approved == 4) //Skip for Depts under coporate services
            {
              $ApprovedN = "Pending with your General Manager";
            }
             else if ($Approved == 5) //For only Material Request
            {
              $ApprovedN = "Pending with Contracts and Procurement";
            }

            else if ($Approved == 6) //For only Material Request
            {
              $ApprovedN = "Pending with GM Coporate Service";
            }

             else if ($Approved == 7)
            {
              $ApprovedN = "Pending with Due Diligence Officer";
            }

             else if ($Approved == 8)
            {
              $ApprovedN = "Pending with GM Due Diligence";
            }

             else if ($Approved == 9)
            {
              $ApprovedN = "Pending with MD";
            }
             else if ($Approved == 10) //Only for material request
            {
              $ApprovedN = "Pending with Due Diligence";
            }
            else if ($Approved == 11)
            {
              $ApprovedN = "Pending with Finance";
            }
            else if ($Approved == 12)
            {
              $ApprovedN = "Pending with Internal Audit";
            }
             else if ($Approved == 13)
            {
              $ApprovedN = "Approved";
            }
            else if ($Approved == 14)
            {
              $ApprovedN = "Sent back";
            }
            else if ($Approved == 15)
            {
              $ApprovedN = "Cancelled";
            }
    
    
      $Record .='
           <tr>
            <td>'.$ReqID.'</td>
            <td>'.$ReqDate.'</td>
            <td>'.$ItemDes.'</td>
            <td>'.$Purpose.'</td>
            <td>'.$Amount.'</td>
            <td>'.$Qnt.'</td>
            <td>'.$ApprovedBy.'</td>
            <td>'.$ApprovedN.'</td>
            <td>'.$attach.'</td>
           </tr>
           
           
           ';
            
     }

    $sresultDept = mysql_query("SELECT * FROM department WHERE id ='$staffDeptID'"); 
 while ($row = mysql_fetch_array($sresultDept)) {
     //$reqid = $row['reqid'];
       $StaffDepartment = $row['DeptmentName'];
       $REQDIVID = $row['DivID'];
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
                  <h3 class="box-title"><a href="./"><i style="font-size:24px" class="fa fa-home"></i></a> <!--Head of Department <strong>[<?php echo $Department; ?>]</strong> Pending Approval</h3>-->
				   
                  <div class="box-tools pull-right">
                  <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
				  <!--<a style="float:right" href="./"> X</a>-->
				  <form>

            <?php if ($NoRowRFQ1 > 0) 
            {
              //fetch tha data from the database
              while ($row = mysql_fetch_array($resultRFQ1)) {
                  
                  $Approved = $row['Approved'];
                  $ReDept =  $row['Deparment'];
                  $RequesterNmeM = getRequesterinfo($row['RequestID']);
                  $ItemDes = "***". getRequestDescription($row['RequestID']) . "***";
                          if ($Approved == 0) 
            {
              $ApprovedN = "Raised";
            }
            else if ($Approved == 1)
            {
              $ApprovedN = "Pending with Supervisor of Department";
            }
            else if ($Approved == 2)
            {
              $ApprovedN = "Pending with Head of Department";
            }
            else if ($Approved == 3)
            {
              $ApprovedN = "Pending with Head of Divison";
            }
            else if ($Approved == 4) //Skip for Depts under coporate services
            {
              $ApprovedN = "Pending with your General Manager";
            }
             else if ($Approved == 5) //For only Material Request
            {
              $ApprovedN = "Pending with Contracts and Procurement";
            }

            else if ($Approved == 6) //For only Material Request
            {
              $ApprovedN = "Pending with GM Coporate Service";
            }

             else if ($Approved == 7)
            {
              $ApprovedN = "Pending with Due Diligence Officer";
            }

             else if ($Approved == 8)
            {
              $ApprovedN = "Pending with GM Due Diligence";
            }

             else if ($Approved == 9)
            {
              $ApprovedN = "Pending with MD";
            }
             else if ($Approved == 10) //Only for material request
            {
              $ApprovedN = "Pending with Due Diligence";
            }
            else if ($Approved == 11)
            {
              $ApprovedN = "Pending with Finance";
            }
            else if ($Approved == 12)
            {
              $ApprovedN = "Pending with Internal Audit";
            }
             else if ($Approved == 13)
            {
              $ApprovedN = "Approved";
            }
            else if ($Approved == 14)
            {
              $ApprovedN = "Sent back";
            }
            else if ($Approved == 15)
            {
              $ApprovedN = "Cancelled";
            }
      

               $REGT = $row['RequestID'];
                if ($sReqID == $row['RequestID']) { 
                  echo $REQOPT = '<option value="'.$REGT.'" selected > '.$REGT.' ::: '.$RequesterNmeM.' ::: ['.$ApprovedN.'] '. $ItemDes.'</option>';
                  }
                  else{
                  echo  $REQOPT = '<option value="'.$REGT.'" >  '.$REGT.' ::: '.$RequesterNmeM.' ::: ['.$ApprovedN.'] '. $ItemDes.'</option>';
                  } 

              }
              
            }
                                
      ?>
   <!--<div class="form-group has-feedback" style="width:90%; display: inline-block; margin:12px; ">
		    <select class="form-control selectn" id="LIRFQ" name="LIRFQ" onChange="ReadLineItem(this)">
			<option value=""> Choose Requisition code</option>
			
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
    </div>-->
    <div class="form-group has-feedback">
      <div>
      <?php if($Approved == 5) { ?>
       <button class="btn btn-success pull-right" onclick="sendTODivHead()" type="button"> Send to GM Corporate Services | <i class="fa fa-send"></i></button>
   
       <!--<?php if($REQDIVID != 1) { ?>
         <button class="btn btn-info pull-left" onclick="sendBTORHODiv()" type="button"> Send back to Requester's Head of Division | <i class="fa fa-send"></i></button>
       <?php } else { ?>
        <button class="btn btn-warning pull-left" onclick="sendBTORHOD()" type="button"> Send back to Requester's Head of Department | <i class="fa fa-send"></i></button>-->
       
     <?php
          }
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
    window.location.href ="hodppor?pdfid=" + hhh;
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
                  <h3 class="box-title"> <?php echo $_SESSION['CompanyAbbr']; ?>/C&P/F01 - Procurement Definition Form </h3>
                   

                 
                
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
                        <th>Amount</th>
                        <th>Quantity</th>
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
                    <tbody>
                   <?php if($UserApp != "") { ?>
                    <tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>Requested by:</b> </td>
                        <td><?php echo $UserApp; ?></td>
                    </tr>
                    <tr>
                        <td><b>Submitted On:</b> </td>
                        <td><?php echo $UserAppDate; ?></td>
                    </tr>
                     <tr>
                        <td><b>Requester's Comment:</b> </td>
                        <td><?php echo $UserAppComment; ?></td>
                    </tr>
                  <?php } ?>
                   <?php if($SupervisorApp != "") { ?>
                    <tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>Supervisor of Department:</b> </td>
                        <td><?php echo $SupervisorApp; ?></td>
                    </tr>
                     <tr>
                        <td><b>Supervisor of Department Acted On:</b> </td>
                        <td><?php echo $SupervisorAppDate; ?></td>
                    </tr>
                    <tr>
                        <td><b>Supervisor of Department's Comment:</b> </td>
                        <td><?php echo $SupervisorAppComment; ?></td>
                    </tr>
                  <?php } ?>
                    <?php if($DeptHeadApp != "") { ?>
                    <tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>Head of Department:</b> </td>
                        <td><?php echo $DeptHeadApp; ?></td>
                    </tr>
                     <tr>
                        <td><b>Head of Department Acted On:</b> </td>
                        <td><?php echo $DeptHeadAppDate; ?></td>
                    </tr>
                    <tr>
                        <td><b>Head of Department's Comment:</b> </td>
                        <td><?php echo $DeptHeadAppComment; ?></td>
                    </tr>
                  <?php } ?>

                   <?php if($DivHeadApp != "") { ?> 
                    <tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>Head of Division:</b> </td>
                        <td><?php echo $DivHeadApp; ?></td>
                    </tr>
                     <tr>
                        <td><b>Head of Division Acted On:</b> </td>
                        <td><?php echo $DivHeadAppDate; ?></td>
                    </tr>
                    <tr>
                        <td><b>Head of Division's Comment:</b> </td>
                        <td><?php echo $DivHeadAppComment; ?></td>
                    </tr>
                  <?php } ?>


                   <?php if($CPApp != "") { ?> 
                    <tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>Contracts & Procurement:</b> </td>
                        <td><?php echo $CPApp; ?></td>
                    </tr>
                     <tr>
                        <td><b>Contracts & Procurement Acted On:</b> </td>
                        <td><?php echo $CPAppDate; ?></td>
                    </tr>
                    <tr>
                        <td><b>Contracts & Procurement's Comment:</b> </td>
                        <td><?php echo $CPAppComment; ?></td>
                    </tr>
                  <?php } ?>
                    


                     <?php if($MgrApp != "") { ?>
                    <tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>GM of Coporate Service:</b> </td>
                        <td><?php echo $MgrApp; ?></td>
                    </tr>
                     <tr>
                        <td><b>GM of Coporate Service Acted On:</b> </td>
                        <td><?php echo $MgrAppDate; ?></td>
                    </tr>
                    <tr>
                        <td><b>GM of Coporate Service's Comment:</b> </td>
                        <td><?php echo $MgrAppComment; ?></td>
                    </tr>

                    <?php } ?>


                    <?php if($DDApp != "") { ?>
                    <tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>GM of Due Dilligence:</b> </td>
                        <td><?php echo $DDApp; ?></td>
                    </tr>
                     <tr>
                        <td><b>GM of Due Dilligence Acted On:</b> </td>
                        <td><?php echo $DDAppDate; ?></td>
                    </tr>
                    <tr>
                        <td><b>GM of Due Dilligence's Comment:</b> </td>
                        <td><?php echo $DDAppComment; ?></td>
                    </tr>

                    <?php } ?>

                     <?php if($MDApp != "") { ?>
                    <tr><td colspan="2" style="background: #00CC99"></td></tr>
                    <tr>
                        <td><b>MD:</b> </td>
                        <td><?php echo $MDApp; ?></td>
                    </tr>
                     <tr>
                        <td><b>MD Acted On:</b> </td>
                        <td><?php echo $MDAppDate; ?></td>
                    </tr>
                    <tr>
                        <td><b>MD's Comment:</b> </td>
                        <td><?php echo $MDAppComment; ?></td>
                    </tr>

                    <?php } ?>

                </tbody>
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
      function sendBTORHOD()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOBRHOD" method="POST" ><div class="form-group">' +
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="eaccCode" name="ReqMSG" placeholder=""  value="Kindly update and submit again. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/></form>';
                  var title = 'Send Back To Requester\'s Head of Department';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }


      function sendBTORHODiv()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOBRHODiv" method="POST" ><div class="form-group">' +
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="eaccCode" name="ReqMSG" placeholder=""  value="Kindly update and submit again. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/></form>';
                  var title = 'Send Back To Requester\'s Head of Division';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script> 
      <script type="text/javascript">
      function sendBTOSupervisor()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOBSupervisor" method="POST" ><div class="form-group">' +
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to Supervisor: </label><input type="text" class="form-control" id="eaccCode" name="hodMSG" placeholder=""  value="Kindly update and submit again. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-info pull-right">Send</button><br/></form>';
                  var title = 'Send Back To Supervisor';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script> 
    <script type="text/javascript">
      function sendTODivHead()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        var HeadOfDiv = '<?php echo $HeadOfDiv ?>';
        var DivisonName = '<?php echo $DivisonName ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOGMCS" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Name of Division: </label><input type="text" class="form-control"   value="'+ DivisonName +'"  readonly ></div>' +
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Head of Division: </label><input type="text" class="form-control"   value="'+ HeadOfDiv +'"  readonly ></div>' +
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="RecMSG" name="ReqMSG" placeholder=""  value="" required ></div><br/>' +

                   '<button type="submit" class="btn btn-success pull-right">Send To GM Corporate Services</button><br/>'

                  ;
                  var title = 'Send To GM Corporate Services';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
              
      }


        function sendTOCnP()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var HeadOfDiv = '<?php echo $HeadOfDiv ?>';
        //var DivisonName = '<?php echo $DivisonName ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOCnP" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="RecMSG" name="ReqMSG" placeholder=""  value="" required ></div><br/>' +

                   '<button type="submit" class="btn btn-success pull-right">Send To Contract & Procurement</button><br/>'

                  ;
                  var title = 'Send To Head of Contract & Procurement';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
              
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