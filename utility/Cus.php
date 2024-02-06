<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

//Load Business Unit
$BUopt = "";
$BusUt = mysql_query("SELECT * FROM businessunit ORDER BY BussinessUnit");
$NoRowBusUt = mysql_num_rows($BusUt);

if ($NoRowBusUt > 0) 
{
  while ($row = mysql_fetch_array($BusUt)) {
    $id = $row{'id'};
    $bnu = $row['BussinessUnit'];
    $BUopt .= '<option value="'.$id.'">'.$bnu.'</option>';
    }
} else { $BUopt .= '<option value="" > --- </option>'; }


$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

$result = mysql_query("SELECT * FROM customers");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($result)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
	  $cusid = $row{'cusid'};
	  $CustormerNme = $row['CustormerNme'];
    $cussnme = $row['cussnme'];
	  $CusRefNo = $row ['CusRefNo'];
	  $CusAddress = $row ['CusAddress'];
    $CusAddress2 = $row ['CusAddress2'];
	  $CusLogo = $row {'CusLogo'};
	  $CusPhone1 = $row ['CusPhone1'];
	  $CusPhone2 = $row ['CusPhone2'];
	  $CusPhone3 = $row ['CusPhone3'];
	  $CusPhone4 = $row ['CusPhone4'];
	  $webaddress = $row ['webaddress'];
	  $email = $row ['email'];
	  
	  
	    $Record .='
					 <tr>
					    <td>'.$cusid.'</td>
            <td>'.$CustormerNme.'</td>
						<td>'.$cussnme.'</td>
						<td>'.$CusRefNo.'</td>
						<td>'.$CusAddress.'</td>
						<td>'.$CusPhone1.'</td>
						<td>'.$email.'</td>
						<td>'.$webaddress.'</td>
						<td><a href="viewCus?cusid='.$cusid.'"<span class="glyphicon glyphicon-edit"></span></a></td>
					
					
					 </tr>
					 
					 
					 ';
						
     }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Register New Customer</title>
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
    <link href="../plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
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
<?php //if((strpos($_SESSION['AccessModule'], "Contracts/Procurement") !== false)) 
{ ?>
          <div class="row">
            <div class="col-md-12">
              <div class="box collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">Register New Customer On ERP</h3>
				   
                  <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div>
				 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8">
                      <p class="text-center">
					  
                        <strong>Customer's Details</strong>
                      </p>
                     <form enctype="multipart/form-data" action="addCus" method="post">
          <div class="form-group has-feedback col-md-4">
            <label>NAME OF ORGANIZATION <strong style="color:red">*</strong></label>
		   <input type="text" class="form-control" id="cusnme" name="cusnme" placeholder="Customer's Name" required  />
		
		  </div>


		   <div class="form-group has-feedback col-md-4">
        <label>REF NO.</label>
		   <input type="text" class="form-control" id="cusrefn" name="cusrefn" placeholder="Customer's ref. No."  />
          </div>
       
		   <div class="form-group has-feedback col-md-4">
        <label>PRIMARY PHONE NO.</label>
            <input type="text" class="form-control" id="cusphn1" name="cusphn1" placeholder="Customer's contact 1"  />
           </div>
		   
		 
		   
		   <div class="form-group has-feedback col-md-4">
        <label>ORGANISATION WEB ADDRESS</label>
            <input type="text" class="form-control" id="cusweb" name="cusweb" placeholder="Customer's Website" />
            <span class="glyphicon glyphicon-globe form-control-feedback"></span>
          </div>


		   <div class="form-group has-feedback col-md-4">
        <label>ORGANISATION EMAIL</label>
            <input type="email" class="form-control" id="cusmail" name="cusmail" placeholder="Customer's Email"  />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>


       
       <div class="form-group has-feedback col-md-4">
        <label>SHORT NAME <strong style="color:red">*</strong></label>
            <input type="text" maxlength = 4 class="form-control" id="cussnme" name="cussnme" placeholder="SHORT NAME" required  />
      </div>

          <div class="form-group has-feedback col-md-6">
        <label>CATEGORY <strong style="color:red">*</strong></label>
            <select class="form-control" id="category" name="category" required >
              <option value="">---</option>
              <option value="IOC">IOC</option>
              <option value="Marginal Field Operator">Marginal Field Operator</option>
              <option value="International Servicing Company">International Servicing Company</option>
              <option value="Local Servicing Company">Local Servicing Company</option>
              <option value="Governmet Agency/Parastatal">Governmet Agency/Parastatal</option>
              <option value="Non-Oil & Gas">Non-Oil & Gas</option>
              <option value="Marine">Marine</option>
            </select>
            <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>


       <div class="form-group has-feedback col-md-6">
        <label>BUSINESS UNIT <strong style="color:red">*</strong></label>
            <select class="form-control" id="busunit" name="busunit" required >
              <option value="">---</option>
              <?php echo $BUopt; ?>
            </select>
            <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>
		  
		  <div class="form-group has-feedback col-md-6">
        <label>DDP ADDRESS</label>
			 <textarea style="width:100%"  name="cusadd" placeholder="Customer's DDP Address" ></textarea>
		   </div>

        <div class="form-group has-feedback col-md-6">
          <label>ExWorks ADDRESS</label>
       <textarea style="width:100%" name="cusadd2" placeholder="Customer's ExWorks Address" ></textarea>
       </div>

         <div class="form-group has-feedback col-md-4">
         <label>CONTACT PERSON PHONE NO. 1</label>
            <input type="text" class="form-control" id="contphn1" name="contphn1" placeholder="contact phone 1"  />
           </div>
       
        <div class="form-group has-feedback col-md-4">
          <label>CONTACT PERSON EMAIL 1</label>
            <input type="text" class="form-control" id="contemail1" name="contemail1" placeholder="contact's Email 1" />
           </div>
       
        <div class="form-group has-feedback col-md-4">
          <label>CONTACT PERSON NAME 1</label>
            <input type="text" class="form-control" id="contnme1" name="contnme1" placeholder=" contact name (Relationship) 1" />
           </div>


          <div class="form-group has-feedback col-md-4">
         <label>CONTACT PERSON PHONE NO. 2</label>
            <input type="text" class="form-control" id="contphn2" name="contphn2" placeholder="contact phone 2"  />
           </div>
       
        <div class="form-group has-feedback col-md-4">
          <label>CONTACT PERSON EMAIL 2</label>
            <input type="text" class="form-control" id="contemail2" name="contemail2" placeholder="contact's Email 2" />
           </div>
       
        <div class="form-group has-feedback col-md-4">
          <label>CONTACT PERSON NAME 2</label>
            <input type="text" class="form-control" id="contnme2" name="contnme2" placeholder=" contact name (Relationship) 2" />
           </div>
		
     
         
              
                    </div><!-- /.col -->
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Customer's Logo</strong>
                      </p>
			<center>
			<?php if (trim(strip_tags($_GET['cusid'])) != "") {
			  echo '<img id="uploadPreview" style="width: 200px; height: 200px;" src="data:image/jpeg;base64,'. base64_encode($CusLogo1). '" class="img-circle" alt="Customer\'s LOGO">';} else
			{			  ?>
			<img id="uploadPreview" class="img-circle" style="width: 200px; height: 200px;" />
			<?php } ?>
			 </center>

<script type="text/javascript">

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("CusLOGO").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

</script>
<br>
			<div class="form-group has-feedback">
            <input type="file" id="CusLOGO" name="CusLOGO" accept="image/jpg" class="form-control" onchange="PreviewImage();" placeholder="Custome's Logo"/>
			
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>		  
          <div class="row">
           
            <div class="col-xs-12">
            
			   <button type="submit" class="btn btn-success btn-block btn-flat">Add Customer</button>
			  
            </div><!-- /.col -->
          </div>
            </form> 
			<br/>
			
			<br/>
			<br/>
			
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          <?php } ?>

        
	
	<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Customer List on ERP</h3>
                  <div class="box-tools pull-right">
                   <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
					  
                        <th>S/N</th>
                        <th>Customer</th>
                        <th>Short Code</th>
                        <th>Cust. RefNo</th>
                        <th>Cust. Address</th>
                        <th>Cust. Phone</th>
                        <th>Email</th>
						<th>Web Address</th>
						<th>Edit</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>S/N</th>
                        <th>Customer</th>
                        <th>Short Code</th>
                        <th>Cust. RefNo</th>
                        <th>Cust. Address</th>
                        <th>Cust. Phone</th>
                        <th>Email</th>
						<th>Web Address</th>
						<th>Edit</th>
                       
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
     
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
	   
        //$("#userTab").dataTable();
        $('#userTab').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
	
  </body>
</html>