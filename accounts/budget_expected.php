<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');

//Let's Read ChartClass
$DivisionOpt = "";
 $DivisionOpt .= '<option value="">--</option>';
$resultDivisionList = mysql_query("SELECT * FROM divisions");
$NoRowDivi = mysql_num_rows($resultDivisionList);
if ($NoRowDivi > 0) {
  while ($row = mysql_fetch_array($resultDivisionList)) {
    $divid = $row['divid'];
    $DivisionName = $row['DivisionName'];
    /*$ctype = $row['ctype'];
    $isActive = $row['isActive'];
    if($isActive == 1){ $Chk = '<input type="checkbox" accttype="Class" acctid="'.$cid.'" onclick="act(this)" checked />'; }
    else { $Chk = '<input type="checkbox" accttype="Class" acctid="'.$cid.'" onclick="act(this)" />'; }
    $RecChartClass .= '<tr><td>'.$cid.'</td><td>'.$class_name.'</td><td>'.$Chk.'</td><td>-</td>
    <td>-</td></tr>';*/
    //<a acctnme="'.$class_name.'" acctid="'.$cid.'" onclick="deleteAcc(this)"><i class="fa fa-trash"></i></a>
    //<a acctnme="'.$class_name.'" acctid="'.$cid.'" onclick="editAcc(this)"><i class="fa fa-edit"></i></a>
    $DivisionOpt .= '<option value="'.$divid.'">'.$DivisionName.'</option>';
    }

  }
  
  
$BudgetRecord = '';
$resultBudget = mysql_query("SELECT * FROM budget_expected");
$NoRowBudget = mysql_num_rows($resultBudget);
if ($NoRowBudget > 0) {
  while ($row = mysql_fetch_array($resultBudget)) {
    $deid = $row['deid'];
    $BudgYear = $row['year'];
    $amount = $row['amount'];
    $isActive = $row['isActive'];
    $BudgetRecord .= '<tr><td>'.$deid.'</td><td>'.$BudgYear.'</td><td>'.number_format($amount).'</td></tr>';
    //$DivisionOpt .= '<option value="'.$divid.'">'. $DivisionName.'</option>';
    //if($isActive == 1){ $Chk = '<input type="checkbox" accttype="Class" acctid="'.$cid.'" onclick="act(this)" checked />'; }
    //else { $Chk = '<input type="checkbox" accttype="Class" acctid="'.$cid.'" onclick="act(this)" />'; }
   // $RecChartClass .= '<tr><td>'.$divid.'</td><td>'.$class_name.'</td><td>'.$Chk.'</td><td>-</td>
   // <td>-</td></tr>';
    //<a acctnme="'.$class_name.'" acctid="'.$cid.'" onclick="deleteAcc(this)"><i class="fa fa-trash"></i></a>
    //<a acctnme="'.$class_name.'" acctid="'.$cid.'" onclick="editAcc(this)"><i class="fa fa-edit"></i></a>

    }

  }

$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Accounts</title>
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
<script type="text/javascript" src="../bootstrap/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	var preLoadTimer;
	var interchk = <?php echo $_SESSION['LockDownTime']; ?>;
	$(this).mousemove(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).keypress(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).scroll(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).mousedown(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	//checktime
	setInterval(function()
	{
	preLoadTimer++;
	if (preLoadTimer > 10)
	{
	window.location.href="../users/lockscreen";
	}
	}, interchk )//30 Secs

});
</script>
<script type="text/javascript">
function act(elem){
  var acctid = $(elem).attr("acctid");
  var accttype = $(elem).attr("accttype");
  //Lets get the Checknob state
  var ActState = $(elem).prop('checked');
 
  $.ajax({
            url: 'activeAcc',
            type: 'POST',
            data: {acctid:acctid, accttype:accttype, actstate:ActState },
            //cache: false,
            //processData:false,
            success: function(html)
            {
                
               
                //$("#sucmsg").html(html);
               //alert(html);
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
              // $("#errmsg").html(textStatus);
              alert(textStatus);
            }           
       });
}

function editAcc(elem)
{
 var acctid = $(elem).attr("acctid"); 
 var acctnme = $(elem).attr("acctnme"); 
    var size='standart';
            var content = '<form role="form" action="editClass" method="POST" ><div class="form-group">' +
             '<input type="hidden" value="'+acctid+'" id="idClass" name="idClass" />'+
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Class Name: </label><input type="text" class="form-control" id="nmeClass" name="nmeClass" value="'+acctnme+'" placeholder="New Class" ></div>' +
             '<button type="submit" class="btn btn-primary pull-right">Update</button><br/></form>';
            var title = 'Edit Account Class';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
           // $('#EditDueDate').datepicker();
        
}

function deleteAcc(elem)
{
 var acctid = $(elem).attr("acctid"); 
 var acctnme = $(elem).attr("acctnme"); 
    var size='standart';
            var content = '<form role="form" action="deleteClass" method="POST" ><div class="form-group">' +
             '<input type="hidden" value="'+acctid+'" id="idClass" name="idClass" />'+
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Class Name: </label>  <label>'+acctnme+'</label></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Are you sure you want to delete this class?</label></div>' +
             '<button type="submit" class="btn btn-primary pull-right">Yes</button><br/></form>';
            var title = 'Delete Account Class';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">No</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

}

function addAcc(elem)
{
 
    var size='standart';
            var content = '<form role="form" action="addEBudget" method="POST" ><div class="form-group">' +
              '<div class="form-group col-md-6"><label>Division Name: </label>'+
              '<select type="text" class="form-control" id="DivID" name="DivID" required >'+
              '<?php echo $DivisionOpt; ?>' +
              '</select>'+
              '</div>' +
              '<div class="form-group col-md-6"><label>Year: </label>'+
              '<input type="text" class="form-control" id="Year" name="Year" value="<?php echo $PresentBusYear; ?>" >'+
              '</div>' +
               '<div class="form-group col-md-4"><label>Expected Revenue: </label>'+
              '<input type="text" class="form-control" id="ER" name="ER" value="" >'+
              '</div>' +
               '<div class="form-group col-md-4"><label>Expected Expense: </label>'+
              '<input type="text" class="form-control" id="EE" name="EE" value="" >'+
              '</div>' +
               '<div class="form-group col-md-4"><label>Expected P/L: </label>'+
              '<input type="text" class="form-control" readonly >'+
              '</div>' +
              '<button type="submit" class="btn btn-primary pull-right">Add Forcast</button><br/></form>';
            var title = 'Expected Budget';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
           // $('#EditDueDate').datepicker();
        
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
  </head>
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
            Accounts - Expected Budget
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Expected Budget</li>
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
          <!-- Info boxes -->
          <div class="row">
           <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Expected Budget</h3>
                  <div class="box-tools pull-right">
                  </div>
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                 <button class="btn btn-success pull-right" id="addAcct" onclick="addAcc(this)" > Add Expected Budget</button>
                 <button class="btn btn-success pull-left" onclick="ExportToExcel()" > Export To Excel</button>

                </div><!-- /.box-header -->
                <div class="box-body">
                   <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Division Name</th>
                        <th>Year</th>
                        <th>Amount</th>
                        <!--<th>Is Active</th>
                        <th>Edit</th>
                        <th>Delete</th>-->
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $BudgetRecord; ?>
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
            
        </div><!-- /.row -->


          

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

       <?php include('../footer.php') ?>
      
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
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="../plugins/chartjs/Chart.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>

    <script type="text/javascript">
     function ExportToExcel()
      {
        var Dat = "Expected Budget List"; //+ new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "Expected Budget",
              filename: Dat,
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true
            });
      }
     </script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) 
    <script src="../dist/js/pages/dashboard2.js" type="text/javascript"></script>-->

    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js" type="text/javascript"></script>
  </body>
</html>