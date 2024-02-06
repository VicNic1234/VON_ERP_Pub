<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with

//Take Value from the two guys in index page LOGIN FORM
$LitIDm = mysql_real_escape_string(trim(strip_tags($_POST['LitIDm'])));
$sPO = mysql_real_escape_string(trim(strip_tags($_POST['smSO'])));
$EditDes = mysql_real_escape_string(trim(strip_tags($_POST['EditDes'])));
$EditRemark = mysql_real_escape_string(trim(strip_tags($_POST['EditRemark'])));
$EditDueDate = mysql_real_escape_string(trim(strip_tags($_POST['EditDueDate'])));
$EditAmt = mysql_real_escape_string(trim(strip_tags($_POST['EditAmt'])));
$EditDisc = mysql_real_escape_string(trim(strip_tags($_POST['EditDisc'])));
$EditURate = mysql_real_escape_string(trim(strip_tags($_POST['EditUnitRate'])));
$EditPer = mysql_real_escape_string(trim(strip_tags($_POST['EditPer'])));
$EditQty = mysql_real_escape_string(trim(strip_tags($_POST['EditQty'])));
$EditCurr = mysql_real_escape_string(trim(strip_tags($_POST['EditCurr'])));
//let's Compute the Discount and Price now
//$Price = $Price - (($Price * $Discount)/100);
//Remain % for UnitRate
$DisR = 100 - $EditDes;
$OrgURate = ($EditURate * 100)/$DisR;

$ExPrice = $OrgURate * intval($EditQty);

$DisAmt = ($ExPrice * $EditDisc)/100;
//We need to convoert Date here
$GetSlash = substr($EditDueDate,4,1); 
//exit;
if ($GetSlash != "-"){

$myDateTime = DateTime::createFromFormat('m/d/Y', $EditDueDate);
$EditDueDate = $myDateTime->format('Y-m-d');
}

if ( $LitIDm == "" )
{
$_SESSION['ErrMsg'] = "Oops! Did not update! Try again";
header('Location: EPCMileStone');
exit;
}



{


$query = "UPDATE purchaselineitems SET Description='".$EditDes."',  Remark='".$EditRemark."', Discount='".$EditDisc."', DiscountAmt='".$DisAmt."', DueDate='".$EditDueDate."', ExtendedCost='".$ExPrice."', Qty='".$EditQty."', UOM='".$EditPer."', UnitCost='".$EditURate."', Currency='".$EditCurr."' WHERE LitID='".$LitIDm."'"; 


$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error(); exit;
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: EPCMileStone?sSO='.$sPO);
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! Line Item : ".$LitIDm . " Updated!";
header('Location: EPCMileStone?sSO='.$sPO);
}

}
//close the connection
mysql_close($dbhandle);




?>