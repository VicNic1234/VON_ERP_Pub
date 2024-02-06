<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

   $conID = trim(strip_tags($_POST['conID']));
  $DocTitle = trim(strip_tags($_POST['DocTitle']));
  $DocDescr = trim(strip_tags($_POST['DocDescr']));
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
  header('Location: viewproj?cnid='.$conID);
  exit;
  }
}
else
{
  //Check if file link it there
  if($DocLink == "")
  {
    $_SESSION['ErrMsg'] = "<strong style='color:red;'>Either you attach a file or set the link to the file thanks!</strong>";
    header('Location: viewproj?cnid='.$conID);
    exit;
  }
}
////////////////////////////////////////////////////////
if($DocLink == "")
{
//Let's set new Name for file
 $ftmpName  = $_FILES['DocFile']['tmp_name']; 
     $fimgName = $_FILES['DocFile']['name'];

        send1:    
        $FILEID = date('Ymd_his');
       $ext = pathinfo($fimgName, PATHINFO_EXTENSION); 
       // $temp = explode(".", $_FILES["file"]["name"]);
        //$newfilename = round(microtime(true)) . '.' . end($temp);
         if (file_exists("../PROJECTAttach/" . $FILEID .".". $ext )) { goto send1; } else
            {
              $FILEURL = "../PROJECTAttach/" . $FILEID .".". $ext;
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
	$query1 = "INSERT INTO supportingdoc (link, description, title, addedby, addedon, module, docid) 
	VALUES ('".$DocLink."','".$DocDescr."','".$DocTitle."','".$UID."','".$Today."','PROJECT','".$conID."');";

if(mysql_query($query1, $dbhandle))
{
   
  	$_SESSION['ErrMsgB'] = "Document is Added";
  header('Location: viewproj?cnid='.$conID);

mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not add Document ";
  header('Location: viewproj?cnid='.$conID);

//close the connection
mysql_close($dbhandle);
}



?>