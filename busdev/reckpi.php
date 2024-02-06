<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include('route.php');

//Let's Read ChartClass
$ChartClassQ = mysql_query("SELECT * FROM hse_kpi Where isActive=1 ORDER BY kpi_name");
$NoRowClass = mysql_num_rows($ChartClassQ);
if ($NoRowClass > 0) {
  while ($row = mysql_fetch_array($ChartClassQ)) {
    $cid = $row{'id'};
    $cname = $row['kpi_name'];
    $OptClass .= '<option value="'.$cid.'">'.$cname.'</option>';
   }

  }
//Let's Read ChartType
$RecKPINme = "";
$resultChartType = mysql_query("SELECT *, hse_kpi.kpi_name As hse_mkpi, hse_kpi_data.id AS hid  FROM hse_kpi_data LEFT JOIN hse_kpi ON hse_kpi_data.kpi_name = hse_kpi.id WHERE hse_kpi_data.isActive=1
  ORDER BY hid ASC");
$NoRowChartType = mysql_num_rows($resultChartType);
if ($NoRowChartType > 0) {
  while ($row = mysql_fetch_array($resultChartType)) {
    $id = $row['hid'];
    $kpiNme = $row['hse_mkpi'];
    $kpiDate = $row['kpi_date'];
    $kpiData = $row['kpi_data'];
    //<td>'.$Chk.'</td>
    $isActive = $row['TyIsActive'];
    if($isActive == 1){ $Chk = '<input type="checkbox" accttype="Type" acctid="'.$id.'" onclick="act(this)" checked />'; }
    else { $Chk = '<input type="checkbox" accttype="Type" acctid="'.$id.'" onclick="act(this)" />'; }
    $RecKPINme .= '<tr><td>'.$id.'</td><td>'.$kpiNme.'</td><td>'.$kpiDate.'</td><td>'.$kpiData.'</td>
    
    <td><a href="delkpidata?id='.$id.'" ><i class="fa fa-trash text-red"></i></a></td>
    </tr>';
    }

  }


$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];


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
            Record KPI Data
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Record KPI Data</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
          <div class="row">
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


           <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Key Performance Indicators</h3>
                  <div class="box-tools pull-right">
                  </div>
                 
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                 <button class="btn btn-success pull-right" id="addAcct" onclick="addAcc(this)"> Add HSE KPI Data</button>
                 <button class="btn btn-success pull-left" onclick="ExportToExcel()" > Export To Excel</button>
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                   <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>KPI Name</th>
                        <th>KPI Date</th>
                        <th>KPI Data</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $RecKPINme; ?>
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
            
        </div><!-- /.row -->
          
         <div class="row">

              <div class="box box-primary">
                
                
                <!-- Modal form-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
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
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

       <?php include('../footer.php') ?>
      


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
    <script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>
    <script src="../mBOOT/jquery-ui.js"></script>

    <script type="text/javascript">
      $(function () {
        //$("#userTab").dataTable();
          $(".datep").datepicker();
      });
    </script>
    
    <script type="text/javascript">
     function ExportToExcel()
      {
        var Dat = "Chart Type List";
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "Chart Type List",
              filename: Dat,
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true
            });
      }
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
 var Classname = $(elem).attr("Classname"); 
 var kpiNme = $(elem).attr("kpiNme"); 
 var kpiid = $(elem).attr("kpiid");
 //alert(kpiNme); 
 var OptClClass = '<?php echo $OptClass ?>';
/*
Classname="'.$Classname.'" kpiNme="'.$kpiNme.'" kpiid="'.$id.'"
*/
    var size='standart';
            var content = '<form role="form" action="editKPI" method="POST" >' +
             '<input type="hidden" value="'+kpiid+'" id="kpiid" name="kpiid" />'+
             '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>KPI Class: </label><select class="form-control" id="KPIClass" name="KPIClass" required>'+
                  OptClClass 
                 +
              '</select></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>KPI Name: </label><input type="text" class="form-control" id="KPINme" name="KPINme" value="'+kpiNme+'" required ></div>' +
             '<button type="submit" class="btn btn-primary pull-right">Update</button><br/></form>';
            var title = 'Edit KPI';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
            $('#KPIClass').val(Classname);
           //$("#newClass").text(acctnme);
           /* $('#KPIClass option').map(function () {
                if ($(this).text() == Classname) return this;
            }).attr('selected', 'selected');
            */

        
}

function deleteAcc (elem){
  var acctid = $(elem).attr("acctid"); 
 var acctnme = $(elem).attr("acctnme"); 
 var accttype = $(elem).attr("accttype"); 
 //var OptClClass = '<?php echo $OptClass ?>'
    var size='standart';
            var content = '<form role="form" action="deleteStorage" method="POST" ><div class="form-group">' +
             '<input type="hidden" value="'+acctid+'" id="idType" name="idType" />'+
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Storage Name: </label> <label>'+accttype+'</label></div>' +
              '<div class="form-group" style="width:100%; display: inline-block; margin: 6px">Are you sure you want to delete this Storage?</div>' +
             '<button type="submit" class="btn btn-primary pull-right">Yes</button><br/></form>';
            var title = 'Delete Storage';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">No</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

}

function addAcc(elem)
{
    var OptClClass = '<?php echo $OptClass ?>'
    var size='standart';
            var content = '<form role="form" action="addKPI" method="POST" ><div class="form-group">' +

              '<div class="form-group col-md-12"><label>KPI Name: </label><select class="form-control" id="KPINme" name="KPINme" required>'+ 
                  OptClClass +
              '</select></div>' +
              '<div class="form-group col-md-6" ><label>Record Date: </label><input type="text" class="form-control" id="KPIDate" name="KPIDate" placeholder="Click to set date" required readonly ></div>' +
              '<div class="form-group col-md-6" ><label>KPI Data: </label><input type="text" class="form-control" id="KPIData" name="KPIData" placeholder="" required ></div>' +
              '<button type="submit" class="btn btn-primary pull-right">Add KPI Data</button><br/></form>';
            var title = 'New KPI Data';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

            

            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
            $('#KPIDate').datepicker();
        
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


  </body>
</html>