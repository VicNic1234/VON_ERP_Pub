<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$BUopt = "";
$q=$_POST['deptid'];
$sql_res=mysql_query("select * from businessunit WHERE DeptID = '".$q."' Order By BussinessUnit");
$NoRow = mysql_num_rows($sql_res);
if ($NoRow > 0) 
{
  while ($row = mysql_fetch_array($sql_res)) {
    $id = $row{'id'};
    $bnu = $row['BussinessUnit'];
    $BUopt .= '<option value="'.$id.'">'.$bnu.'</option>';
    }
} else {$BUopt .= '<option value="" > No Bussiness Unit </option>'; }

echo $BUopt;
}
?>
