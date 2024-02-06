<?php
session_start();
error_reporting(0);
require '../DBcon/db_config.php';
include ('route.php');


$uid = trim(strip_tags($_GET['dc']));
$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
//if ($_SESSION['uid'] == $uid)
//We have to pull Users full details out now
$resultEmpDetail = mysql_query("SELECT * FROM users WHERE uid ='".$uid."'");
//check if doc exist
$NoRowEmpDetail = mysql_num_rows($resultEmpDetail);
if ($NoRowEmpDetail > 0) {
  while ($row = mysql_fetch_array($resultEmpDetail)) {
    $nuid = $row{'uid'};
    $SurName = $row['Surname'];
    $Firstname = $row ['Firstname'];
    $Middlename = $row ['Middlename'];
    $Gender = $row ['Gender'];
    $StaffID = $row ['StaffID'];
    $DateReg = $row ['DateReg'];
    $Email = $row ['Email'];
    $Phone = $row ['Phone'];
    $DeptID = $row ['DeptID'];
    $BUID = $row ['BusinessUnit'];
    $JobT = $row ['JobTitle'];
    $JobP = $row ['JobPosition'];
    $RptMgr = $row ['RptMgr'];
    $DoB = $row ['DoB'];
    $YoExp = $row ['YearsOfExp'];
    $WorkExt = $row ['WorkExt']; 
    $EmployeeStatus = $row ['EmployeeStatus'];
    $ModeOfEmp = $row ['ModeOfEmp'];
    $WorkPhone = $row ['WorkPhone'];
    $DoJ = $row ['DateOfJoining'];
    $SPicture = $row ['Picture'];
    $Dept = $row ['Dept'];
    $porA = $row ['porApproval'];
    $dURL = $row ['Dept'];
    $Role = $row ['Role'];
  }
}
else
{
  echo "User does not exist!";
  exit;
}

//Load Reporting Managers
$RptMgropt = "";
$RptMgrUt = mysql_query("SELECT * FROM users WHERE isActive=1 ORDER BY Surname");
$NoRowRptMgrUt = mysql_num_rows($RptMgrUt);

if ($NoRowRptMgrUt > 0) 
{
  while ($row = mysql_fetch_array($RptMgrUt)) {
    $idrm = $row{'uid'};
    $bnurm = $row['Surname'] ." ". $row['Firstname'];
    if ($idrm == $RptMgr){$RptMgropt .= '<option value="'.$idrm.'" selected >'.$bnurm.'</option>';}
    else {$RptMgropt .= '<option value="'.$idrm.'">'.$bnurm.'</option>';}
    
    }
} else { $RptMgropt .= '<option value="" > No Reporting Manager </option>'; }

//Load Dept
$DepUtOpt = "";
$DepUt = mysql_query("SELECT * FROM department ORDER BY DeptmentName");
$NoRowDepUt = mysql_num_rows($DepUt);

if ($NoRowDepUt > 0) 
{
  while ($row = mysql_fetch_array($DepUt)) {
    $id = $row{'id'};
    $bnu = $row['DeptmentName'];
    if ($id == $DeptID){$DepUtOpt .= '<option value="'.$id.'" selected >'.$bnu.'</option>';}
    else{$DepUtOpt .= '<option value="'.$id.'">'.$bnu.'</option>';}
    
    }
} else { $DepUtOpt .= '<option value="" > No Department </option>'; }

//Load Business Unit //
$BusUtOpt = "";
$BusUtc = mysql_query("SELECT * FROM businessunit ORDER BY BussinessUnit");
$NoRowBusUt = mysql_num_rows($BusUtc);

if ($NoRowBusUt > 0) 
{
  while ($row = mysql_fetch_array($BusUtc)) {
    $idb = $row{'id'};
//$idDept = $row['DeptID'];
    $bnub = $row['BussinessUnit'];
    if ($idb == $BUID){$BusUtOpt .= '<option value="'.$idb.'" selected >'.$bnub.'</option>';}
    else{$BusUtOpt .= '<option value="'.$idb.'">'.$bnub.'</option>';}
    
    }
} else { $BusUtOpt .= '<option value="" > --- </option>'; }




//Let Load Details now
$resultDOC = mysql_query("SELECT * FROM empdocuments WHERE user_id ='".$uid."'");
//check if doc exist
 $NoRowDOC = mysql_num_rows($resultDOC);
 $DocRec = "<tr><td colspan=5><center>No Record</center></td></tr>";
 $DocSN = 0;
 if ($NoRowDOC > 0) {
  $DocRec = "";
  while ($row = mysql_fetch_array($resultDOC)) {
    $DocSN =  $DocSN + 1;
    $DocID = "DOC-" . $row{'id'};
    $DocTitle = $row['name'];
    $DocDes = $row ['description'];
    $DocLink = $row ['attachments'];
    $DocLinkC = '<a target="_blank" href="'.$DocLink.'"><i class="fa fa-download"></i></a>';
    $DocRec .= '<tr><td>'.$DocSN.'</td><td>'.$DocID.'</td><td>'.$DocTitle.'</td><td>'.$DocDes.'</td><td>'.$DocLinkC.'</td></tr>';
    
  }
}

//Lets'get Education History now
$resultEdu = mysql_query("SELECT * FROM empeducation WHERE user_id ='".$uid."'");
//check if doc exist
 $NoRowEdu = mysql_num_rows($resultEdu);
 $EduRec = "<tr><td colspan=5><center>No Record</center></td></tr>";
 $EduSN = 0;
 if ($NoRowEdu > 0) {
  $EduRec = "";
  while ($row = mysql_fetch_array($resultEdu)) {
    $EduSN =  $EduSN + 1;
    $eduInstitue = $row['eduInstitue'];
    $eduYearFrom = $row ['eduYearFrom'];
    $eduYearTo = $row ['eduYearTo'];
    $eduTitle = $row ['eduTitle'];
    $DocLink = $row ['eduCert'];
    $DocLinkC = '<a target="_blank" href="'.$DocLink.'"><i class="fa fa-download"></i></a>';
    $EduRec .= '<tr><td>'.$EduSN.'</td><td>'.$eduInstitue.'</td><td>'.$eduYearFrom.'</td><td>'.$eduYearTo.'</td><td>'.$eduTitle.'</td><td>'.$DocLinkC.'</td></tr>';
    
  }
}

//Lets'get Train/Cert. now
$resultTrain = mysql_query("SELECT * FROM emptrainncert WHERE user_id ='".$uid."'");
//check if doc exist
 $NoRowTrain = mysql_num_rows($resultTrain);
 $RecordTrain = "<tr><td colspan=5><center>No Record</center></td></tr>";
 $TrainSN = 0;
 if ($NoRowTrain > 0) {
  $RecordTrain = "";
  while ($row = mysql_fetch_array($resultTrain)) {
    $TrainSN =  $TrainSN + 1;
    $eduInstitue = $row['eduInstitue'];
    $eduYearFrom = $row ['eduYearFrom'];
    $eduYearTo = $row ['eduYearTo'];
    $eduTitle = $row ['eduTitle'];
    $DocLink = $row ['eduCert'];
    $DocLinkC = '<a target="_blank" href="'.$DocLink.'"><i class="fa fa-download"></i></a>';
    $RecordTrain .= '<tr><td>'.$EduSN.'</td><td>'.$eduInstitue.'</td><td>'.$eduYearFrom.'</td><td>'.$eduYearTo.'</td><td>'.$eduTitle.'</td><td>'.$DocLinkC.'</td></tr>';
    
  }
}


//Lets'get Medi Rec now
$resultMedi = mysql_query("SELECT * FROM empmedi WHERE user_id ='".$uid."'");
//check if doc exist
 $NoRowMedi = mysql_num_rows($resultMedi);
 $RecordMedi = "<tr><td colspan=5><center>No Record</center></td></tr>";
 $MediSN = 0;
 if ($NoRowMedi > 0) {
  $RecordMedi = "";
  while ($row = mysql_fetch_array($resultMedi)) {
    $MediSN =  $MediSN + 1;
    $ailmentType = $row['ailmentType'];
    $ailmentName = $row ['ailmentName'];
    $DiagnosedOn = $row ['DiagnosedOn'];
    $PresentCond = $row ['PresentCond'];
    $DocLink = $row ['mediDoc'];
    $DocLinkC = '<a target="_blank" href="'.$DocLink.'"><i class="fa fa-download"></i></a>';
    $RecordMedi .= '<tr><td>'.$MediSN.'</td><td>'.$ailmentType.'</td><td>'.$ailmentName.'</td><td>'.$DiagnosedOn.'</td><td>'.$PresentCond.'</td><td>'.$DocLinkC.'</td></tr>';
    
  }
}



//Let Load Contact now
$resultCont = mysql_query("SELECT * FROM empcontacts WHERE user_id ='".$uid."'");
//check if doc exist
 $NoRowCont = mysql_num_rows($resultCont);
 $RecordContact = "<tr><td colspan=5><center>No Record</center></td></tr>";
 $ContSN = 0;
 if ($NoRowCont > 0) {
  $RecordContact = "";
  while ($row = mysql_fetch_array($resultCont)) {
    $ContSN =  $ContSN + 1;
    $ContName = $row{'ContactName'};
    $Relationship = $row{'Relationship'};
    $Address = $row{'Address'};
    $PhoneNo = $row{'PhoneNo'};
    $LGA = $row{'LGA'};
    $RecordContact .= '<tr><td>'.$ContName.'</td><td>'.$Relationship.'</td><td>'.$Address.'</td><td>'.$PhoneNo.'</td><td>'.$LGA.'</td></tr>';
    
  }
}

//Let Load Skills now
$resultSkills = mysql_query("SELECT * FROM empskills WHERE user_id ='".$uid."'");
//check if doc exist
 $NoRowSkills = mysql_num_rows($resultSkills);
 $RecordSkills = "<tr><td colspan=5><center>No Record</center></td></tr>";
 $SkillsSN = 0;
 if ($NoRowSkills > 0) {
  $RecordSkills = "";
  while ($row = mysql_fetch_array($resultSkills)) {
    $SkillsSN =  $SkillsSN + 1;
    $Name = $row{'Skill'};
    $ObtainedFrm = $row{'ObtainedFrm'};
    $ObtainedOn = $row{'ObtainedOn'};
    $RecordSkills .= '<tr><td>'.$Name.'</td><td>'.$ObtainedOn.'</td><td>'.$ObtainedFrm.'</td><td>'.$PhoneNo.'</td><td>'.$LGA.'</td></tr>';
    
  }
}

//Let Load Job History now
$resultJH = mysql_query("SELECT * FROM empjobhistory WHERE user_id ='".$uid."'");
//check if doc exist
 $NoRowJH = mysql_num_rows($resultJH);
 $RecordJH = "<tr><td colspan=5><center>No Record</center></td></tr>";
 $JHSN = 0;
 if ($NoRowJH > 0) {
  $RecordJH = "";
  while ($row = mysql_fetch_array($resultJH)) {
    $JHSN =  $JHSN + 1;
    $Name = $row{'CompanyName'};
    $YearFrom = $row{'YearFrom'};
    $YearTo = $row{'YearTo'};
    $JobDescription = $row{'JobDescription'};
    $JobTitle = $row{'JobTitle'};
    $RecordJH .= '<tr><td>'.$Name.'</td><td>'.$YearFrom.'</td><td>'.$YearTo.'</td><td>'.$JobTitle.'</td><td>'.$JobDescription.'</td></tr>';
    
  }
}

//Load Job Title
$JBTopt = "";
$JBTUt = mysql_query("SELECT * FROM jobtitle ORDER BY JobTitle");
$NoRowJBTUt = mysql_num_rows($JBTUt);

if ($NoRowJBTUt > 0) 
{
  while ($row = mysql_fetch_array($JBTUt)) {
    $jid = $row{'id'};
    $jbnu = $row['JobTitle'];
    if($jid == $JobT) { $JBTopt .= '<option value="'.$jid.'" selected >'.$jbnu.'</option>';}
    else {$JBTopt .= '<option value="'.$jid.'">'.$jbnu.'</option>';}
    
    }
} else { $JBTopt .= '<option value="" > No Job Title </option>'; }

//Load Job Position
$JBPopt = "";
$JBPUt = mysql_query("SELECT * FROM jobposition ORDER BY JobPosition");
$NoRowJBPUt = mysql_num_rows($JBPUt);

if ($NoRowJBPUt > 0) 
{
  while ($row = mysql_fetch_array($JBPUt)) {
    $jip = $row{'id'};
    $jbnp = $row['JobPosition'];
    if($jip == $JobP) { $JBPopt .= '<option value="'.$jip.'" selected >'.$jbnp.'</option>';}
    else {$JBPopt .= '<option value="'.$jip.'">'.$jbnp.'</option>';}
    }
} else { $JBPopt .= '<option value="" > No Job Position </option>'; }



//Load this staff Leave
$resultLeave = mysql_query("SELECT * FROM empleave WHERE uid = '".$uid."' AND isActive='1'");
//check if user exist
 $NoRow = mysql_num_rows($resultLeave);


if ($NoRow > 0) 
{
  //fetch tha data from the database
  while ($row = mysql_fetch_array($resultLeave)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     $reqid = $row['id'];
     $leaveType = $row['leaveType'];
     $leaveDaysApplied = $row['leaveDaysApplied'];
     $leaveDaysApproved = $row['leaveDaysApproved'];
     $NoOfDays = explode(",",$leaveDaysApproved);
     $Note = $row['Note'];
     $CreatedOn = $row['CreatedOn'];
     $ApprovedBy = $row['UHApprovedBy'];
     $ApprovedOn = $row['UHApprovedOn'];
     $Approved = $row['Status'];
      if ($Approved == 0) {
        $Approved = "No";
      }
      else if ($Approved == 1)
      {
        $Approved = "Yes";
      }
      else
      {
        $Approved = "Cancelled";
      }

 
    
      $RecordLeave .='
           <tr>
            <td>'.$CreatedOn.'</td>
            <td>'.$leaveType.'</td>
            <td>'.$Note.'</td>
            <td>'.$leaveDaysApplied.'</td>
            <td>'.count($NoOfDays).'</td>
            <td>'.$Approved.'</td>
           
           </tr>
           
           
           ';
            
     }
}


$result = mysql_query("SELECT * FROM emptravel WHERE uid = '".$uid."' AND isActive='1'");
//check if user exist
$NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
  //fetch tha data from the database
  while ($row = mysql_fetch_array($result)) {
     $reqid = $row['id'];
     $travelType = $row['travelType'];
     $travelDaysApplied = $row['travelDaysApplied'];
     $travelDaysApproved = $row['travelDaysApproved'];
     $NoOfDays = explode(",",$travelDaysApproved);
     $Note = $row['Note'];
     $Destination = $row['Destination'];
     $CreatedOn = $row['CreatedOn'];
     $ApprovedBy = $row['UHApprovedBy'];
     $ApprovedOn = $row['UHApprovedOn'];
     $Approved = $row['Status'];
      if ($Approved == 0) {
        $Approved = "No";
      }
      else if ($Approved == 1)
      {
        $Approved = "Yes";
      }
      else
      {
        $Approved = "Cancelled";
      }

 
    
      $RecordTravels .='
           <tr>
            <td>'.$CreatedOn.'</td>
            <td>'.$travelType.'</td>
            <td>'.$Note.'</td>
            <td>'.$Destination.'</td>
            <td>'.$travelDaysApplied.'</td>
            <td>'.count($NoOfDays).'</td>
            <td>'.$Approved.'</td>
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

    <link href="style.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">

        /* custom inclusion of right, left and below tabs */

        .tabs-below > .nav-tabs,
        .tabs-right > .nav-tabs,
        .tabs-left > .nav-tabs {
          border-bottom: 0;
        }

        .tab-content > .tab-pane,
        .pill-content > .pill-pane {
          display: none;
        }

        .tab-content > .active,
        .pill-content > .active {
          display: block;
        }

        .tabs-below > .nav-tabs {
          border-top: 1px solid #ddd;
        }

        .tabs-below > .nav-tabs > li {
          margin-top: -1px;
          margin-bottom: 0;
        }

        .tabs-below > .nav-tabs > li > a {
          -webkit-border-radius: 0 0 4px 4px;
             -moz-border-radius: 0 0 4px 4px;
                  border-radius: 0 0 4px 4px;
        }

        .tabs-below > .nav-tabs > li > a:hover,
        .tabs-below > .nav-tabs > li > a:focus {
          border-top-color: #ddd;
          border-bottom-color: transparent;
        }

        .tabs-below > .nav-tabs > .active > a,
        .tabs-below > .nav-tabs > .active > a:hover,
        .tabs-below > .nav-tabs > .active > a:focus {
          border-color: transparent #ddd #ddd #ddd;
        }

        .tabs-left > .nav-tabs > li,
        .tabs-right > .nav-tabs > li {
          float: none;
        }

        .tabs-left > .nav-tabs > li > a,
        .tabs-right > .nav-tabs > li > a {
          min-width: 74px;
          margin-right: 0;
          margin-bottom: 3px;
        }

        .tabs-left > .nav-tabs {
          float: left;
          margin-right: 19px;
          border-right: 1px solid #ddd;
        }

        .tabs-left > .nav-tabs > li > a {
          margin-right: -1px;
          -webkit-border-radius: 4px 0 0 4px;
             -moz-border-radius: 4px 0 0 4px;
                  border-radius: 4px 0 0 4px;
        }

        .tabs-left > .nav-tabs > li > a:hover,
        .tabs-left > .nav-tabs > li > a:focus {
          border-color: #eeeeee #dddddd #eeeeee #eeeeee;
        }

        .tabs-left > .nav-tabs .active > a,
        .tabs-left > .nav-tabs .active > a:hover,
        .tabs-left > .nav-tabs .active > a:focus {
          border-color: #ddd transparent #ddd #ddd;
          *border-right-color: #ffffff;
        }

        .tabs-right > .nav-tabs {
          float: right;
          margin-left: 19px;
          border-left: 1px solid #ddd;
        }

        .tabs-right > .nav-tabs > li > a {
          margin-left: -1px;
          -webkit-border-radius: 0 4px 4px 0;
             -moz-border-radius: 0 4px 4px 0;
                  border-radius: 0 4px 4px 0;
        }

        .tabs-right > .nav-tabs > li > a:hover,
        .tabs-right > .nav-tabs > li > a:focus {
          border-color: #eeeeee #eeeeee #eeeeee #dddddd;
        }

        .tabs-right > .nav-tabs .active > a,
        .tabs-right > .nav-tabs .active > a:hover,
        .tabs-right > .nav-tabs .active > a:focus {
          border-color: #ddd #ddd #ddd transparent;
          *border-left-color: #ffffff;
        }

    </style>
    <style type="text/css">
    .addbtn {
      color:blue; font-size:12px; font-weight:700; cursor: pointer; display: none;
    }
    .page-header {
  /*border-bottom: 1px solid #ddd;        
      margin: 20px 0 10px 0!important;
      position: relative;*/
      z-index: 1;
      font-size: 12px;
    } 
    </style>
    
  </head>
  <body class="skin-blue sidebar-collapse">
    <div class="wrapper">

            <?php include('../topmenu3.php') ?>
           <?php include('../leftmenu3.php') ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <h1>
            <?php echo $SurName . " " . $Firstname. "'s"; ?> Master Page
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="register"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Documentation</li>
          </ol>

        </div>
        

        
           

        <!-- Main content -->
        <div class="content body">
              <div style="background:#FFF; border-radius:20px;">
                <?php if ($G == "")
                         {} else {
              echo
              '<div class="">'.
              '<div class="alert alert-danger alert-dismissable">' .
                                                     '<i class="fa fa-info-circle"></i>' .
                                                      '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                                       '<center>'.  $G. '</center> '.
                                                  '</div></div>' ; 
                                $_SESSION['ErrMsg'] = "";}

               if ($B == "")
                         {} else {
              echo '<div class="">'.
              '<div class="alert alert-info alert-dismissable">' .
                                                     '<i class="fa fa-info-circle"></i>' .
                                                      '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                                      '<center>'.  $B. '</center> '.
                                                  '</div></div>' ; 
                                $_SESSION['ErrMsgB'] = "";}
              ?>
       

                <div class="row" style="margin:12px;">
                  
                  <div class="col-md-12"><h3><?php echo $SurName . " " . $Firstname. "'s"; ?> Details</h3>
                          
                    <!-- tabs left -->
                    <div class="tabbable tabs-left">
                      <ul class="nav nav-tabs">
                        <li class="active"><a href="#official" data-toggle="tab"><i class='fa fa-circle-o text-aqua'></i> Official</a></li>
                        <li><a href="#document" data-toggle="tab"><i class='fa fa-file text-success'></i> Documents</a></li>
                        <li><a href="#leaves" data-toggle="tab"><i class='fa fa-plane'></i> Leaves</a></li>
                        <li><a href="#travels" data-toggle="tab"><i class='fa fa-car'></i> Travels</a></li>
                          <li><a href="#salary" data-toggle="tab"><i class='fa fa-money'></i> Salary</a></li>
                          <li><a href="#contact" data-toggle="tab"><i class='fa fa-phone'></i> Contact</a></li>
                          <li><a href="#skills" data-toggle="tab"><i class='fa fa-circle-o'></i> Skills</a></li>
                          <li><a href="#payrollinfo" data-toggle="tab"><i class='fa fa-circle-o'></i> Payroll Info</a></li>
                          <li><a href="#payslips" data-toggle="tab"><i class='fa fa-circle-o'></i> Pay Slip</a></li>
                          <li><a href="#jobhistory" data-toggle="tab"><i class='fa fa-circle-o'></i> Job History</a></li>
                          <!--<li><a href="#experience" data-toggle="tab"><i class='fa fa-circle-o'></i> Experience</a></li>-->
                          <li><a href="#education" data-toggle="tab"><i class='fa fa-book text-success'></i> Education</a></li>
                          <li><a href="#trainings" data-toggle="tab"><i class='fa fa-circle-o'></i> Trainings & Certifications</a></li>
                          <li><a href="#medicals" data-toggle="tab"><i class='fa fa-ambulance text-warning'></i> Medical Claims</a></li>
                          <!--<li><a href="#disability" data-toggle="tab"><i class='fa fa-circle-o'></i> Disability</a></li>
                          <li><a href="#dependency" data-toggle="tab"><i class='fa fa-circle-o'></i> Dependency</a></li>-->
                          <!--<li><a href="#visa" data-toggle="tab"><i class='fa fa-circle-o'></i> Visa & Immigation</a></li>
                          <li><a href="#corporate" data-toggle="tab"><i class='fa fa-circle-o'></i> Corporate Card</a></li>
                          <li><a href="#eligibility" data-toggle="tab"><i class='fa fa-circle-o'></i> Work Eligibility</a></li>-->
                          <li><a href="#benefits" data-toggle="tab"><i class='fa fa-circle-o'></i> Benefits</a></li>
                      </ul>
                      <div class="tab-content">
                       <div class="tab-pane active" id="official">

                          <div class="col-md-7" style="background-color:#FBFBFB; border-radius: 25px;">
                            <form enctype="multipart/form-data" action="upstaffinfo" method="post" style="font-size:13px;">
                              <div class="form-group has-feedback col-md-4">
                                <input type="hidden" name="uid" value="<?php echo $uid; ?>" />
                              <label>First Name <span style="color:red">*<span></label>
                              <input type="text" class="form-control" id="Fname" name="Fname" placeholder="First name" value="<?php echo $Firstname; ?>" required />
                              </div>

                              <div class="form-group has-feedback col-md-4">
                                <input type="hidden" name="uid" value="<?php echo $uid; ?>" />
                              <label>Middle Name </label>
                              <input type="text" class="form-control" id="Mname" name="Mname" placeholder="Middle name" value="<?php echo $Middlename; ?>"  />
                              </div>


                              <div class="form-group has-feedback col-md-4">
                              <label>Last Name <span style="color:red">*<span></label>
                              <input type="text" class="form-control" id="Surname" name="Surname" placeholder="Surname" value="<?php echo $SurName; ?>" required />
                              </div>

                              <div class="form-group has-feedback col-md-4">
                              <label>Gender <span style="color:red">*<span></label>
                              <select class="form-control" id="Gender" name="Gender"placeholder="Gender" required>
                                <?php if($Gender != "") { echo '<option value="'.$Gender.'" selected>'.$Gender.'</option>'; } ?>
                              
                              <option value="Male"> Male</option>
                              <option value="Female"> Female</option>
                              </select>
                              </div>

                              <div class="form-group has-feedback col-md-4">
                              <label>Department </label>
                              <select class="form-control"  id="dept" name="dept" onchange="setBU(this)" >
                              <option value=""> -- </option>
                              <?php echo $DepUtOpt; ?>
                              </select>
                              </div>

                              <div class="form-group has-feedback col-md-4">
                              <label>Business Unit <span class="addbtn"> Add New </span></label>
                              <select class="form-control" id="BusUnt" name="BusUnt">
                              <option value=""> -- </option>
                              <?php echo $BusUtOpt; ?>
                              </select>
                              </div>

                             

                              <div class="form-group has-feedback col-md-4">
                              <label>Mode of Employment <span style="color:red">*<span></label>
                              <select class="form-control" id="MOE" name="MOE" required>
                              <option value=""> --</option>
                              <option value="Direct"> Direct</option>
                              <option value="Interview"> Interview</option>
                              <option value="Reference"> Reference</option>
                              <option value="Other"> Other</option>
                              </select>
                              </div>

                              <!-- Matte -->

                              <!--<div class="form-group has-feedback col-md-4">
                              <label>Job Title <span style="color:red">*<span> <span class="addbtn"> Add New </span></label>
                              <select class="form-control"  id="jbtitle" name="jbtitle" required>
                              <option value=""> -- </option>
                              <?php echo $JBTopt; ?>
                              </select>
                              </div>-->

                              <div class="form-group has-feedback col-md-4">
                              <label>Designation <span class="addbtn"> Add New </span></label>
                              <select class="form-control"  id="posti" name="posti" >
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
                              <input type="text" class="form-control" id="DOJ" name="DOJ" placeholder="Date of Joining" value="<?php echo $DoJ; ?>" readonly required />
                              </div>

                              <div class="form-group has-feedback col-md-4">
                              <label>Years of Experience <span style="color:red">*<span></label>
                              <input type="text" class="form-control" id="YOEx" name="YOEx" placeholder="Years of Experience" value="<?php echo $YoExp; ?>" required />
                              </div>

                             

                              <div class="form-group has-feedback col-md-4">
                              <label>Work Phone No. </label>
                              <input type="text" class="form-control" id="WkPhn" name="WkPhn" placeholder="Work Phone No." value="<?php echo $WorkPhone; ?>" />
                              </div>


                              <!-- Matte -->

                              <div class="form-group has-feedback col-md-4">
                              <label>Date of Birth <span style="color:red">*<span></label>
                              <input type="text" class="form-control" id="DOB" name="DOB" placeholder="Date of Birth" value="<?php echo $DoB; ?>" readonly required />
                              </div>

                               <div class="form-group has-feedback col-md-4">
                              <label>Extension </label>
                              <input type="text" class="form-control" id="WkEx" name="WkEx" value="<?php echo $WorkExt; ?>" placeholder="Extension" />
                              </div>

                              <div class="form-group has-feedback col-md-4">
                              <label>Staff ID <span style="color:red">*<span></label>
                              <input type="text" class="form-control" id="staffid" name="staffid" placeholder="Staff ID" value="<?php echo $StaffID; ?>" required />
                              </div>

                              <div class="form-group has-feedback col-md-4">
                              <label>Phone Number <span style="color:red">*<span></label>
                              <input type="text" class="form-control" id="staffphn" name="staffphn" placeholder="Staff Phone" value="<?php echo $Phone; ?>" required />
                              </div>

                              <div class="form-group has-feedback col-md-8">
                              <label>email <span style="color:red">*<span></label>
                              <input type="email" class="form-control" id="staffmail" name="staffmail" placeholder="Email" value="<?php echo $Email; ?>" required />
                              </div>

                              

                             
                              
                            </div> <!-- Col End -->
                            <div class="col-md-2">
                              <p class="text-center">
                              <strong>Staff Image</strong>
                              </p>
                              <center><?php echo '<img src="data:image/jpeg;base64,'. base64_encode($SPicture). '" id="uploadPreview" class="img-circle" style="width: 200px; height: 200px;" />'; ?></center>

                                <script type="text/javascript">

                                    function PreviewImage() {
                                        var oFReader = new FileReader();
                                        oFReader.readAsDataURL(document.getElementById("StaffPhoto").files[0]);

                                        oFReader.onload = function (oFREvent) {
                                            document.getElementById("uploadPreview").src = oFREvent.target.result;
                                        };
                                    };

                                </script>
                                 <br/>
                                <div class="form-group has-feedback">
                                  <input type="file" id="StaffPhoto" name="StaffPhoto" accept="image/jpg" class="form-control" onchange="PreviewImage();" placeholder="Passport" />
                                  <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                                </div> 
                                <div class="row">
                                <div class="col-xs-12">
                                  <button type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
                                </div><!-- /.col -->
                                </div><!-- /.row -->
                              </form>
                            </div>



                      </div>
                       <div class="tab-pane" id="document">
                        
                        <div class="row">
                          <div class="rwow">
                          <a onclick="addDoc('<?php echo $uid; ?>')" href="javascript::;" class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-plus"></i> &nbsp; Add</a>
                          </div>
                          <div class="table-responsive">
                              <table id="schdTab" class="table table-bordered table-striped">
                                <thead>
                                        <tr>
                                        <th>S/N</th>
                                        <th>Doc No.</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Link</th>
                                        </tr>
                                </thead>
                                <tbody>
                                       
                                    <?php echo $DocRec; ?>
                                </tbody>
                                   
                                </table>
                   
                          </div><!-- /.table-responsive -->
                        </div>
                       </div>
                       <div class="tab-pane" id="leaves">
                        <div class="row"> 
                            <div class="table-responsive">
                                    <table id="userTab" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>Applied on</th>
                                          <th>Leave Type</th>
                                          <th>Purpose</th>
                                          <th>Days</th>
                                          <th>No. of Days</th>
                                          <th>Approved</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php echo $RecordLeave; ?>
                                      </tbody>
                                    </table>
                            </div>
                        </div>
                       </div>
                       <div class="tab-pane" id="travels">
                        <div class="row"> 
                            <div class="table-responsive">
                                    <table id="userTabTravel" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>Applied on</th>
                                          <th>Travel Type</th>
                                          <th>Purpose</th>
                                          <th>Destination</th>
                                          <th>Days</th>
                                          <th>No. of Days</th>
                                          <th>Approved</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php echo $RecordTravels; ?>
                                      </tbody>
                                    </table>
                            </div>
                        </div>
                       </div>
                       <div class="tab-pane" id="skills">
                        <div class="row"> 
                           <div class="rwow">
                          <a onclick="addSkill('<?php echo $uid; ?>')" href="javascript::;" class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-plus"></i> &nbsp; Add New Skill</a>
                          </div>
                            <div class="table-responsive">
                                    <table id="userTab" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>Skill</th>
                                          <th>Obtained On</th>
                                          <th>Obtained from</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php echo $RecordSkills; ?>
                                      </tbody>
                                     
                                    </table>
                            </div>
                        </div>

                       </div>
                       <div class="tab-pane" id="salary">
                        <div class="row"> 
                            <div class="table-responsive">
                                    <table id="userTab" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>Paid On</th>
                                          <th>Basic Salary</th>
                                          <th>Income Tax</th>
                                          <th>Bonus</th>
                                          <th>Tax ID No.</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php echo $RecordSalary; ?>
                                      </tbody>
                                     
                                    </table>
                            </div>
                        </div>

                       </div>
                       <div class="tab-pane" id="contact">
                        <div class="row"> 
                          <div class="rwow">
                          <a onclick="addContact('<?php echo $uid; ?>')" href="javascript::;" class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-plus"></i> &nbsp; Add Contact</a>
                          </div>
                            <div class="table-responsive">
                                    <table id="userTabContact" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>Contact Full Name</th>
                                          <th>Relationship</th>
                                          <th>Residential Address</th>
                                          <th>Phone No.</th>
                                          <th>L.G.A</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php echo $RecordContact; ?>
                                      </tbody>
                                     
                                    </table>
                            </div>
                        </div>

                       </div>
                        <div class="tab-pane" id="jobhistory">
                        <div class="row"> 
                          <div class="rwow">
                          <a onclick="addJobH('<?php echo $uid; ?>')" href="javascript::;" class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-plus"></i> &nbsp; Add Job History</a>
                          </div>
                            <div class="table-responsive">
                                    <table id="userTabJobH" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>Company Name</th>
                                          <th>From (Year)</th>
                                          <th>To (Year)</th>
                                          <th>Job Title</th>
                                          <th>Job Description</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php echo $RecordJH; ?>
                                      </tbody>
                                     
                                    </table>
                            </div>
                        </div>

                       </div>

                        <div class="tab-pane" id="education">
                        <div class="row"> 
                          <div class="rwow">
                          <a onclick="addEdu('<?php echo $uid; ?>')" href="javascript::;" class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-plus"></i> &nbsp; Add Education</a>
                          </div>
                            <div class="table-responsive">
                                    <table id="userTabEdu" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>Institution</th>
                                          <th>From (Year)</th>
                                          <th>To (Year)</th>
                                          <th>Certificate Obtained</th>
                                          <th>Attached Certificate</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php echo $EduRec; ?>
                                      </tbody>
                                     
                                    </table>
                            </div>
                        </div>
                       </div>
                      <div class="tab-pane" id="trainings">
                        <div class="row"> 
                          <div class="rwow">
                          <a onclick="addTrain('<?php echo $uid; ?>')" href="javascript::;" class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-plus"></i> &nbsp; Add Trainings/Cert.</a>
                          </div>
                            <div class="table-responsive">
                                    <table id="userTabTrain" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>Institution</th>
                                          <th>From (Year)</th>
                                          <th>To (Year)</th>
                                          <th>Certificate Obtained</th>
                                          <th>Attached Certificate</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php echo $RecordTrain; ?>
                                      </tbody>
                                     
                                    </table>
                            </div>
                        </div>
                       </div>

                       <div class="tab-pane" id="medicals">
                        <div class="row"> 
                          <div class="rwow">
                          <a onclick="addMedi('<?php echo $uid; ?>')" href="javascript::;" class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-plus"></i> &nbsp; Add Medi. Claims</a>
                          </div>
                            <div class="table-responsive">
                                    <table id="userTabMedi" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>Type</th>
                                          <th>Ailment</th>
                                          <th>Diagnosed On</th>
                                          <th>Present Condition</th>
                                          <th>Supporting Doc.</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php echo $RecordMedi; ?>
                                      </tbody>
                                     
                                    </table>
                            </div>
                        </div>
                       </div>
                    <div class="tab-pane" id="payrollinfo" style="font-size:12px;">
                           <div class="row">
                               <form>
                                  <div class="col-md-6">
                                          <div class="form-group col-md-4">
                                            <label>National Housing Fund (NHF)</label>
                                          <input type="text" class="form-control" name="NHFNo" id="NHFNo" placeholder="NHF No.">
                                          </div>
                                          <div class="form-group col-md-4">
                                            <label>Health Insurance Number</label>
                                          <input type="text" class="form-control" name="HISNNo" id="HISNNo" placeholder="Health Insurance No.">
                                          </div>
                                          <div class="form-group col-md-4">
                                            <label>Pensions Fund Number</label>
                                          <input type="text" class="form-control" name="PFNNo" id="PFNNo" placeholder="Pensions Fund Number">
                                          </div>
                                  </div>
                                   <div class="col-md-6">
                                          <div class="form-group col-md-6">
                                            <label>State Internal Revenue Service</label>
                                            <select class="form-control" name="IRSNo" id="IRSNo">
                                            <option value="Lagos State">Lagos State</option>
                                            <option value="Rivers State">Rivers State</option>
                                            </select>
                                          </div>
                                          <div class="form-group col-md-6">
                                            <label>Tax Office</label>
                                             <select class="form-control" name="TaxOffice" id="TaxOffice">
                                              <option value="Lagos State">Lagos State</option>
                                              <option value="Rivers State">Rivers State</option>
                                             </select>
                                          </div>
                                          <div class="form-group col-md-6">
                                            <label>Health Management Organisation</label>
                                            <select class="form-control" name="TaxOffice" id="TaxOffice">
                                              <option value="Mansxad">Mansxad</option>
                                              <option value="PHB">PHB</option>
                                             </select>
                                          </div>
                                           <div class="form-group col-md-6">
                                            <label>Pensions Fund Administrator</label>
                                            <select class="form-control" name="TaxOffice" id="TaxOffice">
                                              <option value="Crusade">Crusade</option>
                                              <option value="Sterling">Sterling</option>
                                             </select>
                                          </div>
                                           
                                          <div class="form-group col-md-6 pull-right">
                                           <button class="btn btn-success pull-right">Update</button>
                                          </div>

                                  </div>
                               </form>
                            </div>
                        </div>
                        
                         <div class="tab-pane" id="payslips">
                        <div class="row"> 
                          <div class="rwow">
                          </div>
                            <div class="table-responsive">
                                    <table id="userTabMedi" class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>PayslipID</th>
                                          <th>Date Paid</th>
                                          <th>Amount Paid</th>
                                          <th>Outstanding</th>
                                          <th>View</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php echo $RecordMedi; ?>
                                      </tbody>
                                     
                                    </table>
                            </div>
                        </div>
                       </div>

                      </div>
                    </div>
                    <!-- /tabs -->
                    
                  </div>
                 
                </div><!-- /row -->
              </div>


            <script type="text/javascript">
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

      function addDoc(uid)
        {
            var title = 'Attach Document';
            var size='large';
            var content = '<form enctype="multipart/form-data" role="form" method="post" action="addDoc"><div class="form-group">' +

          '<div class="form-group has-feedback">' +
            '<label>Document Title</label>' +
          '<input type="text" class="form-control" id="DTitle" name="DTitle" value="" required />' +
          '</div>'+
          '<div class="form-group has-feedback">' +
            '<label>Document Description</label>' +
          '<input type="text" class="form-control" id="DDesc" name="DDesc" value="" required />' +
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>The Document</label>' +
          '<input type="file" class="form-control" id="Doc" name="Doc" required />' +
          '<input type="hidden" name="uid" class="form-control" id="uid" value="'+uid+'" />' +
          '</div>'+
          '<button type="submit" style="margin:12px;" class="btn btn-primary pull-right">Attach</button></form><br/>';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
    
        }

        function addContact(uid){
          var title = 'Add New Contact';
            var size='large';
            var content = '<form enctype="multipart/form-data" role="form" method="post" action="addContact"><div class="form-group">' +

          '<div class="form-group has-feedback">' +
            '<label>Contact Full Name</label>' +
          '<input type="text" class="form-control" id="cName" name="cName" value="" required />' +
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Contact Relationship</label>' +
          '<input type="text" class="form-control" id="CRelationShip" name="CRelationShip" value="" required />' +
          '</div>'+
          '<div class="form-group has-feedback">' +
            '<label>Contact Address</label>' +
          '<input type="text" class="form-control" id="CAddress" name="CAddress" value="" required />' +
          '</div>'+
         '<div class="form-group has-feedback">' +
            '<label>Contact Phone No.</label>' +
          '<input type="text" class="form-control" id="CPhone" name="CPhone" value="" required />' +
          '</div>'+
          '<div class="form-group has-feedback">' +
            '<label>Contact L.G.A</label>' +
          '<input type="text" class="form-control" id="CLGA" name="CLGA" value="" required />' +
          '</div>'+
          '<input type="hidden" name="uid" class="form-control" id="uid" value="'+uid+'" />' +
          '<button type="submit" style="margin:12px;" class="btn btn-primary pull-right">Add</button></form><br/>';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
    

        }

          function addSkill(uid){
          var title = 'Add New Skill';
            var size='large';
            var content = '<form enctype="multipart/form-data" role="form" method="post" action="addSkill"><div class="form-group">' +

          '<div class="form-group has-feedback">' +
            '<label>Skill</label>' +
          '<input type="text" class="form-control" id="sSkill" name="sSkill" value="" required />' +
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Obtained On</label>' +
          '<input type="text" class="form-control" id="sObtOn" name="sObtOn" value="" required />' +
          '</div>'+
          '<div class="form-group has-feedback">' +
            '<label>Obtained From</label>' +
          '<input type="text" class="form-control" id="sObtFrom" name="sObtFrom" value="" required />' +
          '</div>'+
          '<input type="hidden" name="uid" class="form-control" id="uid" value="'+uid+'" />' +
          '<button type="submit" style="margin:12px;" class="btn btn-primary pull-right">Add</button></form><br/>';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
        }

         function addJobH(uid){
          var title = 'Add New Job History';
            var size='large';
            var content = '<form enctype="multipart/form-data" role="form" method="post" action="addJobH"><div class="form-group">' +

          '<div class="form-group has-feedback">' +
            '<label>Name of Company</label>' +
          '<input type="text" class="form-control" id="jhCompanyName" name="jhCompanyName" value="" required />' +
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Year You Joined</label>' +
          '<input type="text" class="form-control" id="jhYearFrom" name="jhYearFrom" value="" required />' +
          '</div>'+
          '<div class="form-group has-feedback">' +
            '<label>Year You Left</label>' +
          '<input type="text" class="form-control" id="jhYearTo" name="jhYearTo" value="" required />' +
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Job Title</label>' +
          '<input type="text" class="form-control" id="jhTitle" name="jhTitle" value="" required />' +
          '</div>'+
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Job Description</label>' +
          '<input type="text" class="form-control" id="jhDescription" name="jhDescription" value="" required />' +
          '</div>'+
          '<input type="hidden" name="uid" class="form-control" id="uid" value="'+uid+'" />' +
          '<button type="submit" style="margin:12px;" class="btn btn-primary pull-right">Add</button></form><br/>';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
        }

        function addEdu(uid){
          var title = 'Add New Education Info.';
            var size='large';
            var content = '<form enctype="multipart/form-data" role="form" method="post" action="addEdu"><div class="form-group">' +

          '<div class="form-group has-feedback">' +
            '<label>Name of Institute</label>' +
          '<input type="text" class="form-control" id="eduInstitue" name="eduInstitue" value="" required />' +
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Year You Started</label>' +
          '<input type="text" class="form-control" id="eduYearFrom" name="eduYearFrom" value="" required />' +
          '</div>'+
          '<div class="form-group has-feedback">' +
            '<label>Year You Finished</label>' +
          '<input type="text" class="form-control" id="eduYearTo" name="eduYearTo" value="" required />' +
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Certificate Obtained</label>' +
          '<input type="text" class="form-control" id="eduTitle" name="eduTitle" value="" required />' +
          '</div>'+
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Attach Certificate</label>' +
          '<input type="file" class="form-control" id="eduCert" name="eduCert" required />' +
          '<input type="hidden" name="uid" class="form-control" id="uid" value="'+uid+'" />' +
          '</div>'+
          '<button type="submit" style="margin:12px;" class="btn btn-primary pull-right">Add</button></form><br/>';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
        }


        function addTrain(uid){
          var title = 'Add New Training/Certification.';
            var size='large';
            var content = '<form enctype="multipart/form-data" role="form" method="post" action="addTrain"><div class="form-group">' +

          '<div class="form-group has-feedback">' +
            '<label>Name of Institute</label>' +
          '<input type="text" class="form-control" id="eduInstitue" name="eduInstitue" value="" required />' +
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Year You Started</label>' +
          '<input type="text" class="form-control" id="eduYearFrom" name="eduYearFrom" value="" required />' +
          '</div>'+
          '<div class="form-group has-feedback">' +
            '<label>Year You Finished</label>' +
          '<input type="text" class="form-control" id="eduYearTo" name="eduYearTo" value="" required />' +
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Certificate Obtained</label>' +
          '<input type="text" class="form-control" id="eduTitle" name="eduTitle" value="" required />' +
          '</div>'+
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Attach Certificate</label>' +
          '<input type="file" class="form-control" id="eduCert" name="eduCert" required />' +
          '<input type="hidden" name="uid" class="form-control" id="uid" value="'+uid+'" />' +
          '</div>'+
          '<button type="submit" style="margin:12px;" class="btn btn-primary pull-right">Add</button></form><br/>';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
        }

        function addMedi(uid){
          var title = 'Add New Medical Claims';
            var size='large';
            var content = '<form enctype="multipart/form-data" role="form" method="post" action="addMedi"><div class="form-group">' +

          '<div class="form-group has-feedback">' +
            '<label>Ailment Type</label>' +
          '<input type="text" class="form-control" id="ailmentType" name="ailmentType" value="" placeholder="Allergy, Infection or Disorder" required />' +
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Ailment Name</label>' +
          '<input type="text" class="form-control" id="ailmentName" name="ailmentName" value="" required />' +
          '</div>'+
          '<div class="form-group has-feedback">' +
            '<label>Diagnosed On</label>' +
          '<input type="text" class="form-control" id="DiagnosedOn" name="DiagnosedOn" value="" required />' +
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Present Condition</label>' +
          '<input type="text" class="form-control" id="PresentCond" name="PresentCond" value="" required />' +
          '</div>'+
          '</div>'+
           '<div class="form-group has-feedback">' +
            '<label>Supporting Document</label>' +
          '<input type="file" class="form-control" id="mediDoc" name="mediDoc" required />' +
          '<input type="hidden" name="uid" class="form-control" id="uid" value="'+uid+'" />' +
          '</div>'+
          '<button type="submit" style="margin:12px;" class="btn btn-primary pull-right">Add</button></form><br/>';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
        }
          function setModalBox(title,content,footer,$size)
          {
            document.getElementById('modal-bodyku').innerHTML=content;
            document.getElementById('myModalLabel').innerHTML=title;
            document.getElementById('modal-footerq').innerHTML=footer;
           
            if($size == 'large')
            {
                $('#myModal').attr('class', 'modal fade bs-example-modal-lg')
                             .attr('aria-labelledby','myLargeModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-lg');
            }
            if($size == 'standart')
            {
                $('#myModal').attr('class', 'modal fade')
                             .attr('aria-labelledby','myModalLabel');
                $('.modal-dialog').attr('class','modal-dialog');
            }
            if($size == 'small')
            {
                $('#myModal').attr('class', 'modal fade bs-example-modal-sm')
                             .attr('aria-labelledby','mySmallModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-sm');
            }
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

        </div><!-- /.content -->
      </div><!-- /.content-wrapper -->

        <?php include('../footer.php'); ?>

      

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='../plugins/fastclick/fastclick.min.js'></script>    
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="../mBOOT/jquery-ui.js"></script>
    <!--<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>-->
    <script src="docs.js"></script>
    <script type="text/javascript">
      //$(document).ready(function() { 
        //var modemp = '<?php echo $ModeOfEmp; ?>';
        //$("#MOE").val(modemp); 

      //});
      $(document).ready(function() {
        var modemp = '<?php echo $ModeOfEmp; ?>';
        $("#MOE").val(modemp); 

        var empsta = '<?php echo $EmployeeStatus; ?>';
        $("#empsta").val(empsta); 
        //alert(empsta);
        
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
      yearRange: "1999:2029"

      });
     
       
      });

      
    </script>
  

  </body>
</html>
