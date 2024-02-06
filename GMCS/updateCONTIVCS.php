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
  $GMCScomment = trim(strip_tags($_POST['GMCScomment']));
  $GMCSapprove = trim(strip_tags($_POST['GMCSapprove'])); //exit;

//exit;
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
    //if($GMCSAppComment != "")
             {
                //$DDcomment = '<div class="rcorners1">'.$GMCSAppComment.'  | <b>'.$GMCSAppDate.'</b></div>'. $DDcomment;
                $GMCScommentN = $GMCSAppComment . '<div class="rcorners1">'.$GMCScomment.'  | <b>'.$Today.'</b></div>';
             }

if($GMCSapprove == 1){
	$query1 = "UPDATE vendorsinvoices SET GMCSApp='".$UID."', GMCSAppComment='".$GMCScommentN."', GMCSAppDate='".$Today."', GMCSAppStatus='1', Status='2' WHERE cid='".$ConID."'";
}
else
  {
  $query1 = "UPDATE vendorsinvoices SET GMCSApp='".$UID."', GMCSAppComment='".$GMCScommentN."', GMCSAppDate='".$Today."', GMCSAppStatus='0', Status='0' WHERE cid='".$ConID."'";
}


if(mysql_query($query1, $dbhandle))
{
   
   if($GMCSapprove == 1)
   {
       /////////////////////////////////////////////////
       	//Get Internal Control
  		$resultDD = mysql_query("SELECT * FROM divisions WHERE divid = 3");
  		 $NoRowDD = mysql_num_rows($resultDD); 
  		 if($NoRowDD > 0)
  		 {
  		     	while ($row = mysql_fetch_array($resultDD)) {
  		     	    $InteralControlDD = $row['GM'];
  		     	}
  		 }
  	
  	//We need to get the GMCS Details
  	$resultLI = mysql_query("SELECT * FROM users WHERE uid='$InteralControlDD'"); 

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
       $_SESSION['ErrMsgB'] = "No GM Internal Control Set ";
      /* if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
       }*/
        header("Location: invoices");
       exit;
   }
       ////////////////////////////////////////////////////
       send_notification ($Email, $FullName, $ConID, "Internal Control", $GMCScomment, $GMCSapprove);
   }else
   {
       /////////////////////////////////////////////////
       	//Get HOD CNP
  		$resultDD = mysql_query("SELECT * FROM department WHERE id = 3");
  		 $NoRowDD = mysql_num_rows($resultDD); 
  		 if($NoRowDD > 0)
  		 {
  		     	while ($row = mysql_fetch_array($resultDD)) {
  		     	    $CnPHOD = $row['hod'];
  		     	}
  		 }
  	
  	//We need to get the GMCS Details
  	$resultLI = mysql_query("SELECT * FROM users WHERE uid='$CnPHOD'"); 

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
       $_SESSION['ErrMsgB'] = "No C&P HOD Set ";
      /* if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
       }*/
         header("Location: invoices");
       exit;
   }
       ////////////////////////////////////////////////////
       send_notification ($Email, $FullName, $ConID, "C & P", $GMCScomment, $GMCSapprove);
   }

  	$_SESSION['ErrMsgB'] = "Updated";
  	
  	
       header("Location: invoices");
    
    // header("Location: ../GMCS/invoices");
    
    
mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not update ";
 /*if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }*/
    // header("Location: ../GMCS/invoices");
      header("Location: invoices");
   
//close the connection
mysql_close($dbhandle);
}


//Lets sned the EMail here, No time
function send_notification ($email, $fullnme, $invid, $role, $msg, $GMCSapprove)
{
	
       
        $MsgTitle = "Elshcon ERP [INVOICE *** Awaiting your action]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view invoice on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        
        if($GMCSapprove == 1)
        {
         $msgLink = 'https://www.elshcon.space/duediligence/printINVOICE?cnid='.$invid;
        }
        else
        {
            $msgLink = 'https://www.elshcon.space/cnp/printINVOICE?cnid='.$invid;
        }
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}


?>