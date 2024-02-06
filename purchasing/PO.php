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
if (!$_GET['sSO']) {
 $resultLI = mysql_query("SELECT * FROM purchaselineitems ORDER BY LitID DESC LIMIT 10"); //WHERE Status='OPEN'
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
}
else if ($_GET['sSO'] == 'ALL') {
 $resultLI = mysql_query("SELECT * FROM purchaselineitems ORDER BY LitID DESC"); //WHERE Status='OPEN'
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

$resultRFQ1 = mysql_query("SELECT * FROM so");
$NoRowRFQ1 = mysql_num_rows($resultRFQ1);

$resultpor1 = mysql_query("SELECT DISTINCT RequestID FROM poreq");
$NoRowpor1 = mysql_num_rows($resultpor1);
/////////////////////////////////////////////////////////////////////////////////////

 $resultPOREQ = mysql_query("SELECT * FROM poreq WHERE Approved='1' AND Status = '0' ");
//check if user exist
 $NoRowPOREQ = mysql_num_rows($resultPOREQ);
 

 $resultSUP1 = mysql_query("SELECT * FROM suppliers ORDER BY SupNme");
 $NoRowSUP1 = mysql_num_rows($resultSUP1);
 //////////////////////////////////////////////////////////
$SupRecord = "";
  if ($NoRowSUP1 > 0) {
  while ($row = mysql_fetch_array($resultSUP1)) {
    $SupRNme = $row['SupNme'];
    $SupID = $row['supid'];
    $SupRecord .='<option value="'.$SupRNme.'">'.$SupRNme.'</option>';
            
     }
   }  



 
?>
<!DOCTYPE html>
<html>
<?php include('../header2.php') ?>
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
            Raise PO
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Raise PO</li>
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
      <form>
   <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
        <select class="form-control" id="LIRFQ" name="LIRFQ" onChange="ReadLineItem(this)">
      <option value=""> Choose SO code</option>
      <option value="ALL"> ALL Items</option>
      <?php if ($NoRowpor1 > 0) 
            {
              //fetch tha data from the database $resultpor1
              while ($row = mysql_fetch_array($resultpor1)) {
              
              ?>
              <option value="<?php echo $row['RequestID']; ?>"  <?php if ($_GET['sSO'] == $row['RequestID']) { echo "selected";} ?>> <?php echo $row['RequestID']; ?></option>
              <?php
              }
              
            }

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
   

<div class="form-group has-feedback" style="width:18%; display: inline-block; margin:12px;">
            <span class="search">
            <input style="width:100%" type="text" class="form-control1  " id="RFQ" name="RFQ" placeholder="SO Code Search..." onInput="searchrfq(this)" />
      
       <ul class="results" id="resultRFQ" >
        
       </ul>
    </span> 
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
                  <h3 class="box-title">Raise Purchase Order</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#00CC99; margin: 12px; width:60%;">
                      <p class="text-center">
                        <strong></strong>
                      </p>
                     <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="regPO" method="post">
           <div class="form-group has-feedback" style="width:40%; display: inline-block;">
        <label>Supplier :</label>
        <select class="form-control" id="POSup" name="POSup" onChange="MakePO(this)"required >
      <option value=""> Choose Supplier</option>
      <?php
      echo $SupRecord;
      ?>
                  
      </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>
     
     
      <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
      <label>Order Date :</label>
      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
             <input type="text" class="form-control" id="PODate" name="PODate" onChange="AddReq(this)" onClick="AddReq(this)" />
      
          </div>
    <div class="form-group has-feedback" style="width:83%; display: inline-block; ">
      <p class="text-center">
      <br/>
      <br/>
      
                        <strong>Delivery Location :</strong>
                      </p>
       <textarea rows="4" cols="50" placeholder="Delivery Location" id="DeliLoc" name="DeliLoc" style="width:100%;"> </textarea>
     </div>
      
     
      
    
<script>
function MakePO(elem)
    {
       var hhh = elem.value;
  var hhhy = hhh.substring(0,2); 
     var oldRFQ =  document.fRFQ.PONo.value;
   if (oldRFQ.indexOf("_") > -1)
  // {  var n = oldRFQ.length - 4;
   {  var n = oldRFQ.indexOf("_");
    var oldRFQ1 = oldRFQ.substring(0,n);
    document.fRFQ.PONo.value = oldRFQ1 + "_" + hhhy + "_" + document.fRFQ.PODate.value;
   }
   else
   {document.fRFQ.PONo.value = oldRFQ + "_" + hhhy + "_" + document.fRFQ.PODate.value;}
   
    } 
</script> 
<script>
function AddReq(elem)
    {
       var hhh = elem.value;
  //var hhhy = hhh.substring(0,2); 
     var oldRFQ =  document.fRFQ.PONo.value;
   if (oldRFQ.indexOf("_") > -1)
  // {  var n = oldRFQ.length - 4;
   {  
      var S = oldRFQ.split(/_/);
    var PEN = S[0];
    document.fRFQ.PONo.value = PEN + "_" + S[1] + "_" + document.fRFQ.PODate.value.trim();
   }
   else
   {//DO NOTHING
   }
   
    } 
</script> 

     
      
    
       
    

    <!-- <p class="text-center">
                        <strong>Attach Customer's PO Document (Optional)</strong>
                      </p>
      <div class="form-group has-feedback" style="width:83%;">
            <input type="file" id="SOFile" name="SOFile" class="form-control" />
      
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>   -->
                </div><!-- /.col -->
                    <div class="col-md-4">
                      
      
      <!--<p class="text-center">
                        <strong>Purchase Order No.:</strong>
                      </p>-->
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="PONo" name="PONo" placeholder="PO Number" value="PO<?php $NoRowPO = $NoRowPO + 1; 
      echo substr($_SESSION['SurName'],0,1).substr($_SESSION['Firstname'],0,1).$NoRowPO."/". date("y")  ; ?>" required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
<br>
 <!--<p class="text-center">
                        <strong>Sub Total:</strong>
                      </p> -->
<div class="form-group has-feedback" style="width:100%; display: none;">
            <input type="text" class="form-control" id="SubTotal" name="SubTotal"  Value="" ReadOnly />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
      <br/>
<!--<p class="text-center">
                        <strong>Discount:</strong>
                      </p>-->
<div class="form-group has-feedback" style="width:100%; display: none;">
            <input type="text" class="form-control" id="pTax" name="pTax"  onInput="document.fRFQ.sTax.value = ((document.fRFQ.SubTotal.value * document.fRFQ.pTax.value)/100);" onKeyPress="return isNumber(event)" Placeholder ="Discount Percentage (%)"  />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
</div>
<div class="form-group has-feedback" style="width:100%; display: none;">
            <input type="text" class="form-control" id="sTax" name="sTax"  Value="" ReadOnly  />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
</div>
      <br/>
      
     <p class="text-center">
                        <strong>Total:</strong>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="sTotal" name="sTotal" Value="" ReadOnly />
            <input type="hidden" id="rTotal" name="rTotal" />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
      <br/>
      
            
          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Create Purchasing Order</button>
              </div><!-- /.col -->
          </div>
                     
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
  
  
  <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Line Item to PO</h3>
         
          
    

                  <div class="box-tools pull-right">
                   <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
    
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
    window.location.href ="PO?sSO=" + hhh;
    //window.alert("JKJ");
     }
  
    } 
</script>

<?php
//fetch tha data from the database
 $SN = 1;
   if ($NoRowLI > 0) {
  while ($row = mysql_fetch_array($resultLI)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
    $LitID = $row{'LitID'};
    $MatSer = $row['MatSer'];
    $Description = $row ['Description'];
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
    $ToWH = '<input type="checkbox" title="straight to Warehouse" value="'. $LitID.'" onClick="WHPerf(this)"></input>';
    $PO = '<input type="checkbox" title="add to PO" id="item-'.$LitID.'" name="poli_cap[]" totp="'.$Price.'" value="'.$Description. '@&@'. $LitID.'@&@'.$Price.'@&@'.$Qty.'@&@'.$UOM.'@&@'.$MatSer.'@&@'.$Discount.'@&@'.$UnitCost.'@&@'.$DDate.'@&@'.$SOn.'@&@WH0" OnClick="CPEXPerf(this)"></input>';
      $Record .='
           <tr>
              <td>'.$SN.'</td>
              <td>'.$LitID.'</td>
            <td>'.$MatSer.'</td>
            <td>'.$Description.'</td>
            <td>'.$Qty.'</td>
            <td>'.$Discount.'</td>
            <td>'.$Price1.'</td>
            <td>'.$PO.'</td>
            <td>'.$ToWH.'</td>
             </tr>';
    $SN = $SN + 1;        
     }
}


?>  

              <div class="box">
                <div class="box-header">
                 
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
                        <th>Discount</th>
                        <th>ExCost</th>
                        <th>addToPO</th>
                        
                        <!--<th>To WH</th>-->

                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
    
    
     </form> 
    
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
   <script type="text/javascript">
   //Date Picker
      $(function () {
     //$('#DOB').datetimepicker();
     $("#PODate").datepicker({
  inline: true,
  minDate: new Date()
});
       
      });
    </script>
    <script type="text/javascript">
  function WHPerf(evt) 
      {
        var WHID = $(evt).val();
        var ItemV = $('#item-'+ WHID).val();
        

        if($(evt).is(':checked'))
        {
          ItemV = ItemV.replace("@WH0", "@WH1");
        }
        else
        {
         ItemV = ItemV.replace("@WH1", "@WH0");
        }
        
        $('#item-'+ WHID).val(ItemV);
        //alert(ItemV);
      }

  </script>
    <script type="text/javascript">
      $(function () {
        $("#userTab").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
  

    function CPEXPerf(evt) {
var roughval = evt.value.split("@&@");
var intAmount = $(evt).attr("totp");//roughval[2];
//alert(intAmount);
 
      {
        var v1=document.getElementById("pTax");
       // v1.setAttribute("readOnly","true");
      }

//var intAmount = evt.value;
var oldAmount = document.fRFQ.SubTotal.value;
 if (evt.checked == true)
{

//document.getElementById('').innerHTML = Number(oldAmount) + Number(intAmount);
document.fRFQ.SubTotal.value = Number(oldAmount) + Number(intAmount);
document.fRFQ.sTax.value = ((document.fRFQ.SubTotal.value * document.fRFQ.pTax.value)/100);
document.fRFQ.sTotal.value = Number(Number(document.fRFQ.SubTotal.value) - Number(document.fRFQ.sTax.value)).toLocaleString('en');
document.fRFQ.rTotal.value = Number(Number(document.fRFQ.SubTotal.value) - Number(document.fRFQ.sTax.value));

//document.fRFQ.total1.value = Number(oldAmount) + Number(intAmount);
//document.fRFQ.tp.value = Number(oldAmount) + Number(intAmount);
}
if (evt.checked == false)
{
document.fRFQ.SubTotal.value = Number(oldAmount) - Number(intAmount);
document.fRFQ.sTax.value = Number((document.fRFQ.SubTotal.value * document.fRFQ.pTax.value)/100).toLocaleString('en');
document.fRFQ.sTotal.value = Number(Number(document.fRFQ.SubTotal.value) - Number(document.fRFQ.sTax.value)).toLocaleString('en');

//document.fRFQ.total1.value = Number(oldAmount) - Number(intAmount);
//document.fRFQ.tp.value = Number(oldAmount) - Number(intAmount);
 var CAPEXsum = document.getElementById("sTotal").value;
      if (CAPEXsum == "0" || CAPEXsum == "NaN")
      {
     // document.fRFQ.SubTotal.value = "0";
  
      //var v1=document.getElementById("pTax");
     $("#pTax").removeAttr("readonly");

      }
      else
      {
        var v1=document.getElementById("pTax");
        //v1.setAttribute("readOnly","true");
      }
}
    var CAPEXsum = document.fRFQ.SubTotal.value;
  if (CAPEXsum == "0" || CAPEXsum == "NaN")
  {
  document.fRFQ.SubTotal.value = "0";
 
  
  }
} 
    </script>
  
  
  </body>
</html>