<?php
include ('../DBcon/db_config.php');
//echo "fwfefw";
//litem
if($_POST)
{

$myUID = $_POST['userid'];


$sqldatan = mysql_query("SELECT * FROM users WHERE uid=$myUID");
while( $row = mysql_fetch_assoc($sqldatan)){
   $PayrollElem = $row['PayrollElem'];
    
}


$sqldata = mysql_query("SELECT * FROM payrollelement WHERE isActive=1");
while( $row = mysql_fetch_assoc($sqldata)){
   $new_array[$row['payid']]['payid'] = $row['payid'];
    $new_array[$row['payid']]['payname'] = $row['payname'];
    $new_array[$row['payid']]['caltype'] = $row['caltype'];
    $new_array[$row['payid']]['payval'] = $row['payval'];
    $new_array[$row['payid']]['valtype'] = $row['valtype'];
}

/*
$arrRoles = array("externalsales", "internalsales", "integratedservices", "projectcontrols", "logistics", "purchasing", 
	"warehousing", "admin", "accounts", "humanresources", "BI" );
*/

$arrRoles = array("Account", "Account (Read Only)", "Asset Management", "Bus Dev", 
	"Contracts/Procurement",
	"Warehouse","Raise Contract","Treat Procurement","Process PO",
	"Corporate/Communication", 
	"Document Control", "Due Diligence", "HSE", 
	"HR/Administration", "ICT", "Deck Mach", "Jetty Services", 
	"Internal Audit", "Legal", "Maintenance", "Warehouse", 
	"Marine/Logistics", "Projects", "QA/QC", 
	"Security", "Strategy/Innovation", "ERP Admin", "BI" );

$option = '<table class="table table-striped table-bordered">';
$option .= '<tr><th>Element</th><th>Cal Type</th><th>Val Type</th><th>--</th><th>Include</th></tr>';
foreach ($new_array as $value) {
    //$value = $value * 2;
    //if (strpos($Role, $value) !== false) { $option .= '<label><input type="checkbox" name="role_cap[]" value="'.$value.'" checked /> '.$value['payname'].'</label> &nbsp; &nbsp;' ; }
    //else { $option .= '&nbsp; <label><input type="checkbox" name="role_cap[]" value="'.$value.'"> '.$value['payname'].'</label> &nbsp; &nbsp;' ; }
    if(strpos($PayrollElem, $value['payid'].",") !== false){
    $option .='<tr><td>'.$value['payname'].'</td><td>'.$value['caltype'].'</td><td>'.$value['valtype'].'</td><td>'.$value['payval'].'</td><td><input type="checkbox" name="role_cap[]" value="'.$value['payid'].'" checked /></td></tr>';
    }
    else
    {
      $option .='<tr><td>'.$value['payname'].'</td><td>'.$value['caltype'].'</td><td>'.$value['valtype'].'</td><td>'.$value['payval'].'</td><td><input type="checkbox" name="role_cap[]" value="'.$value['payid'].'" /></td></tr>';  
    }

}
$option .= '</table>';
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
