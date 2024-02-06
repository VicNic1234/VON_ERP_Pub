<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');
//Let's read all Options now
  //Let's Read opt_cal_method
$CalMethod = mysql_query("SELECT * FROM opt_cal_method Where isActive=1 ORDER BY Description");
$NoRowCalMethod = mysql_num_rows($CalMethod);
if ($NoRowCalMethod > 0) {
  while ($row = mysql_fetch_array($CalMethod)) {
    $cmid = $row{'calid'};
    $DescriptionCal = $row['Description'];
    $OptCalMethod .= '<option value="'.$cmid.'">'.$DescriptionCal.'</option>';
   }

  }

  //Let's Read opt_earning_freq
$CalEarningFrequ = mysql_query("SELECT * FROM opt_earning_freq Where isActive=1");
$NoRowEarningFrequ = mysql_num_rows($CalEarningFrequ);
if ($NoRowEarningFrequ > 0) {
  while ($row = mysql_fetch_array($CalEarningFrequ)) {
    $enfreqid = $row{'enfreqid'};
    $EarningFrequ = $row['EarningFrequ'];
    $OptEarningFrequ .= '<option value="'.$enfreqid.'">'.$EarningFrequ.'</option>';
   }

  }

  //Let's Read Earnings
$CalEmplGroup = mysql_query("SELECT * FROM earnings_settings Where isActive=1");
$NoRowCalEmplGroup = mysql_num_rows($CalEmplGroup);
if ($NoRowCalEmplGroup > 0) {
  while ($row = mysql_fetch_array($CalEmplGroup)) {
    $empgid = $row{'id'};
    $DescriptionEmGrp = $row['Description'];
    $OptEmpGroup .= '<option value="'.$empgid.'">'.$DescriptionEmGrp.'</option>';
   }

  }

  //Let's Read ChartMaster
$ChartMaster = mysql_query("SELECT * FROM acc_chart_master Where isActive=1 ORDER BY account_name");
$NoRowMaster = mysql_num_rows($ChartMaster);
if ($NoRowMaster > 0) {
  while ($row = mysql_fetch_array($ChartMaster)) {
    $tid = $row{'mid'};
    $account_name = $row['account_name'];
    $OptMsAcct .= '<option value="'.$tid.'">'.$account_name.'</option>';
   }

  }

//Let's Read Earnings
$RecAccSet = "";
$resultAccSet = mysql_query("SELECT *, opt_cal_method.calid AS CalMID, 
  opt_cal_method.Description AS CalDes, earnings_settings.Description AS ElemDes,
  opt_cal_method.isActive AS CalStatus, opt_cal_method.CreatedOn AS calCreated
  FROM opt_cal_method
  LEFT JOIN earnings_settings ON opt_cal_method.ELEMENT = earnings_settings.id");
$NoRowAccSet = mysql_num_rows($resultAccSet);
if ($NoRowAccSet > 0) {
  while ($row = mysql_fetch_array($resultAccSet)) {
    $id = $row{'CalMID'};
    $DescriptionEnrs = $row['CalDes'];
    $Percentage = $row['Percentage'];
    $ElemDes = $row['ElemDes'];
    $ELEMENT = $row['ELEMENT'];
    $Nature = $row['Nature'];
    $CreatedOn = $row['calCreated'];
    $isActive = $row['CalStatus'];
    if($isActive == 1){ $Chk = '<input type="checkbox" accttype="Class" setid="'.$id.'" onclick="act(this)" checked />'; }
    else { $Chk = '<input type="checkbox" accttype="Class" setid="'.$cid.'" onclick="act(this)" />'; }
    $RecAccSet .= '<tr><td>'.$id.'</td><td>'.$DescriptionEnrs.'</td>
    <td>'.$Percentage.'</td><td>'.$ElemDes.'</td>
    <td>'.$Nature.'</td><td>'.$CreatedOn.'</td><td>'.$Chk.'</td>
    <td><a enrid="'.$id.'" enrdes="'.$DescriptionEnrs.'" enrcalm="'.$CalMethod.'" enrapplygrp="'.$ApToSffGrp.'" 
    enrfreq="'.$ErnngFrequ.'" enrgl="'.$GLMaster.'" enrtax="'.$Taxable.'" enrisactive="'.$isActive.'" onclick="editCalMethod(this)"><i class="fa fa-edit"></i></a></td>
    </tr>';
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

function editVar(elem)
{
 var setvar = $(elem).attr("setvar"); 
 var setnme = $(elem).attr("setnme"); 
 var setid = $(elem).attr("setid"); 

   var OptMsAcct = '<?php echo $OptMsAcct; ?>';
    var size='standart';
            var content = '<form role="form" action="editVar" method="POST" ><div class="form-group">' +
            '<input type="hidden" name="VarID" value="'+setid+'">'+
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Variable Name: </label><input type="text" class="form-control" id="EnewVar" name="newVar" placeholder="Variable, e.g VAT" value="'+setnme+'" ></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Expose Screen: </label><select class="form-control" id="EnewVarName" name="newVarName"><option>Payables</option><option>Receivables</option><option>Bank Payment</option><option>Bank Receipt</option></select></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>GL Account: </label><select class="form-control" id="EnewVarID" name="newVarID">'+ OptMsAcct +'</select></div>' +
              '<button type="submit" class="btn btn-primary pull-right">Update Variable</button><br/></form>';
            var title = 'Edit Variable';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
            $('#EnewVarName').val(setvar);
            $('#EnewVarID').val(setid);
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
    /*var OptMsAcct = '<?php echo $OptMsAcct; ?>';
    var OptCalMethod = '<?php echo $OptCalMethod; ?>';
    var OptEarningFrequ = '<?php echo $OptEarningFrequ; ?>';*/
    var OptEmpGroup = '<?php echo $OptEmpGroup; ?>';
    var size='standart';
            var content = '<div class="row">' +
            '<div class="col-md-12">' +
            '<form role="form" action="addCalMethod" method="POST" ><div class="form-group">' +
              '<div class="form-group col-md-6"><label>Description: </label><input type="text" class="form-control" name="newCalMethod" placeholder="Enter Calculation Method Description"></div>' +
              '<div class="form-group col-md-6"><label>Percentage: </label><input  type="number" class="form-control" name="newPercent" /></div>' +
              '<div class="form-group col-md-6"><label>Select Earnings to Apply (Element): </label><select class="form-control" name="newElement">'+ OptEmpGroup +'</select></div>' +
              '<div class="form-group col-md-6"><label>Nature: </label><select class="form-control" name="newNature"><option value="GROSS">GROSS</option><option value="NET">NET</option></select></div>' +
              '<button type="submit" class="btn btn-primary pull-right">Add Calculation Method</button><br/></form>'+
              '</div></div>';
            var title = 'New Calculation Method';
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
            Account - Settings 
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Settings</li>
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
                  <h3 class="box-title"><i class="fa fa-cog"></i></h3>
                  <div class="box-tools pull-right">
                  </div>
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                  <h4> Calculation Method </h4>
                 <button class="btn btn-success pull-right" id="addAcct" onclick="addAcc(this)" > Add Calculation Method</button>
                </div><!-- /.box-header -->
                <div class="box-body">
                   <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th> 
                        <th>Description</th>
                        <th>Percentage</th>
                        <th>Element</th>
                        <th>Nature</th>
                        <th>Created On</th>
                        <th>isActive</th>
                        <th>Edit</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $RecAccSet; ?>
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

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard2.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js" type="text/javascript"></script>
  </body>
</html>