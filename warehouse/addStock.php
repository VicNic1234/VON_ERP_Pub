<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:s a");
$uid = $_SESSION['uid'];

$Station = mysql_real_escape_string(trim(strip_tags($_POST['Station'])));
$Storage = mysql_real_escape_string(trim(strip_tags($_POST['Storage'])));
$Bin = mysql_real_escape_string(trim(strip_tags($_POST['Bin'])));
$itCat = mysql_real_escape_string(trim(strip_tags($_POST['itCat'])));
$itCode = mysql_real_escape_string(trim(strip_tags($_POST['itCode'])));
$itDes = mysql_real_escape_string(trim(strip_tags($_POST['itDes'])));
$Condition = mysql_real_escape_string(trim(strip_tags($_POST['Condition'])));
$Bal = mysql_real_escape_string(trim(strip_tags($_POST['Bal'])));
$Cost = mysql_real_escape_string(trim(strip_tags($_POST['Cost'])));
$Purpose = mysql_real_escape_string(trim(strip_tags($_POST['Purpose'])));

if($Station == "" || $Storage == "" || $Bin == "" || $itCat == "" || $itCode == "" || $itDes == "" || $Cost == "")
 { 
   $_SESSION['ErrMsg'] = "Kindly Complete details of new Item";
header('Location: stocks');
exit;
 } 
 else 
 {

 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM wh_stock WHERE stockcode='$itCode'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	$_SESSION['ErrMsg'] = "Stock Code already exist";
		header('Location: stocks');
		exit;
	 } 



 	$query = "INSERT INTO wh_stock (station, storage, Bin, stockcode, itemcat, Description, Bal, Condi, datereg, regby, TotalAmt) 
    VALUES ('$Station', '$Storage', '$Bin', '$itCode', '$itCat', '$itDes', '$Bal', '$Condition', '$DateG', '$uid', '$Cost');";



mysql_query($query);
//echo mysql_error();
  //exit;
	$SID = mysqli_insert_id();
	$newState = "stockcode: ".$itCode." <br/> location: ".$Station." <br/> 
    storage: ".$Storage." <br/> Description: ".$itDes." <br/> Bin: ".$Bin." <br/> Bal: ".$Bal." <br/> itemcat: ".$itCat." <br/> Condi: ".$Condition ." <br/> Amt: ".$Cost;
	///////////////////////////////////////
	$queryHIS = "INSERT INTO stockhistory (sid, actiondate, action, actor, newstate,
	station, storage, Bin, stockcode, itemcat, Description, Bal, Condi, purpose, RecDate, Amt) 
    VALUES ('$SID', '$DateG ', 'Create', '$uid', '$newState',
	'$Location', '$Storage ', '$Bin', '$itCode', '$itCat', '$itDes', '$Bal', '$Condition', '$Purpose', '$DateG', '$Cost');";

//mysql_query($queryHIS);
if (!mysql_query($queryHIS))
{
echo mysql_error(); exit;
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
//header('Location: stocks');
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"] . "?pdfid=".$ReqCode);
    }
}

$_SESSION['ErrMsgB'] = "Congratulations! New Stock is added";
//header('Location: stocks');
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"] . "?pdfid=".$ReqCode);
    }

 }

exit;
if ($accttype == "Class")
{ 
	$sql_res=mysql_query("UPDATE acc_chart_class SET isActive='$actstate' WHERE cid = '$acctid'");
}

if ($accttype == "Master")
{ 
	$sql_res=mysql_query("UPDATE acc_chart_master SET isActive='$actstate' WHERE account_code = '$acctid'");
}

if ($accttype == "Type")
{ 
	$sql_res=mysql_query("UPDATE acc_chart_types SET isActive='$actstate' WHERE id = '$acctid'");
}


$result = mysql_query($sql_res, $dbhandle);

mysql_close($dbhandle);
exit;


?>
