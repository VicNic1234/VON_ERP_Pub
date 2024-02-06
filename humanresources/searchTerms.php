<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['search'];
$sql_res=mysql_query("select * from terms where termsID ='$q'");
$NoRow = mysql_num_rows($sql_res);
if ($NoRow > 0) 
{
while($row=mysql_fetch_array($sql_res))
{
$MatSer = $row['Terms'];


}
echo $MatSer;
}
else
{
?>
<div> </div>
<?php
}

}
?>
