<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$BUopt = "";
$q=$_POST['busid'];
$sql_res=mysql_query("select * from department WHERE BusinessUnitID = '".$q."' Order By DeptmentName");
$NoRow = mysql_num_rows($sql_res);
if ($NoRow > 0) 
{
  while ($row = mysql_fetch_array($sql_res)) {
    $id = $row{'DeptCode'};
    $bnu = $row['DeptmentName'];
    $BUopt .= '<option value="'.$id.'">'.$bnu.'</option>';
    }
} else {$BUopt .= '<option value="" > No Department </option>'; }

echo $BUopt;
}
?>
