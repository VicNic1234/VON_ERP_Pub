<?php
session_start();
error_reporting(0);
//include ('route.php'); 

$b_url = trim(strip_tags($_POST['burl']));
$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

require '../DBcon/db_config.php';
//Load Reporting Managers
$RptMgropt = "";
$RptMgrUt = mysql_query("SELECT * FROM users WHERE isActive=1 ORDER BY Surname");
$NoRowRptMgrUt = mysql_num_rows($RptMgrUt);

if ($NoRowRptMgrUt > 0) 
{
  while ($row = mysql_fetch_array($RptMgrUt)) {
    $id = $row['uid'];
    $bnu = $row['Surname'] ." ". $row['Firstname'];
    $RptMgropt .= '<option value="'.$id.'">'.$bnu.'</option>';
    }
} else { $RptMgropt .= '<option value="" > No Reporting Manager </option>'; }

//Load Job Title
$JBTopt = "";
$JBTUt = mysql_query("SELECT * FROM jobtitle ORDER BY JobTitle");
$NoRowJBTUt = mysql_num_rows($JBTUt);

if ($NoRowJBTUt > 0) 
{
  while ($row = mysql_fetch_array($JBTUt)) {
    $jid = $row{'id'};
    $jbnu = $row['JobTitle'];
    $JBTopt .= '<option value="'.$jid.'">'.$jbnu.'</option>';
    }
} else { $JBTopt .= '<option value="" > No Job Title </option>'; }

//Load Job Position
$JBPopt = "";
$JBPUt = mysql_query("SELECT * FROM jobposition ORDER BY JobPosition");
$NoRowJBPUt = mysql_num_rows($JBPUt);

if ($NoRowJBPUt > 0) 
{
  while ($row = mysql_fetch_array($JBPUt)) {
    $jid = $row{'id'};
    $jbnu = $row['JobPosition'];
    $JBPopt .= '<option value="'.$jid.'">'.$jbnu.'</option>';
    }
} else { $JBPopt .= '<option value="" > No Job Title </option>'; }


//Load Business Unit
$BUopt = "";
$BusUt = mysql_query("SELECT * FROM businessunit ORDER BY BussinessUnit");
$NoRowBusUt = mysql_num_rows($BusUt);

if ($NoRowBusUt > 0) 
{
  while ($row = mysql_fetch_array($BusUt)) {
    $id = $row{'id'};
    $bnu = $row['BussinessUnit'];
    $BUopt .= '<option value="'.$id.'">'.$bnu.'</option>';
    }
} else { $BUopt .= '<option value="" > --- </option>'; }

//Load Dept
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
    $Supervisor = $row ['Supervisor'];
    $HDept = $row ['HDept'];
    $HDiv = $row ['HDiv'];
    $CEO = $row ['CEO'];
    $COO = $row ['COO'];
    $Mgr = $row ['Mgr'];
    $ActStatus = $row ['isActive'];
    $Passwrd = $row ['Password'];

    if ($ActStatus != '1') 
     {
    $AppStatus = '<input type="checkbox" title="Activate Account" id="hpc'.$uid.'" r="'.$uid.'" onclick="cpc(this);"></input>';
     }
     if ($ActStatus == '1') 
     {
     $AppStatus = '<input  type="checkbox" checked title="Deactivate" id="hpc'.$uid.'" r="'.$uid.'" onclick="cpc(this);"></input>';
     }

     if ($Supervisor == 1) { $Supervisor = '<input type="checkbox" ps="Supervisor" title="Supervisor" checked r="'.$uid.'" onclick="setHDept(this);"></input>'; }
     else { $Supervisor = '<input type="checkbox" r="'.$uid.'" ps="Supervisor"  title="Supervisor" onclick="setHDept(this);"></input>'; }

     if ($HDept == 1) { $HDept = '<input type="checkbox" ps="Dept" title="Head of Department" checked r="'.$uid.'" onclick="setHDept(this);"></input>'; }
     else { $HDept = '<input type="checkbox" r="'.$uid.'" ps="Dept"  title="Head of Department" onclick="setHDept(this);"></input>'; }
    
    if ($HDiv == 1) { $HDiv = '<input type="checkbox" title="Head of Division" checked r="'.$uid.'" ps="Div" onclick="setHDept(this);"></input>'; }
     else { $HDiv = '<input type="checkbox" r="'.$uid.'" ps="Div" title="Head of Division" onclick="setHDept(this);"></input>'; }
    
     if ($Mgr == 1) { $Mgr = '<input type="checkbox" title="Manager" checked r="'.$uid.'" ps="Mgr" onclick="setHDept(this);"></input>'; }
     else { $Mgr = '<input type="checkbox" r="'.$uid.'" title="Manager" ps="Mgr" onclick="setHDept(this);"></input>'; }

     if ($CEO == 1) { $CEO = '<input type="checkbox" title="MD" checked r="'.$uid.'" ps="CEO" onclick="setHDept(this);"></input>'; }
     else { $CEO = '<input type="checkbox" r="'.$uid.'" title="MD" ps="CEO" onclick="setHDept(this);"></input>'; }
    
      if ($COO == 1) { $COO = '<input type="checkbox" title="COO" checked r="'.$uid.'" ps="COO" onclick="setHDept(this);"></input>'; }
     else { $COO = '<input type="checkbox" r="'.$uid.'" title="COO" ps="COO" onclick="setHDept(this);"></input>'; }
    

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
           
            <td>'.$CEO.'</td>
            <td>'.$COO.'</td>
            <td><a '.  'onclick="open_container('.$uid.',\''.$SurName.'\',\''.$Firstname.'\',\''.$Gender.'\',\''.$Email.'\',\''.$Phone.'\',\''.$Passwrd.'\',\''.$StaffID.'\');">'. '<span class="glyphicon glyphicon-edit"></span></a></td>
            <td><a '.  'onclick="Delete_LineItem('.$uid.',\''.$SurName.'\',\''.$Firstname.'\',\''.$Gender.'\',\''.$Email.'\',\''.$Phone.'\',\''.$Role.'\');">'. '<span class="glyphicon glyphicon-trash"></span></a></td>
            
           </tr>
           
           
           ';

           /*
            <td>'.$Supervisor.'</td>
            <td>'.$HDept.'</td>
            <td>'.$HDiv.'</td>
            */
    }
} 

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
            User Administration
            <small><?php echo $_SESSION[version]; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo $b_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User Administration</li>
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
                  <h3 class="box-title">Register Staff On ERP</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div>
                    <div class="col-md-9" style="background-color:#FBFBFB">
                      <p class="text-center">
                        <strong>Staff's Details</strong>
                      </p>
                  <form enctype="multipart/form-data" action="reguser" method="post" style="font-size:13px;">
          
          <div class="form-group has-feedback col-md-4">
          <label>First Name <span style="color:red">*<span></label>
          <input type="text" class="form-control" id="Fname" name="Fname" placeholder="First name"required />
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Last Name <span style="color:red">*<span></label>
		      <input type="text" class="form-control" id="Surname" name="Surname" placeholder="Surname"required />
          </div>

          <div class="form-group has-feedback col-md-3">
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

          

          <!-- Matte -->

         

          
          <div class="form-group has-feedback col-md-4">
          <label>Staff ID <!--<span style="color:red">*<span>--></label>
          <input type="text" class="form-control" id="staffid" name="staffid" placeholder="Staff ID" />
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Phone Number <!--<span style="color:red">*<span>--></label>
          <input type="text" class="form-control" id="staffphn" name="staffphn" placeholder="Staff Phone" />
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Email <span style="color:red">*<span></label>
          <input type="email" class="form-control" id="staffmail" name="staffmail" placeholder="Email" required />
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Password <span style="color:red">*<span></label>
          <input type="password" class="form-control" id="staffPass" name="staffPass" placeholder="Password" required />
          </div>
          

         
         
              
                    </div><!-- /.col -->
                    <div class="col-md-3">
                      <p class="text-center">
                        <strong>Staff Image</strong>
                      </p>
			<center><img id="uploadPreview" class="img-circle" style="width: 200px; height: 200px;" /></center>

<script type="text/javascript">

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("StaffPhoto").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

</script>
<br>
			<div class="form-group has-feedback">
            <input type="file" id="StaffPhoto" name="StaffPhoto" accept="image/jpg" class="form-control" onchange="PreviewImage();" placeholder="Passport"/>
			
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>		  
          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div><!-- /.col -->
          </div>
                      </form> 
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
	  <script language="javascript">

        
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
       '<br/><br/><br/>'+
      '<div class="form-group col-md-12"><br/><label>Signature </label><input type="file" class="form-control" id="SignPhoto" name="SignPhoto" placeholder="Signature"></div>' +
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
                  <h3 class="box-title">Staff List on ERP</h3>
                  <div class="box-tools pull-right">
                   <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->

                         <button type='button' onclick="ExportToExcel()" name='expbnt' id='exp-btn' title="Export to Excel" class="btn btn-flat"><i class="fa fa-send"></i></button>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                  <table id="userTabN" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>StaffID</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Dept</th>
                        <th>Email</th>
            						<th>Phone</th>
                        <th>Activate</th>
                        <!--<th>Supervisor</th>
                        <th>Dept Head</th>
                        <th>Div Head</th>-->
                        <th>MD</th>
                        <th>COO</th>
                        <th>Quick Edit</th>
                        <th>-</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                         <th>S/N</th>
                        <th>StaffID</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Dept</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Activate</th>
                       <!-- <th>Supervisor</th>
                        <th>Dept Head</th>
                        <th>Div Head</th>-->
                        <th>MD</th>
                        <th>COO</th>
                        <th>Quick Edit</th>
                        <th>-</th>
                        
                      </tr>
                    </tfoot>
                  </table>
                  </div>
                </div><!-- /.box-body -->
              
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- CRM USERS SETUP -->

          <div class="row">
            <div class="col-md-12">
              <div class="box collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">Register CRM Users On ERP</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                 <div class="row"> 
                    <div class="col-md-12" style="background-color:#FBFBFB">
          <form enctype="multipart/form-data" action="regCRMuser" method="post" style="font-size:13px;">
          
          <div class="form-group has-feedback col-md-4">
          <label>Username <span style="color:red">*<span></label>
          <input type="text" class="form-control" id="CRMUsername" name="CRMUsername" placeholder="Username" required />
          </div>
          <div class="form-group has-feedback col-md-4">
          <label>Email <span style="color:red">*<span></label>
          <input type="email" class="form-control" id="CRMEmail" name="CRMEmail" required />
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Password <span style="color:red">*<span></label>
          <input type="password" class="form-control" id="CRMPassword" name="CRMPassword" placeholder="Password" required />
          </div>

          <div class="form-group col-md-4">
          <label>Customer <span style="color:red">*<span></label>
          <select class="form-control tokenize-demo" style="width:100%; padding:17px;" id="CRMCus" name="CRMCus" required>
          <?php echo $OptCustomer; ?>
          </select>
          </div>
          <div class="form-group col-md-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
          </div>

           </form> 

           <script>      
            $('.tokenize-demo').select2();
          </script>

          <!-- Matte -->

              
                    </div><!-- /.col -->
                   
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

            <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">CRM Users List on ERP</h3>
                  <div class="box-tools pull-right">
                   <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                         <button type='button' onclick="ExportToExcel()" name='expbnt' id='exp-btn' title="Export to Excel" class="btn btn-flat"><i class="fa fa-send"></i></button>
                    --><button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="userTab1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Custormer</th>
                        <th>Activate</th>
                        <th>Quick Edit</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $CUSRecord; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>S/N</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Custormer</th>
                        <th>Activate</th>
                        <th>Quick Edit</th>
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
      function setHDept(elem)
      {

        var UID = $(elem).attr('r');
        var PS = $(elem).attr('ps');

        var Chk = 0;

        if($(elem).is(':checked'))
        {
          Chk = 1;
        }

        var dataString = {UID:UID, PS:PS, Chk:Chk}; 
         $.ajax({
              type: "POST",
              url: "setHV.php",
              data: dataString,
              cache: false,
              success: function(html)
              {
                //$("#BusUnt").html(html);
              }
          });
        // /r="'.$uid.'" ps="Dept"
      }
    </script>
    <script type="text/javascript">
     function ExportToExcel()
      {
        var Dat = "Staff List " + new Date();

        $("#userTabN").table2excel({
              exclude: ".noExl",
              name: "Staff List",
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
	   
        $("#userTabN").dataTable();
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