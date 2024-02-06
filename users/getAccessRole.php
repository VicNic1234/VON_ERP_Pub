<?php
include ('../DBcon/db_config.php');
//echo "fwfefw";
//litem
if($_POST)
{

$q=$_POST['userid'];
$sqldata = mysql_query("SELECT * FROM users WHERE uid=$q");
$option = "";
//$rows = array();
while($r = mysql_fetch_assoc($sqldata)) {
  $Role = $r['AccessModule'];
}

/*
$arrRoles = array("externalsales", "internalsales", "integratedservices", "projectcontrols", "logistics", "purchasing", 
	"warehousing", "admin", "accounts", "humanresources", "BI" );
*/

$arrRoles = array("Account", "Account (Read Only)", "Asset Management", "Bus Dev", 
	"Contracts/Procurement",
	"Warehouse","Raise Contract","Treat Procurement","Process PO", "View All Cash Request", "View All Material Request",
	"Corporate/Communication", 
	"Document Control", "Due Diligence", "HSE", 
	"HR/Administration", "ICT", "Deck Mach", "Jetty Services", 
	"Internal Audit", "Legal", "Maintenance", "Warehouse", 
	"Marine/Logistics", "Projects", "QA/QC", 
	"Security", "Strategy/Innovation", "ERP Admin", "BI" );


foreach ($arrRoles as &$value) {
    //$value = $value * 2;
    if (strpos($Role, $value) !== false) { $option .= '<label><input type="checkbox" name="role_cap[]" value="'.$value.'" checked /> '.$value.'</label> &nbsp; &nbsp;' ; }
    else { $option .= '&nbsp; <label><input type="checkbox" name="role_cap[]" value="'.$value.'"> '.$value.'</label> &nbsp; &nbsp;' ; }

}

echo $option;
/*$Role  = str_replace(" ","",$Role);

$ArrayRole = explode(',',$Role);*/

//$NRoles = count($ArrayRole);
//echo $NRoles = count($arrRoles);



//echo $Role = '<label><input type="checkbox"> Test</label> &nbsp; <label><input type="checkbox"> Test</label>';
//echo json_encode($rows);
exit;

}



?>
