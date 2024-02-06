<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$ACTNOWID = $_SESSION['uid'];
if($ACTNOWID == "")
{
  header('location: ../');
  exit;
}

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

//$resultNumofRP = mysql_query("SELECT * FROM poreq ORDER BY reqid DESC");
$resultPDFCount = mysql_query("SELECT * FROM sysvar WHERE variableName='PDFCOUNT'");
while ($row = mysql_fetch_array($resultPDFCount)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
       $PDFCount = $row['variableValue'];
     }


//GET REQ ID BY YOU /////
$resultRFQ1 = mysql_query("SELECT DISTINCT RequestID FROM poreq WHERE StaffID = '$ACTNOWID' AND (Approved='0' OR Approved='4') ");

$REQIDOPT = "";

$NoRowRFQ1 = mysql_num_rows($resultRFQ1);

{
              //fetch tha data from the database
              while ($row = mysql_fetch_array($resultRFQ1)) {
              
              $REQIDOPT .= '<option value='.$row['RequestID'].'>'.$row['RequestID'].'</option>';
              
              }
              
}

//Unit of Measure

$OptUOM = mysql_query("SELECT * FROM uom ORDER BY UOMAbbr");

$UOMOPT = "";



{
              //fetch tha data from the database
              while ($row = mysql_fetch_array($OptUOM)) {
              
              $UOMOPT .= '<option value='.$row['UOMAbbr'].'>'.$row['UOMAbbr'].'</option>';
              
              }
              
}

//////////////////////////////////

//check number of Purchase Requisition
 //$NoRowNumofRP = mysql_num_rows($resultNumofRP);
 //$nNoRowNumofRP = intval($NoRowNumofRP) + 1;
$REQNO = str_pad($PDFCount,6,"0",STR_PAD_LEFT);
$result = mysql_query("SELECT * FROM poreq WHERE StaffID = '".$ACTNOWID."' AND isActive=1");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($result)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     $reqid = $row['reqid'];
	   $staffName = $row['staffName'];
     $staffID = $row['staffID'];
     $ReqID = $row['RequestID'];
     $ReqDate = $row['RequestDate'];
     $ItemDes = $row['ItemDes'];
     $Purpose = $row['Purpose'];
     $Amount = $row['Amount'];
     $Size = $row['Size'];
     $UOM = $row['UOM'];
     $Type = $row['Type'];
     $attachment = $row['attachment'];
     if($attachment != "") { $attach = '<a href="'.$attachment.'"><i class="fa fa-link"></i></a>'; }
     $Qnt = $row['Qty'];
     $Detele = '';
     $Edit = '';
      $Approved = $row['Approved'];
      if ($Approved == 0) {
        $ApprovedN = "Raised";
        $Detele = '<i  class="fa fa-trash text-red" rid="'.$reqid.'" onclick="deleteit(this)"></i>';
        $Edit = '<i class="fa fa-edit text-blue" rid="'.$reqid.'" reqid="'.$ReqID.'" onclick="edit(this)" ></i>';

      }
      else if ($Approved == 1)
			      {
			        $ApprovedN = "Pending with Supervisor of Department";
			      }
			      else if ($Approved == 2)
			      {
			        $ApprovedN = "Pending with Head of Department";
			      }
			      else if ($Approved == 3)
			      {
			        $ApprovedN = "Pending with Head of Divison";
			      }
			      else if ($Approved == 4) //Skip for Depts under coporate services
			      {
			        $ApprovedN = "Pending with your General Manager";
			      }
			       else if ($Approved == 5) //For only Material Request
			      {
			        $ApprovedN = "Pending with Contracts and Procurement";
			      }

			      else if ($Approved == 6) //For only Material Request
			      {
			        $ApprovedN = "Pending with GM Coporate Service";
			      }

			       else if ($Approved == 7)
			      {
			        $ApprovedN = "Pending with Due Diligence Officer";
			      }

			       else if ($Approved == 8)
			      {
			        $ApprovedN = "Pending with GM Due Diligence";
			      }

			       else if ($Approved == 9)
			      {
			        $ApprovedN = "Pending with MD";
			      }
			       else if ($Approved == 10) //Only for material request
			      {
			        $ApprovedN = "Pending with Due Diligence";
			      }
			      else if ($Approved == 11)
			      {
			        $ApprovedN = "Pending with C&P for Final Close Out";
			      }
			      else if ($Approved == 12)
			      {
			        $ApprovedN = "Pending with Internal Audit";
			      }
			       else if ($Approved == 13)
			      {
			        $ApprovedN = "Approved";
			      }
			      else if ($Approved == 14)
			      {
			        $ApprovedN = "Sent back";
			      }
			      else if ($Approved == 15)
			      {
			        $ApprovedN = "Cancelled";
			      }
               else if ($Approved == 16)
                    {
                      $ApprovedN = "PO Created";
                    }
            else if ($Approved == 17)
                    {
                      $ApprovedN = "Cash Request Raied";
                    }
     
	    $Record .='
					 <tr id="rid-'.$reqid.'">
           
            <td>'.$ReqID.'</td>
            <td>'.$ReqDate.'</td>
            
					  <td>'.$ItemDes.'</td>
						<td>'.$Purpose.'</td>
						<td>'.$Size.'</td>
							<td>'.$UOM.'</td>
								<td>'.$Type.'</td>
            <td>'.$Qnt.'</td>
            <td>'.$ApprovedN.'</td>
            <td>'.$attach.'</td>
            <td>'.$Edit.'</td>
            <td>'.$Detele.'</td>
						
						
					
					
					 </tr>
					 
					 
					 ';
						
     }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | New Requisition </title>
	<link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
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
    <link href="../dist/css/dialog.css" rel="stylesheet" type="text/css" />
    
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                  <h3 class="box-title">Raise Procurement Definition Form</h3>
				   
                  <div class="box-tools pull-right">
                  <a href="ppor"><button class="btn btn-success" type="button"><i class="fa fa-eye"></i> View Request By Form</button></a>
                  </div>
				 <!-- <a style="float:right" href="./"> X</a>-->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8">
                      <p class="text-center">
					  
                        <strong> DETAILS </strong>
                      </p>
                     <form enctype="multipart/form-data" action="addpor" method="post">
      <div class="form-group has-feedback col-md-6" >
        <label>Item(s) Description:</label>
		   <textarea type="text" class="form-control" id="desp" name="desp" placeholder="Item(s) Description" required ><?php echo  $UOMNme1; ?></textarea>

		  </div>
		   <div class="form-group has-feedback col-md-6">
        <label>Purpose:</label>
		   <textarea type="text" class="form-control" id="ppor" name="ppor" placeholder="Justification" required ></textarea>
      </div>

      <!--<div class="form-group has-feedback col-md-6">
        <label>Amount Per Item:</label>
       <input type="text" class="form-control" id="amt" name="amt" oninput="compTAMT()" placeholder="Amount Per Item" value="" onKeyPress="return isNumber(event)" required />
      </div>-->
      
        <div class="form-group has-feedback col-md-3">
        <label>Size:</label>
       <input type="text" class="form-control" id="size" name="size" placeholder="Size of Item" value=""  />
      </div>
      
     <div class="form-group has-feedback col-md-3">
        <label>Type:</label>
       <input type="text" class="form-control" id="type" name="type"  placeholder="Type of Item" value=""  />
      </div>
      
      <div class="form-group has-feedback col-md-3">
        <label>Unit of Measure:</label>
       <!--<input type="text" class="form-control" id="uom" name="uom"  placeholder="UOM" value=""  />-->
       <select class="form-control" id="uom" name="uom" >
           <option value="--">--</option>
           <?php echo $UOMOPT; ?>
       </select>
      </div>

      <div class="form-group has-feedback col-md-3">
        <label>Quantity</label>
       <input type="text" class="form-control" id="qnt" name="qnt" oninput="compTAMT()" placeholder="Quantity" onKeyPress="return isNumber(event)" value="1" required />
      </div>
      
     
       <!--<div class="form-group has-feedback col-md-3">
        <label>Total Amount :</label>
       <input type="text" class="form-control" id="ttam"  value="" onKeyPress="return isNumber(event)" readonly required />
      </div>-->
      
        <script>
          function compTAMT()
          {
              //alert('Ok');
              var AMT = $('#amt').val();
              var QNT = $('#qnt').val();
              var ANS = AMT * QNT;  $('#ttam').val(ANS);
          }
          
      </script>
      
      <input type="hidden" name="ssv" value="<?php echo  $UOMid1; ?>" />
       
		  
		  <div class="form-group has-feedback col-md-12">
         <marquee behavior="alternate"> <label style="color:green">You can attach multiple files after raising request</label> </marquee>
       
      <!-- <input type="file" class="form-control" id="filed" name="filed" />-->
      </div>
         
              
                    </div><!-- /.col -->
                    <div class="col-md-4">
                     


<br>
				  
          <div class="row">
            <!-- //////////////////////////////////////////////////// -->
             <span style="background: #FFE8C4; border-radius:18px; padding: 5px; ">
              <label><input type="radio" name="reqstate" value="new" id="reqstate0" checked="" onclick="chkType()" /> New</label>
              &nbsp; &nbsp; &nbsp;
              <label><input type="radio"  name="reqstate" value="old"  id="reqstate1" onclick="chkType()" /> Add To Previous</label>
              </span>
              <br/>

              <script type="text/javascript">
                function chkType()
                {
                  var isChecked0 = $('#reqstate0').prop('checked');

                  if(isChecked0 == true) 
                    { 
                      $('#flnew').show(); $('#flold').hide(); 
                      $('#selectrqid').prop('disabled', true);
                      $('#subbtn').html("Raise Request");
                    }
                    else 
                    { 
                      $('#flold').show(); $('#flnew').hide();
                      $('#selectrqid').prop('disabled', false);
                      $('#subbtn').html("Add");
                    }
                }
              </script>
            <!-- /////////////////////////////////////////////////////// -->
     
      <div class="form-group has-feedback col-xs-12" id="flnew" style="width:90%; display: inline-block; margin:12px;">
       
        <label>Request ID</label>
       <input type="text" class="form-control" id="rqid" name="rqid" placeholder="Request ID" value="<?php echo $_SESSION['CompanyAbbr']; ?>-<?php echo $REQNO; ?>" readonly required />
      </div>

       <div class="form-group has-feedback col-xs-12" id="flold"  style="width:90%; display: none; margin:12px;">
       
        <label>Request ID</label>
       <select type="text" class="form-control" id="selectrqid" disabled name="rqid" required >
        <option value=""> -- </option>
        <?php echo $REQIDOPT; ?>
      </select>

      </div>

            <div class="col-xs-12">
			      <button type="submit" id="subbtn" class="btn btn-primary btn-block btn-flat">Raise Request</button>
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

   
	
	<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Requisitions by you on ERP</h3>
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
                        
                        <th>Request ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Purpose</th>
                        <th>Size</th>
                        <th>UOM</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Approved</th>
                        
						
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        
                        
                        <th>Request ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Purpose</th>
                        <th>Size</th>
                        <th>UOM</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Approved</th>
                        
          
                       
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
      <div class="row">

              <div class="">
                
                
                <!-- Modal form-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog " style="width:70%">
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

     <div class="row">

              <div class="">
                
                
                <!-- Modal form-->
                <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                  <div class="modal-dialog " style="width:70%">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel1"></h4>
                      </div>
                      <div class="modal-body" id="modal-bodyku1">
                      </div>
                      <div class="modal-footer" id="modal-footerq1">
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
      
      });
    </script>
     <script type="text/javascript">
      function deleteit(elem)
      {
        
        var rid = $(elem).attr('rid');
        var dataString = { rid: rid };
         $.ajax({
              type: "POST",
              url: "deleteIT",
              data: dataString,
              cache: false,
              success: function(html)
              {
                    $("#rid-"+rid).hide();
              }
              });
      }

      function edit(elem)
      {
        var rid = $(elem).attr('rid');
        var reqid = $(elem).attr('reqid');

        var dataString = { rid: rid };
         $.ajax({
              type: "POST",
              url: "getIT",
              data: dataString,
              cache: false,
              success: function(html)
              {
                  setEDIT();
                    var obj = JSON.parse(html);
                    $('#EditDes').html(obj['ItemDes']); //
                    $('#EditJust').html(obj['Purpose']); //
                    $('#EditQty').val(obj['Qty']); //
                    $('#EditAmt').val(obj['Amount']); //
                     $('#EditSize').val(obj['Size']); //
                      $('#EditType').val(obj['Type']); //
                       $('#EditUOM').val(obj['UOM']); //
                       $('#bulidlink').html(obj['Files']); //
                    $('#LitID').val(rid); //
                    $('#iREQID').val(reqid); //

              }
              });
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

        function setModalBox1(title,content,footer,$size)
        {
            document.getElementById('modal-bodyku1').innerHTML=content;
            document.getElementById('myModalLabel1').innerHTML=title;
            document.getElementById('modal-footerq1').innerHTML=footer;
           
            
                $('#myModal1').attr('class', 'modal fade')
                             .attr('aria-labelledby1','myModalLabel1');
                $('.modal-dialog').attr('class','modal-dialog');
           
        }
    </script>

    <script type="text/javascript">
      function adddoc()
      {
      
        var LitID = $('#LitID').val();
        var iREQID = $('#iREQID').val();
        
          var size='standart';
                  var content = '<form role="form" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="kLitID" id="kLitID" value="'+LitID+'" required />'+
                   '<input type="hidden" name="kREQID" id="kREQID" value="'+iREQID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Title: </label><input type="text" class="form-control"  name="DocTitle" id="DocTitle" ></div>' +

                   /* '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Link: </label><input type="text" class="form-control"  name="DocLink" ></div> <center> <b>--OR--</b> </center>' +*/

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Upload Document: </label><input type="file" class="form-control"  name="DocFile" id="DocFile" ></div>' +
                   

                   '<button type="button" onclick="attachdoc()" class="btn btn-success pull-right">Add Document</button>'+

                   
                   '<br/></form>';
                  var title = 'New Document Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox1(title,content,footer,size);
                  $('#myModal1').modal('show');

              
      }

      function attachdoc()
      {
        var REQID = $('#kREQID').val();
        
        var property = document.getElementById('DocFile').files[0];
        var form_data = new FormData();
        
        var DocAttach = $('#DocTitle').val();
        
        form_data.append("filed",property);
        form_data.append("reqid",REQID);
        form_data.append("title",DocAttach);
         $.ajax({
          url:'uploadattach.php',
          method:'POST',
          data:form_data,
          contentType:false,
          cache:false,
          processData:false,
          beforeSend:function(){
            ///$('#msg').html('Loading......');
            //alert("happening");
          },
          success:function(data){
            //console.log(data);
            //$('#msg').html(data);
            
            var obj = JSON.parse(data);
            
            if(obj['MSG'] == "OK")
            {
              var F4m = $('#bulidlink').html();
              var bulidlink  = '<span id="fid-'+obj['FID']+'" style="padding:12px; border-radius:25px; background:#00CCFF; color:#000"><a style="color:#000" href="'+obj['URL']+'" target="_blank"><i class="fa fa-link"></i> '+obj['TITLE']+' </a><i fid="'+obj['FID']+'" ty="new" class="fa fa-trash text-red" onclick="rmFile(this);" title="Click to remove file"></i></span>';
              $('#bulidlink').html(F4m + bulidlink);
              $('#myModal1').modal('hide');
            }
            else
            { alert(obj['MSG']); }

          }
        });
      }
    </script>

    <script type="text/javascript">
      function rmFile(elem)
      {
        var fid = $(elem).attr("fid");
        var ty = $(elem).attr("ty");

        var dataString = { fid: fid, ty:ty };
        $.ajax({
              type: "POST",
              url: "deleteFILE",
              data: dataString,
              cache: false,
              success: function(html)
              {
                //alert(html);
                if(html == "OKNEW")
                {
                    $("#fid-"+fid).hide();
                }

                if(html == "OKOLD")
                {
                    $("#fidold-"+fid).hide();
                }
              }
              });
        
      }
    </script>

    
    
        
        
       
      
      
     
        
      
      
      
      
        
       <!--<input type="text" class="form-control" id="uom" name="uom"  placeholder="UOM" value=""  />-->
       
           
           
       
      

    <script type="text/javascript">
      function setEDIT()
      {
                var UOMOPT = '<?php echo $UOMOPT ?>';

                  var size='standart';
                  var content = '<form role="form" action="updateIT" enctype="multipart/form-data" method="POST" >'+
                   '<div class="row">'+
                   '<div class="col-md-12">'+
                   '<div class="form-group col-md-12">' +
                   '<input type="hidden" value="" id="LitID" name="LitID" />'+ 
                   '<input type="hidden" value="" id="iREQID" name="iREQID" />'+ 
                   '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label><textarea class="form-control" id="EditDes" name="EditDes" placeholder="Description"></textarea></div>' +

                   '<div class="form-group col-md-12" ><label>Justification: </label><textarea class="form-control" id="EditJust" name="EditJust" placeholder="Justification"></textarea></div>' +
                   
                    '<div class="form-group col-md-12"><label>Quantity: </label><input type="text" class="form-control" id="EditQty" name="EditQty" placeholder="Quantity" value="" onKeyPress="return isNumber(event)"  ></div>' +
                   
                   
                    '<div class="form-group has-feedback col-md-3"><label>Size:</label><input type="text" class="form-control" id="EditSize" name="size" placeholder="Size of Item" value=""  /></div>' +
                    
                    '<div class="form-group has-feedback col-md-3"><label>Unit of Measure:</label><select class="form-control" id="EditUOM" name="uom" ><option value="--">--</option>' + UOMOPT + '</select></div>' +
                    
                    '<div class="form-group has-feedback col-md-3"><label>Type:</label> <input type="text" class="form-control" id="EditType" name="type"  placeholder="Type of Item" value=""  /></div>' +
                    /*
                     '<div class="form-group has-feedback col-md-3"><label>Overwrite Attachment:</label> <input type="file" class="form-control" id="EditAttach" name="filed"  /></div>' + */
                      '<div class="form-group has-feedback col-md-3"><label>Add Document (Optional) :</label>'+
        '<span onclick="adddoc()" class="btn btn-info" style="font-size: 17px; color:green" title="Click to Attach File"> Click to Attach File <i class="fa fa-plus"></i> <i class="fa fa-file"></i></span></div>'+

         '<div class="form-group" style="width:100%; display: inline-block; margin: 6px" id="bulidlink"></div>' +
                     '<button type="submit" class="btn btn-primary pull-right">Update</button>'+
                     '</div>'+
                     '</div>'+
                    
                    '</form>';
                  var title = 'Edit Item';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                  

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

                  //$('#AddDueDate').datepicker();
          //return false;
        //alert(LinIT);
              
      }
    </script>
	
  </body>
</html>