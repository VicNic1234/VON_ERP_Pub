<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['search'];
$sql_res=mysql_query("select * from rfq where RFQNum like '%$q%' LIMIT 100");
$NoRow = mysql_num_rows($sql_res);
if ($NoRow > 0) 
{
while($row=mysql_fetch_array($sql_res))
{
$RFQNum = $row['RFQNum'];


$b_RFQNum='<strong>'.$q.'</strong>';

$final_RFQNum = str_ireplace($q, $b_RFQNum, $RFQNum);
?>

<div class="show" align="left">


<li><a onclick="litemsch(this);" r="<?php echo $RFQNum; ?>" ><br /><span><?php  echo $final_RFQNum; ?></span></a></li>

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
