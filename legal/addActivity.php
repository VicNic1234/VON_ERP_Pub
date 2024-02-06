<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

   $conID = trim(strip_tags($_POST['conID']));
  $ActTitle = trim(strip_tags($_POST['ActTitle']));
  $ActDescr = trim(strip_tags($_POST['ActDescr']));
   $DocLink = trim(strip_tags($_POST['DocLink'])); 
  //$DocFile = trim(strip_tags($_POST['DocFile']));
 

  $Today = date('Y/m/d h:i:s a'); 
 
  
if (isset($_FILES['DocFile']) && $_FILES['DocFile']['size'] > 0) 
{ 
  $sizemdia = $_FILES['DocFile']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  header('Location: viewsubj?cnid='.$conID);
  exit;
  }
}
else
{
  //Check if file link it there
  if($DocLink == "")
  {
    /*$_SESSION['ErrMsg'] = "<strong style='color:red;'>Either you attach a file or set the link to the file thanks!</strong>";
    header('Location: viewsubj?cnid='.$conID);
    exit;*/
  }
}
////////////////////////////////////////////////////////
if(isset($_FILES['DocFile']) && $_FILES['DocFile']['size'] > 0)
{
//Let's set new Name for file
 $ftmpName  = $_FILES['DocFile']['tmp_name']; 
     $fimgName = $_FILES['DocFile']['name'];

        send1:    
        $FILEID = date('Ymd_his');
       $ext = pathinfo($fimgName, PATHINFO_EXTENSION); 
       // $temp = explode(".", $_FILES["file"]["name"]);
        //$newfilename = round(microtime(true)) . '.' . end($temp);
         if (file_exists("../CONAttach/" . $FILEID .".". $ext )) { goto send1; } else
            {
              $FILEURL = "../CONAttach/" . $FILEID .".". $ext;
            }
        
         

/////////////////////////////////////////////////////////////
//Here we need to send details to Contract Table
        if (isset($_FILES['DocFile']) && $_FILES['DocFile']['size'] > 0) 
        { 
          move_uploaded_file($ftmpName, $FILEURL);
          
        }
        else
        {
          $FILEURL = "";
        }

        $DocLink = $FILEURL; 
       


}

//echo $DocLink; exit;
if($DocLink == ""){
	$query1 = "INSERT INTO legalactivities (subid, title, description, CreatedBy, CreatedOn, Type) 
	VALUES ('".$conID."','".$ActTitle."','".$ActDescr."','".$UID."','".$Today."', 'Subject');";
}
else{
  $query1 = "INSERT INTO legalactivities (subid, title, description, CreatedBy, CreatedOn, FileLink, Type) 
  VALUES ('".$conID."','".$ActTitle."','".$ActDescr."','".$UID."','".$Today."','".$DocLink."', 'Subject');";
}
if(mysql_query($query1, $dbhandle))
{
   
  	$_SESSION['ErrMsgB'] = "Activity is Added";
  header('Location: viewsubj?cnid='.$conID);

mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not add Activity ";
  header('Location: viewsubj?cnid='.$conID);

//close the connection
mysql_close($dbhandle);
}



?>