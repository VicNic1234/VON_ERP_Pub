<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$acctclass= mysql_real_escape_string(trim(strip_tags($_POST['acctclass'])));
$OptType = "";
  //Let's Read ChartType
$ChartTypeQ = mysql_query("SELECT * FROM acc_chart_types Where class_id = '$acctclass'  AND isActive=1 ORDER BY name");
$NoRowType = mysql_num_rows($ChartTypeQ);
if ($NoRowType > 0) {
  while ($row = mysql_fetch_array($ChartTypeQ)) {
    $tid = $row{'id'};
    $tname = $row['name'];
    $OptType .= '<option value="'.$tid.'">'.$tname.'</option>';
   }

  }

echo $OptType;
//$result = mysql_query($sql_res, $dbhandle);

mysql_close($dbhandle);
exit;


?>
