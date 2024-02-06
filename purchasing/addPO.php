<?php
session_start();
include ('../DBcon/db_config.php');

if (trim(strip_tags($_POST['smPO'])) != "")
{
 
$smPO = trim(strip_tags($_POST['smPO']));
$EditDes = trim(strip_tags($_POST['EditDes']));
$AddDueDate = trim(strip_tags($_POST['AddDueDate']));
$EditQty = trim(strip_tags($_POST['EditQty']));
$EditUnitRate = trim(strip_tags($_POST['EditUnitRate'])); 
$EditDisc = trim(strip_tags($_POST['EditDisc'])); 
$EditAmt = trim(strip_tags($_POST['EditAmt'])); 
$EditPer = trim(strip_tags($_POST['EditPer'])); 


//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO logistics (POID, Description, Qty, UOM, POAmt, DueDate, PODiscount, UnitRate) 
						VALUES ('$smPO', '$EditDes', '$EditQty', '$EditPer','$EditAmt','$AddDueDate','$EditDisc','$EditUnitRate');";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Line is Registered to ". $smPO;
header('Location: sndPO?sPO='. $smPO);


}
//close the connection
mysql_close($dbhandle);




?>