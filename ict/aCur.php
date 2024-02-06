<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

if (trim(strip_tags($_GET['curID'])) != "")
{
$result = mysql_query("SELECT * FROM currencies WHERE curID='".trim(strip_tags($_GET['curID']))."'");

 $NoRow = mysql_num_rows($result);


		if ($NoRow > 0) 
		{
			//fetch tha data from the database
			while ($row = mysql_fetch_array($result)) {
			   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
			  $curID1 = $row{'curID'};
			  $Abbreviation1 = $row['Abbreviation'];
			  $Symbol1 = $row ['Symbol'];
			  $CurrencyName1 = $row ['CurrencyName'];
			  $HunderthName1 = $row {'HunderthName'};
			  $Country1 = $row ['Country'];
			  $ReportingCurreny1 = $row ['ReportingCurreny'];
			  $ExRateToNaria1 = $row ['ExRateToNaria'];
			 
			  }
		}

}

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

$result = mysql_query("SELECT * FROM currencies");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($result)) {
			   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
			  $curID = $row{'curID'};
			  $Abbreviation = $row['Abbreviation'];
			  $Symbol = $row ['Symbol'];
			  $CurrencyName = $row ['CurrencyName'];
			  $HunderthName = $row {'HunderthName'};
			  $Country = $row ['Country'];
			  $ReportingCurreny = $row ['ReportingCurreny'];
			  $ExRateToNaria = $row ['ExRateToNaria'];
	  
	  
	    $Record .='
					 <tr>
					    <td>'.$curID.'</td>
						<td>'.$Abbreviation.'</td>
						<td>'.$Symbol.'</td>
						<td>'.$CurrencyName.'</td>
						<td>'.$HunderthName.'</td>
						<td>'.$Country.'</td>
						<td>'.$ReportingCurreny.'</td>
						<td>'.$ExRateToNaria.'</td>
						<td><a href="?curID='.$curID.'"<span class="glyphicon glyphicon-edit"></span></a></td>
					
					
					 </tr>
					 
					 
					 ';
						
     }
}

$resultCN = mysql_query("SELECT * FROM countries");
//check if user exist
 $NoRowCN = mysql_num_rows($resultCN);


if ($NoRowCN > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($resultCN)) {
			   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
			  $conNME = $row{'country_name'};
			$CountryR .='<option value="'.$conNME.'">'.$conNME.'</option>';
						
     }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>PLANT E.R.P | Register New Customer</title>
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

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Add New Currency On ERP</h3>
				   
                  <div class="box-tools pull-right">
                  <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
				  <a style="float:right" href="./"> X</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8">
                      <p class="text-center">
					  
                        <strong>Currency Details</strong>
                      </p>
					 
                     <form enctype="multipart/form-data" action="addCur" method="post">
          <div class="form-group has-feedback" style="width:40%; display: inline-block;">
		   <input type="text" class="form-control" id="curnme" name="curnme" placeholder="Currency Name" value="<?php echo $CurrencyName1; ?>"required />
			<input type="hidden" name="ssv" value="<?php echo $curID1; ?>" />
		  </div>
		   <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
		   <input type="text" class="form-control" id="curhnme" name="curhnme" placeholder="Hunderth Name" value="<?php echo $HunderthName1; ?>" required />
          </div>
       
		   <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:0px;">
            <input type="text" class="form-control" id="curabv" name="curabv" placeholder="Currency Abbrevation" value="<?php echo $Abbreviation1; ?>" required />
           </div>
		   
		   <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
            <input type="text" class="form-control" id="cursym" name="cursym" placeholder="Currency Symbol" value="<?php echo $Symbol1 ?>" />
           </div>
		   
		    <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:0px;">
            <input type="text" class="form-control" id="curex" name="curex" placeholder="ExRate To Naria" onKeyPress="return isNumber(event)" value="<?php echo $ExRateToNaria1; ?>" />
           </div>
		   
		    <div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">
			<select class="form-control" id="curcon" name="curcon" required >
			<option value = "">Choose Country</option>
			<?php echo $CountryR; ?>
			</select>
            </div>
		   
		  
		
         
              
                    </div><!-- /.col -->
                    <div class="col-md-4">
                     
			
<script type="text/javascript">
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}




</script>
<br>
<br>
<br>
<br>
				  
          <div class="row">
           
            <div class="col-xs-12">
				<?php if (trim(strip_tags($_GET['curID'])) != "") { ?>
              <button type="submit" class="btn btn-primary btn-block btn-flat">Update Currency</button>
			  <?php } else { ?>
			   <button type="submit" class="btn btn-primary btn-block btn-flat">Add Currency</button>
			   <?php } ?>
            </div><!-- /.col -->
          </div>
            </form> 
			<br/>
			<!--<form>
			 <div class="col-xs-12">
				<?php if (trim(strip_tags($_GET['cusid'])) != "") { ?>
              <button type="submit" class="btn btn-primary btn-block btn-flat">Delete Customer</button>
			    <?php } else { ?>
			  
			   <?php } ?>
            </div>
			</form> -->
			<br/>
			<br/>
			<form>
			 <div class="col-xs-12">
				<?php if (trim(strip_tags($_GET['cusid'])) != "") { ?>
              <button type="submit" class="btn btn-primary btn-block btn-flat">Cancel</button>
			    <?php } else { ?>
			  
			   <?php } ?>
            </div><!-- /.col -->
			</form>
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
                  <h3 class="box-title">Currency List on ERP</h3>
                  <div class="box-tools pull-right">
                   <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
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
                        <th>Abbreviation</th>
                        <th>Symbol</th>
                        <th>CurrencyName</th>
                        <th>HunderthName</th>
                        <th>Country</th>
						<th>ReportingCurreny</th>
						<th>ExRateToNaria</th>
						<th>Edit</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>S/N</th>
                        <th>Abbreviation</th>
                        <th>Symbol</th>
                        <th>CurrencyName</th>
                        <th>HunderthName</th>
                        <th>Country</th>
						<th>ReportingCurreny</th>
						<th>ExRateToNaria</th>
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