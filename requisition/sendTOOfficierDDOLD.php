<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID =$uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];
if($uid < 1) {
     $_SESSION['ErrMsg'] = "Oops! Timed Out. Kindly Logout and Login Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit;
}

$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode']))); //exit;
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG']))); 
$rep = mysql_real_escape_string(trim(strip_tags($_POST['rep']))); 
$actor = mysql_real_escape_string(trim(strip_tags($_POST['actor']))); 
$TodayD = date("Y-m-d h:i:s a"); 


$resultDD = mysql_query("SELECT * FROM users WHERE DeptID=11");
 while ($row = mysql_fetch_array($resultDD)) {
       $OffcierDD = $row['uid'];
       $REQUID = $row['uid'];
       
       $OfficerDDNme = $row['Firstname'] . " " . $row['Surname']; 
       $OfficerDDEmail = $row['Email']; 

     }
     
     
$sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
        while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
               $UserApp = $rowPOREQ['UserApp'];
               
               $Deparment = $rowPOREQ['Deparment'];

               $CSAppDate = $rowPOREQ['CSAppDate'];
               $CSAppComment = $rowPOREQ['CSAppComment'];

               $MgrAppDate = $rowPOREQ['MgrAppDate'];
               $MgrAppComment = $rowPOREQ['MgrAppComment'];

             }

//Let's get the request Division
     $ReqDpet = mysql_query("SELECT * department WHERE id=$Deparment");
 while ($row = mysql_fetch_array($ReqDpet)) {
         $ReQDivID = $row['DivID']; 
     }
     
      $ReqDpet = mysql_query("SELECT * divisions WHERE divid=$ReQDivID");
 while ($row = mysql_fetch_array($ReqDpet)) {
         $GM = $row['GM']; 
     }
     
     
//Update the rpo table

 $isHOD = mysql_num_rows($resultDD); 
if($isHOD < 1 ) { 
    $_SESSION['ErrMsg'] = "No Staff in Due Dilligenc Office, contact HR. Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    //header('Location: cashdivppor?pdfid='.$ReqCode);
    exit; 
}


             
       

 if($ReQDivID == 1) //"GM of Divison"
{

     if($MgrAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$MgrAppComment.'  | <b>'.$MgrAppDate.'</b></div> <br/> '. $hodMSG;
             }
   mysql_query("UPDATE poreq SET Approved='7', LastActor='GM of Division', Status='Approved', DDOfficerApp='".$OffcierDD."', MgrApp='".$uid."', ApprovedBy='".$_SESSION['Firstname']. " ".$_SESSION['SurName']."', MgrAppDate='".$TodayD."',  MgrAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}
else

 //if($actor == "CSGM of Divison")
{

      if($CSAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$CSAppComment.'  | <b>'.$CSAppDate.'</b></div> <br/> '. $hodMSG;
             }
   mysql_query("UPDATE poreq SET Approved='7', LastActor='GM of CS', Status='Approved', DDOfficerApp='".$OffcierDD."', CSApp='".$uid."', ApprovedBy='".$_SESSION['Firstname']. " ".$_SESSION['SurName']."', CSAppDate='".$TodayD."',  CSAppComment='".$hodMSG."', MgrApp='".$uid."', MgrAppDate='".$TodayD."',  MgrAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}


//now we have to inform the HOD
require_approval_action_notification ($OfficerDDEmail, $OfficerDDNme, $ReqCode, "Office of Due Dilligence", $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/officeddppor?pdfid='.$pdfid;
		include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$OfficerDDNme." as Officer in Due Dilligence. Thanks";
//header('Location: ppor?sReqID='.$ReqCode);
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);
exit;









?>