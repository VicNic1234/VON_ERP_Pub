<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['search'];
$sql_res=mysql_query("select * from so where SONum like '%$q%' LIMIT 100");
$NoRow = mysql_num_rows($sql_res);
if ($NoRow > 0) 
{
while($row=mysql_fetch_array($sql_res))
{
$SONum = $row['SONum'];


$b_SONum='<strong>'.$q.'</strong>';

$final_SONum = str_ireplace($q, $b_SONum, $SONum);
?>

<div class="show" align="left">


<li><a onclick="litemsch(this);" r="<?php echo $SONum; ?>" ><br /><span><?php  echo $final_SONum; ?></span></a></li>

</div>
<?php
}
}
else
{
?>
<div> </div>
<?php
}

}
?>
