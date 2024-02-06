<?php
session_start();
error_reporting(0);
include ('route.php');

$b_url = trim(strip_tags($_POST['burl']));
$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
$TrainMatrix = '';
require '../DBcon/db_config.php';
//Load Reporting Managers
$RptMgropt = "";
$RptMgrUt = mysql_query("SELECT * FROM users ORDER BY Surname");
$NoRowRptMgrUt = mysql_num_rows($RptMgrUt);

if ($NoRowRptMgrUt > 0) 
{
  while ($row = mysql_fetch_array($RptMgrUt)) {
    $id = $row{'uid'};
    $bnu = $row['Surname'] ." ". $row['Firstname'];
    $RptMgropt .= '<option value="'.$id.'">'.$bnu.'</option>';
    }
} else { $RptMgropt .= '<option value="" > No Reporting Manager </option>'; }




//Load Business Unit
$BUopt = "";
$TMatrix = mysql_query("SELECT * FROM regtraining LEFT JOIN users ON regtraining.userid = users.uid ORDER BY tid DESC");
$NoRowTMatrix = mysql_num_rows($TMatrix);
$snid = 0;
if ($NoRowTMatrix > 0) 
{
  while ($row = mysql_fetch_array($TMatrix)) {
    $tid = $row{'tid'};
    $User = $row['Surname'] ." ". $row['Firstname'];
    $snid = $snid + 1;
    
    $TrainMatrix .='
           <tr>
              <td>'.$snid.'</td>
            <td>'.$row['Surname'] ." ". $row['Firstname'].'</td>
            <td>'.$row['Title'].'</td>
            <td>'.$row['Trainer'].'</td>
            <td>'.$row['Venue'].'</td>
             <td>'.$row['Duration'].'</td>
            <td>'.$row['StartDate'].'</td>
             <td>'.$row['RegisteredOn'].'</td>
           
           <td><a '.  'onclick="open_container('.$tid.');">'. '<span class="fa fa-edit text-green"></span></a></td>
           <td><a '.  'onclick=" set_attd('.$tid.');">'. '<span class="glyphicon glyphicon-edit"></span></a></td>
           
          
           </tr>
           
           
           ';
    
    }
} 






$Record = ""; $snid = 0;
$UsersUt = mysql_query("SELECT * FROM users LEFT JOIN department ON users.DeptID = department.id Where users.isActive=1 AND users.isAvalible=1 ORDER BY Surname");
$NoRowUsersUt = mysql_num_rows($UsersUt);

if ($NoRowUsersUt > 0) 
{
  while ($row = mysql_fetch_array($UsersUt)) {
    $snid = $snid + 1;
    $uid = $row{'uid'};
      $SurName = $row['Surname'];
    $Firstname = $row ['Firstname'];
    $Gender = $row ['Gender'];
    $StaffID = $row ['StaffID'];
    $DateReg = $row ['DateReg'];
    $Email = $row ['Email'];
    $Phone = $row ['Phone'];
    $DoB = $row ['DoB'];
    $DoJ = $row ['DateOfJoining'];//YOExp
    $YOExp = $row ['YearsOfExp'];//
    $WorkExt = $row ['WorkExt'];
    $Picture = $row ['Picture'];
    $Dept = $row ['DeptmentName'];
    $Role = $row ['Role'];
    $PORApp = $row ['porApproval'];
    $ActStatus = $row ['isActive'];

    if ($ActStatus != '1') 
     {
    // $PCStatus = '<i class="fa fa-cog" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc1(this);"></i>';
     $AppStatus = '<input type="checkbox" title="Activate Account" id="hpc'.$uid.'" r="'.$uid.'" onclick="cpc(this);"></input>';
     }
     if ($ActStatus == '1') 
     {
     //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
     $AppStatus = '<input  type="checkbox" checked title="Deactivate" id="hpc'.$uid.'" r="'.$uid.'" onclick="cpc(this);"></input>';
     }

    if ($PORApp != '1') 
     {
    // $PCStatus = '<i class="fa fa-cog" title="Open for Project Control" r="'.$LitID.'" jm="hpc'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc1(this);"></i>';
     $PORAppStatus = '<input type="checkbox" title="Set As Approval for PORequition" id="hpc'.$uid.'" r="'.$uid.'" onclick="cpc(this);"></input>';
     }
     if ($PORApp == '1') 
     {
     //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
     $PORAppStatus = '<input  type="checkbox" checked title="Remove As Approval for PORequition" id="hpc'.$uid.'" r="'.$uid.'" onclick="cpc(this);"></input>';
     }

      $Record .='
           <tr>
              <td>'.$snid.'</td>
            <td>'.$StaffID.'</td>
            <td>'.$SurName.'</td>
            <td>'.$Firstname.'</td>
            <td>'.$Dept.'</td>
            <td>'.$Email.'</td>
            <td>'.$Phone.'</td>
           
           <td><a '.  'onclick="set_renumeration('.$uid.',\''.$SurName.'\',\''.$Firstname.'\',\''.$Gender.'\',\''.$Email.'\',\''.$Phone.'\',\''.$StaffID.'\');">'. '<span class="fa fa-money text-green"></span></a></td>
            <td><a '.  'onclick="open_container('.$uid.',\''.$SurName.'\',\''.$Firstname.'\',\''.$Gender.'\',\''.$Email.'\',\''.$Phone.'\',\''.$StaffID.'\');">'. '<span class="glyphicon glyphicon-edit"></span></a></td>
            <td><a href="employee?dc='.$uid.'">'. '<span class="fa fa-eye"></span></a></td>
            <td><a '.  'onclick="Delete_LineItem('.$uid.',\''.$SurName.'\',\''.$Firstname.'\',\''.$Gender.'\',\''.$Email.'\',\''.$Phone.'\',\''.$Role.'\');">'. '<span class="glyphicon glyphicon-trash"></span></a></td>
          
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
    <title>ENL ERP | Employee</title>
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
              <a href="../humanresources">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
			
			
			     
                              
            <li class="header">USER</li>
            <li><a href="logout"></i><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
            <li><a><i class="fa ion-edit"></i> <span>Change Password</span></a></li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Training Matrix 
            <small><?php echo $_SESSION[version]; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo $b_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Staff Record</li>
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
                  <h3 class="box-title">New Schedule Training on ERP</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-success" data-widget="collapse"> Add </button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div>
                    <div class="col-md-6" style="background-color:#FBFBFB">
                      <p class="text-center">
                        <strong>Staff's Details</strong>
                      </p>
                  <form enctype="multipart/form-data" action="regnewtrainsch" method="post" style="font-size:13px;">
           <div class="form-group has-feedback col-md-12">
          <label>Search Staff Name <span style="color:red">*<span></label>
          <select type="text" class="form-control" id="SSName" name="SSName" required >  <?php echo  $RptMgropt; ?> </select>
          </div>
          <div class="form-group has-feedback col-md-4">
          <label> &nbsp; </label>
          <button class="btn btn-success"> Register Training </button>
          </div>
          <!--<div class="form-group has-feedback col-md-4">
          <label>First Name <span style="color:red">*<span></label>
          <input type="text" class="form-control" id="Fname" name="Fname" placeholder="First name"required />
          </div>
          
          <div class="form-group has-feedback col-md-4">
          <label>Middle Name </label>
          <input type="text" class="form-control" id="Mname" name="Mname" placeholder="Middle name" />
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Last Name <span style="color:red">*<span></label>
		      <input type="text" class="form-control" id="Surname" name="Surname" placeholder="Surname"required />
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Gender <span style="color:red">*<span></label>
          <select class="form-control" id="Gender" name="Gender"placeholder="Gender" required>
          <option value=""> --</option>
          <option value="Male"> Male</option>
          <option value="Female"> Female</option>
          </select>
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Department</label>
          <select class="form-control"  id="dept" name="dept">
          <option value=""> --</option>
          <?php echo $DepUtOpt; ?>
          </select>
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Business Unit <span class="addbtn"> Add New </span></label>
          <select class="form-control" id="BusUnt" name="BusUnt">
          <option value=""> -- </option>
          <?php echo $BUopt; ?>
          </select>
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Mode of Employement <span style="color:red">*<span></label>
          <select class="form-control" id="MOE" name="MOE" required>
          <option value=""> --</option>
          <option value="Direct"> Direct</option>
          <option value="Interview"> Interview</option>
          <option value="Reference"> Reference</option>
          <option value="Other"> Other</option>
          </select>
          </div> -->

          <!-- Matte 

          <div class="form-group has-feedback col-md-4">
          <label>Job Title <span style="color:red">*<span></label>
          <select class="form-control"  id="jbtitle" name="jbtitle" required>
          <option value=""> -- </option>
          <?php echo $JBTopt; ?>
          </select>
          </div>-->
            <!--
          <div class="form-group has-feedback col-md-4">
          <label>Designation</label>
          <select class="form-control"  id="posti" name="posti">
          <option value=""> -- </option>
          <?php echo $JBPopt; ?>
          </select>
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Reporting Manager</label>
          <select class="form-control"  id="rptmgr" name="rptmgr">
          <option value=""> -- </option>
          <?php echo $RptMgropt; ?>
          </select>
          </div>

        
          <div class="form-group has-feedback col-md-8">
          <label>Email </label>
          <input type="email" class="form-control" id="staffmail" name="staffmail" placeholder="Email" value="" />
          </div> -->

         
         
              
                    </div><!-- /.col -->
                    <div class="col-md-6">
                     
            <div class="form-group has-feedback col-md-12">
            <label>Course Title</label>
             <input type="text" class="form-control" id="CourseT" name="CourseT" placeholder="" required />
          </div>
          
      
          
          <div class="form-group has-feedback col-md-12">
            <label>Trainers</label>
             <input type="text" class="form-control" id="Trainer" name="Trainer" placeholder="" required />
          </div>
          
            <div class="form-group has-feedback col-md-12">
            <label>Venue</label>
             <input type="text" class="form-control" id="Venue" name="Venue" placeholder="" required />
          </div>
          
          <div class="form-group has-feedback col-md-12">
            <label>Duration</label>
             <input type="text" class="form-control" id="Duration" name="Duration" placeholder="" required />
          </div>
          
          <div class="form-group has-feedback col-md-12">
            <label>Start Date</label>
             <input type="text" class="form-control" id="StrDate" name="StrDate" placeholder="Click To Set Date" readonly required />
          </div>

				  
        
                     
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
	  <script language="javascript">
  						
        function open_container(uid, surnme, firstnme, gender, emai, phnn, staffid)
		
        {  
			var title = 'Edit '+surnme + ' ' +  firstnme +'\'s Info.';
			
            var size='standart';
						
            var content = '<form role="form" method="post" action="upduser" enctype="multipart/form-data" ><div class="form-group">' +
			'<div class="form-group has-feedback" style="width:100%;">' +
		    '<label>First name: </label>' +
            '<input type="text" class="form-control" id="firstnme" name="firstnme" placeholder="Description of Line Item" value="'+ firstnme +'" ></input>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
			'</div>' +'<input type="hidden" name="uID" value="'+ uid +'" ></input>' +
			
			'<div class="form-group has-feedback" style="width:100%;">' +
		    '<label>Surname: </label>' +
            '<input type="text" class="form-control" id="surnme" name="surnme" placeholder="Description of Line Item" value="'+ surnme +'" ></input>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
			'</div>' +
			'<label>Gender: </label>' +
			'<select class="form-control" id="Gender" name="Gender" placeholder="Gender" required>' +
			'<option value="'+gender+'" selected > '+gender+'</option>' +
			'<option value="Male"> Male</option>' +
			'<option value="Female"> Female</option>' +
			
			'</select>' +
			'<div class="form-group has-feedback" style="width:40%; display: inline-block;">' +
            'Staff ID: <input type="text" class="form-control" id="staffid" name="staffid" placeholder="Staff ID" value="'+staffid+'" required />' +
            
            '</div>' +
		    '<div class="form-group has-feedback" style="width:40%; display: inline-block; margin:12px;">' +
            'Phone: <input type="text" class="form-control" id="staffphn" name="staffphn" placeholder="Staff Phone" value="'+phnn+'" required />' +
           
            '</div>' +
			'</div>'+
			'<label>Email </label>' +
			'<div class="form-group"><input type="text" class="form-control" id="LIemai" name="LIemai" value="'+ emai +'" placeholder="Enter email"></div>' +
			'<label>Photo </label>' +
      '<div class="form-group"><input type="file" class="form-control" id="StaffPhoto" name="StaffPhoto" placeholder="Staff Photo"></div>' +
      //'<label>Access to Module </label>' +
      //'<div class="form-group" id="accmd"></div>' +
      
			'<button type="submit" class="btn btn-primary pull-right">Save changes</button></form>';
           // var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

            loadAccess(uid);
        }
        
          function set_attd(tid)
		 {  
			var title = 'Update Staff Attendance';
			var tid = tid;
            var size='standart';
						
            var content = '<form role="form" method="post" action="updateAttendance" enctype="multipart/form-data" ><div class="form-group">' +
			'<div class="form-group col-md-12" >' +
		  
		     '<label>Present <input type="radio" name="commtype1" value="Present"  /> </label>'+
                                           '&nbsp; &nbsp; &nbsp; &nbsp;'+
                                           '<label>Absent <input type="radio" name="commtype1" value="Absent" checked  /> </label>'+
           // '<input type="text" class="form-control" id="firstnme" name="firstnme" placeholder="Description of Line Item" value="343131" ></input>' +
           // '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
			'</div>' +'<input type="hidden" name="TID" value="'+ tid +'" ></input>' +
			
		
			
		
		
		
      
			'<button type="submit" class="btn btn-primary pull-right">Update</button></form>';
           // var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

           
        }

        function loadAccess(uid)
        {
          //Here we would get all the Module and set on all this user have access to
          
        }
		
		    function Delete_LineItem(uid, surnme, firstnme, gender, emai, phn)
		
        {  
			var title = 'Are You Sure you want to DELETE user with ID no.: '+uid + ', in surnme No.: '+surnme;
			
            var size='standart';
            var content = '<form role="form" method="post" action="ruser"><div class="form-group">' +
			'Phone Number : <label>'+ phn  +'</label> </br>' +
			'<label>Note: After delete, you can never recover this user, thanks!  </label> </br>' +
			'<input type="hidden" name="uid" value="'+ uid +'" ></input>' +
			'<input type="hidden" name="LIsurnme" value="'+ surnme +'" ></input>' +
			
			'<button type="submit" class="btn btn-primary">Yes</button></form>';
           // var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
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
                  <h3 class="box-title">Scheduled Trainings</h3>
                  <div class="box-tools pull-right">
                    <div class="form-group has-feedback" style="width:150px; display: inline-block; margin:1px;">
                         <button type='button' onclick="ExportToExcel()" name='expbnt' id='exp-btn' title="Export to Excel" class="btn btn-flat"><i class="fa fa-send"></i></button>
                 </div>
                   <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Staff Name</th>
                        <th>Training Title</th>
                        <th>Trainer</th>
                        <th>Venue</th>
                        <th>Duration</th>
						<th>Start Date</th>
           <th>Attended?</th>
            <th>Edit</th>
						<th>Check Attendance</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                   <?php echo $TrainMatrix; ?>
                    </tbody>
                    <tfoot class="noExl">
                      <tr>
                          <th>S/N</th>
                        <th>Staff Name</th>
                        <th>Training Title</th>
                        <th>Trainer</th>
                        <th>Venue</th>
                        <th>Duration</th>
						<th>Start Date</th>
           <th>Attended?</th>
            <th>Edit</th>
						<th>Check Attendance</th>
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
    <script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>

	
	
<script src="../mBOOT/jquery-ui.js"></script>
    <script type="text/javascript">
     function ExportToExcel()
      {
        var Dat = "Staff Training Matrix " + new Date();
        $("#userTab").table2excel({
              exclude: ".noExl",
              name: "Staff Training Matrix",
              filename: Dat,
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true
            });
      }
     </script>

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
	  
      
        $( "#StrDate" ).datepicker({
        inline: true,
        changeYear: true,
        changeMonth: true,
        yearRange: "2016:2054"

      });

     
     
       
      });

      function setBU(elem)
      {
          var busuntid = $(elem).val();
          var dataString = 'deptid='+ busuntid;
          $.ajax({
              type: "POST",
              url: "searchBUS.php",
              data: dataString,
              cache: false,
              success: function(html)
              {
                $("#BusUnt").html(html);
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