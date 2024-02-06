<?php
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['litem'];
$sql_res=mysql_query("UPDATE polineitems SET ProjectControl='1', CreateSO='0' WHERE LitID = '$q'");

$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
//$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
//header('Location: Q?sRFQ='.$LIRFQ);
}
else
{
//$_SESSION['ErrMsgB'] = "Congratulations! Line Item : ".$LIID . " Quoted!";
//header('Location: Q?sRFQ='.$LIRFQ);
}

}
//close the connection
mysql_close($dbhandle);


?>
