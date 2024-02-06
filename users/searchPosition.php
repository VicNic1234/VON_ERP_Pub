<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$BUopt = "";
$q=$_POST['jtsid'];
$sql_res=mysql_query("select * from jobposition WHERE JobTitleID = '".$q."' Order By JobPosition");
$NoRow = mysql_num_rows($sql_res);
if ($NoRow > 0) 
{
  while ($row = mysql_fetch_array($sql_res)) {
    $id = $row{'id'};
    $bnu = $row['JobPosition'];
    $BUopt .= '<option value="'.$id.'">'.$bnu.'</option>';
    }
} else {$BUopt .= '<option value="" > No Job Position </option>'; }

echo $BUopt;
}
?>
