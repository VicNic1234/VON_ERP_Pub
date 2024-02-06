<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$SNDUID = $uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];



$ReqCode = mysql_real_escape_string(trim(strip_tags($_POST['ReqCode'])));
$hodMSG = mysql_real_escape_string(trim(strip_tags($_POST['hodMSG']))); 
$rep = mysql_real_escape_string(trim(strip_tags($_POST['rep']))); 
$actor = mysql_real_escape_string(trim(strip_tags($_POST['actor'])));  
$TodayD = date("Y-m-d h:i:s a");

//////////////APPROVAL DIVISION/////////////
/*$resultDivMy = mysql_query("SELECT * FROM divisions WHERE GM =$uid");
 while ($row = mysql_fetch_array($resultDivMy)) {
       $MyDivNme = $row['DivisionName'];
     }
*/
////////////////////////////////////////////////////////////////////////////
     //We everyone in C&P
$sql_res=mysql_query("SELECT * FROM users 
    WHERE DeptID =3 AND HDept =1 "); // uid='17' DeptID =3 DeptID = '$DeptID' AND 

 $isHOD = mysql_num_rows($sql_res); 
if($isHOD < 1) { 
    $_SESSION['ErrMsg'] = "No Head of Department in C&P is configured, contact ICT. Thanks";
    header('Location: divppor?pdfid='.$ReqCode);
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



//Update the rpo table
    mysql_query("UPDATE poreq SET Approved='6', LastActor='Head of Division', Status='Approved', CPApp='".$CPID."', DivHeadApp='".$uid."', ApprovedBy='".$staffname."', DivHeadAppDate='".$TodayD."',  DivHeadAppComment='".$hodMSG."' WHERE RequestID = '$ReqCode'");
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
header('Location: divppor?pdfid='.$ReqCode);
//close the connection
mysql_close($dbhandle);
exit;









?>