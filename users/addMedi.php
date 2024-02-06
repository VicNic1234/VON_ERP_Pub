<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
include ('imagerzer.php');
//select a database to work with
$uid = trim(strip_tags($_POST['uid']));
$ailmentType = trim(strip_tags($_POST['ailmentType']));
$ailmentName = trim(strip_tags($_POST['ailmentName']));
$DiagnosedOn = trim(strip_tags($_POST['DiagnosedOn']));
$PresentCond = trim(strip_tags($_POST['PresentCond']));
//$mediDoc = trim(strip_tags($_POST['mediDoc']));
$CreatedBy = $_SESSION['uid'];
  
if (isset($_FILES['mediDoc']) && $_FILES['mediDoc']['size'] > 0) 
{ 
  $tmpName  = $_FILES['mediDoc']['tmp_name']; 
  $DocName = $_FILES['mediDoc']['name'];
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
$queryNewMedi = "INSERT INTO empmedi (user_id, ailmentType, ailmentName, DiagnosedOn, PresentCond, mediDoc, createdby, isactive) 
VALUES ('$uid','$ailmentType','$ailmentName','$DiagnosedOn','$PresentCond','$doclink','$CreatedBy','1');";

    
     
     if(mysql_query($queryNewMedi)) 
     {
        $_SESSION['ErrMsgB'] = "Medical info. have been added!";
      }
 
      else
      {
        $_SESSION['ErrMsg'] = mysql_error();//"Opps! Data Pool error, tryagain";

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

}
else
{
  $_SESSION['ErrMsg'] = "No Document to attach, tryagain";
  header('Location: employee?dc='.$uid);
}






?>