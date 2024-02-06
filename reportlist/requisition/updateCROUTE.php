<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:s a");

$ReqCode= mysql_real_escape_string($_POST['ReqCID']);
$ActorID= mysql_real_escape_string($_POST['ActorID']);
$ActorRole= mysql_real_escape_string($_POST['ActorRole']);

/*
     $ActorRole .='<option value="0"> Requester </option>';
     $ActorRole .='<option value="1"> Supervisor </option>';
     $ActorRole .='<option value="2"> Head of Department </option>';
     $ActorRole .='<option value="3"> Head of Division </option>';
     $ActorRole .='<option value="4"> GM of Division </option>';
     $ActorRole .='<option value="5"> Contracts & Procurements </option>';
     $ActorRole .='<option value="6"> GM Coporate Service </option>';
     $ActorRole .='<option value="7"> Officer of Due Dilligence </option>';
     $ActorRole .='<option value="8"> GM Due Dilligence </option>';
     $ActorRole .='<option value="9"> MD </option>';
     $ActorRole .='<option value="11"> GM Finance </option>';
*/

if($ActorRole==0)
{
	$sql_res=mysql_query("UPDATE cashreq SET Approved='$ActorRole', LastActor='System Admin', Status='Re-Routed', ApprovedBy='$uid' WHERE RequestID='$ReqCode'"); $result = mysql_query($sql_res, $dbhandle); 
    
}
elseif($ActorRole==1)
{
	$sql_res=mysql_query("UPDATE cashreq SET Approved='$ActorRole', LastActor='System Admin', SupervisorApp='$ActorID', Status='Re-Routed To Requester', ApprovedBy='$uid' WHERE RequestID='$ReqCode'");
    $result = mysql_query($sql_res, $dbhandle);
}
elseif($ActorRole==2)
{
	$sql_res=mysql_query("UPDATE cashreq SET Approved='$ActorRole', LastActor='System Admin', DeptHeadApp='$ActorID', Status='Re-Routed To Head of Dept.', ApprovedBy='$uid' WHERE RequestID='$ReqCode'");
    $result = mysql_query($sql_res, $dbhandle);
}
elseif($ActorRole==3)
{
	$sql_res=mysql_query("UPDATE cashreq SET Approved='$ActorRole', LastActor='System Admin', DivHeadApp='$ActorID', Status='Re-Routed To Head of Div.', ApprovedBy='$uid' WHERE RequestID='$ReqCode'");
    $result = mysql_query($sql_res, $dbhandle);
}
elseif($ActorRole==4)
{
	$sql_res=mysql_query("UPDATE cashreq SET Approved='$ActorRole', LastActor='System Admin', MgrApp='$ActorID', Status='Re-Routed To GM of Div.', ApprovedBy='$uid' WHERE RequestID='$ReqCode'");
    $result = mysql_query($sql_res, $dbhandle);
}
elseif($ActorRole==5)
{
	$sql_res=mysql_query("UPDATE cashreq SET Approved='$ActorRole', LastActor='System Admin', MgrApp='$ActorID', Status='Re-Routed To C&P.', ApprovedBy='$uid' WHERE RequestID='$ReqCode'");
    $result = mysql_query($sql_res, $dbhandle);
}
elseif($ActorRole==6)
{
	$sql_res=mysql_query("UPDATE cashreq SET Approved='$ActorRole', LastActor='System Admin', MgrApp='$ActorID', Status='Re-Routed To GM of CS.', ApprovedBy='$uid' WHERE RequestID='$ReqCode'");
    $result = mysql_query($sql_res, $dbhandle);
}
elseif($ActorRole==7)
{
	$sql_res=mysql_query("UPDATE cashreq SET Approved='$ActorRole', LastActor='System Admin', DDOfficerApp='$ActorID', Status='Re-Routed To Officer of DD.', ApprovedBy='$uid' WHERE RequestID='$ReqCode'");
    $result = mysql_query($sql_res, $dbhandle);
}
elseif($ActorRole==8)
{
	$sql_res=mysql_query("UPDATE cashreq SET Approved='$ActorRole', LastActor='System Admin', DDApp='$ActorID', Status='Re-Routed To GM of DD.', ApprovedBy='$uid' WHERE RequestID='$ReqCode'");
    $result = mysql_query($sql_res, $dbhandle);
}
elseif($ActorRole==9)
{
	$sql_res=mysql_query("UPDATE cashreq SET Approved='$ActorRole', LastActor='System Admin', MDApp='$ActorID', Status='Re-Routed To MD.', ApprovedBy='$uid' WHERE RequestID='$ReqCode'");
    $result = mysql_query($sql_res, $dbhandle);
}
elseif($ActorRole==11)
{
	$sql_res=mysql_query("UPDATE cashreq SET Approved='$ActorRole', LastActor='System Admin', Status='Re-Routed To GM of Finance.', ApprovedBy='$uid' WHERE RequestID='$ReqCode'");
    $result = mysql_query($sql_res, $dbhandle);
}


//echo mysql_error($dbhandle); exit;

 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  
//close the connection
mysql_close($dbhandle);


?>
