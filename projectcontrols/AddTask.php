<?php
session_start();
include ('../DBcon/db_config.php');
include ('../utility/notify.php');

$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];
//select a database to work with

//Take Value from the two guys in index page LOGIN FORM
$sPO = mysql_real_escape_string(trim(strip_tags($_POST['smSO'])));
$TaskName = mysql_real_escape_string(trim(strip_tags($_POST['TaskNme'])));
$TaskResource = mysql_real_escape_string(trim(strip_tags($_POST['TaskResource'])));
$StartDate = mysql_real_escape_string(trim(strip_tags($_POST['StartDate']))); 
$EndDate = mysql_real_escape_string(trim(strip_tags($_POST['EndDate'])));
$Percentage = mysql_real_escape_string(trim(strip_tags($_POST['Percentage'])));
$pDepend = mysql_real_escape_string(trim(strip_tags($_POST['pDepend'])));
$pType = mysql_real_escape_string(trim(strip_tags($_POST['pType'])));
$TaskAmt = mysql_real_escape_string(trim(strip_tags($_POST['TaskAmt'])));
$TaskCurr = mysql_real_escape_string(trim(strip_tags($_POST['TaskCurr'])));
$pParent = mysql_real_escape_string(trim(strip_tags($_POST['pParent']))); 
$pDType = mysql_real_escape_string(trim(strip_tags($_POST['pDType'])));

if($pDepend > 0) { $pDepend .= $pDType;}

if($pType == 1){ $pType = "gtaskgreen"; $pMile = 0; $pGroup = 1;}
if($pType == 2){ $pType = "gtaskgreen"; $pMile = 0; $pGroup = 0;}
if($pType == 3){ $pType = "gtaskblue"; $pMile = 0; $pGroup = 0;}
if($pType == 4){ $pType = "gtaskred"; $pMile = 0; $pGroup = 0;}
if($pType == 5){ $pType = "gtaskpurple"; $pMile = 0; $pGroup = 0;}
if($pType == 6){ $pType = "gtaskpink"; $pMile = 0; $pGroup = 0;}
if($pType == 7){ $pType = "gtaskyellow"; $pMile = 0; $pGroup = 0;}
if($pType == 8){ $pType = "gmilestone"; $pMile = 1; $pGroup = 0;}
if($pType == 9){ $pType = "gtaskgreen"; $pMile = 1; $pGroup = 0;}
if($pType == 10){ $pType = "ggroupblack"; $pMile = 0; $pGroup = 1;}

/*

					'<option value="10" style="background:#000000; color:#FFF">Group</option>'+
                    '<option value="1" style="background:#000000; color:#FFF">Main Task</option>'+
                    '<option value="2" style="background:green; color:#FFF">Sub Task [green]</option>'+
                    '<option value="3" style="background:#4BACDA; color:#FFF">Sub Task [blue]</option>'+
                    '<option value="4" style="background:red; color:#FFF">Sub Task [red]</option>'+
                    '<option value="5" style="background:purple; color:#FFF">Sub Task [purple]</option>'+
                    '<option value="6" style="background:pink; color:#000">Sub Task [pink]</option>'+
                    '<option value="7" style="background:yellow; color:#000">Sub Task [yellow]</option>'+
                    '<option value="8" style="background:#000; color:#FFF">Ordinary MileStone</option>'+
                    '<option value="9" style="background:green; color:#FFF">Payment MileStone</option>'+


*/
//We need to convoert Date here
$GetSlash = substr($StartDate,4,1); 
//exit;
if ($GetSlash != "-" && ($StartDate != "")){

$mySDateTime = DateTime::createFromFormat('m/d/Y', $StartDate);
$StartDate = $mySDateTime->format('Y-m-d');

$myEDateTime = DateTime::createFromFormat('m/d/Y', $EndDate);
$EndDate = $myEDateTime->format('Y-m-d');

}

//Let Set Parent




if ( $sPO == "" )
{
$_SESSION['ErrMsg'] = "Oops! Did not update! Try again";
header('Location: EPCMileStone');
exit;
}



{

$query = "INSERT INTO projecttask (SOCode, pName, pStart, pEnd, pStyle, pLink, pMile, pRes, pComp, pGroup, pParent, pOpen, pDepend, pCaption, pNotes, CreatedBy, CreatedOn) 
VALUES ('$sPO','$TaskName','$StartDate','$EndDate','$pType','','$pMile','$TaskResource', '$Percentage', '$pGroup', '$pParent', '1', '$pDepend', '', '', '$Userid', '$DateG' );";

$result = mysql_query($query);
//$query = "UPDATE purchaselineitems SET Description='".$EditDes."',  Remark='".$EditRemark."', Discount='".$EditDisc."', DiscountAmt='".$DisAmt."', DueDate='".$EditDueDate."', ExtendedCost='".$ExPrice."', Qty='".$EditQty."', UOM='".$EditPer."', UnitCost='".$EditURate."', Currency='".$EditCurr."' WHERE LitID='".$LitIDm."'"; 


//$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error(); exit;
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: EPCMileStone?sSO='.$sPO);
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! Task Item Added!";
header('Location: EPCMileStone?sSO='.$sPO);

}

}
//Here we have to notify the resource persons
notify_resource_person_after_add_task($sPO,$TaskName,$TaskResource,$Userid,$StartDate,$EndDate);

//close the connection
mysql_close($dbhandle);




?>