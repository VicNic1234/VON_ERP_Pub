<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with

//Take Value from the two guys in index page LOGIN FORM
$LitIDm = mysql_real_escape_string(trim(strip_tags($_POST['LitIDm'])));
$sPO = mysql_real_escape_string(trim(strip_tags($_POST['smPO'])));
$EditDes = mysql_real_escape_string(trim(strip_tags($_POST['EditDes'])));
$EditDueDate = mysql_real_escape_string(trim(strip_tags($_POST['EditDueDate'])));
$EditAmt = mysql_real_escape_string(trim(strip_tags($_POST['EditAmt'])));
$EditDisc = mysql_real_escape_string(trim(strip_tags($_POST['EditDisc'])));
$EditURate = mysql_real_escape_string(trim(strip_tags($_POST['EditUnitRate'])));
$EditPer = mysql_real_escape_string(trim(strip_tags($_POST['EditPer'])));
$EditQty = mysql_real_escape_string(trim(strip_tags($_POST['EditQty'])));
$EditQty = mysql_real_escape_string(trim(strip_tags($_POST['EditQty'])));

//We need to convoert Date here
//$date=date_create($EditDueDate,"d/m/Y");
//echo date_format($date,"Y-m-d");
$GetSlash = substr($EditDueDate,4,1); 
//exit;
if ($GetSlash != "-"){

$myDateTime = DateTime::createFromFormat('m/d/Y', $EditDueDate);
$EditDueDate = $myDateTime->format('Y-m-d');
}

if ( $LitIDm == "" )
{
$_SESSION['ErrMsg'] = "Oops! Did not update! Try again";
header('Location: sndPO');
exit;
}



{


$query = "UPDATE logistics SET Description='".$EditDes."', PODiscount='".$EditDisc."', DueDate='".$EditDueDate."', POAmt='".$EditAmt."', Qty='".$EditQty."', UOM='".$EditPer."', UnitRate='".$EditURate."' WHERE logID='".$LitIDm."'"; 


$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: sndPO?sPO='.$sPO);
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! Line Item : ".$LitIDm . " Updated!";
header('Location: sndPO?sPO='.$sPO);
}

}
//close the connection
mysql_close($dbhandle);




?>