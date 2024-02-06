<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$BNKID = mysql_real_escape_string(trim(strip_tags($_POST['BNKID'])));
$OptType = '<option value=""> Select Reciept No. </option>';
  //Let's Read ChartType
$ChartTypeQ = mysql_query("SELECT * FROM reciepts Where Bank = '$BNKID'  AND isActive=1 ORDER BY cheuqeNME");
$NoRowType = mysql_num_rows($ChartTypeQ);
if ($NoRowType > 0) {
  while ($row = mysql_fetch_array($ChartTypeQ)) {
    $tid = $row['chid'];
    $tname = $row['cheuqeNME'];
    $OptType .= '<option value="'.$tid.'">'.$tname.'</option>';
   }

  }

echo $OptType;
//$result = mysql_query($sql_res, $dbhandle);

mysql_close($dbhandle);
exit;


?>
