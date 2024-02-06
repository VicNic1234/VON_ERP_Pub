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
$HODivID = $_SESSION['uid'];

////////////////////////////////////
$resultDept = mysql_query("SELECT * FROM department WHERE id ='$DeptIDn'");
 while ($row = mysql_fetch_array($resultDept)) {
       //$reqid = $row['reqid'];
       $Department = $row['DeptmentName'];
       $DIVID = $row['DivID'];
       $HODIDn = $row['hod']; 
       $SupervisorT = $row['supervisor']; 
     }

     $HeadOfDiv = "";
//////////////////////////////////////////////////////
 $resultDIV = mysql_query("SELECT * FROM divisions WHERE DH = '$HODivID'"); //WHERE divid ='$DIVID'
 while ($row = mysql_fetch_array($resultDIV)) {
       //$reqid = $row['reqid'];
       $DivisonName = $row['DivisionName'];
       $DH = $row['DH'];
       $HeadOfDiv = $row['Firstname']. " " .$row['Surname'];
     }
  
  if($DH != $HODivID)
{
  echo "Un-authorized access";
  exit;
}  
  //////////////////////////////////////////////////////////////   

$sReqID = mysql_real_escape_string(trim(strip_tags($_GET['pdfid'])));


$resultDept = mysql_query("SELECT * FROM department WHERE id ='$DeptIDn'");
 while ($row = mysql_fetch_array($resultDept)) {
     //$reqid = $row['reqid'];
       $Department = $row['DeptmentName'];
       $MyDivID = $row['DivID'];
     }
/////////////////////////////////////////////////
$resultDivCS = mysql_query("SELECT * FROM divisions LEFT JOIN users ON divisions.GM = users.uid WHERE divisions.divid =1");
 while ($row = mysql_fetch_array($resultDivCS)) {
       $GMCS = $row['GM'];
       $GMCSNme = $row['Firstname'] . " " . $row['Surname']; ;
     }

$resultDivDD = mysql_query("SELECT * FROM divisions LEFT JOIN users ON divisions.GM = users.uid WHERE divisions.divid =3");
 while ($row = mysql_fetch_array($resultDivDD)) {
       $GMDD = $row['GM'];
       $GMDDNme = $row['Firstname'] . " " . $row['Surname']; ;

     }

$resultDiv = mysql_query("SELECT * FROM divisions WHERE divid ='$MyDivID'");
 while ($row = mysql_fetch_array($resultDiv)) {
     //$reqid = $row['reqid'];
       $DivisionName = $row['DivisionName'];
       $GMDiv = $row['GM'];
       //$DivID = $row['DivID'];
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

     include ('getApprovals.php');
///////////////////////////////////////////////////////////////////

$resultRFQ1 = mysql_query("SELECT DISTINCT RequestID, Approved, Deparment FROM poreq 
   LEFT JOIN department ON poreq.Deparment = department.id 
    LEFT JOIN divisions ON department.DivID = divisions.divid 
    WHERE (divisions.divid='".$MyDivID."' AND poreq.isActive=1)   "); //OR (poreq.Approved=6 AND poreq.isActive=1)
//OR (poreq.Approved=6 AND poreq.isActive=1) 
/*
$resultRFQ1 = mysql_query("SELECT DISTINCT RequestID, Approved, Deparment, department.DivID As DivID,
divisions.DivisionName As DivNme FROM poreq 
   LEFT JOIN department ON poreq.Deparment = department.id 
    LEFT JOIN divisions ON department.DivID = divisions.divid 
    WHERE poreq.isActive=1"); */
    $NoRowRFQ1 = mysql_num_rows($resultRFQ1); 
    $REQOPT = "";
if ($NoRowRFQ1 > 0) 
            {
              //fetch tha data from the database
              while ($row = mysql_fetch_array($resultRFQ1)) {
                  
                  $Approved = $row['Approved'];
                  $ReDept =  $row['Deparment']; 
                  $ReDiv =  $row['DivID'];
                  $RequesterNmeM = getRequesterinfo($row['RequestID']);
                  $ItemDes = "***". getRequestDescription($row['RequestID']) . "***";
        $ApprovedOpt = getStatus($Approved);

      $REGT = $row['RequestID'];

                //if($ReDiv == $MyDivID)  
                { 

                  if ($sReqID == $row['RequestID']) { 
                   $REQOPT .= '<option value="'.$REGT.'" selected > '.$REGT.' ::: '.$RequesterNmeM.' ::: ['.$ApprovedOpt.'] '. $ItemDes.'</option>';
                  }
                  else{
                    $REQOPT .= '<option value="'.$REGT.'" >  '.$REGT.' ::: '.$RequesterNmeM.' ::: ['.$ApprovedOpt.'] '. $ItemDes.'</option>';
                  } 

                 }

              }
              
            }

//////////////////////////////////////////////////////////////////////////////////////////
 ///// StaffID = '".$_SESSION['uid']."' AND
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
      $Size = $row['Size'];
     $UOM = $row['UOM'];
     $Type = $row['Type'];
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
      $Size = $row['Size'];
     $UOM = $row['UOM'];
     $Type = $row['Type'];
     $Qnt = $row['Qty'];
      $Approved = $row['Approved']; 

     if($Status == "")
     {
       $Status = "Not Submitted";
     }
     else 
     {
      $Status = $Status . " by ". $LastActor;
     }
      
     $ApprovedN = getStatus($Approved);
      $Detele = ''; $Edit = '';

      if($Approved == 3)
      {
        $Detele = '<i  class="fa fa-trash text-red" rid="'.$reqid.'" onclick="deleteit(this)"></i>';
                $Edit = '<i class="fa fa-edit text-blue" rid="'.$reqid.'" reqid="'.$ReqID.'" onclick="edit(this)" ></i>';
      }
      $Record .='
           <tr id="rid-'.$reqid.'">
            <td>'.$ReqID.'</td>
            <td>'.$ReqDate.'</td>
            <td>'.$ItemDes.'</td>
            <td>'.$Purpose.'</td>
             <td>'.$Size.'</td>
              <td>'.$UOM.'</td>
                <td>'.$Type.'</td>
            <td>'.$Qnt.'</td>
            <td>'.$ApprovedBy.'</td>
            <td>'.$ApprovedN.'</td>
             <td>'.$Edit.'</td>
            <td>'.$Detele.'</td>
           </tr>
           
           
           ';
            
     }

    $sresultDept = mysql_query("SELECT * FROM department WHERE id ='$staffDeptID'"); 
 while ($row = mysql_fetch_array($sresultDept)) {
     //$reqid = $row['reqid'];
       $StaffDepartment = $row['DeptmentName'];
     }


      $buildlink = "";
$sql_file=mysql_query("SELECT * FROM filereq WHERE reqcode = '$ReqID' AND isActive=1");
while ($row = mysql_fetch_array($sql_file)) {
       $Files .= '<span  id="fid-'.$row['fid'].'" style="padding:12px; border-radius:25px; background:#00CCFF; color:#000"><a style="color:#000" href="'.$row['fpath'].'" target="_blank"><i class="fa fa-link"></i>'.$row['tile'].' </a><i fid="'.$row['fid'].'" ty="new" onclick="rmFile(this);" class="fa fa-trash text-red" title="Click to remove file"></i></span>';
     }

$buildlink = $Files;
}

//Unit of Measure

$OptUOM = mysql_query("SELECT * FROM uom ORDER BY UOMAbbr");
$UOMOPT = "";
              //fetch tha data from the database
              while ($row = mysql_fetch_array($OptUOM)) {
              $UOMOPT .= '<option value='.$row['UOMAbbr'].'>'.$row['UOMAbbr'].'</option>';
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
                  <h3 class="box-title">Head of Division <strong>[<?php echo $DivisionName; ?>]</strong> Pending Approval</h3>
				   
                  <div class="box-tools pull-right">
                  <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
				  <!--<a style="float:right" href="./"> X</a>-->
				  <form>
   <div class="form-group has-feedback" style="width:90%; display: inline-block; margin:12px; ">
		    <select class="form-control selectn" id="LIRFQ" name="LIRFQ" onChange="ReadLineItem(this)">
			<option value=""> Choose Requisition code</option>
			<?php echo $REQOPT;	?>
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <?php
             $Apprs = getDeptApprovals($DeptIDn,$HODivID,$Approved);
            
             if($sReqID != "" && $Approved == 3) 
              { 
                
               echo HeadOfDivNextApproval($HODivID, $SupervisorT,  $HODIDn, $DH, $Apprs['CPHOD'], $Apprs['GM'], $Apprs['GMCS'], $Apprs['GMDD']);
               //($MyID, $mySupervisor, $myDeptH, $myDivH, $myCPDeptH, $myGM, $myGMCS, $myGMDD)
               
              }   




        ?>

      <!-- <div>
        <?php if($sReqID != "") {  ?>
          <?php if($GMCS != "") { //$HODID ?> 
       <button class="btn btn-success pull-right" onclick="sendTOGMDD()" type="button"> Send to GM of Due Dilligence | <i class="fa fa-send"></i></button>
     <?php } else { ?>
      
       <button class="btn btn-success pull-right" onclick="sendTOGMCS()" type="button"> Send to GM of Corporate Services | <i class="fa fa-send"></i></button> $DeptIDn
      

       <button class="btn btn-success pull-right" onclick="sendTOCnP()" type="button"> Send to Contacts & Procurements | <i class="fa fa-send"></i></button>

     <?php } ?>
         <button class="btn btn-warning pull-left" onclick="sendBTOHOD()" type="button"> Send back to Head of Department | <i class="fa fa-send"></i></button>
     <?php } ?>
      </div> -->
    </div>
   <script type="text/javascript">
      function sendBTOHOD()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOBHOD" method="POST" ><div class="form-group">' +
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to Head of Department: </label><input type="text" class="form-control" id="eaccCode" name="ReqMSG" placeholder=""  value="Kindly update and submit again. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-info pull-right">Send</button><br/></form>';
                  var title = 'Send Back To Head of Department';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }

     </script>
     
     <script type="text/javascript">
      function sendBTOSupervisor(actor)
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOBSupervisor" method="POST" ><div class="form-group">' +
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                    '<input type="hidden" name="actor" value="'+actor+'" />'+
                    
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to Supervisor: </label><input type="text" class="form-control" id="eaccCode" name="hodMSG" placeholder=""  value="Kindly update and submit again. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-info pull-right">Send</button><br/></form>';
                  var title = 'Send Back To Supervisor';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
     </script>
    <script type="text/javascript">
      //sendTOCnP
      function sendTOCnP()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var GMCSNme = '<?php echo $GMCSNme ?>';
        //var DivisonName = '<?php echo $DivisonName ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOCnPdiv" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                  
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="RecMSG" name="hodMSG" placeholder=""  value="" required ></div><br/>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/>'

                  ;
                  var title = 'Send To Contracts & Procurements';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
      }

       function sendTOGMCS()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        var GMCSNme = '<?php echo $GMCSNme ?>';
        var DivisonName = '<?php echo $DivisonName ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOGMCS" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>GM of CS: </label><input type="text" class="form-control"   value="'+ GMCSNme +'"  readonly ></div>' +
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="RecMSG" name="hodMSG" placeholder=""  value="" required ></div><br/>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/>'

                  ;
                  var title = 'Send To GM of Corporate Services';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
      }
    </script>
<script>
function ReadLineItem(elem)
    {
       var hhh = elem.value;
     if (hhh != "")
     {     
    window.location.href ="divppor?pdfid=" + hhh;
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
                        <th>Purpose</th>
                         <th>Size</th>
                        <th>UOM</th>
                        <th>Type</th>
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
                  <div class="modal-dialog " style="width:70%">
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

              <div class="">
                
                
                <!-- Modal form-->
                <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                  <div class="modal-dialog " style="width:70%">
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
      function sendTOGM()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
       /* var HODID = '<?php echo $HODID ?>';
        var HODNme = '<?php echo $Firstname . " " . $SurName ?>';*/
        var ReqID = '<?php echo $staffID ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOGM" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   '<input type="hidden" name="actor" value="Head of Division" />'+
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="RecMSG" name="hodMSG" placeholder=""  value="" required ></div><br/>' +

                   '<button type="submit" class="btn btn-success pull-right">Send To GM OPTS Head</button><br/>'+

                   '</form>'
                   ;
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

    <script type="text/javascript">
      $('.selectn').select2();
    </script>

     <script type="text/javascript">
      function deleteit(elem)
      {
        
        var rid = $(elem).attr('rid');
        var dataString = { rid: rid };
         $.ajax({
              type: "POST",
              url: "deleteIT",
              data: dataString,
              cache: false,
              success: function(html)
              {
                    $("#rid-"+rid).hide();
              }
              });
      }

      function edit(elem)
      {

        var rid = $(elem).attr('rid');
        var reqid = $(elem).attr('reqid');

        var dataString = { rid: rid };
         $.ajax({
              type: "POST",
              url: "getIT",
              data: dataString,
              cache: false,
              success: function(html)
              {
                  setEDIT();
                    var obj = JSON.parse(html);
                    $('#EditDes').html(obj['ItemDes']); //
                    $('#EditJust').html(obj['Purpose']); //
                    $('#EditQty').val(obj['Qty']); //
                    $('#EditAmt').val(obj['Amount']); //
                     $('#EditSize').val(obj['Size']); //
                      $('#EditType').val(obj['Type']); //
                       $('#EditUOM').val(obj['UOM']); //
                       $('#bulidlink').html(obj['Files']); //
                    $('#LitID').val(rid); //
                    $('#iREQID').val(reqid); //

              }
              });
      }
    </script>
    <script type="text/javascript">
      function setEDIT()
      {
                var UOMOPT = '<?php echo $UOMOPT ?>';

                  var size='standart';
                  var content = '<form role="form" action="updateIT" enctype="multipart/form-data" method="POST" >'+
                   '<div class="row">'+
                   '<div class="col-md-12">'+
                   '<div class="form-group col-md-12">' +
                   '<input type="hidden" value="" id="LitID" name="LitID" />'+ 
                   '<input type="hidden" value="" id="iREQID" name="iREQID" />'+ 
                   '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label><textarea class="form-control" id="EditDes" name="EditDes" placeholder="Description"></textarea></div>' +

                   '<div class="form-group col-md-12" ><label>Justification: </label><textarea class="form-control" id="EditJust" name="EditJust" placeholder="Justification"></textarea></div>' +
                   
                    '<div class="form-group col-md-12"><label>Quantity: </label><input type="text" class="form-control" id="EditQty" name="EditQty" placeholder="Quantity" value="" onKeyPress="return isNumber(event)"  ></div>' +
                   
                   
                    '<div class="form-group has-feedback col-md-3"><label>Size:</label><input type="text" class="form-control" id="EditSize" name="size" placeholder="Size of Item" value=""  /></div>' +
                    
                    '<div class="form-group has-feedback col-md-3"><label>Unit of Measure:</label><select class="form-control" id="EditUOM" name="uom" ><option value="--">--</option>' + UOMOPT + '</select></div>' +
                    
                    '<div class="form-group has-feedback col-md-3"><label>Type:</label> <input type="text" class="form-control" id="EditType" name="type"  placeholder="Type of Item" value=""  /></div>' +
                    /*
                     '<div class="form-group has-feedback col-md-3"><label>Overwrite Attachment:</label> <input type="file" class="form-control" id="EditAttach" name="filed"  /></div>' + */
                      '<div class="form-group has-feedback col-md-3"><label>Add Document (Optional) :</label>'+
        '<span onclick="adddoc()" class="btn btn-info" style="font-size: 17px; color:green" title="Click to Attach File"> Click to Attach File <i class="fa fa-plus"></i> <i class="fa fa-file"></i></span></div>'+

         '<div class="form-group" style="width:100%; display: inline-block; margin: 6px" id="bulidlink"></div>' +
                     '<button type="submit" class="btn btn-primary pull-right">Update</button>'+
                     '</div>'+
                     '</div>'+
                    
                    '</form>';
                  var title = 'Edit Item';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                  

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

                  //$('#AddDueDate').datepicker();
          //return false;
        //alert(LinIT);
              
      }
    </script>

    <script type="text/javascript">
     

        function setModalBox1(title,content,footer,$size)
        {
            document.getElementById('modal-bodyku1').innerHTML=content;
            document.getElementById('myModalLabel1').innerHTML=title;
            document.getElementById('modal-footerq1').innerHTML=footer;
           
            
                $('#myModal1').attr('class', 'modal fade')
                             .attr('aria-labelledby1','myModalLabel1');
                $('.modal-dialog').attr('class','modal-dialog');
           
        }
    </script>

    <script type="text/javascript">
      function adddoc()
      {
        //alert("God of all Graces");
        var LitID = $('#LitID').val();
        var iREQID = $('#iREQID').val();
        
          var size='standart';
                  var content = '<form role="form" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="kLitID" id="kLitID" value="'+LitID+'" required />'+
                   '<input type="hidden" name="kREQID" id="kREQID" value="'+iREQID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Title: </label><input type="text" class="form-control"  name="DocTitle" id="DocTitle" ></div>' +

                   /* '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Link: </label><input type="text" class="form-control"  name="DocLink" ></div> <center> <b>--OR--</b> </center>' +*/

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Upload Document: </label><input type="file" class="form-control"  name="DocFile" id="DocFile" ></div>' +
                   

                   '<button type="button" onclick="attachdoc()" class="btn btn-success pull-right">Add Document</button>'+

                   
                   '<br/></form>';
                  var title = 'New Document Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox1(title,content,footer,size);
                  $('#myModal1').modal('show');

              
      }

      function attachdoc()
      {
        var REQID = $('#kREQID').val();
        
        var property = document.getElementById('DocFile').files[0];
        var form_data = new FormData();
        
        var DocAttach = $('#DocTitle').val();
        
        form_data.append("filed",property);
        form_data.append("reqid",REQID);
        form_data.append("title",DocAttach);
         $.ajax({
          url:'uploadattach.php',
          method:'POST',
          data:form_data,
          contentType:false,
          cache:false,
          processData:false,
          beforeSend:function(){
            ///$('#msg').html('Loading......');
            //alert("happening");
          },
          success:function(data){
            //console.log(data);
            //$('#msg').html(data);
            
            var obj = JSON.parse(data);
            
            if(obj['MSG'] == "OK")
            {
              var F4m = $('#bulidlink').html();
              var bulidlink  = '<span id="fid-'+obj['FID']+'" style="padding:12px; border-radius:25px; background:#00CCFF; color:#000"><a style="color:#000" href="'+obj['URL']+'" target="_blank"><i class="fa fa-link"></i> '+obj['TITLE']+' </a><i fid="'+obj['FID']+'" ty="new" class="fa fa-trash text-red" onclick="rmFile(this);" title="Click to remove file"></i></span>';
              $('#bulidlink').html(F4m + bulidlink);
              $('#bulidlinkn').html(F4m + bulidlink);
              
              $('#myModal1').modal('hide');
            }
            else
            { alert(obj['MSG']); }

          }
        });
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
              url: "deleteFILE",
              data: dataString,
              cache: false,
              success: function(html)
              {
                //alert(fid);
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