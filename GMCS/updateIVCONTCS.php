<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $ConID = trim(strip_tags($_POST['conID']));
  $DDcomment = trim(strip_tags($_POST['DDcomment']));
  $DDapprove = trim(strip_tags($_POST['DDapprove'])); //exit;


  $Today = date('Y/m/d h:i:s a'); 
  
  //Let Read the INVOICE Status
  /////////////////////////////////////////
  $sqlPOREQ=mysql_query("SELECT * FROM vendorsinvoices WHERE cid='$ConID'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
      
       $GMCSAppComment = $rowPOREQ['GMCSAppComment'];
       $GMCSAppDate = $rowPOREQ['GMCSAppDate'];

     }
  //////////////////////////////////////////////
 $FDate ="";
    if($GMCSAppComment != "")
             {
                $DDcomment = '<div class="rcorners1">'.$GMCSAppComment.'  | <b>'.$GMCSAppDate.'</b></div> <br/> '. $DDcomment;
             }

if($DDapprove == "on"){
	$query1 = "UPDATE vendorsinvoices SET GMCSApp='".$UID."', GMCSAppComment='".$DDcomment."', GMCSAppDate='".$Today."', GMCSAppStatus='1' WHERE cid='".$ConID."'";
}
else
  {
  $query1 = "UPDATE vendorsinvoices SET GMCSApp='".$UID."', GMCSAppComment='".$DDcomment."', GMCSAppDate='".$Today."', GMCSAppStatus='0' WHERE cid='".$ConID."'";
}


if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Updated ";
	header('Location: invoices');
mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not update ";
  header('Location: invoices');
//close the connection
mysql_close($dbhandle);
}



?>