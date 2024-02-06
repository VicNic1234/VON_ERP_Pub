<?php
session_start();
error_reporting(0);

if((strpos($_SESSION['AccessModule'], "projectcontrols") > -1)) {}
else {  $_SESSION['ErrMsg'] = "You do not have access to edit Sales Order"; 
header('Location: ../users/logout'); exit; }

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
$SOcode = $_GET['SOID'];
require '../DBcon/db_config.php';
//To Change SO Code 
if($_POST['OLDSONUM'])
{
  $oldC = mysql_real_escape_string(trim(strip_tags($_POST['OLDSONUM'])));
  $newC = mysql_real_escape_string(trim(strip_tags($_POST['SONUM'])));
  if($oldC != $newC) {  
    $query = "UPDATE so SET SONum='".$newC."' WHERE SONum='".$oldC."'"; 
    $result = mysql_query($query);
    $query = "UPDATE purchaselineitems SET SOCode='".$newC."' WHERE SOCode='".$oldC."'"; 
    $result = mysql_query($query);
    $_SESSION['ErrMsgB'] = "SO Changed from : ".$oldC . " to :".$newC;
    header('Location: EditSO?SOID='.$newC);
    exit;
  }
}

//To Delete SO Code 
if($_POST['dOLDSONUM'])
{
  $oldC = mysql_real_escape_string(trim(strip_tags($_POST['dOLDSONUM'])));
 {  
    $query = "DELETE FROM so WHERE SONum='".$oldC."'"; 
    $result = mysql_query($query);
    $query = "DELETE FROM purchaselineitems WHERE SOCode='".$oldC."' AND Status='OPEN'"; 
    $result = mysql_query($query);
    $_SESSION['ErrMsgB'] = "SO Deleted : ".$oldC;
    header('Location: aSO');
    exit;
  }
}


  $resultLI = mysql_query("SELECT * FROM purchaselineitems WHERE SOCode ='".$SOcode."'"); //WHERE Status='OPEN'
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
//exit;


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



//Select All Acitve na Avalible Staff
//Allstaff


$resultusers = mysql_query("SELECT uid,Firstname,Surname FROM users Where isActive=1 AND isAvalible=1 ORDER BY Firstname");
$NoRowusers = mysql_num_rows($resultusers);
if ($NoRowusers > 1)
{

while ($row = mysql_fetch_array($resultusers )) {
$uidR = $row{'uid'};
$uNameR = $row{'Firstname'} . " " . $row{'Surname'};
$Allstaff .= '<option value="'.$uidR.'">'.$uNameR.'</option>';
}

}
/////////////////////////////////////////////

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
 while ($row = mysql_fetch_array($resultRFQ1)) {
              
              $SOCus = $row['cusid'];
        }

$resultpor1 = mysql_query("SELECT DISTINCT RequestID FROM poreq");
$NoRowpor1 = mysql_num_rows($resultpor1);
/////////////////////////////////////////////////////////////////////////////////////

 //Let's Get SO Details
$resultSODetails = mysql_query("SELECT * FROM epcprojectdetails WHERE ProjSO ='$SOcode'");
 $NoRowSODetails = mysql_num_rows($resultSODetails);
 //////////////////////////////////////////////////////////
$ClientRecord = "";
  if ($NoRowSODetails > 0) {
  while ($row = mysql_fetch_array($resultSODetails)) {
    $pProjectName = $row['ProjectName'];
    $pClientID = $row['ClientName'];
    $pDivision = $row['Division'];
    $pEndUser = $row['EndUser'];
    $pProjectGoal = $row['ProjectGoal'];
    $pProjectOEM = $row['ProjectOEM'];
    $pPOReceivedDate = $row['POReceivedDate'];
    $pPOAcknowledgedDate = $row['POAcknowledgedDate'];
    $pProjectStartDate = $row['ProjectStartDate'];
    $pProjectEndDate = $row['ProjectEndDate'];
    $pConDate = $row['ContractualDate'];
    $pExtDate = $row['ExtensionDate'];
    $pDescrip = $row['ItemDescription'];
    $ClientRecord .='<option value="'.$ClientID.'">'.$ClientNme.'</option>';
            
     }
   } 
 

 $resultClient1 = mysql_query("SELECT * FROM customers ORDER BY CustormerNme");
 $NoRowClient1 = mysql_num_rows($resultClient1);
 //////////////////////////////////////////////////////////
$ClientRecord = "";
  if ($NoRowClient1 > 0) {
  while ($row = mysql_fetch_array($resultClient1)) {
    $ClientNme = $row['CustormerNme'];
    $ClientID = $row['cusid'];
    if ($pClientID == $ClientID || $SOCus == $ClientID ) { $ClientRecord .='<option value="'.$ClientID.'" selected >'.$ClientNme.'</option>'; }
    else { $ClientRecord .='<option value="'.$ClientID.'">'.$ClientNme.'</option>'; }

    //For End User
    if ($pEndUser == $ClientID) { $EndUserRecord .='<option value="'.$ClientID.'" selected >'.$ClientNme.'</option>'; }
    else { $EndUserRecord .='<option value="'.$ClientID.'">'.$ClientNme.'</option>'; }
            
     }
     
   } 

///////////////////////////////////////////////////////////////////////////
   $resultSupplier = mysql_query("SELECT * FROM suppliers ORDER BY SupNme");
 $NoRowSupplier = mysql_num_rows($resultSupplier);
 //set OEM in an Array
 $OEMArray = explode(",",$pProjectOEM); 
 //////////////////////////////////////////////////////////
$SupplierRecord = "";
  if ($NoRowSupplier > 0) {
  while ($row = mysql_fetch_array($resultSupplier)) {
    $SupNme = $row['SupNme'];
    $Supid = $row['supid'];
    if(in_array($Supid, $OEMArray))
    {
      $SupplierRecord .='<option value="'.$Supid.'" selected >'.$SupNme.'</option>';
    }
    else
    {
      $SupplierRecord .='<option value="'.$Supid.'">'.$SupNme.'</option>';
    }
    
            
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
    if($pDivision == $DivID) { $RecDiv .= '<option value="'.$DivID.'" selected >'.$DivName.'</option>'; }
    else { $RecDiv .= '<option value="'.$DivID.'" >'.$DivName.'</option>'; }
    
  }
 }   





 
?>
<!DOCTYPE html>
<html>
  <?php include('../header2.php') ?>
  <body class="skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper">

       <?php include('../topmenu2.php'); ?>
      <!-- Left side column. contains the logo and sidebar -->
      
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit Sale Order <i class="fa fa-cubes"></i>
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="aSO"><i style="font-size:28px; color:green"  class="fa fa-home"></i></a></li>
           
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
      <form id="chgso" method="POST" action="">
      <div class="form-group has-feedback col-md-4" style="margin:12px;">
      <input type="text" name="SONUM" id="SONUM" class="form-control" value="<?php echo $SOcode; ?>" /> 
      <input type="hidden" name="OLDSONUM" id="OLDSONUM" class="form-control" value="<?php echo $SOcode; ?>" /> 
      </div>
      </form>


      <div class="form-group has-feedback col-md-3" style="margin:12px;">
      <button type="text" class="form-control btn-primary" onclick="subM();"> Change Sale Order Code </button> 
      </div>
      <div class="form-group has-feedback col-md-3" style="margin:12px;">
      <button type="text" class="form-control btn-danger" onclick="rmvM();"> Delete Sale Order Code </button> 
      </div>
      <form id="delso" method="POST" action="">
      <input type="hidden" name="dOLDSONUM" id="dOLDSONUM" class="form-control" value="<?php echo $SOcode; ?>" /> 
      </form>
      <script type="text/javascript">
      function subM()
      {
        if($('#SONUM').val() != "" && $('#OLDSONUM').val() != "")
        {
          $('#chgso').submit();
        }
        else
        {
          alert('Kindly set new SO Code. thanks');
        }
      }

       function rmvM()
      {
        if($('#dOLDSONUM').val() != "")
        {
          $('#delso').submit();
        }
        else
        {
          //alert('Kindly set new SO Code. thanks');
        }
      }
      </script>
     
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
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body collapse">
                  <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="regECPProj" method="post">
                    <div class="col-md-12" style="background-color:#DFDFDF; border-radius: 25px;">
                      <div class="col-md-6">
                      <p class="text-center">
                        <strong></strong>
                      </p>
                     <input type="hidden" name="ProjSO" id="ProjSO" value="<?php echo $SOcode; ?>" />
                      <div class="form-group has-feedback col-md-6">
                      <label>Project Name :</label>
                        <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                       <input type="text" class="form-control" id="POName" name="POName" value="<?php echo $pProjectName; ?>" required />
                
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
                          <select class="form-control" id="SOEndUser" name="SOEndUser" onChange="" required >
                          <option value=""> Select End User</option>
                          <?php
                          echo $EndUserRecord;
                          ?>
                          </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
                       </div>  
                   <div class="form-group has-feedback col-md-12">
                    <label>Project OEM(s) :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                      <select class="tokenize-demo form-control" id="SOOEM" name="SOOEM[]" multiple required >
                         <?php
                          echo $SupplierRecord;
                          ?>
                      </select>
                       <script> $('.tokenize-demo').tokenize2(); </script>
                  </div>
                  <div class="form-group has-feedback col-md-6">
                    <label>PO Received Date :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                     <input type="text" class="form-control SODate" id="PORDate" name="PORDate" value="<?php echo $pPOReceivedDate; ?>" required />
              
                  </div>
                  <div class="form-group has-feedback col-md-6">
                    <label>PO Acknowledged Date :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                     <input type="text" class="form-control SODate" id="POADate" name="POADate" value="<?php echo $pPOAcknowledgedDate; ?>" />
              
                  </div>
                  <div class="form-group has-feedback col-md-6">
                    <label>Project Start Date :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                     <input type="text" class="form-control SODate" id="ProjSDate" name="ProjSDate" value="<?php echo $pProjectStartDate; ?>" />
              
                  </div>
                  <div class="form-group has-feedback col-md-6">
                    <label>Project End Date :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                     <input type="text" class="form-control SODate" id="ProjEDate" name="ProjEDate" value="<?php echo $pProjectEndDate; ?>" />
              
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
                         <textarea rows="4" cols="50" placeholder="Enter Project Goal Here..." id="POGoal" name="POGoal" style="width:100%;" required ><?php echo $pProjectGoal; ?></textarea>
                       </div>
                       <div class="form-group has-feedback col-md-12" >
                          <p class="text-center">
                              <strong>Item Description :</strong>
                          </p>
                         <textarea rows="4" cols="50" placeholder="Enter Project Description Here..." id="PODescrip" name="PODescrip" style="width:100%;" required ><?php echo $pDescrip; ?></textarea>
                       </div>
                  
                  <div class="form-group has-feedback col-md-6">
                    <label>Contractual Date :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                     <input type="text" class="form-control SODate" id="ConDate" name="ConDate" value="<?php echo $pConDate; ?>"  />
                  </div>
                  <div class="form-group has-feedback col-md-6">
                    <label>Extension Date :</label>
                      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
                     <input type="text" class="form-control SODate" id="ExtDate" name="ExtDate"  value="<?php echo $pExtDate; ?>" />
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

function addLitem()
{
var Curren = '<?php echo $Curreny1; ?>';
      var uoms = '<?php echo $uom1; ?>';
      var SOCODE = '<?php echo $SOcode; ?>';
      var title = 'New line item for SO, in SO No. : '+SOCODE;
      //alert(currency);

      var divGrowth = '<?php echo $RecDiv; ?>';
      ///We got get Description now
   
            var size='large';
            var content = '<form role="form" method="post" action="addLineItem"><div class="form-group">' +
      '<label>Line Item\'s Description: </label>' +
            '<textarea required class="form-control" id="ItDes" name="ItDes" placeholder="" ></textarea>' +
            '<span class="glyphicon glyphicon-align-justify form-control-feedback"></span>' +
      '</div>' +
      
      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Currency: </label>'+
      '<select class="form-control" id="Cur" name="Cur">' + Curren + '</select>' +
      //'<input type="hidden" id="mCurrency" value="' + currency + '" />'+
      '<input type="hidden" name="SOCODE" value="' + SOCODE + '" />'+
      
      '</div>' +
      
      '<div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">' +
        '<label>Quantity of Item </label>' +
      '<input type="text" class="form-control" id="LIQty" name="LIQty" placeholder="Quantity" value="" onInput="MainComp()" onKeyPress="return isNumber(event)"  />' +
      '</div>'+

      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Unit of Meas.: </label>'+
      '<select class="form-control" id="UOM" name="UOM">' + uoms + '</select>' +
      
      
      '</div>' +
      
      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Material No.: </label><input type="text" class="form-control" id="mart" name="mart" value="" ></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;" ><label>Unit Weight (Kg): </label><input type="text" class="form-control" id="UnitWeight" name="UnitWeight" value="" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      
      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Extended Weight (Kg): </label><input type="text" class="form-control" id="ExWeight" name="ExWeight" onKeyPress="return isNumber(event)" readonly  ></div>' +
      
      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Unit Cost: </label><input type="text" class="form-control" id="LIUC" name="LIUC" placeholder="Unit Cost" value="" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      
      '<input type="hidden" name="LIID" value="" ></input>' +
      //'<input type="hidden" name="LIRFQ" value="'+ rfq +'" ></input>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Extended Cost: </label><input type="text" class="form-control" id="ExCost" name="ExCost" placeholder="Extended Cost" readonly ></div>' +
      
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Discount(%): </label><input type="text" class="form-control" value="" id="Disc" name="Disc" placeholder="Discount" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Discount Amt: </label><input type="text" class="form-control" id="DiscC" name="DiscC" placeholder="Disc. Amount" onKeyPress="return isNumber(event)" readonly></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>FOB: </label><input type="text" class="form-control" id="FOB" name="FOB" placeholder="ExPrice-Discount"  readonly ></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Packaging(% of FOB): </label><input type="text" class="form-control" id="PackP" value="" name="PackP" placeholder="Pkg %" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Packaging Amt: </label><input type="text" class="form-control" id="PackA" name="PackA" placeholder="Package Amount" onKeyPress="return isNumber(event)" readonly></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Insurance(% of FOB): </label><input type="text" class="form-control" id="InsurP" name="InsurP" value="" placeholder="Insurance %" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Insurance Amt: </label><input type="text" class="form-control" id="InsurA" name="InsurA" placeholder="Insurance Amount" onKeyPress="return isNumber(event)" readonly></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Freight Per Kg: <input type="checkbox" id="freightperchk" name="freightperchk" onclick="chngfpkg();" /></label><input type="text" title="Freight * ExWeight" class="form-control" id="FreightP" name="FreightP" value="" placeholder="Freight" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Freight Amt: </label><input type="text" class="form-control" id="FreightA" name="FreightA" placeholder="Freight Amount" value="" onInput="MainComp()" onKeyPress="return isNumber(event)" readonly></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>SubTotal, CIF: </label><input type="text" class="form-control" id="CIF" name="CIF" placeholder="SubTotal, CIF"  readonly></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>HS CODE: </label><input type="text" class="form-control" id="HSCODE" name="HSCODE" value="" placeholder="HS CODE"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>HS Tariff %: </label><input type="text" class="form-control" id="HSTariff" value="" name="HSTariff" placeholder="HS Tariff %" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>CISS(1% FOB): </label><input type="text" class="form-control" id="PreShip" name="PreShip" placeholder="Custom Duty" readonly ></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Custom Duty: </label><input type="text" class="form-control" id="CustomDuty" name="CustomDuty" placeholder="Custom Duty" readonly ></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Custom Surcharge ( 7% of custom duty ): </label><input type="text" class="form-control" id="CusSub" name="CusSub" placeholder="Custom Surcharge" readonly></div>' +
       '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Custom Vat: <input type="checkbox" name="CusVat" id="CusVat" checked  onclick="MainComp()" /> </label><input type="text" title="5% of (CIF + Duty + Subcharge + CISS + ETLS)" class="form-control" id="CustomVat" name="CustomVat" onInput="MainComp()" placeholder="Custom Vat" onKeyPress="return isNumber(event)" readonly></div>' +
      

      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>ETLS Charge ( 0.5% of CIF ): </label><input type="text" class="form-control" id="ETLS" name="ETLS" placeholder="ETLS Charge" onKeyPress="return isNumber(event)" readonly></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Local Handling (% of CIF ): </label><input type="text" class="form-control" id="pLocHand" name="pLocHand" placeholder="Local Handling %" value = "" onInput="MainComp()" onKeyPress="return isNumber(event)"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Local Handling Amt: </label><input type="text" class="form-control" id="LocHand" name="LocHand" placeholder="Local Handling" readonly ></div>' +
      
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Mark up (% of CIF): <input type="checkbox" id="markupchk" name="markupchk" onclick="chngmkup();" /></label><input type="text" class="form-control" id="markupperc" name="markupperc" value="" placeholder="Mark up %" onInput="MainComp()" onKeyPress="return isNumber(event)"></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Mark up Amt: </label><input type="text" class="form-control" id="markupCos" name="markupCos" placeholder="Mark up" value="" readonly onInput="MainComp()" onKeyPress="return isNumber(event)"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Local Cost: </label><input type="text" class="form-control" id="LocCos" name="LocCos" placeholder="Local Cost" readonly ></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Delivery Ex-Works: </label><input type="text" class="form-control" id="DEX" name="DEX" value="" placeholder="Delivery Ex-works" ></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Ex-Works Location: </label><input type="text" class="form-control" id="DEXL" name="DEXL" value="" placeholder="Delivery Ex-works Location" ></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Delivery Cus. Location: </label><input type="text" class="form-control" id="DCUSL" name="DCUSL" value="" placeholder="Delivery Customers Location" ></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Discount on Total: <input type="checkbox" id="applyDONT" name="applyDONT" onclick="MainComp();" /></label><input type="text" class="form-control" id="DONT" name="DONT" value="" placeholder="Discount on incoterm" onInput="MainComp()" onKeyPress="return isNumber(event)" ></div>' +
      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Growth Engine: </label>'+
      '<select class="form-control" id="Divs" name="Divs">' + divGrowth + '</select>' +
      '</div>' +
      '<br />'+
    '<div class="form-group" style="width:43%; display:inline-block; margin:12px;"><label>DDP Price (CIF + Local Cost): </label><input type="text" class="form-control" id="DPPPrice" name="DPPPrice" placeholder="DDP Price" readonly ><input type="radio" name="qstate" value="1" checked></input> <br /> <label> Include NCD: <input type="checkbox" id="NCDchk" name="NCDchk" onclick="MainComp();" /></label></div>' +
      
      '<div class="form-group" style="width:63%; display:inline-block; margin:12px;"><label>Exworks Price (ExUnit Cost + Packaging + Markup): </label><input type="text" class="form-control" id="EXPPrice" name="EXPPrice" placeholder="Exworks Price" readonly ><input type="radio" name="qstate" value="2"></input></div>' +
      
      '<div class="form-group" style="width:63%; display:inline-block; margin:12px;"><label>CIF Price (CIF + Markup): </label><input type="text" class="form-control" id="CIFPPrice" name="CIFPPrice" placeholder="CIF Price" readonly ><input type="radio" name="qstate" value="3"></input></div>' +
      
      
      '<button type="submit" style="margin:12px;" class="btn btn-primary">Add New Line Item to Prepared SO</button></form>';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

           /* $('#Cur').val(currency);
            //We have to set the original DivGrowth
          if(divg == 0 || divg == null)
            { divg = 6; }
          else { $('#Divs').val(divg); }
          */
      
          MainComp();
          

           
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

        function open_container(LID, rfq, divg, mst, qty, uom, uw, uc, ds, fp, hsc, hst, pp, ip, dw, wl, dly, mkper, ploch, mkdirect, frdirect, framt, mkamt, currency, doincoterm, applydoincoterm)
        {

      var Curren = '<?php echo $Curreny1; ?>';
      var uoms = '<?php echo $uom1; ?>';
      var SOCODE = '<?php echo $SOcode; ?>';
      var title = 'Edit line item for SO, LineItemID : '+LID + ' in RFQ No. : '+SOCODE;
      //alert(currency);

      var divGrowth = '<?php echo $RecDiv; ?>';
      ///We got get Description now
      var dataString = 'search='+ LID;
      var ItemD = '';
                  $.ajax({
                  type: "POST",
                  url: "searchSOLI.php",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     ItemD = html;
                     //alert(ItemD); 
                     document.getElementById('ItDes').innerHTML = ItemD;
                  }
                  });
            var size='large';
            var content = '<form role="form" method="post" action="uppoLineItem"><div class="form-group">' +
      '<label>Line Item\'s Description: </label>' +
            '<textarea required class="form-control" id="ItDes" name="ItDes" placeholder="" ></textarea>' +
            '<span class="glyphicon glyphicon-align-justify form-control-feedback"></span>' +
      '</div>' +
      
      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Currency: </label>'+
      '<select class="form-control" id="Cur" name="Cur">' + Curren + '</select>' +
      //'<input type="hidden" id="mCurrency" value="' + currency + '" />'+
      '<input type="hidden" name="SOCODE" value="' + SOCODE + '" />'+
      
      '</div>' +
      
      '<div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px;">' +
        '<label>Quantity of Item </label>' +
      '<input type="text" class="form-control" id="LIQty" name="LIQty" placeholder="Quantity" value="'+ qty +'" onInput="MainComp()" onKeyPress="return isNumber(event)"  />' +
      '</div>'+

      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Unit of Meas.: </label>'+
      '<select class="form-control" id="UOM" name="UOM">' + uoms + '</select>' +
      
      
      '</div>' +
      
      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Material No.: </label><input type="text" class="form-control" id="mart" name="mart" value="'+mst+'" ></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;" ><label>Unit Weight (Kg): </label><input type="text" class="form-control" id="UnitWeight" name="UnitWeight" value="'+uw+'" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      
      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Extended Weight (Kg): </label><input type="text" class="form-control" id="ExWeight" name="ExWeight" onKeyPress="return isNumber(event)" readonly  ></div>' +
      
      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Unit Cost: </label><input type="text" class="form-control" id="LIUC" name="LIUC" placeholder="Unit Cost" value="'+uc+'" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      
      '<input type="hidden" name="LIID" value="'+ LID +'" ></input>' +
      //'<input type="hidden" name="LIRFQ" value="'+ rfq +'" ></input>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Extended Cost: </label><input type="text" class="form-control" id="ExCost" name="ExCost" placeholder="Extended Cost" readonly ></div>' +
      
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Discount(%): </label><input type="text" class="form-control" value="'+ds+'" id="Disc" name="Disc" placeholder="Discount" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Discount Amt: </label><input type="text" class="form-control" id="DiscC" name="DiscC" placeholder="Disc. Amount" onKeyPress="return isNumber(event)" readonly></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>FOB: </label><input type="text" class="form-control" id="FOB" name="FOB" placeholder="ExPrice-Discount"  readonly ></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Packaging(% of FOB): </label><input type="text" class="form-control" id="PackP" value="'+pp+'" name="PackP" placeholder="Pkg %" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Packaging Amt: </label><input type="text" class="form-control" id="PackA" name="PackA" placeholder="Package Amount" onKeyPress="return isNumber(event)" readonly></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Insurance(% of FOB): </label><input type="text" class="form-control" id="InsurP" name="InsurP" value="'+ip+'" placeholder="Insurance %" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Insurance Amt: </label><input type="text" class="form-control" id="InsurA" name="InsurA" placeholder="Insurance Amount" onKeyPress="return isNumber(event)" readonly></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Freight Per Kg: <input type="checkbox" id="freightperchk" name="freightperchk" onclick="chngfpkg();" '+frdirect+' /></label><input type="text" title="Freight * ExWeight" class="form-control" id="FreightP" name="FreightP" value="'+fp+'" placeholder="Freight" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Freight Amt: </label><input type="text" class="form-control" id="FreightA" name="FreightA" placeholder="Freight Amount" value="'+framt+'" onInput="MainComp()" onKeyPress="return isNumber(event)" readonly></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>SubTotal, CIF: </label><input type="text" class="form-control" id="CIF" name="CIF" placeholder="SubTotal, CIF"  readonly></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>HS CODE: </label><input type="text" class="form-control" id="HSCODE" name="HSCODE" value="'+hsc+'" placeholder="HS CODE"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>HS Tariff %: </label><input type="text" class="form-control" id="HSTariff" value="'+hst+'" name="HSTariff" placeholder="HS Tariff %" onKeyPress="return isNumber(event)" onInput="MainComp()"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>CISS(1% FOB): </label><input type="text" class="form-control" id="PreShip" name="PreShip" placeholder="Custom Duty" readonly ></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Custom Duty: </label><input type="text" class="form-control" id="CustomDuty" name="CustomDuty" placeholder="Custom Duty" readonly ></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Custom Surcharge ( 7% of custom duty ): </label><input type="text" class="form-control" id="CusSub" name="CusSub" placeholder="Custom Surcharge" readonly></div>' +
       '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Custom Vat: <input type="checkbox" name="CusVat" id="CusVat" checked  onclick="MainComp()" /> </label><input type="text" title="5% of (CIF + Duty + Subcharge + CISS + ETLS)" class="form-control" id="CustomVat" name="CustomVat" onInput="MainComp()" placeholder="Custom Vat" onKeyPress="return isNumber(event)" readonly></div>' +
      

      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>ETLS Charge ( 0.5% of CIF ): </label><input type="text" class="form-control" id="ETLS" name="ETLS" placeholder="ETLS Charge" onKeyPress="return isNumber(event)" readonly></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Local Handling (% of CIF ): </label><input type="text" class="form-control" id="pLocHand" name="pLocHand" placeholder="Local Handling %" value = "'+ploch+'" onInput="MainComp()" onKeyPress="return isNumber(event)"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Local Handling Amt: </label><input type="text" class="form-control" id="LocHand" name="LocHand" placeholder="Local Handling" readonly ></div>' +
      
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Mark up (% of CIF): <input type="checkbox" id="markupchk" name="markupchk" onclick="chngmkup();" '+mkdirect+' /></label><input type="text" class="form-control" id="markupperc" name="markupperc" value="'+ mkper +'" placeholder="Mark up %" onInput="MainComp()" onKeyPress="return isNumber(event)"></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Mark up Amt: </label><input type="text" class="form-control" id="markupCos" name="markupCos" placeholder="Mark up" value="'+mkamt+'" readonly onInput="MainComp()" onKeyPress="return isNumber(event)"></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Local Cost: </label><input type="text" class="form-control" id="LocCos" name="LocCos" placeholder="Local Cost" readonly ></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Delivery Ex-Works: </label><input type="text" class="form-control" id="DEX" name="DEX" value="'+dw+'" placeholder="Delivery Ex-works" ></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Ex-Works Location: </label><input type="text" class="form-control" id="DEXL" name="DEXL" value="'+wl+'" placeholder="Delivery Ex-works Location" ></div>' +
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Delivery Cus. Location: </label><input type="text" class="form-control" id="DCUSL" name="DCUSL" value="'+dly+'" placeholder="Delivery Customers Location" ></div>' +
      
      '<div class="form-group" style="width:20%; display:inline-block; margin:12px;"><label>Discount on Total: <input type="checkbox" id="applyDONT" name="applyDONT" onclick="MainComp();" '+applydoincoterm+' /></label><input type="text" class="form-control" id="DONT" name="DONT" value="'+doincoterm+'" placeholder="Discount on incoterm" onInput="MainComp()" onKeyPress="return isNumber(event)" ></div>' +
      '<div class="form-group" style="width:20%; display: inline-block; margin:12px;"><label>Growth Engine: </label>'+
      '<select class="form-control" id="Divs" name="Divs">' + divGrowth + '</select>' +
      '</div>' +
      '<br />'+
    '<div class="form-group" style="width:43%; display:inline-block; margin:12px;"><label>DDP Price (CIF + Local Cost): </label><input type="text" class="form-control" id="DPPPrice" name="DPPPrice" placeholder="DDP Price" readonly ><input type="radio" name="qstate" value="1" checked></input> <br /> <label> Include NCD: <input type="checkbox" id="NCDchk" name="NCDchk" onclick="MainComp();" /></label></div>' +
      
      '<div class="form-group" style="width:63%; display:inline-block; margin:12px;"><label>Exworks Price (ExUnit Cost + Packaging + Markup): </label><input type="text" class="form-control" id="EXPPrice" name="EXPPrice" placeholder="Exworks Price" readonly ><input type="radio" name="qstate" value="2"></input></div>' +
      
      '<div class="form-group" style="width:63%; display:inline-block; margin:12px;"><label>CIF Price (CIF + Markup): </label><input type="text" class="form-control" id="CIFPPrice" name="CIFPPrice" placeholder="CIF Price" readonly ><input type="radio" name="qstate" value="3"></input></div>' +
      
      
      '<button type="submit" style="margin:12px;" class="btn btn-primary">Update Prepared SO Line Item</button></form>';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

            $('#Cur').val(currency);
            //We have to set the original DivGrowth
          if(divg == 0 || divg == null)
            { divg = 6; }
          else { $('#Divs').val(divg); }
      
          MainComp();
          

           
        }

       



         function MainComp()
     {

      /*var RmCurrency = document.getElementById('mCurrency').value;
      if (RmCurrency != "")
      {
        
        //Get select object
        var objSelect = document.getElementById("Cur");

        //Set selected
        setSelectedValue(objSelect, RmCurrency);

        function setSelectedValue(selectObj, valueToSet) 
        {
            for (var i = 0; i < selectObj.options.length; i++) 
            {
                if (selectObj.options[i].text == valueToSet) 
                {
                    selectObj.options[i].selected = true;
                    return;
                }
            }
         }
         document.getElementById('mCurrency').value = "";
      }*/
     

     var UnitCost = document.getElementById('LIUC').value;
     var ExCost = UnitCost * document.getElementById('LIQty').value;
     document.getElementById('ExCost').value = ExCost;
     //EEEEEEEE#####3333333
     var UnitWeight = document.getElementById('UnitWeight').value;
     var ExWeight = UnitWeight * document.getElementById('LIQty').value;
     document.getElementById('ExWeight').value = ExWeight;
     //TTTTTTT##### FOB HHHH
    var DiscoPer = document.getElementById('Disc').value;
    var ECost = document.getElementById('ExCost').value;
    var FOB1 = (DiscoPer * ECost)/ 100;
    var FOB = ECost - FOB1;
    document.getElementById('DiscC').value = FOB1;
    document.getElementById('FOB').value = FOB.toFixed(2);
    //KKKKKKKK PACKAGE ZZZZZZZZ
    var PackPer = document.getElementById('PackP').value;
    var FOBb = document.getElementById('FOB').value;
    var PackAmount = (PackPer * FOBb)/ 100;
    document.getElementById('PackA').value = PackAmount.toFixed(2);
    //KKKKK INSURANCE ZZZZZZ
    var InsurPer = document.getElementById('InsurP').value;
    var FOBb = document.getElementById('FOB').value;
    var InsurAmount = (InsurPer * FOBb)/ 100;
    document.getElementById('InsurA').value = InsurAmount.toFixed(2);
    document.getElementById('PreShip').value = ((1 * FOBb)/ 100).toFixed(2);
    
    //EEEEE FREIGHT HHHHHHHHHHH
    var FreightPer = document.getElementById('FreightP').value;
    var ExW = document.getElementById('ExWeight').value;
    var FreightAmount = FreightPer * ExW;
    if($('#freightperchk').is(":checked") == true)
    {
      
      document.getElementById('FreightA').value = FreightAmount.toFixed(2);

    }

    else
    {
      document.getElementById("FreightP").readOnly=true;
      document.getElementById("FreightA").readOnly=false;
      FreightAmount = Number(document.getElementById('FreightA').value);
    }
    // NNNN CIF, SUB TOTaL
    
    var CIF = (Number(FOB) + PackAmount + InsurAmount + FreightAmount);
    document.getElementById('CIF').value = CIF.toFixed(2);
    //HS Tariff Custom Duty
    var HS = document.getElementById('HSTariff').value
    
    var CusDuty = (CIF * HS)/100;
    var CusSub = (CusDuty * 7)/100;
    var ETLS = (CIF * 0.5)/100;
    var CusVat = ((CIF + ((1 * FOBb)/ 100) + CusDuty + CusSub + ETLS) * 5)/100;
    var LocHand = (CIF * document.getElementById('pLocHand').value)/100;
    if($('#markupchk').is(":checked") == true)
    {
      var markupCos = (CIF * document.getElementById('markupperc').value)/100; 
      document.getElementById('markupCos').value = markupCos.toFixed(2);
    }

    else
    {
       document.getElementById("markupperc").readOnly=true;
      document.getElementById("markupCos").readOnly=false;
    }
    
    
    
    document.getElementById('CustomDuty').value = CusDuty.toFixed(2);
    //document.getElementById('markupCos').value = markupCos.toFixed(2);
    document.getElementById('CusSub').value = CusSub.toFixed(2);
    
    document.getElementById('ETLS').value = ETLS.toFixed(2);
    document.getElementById('LocHand').value = LocHand.toFixed(2);
    
    //To get Local Cost
    //To get Local Cost
    var nCusVat = 0;
    if($('#CusVat').is(":checked") == true)
    {
    document.getElementById('CustomVat').value = CusVat.toFixed(2);
     nCusVat = Number(document.getElementById('CustomVat').value);
      document.getElementById("CustomVat").readOnly=true;
       
    }

    else
    {
      //document.getElementById('CustomVat').value = 0;
       document.getElementById("CustomVat").readOnly=false;
      nCusVat = Number(document.getElementById('CustomVat').value);
    }
    var preship = Number(document.getElementById('PreShip').value);
    var cusdty = Number(document.getElementById('CustomDuty').value);
    var cussubch = Number(document.getElementById('CusSub').value);
    var etls = Number(document.getElementById('ETLS').value);
    var markpval = Number(document.getElementById('markupCos').value);
    var localhndle = Number(document.getElementById('LocHand').value);
    var LocCost = preship + cusdty + cussubch + etls + markpval + localhndle + nCusVat; 
    document.getElementById('LocCos').value = LocCost.toFixed(2);
    
    //Let's Get Price of Discount on Overall
    var DONT = Number(document.getElementById('DONT').value);
    //Let's check if you want to apply DONT
    var applyDONT = 0;
    if($('#applyDONT').is(":checked") == true)
    {
      applyDONT = 1;

    }

    
    //To get DPP cost
    //To get DPP cost
   var DPPprice = LocCost + CIF;
    if($('#NCDchk').is(":checked") == true)
    {

       var nDPPprice = ( 1 * DPPprice)/100; 
       DPPprice = Number(nDPPprice.toFixed(2)) + Number(DPPprice.toFixed(2))
       if(applyDONT == 1){DPPprice = DPPprice - DONT;}
       document.getElementById('DPPPrice').value = DPPprice.toFixed(2);

    }
    else
    {
       if(applyDONT == 1){DPPprice = DPPprice - DONT;}
       document.getElementById('DPPPrice').value = DPPprice.toFixed(2);

    }

    var EXPPrice = 0;
       if(applyDONT == 1){EXPPrice = ExCost + PackAmount + markpval - DONT;} else {EXPPrice = ExCost + PackAmount + markpval;}

    var CIFPPrice = 0;
       if(applyDONT == 1){CIFPPrice = CIF + markpval - DONT;} else {CIFPPrice = CIF + markpval;}

    //document.getElementById('DPPPrice').value = DPPprice.toFixed(2);
    document.getElementById('EXPPrice').value = EXPPrice.toFixed(2);
    document.getElementById('CIFPPrice').value = CIFPPrice.toFixed(2);
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
  var DivsID = $(elem).attr("divs"); 
  var Discount = $(elem).attr("disct");
  var Curren = '<?php echo $Curreny1; ?>';
  var uoms = '<?php echo $uom1; ?>';
  var divGrowth = '<?php echo $RecDiv; ?>';
  //var UnitCost = $(elem).attr("urate");
  //alert(soCurrn);
  //var dataString = 'litem='+ LinIT;

            var size='large';
            var content = '<form role="form" action="updateSO" method="POST" ><div class="form-group">' +
             '<input type="hidden" value="'+ LinIT +'" id="LitIDm" name="LitIDm" />'+
             '<input type="hidden" value="'+ smSO +'" id="smSO" name="smSO" />'+
             '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label><textarea class="form-control" id="EditDes" name="EditDes" placeholder="Description">'+Descr+'</textarea></div>' +
             '<div class="form-group" style="width:100%; display: inline-block;"><label>Remark/Tech. Spec.: </label><textarea class="form-control" id="EditRemark" name="EditRemark" placeholder="Remark/Technical Specification">'+Rmark+'</textarea></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Due Date: </label><input type="text" class="form-control" style="z-index: 100000;" id="EditDueDate" name="EditDueDate" placeholder="Due Date" value="'+DDate+'" required readonly ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Quantity: </label><input type="text" class="form-control" id="EditQty" name="EditQty" placeholder="Quantity" onInput="compute()" value="'+Qty+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Unit Cost: </label><input type="text" class="form-control" id="EditUnitRate" name="EditUnitRate" placeholder="Unit Rate" onInput="compute()" value="'+UnitCost+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Discount %: </label><input type="text" class="form-control" id="EditDisc" name="EditDisc" placeholder="Discount" onInput="compute()" value="'+Discount+'" onKeyPress="return isNumber(event)"  ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Amount: </label><input type="text" class="form-control" id="EditAmt" name="EditAmt" placeholder="Amount" onInput="compute()" value="'+POAmt+'" onKeyPress="return isNumber(event)" readonly ></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Per (UOM): </label><select class="form-control" id="EditPer" name="EditPer" onInput="compute()">'+uoms+'</select></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px"><label>Currency: </label><select class="form-control" id="EditCurr" name="EditCurr" onInput="compute()">'+Curren+'</select></div>' +
              '<div class="form-group" style="width:40%; display: inline-block; margin: 6px;"><label>Growth Engine: </label>'+
              '<select class="form-control" id="Divs" name="Divs">' + divGrowth + '</select>' +
              '</div>' +
              '<button type="submit" class="btn btn-primary">Update</button></form>';
            var title = 'Edit Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

            $('#EditDueDate').datepicker();
            $("#EditPer").val(UOM).change();
            $("#EditCurr").val(soCurrn).change();
            //We have to set the original DivGrowth
          if(DivsID == 0 || DivsID == null)
            { DivsID = 6; }
          $('#Divs').val(DivsID);
}


function deleteLIT(elem)
{
  var LinIT = $(elem).attr("litid");
  var smSO = $(elem).attr("smso");
  
  var Descr = $(elem).attr("descr");
  
  var DivsID = $(elem).attr("divs"); 
 
  //var UnitCost = $(elem).attr("urate");
  //alert(soCurrn);
  //var dataString = 'litem='+ LinIT;

            var size='large';
            var content = '<form role="form" action="removeSOLi" method="POST" ><div class="form-group">' +
             '<input type="hidden" value="'+ LinIT +'" id="LitIDm" name="LitIDm" />'+
             '<input type="hidden" value="'+ smSO +'" id="smSO" name="smSO" />'+
             '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label>  <span>'+Descr+'</span></div>' +
             
              '<button type="submit" class="btn btn-danger">Delete</button></form>';
            var title = 'Delete Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

            $('#EditDueDate').datepicker();
            $("#EditPer").val(UOM).change();
            $("#EditCurr").val(soCurrn).change();
            //We have to set the original DivGrowth
          if(DivsID == 0 || DivsID == null)
            { DivsID = 6; }
          $('#Divs').val(DivsID);
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
    $DivG = $row['Division'];
    $Description = $row ['Description'];
    $Qty = $row ['Qty'];
    $UOM = $row ['UOM'];
    $RFQn = $row ['RFQCode'];
    //$SOCoden = $row ['SOCode'];
    $Price = $row ['UnitDDPrice'];
    $Currency = $row ['Currency'];
    $UnitWeight = $row ['UnitWeight'];
    $UnitCost = $row ['UnitCost'];
    $UnitCost = $UnitCost;
    $Discount = $row ['Discount'];
    $FreightPercent = $row ['FreightPercent'];
    $HScode = $row ['HScode'];
    $HsTarrif = $row ['HsTarrif'];
    $PackingPercent = $row ['PackingPercent'];
    $InsurePercent = $row ['InsurePercent'];
    $DeliveryToWrkLocation = $row ['DeliveryToWrkLocation'];
     $pLocalHandling = $row ['pLocalHandling'];
     $ExCost = $row ['ExtendedCost'];
     $ExCost = number_format($ExCost);
    //$FOBExWorks = $row ['FOBExWorks'];
    $DELIVERY = $row ['DELIVERY'];
    $WorkLocation = $row ['WorkLocation'];
    $ExPrice = $Price * $Qty;
    $ExPrice = $ExPrice;
    $Statu = $row ['Status'];
    $Discount = $row ['Discount'];
    $Price = $ExPrice - (($ExPrice * $Discount)/100);
    
    $Price1 = number_format($Price);
    $Currency = $row ['Currency'];
    $SOn = $row ['SOCode'];
    $EditSO = '<i style="cursor:pointer; color:green" class="fa fa-edit" divs="'.$DivG.'" curr="'.$soCurrn.'" disct="'.$Discount.'" ddate="'.$DDate.'" descr="'.$Description.'" qty="'.$Qty.'" rmk="'.$Remark.'" urate="'.$UnitCost.'" poamt="'.$Price.'" uom="'.$UOM.'" smso="'.$SOn.'" litid="'.$LitID.'" onclick="editLIT(this);"></i>';
    $DeleteSO = '<i style="cursor:pointer; color:red" class="fa fa-trash" divs="'.$DivG.'" curr="'.$soCurrn.'" disct="'.$Discount.'" ddate="'.$DDate.'" descr="'.$Description.'" qty="'.$Qty.'" rmk="'.$Remark.'" urate="'.$UnitCost.'" poamt="'.$Price.'" uom="'.$UOM.'" smso="'.$SOn.'" litid="'.$LitID.'" onclick="deleteLIT(this);"></i>';
    //<td>'.$EditSO.'</td>
      $Record .='
           <tr>
              <td>'.$SN.'</td>
              <td>'.$LitID.'</td>
            <td>'.$MatSer.'</td>
            <td>'.$Description.'</td>
            <td>'.$Qty.'</td>
            <td>'.$UOM.'</td>
            <td>'.$Discount.'</td>
            <td>'.$ExCost.'</td>
            <td><a '.  'onclick="open_container('.$LitID.',\''.$RFQn.'\',\''.$DivG.'\',\''.$MatSer.'\',\''.$Qty.'\',\''.$UOM.'\',\''.$UnitWeight.'\',\''.$UnitCost.'\',\''.$Discount.'\',\''.$FreightPercent.'\',\''.$HScode.'\',\''.$HsTarrif.'\',\''.$PackingPercent.'\',\''.$InsurePercent.'\',\''.$DeliveryToWrkLocation.'\',\''.$WorkLocation.'\',\''.$DELIVERY.'\',\''.$markupperc.'\',\''.$pLocalHandling.'\',\''.$MarkUpDirect.'\',\''.$FreightDirect.'\',\''.$FreightAmt.'\',\''.$MarkUpAmt.'\',\''.$Currency.'\',\''.$doincoterm.'\',\''.$applydoincoterm.'\' );">'. '<span class="fa fa-eye"></span></a></td>
            <td>'.$DeleteSO.'</td>
             </tr>';
    $SN = $SN + 1;        
     }
}


?>  
          <div class="row">
            <div class="col-md-12">
             
              <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title">SO Line Items <i onclick="addLitem()" class="fa fa-plus"></i></h3>
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
                        <th>Delete</th>
                        
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
    <script src="../mBOOT/jQuery.print.js" type="text/javascript"></script>
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