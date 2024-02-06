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
$resultPDFCount = mysql_query("SELECT * FROM sysvar WHERE variableName='ICTCOUNT'");
while ($row = mysql_fetch_array($resultPDFCount)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
       $ICTCount = $row['variableValue'];
     }


//GET REQ ID BY YOU /////
$OptReqCat;
$resultChartClass = mysql_query("SELECT * FROM reqcategory");
$NoRowChartClass = mysql_num_rows($resultChartClass);
if ($NoRowChartClass > 0) {
  while ($row = mysql_fetch_array($resultChartClass)) {
    $cid = $row['id'];
    $class_name = $row['CategoryName'];
    $OptReqCat .= '<option value="'.$cid.'">'.$class_name.'</option>';
    }
  }

//////////////////////////////////


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Quick Survey </title>
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
              <div class="box" style="background:#CCFFFF">
                <div class="box-header with-border">
                  <h3 class="box-title">Quick Survey Form</h3>
				   
                  <div class="box-tools pull-right">
                  
                  </div>
				 <!-- <a style="float:right" href="./"> X</a>-->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form action="sndq" method="post">
                  <div class="row">
                    <div class="col-md-12">
                        <label>The ERP has helped save time for me</label>
                        <div class="form-control">
                            <label> <input type="radio" name="Q1" value="3" /> Very Satisfied  </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q1" value="2" /> Satisfied </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q1" value="1" /> Not Satisfied </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q1" value="0" /> Not Very Satisfied </label>
                        </div>
                        <br/> <br/>
                    </div>
                    
                    <div class="col-md-12">
                        <label>The ERP has helped ease my work process</label>
                        <div class="form-control">
                            <label> <input type="radio" name="Q2" value="3" /> Very Satisfied  </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q2" value="2" /> Satisfied </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q2" value="1" /> Not Satisfied </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q2" value="0" /> Not Very Satisfied </label>
                        </div>
                        <br/> <br/>
                    </div>
                    
                    <div class="col-md-12">
                        <label>The ERP has helped reduce paper printing</label>
                        <div class="form-control">
                            <label> <input type="radio" name="Q3" value="3" /> Very Satisfied  </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q3" value="2" /> Satisfied </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q3" value="1" /> Not Satisfied </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q3" value="0" /> Not Very Satisfied </label>
                        </div>
                        <br/> <br/>
                    </div>
                   
                    <div class="col-md-12">
                        <label>The ERP has helped in my decision making process</label>
                        <div class="form-control">
                            <label> <input type="radio" name="Q4" value="3" /> Very Satisfied  </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q4" value="2" /> Satisfied </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q4" value="1" /> Not Satisfied </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q4" value="0" /> Not Very Satisfied </label>
                        </div>
                        <br/> <br/>
                    </div>
                    
                    <div class="col-md-12">
                        <label>I get good ERP Technical Support</label>
                        <div class="form-control">
                            <label> <input type="radio" name="Q5" value="3" /> Very Satisfied  </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q5" value="2" /> Satisfied </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q5" value="1" /> Not Satisfied </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q5" value="0" /> Not Very Satisfied </label>
                        </div>
                        <br/> <br/>
                    </div>
                    
                    <div class="col-md-12">
                        <label>The ERP System improved my interdepartmental relationships</label>
                        <div class="form-control">
                            <label> <input type="radio" name="Q6" value="3" /> Very Satisfied  </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q6" value="2" /> Satisfied </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q6" value="1" /> Not Satisfied </label>
                            &nbsp; &nbsp; &nbsp; &nbsp;
                            <label> <input type="radio" name="Q6" value="0" /> Not Very Satisfied </label>
                        </div>
                        <br/> <br/>
                    </div>
                    
                    <div class="col-md-12">
                        <label>My Observations</label>
                        <div>
                            <textarea class="form-control" name="observation"></textarea>
                        </div>
                        <br/> <br/>
                    </div>
                    
                    <div class="col-md-12">
                        <label>My Recommendation</label>
                        <div>
                            <textarea class="form-control" name="recommendation"></textarea>
                        </div>
                        <br/> <br/>
                    </div>
                    
                    <button class="btn btn-success pull-right"> Send Survey Report </button>
                   
                  </div><!-- /.row -->
                  </form>
                </div><!-- ./box-body -->
              
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
              url: "deleteICTR",
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
        var dataString = { rid: rid };
         $.ajax({
              type: "POST",
              url: "getICTR",
              data: dataString,
              cache: false,
              success: function(html)
              {
                  setEDIT();
                    var obj = JSON.parse(html);
                    $('#EditDes').html(obj['ItemDes']); //
                    $('#EditCat').val(obj['Purpose']); //
                    $('#LitID').val(rid); //

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
    </script>

    <script type="text/javascript">

      var OptReqCat = '<?php echo $OptReqCat; ?>';
      function setEDIT()
      {
       
                  var size='standart';
                  var content = '<form role="form" action="updateITR" method="POST" ><div class="form-group">' +
                   '<input type="hidden" value="" id="LitID" name="LitID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block;"><label>Description: </label><textarea class="form-control" id="EditDes" name="EditDes" placeholder="Description"></textarea></div>' +

                   '<div class="form-group" style="width:100%; display: inline-block;"><label>Category: </label><select class="form-control" id="EditCat" name="EditCat" >'+OptReqCat+'</select></div>' +
                   
                  
                    '<button type="submit" class="btn btn-primary">Update</button></form>';
                  var title = 'Edit Request';
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