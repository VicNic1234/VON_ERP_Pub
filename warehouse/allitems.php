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

$PageTitle = "All Items in PO";
/*Get ATTNTION*/
$resultUser = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRowUser = mysql_num_rows($resultUser);

 




//poitems

          /*Get Line Item */
$resultPOIt = mysql_query("SELECT *, purchaseorders.PONo AS PONum FROM poitems LEFT JOIN purchaseorders ON poitems.PONo = purchaseorders.cid  WHERE poitems.isActive=1 AND purchaseorders.DDOfficerOn <> ''");
$NoRowPOIt = mysql_num_rows($resultPOIt); 
 $SN = 0;
if ($NoRowPOIt > 0) {
  while ($row = mysql_fetch_array($resultPOIt)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $PDFNUM = $row['PDFNUM'];
    $PONum = $row['PONum'];
    $PDFItemID = $row['PDFItemID'];
    $description = $row['description'];
    $units = $row['units'];
    $qty = $row['qty'];
    $unitprice = $row['unitprice'];
    $totalprice = floatval($unitprice) * floatval($qty);
    $CreatedBy = $row['CreatedBy'];
    $grn = $row['grn'];
    $gdepn = $row['gdepn'];
    $gdiln = $row['gdiln'];
    $isActive = $row['isActive'];
    $chkGRN = '<label title="set For Good Receive Note"><input type="checkbox" />  set for GRN</label>';
    $chkGDN = '<label title="set For Good Delivery Note"><input type="checkbox" />  set for GDN</label>';
    $chkGRN = "<input type='checkbox' />";
    $setGRN = "<button title='Update Goods Receive Note' class='btn btn-warning' onclick='updateGRN(".$sdid.");'><i class='fa fa-upload' ></i></button>";
    $setGDN = "<button title='Update Goods Delivery Note' class='btn btn-success' onclick='updateGDN(".$sdid.");'><i class='fa fa-upload'></i></button>";

  if($grn == 0)
  {
     $grnv = '';
  }
    
    $LineItems .= '<tr>
                      <td>'.$SN.'</td>
                      <td>'.$PONum.'</td>
                      <td>'.$units.'</td>
                    <td>'.$qty.'</td>
                    <td>'.$description.'</td>
                    <td>'.$unitprice.'</td>
                    <td>'.$totalprice.'</td>
                    <td>'.$setGRN.'</td>
                    <td>'.$setGDN.'</td>
                    </tr>';
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
            All Items Released by C&P
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $PONo; ?></li>
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
             
              <!-- Line items -->
              <div class="col-md-12">
              <div class="box box-success">
                <div class="box-header">
                 <h3>Line Items</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>SN</th>
                        <th>PONo.</th>
                        <th>UNIT</th>
                        <th>QTY</th>
                        <th>DESCRIPTION</th>
                        <th>UNIT PRICE</th>
                        <th>TOTAL PRICE</th>
                        <th>Update GRN</th>
                        <th>Update GDN</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $LineItems; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
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
      function updateGRN(gID)
      {
      
        //var CONID = '<?php echo $CONID ?>';
        //alert(gID);
        
          var size='standart';
                  var content = '<form role="form" action="updateGRN" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="itemID" value="'+gID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>New Update: </label><input type="text" class="form-control"  name="DocTitle" ></div>' +

                    '<br/><br/><div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label> <input type="checkbox" /> Items Received from supplier?  </label>'+
                    '</div>' +

                    '<br/><br/><div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Upload Document: </label><input type="file" class="form-control"  name="DRNFile" ></div><br/><br/>' +
                   

                   '<button type="submit" class="btn btn-success pull-right">Update Good Received Note</button><br/></form>';
                  var title = 'Update Goods Received Note';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script>

     <script type="text/javascript">
      function updateGDN(gID)
      {
      
        //var CONID = '<?php echo $CONID ?>';
        //alert(gID);
        
          var size='standart';
                  var content = '<form role="form" action="updateGDN" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="itemID" value="'+gID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>New Update: </label><input type="text" class="form-control"  name="DocTitle" ></div>' +

                    '<br/><br/><div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label> <input type="checkbox" /> Items delivered to Custormer/Client ?  </label>'+
                    '</div>' +

                    '<br/><br/><div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Upload Document: </label><input type="file" class="form-control"  name="DDNFile" ></div><br/><br/>' +
                   

                   '<button type="submit" class="btn btn-success pull-right">Update Good Delivery Note</button><br/></form>';
                  var title = 'Update Goods Delivery Note';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script>

       <script type="text/javascript">
      function adddoc()
      {
      
        var CONID = '<?php echo $CONID ?>';
        //alert(CONID);
        
          var size='standart';
                  var content = '<form role="form" action="addDocPO" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
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

    <script type="text/javascript">
      function addLI()
      {
      
        var CONID = '<?php echo $CONID ?>';
        //alert(CONID);
        var UOMOpt = '<?php echo $UOMOpt; ?>';
          var size='standart';
                  var content = '<form role="form" action="addPOItem" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Item Description: </label><textarea class="form-control"  name="ItemDesc" required ></textarea></div>' +

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit: </label><select class="form-control"  name="ItemUnit" >'+UOMOpt+'</select></div>' +

                   
                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Quantity: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="nUnitQty" onInput="chkIT()" name="UnitQty" required ></div>' +

                      '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="nUnitPrice" onInput="chkIT()" name="UnitPrice" required ></div>' +


                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Total Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="nTotalPrice"  name="TotalPrice" readonly ></div>' +
                   

                   '<button type="submit" class="btn btn-success pull-right">Add Item</button><br/></form>';
                  var title = 'New Item Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }


      function addMI()
      {
      
        var CONID = '<?php echo $CONID ?>';
        //alert(CONID);
        var UOMOpt = '<?php echo $UOMOpt; ?>';
          var size='standart';
                  var content = '<form role="form" action="addPOMItem" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Item Description: </label><textarea class="form-control"  name="ItemDesc" required ></textarea></div>' +

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Impact Type: </label><select class="form-control"  name="ItemImpact" ><option>ADD</option><option>SUBTRACT</option></select></div>' +

                   
                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Amount: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" name="ItemPrice" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Add Item</button><br/></form>';
                  var title = 'New Miscellaneous Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
      function chkIT()
      {
        var UnitQty = $('#nUnitQty').val();
        var UnitPrice = $('#nUnitPrice').val();
        var TotalPrice = Number(UnitQty) * Number(UnitPrice);
        $('#nTotalPrice').val(TotalPrice);
      }
    </script>

    <script type="text/javascript">
      function addLIPDF()
      {
      
        var CONID = '<?php echo $CONID ?>';
        var UOMOpt = '<?php echo $UOMOpt; ?>';
        var ReQOpt = '<?php echo $ReQOpt ?>';
        var $PDFNUM = '<?php echo $PDFNUM ?>';
        //alert(ReQOpt);
        //var Nosr = '<option value=\"ENL-000000\">ENL-000000</option><option value=\"ENL-000001\">ENL-000001</option><option selected value=\"ENL-000002\">ENL-000002</option>';

          var size='standart';
                  var content = '<form role="form" action="addPOItem" method="POST" enctype="multipart/form-data" style="background:#EEE6E6; border-radius:5px;" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Select PDF: </label><select class="form-control" onchange="setPDFItem(this)" id="PDFNum" name="PDFNum" required ><option value=""> --- </option>'+ReQOpt+'</select></div>' +

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Select PDF Item: </label><select class="form-control" onchange="getPDFItemInfo()"  name="PDFItem" id="PDFItem" ></select></div>' +

                   '<div class="form-group" style="width:90%; display: inline-block; margin: 6px"><label>Item Description: </label><textarea class="form-control"  name="ItemDesc" id="PDFItemDesc" required readonly ></textarea></div>' +

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit: </label><select class="form-control" id="PDFItemUnit"  name="ItemUnit"  >'+UOMOpt+'</select></div>' +

                   
                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Quantity: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="PDFUnitQty"  name="UnitQty" required readonly ></div>' +

                      '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="PDFUnitPrice"  name="UnitPrice" required readonly ></div>' +


                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Total Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="PDFTotalPrice"  name="TotalPrice" readonly ></div>' +
                   

                   '<button type="submit" class="btn btn-success pull-right">Add Item</button><br/></form>';
                  var title = 'PDF Item Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

                  setPDFItem();
      }

      
      function setPDFItem()
      {
        var PDFCODE = $('#PDFNum').val();
        var dataString = { PDFCODE:PDFCODE };
         $.ajax({
                  type: "POST",
                  url: "getPDFItems",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     //ItemD = html;
                     //alert(ItemD); 
                     //alert(html);
                     $('#PDFItem').html("<option value=''> -- </option>").append(html);
                  }
              });
        }

        function getPDFItemInfo()
      {
        var PDFItem = $('#PDFItem').val();
        var dataString = { PDFItem:PDFItem };
         $.ajax({
                  type: "POST",
                  url: "getPDFItemInfo",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     //ItemD = html;
                     //alert(ItemD); 
                     //var  data1 = JSON.stringify(html[0]); 
                     //alert(html);
                     data1 = JSON.parse(html)
                     var Purpose = data1[0].Purpose;
                     //alert(Purpose);

                    var ItemDes = data1[0].ItemDes;
                     $('#PDFItemDesc').html(ItemDes);//alert(ItemDes);

                     var Amount = data1[0].Amount;
                     $('#PDFUnitPrice').val(Amount);

                     var Qty = data1[0].Qty;
                     $('#PDFUnitQty').val(Qty);

                     var TotalPrice = Number(Qty) * Number(Amount);
                     $('#PDFTotalPrice').val(TotalPrice);
                     //$('#PDFItem').html("<option value=''> -- </option>").append(html);
                  }
              });
        }
    </script>
	
  </body>
</html>