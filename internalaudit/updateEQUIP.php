<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $EquipID = trim(strip_tags($_POST['EquipID']));
  $EquipNme = trim(strip_tags($_POST['EquipNme']));
  $EquipCode = trim(strip_tags($_POST['EquipCode']));
  $EquipLoc = trim(strip_tags($_POST['EquipLoc']));
  
  $EquipType = trim(strip_tags($_POST['EquipType']));
  $EquipCat = trim(strip_tags($_POST['EquipCat']));
  
  $EquipMan = trim(strip_tags($_POST['EquipMan']));

  $EquipAmt = trim(strip_tags($_POST['EquipAmt']));
  $EquipQty = trim(strip_tags($_POST['EquipQty']));
  $Deper = trim(strip_tags($_POST['Deper']));
  $EquipYrMake = trim(strip_tags($_POST['EquipYrMake'])); 
  $EquipYrStart = trim(strip_tags($_POST['EquipYrStart'])); 
  $EquipFNo = trim(strip_tags($_POST['EquipFNo']));
  $Comment = trim(strip_tags($_POST['Comment']));
   $OficerInc = trim(strip_tags($_POST['OficerInc']));

  $Today = date('Y/m/d h:i:s a'); 
 
  

	$query1 = "UPDATE equipments SET OficerInc='".$OficerInc."', YearOfUse='".$EquipYrStart."', UnitPrice='".$EquipAmt."', Qty='".$EquipQty."', PerDepre='".$Deper."',  EquipNo='".$EquipFNo."', EquipCat='".$EquipCat."', EquipType='".$EquipType."', EquipNme='".$EquipNme."', EquipCode='".$EquipCode."', EquipLoc='".$EquipLoc."', EquipMan='".$EquipMan."', EquipYrMake='".$EquipYrMake."', EquipFNo='".$EquipFNo."', Comment='".$Comment."' WHERE cid='$EquipID'"; 

if(mysql_query($query1, $dbhandle))
{
  $_SESSION['ErrMsgB'] = "Updated!";
 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
mysql_close($dbhandle);
exit;
}
/*
if(mysql_query($query1, $dbhandle))
{
   //Read CONCount
              $CONcount = mysql_query("SELECT * FROM sysvar WHERE variableName = 'CONTRACTCOUNT'");
              while ($row = mysql_fetch_array($CONcount)) { $CONcount = $row{'variableValue'}; }

              $CONcount = intval($CONcount) + 1;
   $query2 = "UPDATE sysvar SET variableValue='".$CONcount."' WHERE variableName = 'CONTRACTCOUNT'";
   mysql_query($query2, $dbhandle);


  	$_SESSION['ErrMsgB'] = "Created ".$ContractNo;
	header('Location: newcontract');
mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not create : ".$ContractNo;
  header('Location: newcontract');
//close the connection
mysql_close($dbhandle);
}
*/


?>