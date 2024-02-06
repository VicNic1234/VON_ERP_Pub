<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $REQID = trim(strip_tags($_POST['REQID']));
  $MSG = trim(strip_tags($_POST['MSG']));
  $CASHRNUM = trim(strip_tags($_POST['CASHRNUM']));
  $PONUM = trim(strip_tags($_POST['PONUM']));
  $Remark = trim(strip_tags($_POST['Remark']));
  

  $Today = date('Y/m/d h:i:s a'); 
 
  
if($PONUM != "")
{
	$query1 = "UPDATE poreq SET CPActor='".$UID."', CPRemark='".$Remark."', CPActDate='".$Today."', CPActType='".$MSG."', CASHNUM='".$CASHRNUM."', PONUM='".$PONUM."', Approved='16' WHERE reqid='".$REQID."'";
}

if($CASHRNUM != "")
{
  $query1 = "UPDATE poreq SET CPActor='".$UID."', CPRemark='".$Remark."', CPActDate='".$Today."', CPActType='".$MSG."', CASHNUM='".$CASHRNUM."', PONUM='".$PONUM."', Approved='17' WHERE reqid='".$REQID."'";
}




if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Updated ";
	  if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not update";
   if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
}



?>