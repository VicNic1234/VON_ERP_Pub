<?php
session_start();
include ('../DBcon/db_config.php');
//$DateG = date("Y/m/d h:i:sa");


$locationID= mysql_real_escape_string(trim(strip_tags($_POST['locationID'])));
$OptStorages = '<option value=""> -- </option>';
  //Let's Read ChartType
$StorageQ = mysql_query("SELECT * FROM wh_storages WHERE class_id = '$locationID'  AND isActive=1 ORDER BY id");
$NoRowSQ = mysql_num_rows($StorageQ);
if ($NoRowSQ > 0) {
  while ($row = mysql_fetch_array($StorageQ)) {
    $tid = $row['id'];
    $tname = $row['name'];
    $OptStorages .= '<option value="'.$tid.'">'.$tname.'</option>';
   }

  }

echo $OptStorages;
//$result = mysql_query($sql_res, $dbhandle);

mysql_close($dbhandle);
exit;


?>
