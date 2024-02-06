<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
include ('../emailsettings/emailSettings.php');

$UID = $_SESSION['uid'];

if($UID < 1)
{
     header('Location: ../users/logout');
    exit;
}

  $ConID = trim(strip_tags($_POST['conID']));
  $CnPcomment1 = $CnPcommentN = trim(strip_tags($_POST['CnPcomment']));
 
//exit;
  $Today = date('Y/m/d h:i:s a'); 
  
  //Let Read the INVOICE Status
  /////////////////////////////////////////
  $sqlPOREQ=mysql_query("SELECT * FROM vendorsinvoices WHERE cid='$ConID'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
      
       $CnPAppComment = $rowPOREQ['CnPAppComment'];
       $CnPAppOn = $rowPOREQ['CnPAppOn'];

     }
  //////////////////////////////////////////////
 $FDate ="";
    //if($GMCSAppComment != "")
             {
                //$DDcomment = '<div class="rcorners1">'.$GMCSAppComment.'  | <b>'.$GMCSAppDate.'</b></div>'. $DDcomment;
                $CnPcommentN = $CnPAppComment . '<div class="rcorners1">'.$CnPcommentN.'  | <b>'.$Today.'</b></div>';
             }
             
             $query1 = "UPDATE vendorsinvoices SET CnPApp='".$UID."', CnPAppComment='".$CnPcommentN."', CnPAppOn='".$Today."', Status='1' WHERE cid='".$ConID."'";

/*
if($DDapprove == "1"){
	$query1 = "UPDATE vendorsinvoices SET GMCSApp='".$UID."', GMCSAppComment='".$DDcomment."', GMCSAppDate='".$Today."', GMCSAppStatus='1' WHERE cid='".$ConID."'";
}
else
  {
  $query1 = "UPDATE vendorsinvoices SET GMCSApp='".$UID."', GMCSAppComment='".$DDcomment."', GMCSAppDate='".$Today."', GMCSAppStatus='0' WHERE cid='".$ConID."'";
}
*/


if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Updated";
  	
  	//Get GM CS
  		$resultDD = mysql_query("SELECT * FROM divisions WHERE divid = 1");
  		 $NoRowDD = mysql_num_rows($resultDD); 
  		 if($NoRowDD > 0)
  		 {
  		     	while ($row = mysql_fetch_array($resultDD)) {
  		     	    $GMDD = $row['GM'];
  		     	}
  		 }
  	
  	//We need to get the GMCS Details
  	$resultLI = mysql_query("SELECT * FROM users WHERE uid='$GMDD'"); 

    $NoRowLI = mysql_num_rows($resultLI); 
    //fetch tha data from the database
   if ($NoRowLI > 0) 
   {
       while ($row = mysql_fetch_array($resultLI)) {
  		     	    $FullName = $row['Firstname'] . " ". $row['Surname']; $Email = $row['Email'];
  		     	}
   }
   else
   {
       $_SESSION['ErrMsgB'] = "No GM CS Set ";
       //Get Internal Contorl
       $resultDD = mysql_query("SELECT * FROM divisions WHERE divid = 3");
  		 $NoRowDD = mysql_num_rows($resultDD); 
  		 if($NoRowDD > 0)
  		 {
  		     	while ($row = mysql_fetch_array($resultDD)) {
  		     	    $GMInCtrl = $row['GM'];
  		     	}
  		 }
  		 
  		 	$resultINCtrl = mysql_query("SELECT * FROM users WHERE uid='$GMInCtrl'"); 

            $NoRowIC = mysql_num_rows($resultINCtrl); 
            //fetch tha data from the database
           if ($NoRowIC > 0) 
           {
               while ($row = mysql_fetch_array($resultINCtrl)) {
          		     	    $FullName = $row['Firstname'] . " ". $row['Surname']; $Email = $row['Email'];
          		     	}
          		     	
          		     	
             $query1 = "UPDATE vendorsinvoices SET CnPApp='".$UID."', CnPAppComment='".$CnPcommentN."', CnPAppOn='".$Today."', Status='2' WHERE cid='".$ConID."'";
             mysql_query($query1, $dbhandle);
          		     	 //we need to send to Inter Control here
                       send_notification ($Email, $FullName, $ConID, "Internal Control", $CnPcomment1);
                       if (isset($_SERVER["HTTP_REFERER"])) {
                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                       }
                       exit;
           }
           else
           {
                $_SESSION['ErrMsgB'] = "No GM Internal Control Set ";
                if (isset($_SERVER["HTTP_REFERER"])) {
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                   }
                   exit;
           }
  		 
  		 ///////
  		 
      
       
   }
  	
    send_notification ($Email, $FullName, $ConID, "GM CS", $CnPcomment1);
     $_SESSION['ErrMsgB'] = "Sent";
       if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
       }
    
    
    
mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not update ";
 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    // header("Location: ../GMCS/invoices");
   
//close the connection
mysql_close($dbhandle);
}


//Lets sned the EMail here, No time
function send_notification ($email, $fullnme, $invid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [INVOICE *** Awaiting your action]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view invoice on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        //$msgLink = 'https://www.elshcon.space/cnp/printINVOICE?cnid='.$invid;
		 //$msgLink = 'https://www.elshcon.space/duediligence/printINVOICE?cnid='.$invid;
		  $msgLink = 'https://www.elshcon.space/GMCS/printINVOICE?cnid='.$invid;
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}


?>