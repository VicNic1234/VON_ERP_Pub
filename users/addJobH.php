<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
include ('imagerzer.php');
//select a database to work with
$uid = trim(strip_tags($_POST['uid']));
$jhCompanyName = trim(strip_tags($_POST['jhCompanyName']));
$jhYearFrom = trim(strip_tags($_POST['jhYearFrom']));
$jhYearTo = trim(strip_tags($_POST['jhYearTo']));
$jhTitle = trim(strip_tags($_POST['jhTitle']));
$jhDescription = trim(strip_tags($_POST['jhDescription']));

$CreatedBy = $_SESSION['uid'];
  

$queryNewSkill = "INSERT INTO empjobhistory (user_id, CompanyName, YearFrom, YearTo, JobTitle, JobDescription,  CreatedBy) 
VALUES ('$uid','$jhCompanyName','$jhYearFrom','$jhYearTo','$jhTitle','$jhDescription', '$CreatedBy');";

    //$regr = ;
     
     if(mysql_query($queryNewSkill)) 
     {
        $_SESSION['ErrMsgB'] = "Job History have been added!";
        //header('Location: employee?dc='.$uid);
      }
 
      else
      {
        $_SESSION['ErrMsg'] = mysql_error();//"Opps! Data Pool error, tryagain";
        //header('Location: employee?dc='.$uid);

      }

      $indiv = trim(strip_tags($_POST['indiv']));

      if($indiv == "YES")
      {
        header('Location: mydetails');
      }
      else
      {
        header('Location: employee?dc='.$uid);
      }








?>