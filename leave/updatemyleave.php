<?php
session_start();
error_reporting(0);
/*ini_set ('display_errors', 1);  
ini_set ('display_startup_errors', 1);  
error_reporting (E_ALL);  */
include ('../DBcon/db_config.php');
include ('../utility/notify.php');


$StaffID = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];


if($StaffID == "")
{
  echo "Kindly logout and login";
  header("Location: ../login");
  exit;
}

//Compute Number of Days
$start = new DateTime($_POST['StartDay']);
$end = new DateTime($_POST['EndDay']);
// otherwise the  end date is excluded (bug?)
$end->modify('+1 day');

$interval = $end->diff($start);

// total days
$days = $interval->days;

// create an iterateable period of date (P1D equates to 1 day)
$period = new DatePeriod($start, new DateInterval('P1D'), $end);
$leaveDaysApplied = '';
// best stored as array, so you can add more than one
$holidays = array('2018-01-20');

foreach($period as $dt) {
    $curr = $dt->format('D');

    // substract if Saturday or Sunday
    if ($curr == 'Sat' || $curr == 'Sun') {
        $days--;
    }


    // (optional) for the updated question
    elseif (in_array($dt->format('Y-m-d'), $holidays)) {
        $days--;
    }

    //
    else
    {
      $leaveDaysApplied .= $dt->format('Y-m-d') .",";
    }
}


$days; // 4
$LID =  mysql_real_escape_string(trim(strip_tags($_POST['LID'])));
//exit;
//////////////////////////////////////

//if($_POST['leaveapply'])
{
   // $sid = mysql_real_escape_string(trim(strip_tags($_POST['leaveapply'])));
    $LeavePurpose = mysql_real_escape_string(trim(strip_tags($_POST['LeavePurpose'])));
    $LeaveType = mysql_real_escape_string(trim(strip_tags($_POST['LeaveType'])));
   // $LeaveDays = mysql_real_escape_string(trim(strip_tags($_POST['LeaveDays'])));
    $StartDay = mysql_real_escape_string(trim(($_POST['StartDay'])));
    $EndDay = mysql_real_escape_string(trim(($_POST['EndDay'])));
//exit;
    if($LeavePurpose == "" || $LeaveType == "" || $StartDay == "" || $EndDay == "")
    {
   echo $G = "Form must be completely filled. Thanks!";

    }
    else
    {
  // echo $leaveDaysApplied; exit;  
//echo $LID; exit;
    $queryNewLeave = "UPDATE empleave SET leaveType='".$LeaveType."', NumberofDays='$days', leaveDaysApplied='".$leaveDaysApplied."', StartDate='$StartDay', EndDate='$EndDay', Note='$LeavePurpose', isActive=1 WHERE id = '".$LID."'";
       mysql_query($queryNewLeave);
        header("Location: myleave");
         $B = "Your Request have been updated!";
           $_SESSION['ErrMsgB'] = $B;
        
/*
        if(mysql_query("UPDATE empleave SET leaveType='".$LeaveType."', StartDate='".$StartDay."', EndDate='".$EndDay."', NumberofDays='$days', Note='$LeavePurpose', 
        leaveDaysApplied='".$leaveDaysApplied."' 
       WHERE id='".$LID."'"))
        {
          $B = "Your Request have been updated!";
           $_SESSION['ErrMsgB'] = $B;//"Oops! Timed Out. Kindly Logout and Login Thanks";
            //echo mysql_error();
          header("Location: myleave");

        }
        else
        {
          $G = "Oops! an error occured. Try again";
          $_SESSION['ErrMsg'] = $G;
          echo mysql_error();
        exit;
        header("Location: myleave");
        }
        */
        //notify_hr_leave($sid, $LeaveType, $LeaveDays, $LeavePurpose);
    
    }


   

}



?>