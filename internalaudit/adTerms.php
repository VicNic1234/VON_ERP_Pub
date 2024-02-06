<?php
session_start();
include ('../DBcon/db_config.php');

if ($_POST['nk'] != "")
{

$Terms = trim($_POST['nk']);
$TermTitle = trim($_POST['TermTitle']);

//Let's just Update
$query = "INSERT iNTO terms (Terms, Title) VALUES ('$Terms', '$TermTitle')"; 

$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: printQ');
exit;
}
else
{
$_SESSION['ErrMsgB'] = "New Terms Added!";
header('Location: printQ');
exit;
}


}  
  
exit;
//close the connection
mysql_close($dbhandle);

?>