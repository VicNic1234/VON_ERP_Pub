<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$addType= mysql_real_escape_string(trim(strip_tags($_POST['addType'])));
$OptType = "";
  //Let's Read ChartType
$ChartTypeQ = mysql_query("SELECT * FROM wh_bins Where account_type = '$addType'  AND isActive=1 ORDER BY mid");
$NoRowType = mysql_num_rows($ChartTypeQ);
if ($NoRowType > 0) {
  while ($row = mysql_fetch_array($ChartTypeQ)) {
    $tid = $row{'mid'};
    $tname = $row['account_code'] . " [". $row['account_name'] . "]";
    $OptType .= '<option value="'.$tid.'">'.$tname.'</option>';
   }

  }

echo $OptType;
//$result = mysql_query($sql_res, $dbhandle);

mysql_close($dbhandle);
exit;


?>
