<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
include ('../emailsettings/emailSettings.php');

$UID = $_SESSION['uid'];

  $ConID = trim(strip_tags($_POST['conID']));
  $DDcomment = trim(strip_tags($_POST['DDcomment']));
  $DDapprove = trim(strip_tags($_POST['DDapprove'])); //exit;

//exit;
  $Today = date('Y/m/d h:i:s a'); 
 $FDate ="";
 
  $sqlPOREQ=mysql_query("SELECT * FROM vendorsinvoices WHERE cid='$ConID'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
      
       $DDAppComment = $rowPOREQ['DDOfficerComment'];
       $DDAppDate = $rowPOREQ['DDOfficerOn'];

     }
     
           {
                //$DDcomment = '<div class="rcorners1">'.$GMCSAppComment.'  | <b>'.$GMCSAppDate.'</b></div>'. $DDcomment;
                $DDcommentN = $DDAppComment . '<div class="rcorners1">'.$DDcomment.'  | <b>'.$Today.'</b></div>';
             }
  

if($DDapprove == "1"){
	$query1 = "UPDATE vendorsinvoices SET DDOfficer='".$UID."', DDOfficerComment='".$DDcommentN."', DDOfficerOn='".$Today."', Status='3' WHERE cid='".$ConID."'";
}
else
  {
  $query1 = "UPDATE vendorsinvoices SET DDOfficer='".$UID."', DDOfficerComment='".$DDcommentN."', DDOfficerOn='".$Today."', Status='1' WHERE cid='".$ConID."'";
}


if(mysql_query($query1, $dbhandle))
{
   
 /////////***************************************************?///////////////////
 if($DDapprove != 1)
   {
       /////////////////////////////////////////////////
       	//Get Internal Control
  		$resultDD = mysql_query("SELECT * FROM divisions WHERE divid = 1");
  		 $NoRowDD = mysql_num_rows($resultDD); 
  		 if($NoRowDD > 0)
  		 {
  		     	while ($row = mysql_fetch_array($resultDD)) {
  		     	    $GMCS = $row['GM'];
  		     	}
  		 }
  	
  	//We need to get the GMCS Details
  	$resultLI = mysql_query("SELECT * FROM users WHERE uid='$GMCS'"); 

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
       if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
       }
       exit;
   }
       ////////////////////////////////////////////////////
       send_notification ($Email, $FullName, $ConID, "GMCS", $DDcomment, $DDapprove);
   }else
   {
       /////////////////////////////////////////////////
       	//Get MD
  		
  	$resultLI = mysql_query("SELECT * FROM users WHERE CEO='1'"); 

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
       $_SESSION['ErrMsgB'] = "No CEO Set ";
       if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
       }
       exit;
   }
       ////////////////////////////////////////////////////
       send_notification ($Email, $FullName, $ConID, "MD's Office", $DDcomment, $DDapprove);
   }
 //////////////////////********************************************///////////////////

  	$_SESSION['ErrMsgB'] = "Updated ";
	header('Location: printINVOICE?cnid='.$ConID);
mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not update ";
  header('Location: printINVOICE?cnid='.$ConID);
//close the connection
mysql_close($dbhandle);
}


//Lets sned the EMail here, No time
function send_notification ($email, $fullnme, $invid, $role, $msg, $DDapprove)
{
	
       
        $MsgTitle = "Elshcon ERP [INVOICE *** Awaiting your action]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view invoice on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        
        if($DDapprove == 1)
        {
         $msgLink = 'https://www.elshcon.space/ceo/printINVOICE?cnid='.$invid;
        }
        else
        {
            $msgLink = 'https://www.elshcon.space/GMCS/printINVOICE?cnid='.$invid;
        }
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}




?>