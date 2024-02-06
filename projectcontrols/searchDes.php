<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['search'];
$sql_res=mysql_query("select * from lineitems where Description like '%$q%' LIMIT 100");
$NoRow = mysql_num_rows($sql_res);
if ($NoRow > 0) 
{
while($row=mysql_fetch_array($sql_res))
{
$MatSer = $row['MatSer'];
$Des = $row['Description'];

$b_MatSer='<strong>'.$q.'</strong>';
$b_Des='<strong>'.$q.'</strong>';
$final_MatSer = str_ireplace($q, $b_MatSer, $MatSer);
$final_Des = str_ireplace($q, $b_Des, $Des);
?>

<div class="show" align="left">


<li><a onclick="mcinfo(this);" ms1="<?php echo $MatSer; ?>" r="<?php echo $Des; ?>" > <?php echo $final_MatSer; ?><br /><span><?php  echo $final_Des; ?></span></a></li>

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
