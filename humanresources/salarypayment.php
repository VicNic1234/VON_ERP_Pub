<?php
session_start();
error_reporting(0);
include ('route.php');

$b_url = trim(strip_tags($_POST['burl']));
$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

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

//Load $BankList
$BankList = '<option> --- </option>';
$BList = mysql_query("SELECT * FROM banks ORDER BY name");
$NoRowBL = mysql_num_rows($BList);

if ($NoRowBL > 0) 
{
  while ($row = mysql_fetch_array($BList)) {
    $jid = $row['id'];
    $jbnu = $row['name'];
    $BankList .= '<option value="'.$jid.'">'.$jbnu.'</option>';
    }
} else { $BankList .= '<option value="" > No Bank </option>'; }

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
$UsersUt = mysql_query("SELECT * FROM users LEFT JOIN department ON users.DeptID = department.id Where users.isActive=1 AND users.isAvalible=1 ORDER BY Surname");
$NoRowUsersUt = mysql_num_rows($UsersUt);

if ($NoRowUsersUt > 0) 
{
  while ($row = mysql_fetch_array($UsersUt)) {
    $snid = $snid + 1;
    $uid = $row['uid'];
      $SurName = $row['Surname'];
    $Firstname = $row['Firstname'];
    $Gender = $row['Gender'];
    $StaffID = $row['StaffID'];
    $DateReg = $row['DateReg'];
    $Email = $row['Email'];
    $Phone = $row['Phone'];
    $DoB = $row['DoB'];
    /*$BankName = $row['BankName'];
    $BankAccount = $row['BankAccount'];
    $BankAccountType = $row['BankAccountType']; */
    $salary = $row['Salary']; 
    $DoJ = $row['DateOfJoining'];//YOExp
    $YOExp = $row['YearsOfExp'];//
    $WorkExt = $row['WorkExt'];
    $Picture = $row['Picture'];
    $Dept = $row['DeptmentName'];
    $Role = $row['Role'];
    $PORApp = $row['porApproval'];
    $ActStatus = $row['isActive'];
    $LastPaymentDate = $row['LastPaymentDate'];
     $PayrollElem = $row['PayrollElem'];
     
     $BankID = $row['BankID'];
      $AccountType = $row['AccountType'];
       $AccountNumber = $row['AccountNumber'];
        $GrossSalary = $row['GrossSalary'];
    
/*
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
     $PORAppStatus = '<input type="checkbox" title="Select to Apply Action" id="hpc'.$uid.'" r="'.$uid.'" onclick="cpc(this);"></input>';
     }
     if ($PORApp == '1') 
     {
     //$PCStatus = '<i class="fa fa-check" title="Close from Project Control" r="'.$LitID.'" id="hpc'.$LitID.'" onclick="cpc(this);"></i>';
     $PORAppStatus = '<input  type="checkbox" checked title="Select to Apply Action" id="hpc'.$uid.'" r="'.$uid.'" onclick="cpc(this);"></input>';
     }
     */

      $Record .='
           <tr>
              <td>'.$snid.'</td>
            <td>'.$StaffID.'</td>
            <td>'.$SurName.'</td>
            <td>'.$Firstname.'</td>
            <td>'.$Dept.'</td>
            <td>'.$Email.'</td>
            <td>'.$Phone.'</td> 
            <td> Monthly </td>
            <td> '. number_format($GrossSalary).' </td>
            <td> '.$LastPaymentDate.' </td>
                      
            <td><a '.  'onclick="open_container('.$uid.',\''.$SurName.'\',\''.$Firstname.'\',\''.$BankID.'\',\''.$AccountNumber.'\',\''.$AccountType.'\',\''.$GrossSalary.'\');">'.  '<span class="glyphicon glyphicon-edit"></span></a></td>
            <td><input  type="checkbox"  title="Select to Apply Action" id="hpc'.$uid.'" r="'.$uid.'" onclick="cpcw(this);"></input></td>
            <td><a href="../users/employee?dc='.$uid.'">'. '<span class="fa fa-eye"></span></a></td>
            
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
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Employee</title>
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

       <?php include('../topmenu2.php') ?>
      <!-- Left side column. contains the logo and sidebar -->
        <?php include('leftmenu.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Staff Renumeration
            <small><?php echo $_SESSION[version]; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo $b_url; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Staff Renumeration</li>
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
  
          <div class="row" style="display:none">
            <div class="col-md-12">
              <div class="box collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">Register New Staff On ERP</h3>
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
                  <form enctype="multipart/form-data" action="regnew" method="post" style="font-size:13px;">
          
          <div class="form-group has-feedback col-md-4">
          <label>First Name <span style="color:red">*<span></label>
          <input type="text" class="form-control" id="Fname" name="Fname" placeholder="First name"required />
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
          </div>

          <!-- Matte 

          <div class="form-group has-feedback col-md-4">
          <label>Job Title <span style="color:red">*<span></label>
          <select class="form-control"  id="jbtitle" name="jbtitle" required>
          <option value=""> -- </option>
          <?php echo $JBTopt; ?>
          </select>
          </div>-->

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

          <div class="form-group has-feedback col-md-4">
          <label>Employee Status <span style="color:red">*<span></label>
          <select class="form-control"  id="empsta" name="empsta" required>
          <option value=""> -- </option>
          <option value="Contract"> Contract</option>
          <option value="Deputation"> Deputation</option>
          <option value="Full Time"> Full Time</option>
          <option value="Left"> Left</option>
          <option value="Part Time"> Part Time</option>
          <option value="Parmanent"> Parmanent</option>
          <option value="Probationary"> Probationary</option>
          <option value="Resigned"> Resigned</option>
          <option value="Suspended"> Suspended</option>
          <option value="Temporary"> Temporary</option>
          </select>
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Date of Joining <span style="color:red">*<span></label>
          <input type="text" class="form-control" id="DOJ" name="DOJ" placeholder="Date of Joining" value="<?php echo $DoJ; ?>" required />
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Years of Experience <span style="color:red">*<span></label>
          <input type="text" class="form-control" id="YOEx" name="YOEx" placeholder="Years of Experience" value="<?php echo $YOExp; ?>" required />
          </div>

         

          <div class="form-group has-feedback col-md-4">
          <label>Work Phone No. </label>
          <input type="text" class="form-control" id="WkPhn" name="WkPhn" placeholder="Work Phone No." value="<?php echo $Phone; ?>" />
          </div>

        

          <!-- Matte -->

          <div class="form-group has-feedback col-md-4">
          <label>Date of Birth <span style="color:red">*<span></label>
          <input type="text" class="form-control" id="DOB" name="DOB" placeholder="Date of Birth" value="<?php echo $DoB; ?>" required />
          </div>

           <div class="form-group has-feedback col-md-3">
          <label>Extension </label>
          <input type="text" class="form-control" id="WkEx" name="WkEx" value="<?php echo $WorkExt; ?>" placeholder="Extension" />
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Staff ID <span style="color:red">*<span></label>
          <input type="text" class="form-control" id="staffid" name="staffid" placeholder="Staff ID" value="<?php echo $WorkExt; ?>" required />
          </div>

          <div class="form-group has-feedback col-md-4">
          <label>Phone Number <span style="color:red">*<span></label>
          <input type="text" class="form-control" id="staffphn" name="staffphn" placeholder="Staff Phone" value="<?php echo $WorkExt; ?>" required />
          </div>

          <div class="form-group has-feedback col-md-8">
          <label>email <span style="color:red">*<span></label>
          <input type="email" class="form-control" id="staffmail" name="staffmail" placeholder="Email" value="<?php echo $WorkExt; ?>" required />
          </div>

         
         
              
                    </div><!-- /.col -->
                    <div class="col-md-3">
                      <p class="text-center">
                        <strong>Staff Image</strong>
                      </p>
			<center><img id="uploadPreview" style="width: 200px; height: 200px;" /></center>

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
            <input type="file" id="StaffPhoto" name="StaffPhoto" accept="image/jpg" class="form-control" onchange="PreviewImage();" placeholder="Passport" Required/>
			
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
  						
        function open_container(uid, surnme, firstnme, bnk, bnkacct, bnkacctyp, salary)
		
        {  
            //'.$uid.',\''.$SurName.'\',\''.$Firstname.'\',\''.$BankID.'\',\''.$AccountNumber.'\',\''.$AccountType.'\',\''.$GrossSalary.'\'
			var title = 'Account Info For '+surnme + ' ' +  firstnme +'\'s Info.';
			var banklist = '<?php echo $BankList; ?>';
            var size='standart';
			
            var content = '<form role="form" method="post" action="updatesalary" enctype="multipart/form-data" ><div class="form-group">' +
		/*	'<div class="form-group has-feedback" style="width:100%;">' +
		    '<label>First name: </label>' +
            '<input type="text" class="form-control" id="firstnme" name="firstnme" placeholder="Description of Line Item" value="'+ firstnme +'" ></input>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
			'</div>' + */ 
			'<div class="col-md-12">'+
			'<input type="hidden" name="uID" value="'+ uid +'" ></input>' +
			'<div class="form-group has-feedback col-md-12">'+
              '<label>Staff Payroll Elements <span style="color:red">*<span></label>'+
              '<div id="PayrollElem" style="padding:7px;"></div>' +
              '</div>'+     
             '<br/><br/><br/>'+
		    /*	'<div class="form-group has-feedback" style="width:100%;">' +
		    '<label>Surname: </label>' +
            '<input type="text" class="form-control" id="surnme" name="surnme" placeholder="Description of Line Item" value="'+ surnme +'" ></input>' +
            '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
			'</div>' + */
			
				
		    '<div class="form-group col-md-6">' +
		    '<label>Bank Name:  </label>' +
            //'<input type="text" class="form-control" id="BankName" name="BankName" placeholder="Bank Name" value="'+bnk+'" required />' +
            '<select class="form-control" id="BankList" name="Bank" required>' +
		    banklist+
			'</select>' +
            '</div>' +
			
			'<div class="form-group col-md-6">' +
			'<label>Bank Account Type: </label>' +
			'<select class="form-control" id="BankAccountType" name="BankAccountType" required>' +
			'<option value="'+bnkacctyp+'" selected > '+bnkacctyp+'</option>' +
			'<option value="Savings"> Savings</option>' +
			'<option value="Current"> Current</option>' +
			'</select>' +
			'</div>' +
			
			'</div>' +
		
			
			'<div class="form-group col-md-6">' +
			'<label>Account Number: </label>' +
            '<input type="text" class="form-control" id="AccountNumber" name="AccountNumber" placeholder="Account Number" value="'+bnkacct+'" required />' +
            '</div>'+
            
             '<div class="form-group col-md-6">' +
              '<label>Gross Salary:  </label>' +
             '<input type="number" class="form-control" id="salary" name="salary" placeholder="Gross Salary" value="'+salary+'" required />' +
           
            '</div>' +
			//'</div>'+
		
			   
			//'<button type="button" onclick="alert(\' Kindly setup your payment aggregator API \')" class="btn btn-success pull-right">Update</button> </div></form>';
			'<button type="submit"  class="btn btn-success pull-right">Update</button> </div></form>';
				
           // var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
            $('#BankList').val(bnk);
            loadPayrollElem(uid);
        }

         function loadPayrollElem(uid)
        {
          //Here we would get all the Module and set on all this user have access to
       //var AccessR ='<label><input type="checkbox"> Test</label> &nbsp; <label><input type="checkbox"> Test</label>';
       //$('#AccessRole').html(AccessR); 'userid='+ uid
          var dataString = { userid:uid };
          $.ajax({
          type: "POST",
          url: "../users/getMyPayrollElements.php",
          data: dataString,
          cache: false,
          success: function(AccessR)
          {
            $('#PayrollElem').html(AccessR)
          },

          error:function(html)
          {
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
                    <div class="form-group has-feedback" style="width:150px; display: inline-block; margin:1px;">
                         <button type='button' onclick="Pay()" name='expbnt' id='exp-btn' title="Click to Pay" class="btn btn-warning"><i class="fa fa-send"></i></button>
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
                        <th>StaffID</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Dept</th>
                        <th>Email</th>
                       <th>Phone</th>
                       <th>Duration</th>
					   <th>Gross Salary</th>
                       <th>Last Payment</th>
                        <th>Set Gross/Net</th>
                       <th>Action On</th>
					   <th>View Profile</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                    <tfoot class="noExl">
                      <tr>
                        <th>S/N</th>
                        <th>StaffID</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Dept</th>
                        <th>Email</th>
                       <th>Phone</th>
                       <th>Duration</th>
					   <th>Gross Salary</th>
                       <th>Last Payment</th>
                        <th>Set Gross/Net</th>
                       <th>Action On</th>
					   <th>View Profile</th>
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
        var Dat = "Staff List " + new Date();
        $("#userTab").table2excel({
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