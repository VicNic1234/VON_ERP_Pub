<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$result = mysql_query("SELECT * FROM notification WHERE StaffID='".$_SESSION['uid']."'");
//check if user exist
$NoRowMsg = mysql_num_rows($result);
$FullName = $_SESSION['Firstname'] . " " .$_SESSION['SurName'];
$msg = "";
if ($NoRowMsg > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($result)) {
	$msg .= '<li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> '.$row{'Message'}.'
                        </a>
                      </li>';
	}
	
}

include('route.php');

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

//Business Year
$BYr = $_SESSION['BusinessYear'];
//Read CONcount
$CONcount = mysql_query("SELECT * FROM sysvar WHERE variableName = 'POCount'");
while ($row = mysql_fetch_array($CONcount)) {
              $nCONcount = $row{'variableValue'};
              }
  $CONTRNO = str_pad($nCONcount,3,"0",STR_PAD_LEFT);


   /*Get CURRENCY*/
$resultCurr = mysql_query("SELECT * FROM currencies Order By Abbreviation");
$NoRowCurr = mysql_num_rows($resultCurr);
if ($NoRowCurr > 0) {
  while ($row = mysql_fetch_array($resultCurr)) 
  {
    $cAB = $row['Abbreviation'];
    
    if($cAB == "NGN")
    { $CurrOpt .= '<option selected value="'.$cAB.'">'.$cAB.'</option>'; }
    else
    {
     $CurrOpt .= '<option value="'.$cAB.'">'.$cAB.'</option>';
    }
  
   
  }
 }

     /*Get PDF*/
$resultREQ = mysql_query("SELECT DISTINCT RequestID FROM poreq WHERE isActive=1 AND Approved>15 ");
$NoRowREQ = mysql_num_rows($resultREQ);
if ($NoRowREQ > 0) {
  while ($row = mysql_fetch_array($resultREQ)) 
  {
    $RequestID = $row['RequestID'];
    if($PDFNUM == $RequestID)
    {
     $ReQOpt .= '<option selected value="'.$RequestID.'">'.$RequestID.'</option>';
    }
    else
    {
     $ReQOpt .= '<option value="'.$RequestID.'">'.$RequestID.'</option>';
    }
  
   
  }
 }

      /*Get PO*/
$resultPO = mysql_query("SELECT PONo, cid FROM purchaseorders WHERE isActive=1 ");
$NoRowREQ = mysql_num_rows($resultPO);
if ($NoRowREQ > 0) {
  while ($row = mysql_fetch_array($resultPO)) 
  {
    $PONos = $row['PONo'];
    $POID = $row['cid'];
    if($PONUM == $POID)
    {
     $POOpt .= '<option selected value="'.$POID.'">'.$PONos.'</option>';
    }
    else
    {
     $POOpt .= '<option value="'.$POID.'">'.$PONos.'</option>';
    }
  
   
  }
 }



 /*Get Suppliers*/
$resultSUP = mysql_query("SELECT * FROM suppliers Order By SupNme");
$NoRowSUP = mysql_num_rows($resultSUP);
if ($NoRowSUP > 0) {
  while ($row = mysql_fetch_array($resultSUP)) 
  {
    $supid = $row['supid'];
    $SupNme = $row['SupNme'];
    $SupOpt .= '<option value="'.$supid.'">'.$SupNme.'</option>';
  }
 }

//
 //////////////////////////////////
  
$resultUser = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRowUser = mysql_num_rows($resultUser);

 $OptStaff ="";
 if ($NoRowUser > 0) {
  while ($row = mysql_fetch_array($resultUser)) 
  {
    $SUserID = $row['uid'];
    $StfName = $row['Firstname'] . " " . $row['Surname'];
    $OptStaff .= '<option value="'.$SUserID.'">'.$StfName.'</option>';
  }
 }



//Let's get the Business Unit
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

	

?>
<?php if ($NoRowCUS > 0) 
            {
              //fetch tha data from the database
              while ($row = mysql_fetch_array($resultCUS)) {
             
              $Custms .= '<option value="'.$row['cussnme'].'">'.$row['CustormerNme'].'</option>';
            
              }
              
            }
                                
      ?>
<!DOCTYPE html>
<html>
 <?php include('../header2.php'); ?>

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
            New Vendor Invoice
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../cnp"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">New Vendor Invoice</li>
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
  
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Vendor Invoice Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#9999FF; border-radius: 15px; padding-top:22px;">
                    
                     <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="regINVOICE" method="post">
          <div class="form-group has-feedback col-md-12" >
                <label>Choose Vendor:</label>
          		  <select class="form-control select2" id="VendSource" name="VendSource" required>
          			<option value=""> Choose Vendor</option>
          			<?php echo $SupOpt; ?>
          			</select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>
        
          <script type="text/javascript">
           /* function setVend(elem)
            {
              var VendID = $(elem).val();
               var formData = {supid:VendID};
                //AJAX CALL
                $.ajax({ type: "POST", url: "../utility/getSupplierCode", data: formData, cache: false,
                      success: function(html) {
                        //var obj = JSON.parse(html);
                        //alert(html);
                        var ContSq = '<?php echo $CONTRNO; ?>'; 
                        var ContfulNo = "ENL/"+html+"/C&P/PO/"+ContSq;
                        $('#ContractNo').val(ContfulNo);
                        //alert(html);
                      }
                       
                    });
            } */
          </script>
		  
		   
		  
		  <div class="form-group has-feedback col-md-6">
                    <label>Invoice Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" id="InvoiceDate" name="InvoiceDate" value="" required="required" readonly placeholder="Click to set Date" />
                    </div><!-- /.input group -->
          </div>

        

          <div class="form-group has-feedback col-md-6">
                 
                    <label>VENDOR ATTENTION:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                      </div>
                      <input class="form-control" name="VENDATTN" >
                    </div><!-- /.input group -->
          </div>
          
           <div class="form-group has-feedback col-md-4">
                 
                    <label>ENL ATTENTION:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                      </div>
                      <select class="form-control select2" name="ENLATTN">
                        <?php echo $OptStaff; ?>
                      </select>
                    </div><!-- /.input group -->
          </div>

          <div class="form-group has-feedback col-md-6">
            <label>Choose Business Unit:</label>
            <select class="form-control" id="conDiv" name="conDiv" required >
            <option value=""> Choose Business Unit</option>
            <?php echo $RecDiv; ?>
            </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-3">
            <label>Currency:</label>
           <select class="form-control" name="currency">
            <option value="">--</option>
            <?php echo $CurrOpt; ?>
           </select>
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>
          
          
          <div class="form-group has-feedback col-md-4">
                    <label>NGN Rate:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-money"></i>
                      </div>
                      <input type="text" class="form-control" name="NGNRate" onKeyPress="return isNumber(event)" required value="1" />
                    </div><!-- /.input group -->
          </div>

        

		 
		 
		
   
     
     <div class="form-group has-feedback col-md-12">
            <label>Comment:</label>
       <textarea rows="4" cols="50" placeholder=" Enter comment here..." id="Comment" name="Comment" style="width:100%; display: inline-block;"></textarea>
     </div>
   
		  
  </div><!-- /.col -->
                    
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Vendor Invoice Number</strong>
                      </p>
			    <div class="form-group has-feedback">
            <input type="text" class="form-control" value="" id="VenInvoiceID" name="VenInvoiceID" placeholder=""  required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
          <br/>
             <p class="text-center">
                        <strong>PDF Number (Optional)</strong>
                      </p>
          <div class="form-group has-feedback">
           <select class="form-control select2" name="PDFNum">
            <option value="">--</option>
            <?php echo $ReQOpt; ?>
           </select>
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
          <br/>
             <p class="text-center">
                        <strong>ENL PO Number (Optional)</strong>
                      </p>
          <div class="form-group has-feedback">
           <select class="form-control select2" name="ENLPONum">
            <option value="">--</option>
            <?php echo $POOpt; ?>
           </select>
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
<br/>
		 
			<p class="text-center">
                        <strong>Vendor Invoice Document (Optional)</strong>
                      </p>
			<div class="form-group has-feedback">
            <input type="file" id="VENFile" name="VENFile" class="form-control" />
			
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>


          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Register Invoice</button>
            </div><!-- /.col -->
          </div>
                      </form> 
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
	
	
		
		
		
		
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
      $(function () {
        $("#userTab").dataTable();
       
        var LastEntryDate = '<?php echo $LastEntryDate; ?>';
          $(".datep").datepicker({dateFormat : 'yy/mm/dd', changeYear: true, changeMonth: true, minDate: LastEntryDate });
      });
    </script>

  <script type="text/javascript">      
        $('.srcselect').select2();
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
    </script>
	
  </body>
</html>