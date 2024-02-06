<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

$resultPROD = mysql_query("SELECT * FROM product");
//check if user exist
 $NoRowPROD = mysql_num_rows($resultPROD);

 $resultRFQ1 = mysql_query("SELECT * FROM rfq WHERE Status='OPEN'");
//check if user exist
 $NoRowRFQ1 = mysql_num_rows($resultRFQ1);
 
$resultCN = mysql_query("SELECT * FROM countries");
//check if user exist
 $NoRowCN = mysql_num_rows($resultCN);
 $resultCN1 = mysql_query("SELECT * FROM countries");
 $NoRowCN1 = mysql_num_rows($resultCN1);
 //////////////////////////////////////////////////////////

  if ($NoRowCN1 > 0) {
	while ($row = mysql_fetch_array($resultCN1)) {
	  $CountryNme = $row['country_name'];
	  $CNRecord .='<option value=\"'.$CountryNme.'\">'.$CountryNme.'</option>';
						
     }
}
 ////////////////////////////////////////////////////////////

 
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);

 if ($_GET['sRFQ'] == "")
 {}
 else
 {
 $resultLI = mysql_query("SELECT * FROM lineitems WHERE RFQCode='".$_GET['sRFQ']."'");
//check if user exist
 $NoRowLI = mysql_num_rows($resultLI);
 }


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Register New Product</title>
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
                  <h3 class="box-title">Register Product</h3>
                  <div class="box-tools pull-right">
                    </div>
					
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#66CC99;">
                      <p class="text-center">
                        <strong></strong>
                      </p>
                     <form id="fRFQ" name="fRFQ" action="addProduct" method="post">
		   <div class="form-group has-feedback" style="width:100%;">
		  <input type="text" class="form-control" id="ProdNme" name="ProdNme" placeholder=">>> Enter Product Name Here <<<"  required />
			
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>
          <!--<div class="form-group has-feedback" style="width:100%;">
		  <select class="form-control" id="SupCountry" name="SupCountry" required>
			<option value=""> Choose Supplier's Country</option>
			<?php if ($NoRowCN > 0) 
						{
							//fetch tha data from the database
							while ($row = mysql_fetch_array($resultCN)) {
							?>
							<option value="<?php echo $row['country_name']; ?>"><?php echo $row['country_name']; ?> </option>
							<?php
							}
							
						}
																
			?>
			
			</select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>-->
		  
		  <!--<div class="form-group has-feedback" style="width:100%;">
		   <input type="email" class="form-control" id="SupMail" name="SupMail" placeholder=">>> Enter Supplier's E-mail Here <<<"  />
		
			</select> <span class="glyphicon glyphicon-message form-control-feedback"></span>
          </div>
		  
		  <div class="form-group has-feedback" style="width:100%;">
		   <input type="text" class="form-control" id="SupURL" name="SupURL" placeholder=">>> Enter Supplier's URL Here <<<"  />
		
			</select> <span class="glyphicon glyphicon-message form-control-feedback"></span>
          </div>-->
         
		 		  
		


<script language="javascript">
        function open_container(LID, prodnme)
        {
            var title = 'Product Details';
			var ConR = "<?php echo $CNRecord ?>";
            var size='standart';
            var content = '<form role="form" method="post" action="updProduct"><div class="form-group">' +
			
			'<input type="hidden" class="form-control" id="ProdID" name="ProdID" value="'+ LID +'"/>' +
			
			'<div class="form-group" style="width:100%;"><label>Product Name : </label><input type="text" class="form-control" id="ProdName" name="ProdName" value="'+ prodnme +'" ></div>' +
			
			
						
			'<button type="submit" class="btn btn-primary">Save changes</button></form>';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
        }
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

 <script type="text/javascript" >
	
	function isAddress(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}



  </script>		
	<!--
			<p class="text-center">
                        <strong>Supplier's Address:</strong>
                      </p>
		 <div class="form-group has-feedback" style="width:100%; display: inline-block; ">
		   <textarea rows="4" cols="50" placeholder=" Enter Suppliers Address..." id="SupAdd" name="SupAdd" style="width:100%;"> </textarea>
		 </div>
		        
        </div><!-- /.col -->
                    <div class="col-md-4">
                      <!--<p class="text-center">
                        <strong>Supplier's Ref No.:</strong>
                      </p>
			<div class="form-group has-feedback" style="width:100%; display: inline-block;">
            <input type="text" class="form-control" id="SupRefNo" name="SupRefNo" placeholder="Supplier's Ref No." />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
		  <p class="text-center">
                        <strong>Supplier's Primary Phone No.:</strong>
                      </p>
		   <div class="form-group has-feedback" style="width:100%;">
		   <input type="text" class="form-control" id="SupPhone1" name="SupPhone1" placeholder=">>> Enter Supplier's Phone No. Here <<<"  required />
		
			</select> <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
		  
		  <p class="text-center">
                        <strong>Supplier's Phone No.:</strong>
                      </p>
		   <div class="form-group has-feedback" style="width:100%;">
		   <input type="text" class="form-control" id="SupPhone2" name="SupPhone2" placeholder=">>> Enter Supplier's Phone No. Here <<<"  />
		
			</select> <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
		  
		   
		  <p class="text-center">
                        <strong>Supplier's Phone No. 2:</strong>
                      </p>
		   <div class="form-group has-feedback" style="width:100%;">
		   <input type="text" class="form-control" id="SupPhone3" name="SupPhone3" placeholder=">>> Enter Supplier's Phone No. Here <<<"  />
		-->
			</select> <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Add Product</button>
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
	
	<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Product Table</h3>
				 
				  
    

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



  </script>
            


<?php
//fetch tha data from the database
	 if ($NoRowPROD > 0) {
	while ($row = mysql_fetch_array($resultPROD)) {
	  $ProdID = $row{'pid'};
	  $ProdNme = $row['productname'];
	  
		
	    $Record .='
					 <tr>
					    <td>'.$ProdID.'</td>
						<td>'.$ProdNme.'</td>
						
						<td><a '.  'onclick="open_container('.$ProdID.',\''.$ProdNme.'\');">'. '<span class="glyphicon glyphicon-edit"></span></a></td>
					
				     </tr>';
						
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
                        <th>Name</th>
                        <th>Edit</th>
                       
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>S/N</th>
                        <th>Name</th>
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
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
	
  </body>
</html>