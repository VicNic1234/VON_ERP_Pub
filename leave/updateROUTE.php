<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:s a");

$ReqCode= mysql_real_escape_string($_POST['ReqCID']);
 $ActorID= mysql_real_escape_string($_POST['ActorID']);
$ActorRole= mysql_real_escape_string($_POST['ActorRole']);
//exit;
/*
     $ActorRole .='<option value="0"> Requester </option>';
     $ActorRole .='<option value="1"> Head of Department </option>';
     $ActorRole .='<option value="2"> Head of Division </option>';
     $ActorRole .='<option value="3"> GM of Division </option>';
     $ActorRole .='<option value="4"> GM Coporate Service </option>';
     $ActorRole .='<option value="5"> Human Resources Mgr </option>';
     $ActorRole .='<option value="6"> MD </option>';
*/

if($ActorRole==0)
{
	$sql_res=mysql_query("UPDATE empleave SET Status='$ActorRole', AuditLog='System Admin Re-routed' WHERE id='$ReqCode'"); $result = mysql_query($sql_res, $dbhandle); 
    
}
elseif($ActorRole==1)
{
	$sql_res=mysql_query("UPDATE empleave SET Status='$ActorRole', AuditLog='System Admin Re-routed' WHERE id='$ReqCode'"); $result = mysql_query($sql_res, $dbhandle); 
}
elseif($ActorRole==2)
{
	$sql_res=mysql_query("UPDATE empleave SET Status='$ActorRole', AuditLog='System Admin Re-routed' WHERE id='$ReqCode'"); $result = mysql_query($sql_res, $dbhandle); 
}
elseif($ActorRole==3)
{
	$sql_res=mysql_query("UPDATE empleave SET Status='$ActorRole', AuditLog='System Admin Re-routed' WHERE id='$ReqCode'"); $result = mysql_query($sql_res, $dbhandle); 
}
elseif($ActorRole==4)
{
	$sql_res=mysql_query("UPDATE empleave SET Status='$ActorRole', AuditLog='System Admin Re-routed' WHERE id='$ReqCode'"); $result = mysql_query($sql_res, $dbhandle); 
}
elseif($ActorRole==5)
{
	$sql_res=mysql_query("UPDATE empleave SET Status='$ActorRole', AuditLog='System Admin Re-routed' WHERE id='$ReqCode'"); $result = mysql_query($sql_res, $dbhandle); 
}
elseif($ActorRole==6)
{
	$sql_res=mysql_query("UPDATE empleave SET Status='$ActorRole', AuditLog='System Admin Re-routed' WHERE id='$ReqCode'"); $result = mysql_query($sql_res, $dbhandle); 
}
elseif($ActorRole==7)
{
	$sql_res=mysql_query("UPDATE empleave SET Status='$ActorRole', AuditLog='System Admin Re-routed' WHERE id='$ReqCode'"); $result = mysql_query($sql_res, $dbhandle); 
}
elseif($ActorRole==8)
{
	$sql_res=mysql_query("UPDATE empleave SET Status='$ActorRole', AuditLog='System Admin Re-routed' WHERE id='$ReqCode'"); $result = mysql_query($sql_res, $dbhandle); 
}
elseif($ActorRole==9)
{
	$sql_res=mysql_query("UPDATE empleave SET Status='$ActorRole', AuditLog='System Admin Re-routed' WHERE id='$ReqCode'"); $result = mysql_query($sql_res, $dbhandle); 
}
elseif($ActorRole==11)
{
	$sql_res=mysql_query("UPDATE empleave SET Status='$ActorRole', AuditLog='System Admin Re-routed' WHERE id='$ReqCode'"); $result = mysql_query($sql_res, $dbhandle); 
}


//echo mysql_error($dbhandle); exit;

 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  
//close the connection
mysql_close($dbhandle);


?>
