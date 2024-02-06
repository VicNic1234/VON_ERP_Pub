<?php
session_start();
error_reporting(0);
include ('route.php');

$b_url = trim(strip_tags($_POST['burl']));
$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';
//Load Users
$UserOpt = "";
$UserRpt = mysql_query("SELECT * FROM users ORDER BY Firstname");
$NoRowDepUt = mysql_num_rows($UserRpt);

if ($NoRowDepUt > 0) 
{
  while ($row = mysql_fetch_array($UserRpt)) {
    $uid = $row['uid'];
    $bnu = $row['Firstname'] . " ". $row['Middlename'] . " ". $row['Surname'];
    $UserOpt .= '<option value="'.$uid.'">'.$bnu.'</option>';
    }
} else { $UserOpt .= '<option value="" > No Staff </option>'; }
//Load Division
$OptDiv = "";
$DivResult = mysql_query("SELECT * FROM divisions ORDER BY DivisionName");
$NoRowDivResult = mysql_num_rows($DivResult);

if ($NoRowDivResult > 0) 
{
  while ($row = mysql_fetch_array($DivResult)) {
    $divid = $row['divid'];
    $divnme = $row['DivisionName'];
    $OptDiv .= '<option value="'.$divid.'">'.$divnme.'</option>';
    }
} else { $OptDiv .= '<option value="" > No Division </option>'; }

    function getUserinfo($uid)
     {
        $resultUserInfo = mysql_query("SELECT * FROM users WHERE uid ='$uid'");
        while ($row = mysql_fetch_array($resultUserInfo)) 
        {
             return $UserNNE = $row['Firstname'] . " " . $row['Surname'];
        }
     }

$Record = ""; $snid = 0;
$UsersUt = mysql_query("SELECT * FROM department LEFT JOIN divisions ON department.DivID = divisions.divid ORDER BY DeptmentName");
$NoRowUsersUt = mysql_num_rows($UsersUt);

if ($NoRowUsersUt > 0) 
{
  while ($row = mysql_fetch_array($UsersUt)) {
    $snid = $snid + 1;
    $uid = $row{'id'};
    $DivisionName = $row['DivisionName'];
    $DeptmentName = $row['DeptmentName'];
    $DeptmentCode = $row['DeptCode'];
    $Description = $row['Description'];
    $HOD = getUserinfo($row['hod']);
    $HODn = $row['hod'];
    $supervisor = getUserinfo($row['supervisor']);
    $supervisorn = $row['supervisor'];
    $DivID = $row['DivID'];
    //$BusUnit = $row ['BussinessUnit'];
    //$BusUnitID = $row ['BusinessUnitID'];
   

      $Record .='
           <tr>
            <td>'.$snid.'</td>
            <td>'.$DivisionName.'</td>
            <td>'.$DeptmentName.'</td>
            <td>'.$DeptmentCode.'</td>
            <td>'.$Description.'</td>
            <td>'.$supervisor.'</td>
            <td>'.$HOD.'</td>
           
            
            <td><a '.  'onclick="open_container('.$uid.',\''.$DeptmentName.'\',\''.$DeptmentCode.'\',\''.$Description.'\',\''.$DivID.'\',\''.$HODn.'\',\''.$supervisorn.'\');">'. '<span class="glyphicon glyphicon-edit"></span></a></td>
          
           </tr>
           
           
           ';
    }
} 


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    
    <title><?php echo $_SESSION['CompanyAbbr'] ?> ERP | Departments</title>
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
            Departments
            <small><?php echo $_SESSION[version]; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Departments</li>
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
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">New Department Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div>
                    <div class="col-md-12" style="background-color:#FBFBFB; border-radius:25px;">
                     
                  <form enctype="multipart/form-data" action="regDept" method="post" style="font-size:13px;">
         
          <div class="form-group has-feedback col-md-3">
          <label>Division Name <span style="color:red">*<span></label>
          <select class="form-control" id="DivID" name="DivID" required>
            <?php echo $OptDiv; ?>
          </select>
          </div>

          <div class="form-group has-feedback col-md-3">
          <label>Department Name <span style="color:red">*<span></label>
          <input type="text" class="form-control" id="Dname" name="Dname" placeholder="Department name"required />
          </div>

          <div class="form-group col-md-3">
          <label>Department Code <span style="color:red">*<span></label>
		      <input type="text" class="form-control" id="Dcode" name="Dcode" placeholder="Department Code"required />
          </div>

          <div class="form-group col-md-3">
          <label>Description</label>
          <input type="text" class="form-control" id="DDes" name="DDes" placeholder="Department Description" />
          </div>

          

           <div class="form-group col-md-3 pull-right" style="padding-top:20px;">
         
         <button type="submit" class="btn btn-primary">Add Department</button>
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

        function open_container(uid, deptname, deptcode, despcription, divID, HOD, supervisor)
		
        {  
			var title = 'Edit '+ deptname + ' Department Info.';
      var businJUnit = '<?php echo $BUopt; ?>';
			var OptDiv = '<?php echo $OptDiv; ?>';
       var UserOpt = '<?php echo $UserOpt; ?>';
            var size='standart';
						
            var content = '<form role="form" method="post" action="upDept" enctype="multipart/form-data" ><div class="form-group">' +
      '<div class="form-group has-feedback" style="width:100%;">' +
        '<label>Division: </label>' +
            '<select class="form-control" id="Divnme" name="Divnme" required >'+ OptDiv +'</select>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
      '</div>' +

			'<div class="form-group has-feedback" style="width:100%;">' +
		    '<label>Department Name: </label>' +
            '<input type="text" class="form-control" id="Dnme" name="Dnme" placeholder="Department Name" value="'+ deptname +'" required ></input>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
			'</div>' +'<input type="hidden" name="uID" id="uID" value="'+ uid +'" ></input>' +
			
			'<div class="form-group has-feedback" style="width:100%;">' +
		    '<label>Department Code: </label>' +
            '<input type="text" class="form-control" id="Dcode" name="Dcode" placeholder="Department Code" value="'+ deptcode +'" required></input>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
			'</div>' +
			
		  '<div class="form-group has-feedback" style="width:100%;">' +
        '<label>Supervisor for this Department: </label>' +
            '<select class="form-control" id="SDept" name="SDept" required ><option value="0"> -- </option>'+ UserOpt +'</select>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
      '</div>' +

      '<div class="form-group has-feedback" style="width:100%;">' +
        '<label>Head of this Department: </label>' +
            '<select class="form-control" id="HDept" name="HDept" required ><option value="0"> -- </option>'+ UserOpt +'</select>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
      '</div>' +

			'<label>Description </label>' +
			'<div class="form-group"><input type="text" class="form-control" id="DDes" name="DDes" value="'+ despcription +'" placeholder="Description"></div>' +
			
			'<button type="submit" class="btn btn-primary">Save changes</button></form>';
           // var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
            $('#SDept').val(supervisor);
            $('#HDept').val(HOD);
            $('#Divnme').val(divID);
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
                  <h3 class="box-title">Department List</h3>
                  <div class="box-tools pull-right">
                     <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                   <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
            
               
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped" style="font-size:13px;">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Division Name</th>
                        <th>Department Name</th>
                        <th>Deparment Code</th>
                        <th>Description</th>
                        <th>Supervisor</th>
                        <th>Head of Dept</th>
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
	   $( "#DOB" ).datepicker({
        inline: true,
        changeYear: true,
        changeMonth: true,
        yearRange: "1950:2014"

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