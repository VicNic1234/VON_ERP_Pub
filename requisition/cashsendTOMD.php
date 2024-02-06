<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID = $uid = $_SESSION['uid'];

$DeptID = $_SESSION['DeptID'];
if($uid < 1) {
     $_SESSION['ErrMsg'] = "Oops! Timed Out. Kindly Logout and Login Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit;
}

$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['ReqMSG']))); 
$TodayD = date("Y-m-d h:i:s a");

//First we need to get the DIVID
/*$sqlDept=mysql_query("SELECT * FROM department WHERE id = '$DeptID'");

$isDept = mysql_num_rows($sqlDept);
if($isDept < 1) { 
    $_SESSION['ErrMsg'] = "Your Department is not configured, contact HR. Thanks";
    header('Location: divppor?pdfid='.$ReqCode);
    exit; 
}

while ($rowDIV = mysql_fetch_array($sqlDept)) {
       $MyDIVID = $rowDIV['DivID'];
     }
*/
////////////////////////////////////////////////////////////////////////////
     //We need to get all concerns in Due Diligence now
    $sql_res=mysql_query("SELECT * FROM users WHERE CEO='1'"); //DeptID = '$DeptID' AND 

 $isHOD = mysql_num_rows($sql_res); 
if($isHOD < 1) { 
    $_SESSION['ErrMsg'] = "No MD configured, contact ICT. Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
   
    {
       $REQUID = $MDID = $row['uid'];
       $MDFullname = $row['Firstname'] . " " . $row['Surname'];
       //$GMDIVName = $row['DivisionName'];
       $MDEmail = $row['Email'];
    }

    //now we have to inform the DD
require_approval_action_notification ($MDEmail, $MDFullname, $ReqCode, "MD", $hodMSG); 
   
     }

//////////////////////////////////////////////////////////////////////////////

     $sqlPOREQ=mysql_query("SELECT * FROM cashreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
      $DDAppDate = $rowPOREQ['DDAppDate']; $DDAppComment = $rowPOREQ['DDAppComment'];
     }

  if($DDAppComment != "")
     {
       $hodMSG =  '<div class="rcorners1">'.mysql_real_escape_string($DDAppComment).'  | <b>'.$DDAppDate.'</b></div> <br/> '. $hodMSG;
     }


//Update the rpo table
  //  mysql_query("UPDATE cashreq SET Approved='9', LastActor='Mgr Due Dilligence', Status='Approved', MDApp='".$MDID."', DDApp='".$uid."', ApprovedBy='".$staffname."', DDAppDate='".$TodayD."',  DDAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
  
  mysql_query("UPDATE cashreq SET Approved='9', LastActor='COO', Status='Approved', MDApp='".$MDID."', COOApp='".$uid."', ApprovedBy='".$staffname."', COOAppDate='".$TodayD."',  COOComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
  


//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [CASH REQUEST *** Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/requisition/cashmdppor?pdfid='.$pdfid;
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$MDFullname." as MD for action. Thanks";
 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//header('Location: cashmgddppor?pdfid='.$ReqCode);
//close the connection
mysql_close($dbhandle);
exit;









?>