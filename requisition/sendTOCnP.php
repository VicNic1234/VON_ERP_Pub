<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID = $uid = $_SESSION['uid'];
$uidN = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];

if($uid == "") {
     $_SESSION['ErrMsg'] = "Oops! Timed Out. Kindly Logout and Login Thanks";
     if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit;
    }
}


$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG']))); 
$rep = mysql_real_escape_string(trim(strip_tags($_POST['rep']))); 
$actor = mysql_real_escape_string(trim(strip_tags($_POST['actor'])));  
$TodayD = date("Y-m-d h:i:s a");

//////////////APPROVAL HDetp CnP/////////////
$resultCnPHOD = mysql_query("SELECT * FROM department WHERE id=3");
 while ($row = mysql_fetch_array($resultCnPHOD)) {
       $CnPHOD = $row['hod'];
     }

////////////////////////////////////////////////////////////////////////////
     //We everyone in C&P
$sql_res=mysql_query("SELECT * FROM users 
    WHERE uid ='$CnPHOD'"); // uid='17' DeptID =3 DeptID = '$DeptID' AND 

 $isHOD = mysql_num_rows($sql_res); 
if($isHOD < 1) { 
    $_SESSION['ErrMsg'] = "No Head of Department in C&P is configured, contact ICT. Thanks";
    //header('Location: hodppor?pdfid='.$ReqCode);
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"] . "?pdfid=".$ReqCode);
    }
    exit; 
}
while ($row = mysql_fetch_array($sql_res)) {
   // if($MyDIVID == $row['divid'])
    {
       $CPID = $row['uid'];
       $REQUID = $row['uid'];
       
       $CPFullname = $row['Firstname'] . " " . $row['Surname'];
       //$GMDIVName = $row['DivisionName'];
       $CPEmail = $row['Email'];
    }
   
     }

//////////////////////////////////////////////////////////////////////////////
//Lets get HOD Info
$sqlPOREQ=mysql_query("SELECT * FROM poreq WHERE RequestID='$ReqCode'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $UserApp = $rowPOREQ['UserApp'];

       $UserAppComment = $rowPOREQ['UserAppComment'];
       $UserAppDate = $rowPOREQ['UserAppDate'];

       $SupervisorComment = $rowPOREQ['SupervisorComment'];
       $SupervisorAppDate = $rowPOREQ['SupervisorAppDate'];

       $DeptHeadAppDate = $rowPOREQ['DeptHeadAppDate'];
       $DeptHeadAppComment = $rowPOREQ['DeptHeadAppComment'];

       $DivHeadAppDate = $rowPOREQ['DivHeadAppDate'];
       $DivHeadAppComment = $rowPOREQ['DivHeadAppComment'];

       $CSAppDate = $rowPOREQ['CSAppDate'];
       $CSAppComment = $rowPOREQ['CSAppComment'];

       $MgrAppDate = $rowPOREQ['MgrAppDate'];
       $MgrAppComment = $rowPOREQ['MgrAppComment'];

     }



//Update the rpo table
     if($actor == "HODiv"){

        if($DivHeadAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$DivHeadAppComment.'  | <b>'.$DivHeadAppDate.'</b></div> <br/> '. $hodMSG;
             }
    mysql_query("UPDATE poreq SET Approved='5', LastActor='Head of Division', Status='Approved', CPApp='".$CPID."', DivHeadApp='".$uid."', ApprovedBy='".$staffname."', DivHeadAppDate='".$TodayD."',  DivHeadAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}

     if($actor == "Requester"){

        if($UserAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$UserAppComment.'  | <b>'.$UserAppDate.'</b></div> <br/> '. $hodMSG;
             }
    mysql_query("UPDATE poreq SET Approved='5', LastActor='Requester', Status='Approved', CPApp='".$CPID."', UserApp='".$uid."', ApprovedBy='".$staffname."', UserAppDate='".$TodayD."',  UserAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}

 if($actor == "GMCS"){

    if($CSAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$CSAppComment.'  | <b>'.$CSAppDate.'</b></div> <br/> '. $hodMSG;
             }
    mysql_query("UPDATE poreq SET Approved='5', LastActor='GM of Coporate Services', Status='Approved', CPApp='".$CPID."', CSApp='".$uid."', ApprovedBy='".$staffname."', CSAppDate='".$TodayD."',  CSAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}

if($actor == "GMDiv"){

    if($MgrAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$MgrAppComment.'  | <b>'.$MgrAppDate.'</b></div> <br/> '. $hodMSG;
             }
    mysql_query("UPDATE poreq SET Approved='5', LastActor='GM of Division', Status='Approved', CPApp='".$CPID."', MgrApp='".$uidN."', ApprovedBy='".$staffname."', MgrAppDate='".$TodayD."',  MgrAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}

if($actor == "HOD"){

    if($DeptHeadAppComment != "")
             {
                $hodMSG = '<div class="rcorners1">'.$DeptHeadAppComment.'  | <b>'.$DeptHeadAppDate.'</b></div> <br/> '. $hodMSG;
             }
             
    mysql_query("UPDATE poreq SET Approved='5', LastActor='Head of Department', Status='Approved', CPApp='".$CPID."', DeptHeadApp='".$uid."', ApprovedBy='".$staffname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
}
   /*mysql_query("UPDATE poreq SET Approved='2', LastActor='Head of Department', Status='Approved', DeptHeadApp='".$HODID."', ApprovedBy='".$HODFullname."', DeptHeadAppDate='".$TodayD."',  DeptHeadAppComment='".$hodMSG."' WHERE WHERE RequestID = '$ReqCode'");*/

//now we have to inform the HOD
//require_approval_action_notification ($GMEmail, $GMFullname, $ReqCode, "GM for " .$GMDIVName, $hodMSG); 

//Lets sned the EMail here, No time
function require_approval_action_notification ($email, $fullnme, $pdfid, $role, $msg)
{
	
       
        $MsgTitle = "Elshcon ERP [Awaiting your approval]";
        $GLOBALS['mail']->Subject = $MsgTitle;
        $GLOBALS['mail']->AddAddress($email, $fullnme);
       

        $msgBody = 'Kindly click on link below to view Request on Elshcon ERP which requires your approval as ' .$role . ',<br/><br/> with message : <br/><br/><em>'.$msg.'</em>';
        $msgLink = 'https://www.elshcon.space/cnp/hodppor?pdfid='.$pdfid;
		
        include('../notify.php');

        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
        $GLOBALS['mail']->Send();
}

///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Your request have been moved to ".$CPFullname." as C&P Head of Department. Thanks";
//header('Location: hodppor?pdfid='.$ReqCode);
//close the connection
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
mysql_close($dbhandle);
exit;









?>