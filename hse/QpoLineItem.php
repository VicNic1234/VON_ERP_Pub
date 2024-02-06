<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with
	//Take Value from the two guys in index page LOGIN FORM
$ItDes = mysql_real_escape_string(trim(strip_tags($_POST['ItDes'])));
//$SupDetails = mysql_real_escape_string(trim(strip_tags($_POST['SupDetails'])));
$Cur = mysql_real_escape_string(trim(strip_tags($_POST['Cur'])));
$LIQty = mysql_real_escape_string(trim(strip_tags($_POST['LIQty'])));
$LIUOM = mysql_real_escape_string(trim(strip_tags($_POST['UOM'])));
$UnitWeight = mysql_real_escape_string(trim(strip_tags($_POST['UnitWeight'])));
$ExWeight = mysql_real_escape_string(trim(strip_tags($_POST['ExWeight'])));
$UnitCost = mysql_real_escape_string(trim(strip_tags($_POST['LIUC'])));
$ExCost = mysql_real_escape_string(trim(strip_tags($_POST['ExCost'])));
$Disc = mysql_real_escape_string(trim(strip_tags($_POST['Disc'])));
$DiscAmt = mysql_real_escape_string(trim(strip_tags($_POST['DiscC'])));
$FOB = mysql_real_escape_string(trim(strip_tags($_POST['FOB'])));
$PackP = mysql_real_escape_string(trim(strip_tags($_POST['PackP'])));
$PackA = mysql_real_escape_string(trim(strip_tags($_POST['PackA'])));
$InsurP = mysql_real_escape_string(trim(strip_tags($_POST['InsurP'])));
$InsurA = mysql_real_escape_string(trim(strip_tags($_POST['InsurA'])));
$FreightP = mysql_real_escape_string(trim(strip_tags($_POST['FreightP'])));
$FreightA = mysql_real_escape_string(trim(strip_tags($_POST['FreightA'])));
$CIF = mysql_real_escape_string(trim(strip_tags($_POST['CIF'])));
$HSCODE = mysql_real_escape_string(trim(strip_tags($_POST['HSCODE'])));
$HSTariff = mysql_real_escape_string(trim(strip_tags($_POST['HSTariff'])));
$CustomDuty = mysql_real_escape_string(trim(strip_tags($_POST['CustomDuty'])));

$PreShip = mysql_real_escape_string(trim(strip_tags($_POST['PreShip'])));
$markupCos = mysql_real_escape_string(trim(strip_tags($_POST['markupCos'])));
$markupperc = mysql_real_escape_string(trim(strip_tags($_POST['markupperc'])));
$CusSub = mysql_real_escape_string(trim(strip_tags($_POST['CusSub'])));
$ETLS = mysql_real_escape_string(trim(strip_tags($_POST['ETLS'])));
$LocHand = mysql_real_escape_string(trim(strip_tags($_POST['LocHand'])));
$LocCos = mysql_real_escape_string(trim(strip_tags($_POST['LocCos'])));
$DPPPrice = mysql_real_escape_string(trim(strip_tags($_POST['DPPPrice'])));

$LIRFQ = mysql_real_escape_string(trim(strip_tags($_POST['LIRFQ'])));
$LIID = mysql_real_escape_string(trim(strip_tags($_POST['LIID'])));
$DEX = mysql_real_escape_string(trim(strip_tags($_POST['DEX'])));
$DEXL = mysql_real_escape_string(trim(strip_tags($_POST['DEXL'])));
$DCUSL = mysql_real_escape_string(trim(strip_tags($_POST['DCUSL'])));

if ( $LIID == "" )
{
$_SESSION['ErrMsg'] = "Oops! Please try again, thanks.";
header('Location: Qchk?sRFQ='.$LIRFQ);
exit;
}


$UnitDDPrice = number_format((floatval($DPPPrice)/ $LIQty), 2, '.','');
$LIRFQ = mysql_real_escape_string(trim(strip_tags($_POST['LIRFQ'])));
$LIID = mysql_real_escape_string(trim(strip_tags($_POST['LIID'])));

$query = "UPDATE polineitems SET Description='".$ItDes."', Status='QUOTED', Qty='".$LIQty."', Price='".$UnitCost."', UnitCost='".$UnitCost."', Currency='".$Cur."', ExtendedCost='".$ExCost."'
, Discount='".$Disc."', DiscountAmt='".$DiscAmt."', UnitWeight='".$UnitWeight."', ExWeight='".$ExWeight."', FOBExWorks='".$FOB."', ExportPackaging='".$PackA."', Currency='".$Cur."'
, PackingPercent='".$PackP."', InsurePercent='".$InsurP."', Insurance='".$InsurA."', FreightPercent='".$FreightP."', Freight='".$FreightA."', ForeignCost='".$CIF."', HsTarrif='".$HSTariff."' 
, HScode='".$HSCODE."', CustomDuty='".$CustomDuty."', SupDetail='".$SupDetails."', PreShipmentInspect='".$PreShip."', MarkUp='".$markupCos."', markupperc='".$markupperc."'
, CustomSubCharge ='".$CusSub."', ETLSCharge='".$ETLS."', LocalHandling='".$LocHand."', LocalCost='".$LocCos."', ExDDPrice='".$DPPPrice."'
, UnitDDPrice='".$UnitDDPrice."', DELIVERY='".$DCUSL."', WorkLocation='".$DEXL."', DeliveryToWrkLocation='".$DEX."' WHERE LitID='".$LIID."' AND ProjectControl='1'"; 
////////////////////////
/////////////

$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: Qchk?sRFQ='.$LIRFQ);
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! Line Item : ".$LIID . " Sales Order Prepared!";
header('Location: Qchk?sRFQ='.$LIRFQ);
}


//close the connection
mysql_close($dbhandle);




?>