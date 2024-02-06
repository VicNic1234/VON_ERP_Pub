<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
include ('imagerzer.php');
//select a database to work with
$uid = trim(strip_tags($_POST['uid']));
$sSkill = trim(strip_tags($_POST['sSkill']));
$sObtOn = trim(strip_tags($_POST['sObtOn']));
$sObtFrom = trim(strip_tags($_POST['sObtFrom']));

$CreatedBy = $_SESSION['uid'];
  

$queryNewSkill = "INSERT INTO empskills (user_id, Skill, ObtainedFrm, ObtainedOn,  CreatedBy) 
VALUES ('$uid','$sSkill','$sObtFrom','$sObtOn', '$CreatedBy');";

    //$regr = ;
     
     if(mysql_query($queryNewSkill)) 
     {
        $_SESSION['ErrMsgB'] = "Skill have been added!";
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