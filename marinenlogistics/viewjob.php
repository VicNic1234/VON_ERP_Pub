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
 $resultLI = mysql_query("SELECT *, mljobs.Comment AS RFQComment FROM mljobs 
 LEFT JOIN customers ON mljobs.cusid = customers.cusid
 LEFT JOIN users ON mljobs.PEAID = users.uid
 LEFT JOIN businessunit ON mljobs.RFQBusUnit = businessunit.id
 WHERE JOBid='".$CONID."'
 "); //WHERE isActive=1 ORDER BY cid

 $NoRowLI = mysql_num_rows($resultLI);
//fetch tha data from the database
   if ($NoRowLI > 0) 
   {
   $SN = 1;
  while ($row = mysql_fetch_array($resultLI)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     
    $cid = $row['JOBid'];
    $RFQNo = $row['JOBNum'];
    $CustormerNme = $row['CustormerNme'];
    $Comment = $row['RFQComment'];
    $BusUNit = $row['BussinessUnit'];
    $BusUNitID = $row['RFQBusUnit'];
    $DateStart = $row['DateStart']; 
    $DateEnd = $row['DateEnd'];
    $Attention = $row['Attention'];
    $RFQCurrency = $row['Currency'];
    //$RaisedBy = $row['Firstname'] . " " . $row['Surname'];//$row['RaisedBy'];
    $FileLink = $row['Attachment'];
    $Scope = $row['Scope'];
    $Source = $row['Source'];
    $JOBType = $row['JOBType'];
    //$JOBType = $row['JOBType'];
   
    }
  }
  else
  {
    $_SESSION['ErrMsg'] = "Oops! an error occured, try again";
    header('Location: jobs');
    exit;
  }

 /*Get CURRENCY*/
$resultCurr = mysql_query("SELECT * FROM currencies Order By Abbreviation");
$NoRowCurr = mysql_num_rows($resultCurr);
if ($NoRowCurr > 0) {
  while ($row = mysql_fetch_array($resultCurr)) 
  {
    $cAB = $row['Abbreviation'];
    
    if($cAB == $RFQCurrency)
    {
     $CurrOpt .= '<option selected value="'.$cAB.'">'.$cAB.'</option>';
    }
    else
    {
      $CurrOpt .= '<option value="'.$cAB.'">'.$cAB.'</option>';
    }
   
  }
 }

$OptUOM = "";
$resultUOM = mysql_query("SELECT * FROM uom Order By UOMAbbr");
$NoRowUOM = mysql_num_rows($resultUOM);
if ($NoRowUOM > 0) {
  while ($row = mysql_fetch_array($resultUOM)) 
  {
    $UOMid = $row['UOMid'];
    $UOMNme = $row['UOMNme'];
    $UOMAbbr = $row['UOMAbbr'];
    
   
      $OptUOM .= '<option value="'.$UOMAbbr.'">'.$UOMNme.' ('.$UOMAbbr.') </option>';
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
    if($BusUNitID == $DivID)
    {
      $RecDiv .= '<option value="'.$DivID.'" selected >'.$DivName.'</option>';
    }
    else
    {
      $RecDiv .= '<option value="'.$DivID.'">'.$DivName.'</option>';
    }
  }
 }



 

 //////////////////////////////////
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);




	

?>
<?php if ($NoRowCUS > 0) 
            {
              //fetch tha data from the database
              while ($row = mysql_fetch_array($resultCUS)) {
             
              $Custms .= '<option value="'.$row['cussnme'].'">'.$row['CustormerNme'].'</option>';
            
              }
              
            }
        

         /*Get Supporting Docs*/
$resultSDoc = mysql_query("SELECT * FROM supportingdoc Where docid='".$CONID."' AND module='RFQ' Order By sdid");
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

         /*Get Terms*/
$resultTerm = mysql_query("SELECT * FROM terms Where TransID='".$CONID."' AND module='RFQ' AND isActive=1 Order By termsID");
$NoRowTerm = mysql_num_rows($resultTerm);
 $SN = 0;
if ($NoRowTerm > 0) {
  while ($row = mysql_fetch_array($resultTerm)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['termsID'];
    $Term = $row['Terms'];
    $addedby = $row['CreatedBy'];
   
    $delDoc = "";
    if($addedby == $MYID)
    {
      $delDoc = '<a href="delterm?id='.$sdid.'"><i class="fa fa-trash"></i></a>';
    }
    $Terms .= '<tr>
                      <td>'.$SN.'</td>
                      <td>'.$Term.'</td>
                      <td>'.$delDoc.'</td></tr>';
  }
 }  
      /*Get Requiremants*/
$resultSRFQ = mysql_query("SELECT * FROM mlrequirements Where JOBCode='".$CONID."'");
$NoRowRFQ = mysql_num_rows($resultSRFQ);
 $SN = 0;
if ($NoRowRFQ > 0) {
  while ($row = mysql_fetch_array($resultSRFQ)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['LitID'];
    $description = $row['Description'];
    $UOM = $row['UOM'];
    $Qty = $row['Qty']." (".$UOM.")";
    $Qtyn = $row['Qty'];
    $UnitCost = $row['UnitCost'];
    $ExtendedCost = $row['ExtendedCost'];
    
    $addedby = $row['addedby'];
   
    if($addedby == $MYID)
    {
      $delDoc = '<i onclick="editli(this)" lineitemID="'.$sdid.'" uom="'.$UOM.'" des="'.$description.'" qty="'.$Qtyn.'" unitcost="'.$UnitCost.'" extcost="'.$ExtendedCost.'"  class="fa fa-edit text-green"></i>';
    }
    $LineITEMS .= '<tr>
                      <td>'.$SN.'</td>
                      <td>'.$description.'</td>
                      <td>'.$Qty.'</td>
                      <td>'.$UnitCost.'</td>
                      <td>'.$ExtendedCost.'</td>
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
             JOB No.: <?php echo $RFQNo; ?>
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $RFQNo; ?></li>
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
              <div class="box collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">JOB Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#00C888; border-radius: 15px; padding-top:22px;">
                    
                     <form enctype="multipart/form-data" id="fJOB" name="fJOB" action="updateJOB" method="post">
          <div class="form-group has-feedback col-md-6" >
                <label>Customer/Client:</label>
               <!-- <select class="form-control srcselect" id="CusSource" name="CusSource" onchange="setRFQNo(this)" required>
                <option value=""> Choose Customer</option>
                <?php echo $CusOpt; ?>
                </select>-->
                <input type="hidden" name="JOBID" value="<?php echo $CONID; ?>" >
                <input type="text" value="<?php echo $CustormerNme; ?>" class="form-control" readonly name="">
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>

           <div class="form-group has-feedback col-md-3" >
                <label>Scope:</label>
                <select class="form-control srcselect" id="Scope" name="Scope" required >
                <option value="Within">Within</option>
                <option value="Out-Of">Out-Of</option>
                
                </select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>

           <div class="form-group has-feedback col-md-3" >
                <label>Source:</label>
                <select class="form-control srcselect" id="Source" name="Source" required >
                <option value="Direct Client">Direct Client</option>
                <option value="Brooker">Brooker</option>
                
                </select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>
      
       <script type="text/javascript">
       function setRFQNo(elem)
       {
         var CusF = $(elem).val(); var CusSplit = CusF.split("@@");
         var RFQCount = '<?php echo $CONTRNO; ?>';
         var Td = new Date();  var year = Td.getFullYear(); year = year.toString().substr(-2);
         var month = Td.getMonth(); month = (month + 1).toString();

          //if month is 1-9 pad right with a 0 for two digits
          if (month.length === 1)
          {
              month = "0" + month;
          }
         var RFQNum = "ENL/"+CusSplit[1]+"/ML/"+ year + "/" + month + "/"+RFQCount;
         $('#JOBNo').val(RFQNum);

       }  
       </script>

        <div class="form-group has-feedback col-md-4">
            <label>JOB Type:</label>
           <select class="form-control" name="JOBType" id="JOBType" required >
            <option value="">--</option>
            <option value="RFH">RFH (Hiring) </option>
            <option value="RFTC">RFTC (Time Chatter) </option>
            <option value="RFVC">RFVC (Vogue Chatter) </option>
            <option value="RFD">RFD (Demised Chatter) </option>
           
           </select>
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>
      
      <div class="form-group has-feedback col-md-4">
                    <label>Start Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" value="<?php echo $DateStart; ?>" readonly name="conSDate" required />
                    </div><!-- /.input group -->
          </div>

         <div class="form-group has-feedback col-md-4">
                 
                    <label>End Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" value="<?php echo $DateEnd; ?>" readonly name="conEDate" />
                    </div><!-- /.input group -->
          </div>

           <div class="form-group has-feedback col-md-4">
            <label>Currency (optional):</label>
           <select class="form-control" name="currency">
            <option value="">--</option>
            <?php echo $CurrOpt; ?>
           </select>
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-8">
            <label>Choose Business Unit:</label>
            <select class="form-control" id="conBusn" name="conBusn" required >
            <option value=""> Choose Business Unit</option>
            <?php echo $RecDiv; ?>
            </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>

         

          <div class="form-group has-feedback col-md-6">
            <label>Attn (Contact):</label>
           <input type="text" class="form-control" name="attn" value="<?php echo $Attention; ?>" />
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>

          <!--<div class="form-group has-feedback col-md-6">
            <label>Personnel Responsible:</label>
           <select class="form-control msrcselect" name="personelresp[]" required>
            <?php echo $StaffList; ?>
           </select>
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>
        -->

     
     
     <div class="form-group has-feedback col-md-12">
       <textarea rows="4" cols="50" placeholder=" Enter comment here..." id="Comment" name="Comment" style="width:100%; display: inline-block;"><?php echo $Comment; ?></textarea>
     </div>
   
      
  </div><!-- /.col -->
                    
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>JOB Number</strong>
                      </p>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" readonly value="ENL/CUS/ML/<?php echo Date('y/m') ; ?>/<?php echo $CONTRNO; ?>" id="JOBNo" name="JOBNo" placeholder="ENL/CUS/ML/002"  required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
          <br/>
           
<br/>
     
      <p class="text-center">
                        <strong>Add JOB Document to overwrite previous (Optional)</strong>
                      </p>
      <div class="form-group has-feedback">
            <input type="file" id="JOBFile" name="JOBFile" class="form-control" />
      
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>    
     

          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Update Job</button>
            </div><!-- /.col -->
          </div>
                      </form> 
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->


             

              <div class="col-md-12">
                 <div class="box box-info">
                <div class="box-header">
                 Line Items
                 <form action="printQ" method="POST">
                  <input type="hidden" name="poid" value="<?php echo $cid; ?>">
                  <button class="btn btn-warning pull-right"> <i class="fa fa-file"></i>  View Quotation </button>
                  </form>

                 <button class="btn btn-success pull-right" onclick="addli()"> Add Line Item</button>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Unit Rate</th>
                        <th>Total Rate</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php echo $LineITEMS; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>

                        <div class="col-md-6">
              <div class="box box-info">
                <div class="box-header">
                 Supporting Documents
                 <button class="btn btn-primary pull-right" onclick="adddoc()"> Add Document</button>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>File Title</th>
                        <th>Description</th>
                        <th>Link</th>
                        <th>Delete</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $SupDocs; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>


                           <div class="col-md-6">
              <div class="box box-info">
                <div class="box-header">
                 Terms
                 <button class="btn btn-primary pull-right" onclick="addterm()"> Add Terms</button>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Term</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Terms; ?>
                    </tbody>
                  </table>
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

          var Scope  = '<?php echo $Scope; ?>';
          var Source  = '<?php echo $Source; ?>';
          var JOBType  = '<?php echo $JOBType; ?>';

          $('#Scope').val(Scope);
          $('#Source').val(Source);
          $('#JOBType').val(JOBType);
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

      function addterm()
      {
      
        var CONID = '<?php echo $CONID ?>';
        //alert(CONID);
        
          var size='standart';
                  var content = '<form role="form" action="addTerm" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group col-md-12"><label>Term: </label><textarea class="form-control" name="Term"></textarea></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Add Term</button><br/></form>';
                  var title = 'New Term Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }

      function addli()
      {
      
        var CONID = '<?php echo $CONID ?>';
        var OptUOM = '<?php echo $OptUOM ?>';
        //alert(CONID);
        
          var size='standart';
                  var content = '<form role="form" action="addLi" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group col-md-12"><label>Line Item Description: </label><textarea class="form-control"  name="LiDescription" required ></textarea></div>' +

                    '<div class="form-group col-md-6"><label>Quantity: </label><input type="text" class="form-control" id="LiQty" name="LiQty" oninput="computeTotal()" onKeyPress="return isNumber(event)" required ></div>' +

                    '<div class="form-group col-md-6"><label>Unit Rate: </label><input type="text" class="form-control" id="LiRate" name="LiRate" value="1" oninput="computeTotal()" onKeyPress="return isNumber(event)" required ></div>'+

                    '<div class="form-group col-md-6"><label>Total Rate: </label><input type="text" class="form-control" id="LiTRate"  name="LiTRate" onKeyPress="return isNumber(event)" required readonly ></div>' +

                    '<div class="form-group col-md-6"><label>Unit of Measure: </label><select class="form-control"  name="UOM" required >'+OptUOM+'</select></div>' +

                      '<div class="form-group col-md-6"><button type="submit" class="btn btn-success">Add Line Item</button></div>' +
                   

                   '<br/></form>';
                  var title = 'New Line Item Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }

       function editli(elem)
      {

        var lineitemID = $(elem).attr("lineitemID");
        var des = $(elem).attr("des");
        var qty = $(elem).attr("qty");
        var unitcost = $(elem).attr("unitcost");
        var extcost = $(elem).attr("extcost");
        var uom = $(elem).attr("uom");
      
        var CONID = '<?php echo $CONID ?>';
        var OptUOM = '<?php echo $OptUOM ?>';
        //alert(CONID);
        
          var size='standart';
                  var content = '<form role="form" action="updateLi" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="lineitemID" value="'+lineitemID+'" required />'+
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group col-md-12"><label>Line Item Description: </label><textarea class="form-control"  name="LiDescription" required >'+des+'</textarea></div>' +

                    '<div class="form-group col-md-6"><label>Quantity: </label><input type="text" class="form-control" id="LiQty" name="LiQty" oninput="computeTotal()" onKeyPress="return isNumber(event)" value="'+qty+'" required ></div>' +

                    '<div class="form-group col-md-6"><label>Unit Rate: </label><input type="text" class="form-control" id="LiRate" name="LiRate" value="'+unitcost+'" oninput="computeTotal()" onKeyPress="return isNumber(event)" required ></div>'+

                    '<div class="form-group col-md-6"><label>Total Rate: </label><input type="text" class="form-control" id="LiTRate"  name="LiTRate" value="'+extcost+'" onKeyPress="return isNumber(event)" required readonly ></div>' +

                    '<div class="form-group col-md-6"><label>Unit of Measure: </label><select class="form-control" id="eUOM"  name="UOM" required >'+OptUOM+'</select></div>' +

                      '<div class="form-group col-md-6"><button type="submit" class="btn btn-info">Update Line Item</button></div>' +
                   

                   '<br/></form>';
                  var title = 'Edit Line Item Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
                  $('#eUOM').val(uom);

              
      }
    </script>

    <script type="text/javascript">
      function computeTotal()
      {
        var LiQty = $('#LiQty').val();
        var LiRate = $('#LiRate').val();
        var LiTRate = Number(LiQty) * Number(LiRate);
        $('#LiTRate').val(LiTRate);

      }
    </script>
	
  </body>
</html>