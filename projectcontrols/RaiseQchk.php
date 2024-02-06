<?php
session_start();
error_reporting(0);
include('route.php');

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';

 //Business Year
$BYr = $_SESSION['BusinessYear']; 

  //Let's get the Division
 $RecDiv = "";
 $resultDiv = mysql_query("SELECT * FROM businessunit ORDER BY BussinessUnit");
 $NoRowDiv= mysql_num_rows($resultDiv);


//Read SOCount
$SOcount = mysql_query("SELECT * FROM sysvar WHERE variableName = 'SOCount'");
while ($row = mysql_fetch_array($SOcount)) {
              $nSOCount = $row{'variableValue'};
             
              }

$nSOCount = str_pad($nSOCount, 4, "0", STR_PAD_LEFT);
$resultRFQ = mysql_query("SELECT * FROM rfq");
//check if user exist
 $NoRowRFQ = mysql_num_rows($resultRFQ);
 
 $resultPO = mysql_query("SELECT * FROM po");
//check if user exist
 $NoRowPO = mysql_num_rows($resultPO);

 $resultRFQ1 = mysql_query("SELECT * FROM rfq WHERE Status='OPEN'");
//check if user exist
 $NoRowRFQ1 = mysql_num_rows($resultRFQ1);
 
$resultCUS = mysql_query("SELECT * FROM customers");
//check if user exist
 $NoRowCUS = mysql_num_rows($resultCUS);

//Let's get the Attachemtn here
 $resultatt = mysql_query("SELECT * FROM rfq WHERE RFQNum='".$_GET['sRFQ']."'");
 $NoRowatt= mysql_num_rows($resultatt);
 if ($NoRowatt > 0) {
  while ($row = mysql_fetch_array($resultatt)) 
  {
    $Attachlnk = $row ['Attachment'];
  }
 }
/*$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);
 if ($NoRow > 0) {
	while ($row = mysql_fetch_array($result)) {
	  $StaffID = $row['StaffID'];
	  $StaffNme = $row['Firstname'];
	  $StaffSur = $row['Surname'];
	  $StaffRecord .='<option value='.$StaffID.'">'.$StaffSur. ' '.$StaffNme. ' - '.$StaffID.'</option>';
						
     }
	 }	
 */
   if($_GET['sRFQ'] != "ALL")
   {
 $resultLI = mysql_query("SELECT * FROM polineitems WHERE ProjectControl='1' AND CreateSO='1' AND RFQCode='".$_GET['sRFQ']."'");
}
else
{
 $resultLI = mysql_query("SELECT * FROM polineitems WHERE ProjectControl='1' AND CreateSO='1'");
}
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
 

 $resultCus1 = mysql_query("SELECT * FROM customers");
 $NoRowCUS1 = mysql_num_rows($resultCus1);
 //////////////////////////////////////////////////////////
$CusRecord = "";
  if ($NoRowCUS1 > 0) {
	while ($row = mysql_fetch_array($resultCus1)) {
	  $CusRNme = $row['CustormerNme'];
	  $CusSNme = $row['cussnme'];
	  $CusRecord .='<option value="'.$CusSNme.'">'.$CusRNme.'</option>';
						
     }
	 }

  

?>
<!DOCTYPE html>
<html>
<?php include('../header2.php') ?>

  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <?php include('../topmenu2.php') ?>
            <!-- Left side column. contains the logo and sidebar -->
       <?php include('leftmenu.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Raise SO
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Raise SO</li>
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
      <option value=""> Choose RFQ code</option>
      <option value="ALL"> ALL Unattended Items</option>
      <?php if ($NoRowRFQ1 > 0) 
            {
              //fetch tha data from the database
              while ($row = mysql_fetch_array($resultRFQ1)) {
              
              ?>
              <option value="<?php echo $row['RFQNum']; ?>"  <?php if ($_GET['sRFQ'] == $row['RFQNum']) { echo "selected";} ?>> <?php echo $row['RFQNum']; ?></option>
              <?php
              }
              
            }
                                
      ?>
                  
      </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>
   

<div class="form-group has-feedback" style="width:18%; display: inline-block; margin:12px;">
            <span class="search">
            <input style="width:100%" type="text" class="form-control1  " id="RFQ" name="RFQ" placeholder="RFQ Code Search..." onInput="searchrfq(this)" />
      
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
window.location.href = "RaiseQchk?sRFQ=" + uval;
}
</script>

    <div class="form-group has-feedback" style="width:20%; display: inline-block; margin:12px; ">
                  
                  <a href="<?php echo $Attachlnk; ?>" <i class="fa fa-eye" ></i> View Attachment </a>
   
    </div>
    
      </form>
        </div>
  
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Raise Sales Order</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#00CC99; margin: 12px; width:60%;">
                      <p class="text-center">
                        <strong></strong>
                      </p>
                     <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="regSO" method="POST">
           <div class="form-group has-feedback" style="width:40%; display: inline-block;">
		    <label>Customer :</label>
		    <select class="form-control" id="SOCus" name="SOCus" onChange="MakePO()"required >
			<option value=""> Choose Customer</option>
			<?php
			echo $CusRecord;
			?>
									
			</select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>
		 
		 
		  <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
		  <label>Order Date :</label>
		  <span class="glyphicon glyphicon-calender form-control-feedback"></span>
             <input type="text" class="form-control" id="SODate" name="SODate" required />
			
          </div>
      <div class="form-group has-feedback" style="width:40%; display: inline-block;">
      <label>Customer's Order No.:</label>
      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
             <input type="text" class="form-control" id="CusONo" name="CusONo" onInput="MakePO();" required />
      
          </div>
		  
		 <!--  <div class="form-group has-feedback" style="width:82%; display: inline-block;">
		  <center>  <label><<< Assgin Staff >>></label> </center>
		    <select class="form-control" id="POSupSt" name="POSupSt" required >
			<option value=""> Select Staff</option>
			<?php
			echo $StaffRecord;
			?>
									
			</select> 
          </div> -->
		  
		
<script>
function MakePO()
    {
       
       var CustomerSO = $('#SOCus').val();
       var CusONo = $('#CusONo').val();
        //Let's set the value now
        var NmeAbbr = "<?php echo substr($_SESSION['SurName'],0,1).substr($_SESSION['Firstname'],0,1) ?>";
        var SOSN = "<?php echo $nSOCount; ?>";
        var PresentYr = '<?php echo date("y") ?>';
        var soVal = "SO_" + NmeAbbr + "_" + SOSN + "/" + PresentYr + "_" + CustomerSO + "_" + CusONo;
       //alert(soVal);
       $('#SONo').val(soVal);
       //SO_<?php $NoRowPO = $NoRowPO + 1; 
      //echo substr($_SESSION['SurName'],0,1).substr($_SESSION['Firstname'],0,1)."_".$NoRowPO."/". date("y"); ?>

	/*var hhhy = hhh.substring(0,2); 
     var oldRFQ =  document.fRFQ.SONo.value;
	 if (oldRFQ.indexOf("_") > -1)
	// {  var n = oldRFQ.length - 4;
	 {  var n = oldRFQ.indexOf("_");
		var oldRFQ1 = oldRFQ.substring(0,n);
		document.fRFQ.SONo.value = oldRFQ1 + "_" + hhhy + "_" + document.fRFQ.SODate.value;
	 }
	 else
	 {document.fRFQ.SONo.value = oldRFQ + "_" + hhhy + "_" + document.fRFQ.SODate.value;}
	 */
    }	
</script>	
<script>
function AddReq(elem)
    {
       var hhh = elem.value;
	//var hhhy = hhh.substring(0,2); 
     var oldRFQ =  document.fRFQ.SONo.value;
	 if (oldRFQ.indexOf("_") > -1)
	// {  var n = oldRFQ.length - 4;
	 {  
	     S = oldRFQ.split(/_/);
		var PEN = S[0];
		document.fRFQ.SONo.value = PEN + "_" + S[1] + "_" + document.fRFQ.SODate.value.trim();
	 }
	 else
	 {//DO NOTHING
	 }
	 
    }	
</script>	

		 
		  
		  <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
      <label>Delivery Location :</label>
      <span class="glyphicon glyphicon-calender form-control-feedback"></span>
             <input type="text" class="form-control" id="DeliLoc" name="DeliLoc" />
      
      </div>
		    <div class="form-group has-feedback" style="width:40%; display: inline-block; ">
           <label>Choose Growth Engine :</label>
            <select class="form-control" id="SODiv" name="SODiv" required >
          <?php  if ($NoRowDiv > 0) {
                while ($row = mysql_fetch_array($resultDiv)) 
                {
                  $DivID = $row['id'];
                  $DivName = $row['BussinessUnit'];
                  echo '<option value="'.$DivID.'" selected >'.$DivName.'</option>';
                  
                }
               } 
          ?>
        </select>
        </div>
        <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
           <label>Choose SO Type :</label>
            <select class="form-control" id="SOType" name="SOType" required >
            <option value=""> Choose SO Type</option>
            <option value="1"> MRO SO</option>
            <option value="2"> EPC SO</option>
            
            </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
        </div>
		 <div class="form-group has-feedback" style="width:83%; display: inline-block; ">
     </br>
		  <p class="text-center">
		  
		  
                        <strong>Remark :</strong>
                      </p>
		   <textarea rows="4" cols="50" placeholder="Enter note for sales order here..." id="Remark" name="Remark" style="width:100%;"></textarea>
		 </div>

     <p class="text-center">
                        <strong>Attach Customer's PO Document (Optional)</strong>
                      </p>
      <div class="form-group has-feedback" style="width:83%;">
            <input type="file" id="SOFile" name="SOFile" class="form-control" />
      
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>  
		            </div><!-- /.col -->
                    <div class="col-md-4">
                      
			
		  <p class="text-center">
                        <strong>Sale Order No.:</strong>
                        <label> (Reverse SO) <input type="checkbox" name="rev" value="rev" /></label>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="SONo" name="SONo" placeholder="SO Number" Value="SO_<?php $NoRowPO = $NoRowPO + 1; 
			echo substr($_SESSION['SurName'],0,1).substr($_SESSION['Firstname'],0,1)."_".$nSOCount."/". date("y"); ?>"  required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
<br>
 <p class="text-center">
                        <strong>Sub Total:</strong>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="SubTotal" name="SubTotal"  Value="" ReadOnly />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
		  <br/>
<p class="text-center">
                        <strong>Tax:</strong>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="pTax" name="pTax"  onInput="document.fRFQ.sTax.value = ((document.fRFQ.SubTotal.value * document.fRFQ.pTax.value)/100);" onKeyPress="return isNumber(event)" Placeholder ="Tax Percentage"  />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
</div>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="sTax" name="sTax"  Value="" ReadOnly  />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
</div>
		  <br/>
		  
		 <p class="text-center">
                        <strong>Total:</strong>
                      </p>
<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="sTotal" name="sTotal" Value="" ReadOnly />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
		  <br/>
			
					  
          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Create Sales Order</button>
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
                  <h3 class="box-title">Add Line Item to SO</h3>
				 
				  
    

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
		window.location.href ="RaiseQchk?sRFQ=" + hhh;
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
	  $Price = $row ['ExtendedCost'];
    $Price1 = number_format($Price, 2);
	  $Currency = $row ['Currency'];
	  $RFQn = $row ['RFQCode'];
	  $PO = '<input type="checkbox" name="poli_cap[]" value="'.$Description. '@&@'. $LitID.'@&@'.$Price.'@&@'.$Qty.'@&@'.$UOM.'" OnClick="CPEXPerf(this)"></input>';
	    $Record .='
					 <tr>
					    <td>'.$SN.'</td>
					    <td>'.$LitID.'</td>
						<td>'.$MatSer.'</td>
						<td>'.$Description.'</td>
						<td>'.$Qty.'</td>
						<td>'.$Price1.'</td>
						<td>'.$PO.'</td>
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
                        <th>ExCost</th>
                       
                       
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>S/N</th>
                        <th>Item ID</th>
                        <th>Mat</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>ExCost</th>
                      
						
                       
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
	<!--	<input type="hidden" value="GHFG" name="Jack" /> -->
		
		 </form> 
		
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  

     <?php include('../footer.php') ?>

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
	   $("#SODate").datepicker({
	inline: true,
	minDate: new Date()
});
       
      });
    </script>
  
    <script type="text/javascript">
      $(function () {
       // $("#userTab").dataTable();
        $('#userTab').dataTable({
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
var intAmount = roughval[2];

 
      {
        var v1=document.getElementById("pTax");
        v1.setAttribute("readOnly","true");
      }

//var intAmount = evt.value;
var oldAmount = document.fRFQ.SubTotal.value;
 if (evt.checked == true)
{

//document.getElementById('').innerHTML = Number(oldAmount) + Number(intAmount);
document.fRFQ.SubTotal.value = Number(oldAmount) + Number(intAmount);
document.fRFQ.sTax.value = ((document.fRFQ.SubTotal.value * document.fRFQ.pTax.value)/100);
document.fRFQ.sTotal.value = Number(Number(document.fRFQ.SubTotal.value) + Number(document.fRFQ.sTax.value)).toLocaleString('en');

//document.fRFQ.total1.value = Number(oldAmount) + Number(intAmount);
//document.fRFQ.tp.value = Number(oldAmount) + Number(intAmount);
}
if (evt.checked == false)
{
document.fRFQ.SubTotal.value = Number(oldAmount) - Number(intAmount);
document.fRFQ.sTax.value = Number((document.fRFQ.SubTotal.value * document.fRFQ.pTax.value)/100).toLocaleString('en');
document.fRFQ.sTotal.value = Number(Number(document.fRFQ.SubTotal.value) + Number(document.fRFQ.sTax.value)).toLocaleString('en');

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
        v1.setAttribute("readOnly","true");
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