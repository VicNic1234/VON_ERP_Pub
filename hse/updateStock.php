<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with
$USERID = $_SESSION['uid'];
  
$DateG = date("Y-m-d h:i:s a");


//Take Value from the two guys in index page LOGIN FORM
$SID = mysql_real_escape_string(trim(strip_tags($_POST['SID'])));
$Location = mysql_real_escape_string(trim(strip_tags($_POST['Location'])));
$Storage = mysql_real_escape_string(trim(strip_tags($_POST['Storage'])));
$Bin = mysql_real_escape_string(trim(strip_tags($_POST['Bin'])));
$itCat = mysql_real_escape_string(trim(strip_tags($_POST['itCat'])));
$itCode = mysql_real_escape_string(trim(strip_tags($_POST['itCode'])));
$itDes = mysql_real_escape_string(trim(strip_tags($_POST['itDes'])));
$Bal = mysql_real_escape_string(trim(strip_tags($_POST['Bal'])));
//$itDes = str_replace("'", "&#8217", $itDes);
//$itDes = str_replace('"', '&#8221', $itDes);
$Condition = mysql_real_escape_string(trim(strip_tags($_POST['Condition'])));
$Purpose = mysql_real_escape_string(trim(strip_tags($_POST['Purpose'])));


if ( $itDes == "" )
{
$_SESSION['ErrMsg'] = "Did not update because description field is emtpy!";
header('Location: stocks');
exit;
}



{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "UPDATE wh_stock SET stockcode='".$itCode."', station='".$Location."', 
storage='".$Storage."', Description='".$itDes."', Bin='".$Bin."', Bal='".$Bal."', itemcat='".$itCat."', Condi='".$Condition."' WHERE sid='".$SID."'"; 


$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error(); exit;
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: stocks');
}
else
{
 //Now we have to inser the item into the table
	//Set New State
	////////////////////////////////
	$newState = "stockcode: ".$itCode." <br/> location: ".$Location." <br/> 
    storage: ".$Storage." <br/> Description: ".$itDes." <br/> Bin: ".$Bin." <br/> Bal: ".$Bal." <br/> itemcat: ".$itCat." <br/> Condi: ".$Condition;
	///////////////////////////////////////
	$queryHIS = "INSERT INTO stockhistory (sid, actiondate, action, actor, newstate,
	station, storage, Bin, stockcode, itemcat, Description, Bal, Condi, purpose) 
    VALUES ('$SID', '$DateG ', 'Update', '$USERID', '$newState',
	'$Location', '$Storage ', '$Bin', '$itCode', '$itCat', '$itDes', '$Bal', '$Condition', '$Purpose');";

//mysql_query($queryHIS);
if (!mysql_query($queryHIS))
{
echo mysql_error(); exit;
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: stocks');
}

$_SESSION['ErrMsgB'] = "Congratulations! Stock : ".$itCode . " Updated!";
header('Location: stocks');
}

}
//close the connection
mysql_close($dbhandle);




?>