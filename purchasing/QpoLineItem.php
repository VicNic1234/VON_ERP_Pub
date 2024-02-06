<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with
$Hfrchk = strip_tags($_POST['freightperchk']);
if ($Hfrchk == "on")
{
	$Hfrchk = "checked";
}
else
{
	$Hfrchk = "unchecked";
}
$Hmkupchk = strip_tags($_POST['markupchk']);
if ($Hmkupchk == "on")
{
	$Hmkupchk  = "checked";
}
else
{
	$Hmkupchk  = "unchecked";
}


	//Take Value from the two guys in index page LOGIN FORM
$ItDes = mysql_real_escape_string(trim(strip_tags($_POST['ItDes'])));
//$ItDes = str_replace("'", "&#8217", $ItDes);
//$ItDes = str_replace('"', '&#8221', $ItDes);
//$ItDes = str_replace('”', '&#8221', $ItDes);
//$ItDes = str_replace('“', '&#8221', $ItDes);
//$SupDetails = mysql_real_escape_string(trim(strip_tags($_POST['SupDetails'])));
$Cur = mysql_real_escape_string(trim(strip_tags($_POST['Cur'])));
$LIDDate = mysql_real_escape_string(trim(strip_tags($_POST['LIDDate'])));
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
$CustomVat = mysql_real_escape_string(trim(strip_tags($_POST['CustomVat'])));

$PreShip = mysql_real_escape_string(trim(strip_tags($_POST['PreShip'])));
$markupCos = mysql_real_escape_string(trim(strip_tags($_POST['markupCos'])));
$markupperc = mysql_real_escape_string(trim(strip_tags($_POST['markupperc'])));
$CusSub = mysql_real_escape_string(trim(strip_tags($_POST['CusSub'])));
$ETLS = mysql_real_escape_string(trim(strip_tags($_POST['ETLS'])));
$LocHand = mysql_real_escape_string(trim(strip_tags($_POST['LocHand'])));
$pLocHand = mysql_real_escape_string(trim(strip_tags($_POST['pLocHand'])));

$LocCos = mysql_real_escape_string(trim(strip_tags($_POST['LocCos'])));


$LIRFQ = mysql_real_escape_string(trim(strip_tags($_POST['LIRFQ'])));
$LIID = mysql_real_escape_string(trim(strip_tags($_POST['LIID'])));
$DEX = mysql_real_escape_string(trim(strip_tags($_POST['DEX'])));
$DEXL = mysql_real_escape_string(trim(strip_tags($_POST['DEXL'])));
$DCUSL = mysql_real_escape_string(trim(strip_tags($_POST['DCUSL'])));

$UOM = mysql_real_escape_string(trim(strip_tags($_POST['UOM'])));
$mart = mysql_real_escape_string(trim(strip_tags($_POST['mart'])));

//exit;

if ( $LIID == "" )
{
$_SESSION['ErrMsg'] = "Oops! Please try again, thanks.";
header('Location: Qchk?sRFQ='.$LIRFQ);
exit;
}


$UnitDDPrice = number_format((floatval($DPPPrice)/ $LIQty), 2, '.','');
$LIRFQ = mysql_real_escape_string(trim(strip_tags($_POST['LIRFQ'])));
$LIID = mysql_real_escape_string(trim(strip_tags($_POST['LIID'])));

$query = "UPDATE purchaselineitems SET Description='".$ItDes."', Status='OPEN', Qty='".$LIQty."', Price='".$UnitCost."',  EXPPrice='".$EXPPrice."', CIFPPrice='".$CIFPPrice."', UnitCost='".$UnitCost."', Currency='".$Cur."', ExtendedCost='".$ExCost."'
, Discount='".$Disc."', DiscountAmt='".$DiscAmt."', UnitWeight='".$UnitWeight."', ExWeight='".$ExWeight."', FOBExWorks='".$FOB."', ExportPackaging='".$PackA."', Currency='".$Cur."'
, PackingPercent='".$PackP."', InsurePercent='".$InsurP."', Insurance='".$InsurA."', FreightPercent='".$FreightP."', Freight='".$FreightA."', ForeignCost='".$CIF."', HsTarrif='".$HSTariff."' 
, HScode='".$HSCODE."', CustomDuty='".$CustomDuty."', CustomVat='".$CustomVat."', SupDetail='".$SupDetails."', PreShipmentInspect='".$PreShip."', MarkUp='".$markupCos."', markupperc='".$markupperc."'
, CustomSubCharge ='".$CusSub."', ETLSCharge='".$ETLS."', LocalHandling='".$LocHand."', LocalCost='".$LocCos."', DPPPrice='".$ExCost."'
, UnitDDPrice='".$UnitDDPrice."', DELIVERY='".$DCUSL."', WorkLocation='".$DEXL."', DeliveryToWrkLocation='".$DEX."', pLocalHandling='".$pLocHand."', MarkUpDirect='".$Hmkupchk."', FreightDirect='".$Hfrchk."', MatSer='".$mart."', UOM='".$UOM."', DueDate='".$LIDDate."'  WHERE LitID='".$LIID."'"; 
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