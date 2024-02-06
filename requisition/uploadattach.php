<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:s a");
$UID = $_SESSION['uid'];
$RESDetails = array();
$title= mysql_real_escape_string($_POST['title']);
$reqid= mysql_real_escape_string($_POST['reqid']);

if (isset($_FILES['filed']) && $_FILES['filed']['size'] > 0) 
{ 
  $sizemdia = $_FILES['filed']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $RESDetails['MSG'] = "YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!";
          $RESDetails['FID'] = "";
          $RESDetails['URL'] = ""; 
          echo json_encode($RESDetails); 

  exit;
  }
}

$DocLink = "";
if (isset($_FILES['filed']) && $_FILES['filed']['size'] > 0) 
{ 
		$ftmpName  = $_FILES['filed']['tmp_name']; 
     $fimgName = $_FILES['filed']['name'];

        send1:    
        $FILEID = date('Ymd_his');
       $ext = pathinfo($fimgName, PATHINFO_EXTENSION); 
       // $temp = explode(".", $_FILES["file"]["name"]);
        //$newfilename = round(microtime(true)) . '.' . end($temp);
         if (file_exists("../REQAttach/" . $FILEID .".". $ext )) { goto send1; } else
            {
              $FILEURL = "../REQAttach/" . $FILEID .".". $ext;
            }
        
         

/////////////////////////////////////////////////////////////
//Here we need to send details to Contract Table
        if (isset($_FILES['filed']) && $_FILES['filed']['size'] > 0) 
        { 
          move_uploaded_file($ftmpName, $FILEURL);
          
        }
        else
        {
          $FILEURL = "";
        }

        $DocLink = $FILEURL; 
}
else
{         $RESDetails['MSG'] = "Kindly add attachment. Thanks";
          $RESDetails['FID'] = "";
          $RESDetails['URL'] = ""; echo json_encode($RESDetails); exit; 
}





  $queryNewFile = "INSERT INTO filereq (tile, fpath, reqtype, reqcode, CreatedOn, CreatedBy) 
        VALUES ('$title', '$DocLink', 'PO', '$reqid' ,'$DateG','$UID');";

        if(mysql_query($queryNewFile))
        {
          //echo mysql_insert_id();;
          $RESDetails['MSG'] = "OK";
          $RESDetails['FID'] = mysql_insert_id();
          $RESDetails['TITLE'] = $title;
          $RESDetails['URL'] = $DocLink;
          echo json_encode($RESDetails);

        }
        else
        {
          $RESDetails['MSG'] = "Oops! an error occured. Try again";
          $RESDetails['FID'] = "";
          $RESDetails['URL'] = ""; 
          echo json_encode($RESDetails); 
         
        }
//header('Location: ' . $home_url);
//close the connection
mysql_close($dbhandle);


?>
