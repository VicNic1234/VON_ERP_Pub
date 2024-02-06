<?php
session_start();
error_reporting(0);
//include ('route.php'); 

$b_url = trim(strip_tags($_POST['burl']));
$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';
$Record = ""; $snid = 0;
$LogsUt = mysql_query("SELECT * FROM msg INNER JOIN users ON msg.sender = users.uid");
$NoRowLogsUt = mysql_num_rows($LogsUt);

if ($NoRowLogsUt > 0) 
{
  while ($row = mysql_fetch_array($LogsUt)) {
    $snid = $snid + 1;
    $Logid = "LOG-".$row['msgid'];
    $msgTitle = $row ['msgTitle'];
    $msg = $row ['msg'];
    $sender = $row ['sender'];
    $FirstNme = $row ['Firstname'];
    $SurNme = $row ['Surname'];
    $CreatedOn = $row ['CreatedOn'];

    $Record .='
           <tr>
              <td>'.$snid.'</td>
            <td>'.$Logid.'</td>
            <td>'.$FirstNme. ' ' .$SurNme . '</td>
            <td>'.$msgTitle.'</td>
            <td>'.$msg.'</td>
            <td>'.$CreatedOn.'</td>
            
           </tr>';

  }
}


/*
$Record = ""; $snid = 0;
$UsersUt = mysql_query("SELECT * FROM users LEFT JOIN department ON users.DeptID = department.id WHERE users.isAvalible=1  ORDER BY users.Surname");
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
    $Picture = $row ['Picture'];
    $Dept = $row ['DeptmentName'];
    $Role = $row ['Role'];
    $PORApp = $row ['porApproval'];
    $ActStatus = $row ['isActive'];
    $Passwrd = $row ['Password'];

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

      $Record .='
           <tr>
              <td>'.$snid.'</td>
            <td>'.$StaffID.'</td>
            <td>'.$SurName.'</td>
            <td>'.$Firstname.'</td>
            <td>'.$Dept.'</td>
            <td>'.$Email.'</td>
            <td>'.$Phone.'</td>
            <td>'.$AppStatus.'</td>
            <td><a '.  'onclick="open_container('.$uid.',\''.$SurName.'\',\''.$Firstname.'\',\''.$Gender.'\',\''.$Email.'\',\''.$Phone.'\',\''.$Passwrd.'\',\''.$StaffID.'\');">'. '<span class="glyphicon glyphicon-edit"></span></a></td>
            <td><a '.  'onclick="Delete_LineItem('.$uid.',\''.$SurName.'\',\''.$Firstname.'\',\''.$Gender.'\',\''.$Email.'\',\''.$Phone.'\',\''.$Role.'\');">'. '<span class="glyphicon glyphicon-trash"></span></a></td>
            
           </tr>
           
           
           ';
    }
} 

*/
$CUSRecord = ""; $CUSsnid = 0;
$CUSUsersUt = mysql_query("SELECT * FROM userext LEFT JOIN customers ON userext.CustomerID = customers.cusid  ORDER BY userext.Username");
$NoRowCUSUsersUt = mysql_num_rows($CUSUsersUt);

if ($NoRowCUSUsersUt > 0) 
{
  while ($row = mysql_fetch_array($CUSUsersUt)) {
    $CUSsnid = $CUSsnid + 1;
    $uid = $row{'uid'};
    $username = $row['username'];
    $password = $row ['password'];
    $CustomerID = $row ['CustomerID'];
    $CustormerNme = $row ['CustormerNme'];
    $CUSemail = $row ['CRMemail'];
    $ActStatus = $row ['isActive'];
    

    if ($ActStatus != '1') 
     {
        $AppStatus = '<input type="checkbox" title="Activate Account" id="hpc'.$uid.'" r="'.$uid.'" onclick="cpc(this);"></input>';
     }
     if ($ActStatus == '1') 
     {
       $AppStatus = '<input  type="checkbox" checked title="Deactivate" id="hpc'.$uid.'" r="'.$uid.'" onclick="cpc(this);"></input>';
     }

      $CUSRecord .='
           <tr>

            <td>'.$CUSsnid.'</td>
            <td>'.$username.'</td>
            <td>'.$CUSemail.'</td>
            <td>'.$password.'</td>
            <td>'.$CustormerNme.'</td>
            <td>'.$AppStatus.'</td>
            <td><a '. 'onclick="CUSopen('.$uid.',\''.$username.'\',\''.$password.'\',\''.$CUSemail.'\',\''.$CustormerNme.'\',\''.$ActStatus.'\');">'. '<span class="glyphicon glyphicon-edit"></span></a></td>
            <td><a '. 'onclick="CUSDelete('.$uid.',\''.$username.'\',\''.$password.'\',\''.$CustormerNme.'\',\''.$ActStatus.'\');">'. '<span class="glyphicon glyphicon-trash"></span></a></td>
            
           </tr>
           
           
           ';
    }
} 
//Here we have to get all the Customers
$resultCustomers = mysql_query("SELECT * FROM customers ORDER BY CustormerNme");
    $NoRowCust = mysql_num_rows($resultCustomers);
    $OptCustomer = '<option value=""> Choose Company</option>';
  if ($NoRowCust > 0) 
  {
    while ($row = mysql_fetch_array($resultCustomers)) 
    {
      $Cusi = $row['cusid'];
      $CusNme = $row['CustormerNme'];
      $OptCustomer .= '<option value="'.$Cusi.'">'.$CusNme.'</option>';
     
    }
  }

$resultCustomers = mysql_query("SELECT * FROM customers ORDER BY CustormerNme");
    $NoRowCust = mysql_num_rows($resultCustomers);
  if ($NoRowCust > 0) 
  {
    while ($row = mysql_fetch_array($resultCustomers)) 
    {
      $Cusi = $row['cusid'];
      $CusNme = $row['CustormerNme'];
      $OptCustomerM .= '<option value="'.$Cusi.'">'.$CusNme.'</option>';
     
    }
  }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PEEL ERP | Activity Log</title>
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
    <!--Multiple Select TOKIN -->
  <script src="../mBOOT/jquery-3.1.1.min.js"></script>
     <link href="../mBOOT/tokenize2.css" rel="stylesheet" type="text/css" />
    <script src="../mBOOT/tokenize2.js" type="text/javascript"></script>
    <!-- Select 2 -->
     <script src="../mBOOT/select2.js"></script>
     <link href="../mBOOT/select2.css" rel="stylesheet" type="text/css" />
  

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
      url: "actpor1",
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
      url: "actpor0",
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
  <body class="skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper">

        <?php include('../topmenu3.php') ?>
           <?php include('../leftmenu3.php') ?>
      <!-- Left side column. contains the logo and sidebar -->
          
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Activity Logs
            <small><?php echo $_SESSION[version]; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo $b_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Activity Logs</li>
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
  
	  <script language="javascript">
  			function CUSopen (uid,username,password,CUSemail,CustormerNme,ActStatus)
        {
          var title = 'Edit CRM '+username + ' for ' +  CustormerNme +'\'s Info.';
          var CuSList = '<?php echo json_encode($OptCustomerM) ?>';
            //alert(CuSList);
            var size='standart';
            
            var content = '<form role="form" method="post" action="updCRMuser" enctype="multipart/form-data" ><div class="form-group">' +
       '<div class="form-group has-feedback" style="width:100%;">' +
        '<label>Username: </label>' +
            '<input type="text" class="form-control" id="CRMUsername" name="CRMUsername" value="'+ username +'" ></input>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
      '</div>' +
      '<div class="form-group has-feedback" style="width:100%;">' +
        '<label>Email: </label>' +
            '<input type="text" class="form-control" id="CRMEmail" name="CRMEmail" value="'+ CUSemail +'" ></input>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
      '</div>' +'<input type="hidden" name="uID" value="'+ uid +'" ></input>' +
      '<div class="form-group has-feedback" style="width:100%;">' +
        '<label>Password: </label>' +
            '<input type="text" class="form-control" id="CRMPassword" name="CRMPassword" value="'+ password +'" ></input>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
      '</div>'+
     
   //'<label>Access to Module </label>' +
      //'<div class="form-group" id="accmd"></div>' +
      
      '<button type="submit" class="btn btn-primary pull-right">Save changes</button></form>';
           // Set Access Role
           /////////////////////////////////////////////////////////
           //AccessRole
           ///////////////////////////////////////////////////////////////
            var footer = '<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

        }

        
        function open_container(uid, surnme, firstnme, gender, emai, phnn, pwsd, staffid)
		
        {  
			var title = 'Edit '+surnme + ' ' +  firstnme +'\'s Info.';
       

            var size='standart';
						
            var content = '<form role="form" method="post" action="updmuser" enctype="multipart/form-data" ><div class="form-group">' +
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
			'<div class="form-group"><input type="email" class="form-control" id="LIemai" name="LIemai" value="'+ emai +'" placeholder="Enter email" required ></div>' +
			'<label>Password </label>' +
      '<div class="form-group"><input type="password" class="form-control" id="staffPass" name="staffPass" value="'+ pwsd +'" placeholder="Enter Password" required ></div>' +
      '<div class="form-group has-feedback col-md-12">'+
          '<label>Access Role <span style="color:red">*<span></label>'+
      '<div id="AccessRole" style="padding:7px;"></div>' +
      '</div>'+     
     '<br/><br/><br/>'+
      '<div class="form-group col-md-12"><br/><label>Photo </label><input type="file" class="form-control" id="StaffPhoto" name="StaffPhoto" placeholder="Staff Photo"></div>' +
      //'<label>Access to Module </label>' +
      //'<div class="form-group" id="accmd"></div>' +
      
			'<button type="submit" class="btn btn-primary pull-right">Save changes</button></form>';
           // Set Access Role
           /////////////////////////////////////////////////////////
           //AccessRole
           ///////////////////////////////////////////////////////////////
            var footer = '<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');

            loadAccess(uid);
        }

        function loadAccess(uid)
        {
          //Here we would get all the Module and set on all this user have access to
       //var AccessR ='<label><input type="checkbox"> Test</label> &nbsp; <label><input type="checkbox"> Test</label>';
       //$('#AccessRole').html(AccessR);
          var dataString = 'userid='+ uid;
          $.ajax({
          type: "POST",
          url: "getAccessRole.php",
          data: dataString,
          cache: false,
          success: function(AccessR)
          {
             //$("#resultRFQ").html(html).show();
             //alert(html);
             $('#AccessRole').html(AccessR)
          },

          error:function(html)
          {
             //$("#resultRFQ").html(html).show();
             alert(html);
          }

          });
          
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

        function Delete_LineItem(uid, surnme, firstnme, gender, emai, phn)
    
        {  
      var title = 'Are You Sure you want to DELETE user with ID no.: '+uid + ', in surnme No.: '+surnme;
      
            var size='standart';
            var content = '<form role="form" method="post" action="adminruser"><div class="form-group">' +
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
                  <h3 class="box-title">ERP Activity Logs</h3>
                  <div class="box-tools pull-right">
                   <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->

                         <button type='button' onclick="ExportToExcel()" name='expbnt' id='exp-btn' title="Export to Excel" class="btn btn-flat"><i class="fa fa-send"></i></button>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>LogID</th>
                        <th>Actor</th>
                        <th>Activity</th>
                        <th>System Msg</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>S/N</th>
                        <th>LogID</th>
                        <th>Actor</th>
                        <th>Activity</th>
                        <th>System Msg</th>
                        <th>Date</th>
                      </tr>
                    </tfoot>
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
    <script src="../plugins/datatables/jquery.table2excel.js" type="text/javascript"></script>
	
	
<script src="../mBOOT/jquery-ui.js"></script>
    <script type="text/javascript">
     function ExportToExcel()
      {
        var Dat = "Activity Logs " + new Date();
        $("#userTab").table2excel({
              //exclude: ".noExl",
              name: "Activity Logs",
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