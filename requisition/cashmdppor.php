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
$myGMID = $_SESSION['uid'];
if($myGMID < 1) {
     $_SESSION['ErrMsg'] = "Oops! Timed Out. Kindly Logout and Login Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit;
}

$resultStaff = mysql_query("SELECT * FROM users where uid='".$myGMID."'"); 

$NoRowStaff = mysql_num_rows($resultStaff);

 if ($NoRowStaff > 0) {
     while($row = mysql_fetch_array($resultStaff)) {
        $DeptID = $row['DeptID']; 
        $HDept = $row['HDept']; 
        $HDiv = $row['HDiv']; 
        $Mgr = $row['Mgr']; 
        $CEO = $row['CEO']; 
       
        }
      }
if($CEO != 1)
{
  echo "Un-authorized access";
  exit;
}
////////////////////////////////////
$resultDivDD = mysql_query("SELECT * FROM users WHERE COO =1");
 while ($row = mysql_fetch_array($resultDivDD)) {
       $GMDD = $row['uid'];
       $GMDDNme = $row['Firstname'] . " " . $row['Surname']; ;

     }
  //////////////////////////////////////////////////////////////   

$sReqID = mysql_real_escape_string(trim(strip_tags($_GET['pdfid'])));

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

$resultRFQ1 = mysql_query("SELECT DISTINCT RequestID, Approved, Deparment FROM cashreq 
   WHERE Approved=9 AND isActive=1");
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
  $result = mysql_query("SELECT * FROM cashreq
  WHERE RequestID='$sReqID' AND isActive=1");
  //LEFT JOIN divisions ON department.DivID = divisions.divid
} 
else 
{
 //$result = mysql_query("SELECT * FROM cashreq WHERE Deparment= '".$DeptIDn."'");
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
     $RelatedPDF = $row['relatedPDF'];
     $Curr = $row['Curr'];
/*
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

     */

     $ApprovedBy = $row['ApprovedBy'];//
     $LastActor = $row['LastActor'];//
     $Status = $row['Status'];//
     $Amount = $row['Amount'];
     $Qnt = $row['Qty'];
     $Qnt = $row['Qty'];
     if($Qnt < 1)
      { $Qnt = 1; }

     $TAmt = floatval($TAmt) + (floatval($Amount) * $Qnt);
     $ApprovedChk = $row['Approved'];
     $attachment = $row['attachment'];
     $attachment = $row['attachment'];
     if($attachment != "") { $attach = '<a href="'.$attachment.'"><i class="fa fa-link"></i></a>'; }
     
      if($attach != "")
      {
             $Files .= '<span id="fidold-'.$reqid.'" style="padding:12px; border-radius:25px; background:#00CCFF; color:#000"><a style="color:#000" href="'.$row['attachment'].'" target="_blank"><i class="fa fa-link"></i> attachment </a><i fid="'.$reqid.'" ty="old" onclick="rmFile(this);" class="fa fa-trash text-red" title="Click to remove file"></i></span>';
      }
     

     if($Status == "")
     {
       $Status = "Not Submitted";
     }
     else 
     {
      $Status = $Status . " by ". $LastActor;
     }
     $ApprovedN = getStatus($ApprovedChk);

      $Record .='
           <tr>
            <td>'.$ReqID.'</td>
            <td>'.$ReqDate.'</td>
            <td>'.$ItemDes.'</td>
            <td>'.$Curr.'</td>
            <td>'.number_format($Amount).'</td>
            <td>'.$Qnt.'</td>
            <td><a href="mview?rNo='.$RelatedPDF.'&all=2" target="_blank">'.$RelatedPDF.'</a></td>
            <td>'.$ApprovedBy.'</td>
            <td>'.$ApprovedN.'</td>

            
            
          
          
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


	 <script>
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
    }
    
    function addCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
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
                 <h3 class="box-title"> <strong>MD's Office</strong> Cash Request Pending Approval</h3>
				   
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
      <div>
         <?php if($sReqID != "" AND $ApprovedChk == 9) {  ?>
          <?php { ?>
            <button class="btn btn-success pull-right" onclick="OpenTreat()" type="button"> Click to treat | <i class="fa fa-cog"></i></button>
       
     <?php } ?>
        <!-- <button class="btn btn-warning pull-left" onclick="sendTOBGMDD()" type="button"> Send back to GM Due Dilligence | <i class="fa fa-send"></i></button> -->
         <button class="btn btn-warning pull-left" onclick="sendTOBCOO()" type="button"> Send back to COO | <i class="fa fa-send"></i></button>
     <?php } ?>
      </div>
    </div>
    <script type="text/javascript">
      function MDAction(elem)
    {
       var ActionOfMD = elem.value;
       var MsgMD = $('#tRecMSG').val();
       var ReQID = '<?php echo $sReqID ; ?>';
       var AAMT = $('#AAMT').val();
      
        AAMT = AAMT.replace(/\,/g, '');
       //alert(ActionOfMD);
     if (ActionOfMD != "")
     {     
         
         if(ActionOfMD != "MDKeepInView" && ActionOfMD != "MDCancel")
         {
             if(AAMT > 0)
             {
                window.location.href ="cashmdaction?pdfid=" + ReQID + "&ActionOfMD="+ActionOfMD+"&Mgs="+MsgMD+"&AAMT="+AAMT;
             }
              else
             {
                 window.alert("Kindly enter the approved amount. Thanks");
             }
         }
         else
         {
            window.location.href ="cashmdaction?pdfid=" + ReQID + "&ActionOfMD="+ActionOfMD+"&Mgs="+MsgMD+"&AAMT="+AAMT;
         }
          
     }
  
    } 
    </script>
   <script type="text/javascript">
    function OpenTreat()
    {

      var sReqID = '<?php echo $sReqID ?>';
      /*
      <button class="btn btn-success pull-right" value="MDApprove" onclick="MDAction(this)" type="button"> Approve | <i class="fa fa-send"></i></button>
        <button class="btn btn-warning pull-right" value="MDKeepInView" onclick="MDAction(this)" type="button"> Keep In View | <i class="fa fa-send"></i></button>
         <button class="btn btn-danger pull-right" value="MDCancel" onclick="MDAction(this)" type="button"> Cancel | <i class="fa fa-send"></i></button>
      */

       var size='standart';
                  var content = '<form role="form" >'+
                 // var RAMT = 322211;//'<?php echo "2,323,23"; ?>'; 
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Cash Request Code: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="tRecMSG" name="ReqMSG" placeholder=""  value="Approved" required ></div><br/>' +
                    
                    '<div class="form-group" style="width:37%; display: inline-block; margin: 6px"><label>Requested Amount: </label><input type="text" class="form-control" id="RAMT" name="RAMT" value="<?php echo number_format($TAmt, 2); ?>" readonly /></div>' +
                    
                    '<div class="form-group" style="width:37%; display: inline-block; margin: 6px"><label>Approved Amount: </label><input type="text" class="form-control" id="AAMT" name="AAMT" oninput="setComma(this)"   onKeyPress="return isNumber(event)" ></div><br/>' +
                    
                   '<div class="col-md-12"><button style="margin:5px" class="btn btn-success col-md-3" value="MDApprove" onclick="MDAction(this)" type="button"> Approve | <i class="fa fa-send"></i></button> '+
        '<button style="margin:5px" class="btn btn-warning col-md-3" value="MDKeepInView" onclick="MDAction(this)" type="button"> Keep In View | <i class="fa fa-send"></i></button>'+
         '<button style="margin:5px" class="btn btn-danger col-md-3" value="MDCancel" onclick="MDAction(this)" type="button"> Cancel | <i class="fa fa-send"></i></button></div>'

                  ;
                  var title = 'Treat Cash Request';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
    }
    
    function setComma(elem)
    {
        var x = $(elem).val();
        x = x.replace(/\,/g, '');
        $(elem).val(addCommas(x));
    }
    
     function sendTOBCOO()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        var GMDDNme = '<?php echo $GMDDNme ?>';
       // var DivisonName = '<?php echo $DivisonName ?>';
        
          var size='standart';
                  var content = '<form role="form" action="cashsendTOBCOO" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Cash Request Code: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>COO: </label><input type="text" class="form-control"   value="'+ GMDDNme +'"  readonly ></div>' +
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="RecMSG" name="ReqMSG" placeholder=""  value="Kindly review" required ></div><br/>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/>'

                  ;
                  var title = 'Send Back To COO';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
      }
       function sendTOBGMDD()
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        var GMDDNme = '<?php echo $GMDDNme ?>';
       // var DivisonName = '<?php echo $DivisonName ?>';
        
          var size='standart';
                  var content = '<form role="form" action="cashsendTOBGMDD" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Cash Request Code: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>GM of Due Dilligence: </label><input type="text" class="form-control"   value="'+ GMDDNme +'"  readonly ></div>' +
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="RecMSG" name="ReqMSG" placeholder=""  value="Kindly review" required ></div><br/>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/>'

                  ;
                  var title = 'Send Back To GM Due Dilligence';
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
    window.location.href ="cashmdppor?pdfid=" + hhh;
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
			  <div class="col-xs-12 col-md-4">
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
                        <td style="font-weight: 700; color:#006600">  <?php echo $Curr .' '. number_format($TAmt); ?></td>
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
                        <th>Currency</th>
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

                   <div class="col-xs-12 col-md-6">
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
                   '<form id="sendBKForm" role="form" action="sendTOBHOD" method="POST" >'+
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