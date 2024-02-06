<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $tncID = trim(strip_tags($_GET['p']));
  //$poid = trim(strip_tags($_GET['poid']));

  $Today = date('Y/m/d h:i:s a'); 


if($tncID != "")
{
  $query1 = "UPDATE postings1 SET isActive='0', DelLog='Deleted By :: ".$UID." :: On = :: ".$Today." ::' WHERE tncid='".$tncID."'";
   
 
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
   


  $_SESSION['ErrMsgB'] = "Posting Deleted";
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