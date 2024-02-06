<?php
session_start();
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
error_reporting(0);
include ('../DBcon/db_config.php');
include ('../emailsettings/emailSettings.php');

$UID = $_SESSION['uid'];

  $ConID = trim(strip_tags($_POST['conID']));
  $MDcomment = trim(strip_tags($_POST['MDcomment']));
  $MDapprove = trim(strip_tags($_POST['MDapprove'])); //exit;


  $Today = date('Y/m/d h:i:s a'); 
 $FDate ="";
 
   $sqlPOREQ=mysql_query("SELECT * FROM vendorsinvoices WHERE cid='$ConID'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
      
       $MDAppComment = $rowPOREQ['MDOfficeComment'];
       $DDAppDate = $rowPOREQ['MDOfficeOn'];

     }
     
           {
                //$DDcomment = '<div class="rcorners1">'.$GMCSAppComment.'  | <b>'.$GMCSAppDate.'</b></div>'. $DDcomment;
                $MDAppCommentN = $MDAppComment . '<div class="rcorners1">'.$MDcomment.'  | <b>'.$Today.'</b></div>';
             }
  
  

if($MDapprove == "on"){
	$query1 = "UPDATE vendorsinvoices SET MDOffice='".$UID."', MDOfficeComment='".$MDAppCommentN."', MDOfficeOn='".$Today."', Status='4' WHERE cid='".$ConID."'";
	//Need to Notify CNP here
}
else
  {
  $query1 = "UPDATE vendorsinvoices SET MDOffice='".$UID."', MDOfficeComment='".$MDAppCommentN."', MDOfficeOn='".$Today."', Status='2' WHERE cid='".$ConID."'";
}


if(mysql_query($query1, $dbhandle))
{
   


  //	$_SESSION['ErrMsgB'] = "Updated ";
//	header('Location: invoices');
$_SESSION['ErrMsgB'] = "Updated!";

 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    
mysql_close($dbhandle);
exit;
  	
 }
 else{
echo mysql_error();
exit;
 //$_SESSION['ErrMsg'] = "Oops! Did not update ";
  header('Location: invoices');
//close the connection
mysql_close($dbhandle);
}



?>