<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');

//Let's Read Currencies
$CurrnQy = mysql_query("SELECT * FROM currencies Where isActive=1 ORDER BY CurrencyName");
$NoRowCurrn = mysql_num_rows($CurrnQy);
if ($NoRowCurrn > 0) {
  while ($row = mysql_fetch_array($CurrnQy)) {
    $curID = $row['curID'];
    $curname = $row['Abbreviation'];
    if($curname == "NGN")
    {
    $OptCurrency .= '<option value="'.$curname.'">'.$curname.'</option>';
    }
   }

  }
  //Let's Read ChartClass
$ChartClassQ = mysql_query("SELECT * FROM acc_chart_class Where isActive=1 ORDER BY class_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'cid'};
    $cname = $row['class_name'];
    $OptClass .= '<option value="'.$cid.'">'.$cname.'</option>';
   }

  }

  //Let's Read ChartType
$ChartTypeQ = mysql_query("SELECT * FROM acc_chart_types Where isActive=1 ORDER BY name");
$NoRowType = mysql_num_rows($ChartTypeQ);
if ($NoRowType > 0) {
  while ($row = mysql_fetch_array($ChartTypeQ)) {
    $tid = $row{'id'};
    $tname = $row['name'];
    $OptType .= '<option value="'.$tid.'">'.$tname.'</option>';
   }

  }

//Let's Read ChartClass
$RecChartMaster = "";
$resultChartMaster = mysql_query("SELECT acc_chart_types.id, acc_chart_types.name, acc_chart_types.class_id, acc_chart_types.isActive, 
  acc_chart_master.account_type, acc_chart_master.account_name, acc_chart_master.mid, acc_chart_master.account_code, acc_chart_master.account_code2, acc_chart_master.isActive As MsIsActive, acc_chart_class.class_name As ClassName, acc_chart_class.cid As CID FROM acc_chart_master LEFT JOIN acc_chart_types
ON acc_chart_master.account_type=acc_chart_types.id 
LEFT JOIN acc_chart_class 
ON acc_chart_types.class_id = acc_chart_class.cid
 ORDER BY acc_chart_types.class_id, acc_chart_types.name   ");
$NoRowChartMaster = mysql_num_rows($resultChartMaster);
if ($NoRowChartMaster > 0) {
  while ($row = mysql_fetch_array($resultChartMaster)) {
    $mid = $row{'mid'};
    $id = $row{'account_code'};
    $id2 = $row{'account_code2'};
    $name = $row['account_name'];
    $type_name = $row['name']; //ClassName
    $class_name = $row['ClassName']; //ClassName
    $classID = $row['CID']; //ClassName
    $isActive = $row['MsIsActive'];
    if($isActive == 1){ $Chk = '<input type="checkbox" accttype="Master" acctid="'.$id.'" onclick="act(this)" checked />'; }
    else { $Chk = '<input type="checkbox" accttype="Master" acctid="'.$id.'" onclick="act(this)" />'; }
    $RecChartMaster .= '<tr><td>'.$id.'</td><td>'.$id2.'</td><td>'.$name.'</td><td>'.$type_name.'</td><td>'.$class_name.'</td><td>'.$Chk.'</td><td><a acctnme="'.$name.'" accttype="'.$type_name.'" acctclass="'.$classID.'" acctid="'.$mid.'" acctcode="'.$id.'" acctcode2="'.$id2.'" onclick="editAcc(this)" ><i class="fa fa-edit"></i></a></td>
    <td>-</td></tr>';
    //<a acctnme="'.$name.'" accttype="'.$type_name.'" acctclass="'.$classID.'" acctid="'.$mid.'" acctcode="'.$id.'" onclick="deleteAcc(this)" ><i class="fa fa-trash"></i></a>
    //<a onclick="setOB(this)" acctid="'.$mid.'" acctname="'.$name.'" > <i class="fa fa-money text-green" title="Set Opening Balance"></i> </a>
    //
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
<!-- DatePicker -->
  <link href="../mBOOT/jquery-ui.css" rel="stylesheet" type="text/css">
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

function eselectType(elem)
{
  var acctclass = $(elem).val();
  $('#editType').html(loadAccType(acctclass));
}

function selectType(elem)
{
  var acctclass = $(elem).val();
  $('#addType').html(loadAccType(acctclass));
}

function editAcc(elem)
{
 var acctid = $(elem).attr("acctid"); 
 var acctcode = $(elem).attr("acctcode"); 
 var oacctcode = $(elem).attr("acctcode2"); 
 var acctnme = $(elem).attr("acctnme"); 
 var accttype = $(elem).attr("accttype"); 
 var acctclass = $(elem).attr("acctclass"); 

  var OptClClass = '<?php echo $OptClass ?>'
  var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
  
    var size='standart';
            var content = '<form role="form" action="editMaster" method="POST" ><div class="form-group">' +
             '<input type="hidden" value="'+acctid+'" id="accID" name="accID" />'+
             '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Account Class: </label><select class="form-control" id="editClass" name="editClass" onchange="eselectType(this)">'+OptClClass+'</select></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Account Type: </label><select class="form-control" id="editType" name="editType">'+OptType+'</select></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Account Code: </label><input type="text" class="form-control" id="eaccCode" name="eaccCode" placeholder="Account Code" onKeyPress="return isNumber(event)" value="'+acctcode+'" ></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label> Old Code: </label><input type="text" class="form-control" id="oaccCode" name="oaccCode" placeholder="Account Code" onKeyPress="return isNumber(event)" value="'+oacctcode+'" ></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Account Name: </label><input type="text" class="form-control" id="eaccNme" name="eaccNme" placeholder="Account Name" value="'+acctnme+'" ></div>' +
              
             '<button type="submit" class="btn btn-primary pull-right">Update</button><br/></form>';
            var title = 'Edit Account';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

              $('#editClass').val(acctclass);
             /*$('#editClass option').map(function () {
                if ($(this).text() == acctclass) return this;
            }).attr('selected', 'selected');
            */
             $('#editType option').map(function () {
                if ($(this).text() == accttype) return this;
            }).attr('selected', 'selected');
           // $('#EditDueDate').datepicker();
        
}

function setOB(elem)
{
 var acctid = $(elem).attr("acctid"); 
 var acctname = $(elem).attr("acctname"); 
 var OptCurrency = '<?php echo $OptCurrency; ?>';

 //alert(acctname);
  
    var size='standart';
            var content = '<form role="form" action="setOB" method="POST" ><div class="form-group">' +
             '<input type="hidden" value="'+acctid+'" id="accID" name="accID" />'+
             
             '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Impact Type: </label><select class="form-control" id="impactType" name="impactType"><option>DEBIT</option><option>CREDIT</option></select></div>' +
              
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Currency: </label><select class="form-control" id="CurrOB" name="CurrOB">'+OptCurrency+'</select></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Amount: </label><input type="text" class="form-control" id="AmtOB" name="AmtOB" placeholder="Opening Balance" onKeyPress="return isNumber(event)" required></div>' +

              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Transaction Date: </label><input type="text" class="form-control" id="TDOB" name="TDOB" value="2018/12/31" placeholder="Click to set date" readonly required ></div>' +
              
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Remark: </label><input type="text" class="form-control" id="RemarkOB" name="RemarkOB" value="2018 Closing Balance" placeholder="Remark is required" required ></div>' +
 
             '<button type="submit" class="btn btn-primary pull-right">Set Opening Balance For '+acctname+'</button><br/></form>';
            var title = 'Set Opening Balance For '+acctname;
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

             // $('#editClass').val(acctclass);
             /*$('#editClass option').map(function () {
                if ($(this).text() == acctclass) return this;
            }).attr('selected', 'selected');
            
             $('#editType option').map(function () {
                if ($(this).text() == accttype) return this;
            }).attr('selected', 'selected');
            */
           $('#TDOB').datepicker({dateFormat : 'yy/mm/dd'});
        
}

function deleteAcc(elem)
{
 var acctid = $(elem).attr("acctid"); 
 var acctcode = $(elem).attr("acctcode"); 
 var acctnme = $(elem).attr("acctnme"); 
 var accttype = $(elem).attr("accttype"); 
 var acctclass = $(elem).attr("acctclass"); 

 /// var OptClClass = '<?php echo $OptClass ?>'
 // var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
  
    var size='standart';
            var content = '<form role="form" action="deleteMaster" method="POST" ><div class="form-group">' +
             '<input type="hidden" value="'+acctid+'" id="accID" name="accID" />'+
            '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Account Name: </label><input type="text" class="form-control" id="eaccNme" name="eaccNme" placeholder="Account Name" value="'+acctnme+'" readonly ></div>' +
            '<div class="form-group" style="width:100%; display: inline-block; margin: 6px">Are you sure you want to delete this account from master list?</div>' +
              
             '<button type="submit" class="btn btn-primary pull-right">Yes</button><br/></form>';
            var title = 'Delete Account';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">No</button>';

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

             
        
}

function addAcc(elem)
{   
    var OptClClass = '<?php echo $OptClass ?>'
    var OptType = loadAccType('1');//'<?php echo $OptType ?>'

    var size='standart';
            var content = '<form role="form" action="addMaster" method="POST" ><div class="form-group">' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Account Class: </label><select class="form-control" id="addClass" name="addClass" onchange="selectType(this)">'+OptClClass+'</select></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Account Type: </label><select class="form-control" id="addType" name="addType">'+OptType+'</select></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Account Code: </label><input type="text" class="form-control" id="addCode" name="addCode" placeholder="e.g 1234" onKeyPress="return isNumber(event)" ></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Account Name: </label><input type="text" class="form-control" id="addAcct" name="addAcct" placeholder="Account Name" ></div>' +

              '<button type="submit" class="btn btn-primary pull-right">Add Class</button><br/></form>';
            var title = 'New Account';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
           // $('#EditDueDate').datepicker();
        
}

   function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    if (charCode == 189)
    {
      return true;
    }
    return true;
}

function loadAccType(AccClass)
{
  //var OptType;
  $.ajax({
            url: 'getAccType',
            type: 'POST',
            data:  {acctclass:AccClass},
            async: false,
            //cache: false,
            //processData:false,
            success: function(html)
            {
                OptType = html;
                //alert(OptType);
                //return OptType;
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
               OptType = textStatus;
               //alert(OptType);
               //return OptType;
            }           
       });
  
    //alert(OptType);
   return OptType;
  
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
            Accounts - Chart Master
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Chart Master</li>
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
                  <h3 class="box-title">Chart Master</h3>
                  <div class="box-tools pull-right">
                  </div>
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                 <button class="btn btn-success pull-right" id="addAcct" onclick="addAcc(this)" > Add Account Master</button>
                 <button class="btn btn-success pull-left" onclick="ExportToExcel()" > Export To Excel</button>
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                   <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Account Code</th>
                        <th>Old Code</th>
                        <th>Account Name</th>
                        <th>Account Type</th>
                        <th>Account Class</th>
                        <th>is Active</th>
                        <th>Edit</th>
                        <th>Open Balance</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $RecChartMaster; ?>
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
    <!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
     <script src="../mBOOT/jquery-ui.js"></script>
    <script type="text/javascript">
     $("#userTab").dataTable(
            {
          "bPaginate": true,
          //"bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true
          //"bAutoWidth": true
        });
    </script>

    <script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>
    
    <script type="text/javascript">
     function ExportToExcel()
      {
        var Dat = "Chart Master List"; //+ new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "Chart Master List",
              filename: Dat,
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true
            });
      }
     </script>


  </body>
</html>