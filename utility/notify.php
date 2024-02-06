<?php
session_start();
//error_reporting();
//include ('../DBcon/db_config.php');
//select a database to work with
require_once('../DBcon/db_config.php');
require_once('../emailsettings/emailSettings.php');


$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];
$fullname = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$CompAbbr = $_SESSION['CompanyName'];

function set_email_notification ($actionID, $module, $sender, $recipent, $CC, $Msg, $MsgType, $MsgTitle)
{
	$query = "INSERT INTO emailtb (actionID, module, sender, recipent, CC, Msg, MsgType, MsgTitle) 
	VALUES ('$actionID','$module','$sender','$recipent','$CC','$Msg','$MsgType','$MsgTitle');";
	 mysql_query($query);
	 //return mysql_error();


}


function notify_projects_of_intelsales_released_lineitem($lineitemID, $RFQCode, $DescriLID)
{
       $fullname = "Projects and Controls Team";//$GLOBALS['fullname'];
       $CompAbbr = $GLOBALS['CompAbbr'];
       //get evebody in Project and Control
	$emails = ""; $msgRep = ""; $senderID = $_SESSION['uid'];
	$sqlMsg = mysql_query("SELECT * FROM users WHERE ReciNotify=1 AND isActive=1 AND isAvalible=1");
	$NoRowsqlMsg = mysql_num_rows($sqlMsg);
 	if ($NoRowsqlMsg > 0) 
 	{
	  	while ($row = mysql_fetch_array($sqlMsg)) 
	  	{
		    $userid = $row['uid'];
		    $userRole = $row['AccessModule'];
		    $userRArray = explode(",",$userRole);

		    if(in_array("projectcontrols", $userRArray))
		    {
		    	$emailu = $row['Email'];  //set all recipient emails
		    	$fullnmeu = $row['Surname'] . " " . $row['Firstname'];  //set all recipient emails
		    	$GLOBALS['mail']->AddAddress($emailu,$fullnmeu);
		    	$msgRep .= $userid .","; // set all msgRep IDs
		    }

	   }
   } 

	//We are now going to send Msgs
	//we need to push the email over now
   		$MsgTitle = "Item Released for SO";
        $GLOBALS['mail']->Subject = $MsgTitle/*$GLOBALS['CompAbbr']. */;
        //$mail->AddAddress($LIemai,$fullname);
        //$GLOBALS['mail']->AddAddress($emails,$fullname);
        $msgBody = 'Kindly note that an Item with <br/> <b> Item ID: </b> ['.$lineitemID.'] in <b>RFQ No.:</b> '.$RFQCode.', needs you to action on it as a project control team member. <br/><br/><b>Description: </b>'.$DescriLID.'<br/>';
        $msgLink = 'https://www.planterp.space/projectcontrols/Qchk?sRFQ='.$RFQCode;
        $msg = '<!DOCTYPE html>
        <html><head>
        <meta charset="UTF-8"></head><body style="margin:0px; font-family:Sans-serif, sans-serif; background:#DBDBDB;"><div style="padding:35px; background:#FFF; font-size:22px; color:#999;"><center> <img style="float:left; width:60px; height:60px; margin-top: 0px;" src="https://www.planterp.space/mBOOT/plant.png" /> '.$CompAbbr.' </center></div>
        <div style="padding:24px; margin:12px; margin-bottom:12px; font-size:15px; color:#8F8F8F; background:#FCFCFC;">Dear '.$fullname.',<br /><br/> '.$msgBody.'<br/> Click on the below button. <br /><br /> <center><a href="'.$msgLink.'"><button type="button" style="padding:12px; background:#42A679; color:#FFF; border-radius:12px; cursor:pointer;">Go to ERP</button></a></center> <br /> or copy and paste the link below on your browser <br />  '.$msgLink.' <br /><br /><br />Thanks<br />
        <br />Sincerely,<br /> </div>   
        </body></html>';
        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
     //Now we are going ot set ERP notification on the App
     set_email_notification ($lineitemID, "projectcontrols", $senderID , $msgRep, "", $msg, "INTERNAL", $MsgTitle);
     set_erp_notification ("message", $MsgTitle, $msgBody, $senderID, $msgRep, $msgLink);
	  $GLOBALS['mail']->Send();
	  

}

function notify_hr_leave($sid, $LeaveType, $LeaveDays, $LeavePurpose)
{
	$sqlMsg = mysql_query("SELECT * FROM users WHERE ReciNotify=1 AND isActive=1 AND isAvalible=1");
	$NoRowsqlMsg = mysql_num_rows($sqlMsg);
 	if ($NoRowsqlMsg > 0) 
 	{
	  	while ($row = mysql_fetch_array($sqlMsg)) 
	  	{
		    $userid = $row['uid'];
		    $userRole = $row['AccessModule'];
		    $userRArray = explode(",",$userRole);

		    if(in_array("projectcontrols", $userRArray))
		    {
		    	$emailu = $row['Email'];  //set all recipient emails
		    	$fullnmeu = $row['Surname'] . " " . $row['Firstname'];  //set all recipient emails
		    	$GLOBALS['mail']->AddAddress($emailu,$fullnmeu);
		    	$msgRep .= $userid .","; // set all msgRep IDs
		    }

	   }
   } 

	//we need to push the email over now
   		$MsgTitle = "LEAVE APPLIED";
        $GLOBALS['mail']->Subject = $MsgTitle/*$GLOBALS['CompAbbr']. */;
        //$mail->AddAddress($LIemai,$fullname);
        //$GLOBALS['mail']->AddAddress($emails,$fullname);
        $msgBody = 'Kindly treat leave applied by '.$fullnmeu.'';
        $msgLink = 'https://www.planterp.space/user/Qchk?sRFQ='.$RFQCode;
        $msg = '<!DOCTYPE html>
        <html><head>
        <meta charset="UTF-8"></head><body style="margin:0px; font-family:Sans-serif, sans-serif; background:#DBDBDB;"><div style="padding:35px; background:#FFF; font-size:22px; color:#999;"><center> <img style="float:left; width:60px; height:60px; margin-top: 0px;" src="https://www.planterp.space/mBOOT/plant.png" /> '.$CompAbbr.' </center></div>
        <div style="padding:24px; margin:12px; margin-bottom:12px; font-size:15px; color:#8F8F8F; background:#FCFCFC;">Dear '.$fullname.',<br /><br/> '.$msgBody.'<br/> Click on the below button. <br /><br /> <center><a href="'.$msgLink.'"><button type="button" style="padding:12px; background:#42A679; color:#FFF; border-radius:12px; cursor:pointer;">Go to ERP</button></a></center> <br /> or copy and paste the link below on your browser <br />  '.$msgLink.' <br /><br /><br />Thanks<br />
        <br />Sincerely,<br /> </div>   
        </body></html>';
        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
     //Now we are going ot set ERP notification on the App
     set_email_notification ($lineitemID, "projectcontrols", $senderID , $msgRep, "", $msg, "INTERNAL", $MsgTitle);
     set_erp_notification ("message", $MsgTitle, $msgBody, $senderID, $msgRep, $msgLink);
	  $GLOBALS['mail']->Send();
	 


}



function notify_purchasing_of_project_so_creation($SONo, $SOType, $SOCusFName, $N, $ItemDetails)
{
	$fullname = "Purchasing Team";//$GLOBALS['fullname'];
       $CompAbbr = $GLOBALS['CompAbbr'];
       //get evebody in Project and Control
	$emails = ""; $msgRep = ""; $senderID = $_SESSION['uid'];
	$sqlMsg = mysql_query("SELECT * FROM users WHERE ReciNotify=1 AND isActive=1 AND isAvalible=1");
	$NoRowsqlMsg = mysql_num_rows($sqlMsg);
 	if ($NoRowsqlMsg > 0) 
 	{
	  	while ($row = mysql_fetch_array($sqlMsg)) 
	  	{
		    $userid = $row['uid'];
		    $userRole = $row['AccessModule'];
		    $userRArray = explode(",",$userRole);

		    if(in_array("purchasing", $userRArray))
		    {
		    	$emailu = $row['Email'];  //set all recipient emails
		    	$fullnmeu = $row['Surname'] . " " . $row['Firstname'];  //set all recipient emails
		    	$GLOBALS['mail']->AddAddress($emailu,$fullnmeu);
		    	$msgRep .= $userid .","; // set all msgRep IDs
		    }

	   }
   } 

	//We are now going to send Msgs
	//we need to push the email over now
   		$MsgTitle = $SONo . " raised" ;
        $GLOBALS['mail']->Subject = $MsgTitle/*$GLOBALS['CompAbbr']. */;
        //$mail->AddAddress($LIemai,$fullname);
        //$GLOBALS['mail']->AddAddress($emails,$fullname);
        $msgBody = 'Kindly note that a Sales Order with <br/> <b> SO No.: </b> ['.$SONo.']  for <b>'.$SOCusFName.'</b> <br/> with <b> '.$N.'</b> item(s), needs you to action on it as a purchasing team member. <br/><br/><b>Details: </b>'.$ItemDetails.'<br/>';
        $msgLink = 'https://www.planterp.space/purchasing/Qchk?sRFQ='.$SONo;
        $msg = '<!DOCTYPE html>
        <html><head>
        <meta charset="UTF-8"></head><body style="margin:0px; font-family:Sans-serif, sans-serif; background:#DBDBDB;"><div style="padding:35px; background:#FFF; font-size:22px; color:#999;"><center> <img style="float:left; width:60px; height:60px; margin-top: 0px;" src="https://www.planterp.space/mBOOT/plant.png" /> '.$CompAbbr.' </center></div>
        <div style="padding:24px; margin:12px; margin-bottom:12px; font-size:15px; color:#8F8F8F; background:#FCFCFC;">Dear '.$fullname.',<br /><br/> '.$msgBody.'<br/> Click on the below button. <br /><br /> <center><a href="'.$msgLink.'"><button type="button" style="padding:12px; background:#42A679; color:#FFF; border-radius:12px; cursor:pointer;">Go to ERP</button></a></center> <br /> or copy and paste the link below on your browser <br />  '.$msgLink.' <br /><br /><br />Thanks<br />
        <br />Sincerely,<br /> </div>   
        </body></html>';
        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
     //Now we are going ot set ERP notification on the App
     set_email_notification ($SONo, "purchasing", $senderID , $msgRep, "", $msg, "INTERNAL", $MsgTitle);
     set_erp_notification ("message", $MsgTitle, $msgBody, $senderID, $msgRep, $msgLink);
	 $GLOBALS['mail']->Send();


}

function notify_logistics_of_po_creation($PONo, $POSup, $N, $ItemDetails)
{
	$fullname = "Logistics Team";//$GLOBALS['fullname'];
       $CompAbbr = $GLOBALS['CompAbbr'];
       //get evebody in Project and Control
	$emails = ""; $msgRep = ""; $senderID = $_SESSION['uid'];
	$sqlMsg = mysql_query("SELECT * FROM users WHERE ReciNotify=1 AND isActive=1 AND isAvalible=1");
	$NoRowsqlMsg = mysql_num_rows($sqlMsg);
 	if ($NoRowsqlMsg > 0) 
 	{
	  	while ($row = mysql_fetch_array($sqlMsg)) 
	  	{
		    $userid = $row['uid'];
		    $userRole = $row['AccessModule'];
		    $userRArray = explode(",",$userRole);

		    if(in_array("logistics", $userRArray))
		    {
		    	$emailu = $row['Email'];  //set all recipient emails
		    	$fullnmeu = $row['Surname'] . " " . $row['Firstname'];  //set all recipient emails
		    	$GLOBALS['mail']->AddAddress($emailu,$fullnmeu);
		    	$msgRep .= $userid .","; // set all msgRep IDs
		    }

	   }
   } 

	//We are now going to send Msgs
	//we need to push the email over now
   		$MsgTitle = $PONo . " Released" ;
        $GLOBALS['mail']->Subject = $MsgTitle/*$GLOBALS['CompAbbr']. */;
        //$mail->AddAddress($LIemai,$fullname);
        //$GLOBALS['mail']->AddAddress($emails,$fullname);
        $msgBody = 'Kindly note that a Purchase Order with <br/> <b> PO No.: </b> ['.$PONo.'] to <b>'.$POSup.'</b> <br/> with <b> '.$N.'</b> item(s), needs you to track as logistics team member. <br/><br/><b>Details: </b>'.$ItemDetails.'<br/>';
        $msgLink = 'https://www.planterp.space/logistics/Qchk?sRFQ='.$PONo;
        $msg = '<!DOCTYPE html>
        <html><head>
        <meta charset="UTF-8"></head><body style="margin:0px; font-family:Sans-serif, sans-serif; background:#DBDBDB;"><div style="padding:35px; background:#FFF; font-size:22px; color:#999;"><center> <img style="float:left; width:60px; height:60px; margin-top: 0px;" src="https://www.planterp.space/mBOOT/plant.png" /> '.$CompAbbr.' </center></div>
        <div style="padding:24px; margin:12px; margin-bottom:12px; font-size:15px; color:#8F8F8F; background:#FCFCFC;">Dear '.$fullname.',<br /><br/> '.$msgBody.'<br/> Click on the below button. <br /><br /> <center><a href="'.$msgLink.'"><button type="button" style="padding:12px; background:#42A679; color:#FFF; border-radius:12px; cursor:pointer;">Go to ERP</button></a></center> <br /> or copy and paste the link below on your browser <br />  '.$msgLink.' <br /><br /><br />Thanks<br />
        <br />Sincerely,<br /> </div>   
        </body></html>';
        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
     //Now we are going ot set ERP notification on the App
     set_email_notification ($PONo, "logistics", $senderID , $msgRep, "", $msg, "INTERNAL", $MsgTitle);
     set_erp_notification ("message", $MsgTitle, $msgBody, $senderID, $msgRep, $msgLink);
	 $GLOBALS['mail']->Send();


}

function notify_warehouse_of_po_creation($PONo, $POSup, $N, $ItemDetails)
{
	$fullname = "Warehouse Team";//$GLOBALS['fullname'];
       $CompAbbr = $GLOBALS['CompAbbr'];
       //get evebody in Project and Control
	$emails = ""; $msgRep = ""; $senderID = $_SESSION['uid'];
	$sqlMsg = mysql_query("SELECT * FROM users WHERE ReciNotify=1 AND isActive=1 AND isAvalible=1");
	$NoRowsqlMsg = mysql_num_rows($sqlMsg);
 	if ($NoRowsqlMsg > 0) 
 	{
	  	while ($row = mysql_fetch_array($sqlMsg)) 
	  	{
		    $userid = $row['uid'];
		    $userRole = $row['AccessModule'];
		    $userRArray = explode(",",$userRole);

		    if(in_array("warehousing", $userRArray))
		    {
		    	$emailu = $row['Email'];  //set all recipient emails
		    	$fullnmeu = $row['Surname'] . " " . $row['Firstname'];  //set all recipient emails
		    	$GLOBALS['mail']->AddAddress($emailu,$fullnmeu);
		    	$msgRep .= $userid .","; // set all msgRep IDs
		    }

	   }
   } 

	//We are now going to send Msgs
	//we need to push the email over now
   		$MsgTitle = $PONo . " Released" ;
        $GLOBALS['mail']->Subject = $MsgTitle/*$GLOBALS['CompAbbr']. */;
        //$mail->AddAddress($LIemai,$fullname);
        //$GLOBALS['mail']->AddAddress($emails,$fullname);
        $msgBody = 'Kindly note that a Purchase Order with <br/> <b> PO No.: </b> ['.$PONo.'] to <b>'.$POSup.'</b> <br/> with <b> '.$N.'</b> item(s), needs your attention as warehouse team member. <br/><br/><b>Details: </b>'.$ItemDetails.'<br/>';
        $msgLink = 'https://www.planterp.space/warehousing/Qchk?sRFQ='.$PONo;
        $msg = '<!DOCTYPE html>
        <html><head>
        <meta charset="UTF-8"></head><body style="margin:0px; font-family:Sans-serif, sans-serif; background:#DBDBDB;"><div style="padding:35px; background:#FFF; font-size:22px; color:#999;"><center> <img style="float:left; width:60px; height:60px; margin-top: 0px;" src="https://www.planterp.space/mBOOT/plant.png" /> '.$CompAbbr.' </center></div>
        <div style="padding:24px; margin:12px; margin-bottom:12px; font-size:15px; color:#8F8F8F; background:#FCFCFC;">Dear '.$fullname.',<br /><br/> '.$msgBody.'<br/> Click on the below button. <br /><br /> <center><a href="'.$msgLink.'"><button type="button" style="padding:12px; background:#42A679; color:#FFF; border-radius:12px; cursor:pointer;">Go to ERP</button></a></center> <br /> or copy and paste the link below on your browser <br />  '.$msgLink.' <br /><br /><br />Thanks<br />
        <br />Sincerely,<br /> </div>   
        </body></html>';
        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
     //Now we are going ot set ERP notification on the App
     set_email_notification ($PONo, "warehouse", $senderID , $msgRep, "", $msg, "INTERNAL", $MsgTitle);
     set_erp_notification ("message", $MsgTitle, $msgBody, $senderID, $msgRep, $msgLink);
	 $GLOBALS['mail']->Send();


}


function notify_warehouse_of_logistic_released_lineitem($q, $POIDCode, $DescriLID)
{
       $fullname = "Warehouse Team";//$GLOBALS['fullname'];
       $CompAbbr = $GLOBALS['CompAbbr'];
       $lineitemID = $q;
       //get evebody in Project and Control
	$emails = ""; $msgRep = ""; $senderID = $_SESSION['uid'];
	$sqlMsg = mysql_query("SELECT * FROM users WHERE ReciNotify=1 AND isActive=1 AND isAvalible=1");
	$NoRowsqlMsg = mysql_num_rows($sqlMsg);
 	if ($NoRowsqlMsg > 0) 
 	{
	  	while ($row = mysql_fetch_array($sqlMsg)) 
	  	{
		    $userid = $row['uid'];
		    $userRole = $row['AccessModule'];
		    $userRArray = explode(",",$userRole);

		    if(in_array("warehousing", $userRArray))
		    {
		    	$emailu = $row['Email'];  //set all recipient emails
		    	$fullnmeu = $row['Surname'] . " " . $row['Firstname'];  //set all recipient emails
		    	$GLOBALS['mail']->AddAddress($emailu,$fullnmeu);
		    	$msgRep .= $userid .","; // set all msgRep IDs
		    }

	   }
   } 

	//We are now going to send Msgs
	//we need to push the email over now
   		$MsgTitle = "Item Released to Warehouse";
        $GLOBALS['mail']->Subject = $MsgTitle/*$GLOBALS['CompAbbr']. */;
        //$mail->AddAddress($LIemai,$fullname);
        //$GLOBALS['mail']->AddAddress($emails,$fullname);
        $msgBody = 'Kindly note that an Item with <br/> <b> Item ID: </b> ['.$lineitemID.'] in <b>RFQ No.:</b> '.$POIDCode.', needs your attention a warehouse team member. <br/><br/><b>Description: </b>'.$DescriLID.'<br/>';
        $msgLink = 'https://www.planterp.space/warehousing/Qchk?sRFQ='.$POIDCode;
        $msg = '<!DOCTYPE html>
        <html><head>
        <meta charset="UTF-8"></head><body style="margin:0px; font-family:Sans-serif, sans-serif; background:#DBDBDB;"><div style="padding:35px; background:#FFF; font-size:22px; color:#999;"><center> <img style="float:left; width:60px; height:60px; margin-top: 0px;" src="https://www.planterp.space/mBOOT/plant.png" /> '.$CompAbbr.' </center></div>
        <div style="padding:24px; margin:12px; margin-bottom:12px; font-size:15px; color:#8F8F8F; background:#FCFCFC;">Dear '.$fullname.',<br /><br/> '.$msgBody.'<br/> Click on the below button. <br /><br /> <center><a href="'.$msgLink.'"><button type="button" style="padding:12px; background:#42A679; color:#FFF; border-radius:12px; cursor:pointer;">Go to ERP</button></a></center> <br /> or copy and paste the link below on your browser <br />  '.$msgLink.' <br /><br /><br />Thanks<br />
        <br />Sincerely,<br /> </div>   
        </body></html>';
        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
     //Now we are going ot set ERP notification on the App
     set_email_notification ($lineitemID, "warehouse", $senderID , $msgRep, "", $msg, "INTERNAL", $MsgTitle);
     set_erp_notification ("message", $MsgTitle, $msgBody, $senderID, $msgRep, $msgLink);
	  $GLOBALS['mail']->Send();
	  

}

function notify_resource_person_after_add_task($sPO,$TaskName,$TaskResource,$Userid,$StartDate,$EndDate)
{
	
    $CompAbbr = $GLOBALS['CompAbbr'];
    //get Task Resource Person and Task Created By Details
	$emails = ""; $msgRep = ""; $senderID = $_SESSION['uid'];
	$sqlMsg = mysql_query("SELECT * FROM users WHERE isActive=1 AND isAvalible=1 AND (uid='".$TaskResource."' OR uid ='".$Userid."')");
	$NoRowsqlMsg = mysql_num_rows($sqlMsg);
 	if ($NoRowsqlMsg > 0) 
 	{
	  	while ($row = mysql_fetch_array($sqlMsg)) 
	  	{
		    $userid = $row['uid'];
		    $userRole = $row['AccessModule'];
		    $userRArray = explode(",",$userRole);

		    if($userid == $TaskResource)
		    {
		    	$emailu = $row['Email'];  //set all recipient emails
		    	$fullnmeu = $row['Surname'] . " " . $row['Firstname'];  //set all recipient emails
		    	$GLOBALS['mail']->AddAddress($emailu,$fullnmeu);
		    	$msgRep .= $userid .","; // set all msgRep IDs
		    }

		    if($Userid == $userid)
		    {
		    	$emailTC = $row['Email'];  //set Task Maker email
		    	$fullnmeTC = $row['Surname'] . " " . $row['Firstname'];  //set Task Maker's name
		    	$GLOBALS['mail']->AddCC($emailTC,$fullnmeTC);


		    }

		    

	   }
   } 

	//We are now going to send Msgs
	//we need to push the email over now
   		$MsgTitle = "You are assigned to Task [".$TaskName. "] in Project [".$sPO . "]" ;
        $GLOBALS['mail']->Subject = $MsgTitle/*$GLOBALS['CompAbbr']. */;
        //$mail->AddAddress($LIemai,$fullname);
        //$GLOBALS['mail']->AddAddress($emails,$fullname);
        $msgBody = 'You have been assigned to Task <b>'.$TaskName.'</b> in Project <b> SO No.: </b> ['.$sPO.']  by <b>'.$fullnmeTC.'</b> <br/> From: <b> '.$StartDate.'</b> <br/> To: <b>'.$EndDate.'</b><br/>';
        $msgLink = '';
        $msg = '<!DOCTYPE html>
        <html><head>
        <meta charset="UTF-8"></head><body style="margin:0px; font-family:Sans-serif, sans-serif; background:#DBDBDB;"><div style="padding:35px; background:#FFF; font-size:22px; color:#999;"><center> <img style="float:left; width:60px; height:60px; margin-top: 0px;" src="https://www.planterp.space/mBOOT/plant.png" /> '.$CompAbbr.' </center></div>
        <div style="padding:24px; margin:12px; margin-bottom:12px; font-size:15px; color:#8F8F8F; background:#FCFCFC;">Dear '.$fullnmeu.',<br /><br/> '.$msgBody.'<br/> Click on the below button. <br /><br /> <center><a href="'.$msgLink.'"><button type="button" style="padding:12px; background:#42A679; color:#FFF; border-radius:12px; cursor:pointer;">Go to ERP</button></a></center> <br /> or copy and paste the link below on your browser <br />  '.$msgLink.' <br /><br /><br />Thanks<br />
        <br />Sincerely,<br /> </div>   
        </body></html>';
        $GLOBALS['mail']->Body = $msg;      //HTML Body
      
   
     //Now we are going to set ERP notification on the App
     set_email_notification ($sPO, "EPC Task", $Userid , $msgRep, "", $msg, "INTERNAL", $MsgTitle);
     set_erp_notification ("task", $MsgTitle, $msgBody, $Userid, $msgRep, $msgLink);
	 $GLOBALS['mail']->Send();


}



function set_erp_notification ($msgtype, $msgTitle, $msg, $sender, $recipents, $link)
{
	$query = "INSERT INTO msg (msgtype, msgTitle, msg, sender, recipents, originrecipients, hlink) 
	VALUES ('$msgtype','$msgTitle','$msg','$sender','$recipents','$recipents', '$link');";
	mysql_query($query);

}




?>