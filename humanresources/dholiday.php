<?php
session_start();
error_reporting(0);
include('route.php');

$b_url = trim(strip_tags($_POST['burl']));
$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';

//Load Business Unit
$DepUtOpt = "";
$DepUt = mysql_query("SELECT * FROM department ORDER BY DeptmentName");
$NoRowDepUt = mysql_num_rows($DepUt);

if ($NoRowDepUt > 0) 
{
  while ($row = mysql_fetch_array($DepUt)) {
    $id = $row{'id'};
    $bnu = $row['DeptmentName'];
    $DepUtOpt .= '<option value="'.$id.'">'.$bnu.'</option>';
    }
} else { $DepUtOpt .= '<option value="" > No Department </option>'; }





$Record = ""; $snid = 0;
$HolidayUt = mysql_query("SELECT * FROM holidaymgt ORDER BY HolidayDay");
$NoRowHolidayUt = mysql_num_rows($HolidayUt);

if ($NoRowHolidayUt > 0) 
{
  while ($row = mysql_fetch_array($HolidayUt)) {
    $snid = $snid + 1;
    $uid = $row{'id'};
    $BusYear = $row['BusYear'];
    $HolidayDay = $row['HolidayDay'];
    $HolidayTitle = $row['HolidayTitle'];

      $Record .='
           <tr>
            <td>'.$snid.'</td>
             <td>'.$BusYear.'</td>
             <td>'.$HolidayTitle.'</td>
            <td>'.$HolidayDay.'</td>
           
            
            <td><a '.  'onclick="open_container('.$uid.',\''.$BusYear.'\',\''.$HolidayTitle.'\',\''.$HolidayDay.'\');">'. '<span class="glyphicon glyphicon-edit"></span></a></td>
          
           </tr>
           
           
           ';
    }
} 


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PENL ERP | Holiday</title>
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
	 <!-- DatePicker -->
  
  <link href="../mBOOT/jquery-ui.css" rel="stylesheet">
	
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
<style type="text/css">
.addbtn {
  color:blue; font-size:12px; font-weight:700; cursor: pointer; display: none;
}
</style>
<script type="text/javascript">
   function cpc(relm)
   {
      //alert("Grace");
    var gh = $(relm).attr('r');
    var ghid = $(relm).attr('id');
    //var prind = $(relm).attr('jm');
    //alert(ghid);
    var dataString = 'litem='+ gh;
    if($('#'+ghid).is(":checked") == true)
    {
    
      $.ajax({
      type: "POST",
      url: "cppor1",
      data: dataString,
      cache: false,
      success: function(html)
      {
            //$("#"+prind).prop('checked', true);
      }
      });
    
    }
    else
    {
    $.ajax({
      type: "POST",
      url: "cppor0",
      data: dataString,
      cache: false,
      success: function(html)
      {
            $("#"+prind).prop('checked', false);
      }
      });
    }
    
   }
</script>

  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

       <?php include('../topmenu3.php') ?>
      <!-- Left side column. contains the logo and sidebar -->
           <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
             <?php echo '<img src="data:image/jpeg;base64,'. base64_encode($prasa). '" class="img-circle" alt="User Image">'; ?>
            </div>
            <div class="pull-left info">
              <p> <?php echo $_SESSION['SurName']. " ". $_SESSION['Firstname']; ?> </p>

                    
					 
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active">
              <a href="./">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
			
			
			     
                              
            
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Holidays
            <small><?php echo $_SESSION[version]; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Holiday Management</li>
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
                  <h3 class="box-title">Holidays for the Year</h3>
                  <div class="box-tools pull-right">
                     <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                   <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
            
               
                <div class="box-body">
                  <div class="col-md-12" id="AllDays"></div>
                </div><!-- /.box-body -->
             
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">New Holiday</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div>
                    <div class="col-md-12" style="background-color:#FBFBFB; border-radius:25px;">
                     
          <form enctype="multipart/form-data" action="regHoliday" method="post" style="font-size:13px;">
          <!--
          <div class="form-group has-feedback col-md-4">
          <label>Department <span style="color:red">*<span></label>
          <select class="form-control" id="DeptU" name="DeptU" required >
            <option value=""> -- </option>
            <?php echo $DepUtOpt;  ?>
          </select>
          </div>
        -->

          <div class="form-group has-feedback col-md-2">
          <label>Business Year <span style="color:red">*<span></label>
          <select class="form-control" id="BusYear" name="BusYear" required >
            <option value=""> -- </option>
            <option value="2016"> 2016 </option>
            <option value="2017"> 2017 </option>
            
          </select>
          </div>

          <div class="form-group col-md-2">
          <label>Holiday Day</label>
          <input type="text" class="form-control" id="HDay" name="HDay" placeholder="Day" />
          </div>

         

          <div class="form-group col-md-4">
          <label>Holiday Title</label>
          <input type="text" class="form-control" id="HTitle" name="HTitle" placeholder="Holiday Title" />
          </div>

          

           <div class="form-group col-md-3 pull-right" style="padding-top:20px;">
         
         <button type="submit" class="btn btn-primary">Add Holiday</button>
          </div>
         

              </div>
                    </div><!-- /.col -->
                     </div><!-- /.col -->
                      </div> </div>
          </div><!-- /.row -->
	  <script language="javascript">
  						/*

               <td>'.$BusUnit.'</td>
            <td>'.$DeptmentName.'</td>
            <td>'.$DeptmentCode.'</td>
            <td>'.$Description.'</td>

            */

        function open_container(uid, busyr, lvti, nwkdays)  
		
        {  
			var title = 'Edit '+ lvti + ' Info.';
			var DeptJUnit = '<?php echo $DepUtOpt;  ?>';
            var size='standart';
						
            var content = '<form role="form" method="post" action="upHolidaymgt" ><div class="form-group">' +

			'<div class="form-group has-feedback" style="width:100%;">' +
		    '<label>Business Year: </label>' +
            '<input type="text" class="form-control" id="BusYear" name="BusYear" placeholder="Business Year" value="'+ busyr +'" required ></input>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
			'</div>' +'<input type="hidden" name="uID" value="'+ uid +'" ></input>' +
			
		
			'<label>Holiday Day </label>' +
			'<div class="form-group"><input type="text" class="form-control" id="HDay1" name="HDay" value="'+ nwkdays +'" placeholder="No of Wrk Day"></div>' +
			
      '<label>Holiday Title </label>' +
      '<div class="form-group"><input type="text" class="form-control" id="HTitle" name="HTitle" value="'+ lvti +'" placeholder="Leave Mgt. Title"></div>' +
      

			'<button type="submit" class="btn btn-primary">Save changes</button></form>';
           // var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
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


	
	<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Holiday List</h3>
                  <div class="box-tools pull-right">
                     <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                   <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
            
               
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped" style="font-size:11px;">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Year</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Edit</th>
            			
           
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    
                  </table>
                </div><!-- /.box-body -->
             
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  
      <?php include('../footer.php'); ?>
     

      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='../plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
	 <!-- bootstrap time picker -->
    <script src="../plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
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
<script src="../mBOOT/jquery-ui.multidatespicker.js"></script>


    <script type="text/javascript">
	 
      $(function () {
	   
        $("#userTab").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
	




	 <script type="text/javascript">
	 //Date Picker
      $(function () {
	   //$('#DOB').datetimepicker();
     var today = new Date();
      var y = today.getFullYear();
      $('#AllDays').multiDatesPicker({
        //disabled: true,
        addDates: ['10/14/2017', '02/19/2017', '01/14/2017', '11/16/2017'],
        //addDisabledDates: ['10/14/2017', '02/19/2017', '01/14/2017', '11/16/2017'],
        numberOfMonths: [3,4],
        defaultDate: '1/1/2017'
      });

	   $( "#HDay" )
     .datepicker
     ({
        inline: true,
        //selectMultiple:false,
        //changeYear: true,
        changeMonth: true,
        //beforeShowDay: $.datepicker.noWeekends,
        yearRange: "2016:2018"
        /*
        createButton:true,
                displayClose:false,
                closeOnSelect:false,
                selectMultiple:true,
                inline:true,
                startDate:'01/01/2005',
                endDate:'31/12/2011'
        */     
      });

      $( "#HDay1" )
     .datepicker
     ({
        inline: true,
        //selectMultiple:false,
        //changeYear: true,
        changeMonth: true,
        //beforeShowDay: $.datepicker.noWeekends,
        yearRange: "2016:2018"
        
      });


      $( "#DOJ" ).datepicker({
      inline: true,
      changeYear: true,
      changeMonth: true,
      yearRange: "1999:2018"

      });
     
       
      });

      function setDept(elem)
      {
          var busuntid = $(elem).val();
          var dataString = 'busid='+ busuntid;
          $.ajax({
              type: "POST",
              url: "searchDept.php",
              data: dataString,
              cache: false,
              success: function(html)
              {
                $("#dept").html(html);
              }
          });
      }

      function setJobPosition(elem)
      {
        var busuntid = $(elem).val();
          var dataString = 'jtsid='+ busuntid;
          $.ajax({
              type: "POST",
              url: "searchPosition.php",
              data: dataString,
              cache: false,
              success: function(html)
              {
                $("#posti").html(html);
              }
          });
      }
    </script>
	
	


  </body>
</html>