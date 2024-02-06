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
$MYID = $_SESSION['uid'];
//Business Year
$BYr = $_SESSION['BusinessYear'];
$CONID = $_GET['cnid'];
 $resultLI = mysql_query("SELECT * FROM contracts 
 LEFT JOIN suppliers ON contracts.VendSource = suppliers.supid
 LEFT JOIN users ON contracts.RaisedBy = users.uid
 WHERE cid='".$CONID."'
 "); //WHERE isActive=1 ORDER BY cid

 $NoRowLI = mysql_num_rows($resultLI);
//fetch tha data from the database
   if ($NoRowLI > 0) 
   {
   $SN = 1;
  while ($row = mysql_fetch_array($resultLI)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     
    $cid = $row['cid'];
    $ContractNo = $row['ContractNo'];
    $Comment = $row['Comment'];
    $conDiv = $row['conDiv'];
    $conSDate = $row['conSDate'];
    $conEDate = $row['conEDate'];
    $Currency = $row['Currency'];
    $PDFNUM = $row['PDFNUM'];
    $SupNme = $row['SupNme'];
    $LegalOfficerComment = $row['LegalOfficerComment'];
    $LegalOfficerOn = $row['LegalOfficerOn'];
    $MDOfficeComment = $row['MDOfficeComment'];
    $MDOfficeOn = $row['MDOfficeOn'];
    $VendSource = $row['VendSource'];
    $RaisedBy = $row['Firstname'] . " " . $row['Surname'];//$row['RaisedBy'];
    $TotalSum = $row['TotalSum'];
    $FileLink = $row['FileLink'];
    }
  }
  else
  {
    $_SESSION['ErrMsg'] = "Oops! an error occured, try again";
    header('Location: contracts');
    exit;
  }

 /*Get CURRENCY*/
$resultCurr = mysql_query("SELECT * FROM currencies Order By Abbreviation");
$NoRowCurr = mysql_num_rows($resultCurr);
if ($NoRowCurr > 0) {
  while ($row = mysql_fetch_array($resultCurr)) 
  {
    $cAB = $row['Abbreviation'];
    
    if($Currency == $cAB)
    {
     $CurrOpt .= '<option selected value="'.$cAB.'">'.$cAB.'</option>';
    }
    else
    {
      $CurrOpt .= '<option value="'.$cAB.'">'.$cAB.'</option>';
    }
   
  }
 }

     /*Get PDF*/
$resultREQ = mysql_query("SELECT DISTINCT RequestID FROM poreq ");
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

 /*Get Suppliers*/
$resultSUP = mysql_query("SELECT * FROM suppliers Order By SupNme");
$NoRowSUP = mysql_num_rows($resultSUP);
if ($NoRowSUP > 0) {
  while ($row = mysql_fetch_array($resultSUP)) 
  {
    $supid = $row['supid'];
    $SupNme = $row['SupNme'];
    if($VendSource == $supid){
     $SupOpt .= '<option selected value="'.$supid.'">'.$SupNme.'</option>';
    }
    else
    {
    $SupOpt .= '<option value="'.$supid.'">'.$SupNme.'</option>';
    }
  }
 }

 //////////////////////////////////
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);



//Let's get the Business Unit
 $RecDiv = "";
 $resultDiv = mysql_query("SELECT * FROM businessunit ORDER BY BussinessUnit");
 $NoRowDiv= mysql_num_rows($resultDiv);
 if ($NoRowDiv > 0) {
  while ($row = mysql_fetch_array($resultDiv)) 
  {
    $DivID = $row['id'];
    $DivName = $row['BussinessUnit'];
    if($conDiv == $DivID)
    {
    $RecDiv .= '<option selected value="'.$DivID.'">'.$DivName.'</option>';

    }
    else
    {
    $RecDiv .= '<option value="'.$DivID.'">'.$DivName.'</option>';

    }
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
        

         /*Get Supporting Docs*/
$resultSDoc = mysql_query("SELECT * FROM supportingdoc Where docid='".$CONID."' AND module='CNP' Order By sdid");
$NoRowSDoc = mysql_num_rows($resultSDoc);
 $SN = 0;
if ($NoRowSDoc > 0) {
  while ($row = mysql_fetch_array($resultSDoc)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['sdid'];
    $link = $row['link'];
    $addedby = $row['addedby'];
    $linkn = '<a target="_blank" href="'.$link.'"><i class="fa fa-link"></i></a>';
    $description = $row['description'];
    $title = $row['title'];
    $delDoc = "";
    if($addedby == $MYID)
    {
      $delDoc = '<a href="deldoc?id='.$sdid.'"><i class="fa fa-trash"></i></a>';
    }
    $SupDocs .= '<tr>
                      <td>'.$SN.'</td>
                      <td>'.$title.'</td>
                    <td>'.$description.'</td>
                    <td>'.$linkn.'</td>
                    <td>'.$delDoc.'</td></tr>';
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
             Contract : <?php echo $ContractNo; ?>
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $ContractNo; ?></li>
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
                  <h3 class="box-title">Contract Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#00C6C6; border-radius: 15px; padding-top:22px;">
                    
                   <?php if ($MDOfficeOn != "") { ?>  <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="updateCONT" method="post"> <?php } ?>
          <div class="form-group has-feedback col-md-12" >
                <label>Choose Vendor:</label>
          		  <select class="form-control" id="VendSource" name="VendSource" required>
          			<option value=""> Choose Vendor</option>
          			<?php echo $SupOpt; ?>
          			</select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
            <input type="hidden" name="ConID" value="<?php echo $CONID; ?>" required>
          </div>
		  
		   
		  
		  <div class="form-group has-feedback col-md-6">
                    <label>Start Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" value="<?php echo $conSDate; ?>" name="conSDate" required />
                    </div><!-- /.input group -->
          </div>

         <div class="form-group has-feedback col-md-6">
                 
                    <label>End Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" value="<?php echo $conEDate; ?>" name="conEDate" />
                    </div><!-- /.input group -->
          </div>

          <div class="form-group has-feedback col-md-5">
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
            <label>Total Sum (optional):</label>
           <input type="text" class="form-control" name="totalSum" value="<?php echo $TotalSum; ?>" onKeyPress="return isNumber(event)" />
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>

		 
		 
		 <div class="form-group has-feedback col-md-12">
		   <textarea rows="4" cols="50" placeholder=" Enter comment here..." id="Comment" name="Comment" style="width:100%; display: inline-block;"><?php echo $Comment; ?></textarea>
		 </div>
   
		  
  </div><!-- /.col -->
                    
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Contract Number</strong>
                      </p>
			    <div class="form-group has-feedback">
            <input type="text" class="form-control" readonly value="<?php echo $ContractNo; ?>" id="ContractNo" name="ContractNo" placeholder="ENL/CUSN/C&P/CONTR/002"  required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
		 <br/>
             <p class="text-center">
                        <strong>PDF Number (Optional)</strong>
                      </p>
          <div class="form-group has-feedback">
           <select class="form-control" name="PDFNum">
            <option value="">--</option>
            <?php echo $ReQOpt; ?>
           </select>
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
<br/>
			<p class="text-center">
                        <strong>Select Document to Over ride (Optional)</strong>
                      </p>
			<div class="form-group has-feedback">
            <input type="file" id="CONFile" name="CONFile" class="form-control" />
			
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>		

                      <p class="text-center">
                         <?php if($FileLink != "") { ?>
                       <a href="<?php echo $FileLink; ?>"><strong>Main Contract Document</strong></a>
                     <?php } ?>
                      </p>

 
     

          <div class="row">
            <?php if ($MDOfficeOn != "") { ?>
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
            </div><!-- /.col -->
            <?php } ?>
          </div>
                      </form> 
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
              <div class="col-md-12">
         

              <div class="col-md-6">
                 <div class="box box-info">
                <div class="box-header">
                 Authorization
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th colspan="2">Actor</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Legal</td>
                        <td>
                            <?php if ($LegalOfficerOn != "") { ?>
                            <input type="checkbox" name="conlegal" checked disabled >
                            <?php } else { ?>
                          <input type="checkbox" name="conlegal" disabled >
                          <?php } ?>
                      </td>
                      </tr>
                      <tr>
                        <td>Technical</td>
                        <td>
                         
                           <?php if ($MDOfficeOn != "") { ?>
                            <input type="checkbox" name="contech" checked disabled >
                            <?php } else { ?>
                          <input type="checkbox" name="contech" disabled >
                          <?php } ?>
                          
                      </td>
                      </tr>
                      <tr>
                        <td>Commercial</td>
                        <td>
                          
                           <?php if ($MDOfficeOn != "") { ?>
                            <input type="checkbox" name="concomm" checked disabled >
                            <?php } else { ?>
                          <input type="checkbox" name="concomm" disabled >
                          <?php } ?>
                      </td>
                      </tr>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>
              
              
              
              
              
              
              
              <div class="col-md-6">
                 <div class="box box-info">
                <div class="box-header">
                 Legal Comment
                </div><!-- /.box-header -->
                <div class="box-body">
                   <div class="row">
                    <div class="col-md-12">

                       <form enctype="multipart/form-data" action="updateCONT" method="post">
                            <div class="form-group has-feedback col-md-12" >
                                  <input type="hidden" name="conID" value="<?php echo $cid; ?>">
                                  <label><?php echo $LegalOfficerComment; ?></label> 
                            </div>
                            <div class="form-group has-feedback col-md-12" >
                              <?php if($LegalOfficerOn == "") { ?>
                                  <label style="color:red"> &nbsp; &nbsp;Not Approved</label>
                              <?php } else { ?>
                                <label style="color:green"> &nbsp; &nbsp; Approved</label>
                              <?php } ?>
                                  
                            </div>
                            <!--<div class="col-xs-12">
                              <button type="submit" class="btn btn-success btn-block btn-flat">Update</button>
                            </div>-->


                      </form>

                    </div>
                   </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>
              
             <div class="col-md-6">
              <div class="box box-info">
               <div class="box-header">
                 MD's Comment
                </div><!-- /.box-header -->
                <div class="box-body">
                   <div class="row">
                    <div class="col-md-12">

                       <form enctype="multipart/form-data" action="updateCONTMD" method="post">
                            <div class="form-group has-feedback col-md-12" >
                                  <input type="hidden" name="conID" value="<?php echo $cid; ?>">
                                  <label name="MDcomment" ><?php echo $MDOfficeComment; ?></label> 
                            </div>
                            <div class="form-group has-feedback col-md-12" >
                              <?php if($MDOfficeOn == "") { ?>
                                 <label style="color:red"> &nbsp; &nbsp;Not Approved</label>
                              <?php } else { ?>
                                <label style="color:green"> &nbsp; &nbsp;Approved</label>
                              <?php } ?>
                                  
                            </div>
                           

                      </form>

                    </div>
                   </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>
              
              
              
              
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
	
	
		
		
		
		
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  

       <?php include('../footer.php') ?>

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
          $(".datep").datepicker();
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
      function adddoc()
      {
      
        var CONID = '<?php echo $CONID ?>';
        //alert(CONID);
        
          var size='standart';
                  var content = '<form role="form" action="addDoc" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Title: </label><input type="text" class="form-control"  name="DocTitle" ></div>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Description: </label><input type="text" class="form-control"  name="DocDescr" ></div>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Link: </label><input type="text" class="form-control"  name="DocLink" ></div> <center> <b>--OR--</b> </center>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Upload Document: </label><input type="file" class="form-control"  name="DocFile" ></div>' +
                   

                   '<button type="submit" class="btn btn-success pull-right">Add Document</button><br/></form>';
                  var title = 'New Document Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script>
	
  </body>
</html>