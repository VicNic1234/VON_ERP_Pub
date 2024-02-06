<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$UID = $_SESSION['uid'];

$StartID = 10878;

$sqlPOREQ=mysql_query("SELECT * FROM SETPOSTGPIG ORDER BY tncid");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
       $StartID = $StartID + 1;
       $OldTNCID = $rowPOREQ['tncid'];
       //here we need to update
        mysql_query("UPDATE SETPOSTGPIG SET tncid='$StartID' WHERE tncid = '$OldTNCID'");
        mysql_query("UPDATE SETPOSTGPIG SET CounterTrans='$StartID' WHERE CounterTrans = '$OldTNCID'");
  
       

     }
echo mysql_error($query, $dbhandle);

echo $StartID; 
mysql_close($dbhandle);


?>
