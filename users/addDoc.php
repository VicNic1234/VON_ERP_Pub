<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
include ('imagerzer.php');
//select a database to work with
$uid = trim(strip_tags($_POST['uid']));
$DDesc = trim(strip_tags($_POST['DDesc']));
$DTitle = trim(strip_tags($_POST['DTitle']));
$CreatedBy = $_SESSION['uid'];
  
if (isset($_FILES['Doc']) && $_FILES['Doc']['size'] > 0) 
{ 
  $tmpName  = $_FILES['Doc']['tmp_name']; 
  $DocName = $_FILES['Doc']['name'];
$ext = pathinfo($DocName, PATHINFO_EXTENSION);
  // Load the original image
//$image = new SimpleImage($tmpName);
// Create a squared version of the image
//$image->square(100);
//$image->resizeToWidth(400);
$doclink = 'empdoc/'.$DTitle.'.'.$ext;
move_uploaded_file($tmpName,$doclink);
//$image->save('empdoc/'.$imgName);
//$data=addslashes(file_get_contents('popimg/'.$imgName));
$queryNewDOC = "INSERT INTO empdocuments (user_id, name, description, attachments, createdby, isactive) 
VALUES ('$uid','$DTitle','$DDesc','$doclink','$CreatedBy','1');";

         
     if(mysql_query($queryNewDOC)) 
     {
        $_SESSION['ErrMsgB'] = "Document is attached!";
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

}
else
{
  $_SESSION['ErrMsg'] = "No Document to attach, tryagain";
  header('Location: employee?dc='.$uid);
}






?>