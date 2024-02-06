<?php
session_start();
error_reporting(0);

include ('route.php');

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
$SOcode = $_GET['sSO'];
//exit;
require '../DBcon/db_config.php';
if (!$_GET['sSO'] || $_GET['sSO'] == 'ALL') {
   //$resultLI = mysql_query("SELECT * FROM purchaselineitems"); //WHERE Status='OPEN'
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
}
else
{
  $resultLI = mysql_query("SELECT * FROM purchaselineitems WHERE SOCode ='".$SOcode."'"); //WHERE Status='OPEN'
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
//exit;
}

$resultcurren = mysql_query("SELECT * FROM currencies");
$NoRowcurren = mysql_num_rows($resultcurren);
if ($NoRowcurren > 1)
{
while ($row = mysql_fetch_array($resultcurren )) {
$CurrencyName = $row{'CurrencyName'};
$Abbreviation = $row{'Abbreviation'};

$Curreny1 .= '<option value="'.$Abbreviation.'">'.$Abbreviation.'</option>';
}
}

$resultuom = mysql_query("SELECT * FROM uom");
$NoRowuom = mysql_num_rows($resultuom);
if ($NoRowuom > 1)
{
while ($row = mysql_fetch_array($resultuom )) {
$uom = $row{'UOMAbbr'};


$uom1 .= '<option value="'.$uom.'">'.$uom.'</option>';
}
}

$resultRFQ1 = mysql_query("SELECT * FROM so");
$NoRowRFQ1 = mysql_num_rows($resultRFQ1);

$resultpor1 = mysql_query("SELECT DISTINCT RequestID FROM poreq");
$NoRowpor1 = mysql_num_rows($resultpor1);
/////////////////////////////////////////////////////////////////////////////////////

 $resultPOREQ = mysql_query("SELECT * FROM poreq WHERE Approved='1' AND Status = '0'");
//check if user exist
 $NoRowPOREQ = mysql_num_rows($resultPOREQ);
 

 $resultClient1 = mysql_query("SELECT * FROM customers ORDER BY CustormerNme");
 $NoRowClient1 = mysql_num_rows($resultClient1);
 //////////////////////////////////////////////////////////
$ClientRecord = "";
  if ($NoRowClient1 > 0) {
  while ($row = mysql_fetch_array($resultClient1)) {
    $ClientNme = $row['CustormerNme'];
    $ClientID = $row['cusid'];
    $ClientRecord .='<option value="'.$ClientID.'">'.$ClientNme.'</option>';
            
     }
   } 

  //Let's get the Division
 $RecDiv = "";
 $resultDiv = mysql_query("SELECT * FROM businessunit ORDER BY BussinessUnit");
 $NoRowDiv= mysql_num_rows($resultDiv);
 if ($NoRowDiv > 0) {
  while ($row = mysql_fetch_array($resultDiv)) 
  {
    $DivID = $row['id'];
    $DivName = $row['BussinessUnit'];
    $RecDiv .= '<option value="'.$DivID.'">'.$DivName.'</option>';
  }
 }   

function select_options($selected = array()){
    $output = '';
    foreach(json_decode(file_get_contents('names.json'), true) as $item){
        $output.= '<option value="' . $item['value'] . '"' . (in_array($item['value'], $selected) ? ' selected' : '') . '>' . $item['text'] . '</option>';
    }
    return $output;
  }


 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Project and Control </title>
  <link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  
  <!-- Font Awesome Icons -->
    <link href="../mBOOT/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../mBOOT/ionicons.min.css" rel="stylesheet" type="text/css" />
   <!-- DatePicker -->
  <link href="../mBOOT/jquery-ui.css" rel="stylesheet">
    <!-- jvectormap -->
    <link href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins-->
       
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
     <!-- folder instead of downloading all of them to reduce the load. -->
        <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />-->
     <link href="../mBOOT/searchstyle.css" rel="stylesheet" type="text/css" />
      <script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
     <link href="../mBOOT/tokenize2.css" rel="stylesheet" type="text/css" />
    <script src="../mBOOT/tokenize2.js" type="text/javascript"></script>

     <!-- Webpage 
      <link href="maingantt.css" rel="stylesheet" type="text/css" />
      <script src="maingantt.js" type="text/javascript"></script>-->
    <!-- jsGanttImproved App -->
      <link href="../mBOOT/jsgantt.css" rel="stylesheet" type="text/css"/>
      <script src="../mBOOT/jsgantt.js" type="text/javascript"></script>

    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

       <?php include('../topmenu2.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
       <?php include('leftmenu.php'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Set ECP Milestone <i class="fa fa-cubes"></i>
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">ECP MileStone</li>
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
<div class="box" style="display:block" id="ELineIt">
    <div class="row">
   <div class="form-group has-feedback col-md-6" style="margin:12px;">
        <select class="form-control" id="LIRFQ" name="LIRFQ" onChange="ReadLineItem(this)">
      <option value=""> Choose SO code</option>
      <option value="ALL"> ALL Items</option>
      <?php 
       if ($NoRowRFQ1 > 0) 
            {
              //fetch tha data from the database $resultpor1
              while ($row = mysql_fetch_array($resultRFQ1)) {
              
              ?>
              <option value="<?php echo $row['SONum']; ?>"  <?php if ($_GET['sSO'] == $row['SONum']) { echo "selected";} ?>> <?php echo $row['SONum']; ?></option>
              <?php
              }
              
            }
                                
      ?>
                  
      </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
      </div>
   

      <div class="form-group has-feedback col-md-4" style="margin:12px;">
            <span class="search">
            <input style="width:100%" type="text" class="form-control1  " id="RFQ" name="RFQ" placeholder="SO Code Search..." onInput="searchrfq(this)" />
      
       <ul class="results" id="resultRFQ" >
        
       </ul>
    </span> 
    </div>
  </div>
<script>
function searchrfq(mou)
{
var searchid = $(mou).val();
var dataString = 'search='+ searchid;
if(searchid!='' && searchid.length >= 4)
{
  $.ajax({
  type: "POST",
  url: "searchSO.php",
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
window.location.href = "PO?sSO=" + uval;
}
</script>

  <!--  <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
                  
                  <a href="<?php echo $Attachlnk; ?>" <i class="fa fa-eye" ></i> View Attachment </a>
   
    </div> -->
    
      </form> 
        </div>
  
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Project Details</h3> &nbsp; <i class="fa fa-comment"></i>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="regECPProj" method="post">
                    <div class="col-md-12" style="background-color:#DFDFDF; border-radius: 25px;">
                      <div class="col-md-6">
                      <p class="text-center">
                        <strong></strong>
                      </p>
                     
                      <div class="form-group has-feedback col-md-6">
                      <label>Project Name :</label>
                        <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                       <input type="text" class="form-control" id="POName" name="POName" />
                
                      </div>
                       <div class="form-group has-feedback col-md-6">
                          <label>Client Name :</label>
                          <select class="form-control" id="SOClient" name="SOClient" onChange="" required >
                          <option value=""> Select Client</option>
                          <?php
                          echo $ClientRecord;
                          ?>
                          </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
                       </div>
                     <div class="form-group has-feedback col-md-12">
                          <label>End User :</label>
                          <select class="form-control" id="SOClient" name="SOClient" onChange="" required >
                          <option value=""> Select End User</option>
                          <?php
                          echo $ClientRecord;
                          ?>
                          </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
                       </div>  
                   <div class="form-group has-feedback col-md-12">
                    <label>Project OEM(s) :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                      <select class="tokenize-demo form-control" id="SOOEM" name="SOOEM" multiple required>
                         <?php
                          echo $ClientRecord;
                          ?>
                      </select>
                      <script> $('.tokenize-demo').tokenize2(); </script>
                  </div>
                  <div class="form-group has-feedback col-md-6">
                    <label>PO Received Date :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                     <input type="text" class="form-control SODate" id="PORDate" name="PORDate" onChange="AddReq(this)" onClick="AddReq(this)" />
              
                  </div>
                  <div class="form-group has-feedback col-md-6">
                    <label>PO Acknowledged Date :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                     <input type="text" class="form-control SODate" id="POADate" name="POADate" onChange="AddReq(this)" onClick="AddReq(this)" />
              
                  </div>
                  <div class="form-group has-feedback col-md-6">
                    <label>Project Start Date :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                     <input type="text" class="form-control SODate" id="ProjSDate" name="ProjSDate" onChange="AddReq(this)" onClick="AddReq(this)" />
              
                  </div>
                  <div class="form-group has-feedback col-md-6">
                    <label>Project End Date :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                     <input type="text" class="form-control SODate" id="ProjEDate" name="ProjEDate" onChange="AddReq(this)" onClick="AddReq(this)" />
              
                  </div>
               
                  </div><!-- /.col 6 -->
                  <div class="col-md-6">
                      
                       <div class="form-group has-feedback col-md-12" style="top-padding:12px;">
                         <label>Division :</label>
                          <select class="form-control" id="SODiv" name="SODiv" required >
                          <option value=""> Choose Division</option>
                          <?php echo $RecDiv; ?>
                          </select>
                      </div>
                        <div class="form-group has-feedback col-md-12" >
                          <p class="text-center">
                              <strong>Project Goal :</strong>
                          </p>
                         <textarea rows="4" cols="50" placeholder="Delivery Location" id="DeliLoc" name="DeliLoc" style="width:100%;"> </textarea>
                       </div>
                       <div class="form-group has-feedback col-md-12" >
                          <p class="text-center">
                              <strong>Item Description :</strong>
                          </p>
                         <textarea rows="4" cols="50" placeholder="Delivery Location" id="DeliLoc" name="DeliLoc" style="width:100%;"> </textarea>
                       </div>
                  
                  <div class="form-group has-feedback col-md-6">
                    <label>Contractual Date :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                     <input type="text" class="form-control SODate" id="ConDate" name="ConDate" onChange="AddReq(this)" onClick="AddReq(this)" />
                  </div>
                  <div class="form-group has-feedback col-md-6">
                    <label>Extension Date :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                     <input type="text" class="form-control SODate" id="ExtDate" name="ExtDate" onChange="AddReq(this)" onClick="AddReq(this)" />
                  </div>
                  <div class="form-group has-feedback col-md-12">
                      <button type="submit" class="btn btn-primary btn-block btn-flat">Update Project</button>
                  </div>
                  </div><!-- ./col 6 -->
                </div><!-- /.col -->
                </form>
                 
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
  
  
 

    
   <script type="text/javascript" >
  
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function isEnterKey(evt) {
    $("#LIDes").click(function(event) {
  event.preventDefault();
//Do your logic here
});
}


function ReadLineItem(elem)
    {
       var hhh = elem.value;
     if (hhh != "")
     {     
    window.location.href ="EPCMileStone?sSO=" + hhh;
    //window.alert("JKJ");
     }
  
    } 

function editLIT(elem)
{
  var LinIT = $(elem).attr("litid");
  var smSO = $(elem).attr("smso");
  var DDate = $(elem).attr("ddate");
  var soCurrn = $(elem).attr("curr");
  var Qty = $(elem).attr("qty");
  var UnitCost = $(elem).attr("urate");
  var Rmark = $(elem).attr("rmk");
  var Descr = $(elem).attr("descr");
  var POAmt = $(elem).attr("poamt");
  var UOM = $(elem).attr("uom");
  var Discount = $(elem).attr("disct");
  var Curren = '<?php echo $Curreny1; ?>';
  var uoms = '<?php echo $uom1; ?>';
  //var UnitCost = $(elem).attr("urate");
  //alert(soCurrn);
  //var dataString = 'litem='+ LinIT;

            var size='large';
            var content = '<form role="form" action="updateSO" method="POST" ><div class="form-group">' +
             '<input type="hidden" value="'+ LinIT +'" id="LitIDm" name="LitIDm" />'+
             '<input type="hidden" value="'+ smSO +'" id="smSO" name="smSO" />'+
             '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label><textarea class="form-control" id="EditDes" name="EditDes" placeholder="Description">'+Descr+'</textarea></div>' +
             '<div class="form-group" style="width:100%; display: inline-block;"><label>Remark/Tech. Spec.: </label><textarea class="form-control" id="EditRemark" name="EditRemark" placeholder="Remark/Technical Specification">'+Rmark+'</textarea></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Due Date: </label><input type="text" class="form-control" style="z-index: 100000;" id="EditDueDate" name="EditDueDate" onInput="compute()" placeholder="Due Date" value="'+DDate+'" readonly ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Quantity: </label><input type="text" class="form-control" id="EditQty" name="EditQty" placeholder="Quantity" onInput="compute()" value="'+Qty+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Unit Rate: </label><input type="text" class="form-control" id="EditUnitRate" name="EditUnitRate" placeholder="Unit Rate" onInput="compute()" value="'+UnitCost+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Discount %: </label><input type="text" class="form-control" id="EditDisc" name="EditDisc" placeholder="Discount" onInput="compute()" value="'+Discount+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Amount: </label><input type="text" class="form-control" id="EditAmt" name="EditAmt" placeholder="Amount" onInput="compute()" value="'+POAmt+'" onKeyPress="return isNumber(event)" readonly ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Per (UOM): </label><select class="form-control" id="EditPer" name="EditPer" onInput="compute()">'+uoms+'</select></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Currency: </label><select class="form-control" id="EditCurr" name="EditCurr" onInput="compute()">'+Curren+'</select></div>' +
              '<button type="submit" class="btn btn-primary">Update</button></form>';
            var title = 'Edit Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

            $('#EditDueDate').datepicker();
            $("#EditPer").val(UOM).change();
            $("#EditCurr").val(soCurrn).change();
}

function compute()
{
  //alert('fdgfgdkj');
  var TotalAmt = parseFloat($('#EditQty').val()) * parseFloat($('#EditUnitRate').val());
                //$('EditAmt').val() 
                var ED = parseFloat($('#EditDisc').val());
                if(ED > 0)
{
  $('#EditAmt').val(TotalAmt - ((ED * TotalAmt)/100) );
}
else
{
  $('#EditAmt').val(TotalAmt);
}
                
                
}

</script>
<script type="text/javascript">
      function setModalBox(title,content,footer,$size)
        {
            document.getElementById('modal-bodyku').innerHTML=content;
            document.getElementById('myModalLabel').innerHTML=title;
            document.getElementById('modal-footerq').innerHTML=footer;
           
            if($size == 'large')
            {
                $('#myModal').attr('class', 'modal fade bs-example-modal-lg')
                             .attr('aria-labelledby','myLargeModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-lg');
            }
            if($size == 'standart')
            {
                $('#myModal').attr('class', 'modal fade')
                             .attr('aria-labelledby','myModalLabel');
                $('.modal-dialog').attr('class','modal-dialog');
            }
            if($size == 'small')
            {
                $('#myModal').attr('class', 'modal fade bs-example-modal-sm')
                             .attr('aria-labelledby','mySmallModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-sm');
            }
        }
        </script> 
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

<?php
//fetch tha data from the database
 $SN = 1;
   if ($NoRowLI > 0) {
  while ($row = mysql_fetch_array($resultLI)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
    $LitID = $row{'LitID'};
    $MatSer = $row['MatSer'];
    $Description = $row ['Description'];
    $Remark = $row ['Remark'];
    $soCurrn = $row['Currency'];
    $Qty = $row ['Qty'];
    $UOM = $row ['UOM'];
    $DDate = $row ['DueDate'];
    $Price = $row ['ExtendedCost'];
    $UnitCost = $Price/$Qty;
    $Discount = $row ['Discount'];
    $Price = $Price - (($Price * $Discount)/100);
    
    $Price1 = number_format($Price);
    $Currency = $row ['Currency'];
    $SOn = $row ['SOCode'];
    $EditSO = '<i style="cursor:pointer; color:orange" class="fa fa-edit" curr="'.$soCurrn.'" disct="'.$Discount.'" ddate="'.$DDate.'" descr="'.$Description.'" qty="'.$Qty.'" rmk="'.$Remark.'" urate="'.$UnitCost.'" poamt="'.$Price.'" uom="'.$UOM.'" smso="'.$SOn.'" litid="'.$LitID.'" onclick="editLIT(this);"></i>';
    //$EditSO = '<i class="fa fa-edit"></i>';
      $Record .='
           <tr>
              <td>'.$SN.'</td>
              <td>'.$LitID.'</td>
            <td>'.$MatSer.'</td>
            <td>'.$Description.'</td>
            <td>'.$Qty.'</td>
            <td>'.$UOM.'</td>
            <td>'.$Discount.'</td>
            <td>'.$Price1.'</td>
            <td>'.$EditSO.'</td>
             </tr>';
    $SN = $SN + 1;        
     }
}


?>  
          <div class="row">
            <div class="col-md-12">
             
              <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title">SO Line Items</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Item ID</th>
                        <th>Mat</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>UOM</th>
                        <th>Discount</th>
                        <th>ExCost</th>
                        <th>Edit</th>
                        
                        <!--<th>To WH</th>-->

                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
    
    
   

     <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Project Schedule</h3>    <i class="fa fa-history"></i>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                                <script type="text/javascript" src="../mBOOT/gchartloader.js"></script>
                                           <script type="text/javascript">
                        google.charts.load("current", {packages:["timeline"]});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                          var container = document.getElementById('example2.1');
                          var chart = new google.visualization.Timeline(container);
                          var dataTable = new google.visualization.DataTable();

                          dataTable.addColumn({ type: 'string', id: 'Term' });
                          dataTable.addColumn({ type: 'string', id: 'Name' });
                          dataTable.addColumn({ type: 'date', id: 'Start' });
                          dataTable.addColumn({ type: 'date', id: 'End' });

                          dataTable.addRows([
                            [ '1', 'Clear Emarc', new Date(2016, 3, 30), new Date(2016, 9, 4) ],
                            [ '2', 'Delivery To Italy',        new Date(2016, 9, 4),  new Date(2017, 2, 17) ],
                            [ '3', 'Final Installation',  new Date(2017, 2, 17),  new Date(2017, 8, 4) ]]);

                            var options = {
                              colors: ['#006633', '#009966', '#00AE57' ]
                             // timeline: { rowLabelStyle: {fontName: 'Helvetica', fontSize: 24, color: '#603913' },
                                            // barLabelStyle: { fontName: 'Garamond', fontSize: 14 } }
                            };
                          chart.draw(dataTable);
                        }
                      </script>

                      <div id="example2.1" style="height: 400px;"></div>
                     
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
      </div><!-- /.row -->


     <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Project Schedule</h3>    <i class="fa fa-history"></i>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row"> 
                  <div class="col-md-12"> 
                      <div id="embedded-Gantt">
              <script type="text/javascript">
              var g = new JSGantt.GanttChart(document.getElementById('embedded-Gantt'), 'week');
              if (g.getDivId() != null) {
                g.setCaptionType('Complete');  // Set to Show Caption (None,Caption,Resource,Duration,Complete)
                g.setQuarterColWidth(36);
                g.setDateTaskDisplayFormat('day dd month yyyy'); // Shown in tool tip box
                g.setDayMajorDateDisplayFormat('mon yyyy - Week ww') // Set format to display dates in the "Major" header of the "Day" view
                g.setWeekMinorDateDisplayFormat('dd mon') // Set format to display dates in the "Minor" header of the "Week" view
                g.setShowTaskInfoLink(1); // Show link in tool tip (0/1)
                g.setShowEndWeekDate(0); // Show/Hide the date for the last day of the week in header for daily view (1/0)
                g.setUseSingleCell(10000); // Set the threshold at which we will only use one cell per table row (0 disables).  Helps with rendering performance for large charts.
                g.setFormatArr('Day', 'Week', 'Month', 'Quarter'); // Even with setUseSingleCell using Hour format on such a large chart can cause issues in some browsers
                // Parameters                     (pID, pName, pStart,       pEnd,        pStyle,         pLink (unused)  pMile, pRes,       pComp, pGroup, pParent, pOpen, pDepend, pCaption, pNotes, pGantt)
                g.AddTaskItem(new JSGantt.TaskItem(1,   'Define Chart API',     '',           '',          'ggroupblack',  '',                 0, 'Brian',    0,     1,      0,       1,     '',      '',      'Some Notes text', g ));
                g.AddTaskItem(new JSGantt.TaskItem(11,  'Chart Object',         '2017-02-20','2017-02-20', 'gmilestone',   '',                 1, 'Shlomy',   100,   0,      1,       1,     '',      '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(12,  'Task Objects',         '',           '',          'ggroupblack',  '',                 0, 'Shlomy',   40,    1,      1,       1,     '',      '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(121, 'Constructor Proc',     '2017-02-21','2017-03-09', 'gtaskblue',    '',                 0, 'Brian T.', 60,    0,      12,      1,     '',      '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(122, 'Task Variables',       '2017-03-06','2017-03-11', 'gtaskred',     '',                 0, 'Brian',    60,    0,      12,      1,     121,     '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(123, 'Task by Minute/Hour',  '2017-03-09','2017-03-14 12:00', 'gtaskyellow', '',            0, 'Ilan',     60,    0,      12,      1,     '',      '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(124, 'Task Functions',       '2017-03-09','2017-03-29', 'gtaskred',     '',                 0, 'Anyone',   60,    0,      12,      1,     '123SS', 'This is a caption', null, g));
                g.AddTaskItem(new JSGantt.TaskItem(2,   'Create HTML Shell',    '2017-03-24','2017-03-24', 'gtaskyellow',  '',                 0, 'Brian',    20,    0,      0,       1,     122,     '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(3,   'Code Javascript',      '',           '',          'ggroupblack',  '',                 0, 'Brian',    0,     1,      0,       1,     '',      '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(31,  'Define Variables',     '2017-02-25','2017-03-17', 'gtaskpurple',  '',                 0, 'Brian',    30,    0,      3,       1,     '',      'Caption 1','',   g));
                g.AddTaskItem(new JSGantt.TaskItem(32,  'Calculate Chart Size', '2017-03-15','2017-03-24', 'gtaskgreen',   '',                 0, 'Shlomy',   40,    0,      3,       1,     '',      '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(33,  'Draw Task Items',      '',           '',          'ggroupblack',  '',                 0, 'Someone',  40,    2,      3,       1,     '',      '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(332, 'Task Label Table',     '2017-03-06','2017-03-09', 'gtaskblue',    '',                 0, 'Brian',    60,    0,      33,      1,     '',      '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(333, 'Task Scrolling Grid',  '2017-03-11','2017-03-20', 'gtaskblue',    '',                 0, 'Brian',    0,     0,      33,      1,     '332',   '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(34,  'Draw Task Bars',       '',           '',          'ggroupblack',  '',                 0, 'Anybody',  60,    1,      3,       0,     '',      '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(341, 'Loop each Task',       '2017-03-26','2017-04-11', 'gtaskred',     '',                 0, 'Brian',    60,    0,      34,      1,     '',      '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(342, 'Calculate Start/Stop', '2017-04-12','2017-05-18', 'gtaskpink',    '',                 0, 'Brian',    60,    0,      34,      1,     '',      '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(343, 'Draw Task Div',        '2017-05-13','2017-05-17', 'gtaskred',     '',                 0, 'Brian',    60,    0,      34,      1,     '',      '',      '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(344, 'Draw Completion Div',  '2017-05-17','2017-06-04', 'gtaskred',     '',                 0, 'Brian',    60,    0,      34,      1,     "342,343",'',     '',      g));
                g.AddTaskItem(new JSGantt.TaskItem(35,  'Make Updates',         '2017-07-17','2017-09-04', 'gtaskpurple',  '',                 0, 'Brian',    30,    0,      3,       1,     '333',   '',      '',      g));

                g.Draw();
              } else {
                alert("Error, unable to create Gantt Chart");
              }
          </script>
          </div>
          </div><!-- /.col -->
          </div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
      </div><!-- /.row -->
    
    
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    

       <?php include('../footer.php'); ?>
     

      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  
    <!-- FastClick -->
    <script src='../plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
   <!-- date-range-picker -->
    <script src="../mBOOT/moment.min.js" type="text/javascript"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
   <!-- bootstrap time picker -->
    <script src="../plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <!-- InputMask -->
    <script src="../plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="../plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="../plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="../plugins/chartjs/Chart.min.js" type="text/javascript"></script>
  <!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../mBOOT/jquery-ui.js"></script>
   <script type="text/javascript"> //Date Picker
      $(function () {
         $(".SODate").datepicker({
           inline: true,
           minDate: new Date()
          });

         $("#userTab").dataTable();
       
      });
    </script>
 
  </body>
</html>