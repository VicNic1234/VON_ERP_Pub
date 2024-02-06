<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with

//Take Value from the two guys in index page LOGIN FORM
$LitIDm = mysql_real_escape_string(trim(strip_tags($_POST['LitIDm'])));
$sPO = mysql_real_escape_string(trim(strip_tags($_POST['smSO'])));



if ( $LitIDm == "" )
{
$_SESSION['ErrMsg'] = "Oops! Did not update! Try again";
header('Location: EditSO?SOID='.$sPO);

exit;
}



{


$query = "DELETE FROM purchaselineitems WHERE LitID='".$LitIDm."' AND Status='OPEN'"; 


$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error(); exit;
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: EditSO?SOID='.$sPO);

}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! Line Item : ".$LitIDm . " Deleted! (".mysql_affected_rows().")";
header('Location: EditSO?SOID='.$sPO);
}

}
//close the connection
mysql_close($dbhandle);




?>