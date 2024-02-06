<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');
//Let's read all Options now
  //Let's Read opt_cal_method
$PayElem = mysql_query("SELECT * FROM payrollelement");
$TabVal = '';
$NoRowPayElem = mysql_num_rows($PayElem);
if ($NoRowPayElem > 0) {
    $SN = 0;
  while ($row = mysql_fetch_array($PayElem)) {
      $SN = $SN + 1;
    $payid = $row['payid'];
     $payname = $row['payname'];
      $caltype = $row['caltype'];
       $valtype = $row['valtype'];
        $payval = $row['payval'];
         $isActive = $row['isActive'];
         $CreatedBy = $row['CreatedBy'];
         $CreatedOn = $row['CreatedOn'];
         $TabVal .= '<tr><td>'.$SN.'</td><td>'.$payname.'</td><td>'.$caltype.'</td><td>'.$valtype.'</td><td>'.$payval.'</td></tr>';
   
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

  //Let's Read opt_employee_group
$CalEmplGroup = mysql_query("SELECT * FROM opt_employee_group Where isActive=1");
$NoRowCalEmplGroup = mysql_num_rows($CalEmplGroup);
if ($NoRowCalEmplGroup > 0) {
  while ($row = mysql_fetch_array($CalEmplGroup)) {
    $empgid = $row{'empgid'};
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
$resultAccSet = mysql_query("SELECT *, earnings_settings.id AS EnrsID,
  earnings_settings.Description AS ErnDes,
  opt_cal_method.Description AS CalMedDes,
  opt_employee_group.Description AS EmpGrp,
  acc_chart_master.account_name AS GLNME,
  earnings_settings.isActive As EnrsStatus FROM earnings_settings
  INNER JOIN acc_chart_master ON earnings_settings.GLMaster = acc_chart_master.mid
  INNER JOIN opt_cal_method ON earnings_settings.CalMethod = opt_cal_method.calid
  INNER JOIN opt_earning_freq ON earnings_settings.EarningFrequ = opt_earning_freq.enfreqid 
  INNER JOIN opt_employee_group ON earnings_settings.AppliedToStaffGroup = opt_employee_group.empgid 
  ");
$NoRowAccSet = mysql_num_rows($resultAccSet);
if ($NoRowAccSet > 0) {
  while ($row = mysql_fetch_array($resultAccSet)) {
    $id = $row{'EnrsID'};
    $DescriptionEnrs = $row['ErnDes'];
    $CalMethod = $row['CalMethod'];
    $CalMethodV = $row['CalMedDes'];
    $ApToSffGrp = $row['AppliedToStaffGroup'];
    $ApToSffGrpV = $row['EmpGrp'];
    $ErnngFrequ = $row['EarningFrequ'];
    $ErnngFrequV = $row['EarningFrequ'];
    $GLMaster = $row['GLMaster']; 
    $GLMasterV = $row['GLNME']; 
    $Taxable = $row['Taxable'];
    $isActive = $row['EnrsStatus'];
    if($Taxable == 1) { $Taxable = "YES"; } else { $Taxable = "NO"; }
    if($isActive == 1){ $Chk = '<input type="checkbox" accttype="Class" setid="'.$id.'" onclick="act(this)" checked />'; }
    else { $Chk = '<input type="checkbox" accttype="Class" setid="'.$cid.'" onclick="act(this)" />'; }
    $RecAccSet .= '<tr><td>'.$id.'</td><td>'.$DescriptionEnrs.'</td><td>'.$CalMethodV.'</td>
    <td>'.$ApToSffGrpV.'</td><td>'.$ErnngFrequ.'</td>
    <td>'.$GLMasterV.'</td><td>'.$Taxable.'</td><td>'.$Chk.'</td>
    <td><a enrid="'.$id.'" enrdes="'.$DescriptionEnrs.'" enrcalm="'.$CalMethod.'" enrapplygrp="'.$ApToSffGrp.'" 
    enrfreq="'.$ErnngFrequ.'" enrgl="'.$GLMaster.'" enrtax="'.$Taxable.'" enrisactive="'.$isActive.'" onclick="editEarning(this)"><i class="fa fa-edit"></i></a></td>
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
/*
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
  
    var size='standart';
            var content = '<div class="row">' +
            '<div class="col-md-12">' +
            '<form role="form" action="addEarning" method="POST" ><div class="form-group">' +
              '<div class="form-group col-md-6"><label>Description: </label><input type="text" class="form-control" name="newEarning" placeholder="Enter Earning Description"></div>' +
              '<div class="form-group col-md-6"><label>Method Of Calculation: </label><select class="form-control" name="newCalMethod">'+ OptCalMethod +'</select></div>' +
              '<div class="form-group col-md-6"><label>Policy Application: </label><select class="form-control" name="newPolicyApp">'+ OptEmpGroup +'</select></div>' +
              '<div class="form-group col-md-6"><label>Earning Frequency: </label><select class="form-control" name="newEarnFreq">'+ OptEarningFrequ +'</select></div>' +
              '<div class="form-group col-md-6"><label>GL Application: </label><select class="form-control" name="newGLApp">'+OptMsAcct+'</select></div>' +
              '<div class="form-group col-md-6"><label>Taxable: </label><select class="form-control" name="newTaxable"><option value="1">YES</option><option value="0">NO</option></select></div>' +
              '<button type="submit" class="btn btn-primary pull-right">Add Earning</button><br/></form>'+
              '</div></div>';
            var title = 'New Earning';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
           // $('#EditDueDate').datepicker();
        
}

*/
function addNE()
{
  
    var size='standart';
           var content = '<div class="row">' +
            '<div class="col-md-12">' +
            '<form role="form" action="addNE" method="POST" ><div class="form-group">' +
              '<div class="form-group col-md-6"><label>Element name: </label><input type="text" class="form-control" name="Nme" placeholder="e.g: Basic" required ></div>' +
              //'<div class="form-group col-md-6"><label class="form-control col-md-6"> <input type="radio" name="caltype" value="Percentage" /> Percentage  </label> <label class="form-control col-md-6"> <input type="radio" name="caltype" value="Fixed" /> Fixed  </label></div>' +
              '<div class="form-group col-md-6"><label>Calculation Type: </label><select class="form-control" name="valtype"><option value="Addition">Addition</option><option value="Deduction">Deduction</option></select></div>' +
              '<div class="form-group col-md-6"><label>Value Type: </label><select class="form-control" name="caltype"><option value="Percentage">Percentage</option><option value="Fixed">Fixed</option></select></div>' +
              '<div class="form-group col-md-6"><label>Value: </label><input type="text" class="form-control" name="Val" placeholder="25" onKeyPress="return isNumber(event)" required ></div>' +
              '<button type="submit" class="btn btn-primary pull-right">Add New Element</button><br/></form>'+
              '</div></div>';
            var title = 'New Payroll Element';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            
            //alert("Testing");

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
            Human Resources - Payroll Element 
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
                  <h4> Payroll Settings </h4>
                 <button class="btn btn-success pull-right" id="addAcct" onclick="addNE()" > Add New Element</button>
                </div><!-- /.box-header -->
                <div class="box-body">
                   <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Cal. type</th>
                        <th>Value Type</th>
                        <th>Value</th>
                        
                      <!--  <th>isActive</th>
                        <th>Edit</th> -->
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $TabVal; ?>
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
  </body>
</html>