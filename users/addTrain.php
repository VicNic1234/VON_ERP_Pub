<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
include ('imagerzer.php');
//select a database to work with
$uid = trim(strip_tags($_POST['uid']));
$eduInstitue = trim(strip_tags($_POST['eduInstitue']));
$eduYearFrom = trim(strip_tags($_POST['eduYearFrom']));
$eduYearTo = trim(strip_tags($_POST['eduYearTo']));
$eduTitle = trim(strip_tags($_POST['eduTitle']));
//$eduCert = trim(strip_tags($_POST['eduCert']));
$CreatedBy = $_SESSION['uid'];
  
if (isset($_FILES['eduCert']) && $_FILES['eduCert']['size'] > 0) 
{ 
  $tmpName  = $_FILES['eduCert']['tmp_name']; 
  $DocName = $_FILES['eduCert']['name'];
$ext = pathinfo($DocName, PATHINFO_EXTENSION);
  // Load the original image
//$image = new SimpleImage($tmpName);
// Create a squared version of the image
//$image->square(100);
//$image->resizeToWidth(400);
$doclink = 'empdoc/'.$eduTitle.' '.$uid.'.'.$ext;
move_uploaded_file($tmpName,$doclink);
//$image->save('empdoc/'.$imgName);
//$data=addslashes(file_get_contents('popimg/'.$imgName));
$queryNewEdu = "INSERT INTO emptrainncert (user_id, eduInstitue, eduYearFrom, eduYearTo, eduTitle, eduCert, createdby, isactive) 
VALUES ('$uid','$eduInstitue','$eduYearFrom','$eduYearTo','$eduTitle','$doclink','$CreatedBy','1');";

    
     
     if(mysql_query($queryNewEdu)) 
     {
        $_SESSION['ErrMsgB'] = "Training/Cert. info. have been added!";
        header('Location: employee?dc='.$uid);
      }
 
      else
      {
        $_SESSION['ErrMsg'] = mysql_error();//"Opps! Data Pool error, tryagain";
        header('Location: employee?dc='.$uid);

      }

}
else
{
  $_SESSION['ErrMsg'] = "No Document to attach, tryagain";
  header('Location: employee?dc='.$uid);
}






?>