<?php
session_start();
error_reporting(0);
include ('DBcon/db_configOOP.php');
if ($_SESSION['uid'] == "" || $_SESSION['SurName'] == "") 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: users/login'); exit; }


$mainUID = $_SESSION['uid']; 

//Get Staff
$resultStaff = mysqli_query($dbhandle, "SELECT * FROM users where uid='".$mainUID."'"); 


$NoRowStaff = $resultStaff->num_rows;

 if ($resultStaff->num_rows > 0) {
     while($row = $resultStaff->fetch_assoc()) {
        $DeptID = $row['DeptID']; 
        /*$Supervisor = $row['Supervisor']; 
        $HDept = $row['HDept']; 
        $HDiv = $row['HDiv']; 
        $Mgr = $row['Mgr']; */
        $CEO = $row['CEO']; 
        $COO = $row['COO']; 
       
        }
      }

$resultDept = mysqli_query($dbhandle, "SELECT * FROM department");
 while ($row = $resultDept->fetch_assoc()) {
       
       $dpetID = $row['id'];
       $Department = $row['DeptmentName'];
       $hod = $row['hod'];
       
       $supervior = $row['supervisor'];
       if($mainUID == $supervior) { $MESUP = 1; }

       if($dpetID == 3 && $hod == $mainUID)
        { $CPHOD = 1; }
       elseif($dpetID == 5 && $hod == $mainUID)
        { $HRHOD = 1; }
       elseif ($mainUID == $hod) 
        { $MEHOD = 1; }
      
     }

$resultGM = mysqli_query($dbhandle, "SELECT * FROM divisions WHERE GM ='$mainUID' OR DH = '$mainUID'");
 while ($row = $resultGM->fetch_assoc()) {
         $CHKGMID = $row['GM'];
         if($mainUID == $CHKGMID) { $MEGM = 1; }
         $CHKDHID = $row['DH'];
         if($mainUID == $CHKDHID) { $MEHD = 1; }

      
       
     }
     


$resultDDGM = mysqli_query($dbhandle, "SELECT * FROM divisions WHERE divid =3");
 while ($row = $resultDDGM->fetch_assoc()) {
        $DDGMID = $row['GM'];
       if($mainUID == $DDGMID) { $DDGM = 1; }
     }

$resultCSGM = mysqli_query($dbhandle, "SELECT * FROM divisions WHERE divid =1");
 while ($row = $resultCSGM->fetch_assoc()) {
        $CSGMID = $row['GM'];
       if($mainUID == $CSGMID) { $CSGM = 1; }
     }
//echo $DDGMID; exit;
$prasa = $_SESSION['Picture'];
$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

$BusinessYr = $_SESSION['BusinessYear'];


?>
<!DOCTYPE html>
<html>
<!-- HEAD -->
<?php include ('header.php'); ?>
<!-- HEAD -->

<body class="skin-blue sidebar-mini">
    <div class="wrapper">

        <!-- Top Menu -->
        <?php include ('topmenu.php'); ?>
        <!-- Top Menu -->
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
                        <input type="text" name="q" class="form-control" placeholder="Search..." />
                        <span class="input-group-btn">
                            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i
                                    class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <?php include ('leftmenu.php');  ?>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>Version <?php echo $_SESSION['version']; ?></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
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
                    <?php if($CPHOD == 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/cnpppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">C & P</span>
                                    <span class="info-box-number"><small>Pending Approvals (MATERIAL)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/cashhodppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Head of Dept</span>
                                    <span class="info-box-number"><small>Pending Approvals (CASH)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Leave request that requires your approval" href="leave/deptleave"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-plane"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Head of Dept</span>
                                    <span class="info-box-number"><small>Pending Approvals (Leave)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->

                    <?php } ?>
                    <?php if($HRHOD == 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Leave request that requires your approval" href="leave/hrleave" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-plane"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">HR Pending Leave</span>
                                    <span class="info-box-number"><small>Pending Approvals (LEAVE)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->


                    <?php } ?>


                    <?php if ($DDGM == 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/gmdd" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="ion ion-ios-gear-outline"></i></span>
                                <div class="info-box-content">
                                    <!-- <span class="info-box-text">GM of Due D.</span>-->
                                    <span class="info-box-text">Manager of Inter.</span>
                                    <span class="info-box-number"><small>Pending Approvals (MATERIAL)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/cashmgddppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Manager of Inter.</span>
                                    <span class="info-box-number"><small>Pending Approvals (CASH)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Leave request that requires your approval" href="leave/gmleave" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-plane"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Manager of Inter.</span>
                                    <span class="info-box-number"><small>Pending Approvals (LEAVE)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>
                    <?php if($DeptID == 112 + "DDO") { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/officeddppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">DD Officer</span>
                                    <span class="info-box-number"><small>Pending Approvals (MATERIAL)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/cashofficeddppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">DD Officer</span>
                                    <span class="info-box-number"><small>Pending Approvals (CASH)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>
                    <?php if($MESUP == 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/supervisorppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-gear-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Supervisor</span>
                                    <span class="info-box-number"><small>Pending Approvals (MATERIAL)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/cashsupervisorppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Supervisor</span>
                                    <span class="info-box-number"><small>Pending Approvals (CASH)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>
                    <?php if($MEHOD == 1 || $HRHOD == 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/hodppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Head of Dept</span>
                                    <span class="info-box-number"><small>Pending Approvals (MATERIAL)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/cashhodppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Head of Dept</span>
                                    <span class="info-box-number"><small>Pending Approvals (CASH)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php }  ?>
                    <?php if($MEGM != 1) { ?>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Leave request that requires your approval" href="leave/deptleave"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-plane"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Head of Dept</span>
                                    <span class="info-box-number"><small>Pending Approvals (Leave)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->

                    <?php }   ?>


                    <?php if($CSGM == 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/gmcsppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="ion ion-ios-gear-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">GM of CS.</span>
                                    <span class="info-box-number"><small>Pending Approvals (MATERIAL)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/cashgmppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">GM of CS.</span>
                                    <span class="info-box-number"><small>Pending Approvals (CASH)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Leave request that requires your approval" href="leave/gmcsleave"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-plane"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">GM of CS.</span>
                                    <span class="info-box-number"><small>Pending Approvals (LEAVE)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Vendor Invoices request that requires your approval" href="GMCS/invoices"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-black"><i class="fa fa-file"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">GM of CS.</span>
                                    <span class="info-box-number"><small>Vendor Invoices</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>
                    <!-- //////////////////////////////////////////////////////////////////////////// -->
                    <?php if($COO == 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Cash Request that requires your approval" href="requisition/cooppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-cog"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">COO's Offfice.</span>
                                    <span class="info-box-number"><small>Pending Material Req. </small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View ENL POs that requires your approval" href="coo/purchaseorders" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-pink"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">COO's Offfice.</span>
                                    <span class="info-box-number"><small>Pending Approvals (ENL POs) </small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Cash Request that requires your approval" href="requisition/cashmdcoo"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">COO's Offfice.</span>
                                    <span class="info-box-number"><small>Pending Cash Req. </small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Vendor's Invoices that requires your approval" href="coo/invoices"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">COO's Offfice.</span>
                                    <span class="info-box-number"><small>Pending Approvals (Vendor's Invoices)
                                        </small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View ENL Contracts that requires your approval" href="coo/contracts" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-legal"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">COO's Offfice.</span>
                                    <span class="info-box-number"><small>Pending Approvals (ENL Contracts)
                                        </small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">

                        <a title="View Leave Request that requires your approval" href="./leave/cooleave"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-plane"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">COO's Offfice.</span>
                                    <span class="info-box-number"><small>Pending Leave Req. </small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->

                    <?php } elseif($MEGM == 1 && $DDGM != 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/gmppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="ion ion-ios-gear-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">GM of Div.</span>
                                    <span class="info-box-number"><small>Pending Approvals (MATERIAL)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/cashgmppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">GM of Div.</span>
                                    <span class="info-box-number"><small>Pending Approvals (CASH)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View leave request that requires your approval" href="leave/gmleave" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">GM of Div.</span>
                                    <span class="info-box-number"><small>Pending Approvals (LEAVE)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->

                    <?php } elseif ($MEHD == 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/divppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-orange"><i class="ion ion-ios-gear-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Head of Div.</span>
                                    <span class="info-box-number"><small>Pending Approvals (MATERIAL)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/cashdivppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-orange"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Head of Div.</span>
                                    <span class="info-box-number"><small>Pending Approvals (CASH)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="leave/divleave" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-orange"><i class="fa fa-plane"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Head of Div.</span>
                                    <span class="info-box-number"><small>Pending Approvals (LEAVE)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>



                    <?php if($CEO == 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/mdppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-pink"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">MD's Offfice.</span>
                                    <span class="info-box-number"><small>Pending Approvals (MATERIAL) </small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/cashmdppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-pink"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">MD's Offfice.</span>
                                    <span class="info-box-number"><small>Pending Approvals (CASH) </small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View leave request that requires your approval" href="leave/mdleave" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-plane"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">MD's Office</span>
                                    <span class="info-box-number"><small>Pending Approvals (LEAVE)</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View ENL POs that requires your approval" href="ceo/purchaseorders" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-pink"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">MD's Offfice.</span>
                                    <span class="info-box-number"><small>Pending Approvals (ENL POs) </small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Vendor's Invoices that requires your approval" href="ceo/invoices"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">MD's Offfice.</span>
                                    <span class="info-box-number"><small>Pending Approvals (Vendor's Invoices)
                                        </small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View ENL Contracts that requires your approval" href="ceo/contracts" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-legal"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">MD's Offfice.</span>
                                    <span class="info-box-number"><small>Pending Approvals (ENL Contracts)
                                        </small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>


                    <!-- fix for small devices only -->
                    <div class="clearfix visible-sm-block"></div>

                    <?php if($Mgr == 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/gmppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Manager</span>
                                    <span class="info-box-number"><small>Pending Approvals</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>

                    <?php if($Mgr == 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Requistions that requires your approval" href="requisition/divppor"
                            target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="ion ion-ios-gear-outline"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Manager</span>
                                    <span class="info-box-number"><small>Pending Approvals</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>


                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="Raise (PDF) Requistion" href="requisition/rpor" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-blue"><i class="fa fa-book"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Raise (PDF) </span>
                                    <span class="info-box-number"><small>New Requistions</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php if($DeptID == 2) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="MD Approved Invoice" href="accounts/mdinvoices" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-blue"><i class="fa fa-print"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">View (Approved Invoices)</span>
                                    <span class="info-box-number"><small>MD Approved Invoice</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->

                    <?php } ?>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View Cash Request" href="requisition/cashrequest" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-purple"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Cash Request </span>
                                    <span class="info-box-number"><small>Raise/Check</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->



                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View ICT Intervention Request" href="requisition/ict" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-desktop"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">ICT Request </span>
                                    <span class="info-box-number"><small>Raise/Check</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="View HIR Request" href="requisition/hir" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-bolt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Hazard ID Report </span>
                                    <span class="info-box-number"><small>Raise/Check</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="Whose Birthday is it?" href="birthday">
                            <div class="info-box">
                                <span class="info-box-icon bg-blue"><i class="fa fa-birthday-cake"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Birthday</span>
                                    <span class="info-box-number"><small>Whose is it?</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="My Leave" href="./leave/myleave" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-brown"><i class="fa fa-plane"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">My Leave</span>
                                    <span class="info-box-number"></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->

                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="My Travel" href="./users/mytravel" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-brown"><i class="fa fa-bus"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">My Travel</span>
                                    <span class="info-box-number"></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->

                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="My Query" href="./users/myquery" target="_blank">
                            <div class="info-box">
                                <span class="info-box-icon bg-brown"><i class="fa fa-question"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">My Query</span>
                                    <span class="info-box-number"></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->

                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="Status of Material Request" href="requisition/actedpdf" target="_blank">
                            <div class="info-box">
                                <span style="background: #422431" class="info-box-icon "><i
                                        class="fa fa-refresh"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Material Request </span>
                                    <span class="info-box-number">Status</span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->

                        </a>
                    </div><!-- /.col -->

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="Status of Cash Request" href="requisition/actedcash" target="_blank">
                            <div class="info-box">
                                <span style="background: #422431" class="info-box-icon "><i
                                        class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Cash Request </span>
                                    <span class="info-box-number">Status</span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->

                        </a>
                    </div><!-- /.col -->

                    <?php if((strpos($_SESSION['AccessModule'], "ERP Admin") !== false) || (strpos($_SESSION['AccessModule'], "View All Cash Request") !== false) || $_SESSION['uid'] == 27 || $_SESSION['uid'] == 2 || $_SESSION['uid'] == 8 || $_SESSION['uid'] == 100 || $_SESSION['uid'] == 19) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="Manage All Cash Request" href="requisition/allcash">
                            <div class="info-box">
                                <span style="background-color: #993300" class="info-box-icon"><i
                                        class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">All Cash Request </span>
                                    <span class="info-box-number"><small>Manage</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>

                    <?php if((strpos($_SESSION['AccessModule'], "ERP Admin") !== false) || (strpos($_SESSION['AccessModule'], "View All Material Request") !== false)) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="Manage All Material Request" href="requisition/allmat">
                            <div class="info-box">
                                <span style="background-color: #993300" class="info-box-icon"><i
                                        class="fa fa-cogs"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">All Material Request </span>
                                    <span class="info-box-number"><small>Manage</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>

                    <?php if((strpos($_SESSION['AccessModule'], "ERP Admin") !== false)) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="Manage All Vendor Invoice" href="admin/invoices">
                            <div class="info-box">
                                <span style="background-color: #993300" class="info-box-icon"><i
                                        class="fa fa-edit"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">All Vendor Invoice </span>
                                    <span class="info-box-number"><small>Manage</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="Manage All ENL PO" href="admin/allpos">
                            <div class="info-box">
                                <span style="background-color: #993300" class="info-box-icon"><i
                                        class="fa fa-paperclip"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">All ENL PO </span>
                                    <span class="info-box-number"><small>Manage</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>

                    <?php if($HRHOD == 1) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="Manage All Leave Request" href="leave/allleave">
                            <div class="info-box">
                                <span style="background-color: #993300" class="info-box-icon"><i
                                        class="fa fa-plane"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">All Leave Request </span>
                                    <span class="info-box-number"><small>Manage</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>

                    <?php if((strpos($_SESSION['AccessModule'], "ERP Admin") !== false)) { ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a title="Manage All Leave Request" href="leave/allleave">
                            <div class="info-box">
                                <span style="background-color: #993300" class="info-box-icon"><i
                                        class="fa fa-plane"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">All Leave Request </span>
                                    <span class="info-box-number"><small>Manage</small></span>
                                </div><!-- /.info-box-content -->
                            </div><!-- /.info-box -->
                        </a>
                    </div><!-- /.col -->
                    <?php } ?>
                </div><!-- /.row -->





            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!-- FOOTER -->
        <?php include ('footer.php'); ?>
        <!-- FOOTER -->

        <!-- Control Sidebar -->
        <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
        <div class='control-sidebar-bg'></div>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard2.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>
</body>

</html>