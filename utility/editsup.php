<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

$supid = $_GET['supid'];
$resultSUP = mysql_query("SELECT * FROM suppliers WHERE supid='".$supid."'");
$NoRowSUP = mysql_num_rows($resultSUP);

 if ($NoRowSUP > 0) {
  while ($row = mysql_fetch_array($resultSUP)) {
    $SupID = $row{'supid'};
    $SupNme = $row['SupNme'];
    $SupSCode = $row['SupSCode'];
    $SupAddress = $row ['SupAddress'];
    $SupCountry = $row ['SupCountry'];
    $SupEMail = $row ['SupEMail'];
    $SupPhone1 = $row ['SupPhone1'];
    $SupPhone2 = $row ['SupPhone2'];
    //$SupPhone3 = $row ['SupPhone3'];
    $SupRefNo = 'ENL/C&P/'.$SupID; //$row ['SupRefNo'];
    $SupURL = $row ['SupURL'];
    $SupTIN = $row ['SupTIN'];
    $SupGL = $row ['SupGL'];
    $SupBusD = $row ['SupBusD'];
    $SupDir = $row ['SupDir'];
    $SupYrReg = $row ['SupYrReg'];
    $SupENLRegNo = $row ['SupENLRegNo'];
    $SupLevel = $row ['SupLevel'];
    $SupCore = $row ['SupCore'];
    $SupCat = $row ['SupCat'];


    }

  }
  else
  {
    $_SESSION['ErrMsg'] = "Oops! Kindly select Vendor to eidt again";
    header('location: aSup');
  }

$resultGL = mysql_query("SELECT * FROM acc_chart_master Order By account_name");
$NoRowGL = mysql_num_rows($resultGL);
  if ($NoRowGL > 0) {
  while ($row = mysql_fetch_array($resultGL)) {
    $GLNME = $row['account_code'] . " - " . $row['account_name'];
    $GLID = $row['mid'];
    if($SupGL == $GLID)
    {
    $OptGL .='<option value=\"'.$GLID.'\">'.$GLNME.'</option>';
    }
    else
    {
      $OptGL .='<option selected value=\"'.$GLID.'\">'.$GLNME.'</option>';
    }
            
     }
}



 
 
$resultCN = mysql_query("SELECT * FROM countries");
//check if user exist
 $NoRowCN = mysql_num_rows($resultCN);
 
 //////////////////////////////////////////////////////////
if ($NoRowCN > 0) 
            {
              //fetch tha data from the database
              while ($row = mysql_fetch_array($resultCN)) {
              
              if($SupCountry == $row['country_name'])
              {
                $OptCountry .= '<option selected value="'.$row['country_name'].'">'.$row['country_name'].' </option>';
              }
              else
              {$OptCountry .= '<option value="'.$row['country_name'].'">'.$row['country_name'].' </option>';}
              
              
              }
              
            }
                                
      
 ///////////////////////////////////////////////////////////

 
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);

 


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Edit Supplier/Vendor</title>
	<link rel="icon" href="../mBoot/plant.png" type="image/png" sizes="10x10">
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
	
  </head>
  <body class="skin-blue sidebar-mini">
  
        <!-- Main content -->
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
                  <h3 class="box-title">Edit Supplier/Vendor</h3>
                  <a href="aSup"><button class="btn btn-success pull-right"> Back To Supplier/Vendor List</button></a>
                  <div class="box-tools pull-right">
                    </div>
					
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#66CC99;">
                      <p class="text-center">
                        <strong></strong>
                      </p>
                     <form id="fRFQ" name="fRFQ" action="updateSupplier" method="post">
		   <div class="form-group has-feedback" style="width:65%; display: inline-block;">
		  <input type="text" class="form-control" id="SupNme" name="SupNme" value="<?php echo $SupNme; ?>" placeholder=">>> Enter Supplier's Name Here <<<"  required />
			   <input type="hidden" name="SUPID" value="<?php echo $SupID; ?>" required >
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>


      <div class="form-group has-feedback" style="width:26%; display: inline-block;">
      <input type="text" maxlength="5" class="form-control" id="SupSCode" name="SupSCode" placeholder=">>> Short Code <<<" value="<?php echo $SupSCode; ?>"  required />
      
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>

          
          <div class="form-group has-feedback" style="width:100%;">
		  <select class="form-control" id="SupCountry" name="SupCountry" required>
			<option value=""> Choose Supplier's/Vendor's Country</option>
			<?php echo $OptCountry; ?>
			
			</select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>
		  
		  <div class="form-group has-feedback" style="width:100%;">
		   <input type="email" class="form-control" id="SupMail" name="SupMail" placeholder=">>> Enter Supplier's/Vendor's E-mail Here <<<" value="<?php echo $SupEMail; ?>"  />
		
			</select> <span class="glyphicon glyphicon-message form-control-feedback"></span>
          </div>
		  
		  <div class="form-group has-feedback" style="width:100%;">
		   <input type="text" class="form-control" id="SupURL" name="SupURL" placeholder=">>> Enter Supplier's/Vendor's URL Here <<<" value="<?php echo $SupURL; ?>"  />
		
			</select> <span class="glyphicon glyphicon-message form-control-feedback"></span>
          </div>
       <div class="form-group has-feedback" style="width:100%;">
      <select class="form-control" id="SupGL" name="SupGL" >
      <option value=""> Choose GL Acct.</option>
      <?php echo $OptGL; ?>
      
      </select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>

	
			<p class="text-center">
                        <strong>Supplier's/Vendor's Directors:</strong>
                      </p>
		 <div class="form-group has-feedback" style="width:100%; display: inline-block; ">
		   <textarea rows="4" cols="50" placeholder=" Enter Supplier's/Vendor's Directors..." id="SupDirectors" name="SupDir" style="width:100%;"><?php echo $SupDir;?></textarea>
		 </div>

     <div class="form-group has-feedback" style="width:45%; display: inline-block;">
       <input type="text" class="form-control" id="SupYrReg" name="SupYrReg" placeholder="Year Registered" title="Year Registered" value="<?php echo $SupYrReg;?>" />
    </div>

   
     <!--<div class="form-group has-feedback" style="width:45%; margin-left:12px; display: inline-block; ">
       <input type="text" class="form-control" id="SupENLRegNo" name="SupENLRegNo" placeholder="ENL Reg. No." title="ENL Reg. No." value="<?php echo $SupENLRegNo;?>" />
    </div>-->
    
    <div class="form-group has-feedback" style="width:45%; margin-left:12px; display: inline-block; ">
       <input type="text" class="form-control" id="SupENLRegNo" name="SupENLRegNo" placeholder="ENL Reg. No." title="ENL Reg. No." value="<?php echo $SupRefNo;?>" readonly />
    </div>

     <div class="form-group has-feedback" style="width:45%; display: inline-block;">
       <input type="text" class="form-control" id="SupLevel" name="SupLevel" placeholder="Level" title="Level" value="<?php echo $SupCore;?>" />
    </div>

    <p class="text-center">
                        <strong>PRODUCT / SERVICE/CORE BUSINESS:</strong>
                      </p>
     <div class="form-group has-feedback" style="width:100%; ">
       <input type="text" class="form-control" id="SupCore" name="SupCore" placeholder="PRODUCT / SERVICE/CORE BUSINESS" title="PRODUCT / SERVICE/CORE BUSINESS" />
    </div>

     <p class="text-center">
                        <strong>BUSINESS CATEGORY:</strong>
                      </p>
     <div class="form-group has-feedback" style="width:100%; ">
       <select type="text" class="form-control" id="SupCat" name="SupCat">
        <option>ELECTRICAL AND ELECTRONICS</option>
        <option>INSTRUMENTATION/ NDT/ CERTIFICATION</option>
        <option>LIFTING GEARS AND DECK FENDERING</option>
        <option>PETROLEUM PRODUCTS</option>
        <option>STATIONERIES</option>
        <option>STELL & FABRICATION</option>
        <option>TECHNICAL TOOLS</option>
        <option>SAFETY GEARS</option>
        <option>WELDING GASES AND WELDING ASSESSORIES</option>
        <option>PAINTS AND ACCESSORIES</option>
        <option>CIVIL WORKS/ BUILDING CONSTRUCTION</option>
        <option>AUTO SPARES AND O.E.MS</option>
        <option>GENERAL CONTRACTS AND SUNDRY SERVICES</option>
        <option>OTHERS</option>
       </select>
    </div>

     <p class="text-center">
                        <strong>Supplier's/Vendor's Address:</strong>
                      </p>
     <div class="form-group has-feedback" style="width:100%; display: inline-block; ">
       <textarea rows="4" cols="50" placeholder=" Enter Supplier's/Vendor's Address..." id="SupAdd" name="SupAdd" style="width:100%;"><?php echo $SupAddress;?></textarea>
     </div>


      <p class="text-center">
                        <strong>Supplier's/Vendor's Business Description:</strong>
                      </p>
     <div class="form-group has-feedback" style="width:100%; display: inline-block; ">
       <textarea rows="4" cols="50" placeholder=" Enter Supplier's/Vendor's Business Description..." id="SupBusD" name="SupBusD" style="width:100%;"><?php echo $SupBusD;?></textarea>
     </div>
    
		        
        </div><!-- /.col -->
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Supplier's/Vendor's Ref No.:</strong>
                      </p>
			<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="SupRefNo" name="SupRefNo" placeholder="Supplier's Ref No." value="<?php echo $SupRefNo;?>" readonly />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
		  <p class="text-center">
                        <strong>Supplier's/Vendor's Primary Phone No.:</strong>
                      </p>
		   <div class="form-group has-feedback" style="width:100%;">
		   <input type="text" class="form-control" id="SupPhone1" name="SupPhone1" placeholder=">>> Enter Supplier's Phone No. Here <<<"  required value="<?php echo $SupPhone1;?>" />
		
			</select> <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
		  
		                  <p class="text-center">
                        <strong>Supplier's/Vendor's Phone No.:</strong>
                      </p>
		   <div class="form-group has-feedback" style="width:100%;">
		   <input type="text" class="form-control" id="SupPhone2" name="SupPhone2" placeholder=">>> Enter Supplier's Phone No. Here <<<" value="<?php echo $SupPhone2;?>"  />
		
			  <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
		  
		   
		  

      <p class="text-center">
          <strong>Supplier's/Vendor's TIN No.:</strong>
      </p>
       <div class="form-group has-feedback" style="width:100%;">
       <input type="text" class="form-control" id="SupTIN" name="SupTIN" placeholder=">>> Enter Supplier's TIN No. Here <<<" value="<?php echo $SupTIN;?>"  />
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div>

          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Update Supplier/Vendor</button>
            </div><!-- /.col -->
          </div>
        </form> 
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
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
		
        </section><!-- /.content -->
      
      </div><!-- /.content-wrapper -->

    

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
	   
        $("#userTab").dataTable();
        var SupCat = '<?php echo $SupCat; ?>';
        $('#SupCat').val(SupCat);
       
      });
    </script>
	
  </body>
</html>