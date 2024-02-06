<?php
include ('../DBcon/db_config.php');
//echo "fwfefw";
//litem
if($_POST)
{

$q=$_POST['litem'];
$sqldata = mysql_query("SELECT * FROM logistics WHERE logID=$q");

$rows = array();
while($r = mysql_fetch_assoc($sqldata)) {
  $rows[] = $r;
}

echo json_encode($rows);
exit;

}

?>
