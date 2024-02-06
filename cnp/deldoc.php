<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $Item = trim(strip_tags($_GET['id']));
  $poid = trim(strip_tags($_GET['poid']));

  $Today = date('Y/m/d h:i:s a'); 
 

if($Item != "")
{
  $query1 = "UPDATE supportingdoc SET isActive='0' WHERE sdid='".$Item."'";
   $_SESSION['ErrMsgB'] = "Document Deleted ";
 // header('Location: viewpo?poid='.$poid);
  //exit;
}
else
{
  $_SESSION['ErrMsg'] = "Oops! Did not delete ";
   if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  exit;
}


if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Doc. Deleted";
	 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not delete ";
  if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

//close the connection
mysql_close($dbhandle);
}



?>